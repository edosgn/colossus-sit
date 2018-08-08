<?php

namespace AppBundle\Controller;

use AppBundle\Entity\FacturaSustrato;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Facturasustrato controller.
 *
 * @Route("facturasustrato")
 */
class FacturaSustratoController extends Controller
{
    /**
     * Lists all facturaSustrato entities.
     *
     * @Route("/", name="facturasustrato_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $facturaSustratos = $em->getRepository('AppBundle:FacturaSustrato')->findAll();

        return $this->render('facturasustrato/index.html.twig', array(
            'facturaSustratos' => $facturaSustratos,
        ));
    }

    /**
     * Creates a new facturaSustrato entity.
     *
     * @Route("/new", name="facturasustrato_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $facturaSustrato = new Facturasustrato();
        $form = $this->createForm('AppBundle\Form\FacturaSustratoType', $facturaSustrato);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($facturaSustrato);
            $em->flush();

            return $this->redirectToRoute('facturasustrato_show', array('id' => $facturaSustrato->getId()));
        }

        return $this->render('facturasustrato/new.html.twig', array(
            'facturaSustrato' => $facturaSustrato,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a facturaSustrato entity.
     *
     * @Route("/{id}", name="facturasustrato_show")
     * @Method("GET")
     */
    public function showAction(FacturaSustrato $facturaSustrato)
    {
        $deleteForm = $this->createDeleteForm($facturaSustrato);

        return $this->render('facturasustrato/show.html.twig', array(
            'facturaSustrato' => $facturaSustrato,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing facturaSustrato entity.
     *
     * @Route("/{id}/edit", name="facturasustrato_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FacturaSustrato $facturaSustrato)
    {
        $deleteForm = $this->createDeleteForm($facturaSustrato);
        $editForm = $this->createForm('AppBundle\Form\FacturaSustratoType', $facturaSustrato);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('facturasustrato_edit', array('id' => $facturaSustrato->getId()));
        }

        return $this->render('facturasustrato/edit.html.twig', array(
            'facturaSustrato' => $facturaSustrato,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a facturaSustrato entity.
     *
     * @Route("/{id}", name="facturasustrato_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FacturaSustrato $facturaSustrato)
    {
        $form = $this->createDeleteForm($facturaSustrato);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($facturaSustrato);
            $em->flush();
        }

        return $this->redirectToRoute('facturasustrato_index');
    }

    /**
     * Creates a form to delete a facturaSustrato entity.
     *
     * @param FacturaSustrato $facturaSustrato The facturaSustrato entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FacturaSustrato $facturaSustrato)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('facturasustrato_delete', array('id' => $facturaSustrato->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
