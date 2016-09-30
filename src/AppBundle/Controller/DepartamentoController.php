<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Departamento;
use AppBundle\Form\DepartamentoType;

/**
 * Departamento controller.
 *
 * @Route("/departamento")
 */
class DepartamentoController extends Controller
{
    /**
     * Lists all Departamento entities.
     *
     * @Route("/", name="departamento_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $departamentos = $em->getRepository('AppBundle:Departamento')->findAll();

        return $this->render('AppBundle:departamento:index.html.twig', array(
            'departamentos' => $departamentos,
        ));
    }

    /**
     * Creates a new Departamento entity.
     *
     * @Route("/new", name="departamento_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $departamento = new Departamento();
        $form = $this->createForm('AppBundle\Form\DepartamentoType', $departamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($departamento);
            $em->flush();

            return $this->redirectToRoute('departamento_show', array('id' => $departamento->getId()));
        }

        return $this->render('AppBundle:departamento:new.html.twig', array(
            'departamento' => $departamento,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Departamento entity.
     *
     * @Route("/{id}", name="departamento_show")
     * @Method("GET")
     */
    public function showAction(Departamento $departamento)
    {
        $deleteForm = $this->createDeleteForm($departamento);

        return $this->render('AppBundle:departamento:show.html.twig', array(
            'departamento' => $departamento,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Departamento entity.
     *
     * @Route("/{id}/edit", name="departamento_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Departamento $departamento)
    {
        $deleteForm = $this->createDeleteForm($departamento);
        $editForm = $this->createForm('AppBundle\Form\DepartamentoType', $departamento);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($departamento);
            $em->flush();

            return $this->redirectToRoute('departamento_edit', array('id' => $departamento->getId()));
        }

        return $this->render('AppBundle:departamento:edit.html.twig', array(
            'departamento' => $departamento,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Departamento entity.
     *
     * @Route("/{id}", name="departamento_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Departamento $departamento)
    {
        $form = $this->createDeleteForm($departamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($departamento);
            $em->flush();
        }

        return $this->redirectToRoute('departamento_index');
    }

    /**
     * Creates a form to delete a Departamento entity.
     *
     * @param Departamento $departamento The Departamento entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Departamento $departamento)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('departamento_delete', array('id' => $departamento->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
