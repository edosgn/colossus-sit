<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Almacen;
use AppBundle\Form\AlmacenType;

/**
 * Almacen controller.
 *
 * @Route("/almacen")
 */
class AlmacenController extends Controller
{
    /**
     * Lists all Almacen entities.
     *
     * @Route("/", name="almacen_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $almacens = $em->getRepository('AppBundle:Almacen')->findAll();

        return $this->render('AppBundle:almacen:index.html.twig', array(
            'almacens' => $almacens,
        ));
    }

    /**
     * Creates a new Almacen entity.
     *
     * @Route("/new", name="almacen_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $almacen = new Almacen();
        $form = $this->createForm('AppBundle\Form\AlmacenType', $almacen);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($almacen);
            $em->flush();

            return $this->redirectToRoute('almacen_show', array('id' => $almacen->getId()));
        }

        return $this->render('AppBundle:almacen:new.html.twig', array(
            'almacen' => $almacen,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Almacen entity.
     *
     * @Route("/{id}", name="almacen_show")
     * @Method("GET")
     */
    public function showAction(Almacen $almacen)
    {
        $deleteForm = $this->createDeleteForm($almacen);

        return $this->render('AppBundle:almacen:show.html.twig', array(
            'almacen' => $almacen,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Almacen entity.
     *
     * @Route("/{id}/edit", name="almacen_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Almacen $almacen)
    {
        $deleteForm = $this->createDeleteForm($almacen);
        $editForm = $this->createForm('AppBundle\Form\AlmacenType', $almacen);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($almacen);
            $em->flush();

            return $this->redirectToRoute('almacen_edit', array('id' => $almacen->getId()));
        }

        return $this->render('AppBundle:almacen:edit.html.twig', array(
            'almacen' => $almacen,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Almacen entity.
     *
     * @Route("/{id}", name="almacen_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Almacen $almacen)
    {
        $form = $this->createDeleteForm($almacen);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($almacen);
            $em->flush();
        }

        return $this->redirectToRoute('almacen_index');
    }

    /**
     * Creates a form to delete a Almacen entity.
     *
     * @param Almacen $almacen The Almacen entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Almacen $almacen)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('almacen_delete', array('id' => $almacen->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
