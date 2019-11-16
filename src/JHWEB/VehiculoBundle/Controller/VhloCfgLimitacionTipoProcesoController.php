<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloCfgLimitacionTipoProceso;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlocfglimitaciontipoproceso controller.
 *
 * @Route("vhlocfglimitaciontipoproceso")
 */
class VhloCfgLimitacionTipoProcesoController extends Controller
{
    /**
     * Lists all vhloCfgLimitacionTipoProceso entities.
     *
     * @Route("/", name="vhlocfglimitaciontipoproceso_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $tiposProceso = $em->getRepository('JHWEBVehiculoBundle:VhloCfgLimitacionTipoProceso')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($tiposProceso) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($tiposProceso)." registros encontrados", 
                'data'=> $tiposProceso,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new vhloCfgLimitacionTipoProceso entity.
     *
     * @Route("/new", name="vhlocfglimitaciontipoproceso_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $tipoProceso = new VhloCfgLimitacionTipoProceso();

            $tipoProceso->setNombre($params->nombre);
            $tipoProceso->setActivo(true);

            $em->persist($tipoProceso);
            $em->flush();

            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con éxito",
            );
        } else {
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Finds and displays a vhloCfgLimitacionTipoProceso entity.
     *
     * @Route("/show", name="vhlocfglimitaciontipoproceso_show")
     * @Method("GET")
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $tipoProceso = $em->getRepository('JHWEBVehiculoBundle:VhloCfgLimitacionTipoProceso')->find($params->id);

            $em->flush();

            if ($tipoProceso) {
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado con exito",
                    'data' => $tipoProceso
                );
            }else{
                $response = array(
                    'title' => 'Atención!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => "Autorizacion no valida", 
                );
            }
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
     * Displays a form to edit an existing vhloCfgLimitacionTipoProceso entity.
     *
     * @Route("/edit", name="vhlocfglimitaciontipoproceso_edit")
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

            $tipoProceso = $em->getRepository('JHWEBVehiculoBundle:VhloCfgLimitacionTipoProceso')->find($params->id);
            
            if ($tipoProceso) {
                $tipoProceso->setNombre(mb_strtoupper($params->nombre, 'utf-8'));

                $em->persist($tipoProceso);
                $em->flush();

                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro editado con éxito", 
                );
            }else{
                $response = array(
                    'title' => 'Atención!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                'tittle' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida", 
            );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a vhloCfgLimitacionTipoProceso entity.
     *
     * @Route("/delete", name="vhlocfglimitaciontipoproceso_delete")
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

            $tipoProceso = $em->getRepository("JHWEBVehiculoBundle:VhloCfgLimitacionTipoProceso")->find($params->id);

            if ($tipoProceso) {
                $tipoProceso->setActivo(false);
                
                $em->flush();

                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro eliminado con exito", 
                );
            }else{
                $response = array(
                    'title' => 'Atención!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                'tittle' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
            );
        }

        return $helpers->json($response);
    }

    /* ================================================= */
    
    /**
     * Listado de tipos de proceso
     *
     * @Route("/select", name="vhlocfgtipoproceso_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $tiposProceso = $em->getRepository('JHWEBVehiculoBundle:VhloCfgLimitacionTipoProceso')->findBy(
            array(
                'activo' => true
            )
        );

        $response = null;

        foreach ($tiposProceso as $key => $tipoProceso) {
            $response[$key] = array(
                'value' => $tipoProceso->getId(),
                'label' => $tipoProceso->getNombre()
            );
        }
        return $helpers->json($response);
    }
}
