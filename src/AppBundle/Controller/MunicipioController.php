<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Municipio;
use AppBundle\Form\MunicipioType;

/**
 * Municipio controller.
 *
 * @Route("/municipio")
 */
class MunicipioController extends Controller
{
    /**
     * Lists all Municipio entities.
     *
     * @Route("/", name="municipio_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $municipios = $em->getRepository('AppBundle:Municipio')->findAll();

        return $this->render('AppBundle:Municipio:index.html.twig', array(
            'municipios' => $municipios,
        ));
    }

    /**
     * Creates a new Municipio entity.
     *
     * @Route("/new", name="municipio_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $municipio = new Municipio();
        $form = $this->createForm('AppBundle\Form\MunicipioType', $municipio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($municipio);
            $em->flush();

            return $this->redirectToRoute('municipio_show', array('id' => $municipio->getId()));
        }

        return $this->render('AppBundle:Municipio:new.html.twig', array(
            'municipio' => $municipio,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Municipio entity.
     *
     * @Route("/{id}", name="municipio_show")
     * @Method("GET")
     */
    public function showAction(Municipio $municipio)
    {
        $deleteForm = $this->createDeleteForm($municipio);

        return $this->render('AppBundle:Municipio:show.html.twig', array(
            'municipio' => $municipio,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Municipio entity.
     *
     * @Route("/{id}/edit", name="municipio_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Municipio $municipio)
    {
        $deleteForm = $this->createDeleteForm($municipio);
        $editForm = $this->createForm('AppBundle\Form\MunicipioType', $municipio);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($municipio);
            $em->flush();

            return $this->redirectToRoute('municipio_edit', array('id' => $municipio->getId()));
        }

        return $this->render('AppBundle:Municipio:edit.html.twig', array(
            'municipio' => $municipio,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Municipio entity.
     *
     * @Route("/{id}", name="municipio_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Municipio $municipio)
    {
        $form = $this->createDeleteForm($municipio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($municipio);
            $em->flush();
        }

        return $this->redirectToRoute('municipio_index');
    }

    /**
     * Creates a form to delete a Municipio entity.
     *
     * @param Municipio $municipio The Municipio entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Municipio $municipio)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('municipio_delete', array('id' => $municipio->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
