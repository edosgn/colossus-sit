<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvIpatImpresoBodega;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Svipatimpresobodega controller.
 *
 * @Route("svipatimpresobodega")
 */
class SvIpatImpresoBodegaController extends Controller
{
    /**
     * Lists all svIpatImpresoBodega entities.
     *
     * @Route("/", name="svipatimpresobodega_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $svIpatImpresoBodegas = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatImpresoBodega')->findAll();

        return $this->render('svipatimpresobodega/index.html.twig', array(
            'svIpatImpresoBodegas' => $svIpatImpresoBodegas,
        ));
    }

    /**
     * Creates a new svIpatImpresoBodega entity.
     *
     * @Route("/new", name="svipatimpresobodega_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $svIpatImpresoBodega = new Svipatimpresobodega();
        $form = $this->createForm('JHWEB\SeguridadVialBundle\Form\SvIpatImpresoBodegaType', $svIpatImpresoBodega);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($svIpatImpresoBodega);
            $em->flush();

            return $this->redirectToRoute('svipatimpresobodega_show', array('id' => $svIpatImpresoBodega->getId()));
        }

        return $this->render('svipatimpresobodega/new.html.twig', array(
            'svIpatImpresoBodega' => $svIpatImpresoBodega,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a svIpatImpresoBodega entity.
     *
     * @Route("/{id}", name="svipatimpresobodega_show")
     * @Method("GET")
     */
    public function showAction(SvIpatImpresoBodega $svIpatImpresoBodega)
    {
        $deleteForm = $this->createDeleteForm($svIpatImpresoBodega);

        return $this->render('svipatimpresobodega/show.html.twig', array(
            'svIpatImpresoBodega' => $svIpatImpresoBodega,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing svIpatImpresoBodega entity.
     *
     * @Route("/{id}/edit", name="svipatimpresobodega_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SvIpatImpresoBodega $svIpatImpresoBodega)
    {
        $deleteForm = $this->createDeleteForm($svIpatImpresoBodega);
        $editForm = $this->createForm('JHWEB\SeguridadVialBundle\Form\SvIpatImpresoBodegaType', $svIpatImpresoBodega);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('svipatimpresobodega_edit', array('id' => $svIpatImpresoBodega->getId()));
        }

        return $this->render('svipatimpresobodega/edit.html.twig', array(
            'svIpatImpresoBodega' => $svIpatImpresoBodega,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a svIpatImpresoBodega entity.
     *
     * @Route("/{id}", name="svipatimpresobodega_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SvIpatImpresoBodega $svIpatImpresoBodega)
    {
        $form = $this->createDeleteForm($svIpatImpresoBodega);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($svIpatImpresoBodega);
            $em->flush();
        }

        return $this->redirectToRoute('svipatimpresobodega_index');
    }

    /**
     * Creates a form to delete a svIpatImpresoBodega entity.
     *
     * @param SvIpatImpresoBodega $svIpatImpresoBodega The svIpatImpresoBodega entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvIpatImpresoBodega $svIpatImpresoBodega)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svipatimpresobodega_delete', array('id' => $svIpatImpresoBodega->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
