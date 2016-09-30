<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\TipoEmpresa;
use AppBundle\Form\TipoEmpresaType;

/**
 * TipoEmpresa controller.
 *
 * @Route("/tipoempresa")
 */
class TipoEmpresaController extends Controller
{
    /**
     * Lists all TipoEmpresa entities.
     *
     * @Route("/", name="tipoempresa_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tipoEmpresas = $em->getRepository('AppBundle:TipoEmpresa')->findAll();

        return $this->render('AppBundle:TipoEmpresa:index.html.twig', array(
            'tipoEmpresas' => $tipoEmpresas,
        ));
    }

    /**
     * Creates a new TipoEmpresa entity.
     *
     * @Route("/new", name="tipoempresa_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tipoEmpresa = new TipoEmpresa();
        $form = $this->createForm('AppBundle\Form\TipoEmpresaType', $tipoEmpresa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tipoEmpresa);
            $em->flush();

            return $this->redirectToRoute('tipoempresa_show', array('id' => $tipoEmpresa->getId()));
        }

        return $this->render('AppBundle:TipoEmpresa:new.html.twig', array(
            'tipoEmpresa' => $tipoEmpresa,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TipoEmpresa entity.
     *
     * @Route("/{id}", name="tipoempresa_show")
     * @Method("GET")
     */
    public function showAction(TipoEmpresa $tipoEmpresa)
    {
        $deleteForm = $this->createDeleteForm($tipoEmpresa);

        return $this->render('AppBundle:TipoEmpresa:show.html.twig', array(
            'tipoEmpresa' => $tipoEmpresa,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TipoEmpresa entity.
     *
     * @Route("/{id}/edit", name="tipoempresa_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TipoEmpresa $tipoEmpresa)
    {
        $deleteForm = $this->createDeleteForm($tipoEmpresa);
        $editForm = $this->createForm('AppBundle\Form\TipoEmpresaType', $tipoEmpresa);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tipoEmpresa);
            $em->flush();

            return $this->redirectToRoute('tipoempresa_edit', array('id' => $tipoEmpresa->getId()));
        }

        return $this->render('AppBundle:TipoEmpresa:edit.html.twig', array(
            'tipoEmpresa' => $tipoEmpresa,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TipoEmpresa entity.
     *
     * @Route("/{id}", name="tipoempresa_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TipoEmpresa $tipoEmpresa)
    {
        $form = $this->createDeleteForm($tipoEmpresa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tipoEmpresa);
            $em->flush();
        }

        return $this->redirectToRoute('tipoempresa_index');
    }

    /**
     * Creates a form to delete a TipoEmpresa entity.
     *
     * @param TipoEmpresa $tipoEmpresa The TipoEmpresa entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TipoEmpresa $tipoEmpresa)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tipoempresa_delete', array('id' => $tipoEmpresa->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
