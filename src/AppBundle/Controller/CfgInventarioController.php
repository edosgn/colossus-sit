<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CfgInventario;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request; use Symfony\Component\HttpFoundation\Response;

/**
 * CfgInventario controller.
 *
 * @Route("cfginventario")
 */
class CfgInventarioController extends Controller
{
    /**
     * Lists all cfgInventario entities.
     *
     * @Route("/", name="cfgInventario_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cfgInventarios = $em->getRepository('AppBundle:CfgInventario')->findAll();

        return $this->render('cfgInventario/index.html.twig', array(
            'cfgInventarios' => $cfgInventarios,
        ));
    }

    /**
     * Creates a new cfgInventario entity.
     *
     * @Route("/new", name="cfgInventario_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $cfgInventario = new CfgInventario();
        $form = $this->createForm('AppBundle\Form\CfgInventarioType', $cfgInventario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cfgInventario);
            $em->flush();

            return $this->redirectToRoute('cfgInventario_show', array('id' => $cfgInventario->getId()));
        }

        return $this->render('cfgInventario/new.html.twig', array(
            'cfgInventario' => $cfgInventario,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a cfgInventario entity.
     *
     * Route("/{id}/show", name="cfgInventario_show")
     * Method("GET")
     */
    public function showAction(CfgInventario $cfgInventario)
    {
        $deleteForm = $this->createDeleteForm($cfgInventario);

        return $this->render('cfgInventario/show.html.twig', array(
            'cfgInventario' => $cfgInventario,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cfgInventario entity.
     *
     * @Route("/{id}/edit", name="cfgInventario_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CfgInventario $cfgInventario)
    {
        $deleteForm = $this->createDeleteForm($cfgInventario);
        $editForm = $this->createForm('AppBundle\Form\CfgInventarioType', $cfgInventario);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cfgInventario_edit', array('id' => $cfgInventario->getId()));
        }

        return $this->render('cfgInventario/edit.html.twig', array(
            'cfgInventario' => $cfgInventario,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cfgInventario entity.
     *
     * @Route("/{id}/delete", name="cfgInventario_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CfgInventario $cfgInventario)
    {
        $form = $this->createDeleteForm($cfgInventario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cfgInventario);
            $em->flush();
        }

        return $this->redirectToRoute('cfgInventario_index');
    }

    /**
     * Creates a form to delete a cfgInventario entity.
     *
     * @param CfgInventario $cfgInventario The cfgInventario entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgInventario $cfgInventario)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgInventario_delete', array('id' => $cfgInventario->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="cfgInventario_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $cfgInventarios = $em->getRepository('AppBundle:CfgInventario')->findBy(
            array('estado' => true)
        );

        $response = null;

        foreach ($cfgInventarios as $key => $cfgInventario) {
            $response[$key] = array(
                'value' => $cfgInventario->getId(),
                'label' => $cfgInventario->getNumero(),
                'other' => $cfgInventario->getFecha(),
            );
        }
        return $helpers->json($response);
    }

}
