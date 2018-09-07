<?php

namespace JHWEB\ConfigBundle\Controller;

use JHWEB\ConfigBundle\Entity\CfgSvSenialColor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cfgsvsenialcolor controller.
 *
 * @Route("cfgsvsenialcolor")
 */
class CfgSvSenialColorController extends Controller
{
    /**
     * Lists all cfgSvSenialColor entities.
     *
     * @Route("/", name="cfgsvsenialcolor_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $colores = $em->getRepository('JHWEBConfigBundle:CfgSvSenialColor')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($colores) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($colores)." registros encontrados", 
                'data'=> $colores,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new cfgSvSenialColor entity.
     *
     * @Route("/new", name="cfgsvsenialcolor_new")
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
           
            $color = new CfgSvSenialColor();

            $color->setNombre($params->nombre);
            $color->setActivo(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($color);
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
     * Finds and displays a cfgSvSenialColor entity.
     *
     * @Route("/{id}/show", name="cfgsvsenialcolor_show")
     * @Method("GET")
     */
    public function showAction(CfgSvSenialColor $cfgSvSenialColor)
    {
        $deleteForm = $this->createDeleteForm($cfgSvSenialColor);

        return $this->render('cfgsvsenialcolor/show.html.twig', array(
            'cfgSvSenialColor' => $cfgSvSenialColor,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cfgSvSenialColor entity.
     *
     * @Route("/edit", name="cfgsvsenialcolor_edit")
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

            $color = $em->getRepository("JHWEBConfigBundle:CfgSvSenialColor")->find(
                $params->id
            );

            if ($color) {
                $color->setNombre($params->nombre);
                
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
     * Deletes a cfgSvSenialColor entity.
     *
     * @Route("/{id}/delete", name="cfgsvsenialcolor_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CfgSvSenialColor $cfgSvSenialColor)
    {
        $form = $this->createDeleteForm($cfgSvSenialColor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cfgSvSenialColor);
            $em->flush();
        }

        return $this->redirectToRoute('cfgsvsenialcolor_index');
    }

    /**
     * Creates a form to delete a cfgSvSenialColor entity.
     *
     * @param CfgSvSenialColor $cfgSvSenialColor The cfgSvSenialColor entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgSvSenialColor $cfgSvSenialColor)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgsvsenialcolor_delete', array('id' => $cfgSvSenialColor->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="cfgsvsenialcolor_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $colores = $em->getRepository('JHWEBConfigBundle:CfgSvSenialColor')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($colores as $key => $color) {
            $response[$key] = array(
                'value' => $color->getId(),
                'label' => $color->getNombre()
            );
        }
        return $helpers->json($response);
    }
}
