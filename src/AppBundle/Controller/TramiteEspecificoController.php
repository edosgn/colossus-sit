<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\TramiteEspecifico;
use AppBundle\Form\TramiteEspecificoType;

/**
 * TramiteEspecifico controller.
 *
 * @Route("/tramiteespecifico")
 */
class TramiteEspecificoController extends Controller
{
    /**
     * Lists all TramiteEspecifico entities.
     *
     * @Route("/", name="tramiteespecifico_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tramiteEspecificos = $em->getRepository('AppBundle:TramiteEspecifico')->findAll();

        return $this->render('AppBundle:TramiteEspecifico:index.html.twig', array(
            'tramiteEspecificos' => $tramiteEspecificos,
        ));
    }

    /**
     * Creates a new TramiteEspecifico entity.
     *
     * @Route("/new", name="tramiteespecifico_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tramiteEspecifico = new TramiteEspecifico();
        $form = $this->createForm('AppBundle\Form\TramiteEspecificoType', $tramiteEspecifico);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tramiteEspecifico);
            $em->flush();

            return $this->redirectToRoute('tramiteespecifico_show', array('id' => $tramiteEspecifico->getId()));
        }

        return $this->render('AppBundle:TramiteEspecifico:new.html.twig', array(
            'tramiteEspecifico' => $tramiteEspecifico,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TramiteEspecifico entity.
     *
     * @Route("/{id}", name="tramiteespecifico_show")
     * @Method("GET")
     */
    public function showAction(TramiteEspecifico $tramiteEspecifico)
    {
        $deleteForm = $this->createDeleteForm($tramiteEspecifico);

        return $this->render('AppBundle:TramiteEspecifico:show.html.twig', array(
            'tramiteEspecifico' => $tramiteEspecifico,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TramiteEspecifico entity.
     *
     * @Route("/{id}/edit", name="tramiteespecifico_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TramiteEspecifico $tramiteEspecifico)
    {
        $deleteForm = $this->createDeleteForm($tramiteEspecifico);
        $editForm = $this->createForm('AppBundle\Form\TramiteEspecificoType', $tramiteEspecifico);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tramiteEspecifico);
            $em->flush();

            return $this->redirectToRoute('tramiteespecifico_edit', array('id' => $tramiteEspecifico->getId()));
        }

        return $this->render('AppBundle:TramiteEspecifico:edit.html.twig', array(
            'tramiteEspecifico' => $tramiteEspecifico,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TramiteEspecifico entity.
     *
     * @Route("/{id}", name="tramiteespecifico_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TramiteEspecifico $tramiteEspecifico)
    {
        $form = $this->createDeleteForm($tramiteEspecifico);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tramiteEspecifico);
            $em->flush();
        }

        return $this->redirectToRoute('tramiteespecifico_index');
    }

    /**
     * Creates a form to delete a TramiteEspecifico entity.
     *
     * @param TramiteEspecifico $tramiteEspecifico The TramiteEspecifico entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TramiteEspecifico $tramiteEspecifico)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tramiteespecifico_delete', array('id' => $tramiteEspecifico->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
