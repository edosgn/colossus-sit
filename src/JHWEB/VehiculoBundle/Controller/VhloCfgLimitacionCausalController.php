<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloCfgLimitacionCausal;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlocfglimitacioncausal controller.
 *
 * @Route("vhlocfglimitacioncausal")
 */
class VhloCfgLimitacionCausalController extends Controller
{
    /**
     * Lists all vhloCfgLimitacionCausal entities.
     *
     * @Route("/", name="vhlocfglimitacioncausal_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $vhloCfgLimitacionCausals = $em->getRepository('JHWEBVehiculoBundle:VhloCfgLimitacionCausal')->findAll();

        return $this->render('vhlocfglimitacioncausal/index.html.twig', array(
            'vhloCfgLimitacionCausals' => $vhloCfgLimitacionCausals,
        ));
    }

    /**
     * Creates a new vhloCfgLimitacionCausal entity.
     *
     * @Route("/new", name="vhlocfglimitacioncausal_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $vhloCfgLimitacionCausal = new Vhlocfglimitacioncausal();
        $form = $this->createForm('JHWEB\VehiculoBundle\Form\VhloCfgLimitacionCausalType', $vhloCfgLimitacionCausal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($vhloCfgLimitacionCausal);
            $em->flush();

            return $this->redirectToRoute('vhlocfglimitacioncausal_show', array('id' => $vhloCfgLimitacionCausal->getId()));
        }

        return $this->render('vhlocfglimitacioncausal/new.html.twig', array(
            'vhloCfgLimitacionCausal' => $vhloCfgLimitacionCausal,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a vhloCfgLimitacionCausal entity.
     *
     * @Route("/{id}/show", name="vhlocfglimitacioncausal_show")
     * @Method("GET")
     */
    public function showAction(VhloCfgLimitacionCausal $vhloCfgLimitacionCausal)
    {
        $deleteForm = $this->createDeleteForm($vhloCfgLimitacionCausal);

        return $this->render('vhlocfglimitacioncausal/show.html.twig', array(
            'vhloCfgLimitacionCausal' => $vhloCfgLimitacionCausal,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vhloCfgLimitacionCausal entity.
     *
     * @Route("/{id}/edit", name="vhlocfglimitacioncausal_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, VhloCfgLimitacionCausal $vhloCfgLimitacionCausal)
    {
        $deleteForm = $this->createDeleteForm($vhloCfgLimitacionCausal);
        $editForm = $this->createForm('JHWEB\VehiculoBundle\Form\VhloCfgLimitacionCausalType', $vhloCfgLimitacionCausal);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vhlocfglimitacioncausal_edit', array('id' => $vhloCfgLimitacionCausal->getId()));
        }

        return $this->render('vhlocfglimitacioncausal/edit.html.twig', array(
            'vhloCfgLimitacionCausal' => $vhloCfgLimitacionCausal,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a vhloCfgLimitacionCausal entity.
     *
     * @Route("/{id}/delete", name="vhlocfglimitacioncausal_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, VhloCfgLimitacionCausal $vhloCfgLimitacionCausal)
    {
        $form = $this->createDeleteForm($vhloCfgLimitacionCausal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vhloCfgLimitacionCausal);
            $em->flush();
        }

        return $this->redirectToRoute('vhlocfglimitacioncausal_index');
    }

    /**
     * Creates a form to delete a vhloCfgLimitacionCausal entity.
     *
     * @param VhloCfgLimitacionCausal $vhloCfgLimitacionCausal The vhloCfgLimitacionCausal entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloCfgLimitacionCausal $vhloCfgLimitacionCausal)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhlocfglimitacioncausal_delete', array('id' => $vhloCfgLimitacionCausal->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ================================================= */
    
    /**
     * Listado de causales
     *
     * @Route("/select", name="vhlocfgorigenregistro_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $causales = $em->getRepository('JHWEBVehiculoBundle:VhloCfgLimitacionCausal')->findBy(
            array(
                'activo' => true
            )
        );

        $response = null;

        foreach ($causales as $key => $causal) {
            $response[$key] = array(
                'value' => $causal->getId(),
                'label' => $causal->getNombre()
            );
        }
        return $helpers->json($response);
    }
}
