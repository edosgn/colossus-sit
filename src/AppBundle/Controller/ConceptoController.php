<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Concepto;
use AppBundle\Form\ConceptoType;

/**
 * Concepto controller.
 *
 * @Route("/concepto")
 */
class ConceptoController extends Controller
{
    /**
     * Lists all Concepto entities.
     *
     * @Route("/", name="concepto_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $conceptos = $em->getRepository('AppBundle:Concepto')->findAll();

        return $this->render('AppBundle:concepto:index.html.twig', array(
            'conceptos' => $conceptos,
        ));
    }

    /**
     * Creates a new Concepto entity.
     *
     * @Route("/new", name="concepto_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $concepto = new Concepto();
        $form = $this->createForm('AppBundle\Form\ConceptoType', $concepto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($concepto);
            $em->flush();

            return $this->redirectToRoute('concepto_show', array('id' => $concepto->getId()));
        }

        return $this->render('AppBundle:concepto:new.html.twig', array(
            'concepto' => $concepto,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Concepto entity.
     *
     * @Route("/{id}", name="concepto_show")
     * @Method("GET")
     */
    public function showAction(Concepto $concepto)
    {
        $deleteForm = $this->createDeleteForm($concepto);

        return $this->render('AppBundle:concepto:show.html.twig', array(
            'concepto' => $concepto,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Concepto entity.
     *
     * @Route("/{id}/edit", name="concepto_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Concepto $concepto)
    {
        $deleteForm = $this->createDeleteForm($concepto);
        $editForm = $this->createForm('AppBundle\Form\ConceptoType', $concepto);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($concepto);
            $em->flush();

            return $this->redirectToRoute('concepto_edit', array('id' => $concepto->getId()));
        }

        return $this->render('AppBundle:concepto:edit.html.twig', array(
            'concepto' => $concepto,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Concepto entity.
     *
     * @Route("/{id}", name="concepto_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Concepto $concepto)
    {
        $form = $this->createDeleteForm($concepto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($concepto);
            $em->flush();
        }

        return $this->redirectToRoute('concepto_index');
    }

    /**
     * Creates a form to delete a Concepto entity.
     *
     * @param Concepto $concepto The Concepto entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Concepto $concepto)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('concepto_delete', array('id' => $concepto->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
