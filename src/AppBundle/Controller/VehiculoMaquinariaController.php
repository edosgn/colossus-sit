<?php

namespace AppBundle\Controller;

use AppBundle\Entity\VehiculoMaquinaria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Vehiculomaquinarium controller.
 *
 * @Route("vehiculomaquinaria")
 */
class VehiculoMaquinariaController extends Controller
{
    /**
     * Lists all vehiculoMaquinarium entities.
     *
     * @Route("/", name="vehiculomaquinaria_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $vehiculoMaquinarias = $em->getRepository('AppBundle:VehiculoMaquinaria')->findAll();

        return $this->render('vehiculomaquinaria/index.html.twig', array(
            'vehiculoMaquinarias' => $vehiculoMaquinarias,
        ));
    }

    /**
     * Creates a new vehiculoMaquinarium entity.
     *
     * @Route("/new", name="vehiculomaquinaria_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $vehiculoMaquinarium = new Vehiculomaquinarium();
        $form = $this->createForm('AppBundle\Form\VehiculoMaquinariaType', $vehiculoMaquinarium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($vehiculoMaquinarium);
            $em->flush();

            return $this->redirectToRoute('vehiculomaquinaria_show', array('id' => $vehiculoMaquinarium->getId()));
        }

        return $this->render('vehiculomaquinaria/new.html.twig', array(
            'vehiculoMaquinarium' => $vehiculoMaquinarium,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a vehiculoMaquinarium entity.
     *
     * @Route("/{id}", name="vehiculomaquinaria_show")
     * @Method("GET")
     */
    public function showAction(VehiculoMaquinaria $vehiculoMaquinarium)
    {
        $deleteForm = $this->createDeleteForm($vehiculoMaquinarium);

        return $this->render('vehiculomaquinaria/show.html.twig', array(
            'vehiculoMaquinarium' => $vehiculoMaquinarium,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vehiculoMaquinarium entity.
     *
     * @Route("/{id}/edit", name="vehiculomaquinaria_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, VehiculoMaquinaria $vehiculoMaquinarium)
    {
        $deleteForm = $this->createDeleteForm($vehiculoMaquinarium);
        $editForm = $this->createForm('AppBundle\Form\VehiculoMaquinariaType', $vehiculoMaquinarium);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vehiculomaquinaria_edit', array('id' => $vehiculoMaquinarium->getId()));
        }

        return $this->render('vehiculomaquinaria/edit.html.twig', array(
            'vehiculoMaquinarium' => $vehiculoMaquinarium,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a vehiculoMaquinarium entity.
     *
     * @Route("/{id}", name="vehiculomaquinaria_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, VehiculoMaquinaria $vehiculoMaquinarium)
    {
        $form = $this->createDeleteForm($vehiculoMaquinarium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vehiculoMaquinarium);
            $em->flush();
        }

        return $this->redirectToRoute('vehiculomaquinaria_index');
    }

    /**
     * Creates a form to delete a vehiculoMaquinarium entity.
     *
     * @param VehiculoMaquinaria $vehiculoMaquinarium The vehiculoMaquinarium entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VehiculoMaquinaria $vehiculoMaquinarium)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vehiculomaquinaria_delete', array('id' => $vehiculoMaquinarium->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
