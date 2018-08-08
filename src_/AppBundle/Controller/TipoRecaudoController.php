<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TipoRecaudo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Tiporecaudo controller.
 *
 * @Route("tiporecaudo")
 */
class TipoRecaudoController extends Controller
{
    /**
     * Lists all tipoRecaudo entities.
     *
     * @Route("/", name="tiporecaudo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tipoRecaudos = $em->getRepository('AppBundle:TipoRecaudo')->findAll();

        return $this->render('tiporecaudo/index.html.twig', array(
            'tipoRecaudos' => $tipoRecaudos,
        ));
    }

    /**
     * Creates a new tipoRecaudo entity.
     *
     * @Route("/new", name="tiporecaudo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tipoRecaudo = new Tiporecaudo();
        $form = $this->createForm('AppBundle\Form\TipoRecaudoType', $tipoRecaudo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tipoRecaudo);
            $em->flush();

            return $this->redirectToRoute('tiporecaudo_show', array('id' => $tipoRecaudo->getId()));
        }

        return $this->render('tiporecaudo/new.html.twig', array(
            'tipoRecaudo' => $tipoRecaudo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a tipoRecaudo entity.
     *
     * @Route("/{id}", name="tiporecaudo_show")
     * @Method("GET")
     */
    public function showAction(TipoRecaudo $tipoRecaudo)
    {
        $deleteForm = $this->createDeleteForm($tipoRecaudo);

        return $this->render('tiporecaudo/show.html.twig', array(
            'tipoRecaudo' => $tipoRecaudo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing tipoRecaudo entity.
     *
     * @Route("/{id}/edit", name="tiporecaudo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TipoRecaudo $tipoRecaudo)
    {
        $deleteForm = $this->createDeleteForm($tipoRecaudo);
        $editForm = $this->createForm('AppBundle\Form\TipoRecaudoType', $tipoRecaudo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tiporecaudo_edit', array('id' => $tipoRecaudo->getId()));
        }

        return $this->render('tiporecaudo/edit.html.twig', array(
            'tipoRecaudo' => $tipoRecaudo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a tipoRecaudo entity.
     *
     * @Route("/{id}", name="tiporecaudo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TipoRecaudo $tipoRecaudo)
    {
        $form = $this->createDeleteForm($tipoRecaudo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tipoRecaudo);
            $em->flush();
        }

        return $this->redirectToRoute('tiporecaudo_index');
    }

    /**
     * Creates a form to delete a tipoRecaudo entity.
     *
     * @param TipoRecaudo $tipoRecaudo The tipoRecaudo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TipoRecaudo $tipoRecaudo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tiporecaudo_delete', array('id' => $tipoRecaudo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
