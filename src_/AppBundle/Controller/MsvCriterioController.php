<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MsvCriterio;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Msvcriterio controller.
 *
 * @Route("msvcriterio")
 */
class MsvCriterioController extends Controller
{
    /**
     * Lists all msvCriterio entities.
     *
     * @Route("/", name="msvcriterio_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $msvCriterios = $em->getRepository('AppBundle:MsvCriterio')->findAll();

        return $this->render('msvcriterio/index.html.twig', array(
            'msvCriterios' => $msvCriterios,
        ));
    }

    /**
     * Creates a new msvCriterio entity.
     *
     * @Route("/new", name="msvcriterio_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $msvCriterio = new Msvcriterio();
        $form = $this->createForm('AppBundle\Form\MsvCriterioType', $msvCriterio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($msvCriterio);
            $em->flush();

            return $this->redirectToRoute('msvcriterio_show', array('id' => $msvCriterio->getId()));
        }

        return $this->render('msvcriterio/new.html.twig', array(
            'msvCriterio' => $msvCriterio,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a msvCriterio entity.
     *
     * @Route("/{id}", name="msvcriterio_show")
     * @Method("GET")
     */
    public function showAction(MsvCriterio $msvCriterio)
    {
        $deleteForm = $this->createDeleteForm($msvCriterio);

        return $this->render('msvcriterio/show.html.twig', array(
            'msvCriterio' => $msvCriterio,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing msvCriterio entity.
     *
     * @Route("/{id}/edit", name="msvcriterio_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MsvCriterio $msvCriterio)
    {
        $deleteForm = $this->createDeleteForm($msvCriterio);
        $editForm = $this->createForm('AppBundle\Form\MsvCriterioType', $msvCriterio);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('msvcriterio_edit', array('id' => $msvCriterio->getId()));
        }

        return $this->render('msvcriterio/edit.html.twig', array(
            'msvCriterio' => $msvCriterio,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a msvCriterio entity.
     *
     * @Route("/{id}", name="msvcriterio_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MsvCriterio $msvCriterio)
    {
        $form = $this->createDeleteForm($msvCriterio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($msvCriterio);
            $em->flush();
        }

        return $this->redirectToRoute('msvcriterio_index');
    }

    /**
     * Creates a form to delete a msvCriterio entity.
     *
     * @param MsvCriterio $msvCriterio The msvCriterio entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MsvCriterio $msvCriterio)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('msvcriterio_delete', array('id' => $msvCriterio->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
