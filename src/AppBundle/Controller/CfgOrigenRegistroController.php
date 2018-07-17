<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CfgOrigenRegistro;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cfgorigenregistro controller.
 *
 * @Route("/cfgorigenregistro")
 */
class CfgOrigenRegistroController extends Controller
{
    /**
     * Lists all cfgOrigenRegistro entities.
     *
     * @Route("/", name="cfgorigenregistro_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cfgOrigenRegistros = $em->getRepository('AppBundle:CfgOrigenRegistro')->findAll();

        return $this->render('cfgorigenregistro/index.html.twig', array(
            'cfgOrigenRegistros' => $cfgOrigenRegistros,
        ));
    }

    /**
     * Creates a new cfgOrigenRegistro entity.
     *
     * @Route("/new", name="cfgorigenregistro_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $cfgOrigenRegistro = new Cfgorigenregistro();
        $form = $this->createForm('AppBundle\Form\CfgOrigenRegistroType', $cfgOrigenRegistro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cfgOrigenRegistro);
            $em->flush();

            return $this->redirectToRoute('cfgorigenregistro_show', array('id' => $cfgOrigenRegistro->getId()));
        }

        return $this->render('cfgorigenregistro/new.html.twig', array(
            'cfgOrigenRegistro' => $cfgOrigenRegistro,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a cfgOrigenRegistro entity.
     *
     * @Route("/{id}", name="cfgorigenregistro_show")
     * @Method("GET")
     */
    public function showAction(CfgOrigenRegistro $cfgOrigenRegistro)
    {
        $deleteForm = $this->createDeleteForm($cfgOrigenRegistro);

        return $this->render('cfgorigenregistro/show.html.twig', array(
            'cfgOrigenRegistro' => $cfgOrigenRegistro,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cfgOrigenRegistro entity.
     *
     * @Route("/{id}/edit", name="cfgorigenregistro_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CfgOrigenRegistro $cfgOrigenRegistro)
    {
        $deleteForm = $this->createDeleteForm($cfgOrigenRegistro);
        $editForm = $this->createForm('AppBundle\Form\CfgOrigenRegistroType', $cfgOrigenRegistro);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cfgorigenregistro_edit', array('id' => $cfgOrigenRegistro->getId()));
        }

        return $this->render('cfgorigenregistro/edit.html.twig', array(
            'cfgOrigenRegistro' => $cfgOrigenRegistro,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cfgOrigenRegistro entity.
     *
     * @Route("/{id}", name="cfgorigenregistro_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CfgOrigenRegistro $cfgOrigenRegistro)
    {
        $form = $this->createDeleteForm($cfgOrigenRegistro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cfgOrigenRegistro);
            $em->flush();
        }

        return $this->redirectToRoute('cfgorigenregistro_index');
    }

    /**
     * Creates a form to delete a cfgOrigenRegistro entity.
     *
     * @param CfgOrigenRegistro $cfgOrigenRegistro The cfgOrigenRegistro entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgOrigenRegistro $cfgOrigenRegistro)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgorigenregistro_delete', array('id' => $cfgOrigenRegistro->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    
    /**
    * datos select
    *
    *@Route("/select", name="origenregistro_select")
    *@Method({"GET","POST"})
    */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $cfgOrigenRegistros = $em->getRepository('AppBundle:CfgOrigenRegistro')->findBy(
        array('estado' => 1)
    );
    
    foreach ($cfgOrigenRegistros as $key => $cfgOrigenRegistro) {
        $response[$key] = array(
            'value' => $cfgOrigenRegistro->getId(),
            'label' => $cfgOrigenRegistro->getNombre(),
        );
      }
       return $helpers->json($response);
    }

}
