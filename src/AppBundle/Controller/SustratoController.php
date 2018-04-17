<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Sustrato;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Request;

/**
 * Sustrato controller.
 *
 * @Route("sustrato")
 */
class SustratoController extends Controller
{
    /**
     * Lists all sustrato entities.
     *
     * @Route("/", name="sustrato_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $sustratos = $em->getRepository('AppBundle:Sustrato')->findAll();

        $response = array(
            'status' => 'success',
            'code' => 200,
            'msj' => "Lista de sustratos",
            'data' => $sustratos, 
        );
        return $helpers->json($response);
    }

    /**
     * Creates a new sustrato entity.
     *
     * @Route("/new", name="sustrato_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $sustrato = new Sustrato();
        $form = $this->createForm('AppBundle\Form\SustratoType', $sustrato);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($sustrato);
            $em->flush();

            return $this->redirectToRoute('sustrato_show', array('id' => $sustrato->getId()));
        }

        return $this->render('sustrato/new.html.twig', array(
            'sustrato' => $sustrato,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a sustrato entity.
     *
     * @Route("/{id}", name="sustrato_show")
     * @Method("GET")
     */
    public function showAction(Sustrato $sustrato)
    {
        $deleteForm = $this->createDeleteForm($sustrato);

        return $this->render('sustrato/show.html.twig', array(
            'sustrato' => $sustrato,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing sustrato entity.
     *
     * @Route("/{id}/edit", name="sustrato_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Sustrato $sustrato)
    {
        $deleteForm = $this->createDeleteForm($sustrato);
        $editForm = $this->createForm('AppBundle\Form\SustratoType', $sustrato);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sustrato_edit', array('id' => $sustrato->getId()));
        }

        return $this->render('sustrato/edit.html.twig', array(
            'sustrato' => $sustrato,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a sustrato entity.
     *
     * @Route("/{id}", name="sustrato_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Sustrato $sustrato)
    {
        $form = $this->createDeleteForm($sustrato);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($sustrato);
            $em->flush();
        }

        return $this->redirectToRoute('sustrato_index');
    }

    /**
     * Creates a form to delete a sustrato entity.
     *
     * @param Sustrato $sustrato The sustrato entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Sustrato $sustrato)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('sustrato_delete', array('id' => $sustrato->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
