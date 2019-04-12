<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloCfgMotivoCancelacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlocfgmotivocancelacion controller.
 *
 * @Route("vhlocfgmotivocancelacion")
 */
class VhloCfgMotivoCancelacionController extends Controller
{
    /**
     * Lists all vhloCfgMotivoCancelacion entities.
     *
     * @Route("/", name="vhlocfgmotivocancelacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $vhloCfgMotivoCancelacions = $em->getRepository('JHWEBVehiculoBundle:VhloCfgMotivoCancelacion')->findAll();

        return $this->render('vhlocfgmotivocancelacion/index.html.twig', array(
            'vhloCfgMotivoCancelacions' => $vhloCfgMotivoCancelacions,
        ));
    }

    /**
     * Creates a new vhloCfgMotivoCancelacion entity.
     *
     * @Route("/new", name="vhlocfgmotivocancelacion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $vhloCfgMotivoCancelacion = new Vhlocfgmotivocancelacion();
        $form = $this->createForm('JHWEB\VehiculoBundle\Form\VhloCfgMotivoCancelacionType', $vhloCfgMotivoCancelacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($vhloCfgMotivoCancelacion);
            $em->flush();

            return $this->redirectToRoute('vhlocfgmotivocancelacion_show', array('id' => $vhloCfgMotivoCancelacion->getId()));
        }

        return $this->render('vhlocfgmotivocancelacion/new.html.twig', array(
            'vhloCfgMotivoCancelacion' => $vhloCfgMotivoCancelacion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a vhloCfgMotivoCancelacion entity.
     *
     * @Route("/{id}", name="vhlocfgmotivocancelacion_show")
     * @Method("GET")
     */
    public function showAction(VhloCfgMotivoCancelacion $vhloCfgMotivoCancelacion)
    {
        $deleteForm = $this->createDeleteForm($vhloCfgMotivoCancelacion);

        return $this->render('vhlocfgmotivocancelacion/show.html.twig', array(
            'vhloCfgMotivoCancelacion' => $vhloCfgMotivoCancelacion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vhloCfgMotivoCancelacion entity.
     *
     * @Route("/{id}/edit", name="vhlocfgmotivocancelacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, VhloCfgMotivoCancelacion $vhloCfgMotivoCancelacion)
    {
        $deleteForm = $this->createDeleteForm($vhloCfgMotivoCancelacion);
        $editForm = $this->createForm('JHWEB\VehiculoBundle\Form\VhloCfgMotivoCancelacionType', $vhloCfgMotivoCancelacion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vhlocfgmotivocancelacion_edit', array('id' => $vhloCfgMotivoCancelacion->getId()));
        }

        return $this->render('vhlocfgmotivocancelacion/edit.html.twig', array(
            'vhloCfgMotivoCancelacion' => $vhloCfgMotivoCancelacion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a vhloCfgMotivoCancelacion entity.
     *
     * @Route("/{id}", name="vhlocfgmotivocancelacion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, VhloCfgMotivoCancelacion $vhloCfgMotivoCancelacion)
    {
        $form = $this->createDeleteForm($vhloCfgMotivoCancelacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vhloCfgMotivoCancelacion);
            $em->flush();
        }

        return $this->redirectToRoute('vhlocfgmotivocancelacion_index');
    }

    /**
     * Creates a form to delete a vhloCfgMotivoCancelacion entity.
     *
     * @param VhloCfgMotivoCancelacion $vhloCfgMotivoCancelacion The vhloCfgMotivoCancelacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloCfgMotivoCancelacion $vhloCfgMotivoCancelacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhlocfgmotivocancelacion_delete', array('id' => $vhloCfgMotivoCancelacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
