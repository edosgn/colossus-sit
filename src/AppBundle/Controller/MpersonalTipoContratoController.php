<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MpersonalTipoContrato;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Mpersonaltipocontrato controller.
 *
 * @Route("mpersonaltipocontrato")
 */
class MpersonalTipoContratoController extends Controller
{
    /**
     * Lists all mpersonalTipoContrato entities.
     *
     * @Route("/", name="mpersonaltipocontrato_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $tiposContrato = $em->getRepository('AppBundle:MpersonalTipoContrato')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($tiposContrato) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => count($tiposContrato)." Registros encontrados", 
                'data'=> $tiposContrato,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new mpersonalTipoContrato entity.
     *
     * @Route("/new", name="mpersonaltipocontrato_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $mpersonalTipoContrato = new Mpersonaltipocontrato();
        $form = $this->createForm('AppBundle\Form\MpersonalTipoContratoType', $mpersonalTipoContrato);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mpersonalTipoContrato);
            $em->flush();

            return $this->redirectToRoute('mpersonaltipocontrato_show', array('id' => $mpersonalTipoContrato->getId()));
        }

        return $this->render('mpersonaltipocontrato/new.html.twig', array(
            'mpersonalTipoContrato' => $mpersonalTipoContrato,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a mpersonalTipoContrato entity.
     *
     * @Route("/{id}/show", name="mpersonaltipocontrato_show")
     * @Method("GET")
     */
    public function showAction(MpersonalTipoContrato $mpersonalTipoContrato)
    {
        $deleteForm = $this->createDeleteForm($mpersonalTipoContrato);

        return $this->render('mpersonaltipocontrato/show.html.twig', array(
            'mpersonalTipoContrato' => $mpersonalTipoContrato,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing mpersonalTipoContrato entity.
     *
     * @Route("/{id}/edit", name="mpersonaltipocontrato_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MpersonalTipoContrato $mpersonalTipoContrato)
    {
        $deleteForm = $this->createDeleteForm($mpersonalTipoContrato);
        $editForm = $this->createForm('AppBundle\Form\MpersonalTipoContratoType', $mpersonalTipoContrato);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mpersonaltipocontrato_edit', array('id' => $mpersonalTipoContrato->getId()));
        }

        return $this->render('mpersonaltipocontrato/edit.html.twig', array(
            'mpersonalTipoContrato' => $mpersonalTipoContrato,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a mpersonalTipoContrato entity.
     *
     * @Route("/{id}/delete", name="mpersonaltipocontrato_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MpersonalTipoContrato $mpersonalTipoContrato)
    {
        $form = $this->createDeleteForm($mpersonalTipoContrato);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mpersonalTipoContrato);
            $em->flush();
        }

        return $this->redirectToRoute('mpersonaltipocontrato_index');
    }

    /**
     * Creates a form to delete a mpersonalTipoContrato entity.
     *
     * @param MpersonalTipoContrato $mpersonalTipoContrato The mpersonalTipoContrato entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MpersonalTipoContrato $mpersonalTipoContrato)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mpersonaltipocontrato_delete', array('id' => $mpersonalTipoContrato->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="mpersonaltipocontrato_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $tiposContrato = $em->getRepository('AppBundle:MpersonalTipoContrato')->findBy(
            array('activo' => true)
        );

        foreach ($tiposContrato as $key => $tipoContrato) {
            $response[$key] = array(
                'value' => $tipoContrato->getId(),
                'label' => $tipoContrato->getNombre()
            );
        }
        return $helpers->json($response);
    }
}
