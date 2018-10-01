<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloMaquinaria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlomaquinarium controller.
 *
 * @Route("vhlomaquinaria")
 */
class VhloMaquinariaController extends Controller
{
    /**
     * Lists all vhloMaquinarium entities.
     *
     * @Route("/", name="vhlomaquinaria_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $vhloMaquinarias = $em->getRepository('JHWEBVehiculoBundle:VhloMaquinaria')->findAll();

        return $this->render('vhlomaquinaria/index.html.twig', array(
            'vhloMaquinarias' => $vhloMaquinarias,
        ));
    }

    /**
     * Creates a new vhloMaquinarium entity.
     *
     * @Route("/new", name="vhlomaquinaria_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $vhloMaquinarium = new Vhlomaquinarium();
        $form = $this->createForm('JHWEB\VehiculoBundle\Form\VhloMaquinariaType', $vhloMaquinarium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($vhloMaquinarium);
            $em->flush();

            return $this->redirectToRoute('vhlomaquinaria_show', array('id' => $vhloMaquinarium->getId()));
        }

        return $this->render('vhlomaquinaria/new.html.twig', array(
            'vhloMaquinarium' => $vhloMaquinarium,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a vhloMaquinarium entity.
     *
     * @Route("/{id}", name="vhlomaquinaria_show")
     * @Method("GET")
     */
    public function showAction(VhloMaquinaria $vhloMaquinarium)
    {
        $deleteForm = $this->createDeleteForm($vhloMaquinarium);

        return $this->render('vhlomaquinaria/show.html.twig', array(
            'vhloMaquinarium' => $vhloMaquinarium,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vhloMaquinarium entity.
     *
     * @Route("/{id}/edit", name="vhlomaquinaria_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, VhloMaquinaria $vhloMaquinarium)
    {
        $deleteForm = $this->createDeleteForm($vhloMaquinarium);
        $editForm = $this->createForm('JHWEB\VehiculoBundle\Form\VhloMaquinariaType', $vhloMaquinarium);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vhlomaquinaria_edit', array('id' => $vhloMaquinarium->getId()));
        }

        return $this->render('vhlomaquinaria/edit.html.twig', array(
            'vhloMaquinarium' => $vhloMaquinarium,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a vhloMaquinarium entity.
     *
     * @Route("/{id}", name="vhlomaquinaria_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, VhloMaquinaria $vhloMaquinarium)
    {
        $form = $this->createDeleteForm($vhloMaquinarium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vhloMaquinarium);
            $em->flush();
        }

        return $this->redirectToRoute('vhlomaquinaria_index');
    }

    /**
     * Creates a form to delete a vhloMaquinarium entity.
     *
     * @param VhloMaquinaria $vhloMaquinarium The vhloMaquinarium entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloMaquinaria $vhloMaquinarium)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhlomaquinaria_delete', array('id' => $vhloMaquinarium->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
