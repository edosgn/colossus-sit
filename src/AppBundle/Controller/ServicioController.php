<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Servicio;
use AppBundle\Form\ServicioType;

/**
 * Servicio controller.
 *
 * @Route("/servicio")
 */
class ServicioController extends Controller
{
    /**
     * Lists all Servicio entities.
     *
     * @Route("/", name="servicio_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $servicios = $em->getRepository('AppBundle:Servicio')->findAll();

        return $this->render('AppBundle:Servicio:index.html.twig', array(
            'servicios' => $servicios,
        ));
    }

    /**
     * Creates a new Servicio entity.
     *
     * @Route("/new", name="servicio_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $servicio = new Servicio();
        $form = $this->createForm('AppBundle\Form\ServicioType', $servicio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($servicio);
            $em->flush();

            return $this->redirectToRoute('servicio_show', array('id' => $servicio->getId()));
        }

        return $this->render('AppBundle:Servicio:new.html.twig', array(
            'servicio' => $servicio,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Servicio entity.
     *
     * @Route("/{id}", name="servicio_show")
     * @Method("GET")
     */
    public function showAction(Servicio $servicio)
    {
        $deleteForm = $this->createDeleteForm($servicio);

        return $this->render('AppBundle:Servicio:show.html.twig', array(
            'servicio' => $servicio,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Servicio entity.
     *
     * @Route("/{id}/edit", name="servicio_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Servicio $servicio)
    {
        $deleteForm = $this->createDeleteForm($servicio);
        $editForm = $this->createForm('AppBundle\Form\ServicioType', $servicio);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($servicio);
            $em->flush();

            return $this->redirectToRoute('servicio_edit', array('id' => $servicio->getId()));
        }

        return $this->render('AppBundle:Servicio:edit.html.twig', array(
            'servicio' => $servicio,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Servicio entity.
     *
     * @Route("/{id}", name="servicio_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Servicio $servicio)
    {
        $form = $this->createDeleteForm($servicio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($servicio);
            $em->flush();
        }

        return $this->redirectToRoute('servicio_index');
    }

    /**
     * Creates a form to delete a Servicio entity.
     *
     * @param Servicio $servicio The Servicio entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Servicio $servicio)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('servicio_delete', array('id' => $servicio->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
