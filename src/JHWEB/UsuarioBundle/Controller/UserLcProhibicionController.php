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

            $userLcProhibicion = new UserLcProhibicion();

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

           
            $trazabilidades = $em->getRepository('JHWEBContravencionalBundle:CvCdoTrazabilidad')->getResolucionesByFechasForLicenciasConduccion($fechaInicio,$fechaFin);
             

            if($trazabilidades){
                $dir=__DIR__.'/../../../../web/docs/';
                $file = $dir.'resol.txt'; 
                
                if( file_exists('resol.txt') == false ){
                    $archivo = fopen($file, "w+b");    // Abrir el archivo, creándolo si no existe
                }else{
                    $archivo = fopen($file,"r"); 
                }
                
                if($archivo == false){
                    echo("Error al crear el archivo");
                }else{

                    $sumatoriaValorComparendo = 0;
                    $cont = 0;

                    foreach ($trazabilidades as $key => $trazabilidad) {
                        $cont ++;
                        $sumatoriaValorComparendo += $trazabilidad->getComparendo()->getValorPagar();

                        fwrite($archivo, $key + 1 . ",");
                        fwrite($archivo, $trazabilidad->getActoAdministrativo()->getNumero() . ",");
                        fwrite($archivo, "" . ",");
                        fwrite($archivo, $trazabilidad->getActoAdministrativo()->getFecha()->format('d/m/Y') . ",");
                        fwrite($archivo, $trazabilidad->getEstado()->getCodigo() . ",");
                        if($trazabilidad->getRestriccion() != null) {
                            fwrite($archivo, $trazabilidad->getRestriccion()->getFechaFin()->format('d/m/Y') . ",");
                        } elseif ($trazabilidad->getRestriccion() == null) {
                            fwrite($archivo, "" . ",");
                        }
                        if($trazabilidad->getComparendo()->getConsecutivo() != null) {
                            fwrite($archivo, $trazabilidad->getComparendo()->getConsecutivo()->getNumero() . ",");
                        } elseif ($trazabilidad->getComparendo()->getConsecutivo() == null) {
                            fwrite($archivo, "" . ",");
                        }
                        fwrite($archivo, $trazabilidad->getComparendo()->getFecha()->format('d/m/Y') . ",");
                        fwrite($archivo, $trazabilidad->getComparendo()->getInfractorIdentificacion() . ",");
                        if($trazabilidad->getComparendo()->getInfractorTipoIdentificacion() != null) {
                            fwrite($archivo, $trazabilidad->getComparendo()->getInfractorTipoIdentificacion()->getCodigo() . ",");
                        } elseif ($trazabilidad->getComparendo()->getInfractorTipoIdentificacion() == null) {
                            fwrite($archivo, "" . ",");
                        }
                        fwrite($archivo, $trazabilidad->getComparendo()->getInfractorNombres() . ",");
                        fwrite($archivo, $trazabilidad->getComparendo()->getInfractorApellidos() . ",");
                        fwrite($archivo, $trazabilidad->getComparendo()->getInfractorDireccion() . ",");
                        fwrite($archivo, $trazabilidad->getComparendo()->getInfractorTelefono() . ",");
                        fwrite($archivo, $trazabilidad->getComparendo()->getInfractorMunicipioResidencia() . ",");
                        fwrite($archivo, $trazabilidad->getComparendo()->getValorPagar() . ",");
                        /* fwrite($archivo, $trazabilidad->getComparendo()->getValorAdicional() . ","); */ //valor adicional a pagar del comparendo
                        /* fwrite($archivo, $trazabilidad->getComparendo()->getFotomulta() . ","); */
                        // eliminarlos luego
                        fwrite($archivo, "0" . ",");
                        fwrite($archivo, "N" . ",");
                        //=============================================================================
                        if($trazabilidad->getComparendo()->getOrganismoTransito() != null) {
                            fwrite($archivo, $trazabilidad->getComparendo()->getOrganismoTransito()->getDivipo() . ",");
                        } elseif (condition) {
                            fwrite($archivo, "" . ",");
                        }
                        if($trazabilidad->getComparendo()->getPolca() == 0) {
                            fwrite($archivo, "N" . ",");
                        } elseif ($trazabilidad->getComparendo()->getPolca() == 1) {
                            fwrite($archivo, "S" . ",");
                        }
                        if($trazabilidad->getComparendo()->getInfraccion() != null) {
                            fwrite($archivo, $trazabilidad->getComparendo()->getInfraccion()->getId() . ",");
                        } elseif ($trazabilidad->getComparendo()->getInfraccion() == null) {
                            fwrite($archivo, "" . ",");
                        }
                        fwrite($archivo, $trazabilidad->getComparendo()->getValorInfraccion() . ",");
                        fwrite($archivo, $trazabilidad->getComparendo()->getValorPagar() . ",");
                        fwrite($archivo, $trazabilidad->getComparendo()->getGradoAlcoholemia() . ",");
                        if($trazabilidad->getRestriccion() != null) {
                            if($trazabilidad->getRestriccion()->getHorasComunitarias() == 1) {
                                fwrite($archivo, "S" . "\r\n");
                            } elseif ($trazabilidad->getRestriccion()->getHorasComunitarias() == 0) {
                                fwrite($archivo, "N" . "\r\n");
                            }
                        } elseif ($trazabilidad->getRestriccion() == null) {
                            fwrite($archivo, "" . "\r\n");
                        }
                    }
                    
                    fwrite($archivo, $cont . ",");
                    fwrite($archivo, $sumatoriaValorComparendo . ",");
                    fwrite($archivo, "0" . ",");
                    fwrite($archivo, "0" .  "\r\n");

                    fflush($archivo);
                }

                fclose($archivo);   // Cerrar el archivo

                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Archivo generado",
                    'data' => "resol.txt"
                );  
            
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No se encontraron prohibiciones",
                    'data' => null,
                );
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
