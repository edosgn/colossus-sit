<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvIpatImpresoAsignacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Svipatimpresoasignacion controller.
 *
 * @Route("svipatimpresoasignacion")
 */
class SvIpatImpresoAsignacionController extends Controller
{
    /**
     * Lists all svIpatImpresoAsignacion entities.
     *
     * @Route("/", name="svipatimpresoasignacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $svIpatImpresoAsignacions = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatImpresoAsignacion')->findAll();

        return $this->render('svipatimpresoasignacion/index.html.twig', array(
            'svIpatImpresoAsignacions' => $svIpatImpresoAsignacions,
        ));
    }

    /**
     * Creates a new svIpatImpresoAsignacion entity.
     *
     * @Route("/new", name="svipatimpresoasignacion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $svIpatImpresoAsignacion = new Svipatimpresoasignacion();
        $form = $this->createForm('JHWEB\SeguridadVialBundle\Form\SvIpatImpresoAsignacionType', $svIpatImpresoAsignacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($svIpatImpresoAsignacion);
            $em->flush();

            return $this->redirectToRoute('svipatimpresoasignacion_show', array('id' => $svIpatImpresoAsignacion->getId()));
        }

        return $this->render('svipatimpresoasignacion/new.html.twig', array(
            'svIpatImpresoAsignacion' => $svIpatImpresoAsignacion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a svIpatImpresoAsignacion entity.
     *
     * @Route("/{id}", name="svipatimpresoasignacion_show")
     * @Method("GET")
     */
    public function showAction(SvIpatImpresoAsignacion $svIpatImpresoAsignacion)
    {
        $deleteForm = $this->createDeleteForm($svIpatImpresoAsignacion);

        return $this->render('svipatimpresoasignacion/show.html.twig', array(
            'svIpatImpresoAsignacion' => $svIpatImpresoAsignacion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing svIpatImpresoAsignacion entity.
     *
     * @Route("/{id}/edit", name="svipatimpresoasignacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SvIpatImpresoAsignacion $svIpatImpresoAsignacion)
    {
        $deleteForm = $this->createDeleteForm($svIpatImpresoAsignacion);
        $editForm = $this->createForm('JHWEB\SeguridadVialBundle\Form\SvIpatImpresoAsignacionType', $svIpatImpresoAsignacion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('svipatimpresoasignacion_edit', array('id' => $svIpatImpresoAsignacion->getId()));
        }

        return $this->render('svipatimpresoasignacion/edit.html.twig', array(
            'svIpatImpresoAsignacion' => $svIpatImpresoAsignacion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a svIpatImpresoAsignacion entity.
     *
     * @Route("/{id}", name="svipatimpresoasignacion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SvIpatImpresoAsignacion $svIpatImpresoAsignacion)
    {
        $form = $this->createDeleteForm($svIpatImpresoAsignacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($svIpatImpresoAsignacion);
            $em->flush();
        }

        return $this->redirectToRoute('svipatimpresoasignacion_index');
    }

    /**
     * Creates a form to delete a svIpatImpresoAsignacion entity.
     *
     * @param SvIpatImpresoAsignacion $svIpatImpresoAsignacion The svIpatImpresoAsignacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvIpatImpresoAsignacion $svIpatImpresoAsignacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svipatimpresoasignacion_delete', array('id' => $svIpatImpresoAsignacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
