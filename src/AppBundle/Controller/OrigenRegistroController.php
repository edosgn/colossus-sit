<?php

namespace AppBundle\Controller;

use AppBundle\Entity\OrigenRegistro;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Origenregistro controller.
 *
 * @Route("origenregistro")
 */
class OrigenRegistroController extends Controller
{
    /**
     * Lists all origenRegistro entities.
     *
     * @Route("/", name="origenregistro_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $origenRegistros = $em->getRepository('AppBundle:OrigenRegistro')->findAll();

        return $this->render('origenregistro/index.html.twig', array(
            'origenRegistros' => $origenRegistros,
        ));
    }

    /**
     * Creates a new origenRegistro entity.
     *
     * @Route("/new", name="origenregistro_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $origenRegistro = new Origenregistro();
        $form = $this->createForm('AppBundle\Form\OrigenRegistroType', $origenRegistro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($origenRegistro);
            $em->flush();

            return $this->redirectToRoute('origenregistro_show', array('id' => $origenRegistro->getId()));
        }

        return $this->render('origenregistro/new.html.twig', array(
            'origenRegistro' => $origenRegistro,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a origenRegistro entity.
     *
     * @Route("/{id}", name="origenregistro_show")
     * @Method("GET")
     */
    public function showAction(OrigenRegistro $origenRegistro)
    {
        $deleteForm = $this->createDeleteForm($origenRegistro);

        return $this->render('origenregistro/show.html.twig', array(
            'origenRegistro' => $origenRegistro,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing origenRegistro entity.
     *
     * @Route("/{id}/edit", name="origenregistro_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, OrigenRegistro $origenRegistro)
    {
        $deleteForm = $this->createDeleteForm($origenRegistro);
        $editForm = $this->createForm('AppBundle\Form\OrigenRegistroType', $origenRegistro);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('origenregistro_edit', array('id' => $origenRegistro->getId()));
        }

        return $this->render('origenregistro/edit.html.twig', array(
            'origenRegistro' => $origenRegistro,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a origenRegistro entity.
     *
     * @Route("/{id}", name="origenregistro_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, OrigenRegistro $origenRegistro)
    {
        $form = $this->createDeleteForm($origenRegistro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($origenRegistro);
            $em->flush();
        }

        return $this->redirectToRoute('origenregistro_index');
    }

    /**
     * Creates a form to delete a origenRegistro entity.
     *
     * @param OrigenRegistro $origenRegistro The origenRegistro entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(OrigenRegistro $origenRegistro)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('origenregistro_delete', array('id' => $origenRegistro->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
