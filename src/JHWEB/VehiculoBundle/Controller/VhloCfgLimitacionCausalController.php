<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloCfgLimitacionCausal;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlocfglimitacioncausal controller.
 *
 * @Route("vhlocfglimitacioncausal")
 */
class VhloCfgLimitacionCausalController extends Controller
{
    /**
     * Lists all vhloCfgLimitacionCausal entities.
     *
     * @Route("/", name="vhlocfglimitacioncausal_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $causales = $em->getRepository('JHWEBVehiculoBundle:VhloCfgLimitacionCausal')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($causales) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($causales)." registros encontrados", 
                'data'=> $causales,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new vhloCfgLimitacionCausal entity.
     *
     * @Route("/new", name="vhlocfglimitacioncausal_new")
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

            $causalLimitacion = new VhloCfgLimitacionCausal();

            $causalLimitacion->setNombre($params->nombre);
            $causalLimitacion->setActivo(true);

            $em->persist($causalLimitacion);
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
     * Finds and displays a vhloCfgLimitacionCausal entity.
     *
     * @Route("/{id}/show", name="vhlocfglimitacioncausal_show")
     * @Method("GET")
     */
    public function showAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            
            $causalLimitacion = $em->getRepository('JHWEBVehiculoBundle:VhloCfgLimitacionCausal')->find($id);
            
            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Registro encontrado", 
                'data'=> $causalLimitacion,
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
     * Displays a form to edit an existing vhloCfgLimitacionCausal entity.
     *
     * @Route("/edit", name="vhlocfglimitacioncausal_edit")
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

            $causalLimitacion = $em->getRepository('JHWEBVehiculoBundle:VhloCfgLimitacionCausal')->find($params->id);
            
            if ($causalLimitacion) {
                $causalLimitacion->setNombre(mb_strtoupper($params->nombre, 'utf-8'));

                $em->persist($causalLimitacion);
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
     * Deletes a vhloCfgLimitacionCausal entity.
     *
     * @Route("/delete", name="vhlocfglimitacioncausal_delete")
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

            $causalLimitacion = $em->getRepository("JHWEBVehiculoBundle:VhloCfgLimitacionCausal")->find($params->id);

            if ($causalLimitacion) {
                $causalLimitacion->setActivo(false);
                
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
     * Creates a form to delete a vhloCfgLimitacionCausal entity.
     *
     * @param VhloCfgLimitacionCausal $vhloCfgLimitacionCausal The vhloCfgLimitacionCausal entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloCfgLimitacionCausal $vhloCfgLimitacionCausal)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhlocfglimitacioncausal_delete', array('id' => $vhloCfgLimitacionCausal->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ================================================= */
    
    /**
     * Listado de causales
     *
     * @Route("/select", name="vhlocfglimitacioncausal_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $causales = $em->getRepository('JHWEBVehiculoBundle:VhloCfgLimitacionCausal')->findBy(
            array(
                'activo' => true
            )
        );

        $response = null;

        foreach ($causales as $key => $causal) {
            $response[$key] = array(
                'value' => $causal->getId(),
                'label' => $causal->getNombre()
            );
        }
        return $helpers->json($response);
    }
}
