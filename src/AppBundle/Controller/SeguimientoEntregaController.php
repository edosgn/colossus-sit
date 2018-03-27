<?php

namespace AppBundle\Controller;

use AppBundle\Entity\SeguimientoEntrega;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Seguimientoentrega controller.
 *
 * @Route("seguimientoentrega")
 */
class SeguimientoEntregaController extends Controller
{
    /**
     * Lists all seguimientoEntrega entities.
     *
     * @Route("/", name="seguimientoentrega_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $seguimientoEntrega = $em->getRepository('AppBundle:SeguimientoEntrega')->findAll();

        $response = array(
            'status' => 'success',
            'code' => 200,
            'msj' => "lista de seguimientos entrega",
            'data' => $seguimientoEntrega, 
        );
        return $helpers->json($response);
    }

    /**
     * Creates a new seguimientoEntrega entity.
     *
     * @Route("/new", name="seguimientoentrega_new")
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
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Los campos no pueden estar vacios", 
                );
            }else{
                $numeroRegistros = $params->numeroRegistros;
                $numeroOficio = $params->numeroOficio;
                $fechaCargue = (isset($params->fechaCargue)) ? $params->fechaCargue : null;
                $fechaCargueDateTime = new \DateTime($fechaCargue);

                $seguimientoEntrega = new SeguimientoEntrega();

                $seguimientoEntrega->setNumeroRegistros($numeroRegistros);
                $seguimientoEntrega->setNumeroOficio($numeroOficio);
                $seguimientoEntrega->setFechaCargue($fechaCargueDateTime);
                //$seguimientoEntrega->setEstado(true);

                $em = $this->getDoctrine()->getManager();
                $em->persist($seguimientoEntrega);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro creado con exito", 
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
     * Finds and displays a seguimientoEntrega entity.
     *
     * @Route("/{id}/show", name="seguimientoentrega_show")
     * @Method("GET")
     */
    public function showAction(SeguimientoEntrega $seguimientoEntrega)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro encontrado", 
                    'data'=> $seguimientoEntrega,
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
     * Displays a form to edit an existing seguimientoEntrega entity.
     *
     * @Route("/{id}/edit", name="seguimientoentrega_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SeguimientoEntrega $seguimientoEntrega)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $numeroRegistros = $params->numeroRegistros;
            $numeroOficio = $params->numeroOficio;
            $fechaCargue = (isset($params->fechaCargue)) ? $params->fechaCargue : null;
            $fechaCargueDateTime = new \DateTime($fechaCargue);

            $em = $this->getDoctrine()->getManager();

            if ($seguimientoEntrega!=null) {
                $seguimientoEntrega->setNumeroRegistros($numeroRegistros);
                $seguimientoEntrega->setNumeroOficio($numeroOficio);
                $seguimientoEntrega->setFechaCargue($fechaCargueDateTime);

                $em = $this->getDoctrine()->getManager();
                $em->persist($seguimientoEntrega);
                $em->flush();

                 $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Registro actualizado con exito", 
                        'data'=> $seguimientoEntrega,
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
                    'msj' => "Autorizacion no valida para editar banco", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a seguimientoEntrega entity.
     *
     * @Route("/{id}/delete", name="seguimientoentrega_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, SeguimientoEntrega $seguimientoEntrega)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();

            $seguimientoEntrega->setEstado(false);
            $em = $this->getDoctrine()->getManager();
                $em->persist($seguimientoEntrega);
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
     * Creates a form to delete a seguimientoEntrega entity.
     *
     * @param SeguimientoEntrega $seguimientoEntrega The seguimientoEntrega entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SeguimientoEntrega $seguimientoEntrega)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('seguimientoentrega_delete', array('id' => $seguimientoEntrega->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
