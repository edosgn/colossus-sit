<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloCfgCondicionIngreso;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlocfgcondicioningreso controller.
 *
 * @Route("vhlocfgcondicioningreso")
 */
class VhloCfgCondicionIngresoController extends Controller
{
    /**
     * Lists all vhloCfgCondicionIngreso entities.
     *
     * @Route("/", name="vhlocfgcondicioningreso_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $condicionesIngreso = $em->getRepository('JHWEBVehiculoBundle:VhloCfgCondicionIngreso')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($condicionesIngreso) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($condicionesIngreso)." registros encontrados", 
                'data'=> $condicionesIngreso,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new vhloCfgCondicionIngreso entity.
     *
     * @Route("/new", name="vhlocfgcondicioningreso_new")
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
           
            $condicionIngreso = new VhloCfgCondicionIngreso();

            $condicionIngreso->setNombre($params->nombre);
            $condicionIngreso->setActivo(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($condicionIngreso);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con exito",
            );
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
     * Finds and displays a vhloCfgCondicionIngreso entity.
     *
     * @Route("/{id}/show", name="vhlocfgcondicioningreso_show")
     * @Method("GET")
     */
    public function showAction(VhloCfgCondicionIngreso $vhloCfgCondicionIngreso)
    {
        $deleteForm = $this->createDeleteForm($vhloCfgCondicionIngreso);

        return $this->render('vhlocfgcondicioningreso/show.html.twig', array(
            'vhloCfgCondicionIngreso' => $vhloCfgCondicionIngreso,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vhloCfgCondicionIngreso entity.
     *
     * @Route("/edit", name="vhlocfgcondicioningreso_edit")
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
            $condicionIngreso = $em->getRepository("JHWEBVehiculoBundle:VhloCfgCondicionIngreso")->find($params->id);

            if ($condicionIngreso) {
                $condicionIngreso->setNombre($params->nombre);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $condicionIngreso,
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
     * Deletes a vhloCfgCondicionIngreso entity.
     *
     * @Route("/delete", name="vhlocfgcondicioningreso_delete")
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
            $condicionIngreso = $em->getRepository("JHWEBVehiculoBundle:VhloCfgCondicionIngreso")->find($params->id);

            if ($condicionIngreso) {
                $condicionIngreso->setActivo(false);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro eliminado con exito", 
                    'data'=> $condicionIngreso,
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
     * Creates a form to delete a vhloCfgCondicionIngreso entity.
     *
     * @param VhloCfgCondicionIngreso $vhloCfgCondicionIngreso The vhloCfgCondicionIngreso entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloCfgCondicionIngreso $vhloCfgCondicionIngreso)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhlocfgcondicioningreso_delete', array('id' => $vhloCfgCondicionIngreso->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="vhlocfgcondicioningreso_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $condicionesIngreso = $em->getRepository('JHWEBVehiculoBundle:VhloCfgCondicionIngreso')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($condicionesIngreso as $key => $condicionIngreso) {
            $response[$key] = array(
                'value' => $condicionIngreso->getId(),
                'label' => $condicionIngreso->getNombre()
            );
        }
        
        return $helpers->json($response);
    }
}
