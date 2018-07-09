<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CfgModalidadTransporte;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cfgmodalidadtransporte controller.
 *
 * @Route("cfgmodalidadtransporte")
 */
class CfgModalidadTransporteController extends Controller
{
    /**
     * Lists all cfgModalidadTransporte entities.
     *
     * @Route("/", name="cfgmodalidadtransporte_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cfgModalidadTransportes = $em->getRepository('AppBundle:CfgModalidadTransporte')->findAll();

        return $this->render('cfgmodalidadtransporte/index.html.twig', array(
            'cfgModalidadTransportes' => $cfgModalidadTransportes,
        ));
    }

    /**
     * Creates a new cfgModalidadTransporte entity.
     *
     * @Route("/new", name="cfgmodalidadtransporte_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $cfgModalidadTransporte = new Cfgmodalidadtransporte();
        $form = $this->createForm('AppBundle\Form\CfgModalidadTransporteType', $cfgModalidadTransporte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cfgModalidadTransporte);
            $em->flush();

            return $this->redirectToRoute('cfgmodalidadtransporte_show', array('id' => $cfgModalidadTransporte->getId()));
        }

        return $this->render('cfgmodalidadtransporte/new.html.twig', array(
            'cfgModalidadTransporte' => $cfgModalidadTransporte,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a cfgModalidadTransporte entity.
     *
     * @Route("/{id}/show", name="cfgmodalidadtransporte_show")
     * @Method("GET")
     */
    public function showAction(CfgModalidadTransporte $cfgModalidadTransporte)
    {
        $deleteForm = $this->createDeleteForm($cfgModalidadTransporte);

        return $this->render('cfgmodalidadtransporte/show.html.twig', array(
            'cfgModalidadTransporte' => $cfgModalidadTransporte,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cfgModalidadTransporte entity.
     *
     * @Route("/{id}/edit", name="cfgmodalidadtransporte_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CfgModalidadTransporte $cfgModalidadTransporte)
    {
        $deleteForm = $this->createDeleteForm($cfgModalidadTransporte);
        $editForm = $this->createForm('AppBundle\Form\CfgModalidadTransporteType', $cfgModalidadTransporte);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cfgmodalidadtransporte_edit', array('id' => $cfgModalidadTransporte->getId()));
        }

        return $this->render('cfgmodalidadtransporte/edit.html.twig', array(
            'cfgModalidadTransporte' => $cfgModalidadTransporte,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cfgModalidadTransporte entity.
     *
     * @Route("/{id}/delete", name="cfgmodalidadtransporte_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CfgModalidadTransporte $cfgModalidadTransporte)
    {
        $form = $this->createDeleteForm($cfgModalidadTransporte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cfgModalidadTransporte);
            $em->flush();
        }

        return $this->redirectToRoute('cfgmodalidadtransporte_index');
    }

    /**
     * Creates a form to delete a cfgModalidadTransporte entity.
     *
     * @param CfgModalidadTransporte $cfgModalidadTransporte The cfgModalidadTransporte entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgModalidadTransporte $cfgModalidadTransporte)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgmodalidadtransporte_delete', array('id' => $cfgModalidadTransporte->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="cfgmodalidadtransporte_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $modalidades = $em->getRepository('AppBundle:CfgModalidadTransporte')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($modalidades as $key => $modalidad) {
            $response[$key] = array(
                'value' => $modalidad->getId(),
                'label' => $modalidad->getNombre()
            );
        }
        return $helpers->json($response);
    }
}
