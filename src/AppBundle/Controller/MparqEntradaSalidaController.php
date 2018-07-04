<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MparqEntradaSalida;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Mparqentradasalida controller.
 *
 * @Route("mparqentradasalida")
 */
class MparqEntradaSalidaController extends Controller
{
    /**
     * Lists all mparqEntradaSalida entities.
     *
     * @Route("/", name="mparqentradasalida_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $entradasSalidas = $em->getRepository('AppBundle:MparqEntradaSalida')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($entradasSalidas) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => count($entradasSalidas)." Registros encontrados", 
                'data'=> $entradasSalidas,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new mparqEntradaSalida entity.
     *
     * @Route("/new", name="mparqentradasalida_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $mparqEntradaSalida = new Mparqentradasalida();
        $form = $this->createForm('AppBundle\Form\MparqEntradaSalidaType', $mparqEntradaSalida);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mparqEntradaSalida);
            $em->flush();

            return $this->redirectToRoute('mparqentradasalida_show', array('id' => $mparqEntradaSalida->getId()));
        }

        return $this->render('mparqentradasalida/new.html.twig', array(
            'mparqEntradaSalida' => $mparqEntradaSalida,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a mparqEntradaSalida entity.
     *
     * @Route("/{id}", name="mparqentradasalida_show")
     * @Method("GET")
     */
    public function showAction(MparqEntradaSalida $mparqEntradaSalida)
    {
        $deleteForm = $this->createDeleteForm($mparqEntradaSalida);

        return $this->render('mparqentradasalida/show.html.twig', array(
            'mparqEntradaSalida' => $mparqEntradaSalida,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing mparqEntradaSalida entity.
     *
     * @Route("/{id}/edit", name="mparqentradasalida_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MparqEntradaSalida $mparqEntradaSalida)
    {
        $deleteForm = $this->createDeleteForm($mparqEntradaSalida);
        $editForm = $this->createForm('AppBundle\Form\MparqEntradaSalidaType', $mparqEntradaSalida);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mparqentradasalida_edit', array('id' => $mparqEntradaSalida->getId()));
        }

        return $this->render('mparqentradasalida/edit.html.twig', array(
            'mparqEntradaSalida' => $mparqEntradaSalida,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a mparqEntradaSalida entity.
     *
     * @Route("/{id}", name="mparqentradasalida_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MparqEntradaSalida $mparqEntradaSalida)
    {
        $form = $this->createDeleteForm($mparqEntradaSalida);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mparqEntradaSalida);
            $em->flush();
        }

        return $this->redirectToRoute('mparqentradasalida_index');
    }

    /**
     * Creates a form to delete a mparqEntradaSalida entity.
     *
     * @param MparqEntradaSalida $mparqEntradaSalida The mparqEntradaSalida entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MparqEntradaSalida $mparqEntradaSalida)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mparqentradasalida_delete', array('id' => $mparqEntradaSalida->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
