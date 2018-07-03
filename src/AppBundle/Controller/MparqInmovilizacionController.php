<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MparqInmovilizacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Mparqinmovilizacion controller.
 *
 * @Route("mparqinmovilizacion")
 */
class MparqInmovilizacionController extends Controller
{
    /**
     * Lists all mparqInmovilizacion entities.
     *
     * @Route("/", name="mparqinmovilizacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $inmovilizaciones = $em->getRepository('AppBundle:MparqInmovilizacion')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($inmovilizaciones) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => count($inmovilizaciones)." Registros encontrados", 
                'data'=> $inmovilizaciones,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new mparqInmovilizacion entity.
     *
     * @Route("/new", name="mparqinmovilizacion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $mparqInmovilizacion = new Mparqinmovilizacion();
        $form = $this->createForm('AppBundle\Form\MparqInmovilizacionType', $mparqInmovilizacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mparqInmovilizacion);
            $em->flush();

            return $this->redirectToRoute('mparqinmovilizacion_show', array('id' => $mparqInmovilizacion->getId()));
        }

        return $this->render('mparqinmovilizacion/new.html.twig', array(
            'mparqInmovilizacion' => $mparqInmovilizacion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a mparqInmovilizacion entity.
     *
     * @Route("/{id}", name="mparqinmovilizacion_show")
     * @Method("GET")
     */
    public function showAction(MparqInmovilizacion $mparqInmovilizacion)
    {
        $deleteForm = $this->createDeleteForm($mparqInmovilizacion);

        return $this->render('mparqinmovilizacion/show.html.twig', array(
            'mparqInmovilizacion' => $mparqInmovilizacion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing mparqInmovilizacion entity.
     *
     * @Route("/{id}/edit", name="mparqinmovilizacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MparqInmovilizacion $mparqInmovilizacion)
    {
        $deleteForm = $this->createDeleteForm($mparqInmovilizacion);
        $editForm = $this->createForm('AppBundle\Form\MparqInmovilizacionType', $mparqInmovilizacion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mparqinmovilizacion_edit', array('id' => $mparqInmovilizacion->getId()));
        }

        return $this->render('mparqinmovilizacion/edit.html.twig', array(
            'mparqInmovilizacion' => $mparqInmovilizacion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a mparqInmovilizacion entity.
     *
     * @Route("/{id}", name="mparqinmovilizacion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MparqInmovilizacion $mparqInmovilizacion)
    {
        $form = $this->createDeleteForm($mparqInmovilizacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mparqInmovilizacion);
            $em->flush();
        }

        return $this->redirectToRoute('mparqinmovilizacion_index');
    }

    /**
     * Creates a form to delete a mparqInmovilizacion entity.
     *
     * @param MparqInmovilizacion $mparqInmovilizacion The mparqInmovilizacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MparqInmovilizacion $mparqInmovilizacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mparqinmovilizacion_delete', array('id' => $mparqInmovilizacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
