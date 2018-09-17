<?php

namespace JHWEB\ConfigBundle\Controller;

use JHWEB\ConfigBundle\Entity\CfgAdmFormato;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cfgadmformato controller.
 *
 * @Route("cfgadmformato")
 */
class CfgAdmFormatoController extends Controller
{
    /**
     * Lists all cfgAdmFormato entities.
     *
     * @Route("/", name="cfgadmformato_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cfgAdmFormatos = $em->getRepository('JHWEBConfigBundle:CfgAdmFormato')->findAll();

        return $this->render('cfgadmformato/index.html.twig', array(
            'cfgAdmFormatos' => $cfgAdmFormatos,
        ));
    }

    /**
     * Creates a new cfgAdmFormato entity.
     *
     * @Route("/new", name="cfgadmformato_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $cfgAdmFormato = new Cfgadmformato();
        $form = $this->createForm('JHWEB\ConfigBundle\Form\CfgAdmFormatoType', $cfgAdmFormato);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cfgAdmFormato);
            $em->flush();

            return $this->redirectToRoute('cfgadmformato_show', array('id' => $cfgAdmFormato->getId()));
        }

        return $this->render('cfgadmformato/new.html.twig', array(
            'cfgAdmFormato' => $cfgAdmFormato,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a cfgAdmFormato entity.
     *
     * @Route("/{id}", name="cfgadmformato_show")
     * @Method("GET")
     */
    public function showAction(CfgAdmFormato $cfgAdmFormato)
    {
        $deleteForm = $this->createDeleteForm($cfgAdmFormato);

        return $this->render('cfgadmformato/show.html.twig', array(
            'cfgAdmFormato' => $cfgAdmFormato,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cfgAdmFormato entity.
     *
     * @Route("/{id}/edit", name="cfgadmformato_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CfgAdmFormato $cfgAdmFormato)
    {
        $deleteForm = $this->createDeleteForm($cfgAdmFormato);
        $editForm = $this->createForm('JHWEB\ConfigBundle\Form\CfgAdmFormatoType', $cfgAdmFormato);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cfgadmformato_edit', array('id' => $cfgAdmFormato->getId()));
        }

        return $this->render('cfgadmformato/edit.html.twig', array(
            'cfgAdmFormato' => $cfgAdmFormato,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cfgAdmFormato entity.
     *
     * @Route("/{id}", name="cfgadmformato_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CfgAdmFormato $cfgAdmFormato)
    {
        $form = $this->createDeleteForm($cfgAdmFormato);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cfgAdmFormato);
            $em->flush();
        }

        return $this->redirectToRoute('cfgadmformato_index');
    }

    /**
     * Creates a form to delete a cfgAdmFormato entity.
     *
     * @param CfgAdmFormato $cfgAdmFormato The cfgAdmFormato entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgAdmFormato $cfgAdmFormato)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgadmformato_delete', array('id' => $cfgAdmFormato->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
