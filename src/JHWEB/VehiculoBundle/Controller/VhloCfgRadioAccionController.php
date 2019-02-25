<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloCfgRadioAccion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlocfgradioaccion controller.
 *
 * @Route("vhlocfgradioaccion")
 */
class VhloCfgRadioAccionController extends Controller
{
    /**
     * Lists all vhloCfgRadioAccion entities.
     *
     * @Route("/", name="vhlocfgradioaccion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $radiosAccion = $em->getRepository('JHWEBVehiculoBundle:VhloCfgRadioAccion')->findBy(
            array('activo'=>true)
        );

        $response['data'] = array();

        if ($radiosAccion) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($radiosAccion)." Registros encontrados", 
                'data'=> $radiosAccion,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new vhloCfgRadioAccion entity.
     *
     * @Route("/new", name="vhlocfgradioaccion_new")
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

            $radioAccion = new VhloCfgRadioAccion();

            $radioAccion->setNombre(strtoupper($params->nombre));
            $radioAccion->setActivo(true);
            
            $em->persist($radioAccion);
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
     * Finds and displays a vhloCfgRadioAccion entity.
     *
     * @Route("/show", name="vhlocfgradioaccion_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $radioAccion = $em->getRepository('JHWEBVehiculoBundle:VhloCfgRadioAccion')->find($params->id);

            if ($radioAccion) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado", 
                    'data'=> $radioAccion,
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
                'message' => "Autorizacion no valida", 
            );
        }

        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing vhloCfgRadioAccion entity.
     *
     * @Route("/edit", name="vhlocfgradioaccion_edit")
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
            $radioAccion = $em->getRepository("JHWEBVehiculoBundle:VhloCfgRadioAccion")->find($params->id);

            if ($radioAccion) {
                $radioAccion->setNombre(strtoupper($params->nombre));
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $radioAccion,
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
     * Deletes a vhloCfgRadioAccion entity.
     *
     * @Route("/delete", name="vhlocfgradioaccion_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request, VhloCfgRadioAccion $vhloCfgRadioAccion)
    {
        $form = $this->createDeleteForm($vhloCfgRadioAccion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vhloCfgRadioAccion);
            $em->flush();
        }

        return $this->redirectToRoute('vhlocfgradioaccion_index');
    }

    /**
     * Creates a form to delete a vhloCfgRadioAccion entity.
     *
     * @param VhloCfgRadioAccion $vhloCfgRadioAccion The vhloCfgRadioAccion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloCfgRadioAccion $vhloCfgRadioAccion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhlocfgradioaccion_delete', array('id' => $vhloCfgRadioAccion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="vhlocfgradioaccion_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $radiosAccion = $em->getRepository('JHWEBVehiculoBundle:VhloCfgRadioAccion')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($radiosAccion as $key => $radioAccion) {
            $response[$key] = array(
                'value' => $radioAccion->getId(),
                'label' => $radioAccion->getNombre()
            );
        }
        
        return $helpers->json($response);
    }
}
