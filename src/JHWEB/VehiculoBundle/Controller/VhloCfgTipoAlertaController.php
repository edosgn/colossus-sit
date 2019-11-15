<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloCfgTipoAlerta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlocfgtipoalertum controller.
 *
 * @Route("vhlocfgtipoalerta")
 */
class VhloCfgTipoAlertaController extends Controller
{
    /**
     * Lists all vhloCfgTipoAlertum entities.
     *
     * @Route("/", name="vhlocfgtipoalerta_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $tiposAlerta = $em->getRepository('JHWEBVehiculoBundle:VhloCfgTipoAlerta')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($tiposAlerta) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($tiposAlerta)." registros encontrados", 
                'data'=> $tiposAlerta,
            );
        }

        return $helpers->json($response);;
    }

    /**
     * Creates a new vhloCfgTipoAlertum entity.
     *
     * @Route("/new", name="vhlocfgtipoalerta_new")
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
            
            $tipoAlerta = new VhloCfgTipoAlerta();

            $tipoAlerta->setNombre(mb_strtoupper($params->nombre, 'utf-8'));
            $tipoAlerta->setActivo(true);

            $em->persist($tipoAlerta);
            $em->flush();

            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con exito",
            );
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

    /**
     * Finds and displays a vhloCfgTipoAlertum entity.
     *
     * @Route("/show", name="vhlocfgtipoalerta_show")
     * @Method("POST")
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

            $tipoAlerta = $em->getRepository('JHWEBVehiculoBundle:VhloCfgTipoAlerta')->find(
                $params->id
            );

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Registro encontrado con exito.',
                'data' => $tipoAlerta
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida.', 
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing vhloCfgTipoAlertum entity.
     *
     * @Route("/edit", name="vhlocfgtipoalerta_edit")
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
            $tipoAlerta = $em->getRepository("JHWEBVehiculoBundle:VhloCfgTipoAlerta")->find($params->id);

            if ($tipoAlerta) {
                $tipoAlerta->setNombre(mb_strtoupper($params->nombre, 'utf-8'));
                
                $em->flush();

                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
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
                'message' => "Autorizacion no valida para editar", 
            );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a vhloCfgTipoAlertum entity.
     *
     * @Route("/delete", name="vhlocfgtipoalerta_delete")
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
            $tipoAlerta = $em->getRepository("JHWEBVehiculoBundle:VhloCfgTipoAlerta")->find($params->id);

            if ($tipoAlerta) {
                $tipoAlerta->setActivo(false);
                
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
                'message' => "Autorizacion no valida para editar", 
            );
        }

        return $helpers->json($response);
    }

    /**
     * Listado con tipos de alerta para seleección con búsqueda
     *
     * @Route("/select", name="vhlocfgtipoalerta_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $alertas = $em->getRepository('JHWEBVehiculoBundle:VhloCfgTipoAlerta')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($alertas as $key => $alerta) {
            $response[$key] = array(
                'value' => $alerta->getId(),
                'label' => $alerta->getNombre()
            );
        }
        
        return $helpers->json($response);
    }
}
