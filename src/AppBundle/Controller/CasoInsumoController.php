<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CasoInsumo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Casoinsumo controller.
 *
 * @Route("casoinsumo")
 */
class CasoInsumoController extends Controller
{
    /**
     * Lists all casoInsumo entities.
     *
     * @Route("/", name="casoinsumo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $casoInsumos = $em->getRepository('AppBundle:CasoInsumo')->findAll();

        return $this->render('casoinsumo/index.html.twig', array(
            'casoInsumos' => $casoInsumos,
        ));
    }

    /**
     * Creates a new casoInsumo entity.
     *
     * @Route("/new", name="casoinsumo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $casoInsumo = new Casoinsumo();
        $form = $this->createForm('AppBundle\Form\CasoInsumoType', $casoInsumo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($casoInsumo);
            $em->flush();

            return $this->redirectToRoute('casoinsumo_show', array('id' => $casoInsumo->getId()));
        }

        return $this->render('casoinsumo/new.html.twig', array(
            'casoInsumo' => $casoInsumo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a casoInsumo entity.
     *
     * @Route("/{id}", name="casoinsumo_show")
     * @Method("GET")
     */
    public function showAction(CasoInsumo $casoInsumo)
    {
        $deleteForm = $this->createDeleteForm($casoInsumo);

        return $this->render('casoinsumo/show.html.twig', array(
            'casoInsumo' => $casoInsumo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing casoInsumo entity.
     *
     * @Route("/{id}/edit", name="casoinsumo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CasoInsumo $casoInsumo)
    {
        $deleteForm = $this->createDeleteForm($casoInsumo);
        $editForm = $this->createForm('AppBundle\Form\CasoInsumoType', $casoInsumo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('casoinsumo_edit', array('id' => $casoInsumo->getId()));
        }

        return $this->render('casoinsumo/edit.html.twig', array(
            'casoInsumo' => $casoInsumo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a casoInsumo entity.
     *
     * @Route("/{id}", name="casoinsumo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CasoInsumo $casoInsumo)
    {
        $form = $this->createDeleteForm($casoInsumo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($casoInsumo);
            $em->flush();
        }

        return $this->redirectToRoute('casoinsumo_index');
    }

    /**
     * Creates a form to delete a casoInsumo entity.
     *
     * @param CasoInsumo $casoInsumo The casoInsumo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CasoInsumo $casoInsumo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('casoinsumo_delete', array('id' => $casoInsumo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
