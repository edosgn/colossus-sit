<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CfgAuditoria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Cfgauditoria controller.
 *
 * @Route("cfgauditoria")
 */
class CfgAuditoriaController extends Controller
{
    /**
     * Lists all cfgAuditoria entities.
     *
     * @Route("/", name="cfgauditoria_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $auditorias = $em->getRepository('AppBundle:CfgAuditoria')->findAll();

        $response['data'] = array();

        if ($auditorias) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => count($auditorias)." Registros encontrados", 
                'data'=> $auditorias,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new cfgAuditoria entity.
     *
     * @Route("/new", name="cfgauditoria_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization",null);
        $authCheck = $helpers->authCheck($hash);
        if($authCheck == true){
            $json = $request->get("json",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $ip = $request->getClientIp();
            
            $auditoria = new CfgAuditoria();
            $auditoria->setFecha(new \Datetime(date('Y-m-d h:i:s')));
            $auditoria->setUrl($params->url);
            $auditoria->setToken($params->token);
            $auditoria->setDatos($params->json);
            $auditoria->setAccion($params->action);
            $auditoria->setIp($ip);
            
            $em->persist($auditoria);
            $em->flush();
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "Registro creado con éxito",
            );
            
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorización no valida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Finds and displays a cfgAuditoria entity.
     *
     * @Route("/{id}", name="cfgauditoria_show")
     * @Method("GET")
     */
    public function showAction(CfgAuditoria $cfgAuditoria)
    {
        $deleteForm = $this->createDeleteForm($cfgAuditoria);

        return $this->render('cfgauditoria/show.html.twig', array(
            'cfgAuditoria' => $cfgAuditoria,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cfgAuditoria entity.
     *
     * @Route("/{id}/edit", name="cfgauditoria_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CfgAuditoria $cfgAuditoria)
    {
        $deleteForm = $this->createDeleteForm($cfgAuditoria);
        $editForm = $this->createForm('AppBundle\Form\CfgAuditoriaType', $cfgAuditoria);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cfgauditoria_edit', array('id' => $cfgAuditoria->getId()));
        }

        return $this->render('cfgauditoria/edit.html.twig', array(
            'cfgAuditoria' => $cfgAuditoria,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cfgAuditoria entity.
     *
     * @Route("/{id}", name="cfgauditoria_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CfgAuditoria $cfgAuditoria)
    {
        $form = $this->createDeleteForm($cfgAuditoria);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cfgAuditoria);
            $em->flush();
        }

        return $this->redirectToRoute('cfgauditoria_index');
    }

    /**
     * Creates a form to delete a cfgAuditoria entity.
     *
     * @param CfgAuditoria $cfgAuditoria The cfgAuditoria entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgAuditoria $cfgAuditoria)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgauditoria_delete', array('id' => $cfgAuditoria->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
