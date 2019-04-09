<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvIpatConsecutivo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svipatconsecutivo controller.
 *
 * @Route("svipatconsecutivo")
 */
class SvIpatConsecutivoController extends Controller
{
    /**
     * Lists all svIpatConsecutivo entities.
     *
     * @Route("/", name="svipatconsecutivo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $svIpatConsecutivos = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatConsecutivo')->findAll();

        return $this->render('svipatconsecutivo/index.html.twig', array(
            'svIpatConsecutivos' => $svIpatConsecutivos,
        ));
    }

    /**
     * Creates a new svIpatConsecutivo entity.
     *
     * @Route("/new", name="svipatconsecutivo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $svIpatConsecutivo = new Svipatconsecutivo();
        $form = $this->createForm('JHWEB\SeguridadVialBundle\Form\SvIpatConsecutivoType', $svIpatConsecutivo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($svIpatConsecutivo);
            $em->flush();

            return $this->redirectToRoute('svipatconsecutivo_show', array('id' => $svIpatConsecutivo->getId()));
        }

        return $this->render('svipatconsecutivo/new.html.twig', array(
            'svIpatConsecutivo' => $svIpatConsecutivo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a svIpatConsecutivo entity.
     *
     * @Route("/{id}", name="svipatconsecutivo_show")
     * @Method("GET")
     */
    public function showAction(SvIpatConsecutivo $svIpatConsecutivo)
    {
        $deleteForm = $this->createDeleteForm($svIpatConsecutivo);

        return $this->render('svipatconsecutivo/show.html.twig', array(
            'svIpatConsecutivo' => $svIpatConsecutivo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing svIpatConsecutivo entity.
     *
     * @Route("/{id}/edit", name="svipatconsecutivo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SvIpatConsecutivo $svIpatConsecutivo)
    {
        $deleteForm = $this->createDeleteForm($svIpatConsecutivo);
        $editForm = $this->createForm('JHWEB\SeguridadVialBundle\Form\SvIpatConsecutivoType', $svIpatConsecutivo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('svipatconsecutivo_edit', array('id' => $svIpatConsecutivo->getId()));
        }

        return $this->render('svipatconsecutivo/edit.html.twig', array(
            'svIpatConsecutivo' => $svIpatConsecutivo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a svIpatConsecutivo entity.
     *
     * @Route("/{id}", name="svipatconsecutivo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SvIpatConsecutivo $svIpatConsecutivo)
    {
        $form = $this->createDeleteForm($svIpatConsecutivo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($svIpatConsecutivo);
            $em->flush();
        }

        return $this->redirectToRoute('svipatconsecutivo_index');
    }

    /**
     * Creates a form to delete a svIpatConsecutivo entity.
     *
     * @param SvIpatConsecutivo $svIpatConsecutivo The svIpatConsecutivo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvIpatConsecutivo $svIpatConsecutivo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svipatconsecutivo_delete', array('id' => $svIpatConsecutivo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
