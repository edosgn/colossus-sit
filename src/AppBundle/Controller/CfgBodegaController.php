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
     * @Route("/", name="cfgBodega_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cfgBodegas = $em->getRepository('AppBundle:CfgBodega')->findAll();

        return $this->render('cfgBodega/index.html.twig', array(
            'cfgBodegas' => $cfgBodegas,
        ));
    }

    /**
     * Creates a new cfgBodega entity.
     *
     * @Route("/new", name="cfgBodega_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $cfgBodega = new CfgBodega();
        $form = $this->createForm('AppBundle\Form\CfgBodegaType', $cfgBodega);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cfgBodega);
            $em->flush();

            return $this->redirectToRoute('cfgBodega_show', array('id' => $cfgBodega->getId()));
        }

        return $this->render('cfgBodega/new.html.twig', array(
            'cfgBodega' => $cfgBodega,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a cfgBodega entity.
     *
     * Route("/{id}", name="cfgBodega_show")
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
     * @Route("/{id}/edit", name="cfgBodega_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CfgBodega $cfgBodega)
    {
        $deleteForm = $this->createDeleteForm($cfgBodega);
        $editForm = $this->createForm('AppBundle\Form\CfgBodegaType', $cfgBodega);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cfgBodega_edit', array('id' => $cfgBodega->getId()));
        }

        return $this->render('cfgBodega/edit.html.twig', array(
            'cfgBodega' => $cfgBodega,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cfgBodega entity.
     *
     * @Route("/{id}", name="cfgBodega_delete")
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
     * @Route("/select", name="cfgBodega_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $cfgBodegas = $em->getRepository('AppBundle:CfgBodega')->findBy(
            array('estado' => 1)
        );
        foreach ($cfgBodegas as $key => $cfgBodega) {
            $response[$key] = array(
                'value' => $cfgBodega->getId(),
                'label' => $cfgBodega->getNombre(),
            );
        }
        return $helpers->json($response);
    }

}
