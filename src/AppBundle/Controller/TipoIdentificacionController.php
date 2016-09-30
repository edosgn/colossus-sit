<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\TipoIdentificacion;
use AppBundle\Form\TipoIdentificacionType;

/**
 * TipoIdentificacion controller.
 *
 * @Route("/tipoidentificacion")
 */
class TipoIdentificacionController extends Controller
{
    /**
     * Lists all TipoIdentificacion entities.
     *
     * @Route("/", name="tipoidentificacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tipoIdentificacions = $em->getRepository('AppBundle:TipoIdentificacion')->findAll();

        return $this->render('AppBundle:TipoIdentificacion:index.html.twig', array(
            'tipoIdentificacions' => $tipoIdentificacions,
        ));
    }

    /**
     * Creates a new TipoIdentificacion entity.
     *
     * @Route("/new", name="tipoidentificacion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tipoIdentificacion = new TipoIdentificacion();
        $form = $this->createForm('AppBundle\Form\TipoIdentificacionType', $tipoIdentificacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tipoIdentificacion);
            $em->flush();

            return $this->redirectToRoute('tipoidentificacion_show', array('id' => $tipoIdentificacion->getId()));
        }

        return $this->render('AppBundle:TipoIdentificacion:new.html.twig', array(
            'tipoIdentificacion' => $tipoIdentificacion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TipoIdentificacion entity.
     *
     * @Route("/{id}", name="tipoidentificacion_show")
     * @Method("GET")
     */
    public function showAction(TipoIdentificacion $tipoIdentificacion)
    {
        $deleteForm = $this->createDeleteForm($tipoIdentificacion);

        return $this->render('AppBundle:TipoIdentificacion:show.html.twig', array(
            'tipoIdentificacion' => $tipoIdentificacion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TipoIdentificacion entity.
     *
     * @Route("/{id}/edit", name="tipoidentificacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TipoIdentificacion $tipoIdentificacion)
    {
        $deleteForm = $this->createDeleteForm($tipoIdentificacion);
        $editForm = $this->createForm('AppBundle\Form\TipoIdentificacionType', $tipoIdentificacion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tipoIdentificacion);
            $em->flush();

            return $this->redirectToRoute('tipoidentificacion_edit', array('id' => $tipoIdentificacion->getId()));
        }

        return $this->render('AppBundle:TipoIdentificacion:edit.html.twig', array(
            'tipoIdentificacion' => $tipoIdentificacion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TipoIdentificacion entity.
     *
     * @Route("/{id}", name="tipoidentificacion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TipoIdentificacion $tipoIdentificacion)
    {
        $form = $this->createDeleteForm($tipoIdentificacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tipoIdentificacion);
            $em->flush();
        }

        return $this->redirectToRoute('tipoidentificacion_index');
    }

    /**
     * Creates a form to delete a TipoIdentificacion entity.
     *
     * @param TipoIdentificacion $tipoIdentificacion The TipoIdentificacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TipoIdentificacion $tipoIdentificacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tipoidentificacion_delete', array('id' => $tipoIdentificacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
