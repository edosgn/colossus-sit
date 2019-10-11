<?php

namespace JHWEB\ConfigBundle\Controller;

use JHWEB\ConfigBundle\Entity\CfgAuditoria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cfgauditorium controller.
 *
 * @Route("cfgauditoria")
 */
class CfgAuditoriaController extends Controller
{
    /**
     * Lists all cfgAuditorium entities.
     *
     * @Route("/", name="cfgauditoria_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $auditorias = $em->getRepository('JHWEBConfigBundle:CfgAuditoria')->findAll();

        $response['data'] = array();

        if ($auditorias) {
            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => count($auditorias)." Registros encontrados", 
                'data'=> $auditorias,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new cfgAuditorium entity.
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
            $json = $request->get("data", null);
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

            $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findOneBy(
                array(
                    'identificacion' => $params->identificacion
                )
            );

            $funcionario = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->findOneBy(
                array(
                    'ciudadano' => $ciudadano->getId()
                )
            );

            $auditoria->setFuncionario($funcionario);
            
            $em->persist($auditoria);
            $em->flush();
            
            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con éxito",
            );
            
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

    /**
     * Finds and displays a cfgAuditorium entity.
     *
     * @Route("/{id}/show", name="cfgauditoria_show")
     * @Method("GET")
     */
    public function showAction(CfgAuditoria $cfgAuditorium)
    {
        $deleteForm = $this->createDeleteForm($cfgAuditorium);

        return $this->render('cfgauditoria/show.html.twig', array(
            'cfgAuditorium' => $cfgAuditorium,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cfgAuditorium entity.
     *
     * @Route("/{id}/edit", name="cfgauditoria_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CfgAuditoria $cfgAuditorium)
    {
        $deleteForm = $this->createDeleteForm($cfgAuditorium);
        $editForm = $this->createForm('JHWEB\ConfigBundle\Form\CfgAuditoriaType', $cfgAuditorium);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cfgauditoria_edit', array('id' => $cfgAuditorium->getId()));
        }

        return $this->render('cfgauditoria/edit.html.twig', array(
            'cfgAuditorium' => $cfgAuditorium,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cfgAuditorium entity.
     *
     * @Route("/{id}/delete", name="cfgauditoria_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CfgAuditoria $cfgAuditorium)
    {
        $form = $this->createDeleteForm($cfgAuditorium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cfgAuditorium);
            $em->flush();
        }

        return $this->redirectToRoute('cfgauditoria_index');
    }

    /**
     * Creates a form to delete a cfgAuditorium entity.
     *
     * @param CfgAuditoria $cfgAuditorium The cfgAuditorium entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgAuditoria $cfgAuditorium)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgauditoria_delete', array('id' => $cfgAuditorium->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
