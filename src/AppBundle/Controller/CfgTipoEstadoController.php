<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CfgTipoEstado;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * CfgTipoEstado controller.
 *
 * @Route("cfgtipoestado")
 */
class CfgTipoEstadoController extends Controller
{
    /**
     * Lists all cfgTipoEstado entities.
     *
     */
    public function indexAction()
    {
        /*$helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $tiposEstado = $em->getRepository('AppBundle:CfgTipoEstado')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($tiposEstado) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => count($tiposEstado)." Registros encontrados",
                'data'=> $tiposEstado,
            );
        }

        return $helpers->json($response);*/

        $em = $this->getDoctrine()->getManager();

        $cfgTipoEstados = $em->getRepository('AppBundle:CfgTipoEstado')->findAll();

        return $this->render('cfgTipoEstado/index.html.twig', array(
            'cfgTipoEstados' => $cfgTipoEstados,
        ));
    }

    /**
     * Creates a new cfgTipoEstado entity.
     *
     */
    public function newAction(Request $request)
    {
        $cfgTipoEstado = new CfgTipoEstado();
        $form = $this->createForm('AppBundle\Form\CfgTipoEstadoType', $cfgTipoEstado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cfgTipoEstado);
            $em->flush();

            return $this->redirectToRoute('cfgTipoEstado_show', array('id' => $cfgTipoEstado->getId()));
        }

        return $this->render('cfgTipoEstado/new.html.twig', array(
            'cfgTipoEstado' => $cfgTipoEstado,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a cfgTipoEstado entity.
     *
     */
    public function showAction(CfgTipoEstado $cfgTipoEstado)
    {
        $deleteForm = $this->createDeleteForm($cfgTipoEstado);

        return $this->render('cfgTipoEstado/show.html.twig', array(
            'cfgTipoEstado' => $cfgTipoEstado,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cfgTipoEstado entity.
     *
     */
    public function editAction(Request $request, CfgTipoEstado $cfgTipoEstado)
    {
        $deleteForm = $this->createDeleteForm($cfgTipoEstado);
        $editForm = $this->createForm('AppBundle\Form\CfgTipoEstadoType', $cfgTipoEstado);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cfgTipoEstado_edit', array('id' => $cfgTipoEstado->getId()));
        }

        return $this->render('cfgTipoEstado/edit.html.twig', array(
            'cfgTipoEstado' => $cfgTipoEstado,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cfgTipoEstado entity.
     *
     */
    public function deleteAction(Request $request, CfgTipoEstado $cfgTipoEstado)
    {
        $form = $this->createDeleteForm($cfgTipoEstado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cfgTipoEstado);
            $em->flush();
        }

        return $this->redirectToRoute('cfgTipoEstado_index');
    }

    /**
     * Creates a form to delete a cfgTipoEstado entity.
     *
     * @param CfgTipoEstado $cfgTipoEstado The cfgTipoEstado entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgTipoEstado $cfgTipoEstado)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgTipoEstado_delete', array('id' => $cfgTipoEstado->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="cfgtipoEstado_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $tiposEstado = $em->getRepository('AppBundle:CfgTipoEstado')->findBy(
            array('estado' => 1)
        );
        foreach ($tiposEstado as $key => $cfgTipoEstado) {
            $response[$key] = array(
                'value' => $cfgTipoEstado->getId(),
                'label' => $cfgTipoEstado->getNombre(),
            );
        }
        return $helpers->json($response);
    }
}
