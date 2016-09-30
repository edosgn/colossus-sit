<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Consumible;
use AppBundle\Form\ConsumibleType;

/**
 * Consumible controller.
 *
 * @Route("/consumible")
 */
class ConsumibleController extends Controller
{
    /**
     * Lists all Consumible entities.
     *
     * @Route("/", name="consumible_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $consumibles = $em->getRepository('AppBundle:Consumible')->findAll();

        return $this->render('AppBundle:consumible:index.html.twig', array(
            'consumibles' => $consumibles,
        ));
    }

    /**
     * Creates a new Consumible entity.
     *
     * @Route("/new", name="consumible_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $consumible = new Consumible();
        $form = $this->createForm('AppBundle\Form\ConsumibleType', $consumible);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($consumible);
            $em->flush();

            return $this->redirectToRoute('consumible_show', array('id' => $consumible->getId()));
        }

        return $this->render('AppBundle:consumible:new.html.twig', array(
            'consumible' => $consumible,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Consumible entity.
     *
     * @Route("/{id}", name="consumible_show")
     * @Method("GET")
     */
    public function showAction(Consumible $consumible)
    {
        $deleteForm = $this->createDeleteForm($consumible);

        return $this->render('AppBundle:consumible:show.html.twig', array(
            'consumible' => $consumible,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Consumible entity.
     *
     * @Route("/{id}/edit", name="consumible_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Consumible $consumible)
    {
        $deleteForm = $this->createDeleteForm($consumible);
        $editForm = $this->createForm('AppBundle\Form\ConsumibleType', $consumible);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($consumible);
            $em->flush();

            return $this->redirectToRoute('consumible_edit', array('id' => $consumible->getId()));
        }

        return $this->render('AppBundle:consumible:edit.html.twig', array(
            'consumible' => $consumible,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Consumible entity.
     *
     * @Route("/{id}", name="consumible_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Consumible $consumible)
    {
        $form = $this->createDeleteForm($consumible);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($consumible);
            $em->flush();
        }

        return $this->redirectToRoute('consumible_index');
    }

    /**
     * Creates a form to delete a Consumible entity.
     *
     * @param Consumible $consumible The Consumible entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Consumible $consumible)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('consumible_delete', array('id' => $consumible->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
