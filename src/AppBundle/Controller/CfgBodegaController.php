<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CfgBodega;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request; use Symfony\Component\HttpFoundation\Response;

/**
 * CfgBodega controller.
 *
 * @Route("cfgbodega")
 */
class CfgBodegaController extends Controller
{
    /**
     * Lists all cfgBodega entities.
     *
     * @Route("/", name="cfgbodega_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $cfgBodegas = $em->getRepository('AppBundle:CfgBodega')->findBy(
            array('estado' => 1)
        );

        $response['data'] = array();

        if ($cfgBodegas) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($cfgBodegas)." registros encontrados", 
                'data'=> $cfgBodegas,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new cfgBodega entity.
     *
     * @Route("/new", name="cfgbodega_new")
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


            $bodega = new CfgBodega();

            $bodega->setNombre($params->nombre);
            $bodega->setEstado(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($bodega);
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
     * Finds and displays a cfgBodega entity.
     *
     * Route("/{id}/show", name="cfgbodega_show")
     * Method("GET")
     */
    public function showAction(CfgBodega $cfgBodega)
    {
        $deleteForm = $this->createDeleteForm($cfgBodega);

        return $this->render('cfgBodega/show.html.twig', array(
            'cfgBodega' => $cfgBodega,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cfgBodega entity.
     *
     * @Route("/{id}/edit", name="cfgbodega_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CfgBodega $cfgBodega)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            $cfgBodega = $em->getRepository("AppBundle:CfgBodega")->find($params->id);

            if ($cfgBodega) {
                $cfgBodega->setNombre($params->nombre);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $cfgBodega,
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
     * Deletes a cfgBodega entity.
     *
     * @Route("/{id}/delete", name="cfgbodega_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CfgBodega $cfgBodega)
    {
        $form = $this->createDeleteForm($cfgBodega);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cfgBodega);
            $em->flush();
        }

        return $this->redirectToRoute('cfgBodega_index');
    }

    /**
     * Creates a form to delete a cfgBodega entity.
     *
     * @param CfgBodega $cfgBodega The cfgBodega entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgBodega $cfgBodega)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgBodega_delete', array('id' => $cfgBodega->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="cfgbodega_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $cfgBodegas = $em->getRepository('AppBundle:CfgBodega')->findBy(
            array('estado' => 1)
        );

        $response = null;

        foreach ($cfgBodegas as $key => $cfgBodega) {
            $response[$key] = array(
                'value' => $cfgBodega->getId(),
                'label' => $cfgBodega->getNombre(),
            );
        }
        return $helpers->json($response);
    }

}
