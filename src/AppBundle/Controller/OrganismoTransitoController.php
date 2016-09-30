<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\OrganismoTransito;
use AppBundle\Form\OrganismoTransitoType;

/**
 * OrganismoTransito controller.
 *
 * @Route("/organismotransito")
 */
class OrganismoTransitoController extends Controller
{
    /**
     * Lists all OrganismoTransito entities.
     *
     * @Route("/", name="organismotransito_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $organismoTransitos = $em->getRepository('AppBundle:OrganismoTransito')->findAll();

        return $this->render('AppBundle:OrganismoTransito:index.html.twig', array(
            'organismoTransitos' => $organismoTransitos,
        ));
    }

    /**
     * Creates a new OrganismoTransito entity.
     *
     * @Route("/new", name="organismotransito_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $organismoTransito = new OrganismoTransito();
        $form = $this->createForm('AppBundle\Form\OrganismoTransitoType', $organismoTransito);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($organismoTransito);
            $em->flush();

            return $this->redirectToRoute('organismotransito_show', array('id' => $organismoTransito->getId()));
        }

        return $this->render('AppBundle:OrganismoTransito:new.html.twig', array(
            'organismoTransito' => $organismoTransito,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a OrganismoTransito entity.
     *
     * @Route("/{id}", name="organismotransito_show")
     * @Method("GET")
     */
    public function showAction(OrganismoTransito $organismoTransito)
    {
        $deleteForm = $this->createDeleteForm($organismoTransito);

        return $this->render('AppBundle:OrganismoTransito:show.html.twig', array(
            'organismoTransito' => $organismoTransito,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing OrganismoTransito entity.
     *
     * @Route("/{id}/edit", name="organismotransito_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, OrganismoTransito $organismoTransito)
    {
        $deleteForm = $this->createDeleteForm($organismoTransito);
        $editForm = $this->createForm('AppBundle\Form\OrganismoTransitoType', $organismoTransito);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($organismoTransito);
            $em->flush();

            return $this->redirectToRoute('organismotransito_edit', array('id' => $organismoTransito->getId()));
        }

        return $this->render('AppBundle:OrganismoTransito:edit.html.twig', array(
            'organismoTransito' => $organismoTransito,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a OrganismoTransito entity.
     *
     * @Route("/{id}", name="organismotransito_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, OrganismoTransito $organismoTransito)
    {
        $form = $this->createDeleteForm($organismoTransito);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($organismoTransito);
            $em->flush();
        }

        return $this->redirectToRoute('organismotransito_index');
    }

    /**
     * Creates a form to delete a OrganismoTransito entity.
     *
     * @param OrganismoTransito $organismoTransito The OrganismoTransito entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(OrganismoTransito $organismoTransito)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('organismotransito_delete', array('id' => $organismoTransito->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
