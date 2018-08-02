<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MparqPatio;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Mparqpatio controller.
 *
 * @Route("mparqpatio")
 */
class MparqPatioController extends Controller
{
    /**
     * Lists all mparqPatio entities.
     *
     * @Route("/", name="mparqpatio_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $mparqPatios = $em->getRepository('AppBundle:MparqPatio')->findAll();

        return $this->render('mparqpatio/index.html.twig', array(
            'mparqPatios' => $mparqPatios,
        ));
    }

    /**
     * Creates a new mparqPatio entity.
     *
     * @Route("/new", name="mparqpatio_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $mparqPatio = new Mparqpatio();
        $form = $this->createForm('AppBundle\Form\MparqPatioType', $mparqPatio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mparqPatio);
            $em->flush();

            return $this->redirectToRoute('mparqpatio_show', array('id' => $mparqPatio->getId()));
        }

        return $this->render('mparqpatio/new.html.twig', array(
            'mparqPatio' => $mparqPatio,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a mparqPatio entity.
     *
     * @Route("/{id}/show", name="mparqpatio_show")
     * @Method("GET")
     */
    public function showAction(MparqPatio $mparqPatio)
    {
        $deleteForm = $this->createDeleteForm($mparqPatio);

        return $this->render('mparqpatio/show.html.twig', array(
            'mparqPatio' => $mparqPatio,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing mparqPatio entity.
     *
     * @Route("/{id}/edit", name="mparqpatio_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MparqPatio $mparqPatio)
    {
        $deleteForm = $this->createDeleteForm($mparqPatio);
        $editForm = $this->createForm('AppBundle\Form\MparqPatioType', $mparqPatio);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mparqpatio_edit', array('id' => $mparqPatio->getId()));
        }

        return $this->render('mparqpatio/edit.html.twig', array(
            'mparqPatio' => $mparqPatio,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a mparqPatio entity.
     *
     * @Route("/{id}/delete", name="mparqpatio_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MparqPatio $mparqPatio)
    {
        $form = $this->createDeleteForm($mparqPatio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mparqPatio);
            $em->flush();
        }

        return $this->redirectToRoute('mparqpatio_index');
    }

    /**
     * Creates a form to delete a mparqPatio entity.
     *
     * @param MparqPatio $mparqPatio The mparqPatio entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MparqPatio $mparqPatio)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mparqpatio_delete', array('id' => $mparqPatio->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="mparqpatio_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $response = null;
        
        $patios = $em->getRepository('AppBundle:MparqPatio')->findBy(
            array(
                'activo' => true,
            )
        );

        foreach ($patios as $key => $patio) {
            $response[$key] = array(
                'value' => $patio->getId(),
                'label' => $patio->getNombre()
            );
        }
        return $helpers->json($response);
    }
}
