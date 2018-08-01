<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CfgEmpresaGps;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cfgempresagp controller.
 *
 * @Route("cfgempresagps")
 */
class CfgEmpresaGpsController extends Controller
{
    /**
     * Lists all cfgEmpresaGp entities.
     *
     * @Route("/", name="cfgempresagps_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cfgEmpresaGps = $em->getRepository('AppBundle:CfgEmpresaGps')->findAll();

        return $this->render('cfgempresagps/index.html.twig', array(
            'cfgEmpresaGps' => $cfgEmpresaGps,
        ));
    }

    /**
     * Creates a new cfgEmpresaGp entity.
     *
     * @Route("/new", name="cfgempresagps_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $cfgEmpresaGp = new Cfgempresagp();
        $form = $this->createForm('AppBundle\Form\CfgEmpresaGpsType', $cfgEmpresaGp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cfgEmpresaGp);
            $em->flush();

            return $this->redirectToRoute('cfgempresagps_show', array('id' => $cfgEmpresaGp->getId()));
        }

        return $this->render('cfgempresagps/new.html.twig', array(
            'cfgEmpresaGp' => $cfgEmpresaGp,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a cfgEmpresaGp entity.
     *
     * @Route("/{id}/show", name="cfgempresagps_show")
     * @Method("GET")
     */
    public function showAction(CfgEmpresaGps $cfgEmpresaGp)
    {
        $deleteForm = $this->createDeleteForm($cfgEmpresaGp);

        return $this->render('cfgempresagps/show.html.twig', array(
            'cfgEmpresaGp' => $cfgEmpresaGp,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cfgEmpresaGp entity.
     *
     * @Route("/{id}/edit", name="cfgempresagps_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CfgEmpresaGps $cfgEmpresaGp)
    {
        $deleteForm = $this->createDeleteForm($cfgEmpresaGp);
        $editForm = $this->createForm('AppBundle\Form\CfgEmpresaGpsType', $cfgEmpresaGp);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cfgempresagps_edit', array('id' => $cfgEmpresaGp->getId()));
        }

        return $this->render('cfgempresagps/edit.html.twig', array(
            'cfgEmpresaGp' => $cfgEmpresaGp,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cfgEmpresaGp entity.
     *
     * @Route("/{id}/delete", name="cfgempresagps_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CfgEmpresaGps $cfgEmpresaGp)
    {
        $form = $this->createDeleteForm($cfgEmpresaGp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cfgEmpresaGp);
            $em->flush();
        }

        return $this->redirectToRoute('cfgempresagps_index');
    }

    /**
     * Creates a form to delete a cfgEmpresaGp entity.
     *
     * @param CfgEmpresaGps $cfgEmpresaGp The cfgEmpresaGp entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgEmpresaGps $cfgEmpresaGp)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgempresagps_delete', array('id' => $cfgEmpresaGp->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="cfgempresagps_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $cfgEmpresasGps = $em->getRepository('AppBundle:CfgEmpresaGps')->findBy(
            array('estado' => 1)
        );

        $response = null;
        foreach ($cfgEmpresasGps as $key => $cfgEmpresaGps) {
            $response[$key] = array(
                'value' => $cfgEmpresaGps->getId(),
                'label' => $cfgEmpresaGps->getNombre(),
            );
        }
        
        return $helpers->json($response);
    }
}
