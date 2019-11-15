<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloCfgLimitacionTipo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlocfglimitaciontipo controller.
 *
 * @Route("vhlocfglimitaciontipo")
 */
class VhloCfgLimitacionTipoController extends Controller
{
    /**
     * Lists all vhloCfgLimitacionTipo entities.
     *
     * @Route("/", name="vhlocfglimitaciontipo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $tiposLimitacion = $em->getRepository('JHWEBVehiculoBundle:VhloCfgLimitacionTipo')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($tiposLimitacion) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($tiposLimitacion)." registros encontrados", 
                'data'=> $tiposLimitacion,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new vhloCfgLimitacionTipo entity.
     *
     * @Route("/new", name="vhlocfglimitaciontipo_new")
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

            $tipoLimitacion = new VhloCfgLimitacionTipo();

            $tipoLimitacion->setNombre(mb_strtoupper($params->nombre, 'utf-8'));
            $tipoLimitacion->setActivo(true);

            $em->persist($tipoLimitacion);
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
     * Finds and displays a vhloCfgLimitacionTipo entity.
     *
     * @Route("/{id}/show", name="vhlocfglimitaciontipo_show")
     * @Method("GET")
     */
    public function showAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            
            $tipoLimitacion = $em->getRepository('JHWEBVehiculoBundle:VhloCfgLimitacionCausal')->find($id);
            
            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Registro encontrad", 
                'data'=> $tipoLimitacion,
            );
        }else{
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
     * Displays a form to edit an existing vhloCfgLimitacionTipo entity.
     *
     * @Route("/edit", name="vhlocfglimitaciontipo_edit")
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

            $tipoLimitacion = $em->getRepository('JHWEBVehiculoBundle:VhloCfgLimitacionTipo')->find($params->id);
            
            if ($tipoLimitacion) {
                $tipoLimitacion->setNombre(mb_strtoupper($params->nombre, 'utf-8'));

                $em->persist($tipoLimitacion);
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
     * Deletes a vhloCfgLimitacionTipo entity.
     *
     * @Route("/delete", name="vhlocfglimitaciontipo_delete")
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

            $limitacionTipo = $em->getRepository("JHWEBVehiculoBundle:VhloCfgLimitacionTipo")->find(mb_strtoupper($params->id, 'utf-8'));

            if ($limitacionTipo) {
                $limitacionTipo->setActivo(false);
                
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

    /**
     * Creates a form to delete a vhloCfgLimitacionTipo entity.
     *
     * @param VhloCfgLimitacionTipo $vhloCfgLimitacionTipo The vhloCfgLimitacionTipo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloCfgLimitacionTipo $vhloCfgLimitacionTipo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhlocfglimitaciontipo_delete', array('id' => $vhloCfgLimitacionTipo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

     /* ================================================= */
    
    /**
     * Listado de tipos de proceso
     *
     * @Route("/select", name="vhlocfglimitaciontipo_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $tipos = $em->getRepository('JHWEBVehiculoBundle:VhloCfgLimitacionTipo')->findBy(
            array(
                'activo' => true
            )
        );

        $response = null;

        foreach ($tipos as $key => $tipo) {
            $response[$key] = array(
                'value' => $tipo->getId(),
                'label' => $tipo->getNombre()
            );
        }
        return $helpers->json($response);
    }
}
