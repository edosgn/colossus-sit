<?php

namespace JHWEB\ConfigBundle\Controller;

use JHWEB\ConfigBundle\Entity\CfgSvUnidadMedida;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cfgsvunidadmedida controller.
 *
 * @Route("cfgsvunidadmedida")
 */
class CfgSvUnidadMedidaController extends Controller
{
    /**
     * Lists all cfgSvUnidadMedida entities.
     *
     * @Route("/", name="cfgsvunidadmedida_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $medidas = $em->getRepository('JHWEBConfigBundle:CfgSvUnidadMedida')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($medidas) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($medidas)." registros encontrados", 
                'data'=> $medidas,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new cfgSvUnidadMedida entity.
     *
     * @Route("/new", name="cfgsvunidadmedida_new")
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
           
            $medida = new CfgSvUnidadMedida();

            $medida->setNombre($params->nombre);
            $medida->setActivo(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($medida);
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
     * Finds and displays a cfgSvUnidadMedida entity.
     *
     * @Route("/{id}/show", name="cfgsvunidadmedida_show")
     * @Method("GET")
     */
    public function showAction(CfgSvUnidadMedida $cfgSvUnidadMedida)
    {
        $deleteForm = $this->createDeleteForm($cfgSvUnidadMedida);

        return $this->render('cfgsvunidadmedida/show.html.twig', array(
            'cfgSvUnidadMedida' => $cfgSvUnidadMedida,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cfgSvUnidadMedida entity.
     *
     * @Route("/edit", name="cfgsvunidadmedida_edit")
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
            
            $medida = $em->getRepository("JHWEBConfigBundle:CfgSvUnidadMedida")->find(
                $params->id
            );

            if ($medida) {
                $medida->setNombre($params->nombre);
                
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
     * Deletes a cfgSvUnidadMedida entity.
     *
     * @Route("/{id}/delete", name="cfgsvunidadmedida_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CfgSvUnidadMedida $cfgSvUnidadMedida)
    {
        $form = $this->createDeleteForm($cfgSvUnidadMedida);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cfgSvUnidadMedida);
            $em->flush();
        }

        return $this->redirectToRoute('cfgsvunidadmedida_index');
    }

    /**
     * Creates a form to delete a cfgSvUnidadMedida entity.
     *
     * @param CfgSvUnidadMedida $cfgSvUnidadMedida The cfgSvUnidadMedida entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgSvUnidadMedida $cfgSvUnidadMedida)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgsvunidadmedida_delete', array('id' => $cfgSvUnidadMedida->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="cfgsvunidadmedida_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $medidas = $em->getRepository('JHWEBConfigBundle:CfgSvUnidadMedida')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($medidas as $key => $medida) {
            $response[$key] = array(
                'value' => $medida->getId(),
                'label' => $medida->getNombre()
            );
        }
        return $helpers->json($response);
    }
}
