<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CfgFestivo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cfgfestivo controller.
 *
 * @Route("cfgfestivo")
 */
class CfgFestivoController extends Controller
{
    /**
     * Lists all cfgFestivo entities.
     *
     * @Route("/", name="cfgfestivo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cfgFestivos = $em->getRepository('AppBundle:CfgFestivo')->findAll();

        return $this->render('cfgfestivo/index.html.twig', array(
            'cfgFestivos' => $cfgFestivos,
        ));
    }

    /**
     * Creates a new cfgFestivo entity.
     *
     * @Route("/new", name="cfgfestivo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $cfgFestivo = new Cfgfestivo();
        $form = $this->createForm('AppBundle\Form\CfgFestivoType', $cfgFestivo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cfgFestivo);
            $em->flush();

            return $this->redirectToRoute('cfgfestivo_show', array('id' => $cfgFestivo->getId()));
        }

        return $this->render('cfgfestivo/new.html.twig', array(
            'cfgFestivo' => $cfgFestivo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a cfgFestivo entity.
     *
     * @Route("/{id}", name="cfgfestivo_show")
     * @Method("GET")
     */
    public function showAction(CfgFestivo $cfgFestivo)
    {
        $deleteForm = $this->createDeleteForm($cfgFestivo);

        return $this->render('cfgfestivo/show.html.twig', array(
            'cfgFestivo' => $cfgFestivo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cfgFestivo entity.
     *
     * @Route("/{id}/edit", name="cfgfestivo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CfgFestivo $cfgFestivo)
    {
        $deleteForm = $this->createDeleteForm($cfgFestivo);
        $editForm = $this->createForm('AppBundle\Form\CfgFestivoType', $cfgFestivo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cfgfestivo_edit', array('id' => $cfgFestivo->getId()));
        }

        return $this->render('cfgfestivo/edit.html.twig', array(
            'cfgFestivo' => $cfgFestivo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cfgFestivo entity.
     *
     * @Route("/{id}", name="cfgfestivo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CfgFestivo $cfgFestivo)
    {
        $form = $this->createDeleteForm($cfgFestivo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cfgFestivo);
            $em->flush();
        }

        return $this->redirectToRoute('cfgfestivo_index');
    }

    /**
     * Creates a form to delete a cfgFestivo entity.
     *
     * @param CfgFestivo $cfgFestivo The cfgFestivo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgFestivo $cfgFestivo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgfestivo_delete', array('id' => $cfgFestivo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
