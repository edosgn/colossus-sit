<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CfgRadioAccion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Cfgradioaccion controller.
 *
 * @Route("cfgradioaccion")
 */
class CfgRadioAccionController extends Controller
{
    /**
     * Lists all cfgRadioAccion entities.
     *
     * @Route("/", name="cfgradioaccion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cfgRadioAccions = $em->getRepository('AppBundle:CfgRadioAccion')->findAll();

        return $this->render('cfgradioaccion/index.html.twig', array(
            'cfgRadioAccions' => $cfgRadioAccions,
        ));
    }

    /**
     * Creates a new cfgRadioAccion entity.
     *
     * @Route("/new", name="cfgradioaccion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $cfgRadioAccion = new Cfgradioaccion();
        $form = $this->createForm('AppBundle\Form\CfgRadioAccionType', $cfgRadioAccion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cfgRadioAccion);
            $em->flush();

            return $this->redirectToRoute('cfgradioaccion_show', array('id' => $cfgRadioAccion->getId()));
        }

        return $this->render('cfgradioaccion/new.html.twig', array(
            'cfgRadioAccion' => $cfgRadioAccion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a cfgRadioAccion entity.
     *
     * @Route("/{id}/show", name="cfgradioaccion_show")
     * @Method("GET")
     */
    public function showAction(CfgRadioAccion $cfgRadioAccion)
    {
        $deleteForm = $this->createDeleteForm($cfgRadioAccion);

        return $this->render('cfgradioaccion/show.html.twig', array(
            'cfgRadioAccion' => $cfgRadioAccion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cfgRadioAccion entity.
     *
     * @Route("/{id}/edit", name="cfgradioaccion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CfgRadioAccion $cfgRadioAccion)
    {
        $deleteForm = $this->createDeleteForm($cfgRadioAccion);
        $editForm = $this->createForm('AppBundle\Form\CfgRadioAccionType', $cfgRadioAccion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cfgradioaccion_edit', array('id' => $cfgRadioAccion->getId()));
        }

        return $this->render('cfgradioaccion/edit.html.twig', array(
            'cfgRadioAccion' => $cfgRadioAccion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cfgRadioAccion entity.
     *
     * @Route("/{id}/delete", name="cfgradioaccion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CfgRadioAccion $cfgRadioAccion)
    {
        $form = $this->createDeleteForm($cfgRadioAccion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cfgRadioAccion);
            $em->flush();
        }

        return $this->redirectToRoute('cfgradioaccion_index');
    }

    /**
     * Creates a form to delete a cfgRadioAccion entity.
     *
     * @param CfgRadioAccion $cfgRadioAccion The cfgRadioAccion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgRadioAccion $cfgRadioAccion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgradioaccion_delete', array('id' => $cfgRadioAccion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="cfgradioaccion_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $radiosAccion = $em->getRepository('AppBundle:CfgRadioAccion')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($radiosAccion as $key => $radioAccion) {
            $response[$key] = array(
                'value' => $radioAccion->getId(),
                'label' => $radioAccion->getNombre()
            );
        }
        return $helpers->json($response);
    }
}
