<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CfgTipoDestino;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * CfgTipoDestino controller.
 *
 * @Route("cfgtipodestino")
 */
class CfgTipoDestinoController extends Controller
{
    /**
     * Lists all cfgTipoDestino entities.
     *
     */
    public function indexAction()
    {
        /*$helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $tiposDestino = $em->getRepository('AppBundle:CfgTipoDestino')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($tiposDestino) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => count($tiposDestino)." Registros encontrados",
                'data'=> $tiposDestino,
            );
        }

        return $helpers->json($response);*/

        $em = $this->getDoctrine()->getManager();

        $cfgTipoDestinos = $em->getRepository('AppBundle:CfgTipoDestino')->findAll();

        return $this->render('cfgTipoDestino/index.html.twig', array(
            'cfgTipoDestinos' => $cfgTipoDestinos,
        ));
    }

    /**
     * Creates a new cfgTipoDestino entity.
     *
     */
    public function newAction(Request $request)
    {
        $cfgTipoDestino = new CfgTipoDestino();
        $form = $this->createForm('AppBundle\Form\CfgTipoDestinoType', $cfgTipoDestino);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cfgTipoDestino);
            $em->flush();

            return $this->redirectToRoute('cfgTipoDestino_show', array('id' => $cfgTipoDestino->getId()));
        }

        return $this->render('cfgTipoDestino/new.html.twig', array(
            'cfgTipoDestino' => $cfgTipoDestino,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a cfgTipoDestino entity.
     *
     */
    public function showAction(CfgTipoDestino $cfgTipoDestino)
    {
        $deleteForm = $this->createDeleteForm($cfgTipoDestino);

        return $this->render('cfgTipoDestino/show.html.twig', array(
            'cfgTipoDestino' => $cfgTipoDestino,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cfgTipoDestino entity.
     *
     */
    public function editAction(Request $request, CfgTipoDestino $cfgTipoDestino)
    {
        $deleteForm = $this->createDeleteForm($cfgTipoDestino);
        $editForm = $this->createForm('AppBundle\Form\CfgTipoDestinoType', $cfgTipoDestino);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cfgTipoDestino_edit', array('id' => $cfgTipoDestino->getId()));
        }

        return $this->render('cfgTipoDestino/edit.html.twig', array(
            'cfgTipoDestino' => $cfgTipoDestino,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cfgTipoDestino entity.
     *
     */
    public function deleteAction(Request $request, CfgTipoDestino $cfgTipoDestino)
    {
        $form = $this->createDeleteForm($cfgTipoDestino);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cfgTipoDestino);
            $em->flush();
        }

        return $this->redirectToRoute('cfgTipoDestino_index');
    }

    /**
     * Creates a form to delete a cfgTipoDestino entity.
     *
     * @param CfgTipoDestino $cfgTipoDestino The cfgTipoDestino entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgTipoDestino $cfgTipoDestino)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgTipoDestino_delete', array('id' => $cfgTipoDestino->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="cfgtipodestino_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        $tiposDestino = $em->getRepository('AppBundle:CfgTipoDestino')->findBy(
            array('estado' => 1)
        );

        $response = null;
        
        foreach ($tiposDestino as $key => $cfgTipoDestino) {
            $response[$key] = array(
                'value' => $cfgTipoDestino->getId(),
                'label' => $cfgTipoDestino->getNombre(),
            );
        }
        return $helpers->json($response);
    }
}
