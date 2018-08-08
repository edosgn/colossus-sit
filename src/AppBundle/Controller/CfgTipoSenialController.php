<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CfgTipoSenial;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * CfgTipoSenial controller.
 *
 * @Route("cfgtiposenial")
 */
class CfgTipoSenialController extends Controller
{
    /**
     * Lists all cfgTipoSenial entities.
     *
     * @Route("/", name="cfgtiposenial_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cfgTipoSenials = $em->getRepository('AppBundle:CfgTipoSenial')->findAll();

        return $this->render('cfgtiposenial/index.html.twig', array(
            'cfgTipoSenials' => $cfgTipoSenials,
        ));
    }

    /**
     * Creates a new cfgTipoSenial entity.
     *
     * @Route("/new", name="cfgtiposenial_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $cfgTipoSenial = new CfgTipoSenial();
        $form = $this->createForm('AppBundle\Form\CfgTipoSenialType', $cfgTipoSenial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cfgTipoSenial);
            $em->flush();

            return $this->redirectToRoute('cfgtiposenial_show', array('id' => $cfgTipoSenial->getId()));
        }

        return $this->render('cfgtiposenial/new.html.twig', array(
            'cfgTipoSenial' => $cfgTipoSenial,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a cfgTipoSenial entity.
     *
     * Route("/{id}", name="cfgtiposenial_show")
     * Method("GET")
     */
    public function showAction(CfgTipoSenial $cfgTipoSenial)
    {
        $deleteForm = $this->createDeleteForm($cfgTipoSenial);

        return $this->render('cfgtiposenial/show.html.twig', array(
            'cfgTipoSenial' => $cfgTipoSenial,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cfgTipoSenial entity.
     *
     * @Route("/{id}/edit", name="cfgtiposenial_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CfgTipoSenial $cfgTipoSenial)
    {
        $deleteForm = $this->createDeleteForm($cfgTipoSenial);
        $editForm = $this->createForm('AppBundle\Form\CfgTipoSenialType', $cfgTipoSenial);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cfgtiposenial_edit', array('id' => $cfgTipoSenial->getId()));
        }

        return $this->render('cfgtiposenial/edit.html.twig', array(
            'cfgTipoSenial' => $cfgTipoSenial,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cfgTipoSenial entity.
     *
     * @Route("/{id}", name="cfgtiposenial_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CfgTipoSenial $cfgTipoSenial)
    {
        $form = $this->createDeleteForm($cfgTipoSenial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cfgTipoSenial);
            $em->flush();
        }

        return $this->redirectToRoute('cfgtiposenial_index');
    }

    /**
     * Creates a form to delete a cfgTipoSenial entity.
     *
     * @param CfgTipoSenial $cfgTipoSenial The cfgTipoSenial entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgTipoSenial $cfgTipoSenial)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgtiposenial_delete', array('id' => $cfgTipoSenial->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="cfgtiposenial_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $senales = $em->getRepository('AppBundle:CfgTipoSenial')->findBy(
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
