<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TipoCorrespondencia;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Tipocorrespondencium controller.
 *
 * @Route("tipocorrespondencia")
 */
class TipoCorrespondenciaController extends Controller
{
    /**
     * Lists all tipoCorrespondencia entities.
     *
     * @Route("/", name="tipocorrespondencia_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $tipoCorrespondencias = $em->getRepository('AppBundle:TipoCorrespondencia')->findBy(
            array('estado' => true)
        );

        $response = array(
            'status' => 'success',
            'code' => 200,
            'msj' => "Lista de tipos de correspondencia", 
            'data'=> $tipoCorrespondencias,
        );
     
        return $helpers->json($response);
    }

    /**
     * Creates a new tipoCorrespondencia entity.
     *
     * @Route("/new", name="tipocorrespondencia_new")
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
                $tipoCorrespondencia = new TipoCorrespondencia();

                $tipoCorrespondencia->setNombre($params->nombre);
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
     * Finds and displays a tipoCorrespondencia entity.
     *
     * @Route("/show/{id}", name="tipocorrespondencia_show")
     * @Method("POST")
     */
    public function showAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $tipoCorrespondencia = $em->getRepository('AppBundle:TipoCorrespondencia')->find($id);
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "tipoCorrespondencia con nombre"." ".$tipoCorrespondencia->getNombre(), 
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
     * Displays a form to edit an existing tipoCorrespondencia entity.
     *
     * @Route("/edit", name="tipocorrespondencia_edit")
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
            $tipoCorrespondencia = $em->getRepository("AppBundle:TipoCorrespondencia")->find($params->id);

            if ($tipoCorrespondencia!=null) {
                $tipoCorrespondencia->setNombre($params->nombre);
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($tipoCorrespondencia);
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
     * Deletes a tipoCorrespondencia entity.
     *
     * @Route("/{id}/delete", name="tipocorrespondencia_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $tipoCorrespondencia = $em->getRepository('AppBundle:TipoCorrespondencia')->find($id);

            $tipoCorrespondencia->setEstado(0);
            $em = $this->getDoctrine()->getManager();
                $em->persist($tipoCorrespondencia);
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
                    'msj' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a tipoCorrespondencia entity.
     *
     * @param TipoCorrespondencia $tipoCorrespondencia The tipoCorrespondencia entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TipoCorrespondencia $tipoCorrespondencia)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tipocorrespondencia_delete', array('id' => $tipoCorrespondencia->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="tipocorrespondencia_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $tipoCorrespondencias = $em->getRepository('AppBundle:TipoCorrespondencia')->findBy(
        array('estado' => true)
    );
      foreach ($tipoCorrespondencias as $key => $tipoCorrespondencia) {
        $response[$key] = array(
            'value' => $tipoCorrespondencia->getId(),
            'label' => $tipoCorrespondencia->getNombre(),
            );
      }
       return $helpers->json($response);
    }
}
