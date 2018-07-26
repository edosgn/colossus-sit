<?php

namespace AppBundle\Controller;

use AppBundle\Entity\VehiculoRemolque;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Vehiculoremolque controller.
 *
 * @Route("vehiculoremolque")
 */
class VehiculoRemolqueController extends Controller
{
    /**
     * Lists all vehiculoRemolque entities.
     *
     * @Route("/", name="vehiculoremolque_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $vehiculoRemolques = $em->getRepository('AppBundle:VehiculoRemolque')->findAll();

        return $this->render('vehiculoremolque/index.html.twig', array(
            'vehiculoRemolques' => $vehiculoRemolques,
        ));
    }

    /**
     * Creates a new vehiculoRemolque entity.
     *
     * @Route("/new", name="vehiculoremolque_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $vehiculoRemolque = new Vehiculoremolque();
        $form = $this->createForm('AppBundle\Form\VehiculoRemolqueType', $vehiculoRemolque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($vehiculoRemolque);
            $em->flush();

            return $this->redirectToRoute('vehiculoremolque_show', array('id' => $vehiculoRemolque->getId()));
        }

        return $this->render('vehiculoremolque/new.html.twig', array(
            'vehiculoRemolque' => $vehiculoRemolque,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a vehiculoRemolque entity.
     *
     * @Route("/{id}", name="vehiculoremolque_show")
     * @Method("GET")
     */
    public function showAction(VehiculoRemolque $vehiculoRemolque)
    {
        $deleteForm = $this->createDeleteForm($vehiculoRemolque);

        return $this->render('vehiculoremolque/show.html.twig', array(
            'vehiculoRemolque' => $vehiculoRemolque,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vehiculoRemolque entity.
     *
     * @Route("/{id}/edit", name="vehiculoremolque_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, VehiculoRemolque $vehiculoRemolque)
    {
        $deleteForm = $this->createDeleteForm($vehiculoRemolque);
        $editForm = $this->createForm('AppBundle\Form\VehiculoRemolqueType', $vehiculoRemolque);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vehiculoremolque_edit', array('id' => $vehiculoRemolque->getId()));
        }

        return $this->render('vehiculoremolque/edit.html.twig', array(
            'vehiculoRemolque' => $vehiculoRemolque,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a vehiculoRemolque entity.
     *
     * @Route("/{id}", name="vehiculoremolque_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, VehiculoRemolque $vehiculoRemolque)
    {
        $form = $this->createDeleteForm($vehiculoRemolque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vehiculoRemolque);
            $em->flush();
        }

        return $this->redirectToRoute('vehiculoremolque_index');
    }

    /**
     * Creates a form to delete a vehiculoRemolque entity.
     *
     * @param VehiculoRemolque $vehiculoRemolque The vehiculoRemolque entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VehiculoRemolque $vehiculoRemolque)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vehiculoremolque_delete', array('id' => $vehiculoRemolque->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
