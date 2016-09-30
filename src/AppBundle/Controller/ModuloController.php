<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Modulo;
use AppBundle\Form\ModuloType;

/**
 * Modulo controller.
 *
 * @Route("/modulo")
 */
class ModuloController extends Controller
{
    /**
     * Lists all Modulo entities.
     *
     * @Route("/", name="modulo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $modulos = $em->getRepository('AppBundle:Modulo')->findAll();

        return $this->render('AppBundle:modulo:index.html.twig', array(
            'modulos' => $modulos,
        ));
    }

    /**
     * Creates a new Modulo entity.
     *
     * @Route("/new", name="modulo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $modulo = new Modulo();
        $form = $this->createForm('AppBundle\Form\ModuloType', $modulo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($modulo);
            $em->flush();

            return $this->redirectToRoute('modulo_show', array('id' => $modulo->getId()));
        }

        return $this->render('AppBundle:modulo:new.html.twig', array(
            'modulo' => $modulo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Modulo entity.
     *
     * @Route("/{id}", name="modulo_show")
     * @Method("GET")
     */
    public function showAction(Modulo $modulo)
    {
        $deleteForm = $this->createDeleteForm($modulo);

        return $this->render('AppBundle:modulo:show.html.twig', array(
            'modulo' => $modulo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Modulo entity.
     *
     * @Route("/{id}/edit", name="modulo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Modulo $modulo)
    {
        $deleteForm = $this->createDeleteForm($modulo);
        $editForm = $this->createForm('AppBundle\Form\ModuloType', $modulo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($modulo);
            $em->flush();

            return $this->redirectToRoute('modulo_edit', array('id' => $modulo->getId()));
        }

        return $this->render('AppBundle:modulo:edit.html.twig', array(
            'modulo' => $modulo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Modulo entity.
     *
     * @Route("/{id}", name="modulo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Modulo $modulo)
    {
        $form = $this->createDeleteForm($modulo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($modulo);
            $em->flush();
        }

        return $this->redirectToRoute('modulo_index');
    }

    /**
     * Creates a form to delete a Modulo entity.
     *
     * @param Modulo $modulo The Modulo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Modulo $modulo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('modulo_delete', array('id' => $modulo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
