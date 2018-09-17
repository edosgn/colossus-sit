<?php

namespace JHWEB\ConfigBundle\Controller;

use JHWEB\ConfigBundle\Entity\CfgSvSenialTipo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cfgsvsenialtipo controller.
 *
 * @Route("cfgsvsenialtipo")
 */
class CfgSvSenialTipoController extends Controller
{
    /**
     * Lists all cfgSvSenialTipo entities.
     *
     * @Route("/", name="cfgsvsenialtipo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $tipos = $em->getRepository('JHWEBConfigBundle:CfgSvSenialTipo')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($tipos) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($tipos)." registros encontrados", 
                'data'=> $tipos,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new cfgSvSenialTipo entity.
     *
     * @Route("/new", name="cfgsvsenialtipo_new")
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
           
            $tipo = new CfgSvSenialTipo();

            $tipo->setNombre($params->nombre);
            $tipo->setActivo(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($tipo);
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
     * Finds and displays a cfgSvSenialTipo entity.
     *
     * @Route("/{id}/show", name="cfgsvsenialtipo_show")
     * @Method("GET")
     */
    public function showAction(CfgSvSenialTipo $cfgSvSenialTipo)
    {
        $deleteForm = $this->createDeleteForm($cfgSvSenialTipo);

        return $this->render('cfgsvsenialtipo/show.html.twig', array(
            'cfgSvSenialTipo' => $cfgSvSenialTipo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cfgSvSenialTipo entity.
     *
     * @Route("/edit", name="cfgsvsenialtipo_edit")
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
            
            $tipo = $em->getRepository("JHWEBConfigBundle:CfgSvSenialTipo")->find(
                $params->id
            );

            if ($tipo) {
                $tipo->setNombre($params->nombre);
                
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
     * Deletes a cfgSvSenialTipo entity.
     *
     * @Route("/{id}/delete", name="cfgsvsenialtipo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CfgSvSenialTipo $cfgSvSenialTipo)
    {
        $form = $this->createDeleteForm($cfgSvSenialTipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cfgSvSenialTipo);
            $em->flush();
        }

        return $this->redirectToRoute('cfgsvsenialtipo_index');
    }

    /**
     * Creates a form to delete a cfgSvSenialTipo entity.
     *
     * @param CfgSvSenialTipo $cfgSvSenialTipo The cfgSvSenialTipo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgSvSenialTipo $cfgSvSenialTipo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgsvsenialtipo_delete', array('id' => $cfgSvSenialTipo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="cfgsvsenialtipo_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $tipos = $em->getRepository('JHWEBConfigBundle:CfgSvSenialTipo')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($tipos as $key => $tipo) {
            $response[$key] = array(
                'value' => $tipo->getId(),
                'label' => $tipo->getNombre()
            );
        }
        return $helpers->json($response);
    }
}
