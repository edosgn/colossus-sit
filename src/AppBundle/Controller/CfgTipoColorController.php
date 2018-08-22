<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CfgTipoColor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * CfgTipoColor controller.
 *
 * @Route("cfgtipocolor")
 */
class CfgTipoColorController extends Controller
{
    /**
     * Lists all cfgTipoColor entities.
     *
     */
    public function indexAction()
    {
        /*$helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $tiposColor = $em->getRepository('AppBundle:CfgTipoColor')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($tiposColor) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => count($tiposColor)." Registros encontrados",
                'data'=> $tiposColor,
            );
        }

        return $helpers->json($response);*/

        $em = $this->getDoctrine()->getManager();

        $cfgTipoColors = $em->getRepository('AppBundle:CfgTipoColor')->findAll();

        return $this->render('cfgTipoColor/index.html.twig', array(
            'cfgTipoColors' => $cfgTipoColors,
        ));
    }

    /**
     * Creates a new cfgTipoColor entity.
     *
     */
    public function newAction(Request $request)
    {
        $cfgTipoColor = new CfgTipoColor();
        $form = $this->createForm('AppBundle\Form\CfgTipoColorType', $cfgTipoColor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cfgTipoColor);
            $em->flush();

            return $this->redirectToRoute('cfgTipoColor_show', array('id' => $cfgTipoColor->getId()));
        }

        return $this->render('cfgTipoColor/new.html.twig', array(
            'cfgTipoColor' => $cfgTipoColor,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a cfgTipoColor entity.
     *
     */
    public function showAction(CfgTipoColor $cfgTipoColor)
    {
        $deleteForm = $this->createDeleteForm($cfgTipoColor);

        return $this->render('cfgTipoColor/show.html.twig', array(
            'cfgTipoColor' => $cfgTipoColor,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cfgTipoColor entity.
     *
     */
    public function editAction(Request $request, CfgTipoColor $cfgTipoColor)
    {
        $deleteForm = $this->createDeleteForm($cfgTipoColor);
        $editForm = $this->createForm('AppBundle\Form\CfgTipoColorType', $cfgTipoColor);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cfgTipoColor_edit', array('id' => $cfgTipoColor->getId()));
        }

        return $this->render('cfgTipoColor/edit.html.twig', array(
            'cfgTipoColor' => $cfgTipoColor,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cfgTipoColor entity.
     *
     */
    public function deleteAction(Request $request, CfgTipoColor $cfgTipoColor)
    {
        $form = $this->createDeleteForm($cfgTipoColor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cfgTipoColor);
            $em->flush();
        }

        return $this->redirectToRoute('cfgTipoColor_index');
    }

    /**
     * Creates a form to delete a cfgTipoColor entity.
     *
     * @param CfgTipoColor $cfgTipoColor The cfgTipoColor entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgTipoColor $cfgTipoColor)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgTipoColor_delete', array('id' => $cfgTipoColor->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="cfgtipoColor_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        
        $em = $this->getDoctrine()->getManager();
        $tiposColor = $em->getRepository('AppBundle:CfgTipoColor')->findBy(
            array('estado' => 1), array('nombre' => 'ASC')
        );
        $response = null;

        foreach ($tiposColor as $key => $cfgTipoColor) {
            $response[$key] = array(
                'value' => $cfgTipoColor->getId(),
                'label' => $cfgTipoColor->getNombre(),
                'other'   => $cfgTipoColor->getHex(),
            );
        }
        return $helpers->json($response);
    }
}
