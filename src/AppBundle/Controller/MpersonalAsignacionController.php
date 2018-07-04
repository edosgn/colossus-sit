<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MpersonalAsignacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Mpersonalasignacion controller.
 *
 * @Route("mpersonalasignacion")
 */
class MpersonalAsignacionController extends Controller
{
    /**
     * Lists all mpersonalAsignacion entities.
     *
     * @Route("/", name="mpersonalasignacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        $asignaciones = $em->getRepository('AppBundle:MpersonalAsignacion')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($asignaciones) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => count($asignaciones)." Registros encontrados", 
                'data'=> $asignaciones,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new mpersonalAsignacion entity.
     *
     * @Route("/new", name="mpersonalasignacion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $mpersonalAsignacion = new Mpersonalasignacion();
        $form = $this->createForm('AppBundle\Form\MpersonalAsignacionType', $mpersonalAsignacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mpersonalAsignacion);
            $em->flush();

            return $this->redirectToRoute('mpersonalasignacion_show', array('id' => $mpersonalAsignacion->getId()));
        }

        return $this->render('mpersonalasignacion/new.html.twig', array(
            'mpersonalAsignacion' => $mpersonalAsignacion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a mpersonalAsignacion entity.
     *
     * @Route("/{id}", name="mpersonalasignacion_show")
     * @Method("GET")
     */
    public function showAction(MpersonalAsignacion $mpersonalAsignacion)
    {
        $deleteForm = $this->createDeleteForm($mpersonalAsignacion);

        return $this->render('mpersonalasignacion/show.html.twig', array(
            'mpersonalAsignacion' => $mpersonalAsignacion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing mpersonalAsignacion entity.
     *
     * @Route("/{id}/edit", name="mpersonalasignacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MpersonalAsignacion $mpersonalAsignacion)
    {
        $deleteForm = $this->createDeleteForm($mpersonalAsignacion);
        $editForm = $this->createForm('AppBundle\Form\MpersonalAsignacionType', $mpersonalAsignacion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mpersonalasignacion_edit', array('id' => $mpersonalAsignacion->getId()));
        }

        return $this->render('mpersonalasignacion/edit.html.twig', array(
            'mpersonalAsignacion' => $mpersonalAsignacion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a mpersonalAsignacion entity.
     *
     * @Route("/{id}", name="mpersonalasignacion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MpersonalAsignacion $mpersonalAsignacion)
    {
        $form = $this->createDeleteForm($mpersonalAsignacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mpersonalAsignacion);
            $em->flush();
        }

        return $this->redirectToRoute('mpersonalasignacion_index');
    }

    /**
     * Creates a form to delete a mpersonalAsignacion entity.
     *
     * @param MpersonalAsignacion $mpersonalAsignacion The mpersonalAsignacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MpersonalAsignacion $mpersonalAsignacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mpersonalasignacion_delete', array('id' => $mpersonalAsignacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
