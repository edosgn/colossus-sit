<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MsvVariable;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Msvvariable controller.
 *
 * @Route("msvvariable")
 */
class MsvVariableController extends Controller
{
    /**
     * Lists all msvVariable entities.
     *
     * @Route("/", name="msvvariable_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $msvVariable = $em->getRepository('AppBundle:MsvVariable')->findBy( array('estado' => 1));

        $response = array(
                    'status' => 'succes',
                    'code' => 200,
                    'msj' => "listado festivos",
                    'data' => $msvVariable,
        );

        return $helpers ->json($response);
    }

    /**
     * Creates a new msvVariable entity.
     *
     * @Route("/new", name="msvvariable_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $msvVariable = new Msvvariable();
        $form = $this->createForm('AppBundle\Form\MsvVariableType', $msvVariable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($msvVariable);
            $em->flush();

            return $this->redirectToRoute('msvvariable_show', array('id' => $msvVariable->getId()));
        }

        return $this->render('msvvariable/new.html.twig', array(
            'msvVariable' => $msvVariable,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a msvVariable entity.
     *
     * @Route("/{id}", name="msvvariable_show")
     * @Method("GET")
     */
    public function showAction(MsvVariable $msvVariable)
    {
        $deleteForm = $this->createDeleteForm($msvVariable);

        return $this->render('msvvariable/show.html.twig', array(
            'msvVariable' => $msvVariable,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing msvVariable entity.
     *
     * @Route("/{id}/edit", name="msvvariable_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MsvVariable $msvVariable)
    {
        $deleteForm = $this->createDeleteForm($msvVariable);
        $editForm = $this->createForm('AppBundle\Form\MsvVariableType', $msvVariable);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('msvvariable_edit', array('id' => $msvVariable->getId()));
        }

        return $this->render('msvvariable/edit.html.twig', array(
            'msvVariable' => $msvVariable,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a msvVariable entity.
     *
     * @Route("/{id}", name="msvvariable_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MsvVariable $msvVariable)
    {
        $form = $this->createDeleteForm($msvVariable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($msvVariable);
            $em->flush();
        }

        return $this->redirectToRoute('msvvariable_index');
    }

    /**
     * Creates a form to delete a msvVariable entity.
     *
     * @param MsvVariable $msvVariable The msvVariable entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MsvVariable $msvVariable)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('msvvariable_delete', array('id' => $msvVariable->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
