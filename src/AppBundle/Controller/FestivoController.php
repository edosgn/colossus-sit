<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Festivo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Festivo controller.
 *
 * @Route("festivo")
 */
class FestivoController extends Controller
{
    /**
     * Lists all festivo entities.
     *
     * @Route("/", name="festivo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $festivos = $em->getRepository('AppBundle:Festivo')->findAll();

        return $this->render('festivo/index.html.twig', array(
            'festivos' => $festivos,
        ));
    }

    /**
     * Creates a new festivo entity.
     *
     * @Route("/new", name="festivo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $festivo = new Festivo();
        $form = $this->createForm('AppBundle\Form\FestivoType', $festivo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($festivo);
            $em->flush();

            return $this->redirectToRoute('festivo_show', array('id' => $festivo->getId()));
        }

        return $this->render('festivo/new.html.twig', array(
            'festivo' => $festivo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a festivo entity.
     *
     * @Route("/{id}", name="festivo_show")
     * @Method("GET")
     */
    public function showAction(Festivo $festivo)
    {
        $deleteForm = $this->createDeleteForm($festivo);

        return $this->render('festivo/show.html.twig', array(
            'festivo' => $festivo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing festivo entity.
     *
     * @Route("/{id}/edit", name="festivo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Festivo $festivo)
    {
        $deleteForm = $this->createDeleteForm($festivo);
        $editForm = $this->createForm('AppBundle\Form\FestivoType', $festivo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('festivo_edit', array('id' => $festivo->getId()));
        }

        return $this->render('festivo/edit.html.twig', array(
            'festivo' => $festivo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a festivo entity.
     *
     * @Route("/{id}", name="festivo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Festivo $festivo)
    {
        $form = $this->createDeleteForm($festivo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($festivo);
            $em->flush();
        }

        return $this->redirectToRoute('festivo_index');
    }

    /**
     * Creates a form to delete a festivo entity.
     *
     * @param Festivo $festivo The festivo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Festivo $festivo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('festivo_delete', array('id' => $festivo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
