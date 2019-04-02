<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloCfgLimitacionTipo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlocfglimitaciontipo controller.
 *
 * @Route("vhlocfglimitaciontipo")
 */
class VhloCfgLimitacionTipoController extends Controller
{
    /**
     * Lists all vhloCfgLimitacionTipo entities.
     *
     * @Route("/", name="vhlocfglimitaciontipo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $vhloCfgLimitacionTipos = $em->getRepository('JHWEBVehiculoBundle:VhloCfgLimitacionTipo')->findAll();

        return $this->render('vhlocfglimitaciontipo/index.html.twig', array(
            'vhloCfgLimitacionTipos' => $vhloCfgLimitacionTipos,
        ));
    }

    /**
     * Creates a new vhloCfgLimitacionTipo entity.
     *
     * @Route("/new", name="vhlocfglimitaciontipo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $vhloCfgLimitacionTipo = new Vhlocfglimitaciontipo();
        $form = $this->createForm('JHWEB\VehiculoBundle\Form\VhloCfgLimitacionTipoType', $vhloCfgLimitacionTipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($vhloCfgLimitacionTipo);
            $em->flush();

            return $this->redirectToRoute('vhlocfglimitaciontipo_show', array('id' => $vhloCfgLimitacionTipo->getId()));
        }

        return $this->render('vhlocfglimitaciontipo/new.html.twig', array(
            'vhloCfgLimitacionTipo' => $vhloCfgLimitacionTipo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a vhloCfgLimitacionTipo entity.
     *
     * @Route("/{id}/show", name="vhlocfglimitaciontipo_show")
     * @Method("GET")
     */
    public function showAction(VhloCfgLimitacionTipo $vhloCfgLimitacionTipo)
    {
        $deleteForm = $this->createDeleteForm($vhloCfgLimitacionTipo);

        return $this->render('vhlocfglimitaciontipo/show.html.twig', array(
            'vhloCfgLimitacionTipo' => $vhloCfgLimitacionTipo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vhloCfgLimitacionTipo entity.
     *
     * @Route("/{id}/edit", name="vhlocfglimitaciontipo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, VhloCfgLimitacionTipo $vhloCfgLimitacionTipo)
    {
        $deleteForm = $this->createDeleteForm($vhloCfgLimitacionTipo);
        $editForm = $this->createForm('JHWEB\VehiculoBundle\Form\VhloCfgLimitacionTipoType', $vhloCfgLimitacionTipo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vhlocfglimitaciontipo_edit', array('id' => $vhloCfgLimitacionTipo->getId()));
        }

        return $this->render('vhlocfglimitaciontipo/edit.html.twig', array(
            'vhloCfgLimitacionTipo' => $vhloCfgLimitacionTipo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a vhloCfgLimitacionTipo entity.
     *
     * @Route("/{id}/delete", name="vhlocfglimitaciontipo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, VhloCfgLimitacionTipo $vhloCfgLimitacionTipo)
    {
        $form = $this->createDeleteForm($vhloCfgLimitacionTipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vhloCfgLimitacionTipo);
            $em->flush();
        }

        return $this->redirectToRoute('vhlocfglimitaciontipo_index');
    }

    /**
     * Creates a form to delete a vhloCfgLimitacionTipo entity.
     *
     * @param VhloCfgLimitacionTipo $vhloCfgLimitacionTipo The vhloCfgLimitacionTipo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloCfgLimitacionTipo $vhloCfgLimitacionTipo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhlocfglimitaciontipo_delete', array('id' => $vhloCfgLimitacionTipo->getId())))
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
        
        $tipos = $em->getRepository('JHWEBVehiculoBundle:VhloCfgLimitacionTipo')->findBy(
            array(
                'activo' => true
            )
        );

        $response = null;

        foreach ($tipos as $key => $tipo) {
            $response[$key] = array(
                'value' => $tipo->getId(),
                'label' => $tipo->getNombre()
            );
        }
        return $helpers->json($response);
    }
}
