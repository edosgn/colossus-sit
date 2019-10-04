<?php

namespace JHWEB\UsuarioBundle\Controller;

use JHWEB\UsuarioBundle\Entity\UserLcProhibicion;
use JHWEB\UsuarioBundle\Entity\UserRestriccion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Userlcprohibicion controller.
 *
 * @Route("userlcprohibicion")
 */
class UserLcProhibicionController extends Controller
{
    /**
     * Lists all userLcProhibicion entities.
     * 
     * @Route("/", name="userlcprohibicion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $userLcProhibicions = $em->getRepository('JHWEBUsuarioBundle:UserLcProhibicion')->findAll();

        return $this->render('userlcprohibicion/index.html.twig', array(
            'userLcProhibicions' => $userLcProhibicions,
        ));
    }

    /**
     * Creates a new userLcProhibicion entity.
     *
     * @Route("/new", name="userlcprohibicion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization",null);
        $authCheck = $helpers->authCheck($hash);
        
        if($authCheck == true){
            $json = $request->get("data",null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();

            $usuario = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->find($params->idCiudadano);
            
            $fechaResolucion = (isset($params->fechaResolucion)) ? $params->fechaResolucion : null;
            $fechaOrden = (isset($params->fechaOrden)) ? $params->fechaOrden : null;
            $fechaPlazo = (isset($params->fechaPlazo)) ? $params->fechaPlazo : null;
            $fechaInicio = (isset($params->fechaInicio)) ? $params->fechaInicio : null;
            $fechaFin = (isset($params->fechaFin)) ? $params->fechaFin : null;

            $userLcProhibicion = new Userlcprohibicion();

            if($params->idJuzgado){
                $entidadJudicial = $em->getRepository('JHWEBConfigBundle:CfgEntidadJudicial')->find($params->idJuzgado);
                $userLcProhibicion->setJuzgado($entidadJudicial);
            }
            if($fechaResolucion){
                $userLcProhibicion->setFechaResolucion(new \Datetime($fechaResolucion));
            }
            if($fechaOrden){
                $userLcProhibicion->setFechaOrden(new \Datetime($fechaOrden));
            }
            if($fechaPlazo){
                $userLcProhibicion->setFechaPlazo(new \Datetime($fechaPlazo));
            }

            $userLcProhibicion->setUsuario($usuario);
            $userLcProhibicion->setTipoNovedad($params->tipoNovedad);
            $userLcProhibicion->setTipoOrden($params->tipoOrden);
            $userLcProhibicion->setNumProceso($params->numProceso);
            $userLcProhibicion->setFechaInicio(new \Datetime($fechaInicio));
            $userLcProhibicion->setFechaFin(new \Datetime($fechaFin));
            $userLcProhibicion->setMotivo($params->motivo);
            
            // var_dump($userLcProhibicion);
            // die();
            $em->persist($userLcProhibicion);
            $em->flush();
            
            $userRestriccion = new UserRestriccion();
            $userRestriccion->setUsuario($usuario);
            $userRestriccion->setTipo('PROHIBICION');
            $userRestriccion->setForanea($userLcProhibicion->getId());
            $userRestriccion->setTabla('UserLcProhibicion');
            $userRestriccion->setDescripcion($params->tipoNovedad.' DERECHO A CONDUCIR');
            $userRestriccion->setFechaRegistro(new \Datetime($fechaInicio));
            $userRestriccion->setFechaVencimiento(new \Datetime($fechaFin));
            $userRestriccion->setActivo(true);
            
            $em->persist($userRestriccion);
            $em->flush();

            

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con éxito",
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no valida",
            );
        }
        return $helpers->json($response);
    }



    /**
     * Creates a new userLcProhibicion entity.
     *
     * @Route("/reporte", name="userlcprohibicion_reporte")
     * @Method({"GET", "POST"})
     */
    public function reporteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization",null);
        $authCheck = $helpers->authCheck($hash);
        
