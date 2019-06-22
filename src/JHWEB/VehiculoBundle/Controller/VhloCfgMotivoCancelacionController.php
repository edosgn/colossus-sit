<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloCfgMotivoCancelacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlocfgmotivocancelacion controller.
 *
 * @Route("vhlocfgmotivocancelacion")
 */
class VhloCfgMotivoCancelacionController extends Controller
{
    /**
     * Lists all vhloCfgMotivoCancelacion entities.
     *
     * @Route("/", name="vhlocfgmotivocancelacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $motivosCancelacion = $em->getRepository('JHWEBVehiculoBundle:VhloCfgMotivoCancelacion')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($motivosCancelacion) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($motivosCancelacion)." registros encontrados", 
                'data'=> $motivosCancelacion,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new vhloCfgMotivoCancelacion entity.
     *
     * @Route("/new", name="vhlocfgmotivocancelacion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);
            
            $em = $this->getDoctrine()->getManager();

            $motivoCancelacion = new VhloCfgMotivoCancelacion();

            $motivoCancelacion->setNombre($params->nombre);
            $motivoCancelacion->setCodigo($params->codigo);
            $motivoCancelacion->setActivo(true);
            $motivoCancelacion->setGestionable(false);

            $em->persist($motivoCancelacion);
            $em->flush();

            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con exito",
            );
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Finds and displays a vhloCfgMotivoCancelacion entity.
     *
     * @Route("/show", name="vhlocfgmotivocancelacion_show")
     * @Method("GET")
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $motivoCancelacion = $em->getRepository("JHWEBVehiculoBundle:VhloCfgMotivoCancelacion")->find($params->id);

            if ($motivoCancelacion) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado con exito", 
                    'data'=> $motivoCancelacion,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorizacion no valida para editar", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing vhloCfgMotivoCancelacion entity.
     *
     * @Route("/edit", name="vhlocfgmotivocancelacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $motivoCancelacion = $em->getRepository("JHWEBVehiculoBundle:VhloCfgMotivoCancelacion")->find($params->id);

            if ($motivoCancelacion) {
                $motivoCancelacion->setCodigo($params->codigo);
                $motivoCancelacion->setNombre($params->nombre);
                
                $em->flush();

                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $motivoCancelacion,
                );
            }else{
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($response);
    }

    /**
     * Deletes a vhloCfgMotivoCancelacion entity.
     *
     * @Route("/delete", name="vhlocfgmotivocancelacion_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $motivoCancelacion = $em->getRepository("JHWEBVehiculoBundle:VhloCfgMotivoCancelacion")->find($params->id);

            if ($motivoCancelacion) {
                $motivoCancelacion->setActivo(false);
                
                $em->flush();

                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro eliminado con exito", 
                    'data'=> $motivoCancelacion,
                );
            }else{
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorización no válida", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="vhlocfgmotivocancelacion_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $motivosCancelacion = $em->getRepository('JHWEBVehiculoBundle:VhloCfgMotivoCancelacion')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($motivosCancelacion as $key => $motivoCancelacion) {
            $response[$key] = array(
                'value' => $motivoCancelacion->getId(),
                'label' => $motivoCancelacion->getNombre()
            );
        }
        
        return $helpers->json($response);
    }
}
