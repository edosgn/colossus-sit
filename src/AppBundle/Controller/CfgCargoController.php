<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CfgCargo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Cfgcargo controller.
 *
 * @Route("cfgcargo")
 */
class CfgCargoController extends Controller
{
    /**
     * Lists all cfgCargo entities.
     *
     * @Route("/", name="cfgcargo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $cargos = $em->getRepository('AppBundle:CfgCargo')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($cargos) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($cargos)." registros encontrados", 
                'data'=> $cargos,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new cfgCargo entity.
     *
     * @Route("/new", name="cfgcargo_new")
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

            /*if (count($params)==0) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "los campos no pueden estar vacios", 
                );
            }else{*/
                $cargo = new CfgCargo();

                $cargo->setNombre($params->nombre);
                $cargo->setActivo(true);

                $em = $this->getDoctrine()->getManager();
                $em->persist($cargo);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro creado con exito",
                );
            //}
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
     * Finds and displays a cfgCargo entity.
     *
     * @Route("/{id}/show", name="cfgcargo_show")
     * @Method("GET")
     */
    public function showAction(CfgCargo $cfgCargo)
    {
        $deleteForm = $this->createDeleteForm($cfgCargo);

        return $this->render('cfgcargo/show.html.twig', array(
            'cfgCargo' => $cfgCargo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cfgCargo entity.
     *
     * @Route("/edit", name="cfgcargo_edit")
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
            $cargo = $em->getRepository("AppBundle:CfgCargo")->find($params->id);

            if ($cargo!=null) {
                $cargo->setNombre($params->nombre);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $cargo,
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
     * Deletes a cfgCargo entity.
     *
     * @Route("/delete", name="cfgcargo_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if($authCheck == true){
            $json = $request->get("json",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            $cargo = $em->getRepository('AppBundle:CfgCargo')->find($params->id);
            
            $cargo->setActivo(false);
            $em->flush();

            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro eliminado con éxito", 
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
     * Creates a form to delete a cfgCargo entity.
     *
     * @param CfgCargo $cfgCargo The cfgCargo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgCargo $cfgCargo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgcargo_delete', array('id' => $cfgCargo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="cfgcargo_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $cargos = $em->getRepository('AppBundle:CfgCargo')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($cargos as $key => $cargo) {
            $response[$key] = array(
                'value' => $cargo->getId(),
                'label' => $cargo->getNombre()
            );
        }
        return $helpers->json($response);
    }
}
