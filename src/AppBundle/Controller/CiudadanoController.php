<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Ciudadano;
use AppBundle\Form\CiudadanoType;

/**
 * Ciudadano controller.
 *
 * @Route("/ciudadano")
 */
class CiudadanoController extends Controller
{
    /**
     * Lists all Ciudadano entities.
     *
     * @Route("/", name="ciudadano_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ciudadanos = $em->getRepository('AppBundle:Ciudadano')->findAll();

        return $this->render('AppBundle:ciudadano:index.html.twig', array(
            'ciudadanos' => $ciudadanos,
        ));
    }

    /**
     * Creates a new Ciudadano entity.
     *
     * @Route("/new", name="ciudadano_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $ciudadano = new Ciudadano();
        $form = $this->createForm('AppBundle\Form\CiudadanoType', $ciudadano);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ciudadano);
            $em->flush();

            return $this->redirectToRoute('ciudadano_show', array('id' => $ciudadano->getId()));
        }

        return $this->render('AppBundle:ciudadano:new.html.twig', array(
            'ciudadano' => $ciudadano,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Ciudadano entity.
     *
     * @Route("/{id}", name="ciudadano_show")
     * @Method("GET")
     */
    public function showAction(Ciudadano $ciudadano)
    {
        $deleteForm = $this->createDeleteForm($ciudadano);

        return $this->render('AppBundle:ciudadano:show.html.twig', array(
            'ciudadano' => $ciudadano,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Ciudadano entity.
     *
     * @Route("/{id}/edit", name="ciudadano_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Ciudadano $ciudadano)
    {
        $deleteForm = $this->createDeleteForm($ciudadano);
        $editForm = $this->createForm('AppBundle\Form\CiudadanoType', $ciudadano);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ciudadano);
            $em->flush();

            return $this->redirectToRoute('ciudadano_edit', array('id' => $ciudadano->getId()));
        }

        return $this->render('AppBundle:ciudadano:edit.html.twig', array(
            'ciudadano' => $ciudadano,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Ciudadano entity.
     *
     * @Route("/{id}", name="ciudadano_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Ciudadano $ciudadano)
    {
        $form = $this->createDeleteForm($ciudadano);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ciudadano);
            $em->flush();
        }

        return $this->redirectToRoute('ciudadano_index');
    }

    /**
     * Creates a form to delete a Ciudadano entity.
     *
     * @param Ciudadano $ciudadano The Ciudadano entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Ciudadano $ciudadano)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ciudadano_delete', array('id' => $ciudadano->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
