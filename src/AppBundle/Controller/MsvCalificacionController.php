<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MsvCalificacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Msvcalificacion controller.
 *
 * @Route("msvcalificacion")
 */
class MsvCalificacionController extends Controller
{
    /**
     * Lists all msvCalificacion entities.
     *
     * @Route("/", name="msvcalificacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $msvCalificacions = $em->getRepository('AppBundle:MsvCalificacion')->findAll();

        return $this->render('msvcalificacion/index.html.twig', array(
            'msvCalificacions' => $msvCalificacions,
        ));
    }

    /**
     * Creates a new msvCalificacion entity.
     *
     * @Route("/new", name="msvcalificacion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $msvCalificacion = new Msvcalificacion();
        $form = $this->createForm('AppBundle\Form\MsvCalificacionType', $msvCalificacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($msvCalificacion);
            $em->flush();

            return $this->redirectToRoute('msvcalificacion_show', array('id' => $msvCalificacion->getId()));
        }

        return $this->render('msvcalificacion/new.html.twig', array(
            'msvCalificacion' => $msvCalificacion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a msvCalificacion entity.
     *
     * @Route("/{id}", name="msvcalificacion_show")
     * @Method("GET")
     */
    public function showAction(MsvCalificacion $msvCalificacion)
    {
        $deleteForm = $this->createDeleteForm($msvCalificacion);

        return $this->render('msvcalificacion/show.html.twig', array(
            'msvCalificacion' => $msvCalificacion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing msvCalificacion entity.
     *
     * @Route("/{id}/edit", name="msvcalificacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MsvCalificacion $msvCalificacion)
    {
        $deleteForm = $this->createDeleteForm($msvCalificacion);
        $editForm = $this->createForm('AppBundle\Form\MsvCalificacionType', $msvCalificacion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('msvcalificacion_edit', array('id' => $msvCalificacion->getId()));
        }

        return $this->render('msvcalificacion/edit.html.twig', array(
            'msvCalificacion' => $msvCalificacion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a msvCalificacion entity.
     *
     * @Route("/{id}", name="msvcalificacion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MsvCalificacion $msvCalificacion)
    {
        $form = $this->createDeleteForm($msvCalificacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($msvCalificacion);
            $em->flush();
        }

        return $this->redirectToRoute('msvcalificacion_index');
    }

    /**
     * Creates a form to delete a msvCalificacion entity.
     *
     * @param MsvCalificacion $msvCalificacion The msvCalificacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MsvCalificacion $msvCalificacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('msvcalificacion_delete', array('id' => $msvCalificacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
