<?php

namespace JHWEB\FinancieroBundle\Controller;

use JHWEB\FinancieroBundle\Entity\FroFacTransferencia;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Frofactransferencium controller.
 *
 * @Route("frofactransferencia")
 */
class FroFacTransferenciaController extends Controller
{
    /**
     * Lists all froFacTransferencium entities.
     *
     * @Route("/", name="frofactransferencia_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $froFacTransferencias = $em->getRepository('JHWEBFinancieroBundle:FroFacTransferencia')->findAll();

        return $this->render('frofactransferencia/index.html.twig', array(
            'froFacTransferencias' => $froFacTransferencias,
        ));
    }

    /**
     * Creates a new froFacTransferencium entity.
     *
     * @Route("/new", name="frofactransferencia_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $froFacTransferencium = new Frofactransferencium();
        $form = $this->createForm('JHWEB\FinancieroBundle\Form\FroFacTransferenciaType', $froFacTransferencium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($froFacTransferencium);
            $em->flush();

            return $this->redirectToRoute('frofactransferencia_show', array('id' => $froFacTransferencium->getId()));
        }

        return $this->render('frofactransferencia/new.html.twig', array(
            'froFacTransferencium' => $froFacTransferencium,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a froFacTransferencium entity.
     *
     * @Route("/{id}/show", name="frofactransferencia_show")
     * @Method("GET")
     */
    public function showAction(FroFacTransferencia $froFacTransferencium)
    {
        $deleteForm = $this->createDeleteForm($froFacTransferencium);

        return $this->render('frofactransferencia/show.html.twig', array(
            'froFacTransferencium' => $froFacTransferencium,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing froFacTransferencium entity.
     *
     * @Route("/{id}/edit", name="frofactransferencia_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FroFacTransferencia $froFacTransferencium)
    {
        $deleteForm = $this->createDeleteForm($froFacTransferencium);
        $editForm = $this->createForm('JHWEB\FinancieroBundle\Form\FroFacTransferenciaType', $froFacTransferencium);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('frofactransferencia_edit', array('id' => $froFacTransferencium->getId()));
        }

        return $this->render('frofactransferencia/edit.html.twig', array(
            'froFacTransferencium' => $froFacTransferencium,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a froFacTransferencium entity.
     *
     * @Route("/{id}/delete", name="frofactransferencia_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FroFacTransferencia $froFacTransferencium)
    {
        $form = $this->createDeleteForm($froFacTransferencium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($froFacTransferencium);
            $em->flush();
        }

        return $this->redirectToRoute('frofactransferencia_index');
    }

    /**
     * Creates a form to delete a froFacTransferencium entity.
     *
     * @param FroFacTransferencia $froFacTransferencium The froFacTransferencium entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FroFacTransferencia $froFacTransferencium)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('frofactransferencia_delete', array('id' => $froFacTransferencium->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ===================================================== */

    /**
     * reporte de transferencias.
     *
     * @Route("/report/transfer", name="frofactransferencia_report_transfer")
     * @Method({"GET", "POST"})
     */
    public function reportTransferAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization",null);
        $authCheck = $helpers->authCheck($hash);

        if($authCheck == true){
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $tranferencias = $em->getRepository('JHWEBFinancieroBundle:FroFacTransferencia')->getReportTransfer(
                new \Datetime($params->fechaInicial),
                new \Datetime($params->fechaFinal)
            );

            if ($tranferencias) {
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($tranferencias)." registros encontrados.",
                    'data' => $tranferencias,
                );
            } else {
                $response = array(
                    'title' => 'Atención!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => "Ningún registro encontrado.",
                );
            }
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no valida",
            );
        }
        
        return $helpers->json($response);
    }
}
