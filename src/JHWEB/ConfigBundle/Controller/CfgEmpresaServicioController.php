<?php

namespace JHWEB\ConfigBundle\Controller;

use JHWEB\ConfigBundle\Entity\CfgEmpresaServicio;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cfgempresaservicio controller.
 *
 * @Route("cfgempresaservicio")
 */
class CfgEmpresaServicioController extends Controller
{
    /**
     * Lists all cfgEmpresaServicio entities.
     *
     * @Route("/", name="cfgempresaservicio_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cfgEmpresaServicios = $em->getRepository('JHWEBConfigBundle:CfgEmpresaServicio')->findAll();

        return $this->render('cfgempresaservicio/index.html.twig', array(
            'cfgEmpresaServicios' => $cfgEmpresaServicios,
        ));

        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $cargos = $em->getRepository('JHWEBConfigBundle:CfgEmpresaServicio')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($cargos) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($cargos)." registros encontrados", 
                'data'=> $cargos,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new cfgEmpresaServicio entity.
     *
     * @Route("/new", name="cfgempresaservicio_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $cfgEmpresaServicio = new Cfgempresaservicio();
        $form = $this->createForm('JHWEB\ConfigBundle\Form\CfgEmpresaServicioType', $cfgEmpresaServicio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cfgEmpresaServicio);
            $em->flush();

            return $this->redirectToRoute('cfgempresaservicio_show', array('id' => $cfgEmpresaServicio->getId()));
        }

        return $this->render('cfgempresaservicio/new.html.twig', array(
            'cfgEmpresaServicio' => $cfgEmpresaServicio,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a cfgEmpresaServicio entity.
     *
     * @Route("/{id}", name="cfgempresaservicio_show")
     * @Method("GET")
     */
    public function showAction(CfgEmpresaServicio $cfgEmpresaServicio)
    {
        $deleteForm = $this->createDeleteForm($cfgEmpresaServicio);

        return $this->render('cfgempresaservicio/show.html.twig', array(
            'cfgEmpresaServicio' => $cfgEmpresaServicio,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cfgEmpresaServicio entity.
     *
     * @Route("/{id}/edit", name="cfgempresaservicio_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CfgEmpresaServicio $cfgEmpresaServicio)
    {
        $deleteForm = $this->createDeleteForm($cfgEmpresaServicio);
        $editForm = $this->createForm('JHWEB\ConfigBundle\Form\CfgEmpresaServicioType', $cfgEmpresaServicio);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cfgempresaservicio_edit', array('id' => $cfgEmpresaServicio->getId()));
        }

        return $this->render('cfgempresaservicio/edit.html.twig', array(
            'cfgEmpresaServicio' => $cfgEmpresaServicio,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cfgEmpresaServicio entity.
     *
     * @Route("/{id}", name="cfgempresaservicio_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CfgEmpresaServicio $cfgEmpresaServicio)
    {
        $form = $this->createDeleteForm($cfgEmpresaServicio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cfgEmpresaServicio);
            $em->flush();
        }

        return $this->redirectToRoute('cfgempresaservicio_index');
    }

    /**
     * Creates a form to delete a cfgEmpresaServicio entity.
     *
     * @param CfgEmpresaServicio $cfgEmpresaServicio The cfgEmpresaServicio entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgEmpresaServicio $cfgEmpresaServicio)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgempresaservicio_delete', array('id' => $cfgEmpresaServicio->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
