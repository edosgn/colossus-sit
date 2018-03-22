<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\TipoIdentificacion;
use AppBundle\Form\TipoIdentificacionType;

/**
 * TipoIdentificacion controller.
 *
 * @Route("/tipoidentificacion")
 */
class TipoIdentificacionController extends Controller
{
    /**
     * Lists all TipoIdentificacion entities.
     *
     * @Route("/", name="tipoidentificacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $tipoIdentificaiones = $em->getRepository('AppBundle:TipoIdentificacion')->findBy(
            array('estado' => 1)
        );
        $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado Tipos de identificaion", 
                    'data'=> $tipoIdentificaiones,
            );
         
        return $helpers->json($responce);
    }

    /**
     * Creates a new TipoIdentificacion entity.
     *
     * @Route("/new", name="tipoidentificacion_new")
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
            if (count($params)==0) {
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "los campos no pueden estar vacios", 
                );
            }else{
                        $nombre = $params->nombre;
                        $tipoIdentificacion = new TipoIdentificacion();

                        $tipoIdentificacion->setNombre($nombre);
                        $tipoIdentificacion->setEstado(true);

                        $em = $this->getDoctrine()->getManager();
                        $em->persist($tipoIdentificacion);
                        $em->flush();

                        $responce = array(
                            'status' => 'success',
                            'code' => 200,
                            'msj' => "Tipo identificaion creado con exito", 
                        );
                       
                    }
        }else{
            $responce = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida", 
            );
            } 
        return $helpers->json($responce);
    }

    /**
     * Finds and displays a TipoIdentificacion entity.
     *
     * @Route("/show/{id}", name="tipoidentificacion_show")
     * @Method("POST")
     */
    public function showAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $tipoIdentificacion = $em->getRepository('AppBundle:TipoIdentificacion')->find($id);
            $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "tipoIdentificacion con nombre"." ".$tipoIdentificacion->getNombre(), 
                    'data'=> $tipoIdentificacion,
            );
        }else{
            $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($responce);
    }

    /**
     * Displays a form to edit an existing TipoIdentificacion entity.
     *
     * @Route("/edit", name="tipoidentificacion_edit")
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

            
            $nombre = $params->nombre;

            $em = $this->getDoctrine()->getManager();
            $tipoIdentificacion = $em->getRepository("AppBundle:TipoIdentificacion")->find($params->id);

            if ($tipoIdentificacion!=null) {
                $tipoIdentificacion->setNombre($nombre);
                $em = $this->getDoctrine()->getManager();
                $em->persist($tipoIdentificacion);
                $em->flush();

                 $responce = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "tipoIdentificacion actualizado con exito", 
                        'data'=> $tipoIdentificacion,
                );
            }else{
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El tipoIdentificacion no se encuentra en la base de datos", 
                );
            }
        }else{
            $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar tipoIdentificacion", 
                );
        }

        return $helpers->json($responce);
    }

    /**
     * Deletes a TipoIdentificacion entity.
     *
     * @Route("/{id}/delete", name="tipoidentificacion_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $tipoIdentificacion = $em->getRepository('AppBundle:TipoIdentificacion')->find($id);

            $tipoIdentificacion->setEstado(0);
            $em = $this->getDoctrine()->getManager();
                $em->persist($tipoIdentificacion);
                $em->flush();
            $responce = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "tipoIdentificacion eliminado con exito", 
                );
        }else{
            $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($responce);
    }

    /**
     * Creates a form to delete a TipoIdentificacion entity.
     *
     * @param TipoIdentificacion $tipoIdentificacion The TipoIdentificacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TipoIdentificacion $tipoIdentificacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tipoidentificacion_delete', array('id' => $tipoIdentificacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="tipoIdentificacion_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $tipoIdentificacions = $em->getRepository('AppBundle:TipoIdentificacion')->findBy(
        array('estado' => 1)
    );
      foreach ($tipoIdentificacions as $key => $tipoIdentificacion) {
        $responce[$key] = array(
            'value' => $tipoIdentificacion->getId(),
            'label' => $tipoIdentificacion->getNombre(),
            );
      }
       return $helpers->json($responce);
    }
}