        if($authCheck == true){
            $json = $request->get("data",null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();

            $fechaInicio = new \Datetime($params->fechaInicio);
            $fechaFin = new \Datetime($params->fechaFin);

           
            $prohibiciones = $em->getRepository('JHWEBUsuarioBundle:UserLcProhibicion')->getFecha($fechaInicio,$fechaFin);
            
            if($prohibiciones){ 
                $dir=__DIR__.'/../../../../web/docs/';
                $file = $dir."reporteProhibicion.txt"; 
    
                if( file_exists("reporteProhibicion.txt") == false ){
                    $archivo = fopen($file, "w+b");    // Abrir el archivo, creándolo si no existe
                }else{
                    $archivo = fopen($file,"r"); 
                }
    
                if($archivo == false){
                    echo("Error al crear el archivo");
                } else {
                    foreach ($prohibiciones as $key => $prohibicion) {
                        
                        if($prohibicion->getNumProceso() != null) {
                            fwrite($archivo, $prohibicion->getNumProceso(). ",");
                        } elseif ($prohibicion->getNumProceso() == null) {
                            fwrite($archivo, "" . ",");
                        }
                        if($prohibicion->getFechaInicio() != null) {
                            fwrite($archivo, $prohibicion->getFechaInicio()->format('Y-m-d'). ",");
                        } elseif ($prohibicion->getFechaInicio() == null) {
                            fwrite($archivo, "" . ",");
                        }
                        if($prohibicion->getFechaFin() != null) {
                            fwrite($archivo, $prohibicion->getFechaFin()->format('Y-m-d'). ",");
                        } elseif ($prohibicion->getFechaFin() == null) {
                            fwrite($archivo, "" . ",");
                        }
                        if($prohibicion->getFechaResolucion() != null) {
                            fwrite($archivo, $prohibicion->getFechaResolucion()->format('Y-m-d'). ",");
                        } elseif ($prohibicion->getFechaResolucion() == null) {
                            fwrite($archivo, "" . ",");
                        }
                        if($prohibicion->getFechaPlazo() != null) {
                            fwrite($archivo, $prohibicion->getFechaPlazo()->format('Y-m-d'). ",");
                        } elseif ($prohibicion->getFechaPlazo() == null) {
                            fwrite($archivo, "" . ",");
                        }
                        if($prohibicion->getTipoOrden() != null) {
                            fwrite($archivo, $prohibicion->getTipoOrden(). ",");
                        } elseif ($prohibicion->getTipoOrden() == null) {
                            fwrite($archivo, "" . ",");
                        }
                        if($prohibicion->getTipoNovedad() != null) {
                            fwrite($archivo, $prohibicion->getTipoNovedad(). ",");
                        } elseif ($prohibicion->getTipoNovedad() == null) {
                            fwrite($archivo, "" . ",");
                        }
                        if($prohibicion->getMotivo() != null) {
                            fwrite($archivo, $prohibicion->getMotivo(). ",");
                        } elseif ($prohibicion->getMotivo() == null) {
                            fwrite($archivo, "" . ",");
                        }
                        if($prohibicion->getUsuario() != null) {
                            fwrite($archivo, $prohibicion->getUsuario()->getIdentificacion(). ",");
                        } elseif ($prohibicion->getUsuario() == null) {
                            fwrite($archivo, "" . ",");
                        }
                        if($prohibicion->getUsuario() != null) {
                            fwrite($archivo, $prohibicion->getUsuario()->getPrimerNombre().' '.$prohibicion->getUsuario()->getSegundoNombre().' '.$prohibicion->getUsuario()->getPrimerApellido().' '.$prohibicion->getUsuario()->getSegundoApellido(). ",");
                        } elseif ($prohibicion->getUsuario() == null) {
                            fwrite($archivo, "" . ",");
                        }
                        
                        fwrite($archivo, "" . "\r\n");
                       
                    }
                    fflush($archivo);
    
                    fclose($archivo);   // Cerrar el archivo
    
                    $arrayReportes[] = "TTAMTRVE.DAT";
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => "Registro creado con éxito",
                        'data' => "reporteProhibicion.txt",
                    );
                }
            }
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no valida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Finds and displays a userLcProhibicion entity.
     *
     * @Route("/{id}", name="userlcprohibicion_show")
     * @Method("GET")
     */
    public function showAction(UserLcProhibicion $userLcProhibicion)
    {
        $deleteForm = $this->createDeleteForm($userLcProhibicion);

        return $this->render('userlcprohibicion/show.html.twig', array(
            'userLcProhibicion' => $userLcProhibicion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing userLcProhibicion entity.
     *
     * @Route("/{id}/edit", name="userlcprohibicion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, UserLcProhibicion $userLcProhibicion)
    {
        $deleteForm = $this->createDeleteForm($userLcProhibicion);
        $editForm = $this->createForm('JHWEB\UsuarioBundle\Form\UserLcProhibicionType', $userLcProhibicion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('userlcprohibicion_edit', array('id' => $userLcProhibicion->getId()));
        }

        return $this->render('userlcprohibicion/edit.html.twig', array(
            'userLcProhibicion' => $userLcProhibicion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a userLcProhibicion entity.
     *
     * @Route("/{id}", name="userlcprohibicion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, UserLcProhibicion $userLcProhibicion)
    {
        $form = $this->createDeleteForm($userLcProhibicion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($userLcProhibicion);
            $em->flush();
        }

        return $this->redirectToRoute('userlcprohibicion_index');
    }

    /**
     * Creates a form to delete a userLcProhibicion entity.
     *
     * @param UserLcProhibicion $userLcProhibicion The userLcProhibicion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(UserLcProhibicion $userLcProhibicion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('userlcprohibicion_delete', array('id' => $userLcProhibicion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
