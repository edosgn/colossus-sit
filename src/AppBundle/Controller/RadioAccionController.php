<?php

namespace AppBundle\Controller;

use AppBundle\Entity\RadioAccion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Radioaccion controller.
 *
 * @Route("radioaccion")
 */
class RadioAccionController extends Controller
{
    /**
     * Lists all radioAccion entities.
     *
     * @Route("/", name="radioaccion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $radioAccions = $em->getRepository('AppBundle:RadioAccion')->findAll();

        return $this->render('radioaccion/index.html.twig', array(
            'radioAccions' => $radioAccions,
        ));
    }

    /**
     * Creates a new radioAccion entity.
     *
     * @Route("/new", name="radioaccion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $radioAccion = new Radioaccion();
        $form = $this->createForm('AppBundle\Form\RadioAccionType', $radioAccion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($radioAccion);
            $em->flush();

            return $this->redirectToRoute('radioaccion_show', array('id' => $radioAccion->getId()));
        }

        return $this->render('radioaccion/new.html.twig', array(
            'radioAccion' => $radioAccion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a radioAccion entity.
     *
     * @Route("/{id}", name="radioaccion_show")
     * @Method("GET")
     */
    public function showAction(RadioAccion $radioAccion)
    {
        $deleteForm = $this->createDeleteForm($radioAccion);

        return $this->render('radioaccion/show.html.twig', array(
            'radioAccion' => $radioAccion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing radioAccion entity.
     *
     * @Route("/{id}/edit", name="radioaccion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, RadioAccion $radioAccion)
    {
        $deleteForm = $this->createDeleteForm($radioAccion);
        $editForm = $this->createForm('AppBundle\Form\RadioAccionType', $radioAccion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('radioaccion_edit', array('id' => $radioAccion->getId()));
        }

        return $this->render('radioaccion/edit.html.twig', array(
            'radioAccion' => $radioAccion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a radioAccion entity.
     *
     * @Route("/{id}", name="radioaccion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, RadioAccion $radioAccion)
    {
        $form = $this->createDeleteForm($radioAccion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($radioAccion);
            $em->flush();
        }

        return $this->redirectToRoute('radioaccion_index');
    }

    /**
     * Creates a form to delete a radioAccion entity.
     *
     * @param RadioAccion $radioAccion The radioAccion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(RadioAccion $radioAccion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('radioaccion_delete', array('id' => $radioAccion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
