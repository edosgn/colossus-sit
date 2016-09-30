<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Caso;
use AppBundle\Form\CasoType;

/**
 * Caso controller.
 *
 * @Route("/caso")
 */
class CasoController extends Controller
{
    /**
     * Lists all Caso entities.
     *
     * @Route("/", name="caso_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $casos = $em->getRepository('AppBundle:Caso')->findAll();

        return $this->render('AppBundle:caso:index.html.twig', array(
            'casos' => $casos,
        ));
    }

    /**
     * Creates a new Caso entity.
     *
     * @Route("/new", name="caso_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $caso = new Caso();
        $form = $this->createForm('AppBundle\Form\CasoType', $caso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($caso);
            $em->flush();

            return $this->redirectToRoute('caso_show', array('id' => $caso->getId()));
        }

        return $this->render('AppBundle:caso:new.html.twig', array(
            'caso' => $caso,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Caso entity.
     *
     * @Route("/{id}", name="caso_show")
     * @Method("GET")
     */
    public function showAction(Caso $caso)
    {
        $deleteForm = $this->createDeleteForm($caso);

        return $this->render('AppBundle:caso:show.html.twig', array(
            'caso' => $caso,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Caso entity.
     *
     * @Route("/{id}/edit", name="caso_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Caso $caso)
    {
        $deleteForm = $this->createDeleteForm($caso);
        $editForm = $this->createForm('AppBundle\Form\CasoType', $caso);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($caso);
            $em->flush();

            return $this->redirectToRoute('caso_edit', array('id' => $caso->getId()));
        }

        return $this->render('AppBundle:caso:edit.html.twig', array(
            'caso' => $caso,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Caso entity.
     *
     * @Route("/{id}", name="caso_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Caso $caso)
    {
        $form = $this->createDeleteForm($caso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($caso);
            $em->flush();
        }

        return $this->redirectToRoute('caso_index');
    }

    /**
     * Creates a form to delete a Caso entity.
     *
     * @param Caso $caso The Caso entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Caso $caso)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('caso_delete', array('id' => $caso->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
