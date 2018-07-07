<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CfgTipoAlerta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cfgtipoalertum controller.
 *
 * @Route("cfgtipoalerta")
 */
class CfgTipoAlertaController extends Controller
{
    /**
     * Lists all cfgTipoAlertum entities.
     *
     * @Route("/", name="cfgtipoalerta_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cfgTipoAlertas = $em->getRepository('AppBundle:CfgTipoAlerta')->findAll();

        return $this->render('cfgtipoalerta/index.html.twig', array(
            'cfgTipoAlertas' => $cfgTipoAlertas,
        ));
    }

    /**
     * Creates a new cfgTipoAlertum entity.
     *
     * @Route("/new", name="cfgtipoalerta_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $cfgTipoAlertum = new Cfgtipoalertum();
        $form = $this->createForm('AppBundle\Form\CfgTipoAlertaType', $cfgTipoAlertum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cfgTipoAlertum);
            $em->flush();

            return $this->redirectToRoute('cfgtipoalerta_show', array('id' => $cfgTipoAlertum->getId()));
        }

        return $this->render('cfgtipoalerta/new.html.twig', array(
            'cfgTipoAlertum' => $cfgTipoAlertum,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a cfgTipoAlertum entity.
     *
     * @Route("/{id}", name="cfgtipoalerta_show")
     * @Method("GET")
     */
    public function showAction(CfgTipoAlerta $cfgTipoAlertum)
    {
        $deleteForm = $this->createDeleteForm($cfgTipoAlertum);

        return $this->render('cfgtipoalerta/show.html.twig', array(
            'cfgTipoAlertum' => $cfgTipoAlertum,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cfgTipoAlertum entity.
     *
     * @Route("/{id}/edit", name="cfgtipoalerta_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CfgTipoAlerta $cfgTipoAlertum)
    {
        $deleteForm = $this->createDeleteForm($cfgTipoAlertum);
        $editForm = $this->createForm('AppBundle\Form\CfgTipoAlertaType', $cfgTipoAlertum);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cfgtipoalerta_edit', array('id' => $cfgTipoAlertum->getId()));
        }

        return $this->render('cfgtipoalerta/edit.html.twig', array(
            'cfgTipoAlertum' => $cfgTipoAlertum,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cfgTipoAlertum entity.
     *
     * @Route("/{id}", name="cfgtipoalerta_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CfgTipoAlerta $cfgTipoAlertum)
    {
        $form = $this->createDeleteForm($cfgTipoAlertum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cfgTipoAlertum);
            $em->flush();
        }

        return $this->redirectToRoute('cfgtipoalerta_index');
    }

    /**
     * Creates a form to delete a cfgTipoAlertum entity.
     *
     * @param CfgTipoAlerta $cfgTipoAlertum The cfgTipoAlertum entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgTipoAlerta $cfgTipoAlertum)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgtipoalerta_delete', array('id' => $cfgTipoAlertum->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="alerta_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $alertas = $em->getRepository('AppBundle:Alerta')->findBy(
        array('estado' => 1)
    );
      foreach ($alertas as $key => $alerta) {
        $response[$key] = array(
            'value' => $alerta->getId(),
            'label' => $alerta->getNombre()."_".$alerta->getNombre(),
            );
      }
       return $helpers->json($response);
    }
}
