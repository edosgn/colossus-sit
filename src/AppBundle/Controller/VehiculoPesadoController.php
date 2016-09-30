<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\VehiculoPesado;
use AppBundle\Form\VehiculoPesadoType;

/**
 * VehiculoPesado controller.
 *
 * @Route("/vehiculopesado")
 */
class VehiculoPesadoController extends Controller
{
    /**
     * Lists all VehiculoPesado entities.
     *
     * @Route("/", name="vehiculopesado_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $vehiculoPesados = $em->getRepository('AppBundle:VehiculoPesado')->findAll();

        return $this->render('AppBundle:VehiculoPesado:index.html.twig', array(
            'vehiculoPesados' => $vehiculoPesados,
        ));
    }

    /**
     * Creates a new VehiculoPesado entity.
     *
     * @Route("/new", name="vehiculopesado_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $vehiculoPesado = new VehiculoPesado();
        $form = $this->createForm('AppBundle\Form\VehiculoPesadoType', $vehiculoPesado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($vehiculoPesado);
            $em->flush();

            return $this->redirectToRoute('vehiculopesado_show', array('id' => $vehiculoPesado->getId()));
        }

        return $this->render('AppBundle:VehiculoPesado:new.html.twig', array(
            'vehiculoPesado' => $vehiculoPesado,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a VehiculoPesado entity.
     *
     * @Route("/{id}", name="vehiculopesado_show")
     * @Method("GET")
     */
    public function showAction(VehiculoPesado $vehiculoPesado)
    {
        $deleteForm = $this->createDeleteForm($vehiculoPesado);

        return $this->render('AppBundle:VehiculoPesado:show.html.twig', array(
            'vehiculoPesado' => $vehiculoPesado,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing VehiculoPesado entity.
     *
     * @Route("/{id}/edit", name="vehiculopesado_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, VehiculoPesado $vehiculoPesado)
    {
        $deleteForm = $this->createDeleteForm($vehiculoPesado);
        $editForm = $this->createForm('AppBundle\Form\VehiculoPesadoType', $vehiculoPesado);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($vehiculoPesado);
            $em->flush();

            return $this->redirectToRoute('vehiculopesado_edit', array('id' => $vehiculoPesado->getId()));
        }

        return $this->render('AppBundle:VehiculoPesado:edit.html.twig', array(
            'vehiculoPesado' => $vehiculoPesado,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a VehiculoPesado entity.
     *
     * @Route("/{id}", name="vehiculopesado_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, VehiculoPesado $vehiculoPesado)
    {
        $form = $this->createDeleteForm($vehiculoPesado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vehiculoPesado);
            $em->flush();
        }

        return $this->redirectToRoute('vehiculopesado_index');
    }

    /**
     * Creates a form to delete a VehiculoPesado entity.
     *
     * @param VehiculoPesado $vehiculoPesado The VehiculoPesado entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VehiculoPesado $vehiculoPesado)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vehiculopesado_delete', array('id' => $vehiculoPesado->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
