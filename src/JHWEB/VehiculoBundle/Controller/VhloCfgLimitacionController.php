<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloCfgLimitacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlocfglimitacion controller.
 *
 * @Route("vhlocfglimitacion")
 */
class VhloCfgLimitacionController extends Controller
{
    /**
     * Lists all vhloCfgLimitacion entities.
     *
     * @Route("/", name="vhlocfglimitacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $vhloCfgLimitacions = $em->getRepository('JHWEBVehiculoBundle:VhloCfgLimitacion')->findAll();

        return $this->render('vhlocfglimitacion/index.html.twig', array(
            'vhloCfgLimitacions' => $vhloCfgLimitacions,
        ));
    }

    /**
     * Creates a new vhloCfgLimitacion entity.
     *
     * @Route("/new", name="vhlocfglimitacion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $vhloCfgLimitacion = new Vhlocfglimitacion();
        $form = $this->createForm('JHWEB\VehiculoBundle\Form\VhloCfgLimitacionType', $vhloCfgLimitacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($vhloCfgLimitacion);
            $em->flush();

            return $this->redirectToRoute('vhlocfglimitacion_show', array('id' => $vhloCfgLimitacion->getId()));
        }

        return $this->render('vhlocfglimitacion/new.html.twig', array(
            'vhloCfgLimitacion' => $vhloCfgLimitacion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a vhloCfgLimitacion entity.
     *
     * @Route("/{id}", name="vhlocfglimitacion_show")
     * @Method("GET")
     */
    public function showAction(VhloCfgLimitacion $vhloCfgLimitacion)
    {
        $deleteForm = $this->createDeleteForm($vhloCfgLimitacion);

        return $this->render('vhlocfglimitacion/show.html.twig', array(
            'vhloCfgLimitacion' => $vhloCfgLimitacion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vhloCfgLimitacion entity.
     *
     * @Route("/{id}/edit", name="vhlocfglimitacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, VhloCfgLimitacion $vhloCfgLimitacion)
    {
        $deleteForm = $this->createDeleteForm($vhloCfgLimitacion);
        $editForm = $this->createForm('JHWEB\VehiculoBundle\Form\VhloCfgLimitacionType', $vhloCfgLimitacion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vhlocfglimitacion_edit', array('id' => $vhloCfgLimitacion->getId()));
        }

        return $this->render('vhlocfglimitacion/edit.html.twig', array(
            'vhloCfgLimitacion' => $vhloCfgLimitacion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a vhloCfgLimitacion entity.
     *
     * @Route("/{id}", name="vhlocfglimitacion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, VhloCfgLimitacion $vhloCfgLimitacion)
    {
        $form = $this->createDeleteForm($vhloCfgLimitacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vhloCfgLimitacion);
            $em->flush();
        }

        return $this->redirectToRoute('vhlocfglimitacion_index');
    }

    /**
     * Creates a form to delete a vhloCfgLimitacion entity.
     *
     * @param VhloCfgLimitacion $vhloCfgLimitacion The vhloCfgLimitacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloCfgLimitacion $vhloCfgLimitacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhlocfglimitacion_delete', array('id' => $vhloCfgLimitacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
