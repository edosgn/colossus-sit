<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Modalidad;
use AppBundle\Form\ModalidadType;

/**
 * Modalidad controller.
 *
 * @Route("/modalidad")
 */
class ModalidadController extends Controller
{
    /**
     * Lists all Modalidad entities.
     *
     * @Route("/", name="modalidad_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $modalidads = $em->getRepository('AppBundle:Modalidad')->findAll();

        return $this->render('AppBundle:modalidad:index.html.twig', array(
            'modalidads' => $modalidads,
        ));
    }

    /**
     * Creates a new Modalidad entity.
     *
     * @Route("/new", name="modalidad_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $modalidad = new Modalidad();
        $form = $this->createForm('AppBundle\Form\ModalidadType', $modalidad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($modalidad);
            $em->flush();

            return $this->redirectToRoute('modalidad_show', array('id' => $modalidad->getId()));
        }

        return $this->render('AppBundle:modalidad:new.html.twig', array(
            'modalidad' => $modalidad,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Modalidad entity.
     *
     * @Route("/{id}", name="modalidad_show")
     * @Method("GET")
     */
    public function showAction(Modalidad $modalidad)
    {
        $deleteForm = $this->createDeleteForm($modalidad);

        return $this->render('AppBundle:modalidad:show.html.twig', array(
            'modalidad' => $modalidad,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Modalidad entity.
     *
     * @Route("/{id}/edit", name="modalidad_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Modalidad $modalidad)
    {
        $deleteForm = $this->createDeleteForm($modalidad);
        $editForm = $this->createForm('AppBundle\Form\ModalidadType', $modalidad);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($modalidad);
            $em->flush();

            return $this->redirectToRoute('modalidad_edit', array('id' => $modalidad->getId()));
        }

        return $this->render('AppBundle:modalidad:edit.html.twig', array(
            'modalidad' => $modalidad,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Modalidad entity.
     *
     * @Route("/{id}", name="modalidad_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Modalidad $modalidad)
    {
        $form = $this->createDeleteForm($modalidad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($modalidad);
            $em->flush();
        }

        return $this->redirectToRoute('modalidad_index');
    }

    /**
     * Creates a form to delete a Modalidad entity.
     *
     * @param Modalidad $modalidad The Modalidad entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Modalidad $modalidad)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('modalidad_delete', array('id' => $modalidad->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
