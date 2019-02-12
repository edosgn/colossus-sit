<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TramitePrecio;
use AppBundle\Entity\Modulo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Tramiteprecio controller.
 *
 * @Route("tramiteprecio")
 */
class TramitePrecioController extends Controller
{
    /**
     * Lists all tramitePrecio entities.
     *
     * @Route("/", name="tramiteprecio_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $tramitePreciosTotal = $em->getRepository('AppBundle:TramitePrecio')->findBy(
            array('estado' => 1)
        );
        $tramiteTotal = $em->getRepository('AppBundle:TramitePrecio')->findBy(
            array('estado' => 1 , 'activo'=> 1)
        );
        
        $fechaActual = new \DateTime("now");
        $fechaActualCompare = $fechaActual->format("Y-m-d");
        
        foreach ($tramitePreciosTotal as $key => $tramitePrecio) {
            $fechainicioCompare = $tramitePrecio->getFechaInicio();
            if($fechainicioCompare<=$fechaActualCompare){
                $tramitePrecio->setActivo(true);
                
                $em->persist($tramitePrecio);
                $em->flush();
            }
        }
        
        // lista de tramites activos y proximos
        $tramitePreciosActivo = $em->getRepository('AppBundle:TramitePrecio')->findBy(
            array('estado' => 1,'activo'=>1)
            );

        $tramiteProximo = $em->getRepository('AppBundle:TramitePrecio')->findBy(
                array('estado' => 1, 'activo'=>0)
            );

        $comprobar = $em->getRepository('AppBundle:TramitePrecio')->findBy(
            array('estado' => 1,'activo'=>1)
            );

        $response = array(
            'status' => 'success',
            'code' => 200,
            'msj' => "listado tramitePrecios", 
            'tramitePreciosActivo'=> $tramitePreciosActivo,
            'tramiteProximo'=> $tramiteProximo,
            'data'=> $tramitePreciosActivo, 
            'compa'=> $comprobar,
        );
         
        return $helpers->json($response);
        // fin de lista activos



        foreach ($tramiteTotal as $key1 => $tramitePrecio) {

            foreach ($tramitesAsignados as $key => $tramiteAsigando) {
                if ($tramiteTotal->getNombre() != $tramiteAsigando->getNombre()) {
                    $tramitesEnviar[$key1] = $tramiteTotal;
                }
            } 
        }

        $response = array(
            'status' => 'success',
                    'code' => 200,
                    'msj' => "listado tramitePrecios", 
                    'tramitePreciosActivo'=> $tramitesEnviar,
                   
            );
   
    }

    /**
     * Creates a new tramitePrecio entity.
     *
     * @Route("/new", name="tramiteprecio_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck== true) { 
            $json = $request->get("json",null);
            $params = json_decode($json);

            $fechaInicio = $params->fechaInicio;
            
            if (new \DateTime($fechaInicio) < new \DateTime(date('Y-m-d'))) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "La fecha de inicio no puede ser inferior a la fecha actual.", 
                );
            }else{
                $em = $this->getDoctrine()->getManager();

                $tramitePrecio = new TramitePrecio();
                $tramite = $em->getRepository('AppBundle:Tramite')->find($params->tramiteId);
                $modulo = $em->getRepository('AppBundle:Modulo')->find($params->moduloId);
                $fechaInicio = new \DateTime($fechaInicio);

                if (isset($params->claseId)) {
                    $clase = $em->getRepository('AppBundle:Clase')->find($params->claseId);
                    $tramitePrecio->setClase($clase);
                    $tramitePrecio->setNombre($tramite->getNombre() . ' ' . $clase->getNombre());
                }else{
                    $tramitePrecio->setNombre($tramite->getNombre());
                }

                $tramitePrecio->setValor(ceil($params->valor));
                $tramitePrecio->setFechaInicio($fechaInicio);
                $tramitePrecio->setModulo($modulo);
                $tramitePrecio->setTramite($tramite);
                $tramitePrecio->setEstado(true);

                $fechaActual = new \DateTime("now");
                $fechaActualCompare = $fechaActual->format("Y-m-d");
                $fechainicioCompare = $fechaInicio->format("Y-m-d");
                
                if($fechainicioCompare==$fechaActualCompare){
                    $tramitePrecio->setActivo(true);

                }else{
                    $tramitePrecio->setActivo(false);
                }
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($tramitePrecio);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "precio creada con exito", 
                );
            }  
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida", 
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new tramitePrecio entity.
     *
     * @Route("/new/tramites/precios", name="tramiteprecio_tramites")
     * @Method({"GET", "POST"})
     */
    public function newTramitesPreciosAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck== true) { 
            $em = $this->getDoctrine()->getManager();
            $json = $request->get("json",null);
            $params = json_decode($json);
            foreach ($params as $key => $tramitePrecio) {
                $tramitePrecioBD = $em->getRepository('AppBundle:TramitePrecio')->findOneBy(
                    array('nombre' => $tramitePrecio->nombre,'estado' => 1)
                );
                $tramitePrecioBD->setEstado(false);
                $em->persist($tramitePrecioBD);
                $em->flush();

                



                $tramitePrecioNew = new TramitePrecio();
                $fechaInicio = new \DateTime($tramitePrecio->fechaInicio);

                $tramitePrecioNew->setNombre($tramitePrecio->nombre);
                $tramitePrecioNew->setValor($tramitePrecio->valorNuevo);
                $tramitePrecioNew->setValorTotal($tramitePrecio->valorTotal);
                $tramitePrecioNew->setFechaInicio($fechaInicio);
                $tramitePrecioNew->setModulo($tramitePrecioBD->getModulo());
                $tramitePrecioNew->setTramite($tramitePrecioBD->getTramite());
                $tramitePrecioNew->setClase($tramitePrecioBD->getClase());
                $tramitePrecioNew->setEstado(true);
    
                $fechaActual = new \DateTime("now");
                $fechaActualCompare = $fechaActual->format("Y-m-d");
                $fechainicioCompare = $fechaInicio->format("Y-m-d");
                
                if($fechainicioCompare==$fechaActualCompare){
                    $tramitePrecioNew->setActivo(true);
    
                }else{
                    $tramitePrecioNew->setActivo(false);
                }
    
                $em = $this->getDoctrine()->getManager();
                $em->persist($tramitePrecioNew);
                $em->flush();
            }

            $conceptoParametrosTramites = $em->getRepository('AppBundle:ConceptoParametroTramite')->findBy(
                array('tramitePrecio' => $tramitePrecioBD->getId(),'estado' => 1)
            );

            foreach ($conceptoParametrosTramites as $key => $conceptoParametroTramite) {
                $conceptoParametroTramite->setTramitePrecio($tramitePrecioNew);
                $em->persist($conceptoParametroTramite);
                $em->flush();
            }
               
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "precio creada con éxito", 
                );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida", 
            );
            } 
        return $helpers->json($response);
    }

    /**
     * Finds and displays a tramitePrecio entity.
     *
     * @Route("/show/{id}", name="tramiteprecio_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $tramitePrecio = $em->getRepository('AppBundle:TramitePrecio')->find($id);
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "tramitePrecio encontrada", 
                    'data'=> $tramitePrecio,
            );
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing Color entity.
     *
     * @Route("/edit", name="tramiteprecio_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("json",null);
            $params = json_decode($json);
            
            $valor = $params->valor;
            $fechaInicio = $params->fechaInicio;
            $moduloId = $params->moduloId;
            $tramiteId = $params->tramiteId;
            $fechaInicio = new \DateTime($fechaInicio);
            
            $em = $this->getDoctrine()->getManager();
            $tramitePrecio = $em->getRepository("AppBundle:TramitePrecio")->find($params->id);
            if ($params->claseId) {
                $claseId = $params->claseId;
                $clase = $em->getRepository('AppBundle:Clase')->find($claseId);
                $tramitePrecio->setClase($clase);
            }



            $tramite = $em->getRepository('AppBundle:Tramite')->find($tramiteId);
            $modulo = $em->getRepository("AppBundle:Modulo")->find($moduloId);

            if ($tramitePrecio!=null) {

                $tramitePrecio->setValor($valor);
                $tramitePrecio->setFechaInicio($fechaInicio);
                $tramitePrecio->setModulo($modulo);
                $tramitePrecio->setTramite($tramite);
                $tramitePrecio->setEstado(true);


                $em = $this->getDoctrine()->getManager();
                $em->persist($tramitePrecio);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "precio editada con exito", 
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "La precio no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar banco", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * datos para select 2 por modulo
     *
     * @Route("/{id}/delete/tramite/precio", name="eliminar_tramite_precio")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $tramitePrecio = $em->getRepository('AppBundle:TramitePrecio')->find($id);
            
            $tramitePrecio->setEstado(false);
            $em->persist($tramitePrecio);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "registro eliminado", 
            );

        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar banco", 
                );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a tramitePrecio entity.
     *
     * @param TramitePrecio $tramitePrecio The tramitePrecio entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TramitePrecio $tramitePrecio)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tramiteprecio_delete', array('id' => $tramitePrecio->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select/modulo/{moduloId}", name="pais_select")
     * @Method({"GET", "POST"})
     */
    public function selectPaisAction($moduloId)
    {
        $response = null;
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $tramitesPrecio = $em->getRepository('AppBundle:TramitePrecio')->findBy(
            array('estado' => 1,'modulo'=>$moduloId)
        );
        foreach ($tramitesPrecio as $key => $tramitePrecio) {
            $response[$key] = array(
                'value' => $tramitePrecio->getId(),
                'label' => $tramitePrecio->getNombre(),
            );
        }
        return $helpers->json($response);
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="tramite_precio_select")
     * @Method({"GET", "POST"})
     */
    public function selectTramitePrecioAction()
    {
        $response = null;
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $tramitesPrecio = $em->getRepository('AppBundle:TramitePrecio')->findAll();
        foreach ($tramitesPrecio as $key => $tramitePrecio) {
            $response[$key] = array(
                'value' => $tramitePrecio->getId(),
                'label' => $tramitePrecio->getNombre(),
            );
        }
        return $helpers->json($response);
    }
}
