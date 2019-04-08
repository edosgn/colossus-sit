<?php

namespace JHWEB\PersonalBundle\Controller;

use JHWEB\PersonalBundle\Entity\PnalTalonario;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Pnaltalonario controller.
 *
 * @Route("pnaltalonario")
 */
class PnalTalonarioController extends Controller
{
    /**
     * Lists all pnalTalonario entities.
     *
     * @Route("/", name="pnaltalonario_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pnalTalonarios = $em->getRepository('JHWEBPersonalBundle:PnalTalonario')->findAll();

        return $this->render('pnaltalonario/index.html.twig', array(
            'pnalTalonarios' => $pnalTalonarios,
        ));
    }

    /**
     * Creates a new pnalTalonario entity.
     *
     * @Route("/new", name="pnaltalonario_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $pnalTalonario = new Pnaltalonario();
        $form = $this->createForm('JHWEB\PersonalBundle\Form\PnalTalonarioType', $pnalTalonario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pnalTalonario);
            $em->flush();

            return $this->redirectToRoute('pnaltalonario_show', array('id' => $pnalTalonario->getId()));
        }

        return $this->render('pnaltalonario/new.html.twig', array(
            'pnalTalonario' => $pnalTalonario,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a pnalTalonario entity.
     *
     * @Route("/{id}", name="pnaltalonario_show")
     * @Method("GET")
     */
    public function showAction(PnalTalonario $pnalTalonario)
    {
        $deleteForm = $this->createDeleteForm($pnalTalonario);

        return $this->render('pnaltalonario/show.html.twig', array(
            'pnalTalonario' => $pnalTalonario,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing pnalTalonario entity.
     *
     * @Route("/{id}/edit", name="pnaltalonario_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, PnalTalonario $pnalTalonario)
    {
        $deleteForm = $this->createDeleteForm($pnalTalonario);
        $editForm = $this->createForm('JHWEB\PersonalBundle\Form\PnalTalonarioType', $pnalTalonario);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pnaltalonario_edit', array('id' => $pnalTalonario->getId()));
        }

        return $this->render('pnaltalonario/edit.html.twig', array(
            'pnalTalonario' => $pnalTalonario,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a pnalTalonario entity.
     *
     * @Route("/{id}", name="pnaltalonario_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, PnalTalonario $pnalTalonario)
    {
        $form = $this->createDeleteForm($pnalTalonario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pnalTalonario);
            $em->flush();
        }

        return $this->redirectToRoute('pnaltalonario_index');
    }

    /**
     * Creates a form to delete a pnalTalonario entity.
     *
     * @param PnalTalonario $pnalTalonario The pnalTalonario entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PnalTalonario $pnalTalonario)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pnaltalonario_delete', array('id' => $pnalTalonario->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
