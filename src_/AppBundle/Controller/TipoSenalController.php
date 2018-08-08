<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TipoSenal;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Tiposenal controller.
 *
 * @Route("tiposenal")
 */
class TipoSenalController extends Controller
{
    /**
     * Lists all tipoSenal entities.
     *
     * @Route("/", name="tiposenal_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tipoSenals = $em->getRepository('AppBundle:TipoSenal')->findAll();

        return $this->render('tiposenal/index.html.twig', array(
            'tipoSenals' => $tipoSenals,
        ));
    }

    /**
     * Creates a new tipoSenal entity.
     *
     * @Route("/new", name="tiposenal_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tipoSenal = new Tiposenal();
        $form = $this->createForm('AppBundle\Form\TipoSenalType', $tipoSenal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tipoSenal);
            $em->flush();

            return $this->redirectToRoute('tiposenal_show', array('id' => $tipoSenal->getId()));
        }

        return $this->render('tiposenal/new.html.twig', array(
            'tipoSenal' => $tipoSenal,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a tipoSenal entity.
     *
     * Route("/{id}", name="tiposenal_show")
     * Method("GET")
     */
    public function showAction(TipoSenal $tipoSenal)
    {
        $deleteForm = $this->createDeleteForm($tipoSenal);

        return $this->render('tiposenal/show.html.twig', array(
            'tipoSenal' => $tipoSenal,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing tipoSenal entity.
     *
     * @Route("/{id}/edit", name="tiposenal_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TipoSenal $tipoSenal)
    {
        $deleteForm = $this->createDeleteForm($tipoSenal);
        $editForm = $this->createForm('AppBundle\Form\TipoSenalType', $tipoSenal);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tiposenal_edit', array('id' => $tipoSenal->getId()));
        }

        return $this->render('tiposenal/edit.html.twig', array(
            'tipoSenal' => $tipoSenal,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a tipoSenal entity.
     *
     * @Route("/{id}", name="tiposenal_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TipoSenal $tipoSenal)
    {
        $form = $this->createDeleteForm($tipoSenal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tipoSenal);
            $em->flush();
        }

        return $this->redirectToRoute('tiposenal_index');
    }

    /**
     * Creates a form to delete a tipoSenal entity.
     *
     * @param TipoSenal $tipoSenal The tipoSenal entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TipoSenal $tipoSenal)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tiposenal_delete', array('id' => $tipoSenal->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="tiposenal_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $senales = $em->getRepository('AppBundle:TipoSenal')->findBy(
            array('estado' => 1)
        );
        foreach ($senales as $key => $senal) {
            $response[$key] = array(
                'value' => $senal->getId(),
                'label' => $senal->getNombre(),
            );
        }
        return $helpers->json($response);
    }
}
