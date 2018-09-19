<?php

namespace JHWEB\ConfigBundle\Controller;

use JHWEB\ConfigBundle\Entity\CfgAdmFormatoTipo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cfgadmformatotipo controller.
 *
 * @Route("cfgadmformatotipo")
 */
class CfgAdmFormatoTipoController extends Controller
{
    /**
     * Lists all cfgAdmFormatoTipo entities.
     *
     * @Route("/", name="cfgadmformatotipo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cfgAdmFormatoTipos = $em->getRepository('JHWEBConfigBundle:CfgAdmFormatoTipo')->findAll();

        return $this->render('cfgadmformatotipo/index.html.twig', array(
            'cfgAdmFormatoTipos' => $cfgAdmFormatoTipos,
        ));
    }

    /**
     * Creates a new cfgAdmFormatoTipo entity.
     *
     * @Route("/new", name="cfgadmformatotipo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $cfgAdmFormatoTipo = new Cfgadmformatotipo();
        $form = $this->createForm('JHWEB\ConfigBundle\Form\CfgAdmFormatoTipoType', $cfgAdmFormatoTipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cfgAdmFormatoTipo);
            $em->flush();

            return $this->redirectToRoute('cfgadmformatotipo_show', array('id' => $cfgAdmFormatoTipo->getId()));
        }

        return $this->render('cfgadmformatotipo/new.html.twig', array(
            'cfgAdmFormatoTipo' => $cfgAdmFormatoTipo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a cfgAdmFormatoTipo entity.
     *
     * @Route("/{id}", name="cfgadmformatotipo_show")
     * @Method("GET")
     */
    public function showAction(CfgAdmFormatoTipo $cfgAdmFormatoTipo)
    {
        $deleteForm = $this->createDeleteForm($cfgAdmFormatoTipo);

        return $this->render('cfgadmformatotipo/show.html.twig', array(
            'cfgAdmFormatoTipo' => $cfgAdmFormatoTipo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cfgAdmFormatoTipo entity.
     *
     * @Route("/{id}/edit", name="cfgadmformatotipo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CfgAdmFormatoTipo $cfgAdmFormatoTipo)
    {
        $deleteForm = $this->createDeleteForm($cfgAdmFormatoTipo);
        $editForm = $this->createForm('JHWEB\ConfigBundle\Form\CfgAdmFormatoTipoType', $cfgAdmFormatoTipo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cfgadmformatotipo_edit', array('id' => $cfgAdmFormatoTipo->getId()));
        }

        return $this->render('cfgadmformatotipo/edit.html.twig', array(
            'cfgAdmFormatoTipo' => $cfgAdmFormatoTipo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cfgAdmFormatoTipo entity.
     *
     * @Route("/{id}", name="cfgadmformatotipo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CfgAdmFormatoTipo $cfgAdmFormatoTipo)
    {
        $form = $this->createDeleteForm($cfgAdmFormatoTipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cfgAdmFormatoTipo);
            $em->flush();
        }

        return $this->redirectToRoute('cfgadmformatotipo_index');
    }

    /**
     * Creates a form to delete a cfgAdmFormatoTipo entity.
     *
     * @param CfgAdmFormatoTipo $cfgAdmFormatoTipo The cfgAdmFormatoTipo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgAdmFormatoTipo $cfgAdmFormatoTipo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgadmformatotipo_delete', array('id' => $cfgAdmFormatoTipo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
