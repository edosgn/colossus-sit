<?php

namespace JHWEB\ConfigBundle\Controller;

use JHWEB\ConfigBundle\Entity\CfgAdmActoAdministrativo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Cfgadmactoadministrativo controller.
 *
 * @Route("cfgadmactoadministrativo")
 */
class CfgAdmActoAdministrativoController extends Controller
{
    /**
     * Lists all cfgAdmActoAdministrativo entities.
     *
     * @Route("/", name="cfgadmactoadministrativo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cfgAdmActoAdministrativos = $em->getRepository('JHWEBConfigBundle:CfgAdmActoAdministrativo')->findAll();

        return $this->render('cfgadmactoadministrativo/index.html.twig', array(
            'cfgAdmActoAdministrativos' => $cfgAdmActoAdministrativos,
        ));
    }

    /**
     * Creates a new cfgAdmActoAdministrativo entity.
     *
     * @Route("/new", name="cfgadmactoadministrativo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $cfgAdmActoAdministrativo = new Cfgadmactoadministrativo();
        $form = $this->createForm('JHWEB\ConfigBundle\Form\CfgAdmActoAdministrativoType', $cfgAdmActoAdministrativo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cfgAdmActoAdministrativo);
            $em->flush();

            return $this->redirectToRoute('cfgadmactoadministrativo_show', array('id' => $cfgAdmActoAdministrativo->getId()));
        }

        return $this->render('cfgadmactoadministrativo/new.html.twig', array(
            'cfgAdmActoAdministrativo' => $cfgAdmActoAdministrativo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a cfgAdmActoAdministrativo entity.
     *
     * @Route("/{id}/show", name="cfgadmactoadministrativo_show")
     * @Method("GET")
     */
    public function showAction(CfgAdmActoAdministrativo $cfgAdmActoAdministrativo)
    {
        $deleteForm = $this->createDeleteForm($cfgAdmActoAdministrativo);

        return $this->render('cfgadmactoadministrativo/show.html.twig', array(
            'cfgAdmActoAdministrativo' => $cfgAdmActoAdministrativo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cfgAdmActoAdministrativo entity.
     *
     * @Route("/{id}/edit", name="cfgadmactoadministrativo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CfgAdmActoAdministrativo $cfgAdmActoAdministrativo)
    {
        $deleteForm = $this->createDeleteForm($cfgAdmActoAdministrativo);
        $editForm = $this->createForm('JHWEB\ConfigBundle\Form\CfgAdmActoAdministrativoType', $cfgAdmActoAdministrativo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cfgadmactoadministrativo_edit', array('id' => $cfgAdmActoAdministrativo->getId()));
        }

        return $this->render('cfgadmactoadministrativo/edit.html.twig', array(
            'cfgAdmActoAdministrativo' => $cfgAdmActoAdministrativo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cfgAdmActoAdministrativo entity.
     *
     * @Route("/{id}/delete", name="cfgadmactoadministrativo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CfgAdmActoAdministrativo $cfgAdmActoAdministrativo)
    {
        $form = $this->createDeleteForm($cfgAdmActoAdministrativo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cfgAdmActoAdministrativo);
            $em->flush();
        }

        return $this->redirectToRoute('cfgadmactoadministrativo_index');
    }

    /**
     * Creates a form to delete a cfgAdmActoAdministrativo entity.
     *
     * @param CfgAdmActoAdministrativo $cfgAdmActoAdministrativo The cfgAdmActoAdministrativo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgAdmActoAdministrativo $cfgAdmActoAdministrativo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgadmactoadministrativo_delete', array('id' => $cfgAdmActoAdministrativo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ===================================== */

    /**
     * PDF
     *
     * @Route("/{id}/pdf", name="cfgadmactoadministrativo_pdf")
     * @Method({"GET", "POST"})
     */
    public function pdfAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $trazabilidad = $em->getRepository('JHWEBContravencionalBundle:CvCdoTrazabilidad')->find(
            $id
        );

        $html = $this->renderView('@App/default/pdf.actoAdministrativo.html.twig', array(
            'trazabilidad' => $trazabilidad
        ));

        $this->get('app.pdf')->templatePreview($html, $trazabilidad->getActoAdministrativo()->getNumero());
    }
}
