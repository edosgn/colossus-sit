<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgSenialProveedor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgsenialproveedor controller.
 *
 * @Route("svcfgsenialproveedor")
 */
class SvCfgSenialProveedorController extends Controller
{
    /**
     * Lists all svCfgSenialProveedor entities.
     *
     * @Route("/", name="svcfgsenialproveedor_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $proveedores = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenialProveedor')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($proveedores) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($proveedores)." registros encontrados", 
                'data'=> $proveedores,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new svCfgSenialProveedor entity.
     *
     * @Route("/new", name="svcfgsenialproveedor_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $svCfgSenialProveedor = new Svcfgsenialproveedor();
        $form = $this->createForm('JHWEB\SeguridadVialBundle\Form\SvCfgSenialProveedorType', $svCfgSenialProveedor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($svCfgSenialProveedor);
            $em->flush();

            return $this->redirectToRoute('svcfgsenialproveedor_show', array('id' => $svCfgSenialProveedor->getId()));
        }

        return $this->render('svcfgsenialproveedor/new.html.twig', array(
            'svCfgSenialProveedor' => $svCfgSenialProveedor,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a svCfgSenialProveedor entity.
     *
     * @Route("/{id}", name="svcfgsenialproveedor_show")
     * @Method("GET")
     */
    public function showAction(SvCfgSenialProveedor $svCfgSenialProveedor)
    {
        $deleteForm = $this->createDeleteForm($svCfgSenialProveedor);

        return $this->render('svcfgsenialproveedor/show.html.twig', array(
            'svCfgSenialProveedor' => $svCfgSenialProveedor,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing svCfgSenialProveedor entity.
     *
     * @Route("/{id}/edit", name="svcfgsenialproveedor_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SvCfgSenialProveedor $svCfgSenialProveedor)
    {
        $deleteForm = $this->createDeleteForm($svCfgSenialProveedor);
        $editForm = $this->createForm('JHWEB\SeguridadVialBundle\Form\SvCfgSenialProveedorType', $svCfgSenialProveedor);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('svcfgsenialproveedor_edit', array('id' => $svCfgSenialProveedor->getId()));
        }

        return $this->render('svcfgsenialproveedor/edit.html.twig', array(
            'svCfgSenialProveedor' => $svCfgSenialProveedor,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a svCfgSenialProveedor entity.
     *
     * @Route("/{id}", name="svcfgsenialproveedor_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SvCfgSenialProveedor $svCfgSenialProveedor)
    {
        $form = $this->createDeleteForm($svCfgSenialProveedor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($svCfgSenialProveedor);
            $em->flush();
        }

        return $this->redirectToRoute('svcfgsenialproveedor_index');
    }

    /**
     * Creates a form to delete a svCfgSenialProveedor entity.
     *
     * @param SvCfgSenialProveedor $svCfgSenialProveedor The svCfgSenialProveedor entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgSenialProveedor $svCfgSenialProveedor)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svcfgsenialproveedor_delete', array('id' => $svCfgSenialProveedor->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
