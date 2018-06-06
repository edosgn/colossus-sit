<?php

namespace AppBundle\Controller;

use AppBundle\Entity\RepresentanteEmpresa;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Representanteempresa controller.
 *
 * @Route("representanteempresa")
 */
class RepresentanteEmpresaController extends Controller
{
    /**
     * Lists all representanteEmpresa entities.
     *
     * @Route("/", name="representanteempresa_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $representanteEmpresas = $em->getRepository('AppBundle:RepresentanteEmpresa')->findAll();

        return $this->render('representanteempresa/index.html.twig', array(
            'representanteEmpresas' => $representanteEmpresas,
        ));
    }

    /**
     * Creates a new representanteEmpresa entity.
     *
     * @Route("/new", name="representanteempresa_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $representanteEmpresa = new Representanteempresa();
        $form = $this->createForm('AppBundle\Form\RepresentanteEmpresaType', $representanteEmpresa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($representanteEmpresa);
            $em->flush();

            return $this->redirectToRoute('representanteempresa_show', array('id' => $representanteEmpresa->getId()));
        }

        return $this->render('representanteempresa/new.html.twig', array(
            'representanteEmpresa' => $representanteEmpresa,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a representanteEmpresa entity.
     *
     * @Route("/{id}", name="representanteempresa_show")
     * @Method("GET")
     */
    public function showAction(RepresentanteEmpresa $representanteEmpresa)
    {
        $deleteForm = $this->createDeleteForm($representanteEmpresa);

        return $this->render('representanteempresa/show.html.twig', array(
            'representanteEmpresa' => $representanteEmpresa,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing representanteEmpresa entity.
     *
     * @Route("/{id}/edit", name="representanteempresa_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, RepresentanteEmpresa $representanteEmpresa)
    {
        $deleteForm = $this->createDeleteForm($representanteEmpresa);
        $editForm = $this->createForm('AppBundle\Form\RepresentanteEmpresaType', $representanteEmpresa);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('representanteempresa_edit', array('id' => $representanteEmpresa->getId()));
        }

        return $this->render('representanteempresa/edit.html.twig', array(
            'representanteEmpresa' => $representanteEmpresa,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a representanteEmpresa entity.
     *
     * @Route("/{id}", name="representanteempresa_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, RepresentanteEmpresa $representanteEmpresa)
    {
        $form = $this->createDeleteForm($representanteEmpresa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($representanteEmpresa);
            $em->flush();
        }

        return $this->redirectToRoute('representanteempresa_index');
    }

    /**
     * Creates a form to delete a representanteEmpresa entity.
     *
     * @param RepresentanteEmpresa $representanteEmpresa The representanteEmpresa entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(RepresentanteEmpresa $representanteEmpresa)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('representanteempresa_delete', array('id' => $representanteEmpresa->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
