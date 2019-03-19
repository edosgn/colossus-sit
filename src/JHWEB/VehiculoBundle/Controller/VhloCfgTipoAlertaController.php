<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloCfgTipoAlerta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlocfgtipoalertum controller.
 *
 * @Route("vhlocfgtipoalerta")
 */
class VhloCfgTipoAlertaController extends Controller
{
    /**
     * Lists all vhloCfgTipoAlertum entities.
     *
     * @Route("/", name="vhlocfgtipoalerta_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $vhloCfgTipoAlertas = $em->getRepository('JHWEBVehiculoBundle:VhloCfgTipoAlerta')->findAll();

        return $this->render('vhlocfgtipoalerta/index.html.twig', array(
            'vhloCfgTipoAlertas' => $vhloCfgTipoAlertas,
        ));
    }

    /**
     * Creates a new vhloCfgTipoAlertum entity.
     *
     * @Route("/new", name="vhlocfgtipoalerta_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $vhloCfgTipoAlertum = new Vhlocfgtipoalertum();
        $form = $this->createForm('JHWEB\VehiculoBundle\Form\VhloCfgTipoAlertaType', $vhloCfgTipoAlertum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($vhloCfgTipoAlertum);
            $em->flush();

            return $this->redirectToRoute('vhlocfgtipoalerta_show', array('id' => $vhloCfgTipoAlertum->getId()));
        }

        return $this->render('vhlocfgtipoalerta/new.html.twig', array(
            'vhloCfgTipoAlertum' => $vhloCfgTipoAlertum,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a vhloCfgTipoAlertum entity.
     *
     * @Route("/{id}/show", name="vhlocfgtipoalerta_show")
     * @Method("GET")
     */
    public function showAction(VhloCfgTipoAlerta $vhloCfgTipoAlertum)
    {
        $deleteForm = $this->createDeleteForm($vhloCfgTipoAlertum);

        return $this->render('vhlocfgtipoalerta/show.html.twig', array(
            'vhloCfgTipoAlertum' => $vhloCfgTipoAlertum,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vhloCfgTipoAlertum entity.
     *
     * @Route("/{id}/edit", name="vhlocfgtipoalerta_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, VhloCfgTipoAlerta $vhloCfgTipoAlertum)
    {
        $deleteForm = $this->createDeleteForm($vhloCfgTipoAlertum);
        $editForm = $this->createForm('JHWEB\VehiculoBundle\Form\VhloCfgTipoAlertaType', $vhloCfgTipoAlertum);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vhlocfgtipoalerta_edit', array('id' => $vhloCfgTipoAlertum->getId()));
        }

        return $this->render('vhlocfgtipoalerta/edit.html.twig', array(
            'vhloCfgTipoAlertum' => $vhloCfgTipoAlertum,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a vhloCfgTipoAlertum entity.
     *
     * @Route("/{id}/delete", name="vhlocfgtipoalerta_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, VhloCfgTipoAlerta $vhloCfgTipoAlertum)
    {
        $form = $this->createDeleteForm($vhloCfgTipoAlertum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vhloCfgTipoAlertum);
            $em->flush();
        }

        return $this->redirectToRoute('vhlocfgtipoalerta_index');
    }

    /**
     * Creates a form to delete a vhloCfgTipoAlertum entity.
     *
     * @param VhloCfgTipoAlerta $vhloCfgTipoAlertum The vhloCfgTipoAlertum entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloCfgTipoAlerta $vhloCfgTipoAlertum)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhlocfgtipoalerta_delete', array('id' => $vhloCfgTipoAlertum->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* =================================================== */

    /**
     * Listado con tipos de alerta para seleección con búsqueda
     *
     * @Route("/select", name="vhlocfgtipoalerta_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $alertas = $em->getRepository('JHWEBVehiculoBundle:VhloCfgTipoAlerta')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($alertas as $key => $alerta) {
            $response[$key] = array(
                'value' => $alerta->getId(),
                'label' => $alerta->getNombre()
            );
        }
        
        return $helpers->json($response);
    }
}
