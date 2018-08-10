<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MgdTipoCorrespondencia;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Mgdtipocorrespondencium controller.
 *
 * @Route("mgdtipocorrespondencia")
 */
class MgdTipoCorrespondenciaController extends Controller
{
    /**
     * Lists all mgdTipoCorrespondencium entities.
     *
     * @Route("/", name="mgdtipocorrespondencia_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $tiposCorrespondencia = $em->getRepository('AppBundle:MgdTipoCorrespondencia')->findBy(
            array('estado' => true)
        );

        $response = array(
            'status' => 'success',
            'code' => 200,
            'msj' => "Lista de tipos de correspondencia", 
            'data'=> $tiposCorrespondencia,
        );
     
        return $helpers->json($response);
    }

    /**
     * Creates a new mgdTipoCorrespondencium entity.
     *
     * @Route("/new", name="mgdtipocorrespondencia_new")
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
                    'msj' => "los campos no pueden estar vacios", 
                );
            }else{*/
                $tipoCorrespondencia = new MgdTipoCorrespondencia();

                $tipoCorrespondencia->setNombre($params->nombre);
                $tipoCorrespondencia->setDiasVigencia($params->diasVigencia);

                if ($params->editable) {
                    $tipoCorrespondencia->setEditable($params->editable);
                }

                if ($params->prohibicion) {
                    $tipoCorrespondencia->setProhibicion($params->prohibicion);
                }

                $tipoCorrespondencia->setEstado(true);

                $em = $this->getDoctrine()->getManager();
                $em->persist($tipoCorrespondencia);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro creado con exito",  
                );
            //}
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida", 
            );
        } 
        return $helpers->json($response);
    }

    /**
     * Finds and displays a mgdTipoCorrespondencium entity.
     *
     * @Route("/{id}/show", name="mgdtipocorrespondencia_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $tipoCorrespondencia = $em->getRepository('AppBundle:MgdTipoCorrespondencia')->find($id);
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro encontrado", 
                    'data'=> $tipoCorrespondencia,
            );
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing mgdTipoCorrespondencium entity.
     *
     * @Route("/edit", name="mgdtipocorrespondencia_edit")
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
            $tipoCorrespondencia = $em->getRepository("AppBundle:MgdTipoCorrespondencia")->find($params->id);

            if ($tipoCorrespondencia!=null) {
                $tipoCorrespondencia->setNombre($params->nombre);
                $tipoCorrespondencia->setDiasVigencia($params->diasVigencia);

                if ($params->editable) {
                    $tipoCorrespondencia->setEditable($params->editable);
                }

                if ($params->prohibicion) {
                    $tipoCorrespondencia->setProhibicion($params->prohibicion);
                }
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro actualizado con exito", 
                    'data'=> $tipoCorrespondencia,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El registro no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a mgdTipoCorrespondencium entity.
     *
     * @Route("/{id}/delete", name="mgdtipocorrespondencia_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $tipoCorrespondencia = $em->getRepository('AppBundle:MgdTipoCorrespondencia')->find($id);

            if ($tipoCorrespondencia) {
                $tipoCorrespondencia->setEstado(false);
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $response = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "Registro eliminado con exito", 
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El registro no se encuentra en la base de datos", 
                );
            }

        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a mgdTipoCorrespondencium entity.
     *
     * @param MgdTipoCorrespondencia $mgdTipoCorrespondencium The mgdTipoCorrespondencium entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MgdTipoCorrespondencia $mgdTipoCorrespondencium)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mgdtipocorrespondencia_delete', array('id' => $mgdTipoCorrespondencium->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="mgdtipocorrespondencia_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $tipoCorrespondencias = $em->getRepository('AppBundle:MgdTipoCorrespondencia')->findBy(
            array('estado' => true)
        );

        foreach ($tipoCorrespondencias as $key => $tipoCorrespondencia) {
            $response[$key] = array(
                'value' => $tipoCorrespondencia->getId(),
                'label' => $tipoCorrespondencia->getNombre()
            );
        }
        return $helpers->json($response);
    }
}
