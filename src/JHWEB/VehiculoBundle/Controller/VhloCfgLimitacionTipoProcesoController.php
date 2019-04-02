<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloCfgLimitacionTipoProceso;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlocfglimitaciontipoproceso controller.
 *
 * @Route("vhlocfglimitaciontipoproceso")
 */
class VhloCfgLimitacionTipoProcesoController extends Controller
{
    /**
     * Lists all vhloCfgLimitacionTipoProceso entities.
     *
     * @Route("/", name="vhlocfglimitaciontipoproceso_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $vhloCfgLimitacionTipoProcesos = $em->getRepository('JHWEBVehiculoBundle:VhloCfgLimitacionTipoProceso')->findAll();

        return $this->render('vhlocfglimitaciontipoproceso/index.html.twig', array(
            'vhloCfgLimitacionTipoProcesos' => $vhloCfgLimitacionTipoProcesos,
        ));
    }

    /**
     * Creates a new vhloCfgLimitacionTipoProceso entity.
     *
     * @Route("/new", name="vhlocfglimitaciontipoproceso_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $vhloCfgLimitacionTipoProceso = new Vhlocfglimitaciontipoproceso();
        $form = $this->createForm('JHWEB\VehiculoBundle\Form\VhloCfgLimitacionTipoProcesoType', $vhloCfgLimitacionTipoProceso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($vhloCfgLimitacionTipoProceso);
            $em->flush();

            return $this->redirectToRoute('vhlocfglimitaciontipoproceso_show', array('id' => $vhloCfgLimitacionTipoProceso->getId()));
        }

        return $this->render('vhlocfglimitaciontipoproceso/new.html.twig', array(
            'vhloCfgLimitacionTipoProceso' => $vhloCfgLimitacionTipoProceso,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a vhloCfgLimitacionTipoProceso entity.
     *
     * @Route("/{id}/show", name="vhlocfglimitaciontipoproceso_show")
     * @Method("GET")
     */
    public function showAction(VhloCfgLimitacionTipoProceso $vhloCfgLimitacionTipoProceso)
    {
        $deleteForm = $this->createDeleteForm($vhloCfgLimitacionTipoProceso);

        return $this->render('vhlocfglimitaciontipoproceso/show.html.twig', array(
            'vhloCfgLimitacionTipoProceso' => $vhloCfgLimitacionTipoProceso,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vhloCfgLimitacionTipoProceso entity.
     *
     * @Route("/{id}/edit", name="vhlocfglimitaciontipoproceso_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, VhloCfgLimitacionTipoProceso $vhloCfgLimitacionTipoProceso)
    {
        $deleteForm = $this->createDeleteForm($vhloCfgLimitacionTipoProceso);
        $editForm = $this->createForm('JHWEB\VehiculoBundle\Form\VhloCfgLimitacionTipoProcesoType', $vhloCfgLimitacionTipoProceso);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vhlocfglimitaciontipoproceso_edit', array('id' => $vhloCfgLimitacionTipoProceso->getId()));
        }

        return $this->render('vhlocfglimitaciontipoproceso/edit.html.twig', array(
            'vhloCfgLimitacionTipoProceso' => $vhloCfgLimitacionTipoProceso,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a vhloCfgLimitacionTipoProceso entity.
     *
     * @Route("/{id}/delete", name="vhlocfglimitaciontipoproceso_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, VhloCfgLimitacionTipoProceso $vhloCfgLimitacionTipoProceso)
    {
        $form = $this->createDeleteForm($vhloCfgLimitacionTipoProceso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vhloCfgLimitacionTipoProceso);
            $em->flush();
        }

        return $this->redirectToRoute('vhlocfglimitaciontipoproceso_index');
    }

    /**
     * Creates a form to delete a vhloCfgLimitacionTipoProceso entity.
     *
     * @param VhloCfgLimitacionTipoProceso $vhloCfgLimitacionTipoProceso The vhloCfgLimitacionTipoProceso entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloCfgLimitacionTipoProceso $vhloCfgLimitacionTipoProceso)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhlocfglimitaciontipoproceso_delete', array('id' => $vhloCfgLimitacionTipoProceso->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ================================================= */
    
    /**
     * Listado de tipos de proceso
     *
     * @Route("/select", name="vhlocfgorigenregistro_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $tiposProceso = $em->getRepository('JHWEBVehiculoBundle:VhloCfgLimitacionTipoProceso')->findBy(
            array(
                'activo' => true
            )
        );

        $response = null;

        foreach ($tiposProceso as $key => $tipoProceso) {
            $response[$key] = array(
                'value' => $tipoProceso->getId(),
                'label' => $tipoProceso->getNombre()
            );
        }
        return $helpers->json($response);
    }
}
