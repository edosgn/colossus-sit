<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloRemolque;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Vhloremolque controller.
 *
 * @Route("vhloremolque")
 */
class VhloRemolqueController extends Controller
{
    /**
     * Lists all vhloRemolque entities.
     *
     * @Route("/", name="vhloremolque_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $vhloRemolques = $em->getRepository('JHWEBVehiculoBundle:VhloRemolque')->findAll();

        return $this->render('vhloremolque/index.html.twig', array(
            'vhloRemolques' => $vhloRemolques,
        ));
    }

    /**
     * Creates a new vhloRemolque entity.
     *
     * @Route("/new", name="vhloremolque_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $vhloRemolque = new Vhloremolque();
        $form = $this->createForm('JHWEB\VehiculoBundle\Form\VhloRemolqueType', $vhloRemolque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($vhloRemolque);
            $em->flush();

            return $this->redirectToRoute('vhloremolque_show', array('id' => $vhloRemolque->getId()));
        }

        return $this->render('vhloremolque/new.html.twig', array(
            'vhloRemolque' => $vhloRemolque,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a vhloRemolque entity.
     *
     * @Route("/{id}", name="vhloremolque_show")
     * @Method("GET")
     */
    public function showAction(VhloRemolque $vhloRemolque)
    {
        $deleteForm = $this->createDeleteForm($vhloRemolque);

        return $this->render('vhloremolque/show.html.twig', array(
            'vhloRemolque' => $vhloRemolque,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vhloRemolque entity.
     *
     * @Route("/{id}/edit", name="vhloremolque_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, VhloRemolque $vhloRemolque)
    {
        $deleteForm = $this->createDeleteForm($vhloRemolque);
        $editForm = $this->createForm('JHWEB\VehiculoBundle\Form\VhloRemolqueType', $vhloRemolque);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vhloremolque_edit', array('id' => $vhloRemolque->getId()));
        }

        return $this->render('vhloremolque/edit.html.twig', array(
            'vhloRemolque' => $vhloRemolque,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a vhloRemolque entity.
     *
     * @Route("/{id}", name="vhloremolque_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, VhloRemolque $vhloRemolque)
    {
        $form = $this->createDeleteForm($vhloRemolque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vhloRemolque);
            $em->flush();
        }

        return $this->redirectToRoute('vhloremolque_index');
    }

    /**
     * Creates a form to delete a vhloRemolque entity.
     *
     * @param VhloRemolque $vhloRemolque The vhloRemolque entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloRemolque $vhloRemolque)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhloremolque_delete', array('id' => $vhloRemolque->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
