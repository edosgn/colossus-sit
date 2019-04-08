<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvIpatAsignacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Svipatasignacion controller.
 *
 * @Route("svipatasignacion")
 */
class SvIpatAsignacionController extends Controller
{
    /**
     * Lists all svIpatAsignacion entities.
     *
     * @Route("/", name="svipatasignacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $svIpatAsignacions = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatAsignacion')->findAll();

        return $this->render('svipatasignacion/index.html.twig', array(
            'svIpatAsignacions' => $svIpatAsignacions,
        ));
    }

    /**
     * Creates a new svIpatAsignacion entity.
     *
     * @Route("/new", name="svipatasignacion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $svIpatAsignacion = new Svipatasignacion();
        $form = $this->createForm('JHWEB\SeguridadVialBundle\Form\SvIpatAsignacionType', $svIpatAsignacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($svIpatAsignacion);
            $em->flush();

            return $this->redirectToRoute('svipatasignacion_show', array('id' => $svIpatAsignacion->getId()));
        }

        return $this->render('svipatasignacion/new.html.twig', array(
            'svIpatAsignacion' => $svIpatAsignacion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a svIpatAsignacion entity.
     *
     * @Route("/{id}", name="svipatasignacion_show")
     * @Method("GET")
     */
    public function showAction(SvIpatAsignacion $svIpatAsignacion)
    {
        $deleteForm = $this->createDeleteForm($svIpatAsignacion);

        return $this->render('svipatasignacion/show.html.twig', array(
            'svIpatAsignacion' => $svIpatAsignacion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing svIpatAsignacion entity.
     *
     * @Route("/{id}/edit", name="svipatasignacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SvIpatAsignacion $svIpatAsignacion)
    {
        $deleteForm = $this->createDeleteForm($svIpatAsignacion);
        $editForm = $this->createForm('JHWEB\SeguridadVialBundle\Form\SvIpatAsignacionType', $svIpatAsignacion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('svipatasignacion_edit', array('id' => $svIpatAsignacion->getId()));
        }

        return $this->render('svipatasignacion/edit.html.twig', array(
            'svIpatAsignacion' => $svIpatAsignacion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a svIpatAsignacion entity.
     *
     * @Route("/{id}", name="svipatasignacion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SvIpatAsignacion $svIpatAsignacion)
    {
        $form = $this->createDeleteForm($svIpatAsignacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($svIpatAsignacion);
            $em->flush();
        }

        return $this->redirectToRoute('svipatasignacion_index');
    }

    /**
     * Creates a form to delete a svIpatAsignacion entity.
     *
     * @param SvIpatAsignacion $svIpatAsignacion The svIpatAsignacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvIpatAsignacion $svIpatAsignacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svipatasignacion_delete', array('id' => $svIpatAsignacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
