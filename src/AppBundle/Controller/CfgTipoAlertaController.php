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
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $tiposAlerta = $em->getRepository('AppBundle:CfgTipoAlerta')->findAll();

        $response['data'] = array();

        if ($tiposAlerta) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($tiposAlerta)." registros encontrados", 
                'data'=> $tiposAlerta,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new cfgTipoAlertum entity.
     *
     * @Route("/new", name="cfgtipoalerta_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);
           
            $tipoAlerta = new CfgTipoAlerta();

            $tipoAlerta->setNombre(strtoupper($params->nombre));
            $tipoAlerta->setActivo(true);

            $em = $this->getDoctrine()->getManager();

            $em->persist($tipoAlerta);
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
     * Finds and displays a cfgTipoAlertum entity.
     *
     * @Route("/show", name="cfgtipoalerta_show")
     * @Method("POST")
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $tipoAlerta = $em->getRepository('AppBundle:CfgTipoAlerta')->find(
                $params->id
            );

            if ($tipoAlerta) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado", 
                    'data'=> $tipoAlerta,
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
                'message' => "Autorizacion no valida", 
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing cfgTipoAlertum entity.
     *
     * @Route("/edit", name="cfgtipoalerta_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            $tipoAlerta = $em->getRepository("AppBundle:CfgTipoAlerta")->find(
                $params->id
            );

            if ($tipoAlerta) {
                $tipoAlerta->setNombre(strtoupper($params->nombre));
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $tipoAlerta,
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
     * Deletes a cfgTipoAlertum entity.
     *
     * @Route("/{id}/delete", name="cfgtipoalerta_delete")
     * @Method("POST")
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

        
        $tiposAlerta = $em->getRepository('AppBundle:CfgTipoAlerta')->findAll();

        $response = null;

        foreach ($tiposAlerta as $key => $tipoAlerta) {
            $response[$key] = array(
                'value' => $tipoAlerta->getId(),
                'label' => $tipoAlerta->getNombre()
            );
        }
        
        return $helpers->json($response);
    }
}
