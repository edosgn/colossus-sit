<?php

namespace JHWEB\ConfigBundle\Controller;

use JHWEB\ConfigBundle\Entity\CfgSvSenialEstado;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cfgsvsenialestado controller.
 *
 * @Route("cfgsvsenialestado")
 */
class CfgSvSenialEstadoController extends Controller
{
    /**
     * Lists all cfgSvSenialEstado entities.
     *
     * @Route("/", name="cfgsvsenialestado_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $estados = $em->getRepository('JHWEBConfigBundle:CfgSvSenialEstado')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($estados) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($estados)." registros encontrados", 
                'data'=> $estados,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new cfgSvSenialEstado entity.
     *
     * @Route("/new", name="cfgsvsenialestado_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("json",null);
            $params = json_decode($json);
           
            $estado = new CfgSvSenialEstado();

            $estado->setNombre($params->nombre);
            $estado->setActivo(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($estado);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con exito",
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Finds and displays a cfgSvSenialEstado entity.
     *
     * @Route("/{id}/show", name="cfgsvsenialestado_show")
     * @Method("GET")
     */
    public function showAction(CfgSvSenialEstado $cfgSvSenialEstado)
    {
        $deleteForm = $this->createDeleteForm($cfgSvSenialEstado);

        return $this->render('cfgsvsenialestado/show.html.twig', array(
            'cfgSvSenialEstado' => $cfgSvSenialEstado,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cfgSvSenialEstado entity.
     *
     * @Route("/edit", name="cfgsvsenialestado_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            
            $estado = $em->getRepository("JHWEBConfigBundle:CfgSvSenialEstado")->find(
                $params->id
            );

            if ($estado) {
                $estado->setNombre($params->nombre);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $conector,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorizacion no valida para editar", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a cfgSvSenialEstado entity.
     *
     * @Route("/{id}/delete", name="cfgsvsenialestado_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CfgSvSenialEstado $cfgSvSenialEstado)
    {
        $form = $this->createDeleteForm($cfgSvSenialEstado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cfgSvSenialEstado);
            $em->flush();
        }

        return $this->redirectToRoute('cfgsvsenialestado_index');
    }

    /**
     * Creates a form to delete a cfgSvSenialEstado entity.
     *
     * @param CfgSvSenialEstado $cfgSvSenialEstado The cfgSvSenialEstado entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgSvSenialEstado $cfgSvSenialEstado)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgsvsenialestado_delete', array('id' => $cfgSvSenialEstado->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="cfgsvsenialestado_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $estados = $em->getRepository('JHWEBConfigBundle:CfgSvSenialEstado')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($estados as $key => $estado) {
            $response[$key] = array(
                'value' => $estado->getId(),
                'label' => $estado->getNombre()
            );
        }
        return $helpers->json($response);
    }
}
