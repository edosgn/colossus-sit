<?php

namespace AppBundle\Controller;

use AppBundle\Entity\LoteInsumo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Loteinsumo controller.
 *
 * @Route("loteinsumo")
 */
class LoteInsumoController extends Controller
{
    /**
     * Lists all loteInsumo entities.
     *
     * @Route("/", name="loteinsumo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $loteInsumos = $em->getRepository('AppBundle:LoteInsumo')->findAll();

        return $this->render('loteinsumo/index.html.twig', array(
            'loteInsumos' => $loteInsumos,
        ));
    }

    /**
     * Creates a new loteInsumo entity.
     *
     * @Route("/new", name="loteinsumo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $loteInsumo = new Loteinsumo();
        $form = $this->createForm('AppBundle\Form\LoteInsumoType', $loteInsumo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($loteInsumo);
            $em->flush();

            return $this->redirectToRoute('loteinsumo_show', array('id' => $loteInsumo->getId()));
        }

        return $this->render('loteinsumo/new.html.twig', array(
            'loteInsumo' => $loteInsumo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a loteInsumo entity.
     *
     * @Route("/{id}", name="loteinsumo_show")
     * @Method("GET")
     */
    public function showAction(LoteInsumo $loteInsumo)
    {
        $deleteForm = $this->createDeleteForm($loteInsumo);

        return $this->render('loteinsumo/show.html.twig', array(
            'loteInsumo' => $loteInsumo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing loteInsumo entity.
     *
     * @Route("/{id}/edit", name="loteinsumo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, LoteInsumo $loteInsumo)
    {
        $deleteForm = $this->createDeleteForm($loteInsumo);
        $editForm = $this->createForm('AppBundle\Form\LoteInsumoType', $loteInsumo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('loteinsumo_edit', array('id' => $loteInsumo->getId()));
        }

        return $this->render('loteinsumo/edit.html.twig', array(
            'loteInsumo' => $loteInsumo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a loteInsumo entity.
     *
     * @Route("/{id}", name="loteinsumo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, LoteInsumo $loteInsumo)
    {
        $form = $this->createDeleteForm($loteInsumo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($loteInsumo);
            $em->flush();
        }

        return $this->redirectToRoute('loteinsumo_index');
    }

    /**
     * Creates a form to delete a loteInsumo entity.
     *
     * @param LoteInsumo $loteInsumo The loteInsumo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(LoteInsumo $loteInsumo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('loteinsumo_delete', array('id' => $loteInsumo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
