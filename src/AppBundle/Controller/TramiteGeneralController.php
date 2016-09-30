<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\TramiteGeneral;
use AppBundle\Form\TramiteGeneralType;

/**
 * TramiteGeneral controller.
 *
 * @Route("/tramitegeneral")
 */
class TramiteGeneralController extends Controller
{
    /**
     * Lists all TramiteGeneral entities.
     *
     * @Route("/", name="tramitegeneral_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tramiteGenerals = $em->getRepository('AppBundle:TramiteGeneral')->findAll();

        return $this->render('AppBundle:TramiteGeneral:index.html.twig', array(
            'tramiteGenerals' => $tramiteGenerals,
        ));
    }

    /**
     * Creates a new TramiteGeneral entity.
     *
     * @Route("/new", name="tramitegeneral_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tramiteGeneral = new TramiteGeneral();
        $form = $this->createForm('AppBundle\Form\TramiteGeneralType', $tramiteGeneral);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tramiteGeneral);
            $em->flush();

            return $this->redirectToRoute('tramitegeneral_show', array('id' => $tramiteGeneral->getId()));
        }

        return $this->render('AppBundle:TramiteGeneral:new.html.twig', array(
            'tramiteGeneral' => $tramiteGeneral,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TramiteGeneral entity.
     *
     * @Route("/{id}", name="tramitegeneral_show")
     * @Method("GET")
     */
    public function showAction(TramiteGeneral $tramiteGeneral)
    {
        $deleteForm = $this->createDeleteForm($tramiteGeneral);

        return $this->render('AppBundle:TramiteGeneral:show.html.twig', array(
            'tramiteGeneral' => $tramiteGeneral,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TramiteGeneral entity.
     *
     * @Route("/{id}/edit", name="tramitegeneral_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TramiteGeneral $tramiteGeneral)
    {
        $deleteForm = $this->createDeleteForm($tramiteGeneral);
        $editForm = $this->createForm('AppBundle\Form\TramiteGeneralType', $tramiteGeneral);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tramiteGeneral);
            $em->flush();

            return $this->redirectToRoute('tramitegeneral_edit', array('id' => $tramiteGeneral->getId()));
        }

        return $this->render('AppBundle:TramiteGeneral:edit.html.twig', array(
            'tramiteGeneral' => $tramiteGeneral,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TramiteGeneral entity.
     *
     * @Route("/{id}", name="tramitegeneral_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TramiteGeneral $tramiteGeneral)
    {
        $form = $this->createDeleteForm($tramiteGeneral);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tramiteGeneral);
            $em->flush();
        }

        return $this->redirectToRoute('tramitegeneral_index');
    }

    /**
     * Creates a form to delete a TramiteGeneral entity.
     *
     * @param TramiteGeneral $tramiteGeneral The TramiteGeneral entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TramiteGeneral $tramiteGeneral)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tramitegeneral_delete', array('id' => $tramiteGeneral->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
