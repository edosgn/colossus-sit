<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Variante;
use AppBundle\Form\VarianteType;

/**
 * Variante controller.
 *
 * @Route("/variante")
 */
class VarianteController extends Controller
{
    /**
     * Lists all Variante entities.
     *
     * @Route("/", name="variante_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $variantes = $em->getRepository('AppBundle:Variante')->findAll();

        return $this->render('AppBundle:Variante:index.html.twig', array(
            'variantes' => $variantes,
        ));
    }

    /**
     * Creates a new Variante entity.
     *
     * @Route("/new", name="variante_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $variante = new Variante();
        $form = $this->createForm('AppBundle\Form\VarianteType', $variante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($variante);
            $em->flush();

            return $this->redirectToRoute('variante_show', array('id' => $variante->getId()));
        }

        return $this->render('AppBundle:Variante:new.html.twig', array(
            'variante' => $variante,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Variante entity.
     *
     * @Route("/{id}", name="variante_show")
     * @Method("GET")
     */
    public function showAction(Variante $variante)
    {
        $deleteForm = $this->createDeleteForm($variante);

        return $this->render('AppBundle:Variante:show.html.twig', array(
            'variante' => $variante,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Variante entity.
     *
     * @Route("/{id}/edit", name="variante_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Variante $variante)
    {
        $deleteForm = $this->createDeleteForm($variante);
        $editForm = $this->createForm('AppBundle\Form\VarianteType', $variante);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($variante);
            $em->flush();

            return $this->redirectToRoute('variante_edit', array('id' => $variante->getId()));
        }

        return $this->render('AppBundle:Variante:edit.html.twig', array(
            'variante' => $variante,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Variante entity.
     *
     * @Route("/{id}", name="variante_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Variante $variante)
    {
        $form = $this->createDeleteForm($variante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($variante);
            $em->flush();
        }

        return $this->redirectToRoute('variante_index');
    }

    /**
     * Creates a form to delete a Variante entity.
     *
     * @param Variante $variante The Variante entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Variante $variante)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('variante_delete', array('id' => $variante->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
