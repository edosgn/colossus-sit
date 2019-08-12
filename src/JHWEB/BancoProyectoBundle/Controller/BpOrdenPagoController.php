<?php

namespace JHWEB\BancoProyectoBundle\Controller;

use JHWEB\BancoProyectoBundle\Entity\BpOrdenPago;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Bpordenpago controller.
 *
 * @Route("bpordenpago")
 */
class BpOrdenPagoController extends Controller
{
    /**
     * Lists all bpOrdenPago entities.
     *
     * @Route("/", name="bpordenpago_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $ordenes = $em->getRepository('JHWEBBancoProyectoBundle:BpOrdenPago')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($ordenes) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($ordenes)." registros encontrados", 
                'data'=> $ordenes,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new bpOrdenPago entity.
     *
     * @Route("/new", name="bpordenpago_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $bpOrdenPago = new Bpordenpago();
        $form = $this->createForm('JHWEB\BancoProyectoBundle\Form\BpOrdenPagoType', $bpOrdenPago);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($bpOrdenPago);
            $em->flush();

            return $this->redirectToRoute('bpordenpago_show', array('id' => $bpOrdenPago->getId()));
        }

        return $this->render('bpordenpago/new.html.twig', array(
            'bpOrdenPago' => $bpOrdenPago,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a bpOrdenPago entity.
     *
     * @Route("/{id}", name="bpordenpago_show")
     * @Method("GET")
     */
    public function showAction(BpOrdenPago $bpOrdenPago)
    {
        $deleteForm = $this->createDeleteForm($bpOrdenPago);

        return $this->render('bpordenpago/show.html.twig', array(
            'bpOrdenPago' => $bpOrdenPago,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing bpOrdenPago entity.
     *
     * @Route("/{id}/edit", name="bpordenpago_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, BpOrdenPago $bpOrdenPago)
    {
        $deleteForm = $this->createDeleteForm($bpOrdenPago);
        $editForm = $this->createForm('JHWEB\BancoProyectoBundle\Form\BpOrdenPagoType', $bpOrdenPago);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('bpordenpago_edit', array('id' => $bpOrdenPago->getId()));
        }

        return $this->render('bpordenpago/edit.html.twig', array(
            'bpOrdenPago' => $bpOrdenPago,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a bpOrdenPago entity.
     *
     * @Route("/{id}", name="bpordenpago_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, BpOrdenPago $bpOrdenPago)
    {
        $form = $this->createDeleteForm($bpOrdenPago);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($bpOrdenPago);
            $em->flush();
        }

        return $this->redirectToRoute('bpordenpago_index');
    }

    /**
     * Creates a form to delete a bpOrdenPago entity.
     *
     * @param BpOrdenPago $bpOrdenPago The bpOrdenPago entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BpOrdenPago $bpOrdenPago)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bpordenpago_delete', array('id' => $bpOrdenPago->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
