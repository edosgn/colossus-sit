<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MsvTConsecutivo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Msvtconsecutivo controller.
 *
 * @Route("msvtconsecutivo")
 */
class MsvTConsecutivoController extends Controller
{
    /**
     * Lists all msvTConsecutivo entities.
     *
     * @Route("/", name="msvtconsecutivo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $msvTConsecutivos = $em->getRepository('AppBundle:MsvTConsecutivo')->findAll();

        return $this->render('msvtconsecutivo/index.html.twig', array(
            'msvTConsecutivos' => $msvTConsecutivos,
        ));
    }

    /**
     * Creates a new msvTConsecutivo entity.
     *
     * @Route("/new", name="msvtconsecutivo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $msvTConsecutivo = new Msvtconsecutivo();
        $form = $this->createForm('AppBundle\Form\MsvTConsecutivoType', $msvTConsecutivo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($msvTConsecutivo);
            $em->flush();

            return $this->redirectToRoute('msvtconsecutivo_show', array('id' => $msvTConsecutivo->getId()));
        }

        return $this->render('msvtconsecutivo/new.html.twig', array(
            'msvTConsecutivo' => $msvTConsecutivo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a msvTConsecutivo entity.
     *
     * @Route("/{id}", name="msvtconsecutivo_show")
     * @Method("GET")
     */
    public function showAction(MsvTConsecutivo $msvTConsecutivo)
    {
        $deleteForm = $this->createDeleteForm($msvTConsecutivo);

        return $this->render('msvtconsecutivo/show.html.twig', array(
            'msvTConsecutivo' => $msvTConsecutivo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing msvTConsecutivo entity.
     *
     * @Route("/{id}/edit", name="msvtconsecutivo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MsvTConsecutivo $msvTConsecutivo)
    {
        $deleteForm = $this->createDeleteForm($msvTConsecutivo);
        $editForm = $this->createForm('AppBundle\Form\MsvTConsecutivoType', $msvTConsecutivo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('msvtconsecutivo_edit', array('id' => $msvTConsecutivo->getId()));
        }

        return $this->render('msvtconsecutivo/edit.html.twig', array(
            'msvTConsecutivo' => $msvTConsecutivo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a msvTConsecutivo entity.
     *
     * @Route("/{id}", name="msvtconsecutivo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MsvTConsecutivo $msvTConsecutivo)
    {
        $form = $this->createDeleteForm($msvTConsecutivo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($msvTConsecutivo);
            $em->flush();
        }

        return $this->redirectToRoute('msvtconsecutivo_index');
    }

    /**
     * Creates a form to delete a msvTConsecutivo entity.
     *
     * @param MsvTConsecutivo $msvTConsecutivo The msvTConsecutivo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MsvTConsecutivo $msvTConsecutivo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('msvtconsecutivo_delete', array('id' => $msvTConsecutivo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
