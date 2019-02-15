<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvSenialDemarcacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Svsenialdemarcacion controller.
 *
 * @Route("svsenialdemarcacion")
 */
class SvSenialDemarcacionController extends Controller
{
    /**
     * Lists all svSenialDemarcacion entities.
     *
     * @Route("/", name="svsenialdemarcacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $svSenialDemarcacions = $em->getRepository('JHWEBSeguridadVialBundle:SvSenialDemarcacion')->findAll();

        return $this->render('svsenialdemarcacion/index.html.twig', array(
            'svSenialDemarcacions' => $svSenialDemarcacions,
        ));
    }

    /**
     * Creates a new svSenialDemarcacion entity.
     *
     * @Route("/new", name="svsenialdemarcacion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $svSenialDemarcacion = new Svsenialdemarcacion();
        $form = $this->createForm('JHWEB\SeguridadVialBundle\Form\SvSenialDemarcacionType', $svSenialDemarcacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($svSenialDemarcacion);
            $em->flush();

            return $this->redirectToRoute('svsenialdemarcacion_show', array('id' => $svSenialDemarcacion->getId()));
        }

        return $this->render('svsenialdemarcacion/new.html.twig', array(
            'svSenialDemarcacion' => $svSenialDemarcacion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a svSenialDemarcacion entity.
     *
     * @Route("/{id}", name="svsenialdemarcacion_show")
     * @Method("GET")
     */
    public function showAction(SvSenialDemarcacion $svSenialDemarcacion)
    {
        $deleteForm = $this->createDeleteForm($svSenialDemarcacion);

        return $this->render('svsenialdemarcacion/show.html.twig', array(
            'svSenialDemarcacion' => $svSenialDemarcacion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing svSenialDemarcacion entity.
     *
     * @Route("/{id}/edit", name="svsenialdemarcacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SvSenialDemarcacion $svSenialDemarcacion)
    {
        $deleteForm = $this->createDeleteForm($svSenialDemarcacion);
        $editForm = $this->createForm('JHWEB\SeguridadVialBundle\Form\SvSenialDemarcacionType', $svSenialDemarcacion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('svsenialdemarcacion_edit', array('id' => $svSenialDemarcacion->getId()));
        }

        return $this->render('svsenialdemarcacion/edit.html.twig', array(
            'svSenialDemarcacion' => $svSenialDemarcacion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a svSenialDemarcacion entity.
     *
     * @Route("/{id}", name="svsenialdemarcacion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SvSenialDemarcacion $svSenialDemarcacion)
    {
        $form = $this->createDeleteForm($svSenialDemarcacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($svSenialDemarcacion);
            $em->flush();
        }

        return $this->redirectToRoute('svsenialdemarcacion_index');
    }

    /**
     * Creates a form to delete a svSenialDemarcacion entity.
     *
     * @param SvSenialDemarcacion $svSenialDemarcacion The svSenialDemarcacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvSenialDemarcacion $svSenialDemarcacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svsenialdemarcacion_delete', array('id' => $svSenialDemarcacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
