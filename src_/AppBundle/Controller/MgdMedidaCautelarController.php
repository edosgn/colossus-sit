<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MgdMedidaCautelar;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Mgdmedidacautelar controller.
 *
 * @Route("mgdmedidacautelar")
 */
class MgdMedidaCautelarController extends Controller
{
    /**
     * Lists all mgdMedidaCautelar entities.
     *
     * @Route("/", name="mgdmedidacautelar_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $mgdMedidaCautelars = $em->getRepository('AppBundle:MgdMedidaCautelar')->findAll();

        return $this->render('mgdmedidacautelar/index.html.twig', array(
            'mgdMedidaCautelars' => $mgdMedidaCautelars,
        ));
    }

    /**
     * Creates a new mgdMedidaCautelar entity.
     *
     * @Route("/new", name="mgdmedidacautelar_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $mgdMedidaCautelar = new Mgdmedidacautelar();
        $form = $this->createForm('AppBundle\Form\MgdMedidaCautelarType', $mgdMedidaCautelar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mgdMedidaCautelar);
            $em->flush();

            return $this->redirectToRoute('mgdmedidacautelar_show', array('id' => $mgdMedidaCautelar->getId()));
        }

        return $this->render('mgdmedidacautelar/new.html.twig', array(
            'mgdMedidaCautelar' => $mgdMedidaCautelar,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a mgdMedidaCautelar entity.
     *
     * @Route("/{id}", name="mgdmedidacautelar_show")
     * @Method("GET")
     */
    public function showAction(MgdMedidaCautelar $mgdMedidaCautelar)
    {
        $deleteForm = $this->createDeleteForm($mgdMedidaCautelar);

        return $this->render('mgdmedidacautelar/show.html.twig', array(
            'mgdMedidaCautelar' => $mgdMedidaCautelar,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing mgdMedidaCautelar entity.
     *
     * @Route("/{id}/edit", name="mgdmedidacautelar_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MgdMedidaCautelar $mgdMedidaCautelar)
    {
        $deleteForm = $this->createDeleteForm($mgdMedidaCautelar);
        $editForm = $this->createForm('AppBundle\Form\MgdMedidaCautelarType', $mgdMedidaCautelar);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mgdmedidacautelar_edit', array('id' => $mgdMedidaCautelar->getId()));
        }

        return $this->render('mgdmedidacautelar/edit.html.twig', array(
            'mgdMedidaCautelar' => $mgdMedidaCautelar,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a mgdMedidaCautelar entity.
     *
     * @Route("/{id}", name="mgdmedidacautelar_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MgdMedidaCautelar $mgdMedidaCautelar)
    {
        $form = $this->createDeleteForm($mgdMedidaCautelar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mgdMedidaCautelar);
            $em->flush();
        }

        return $this->redirectToRoute('mgdmedidacautelar_index');
    }

    /**
     * Creates a form to delete a mgdMedidaCautelar entity.
     *
     * @param MgdMedidaCautelar $mgdMedidaCautelar The mgdMedidaCautelar entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MgdMedidaCautelar $mgdMedidaCautelar)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mgdmedidacautelar_delete', array('id' => $mgdMedidaCautelar->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
