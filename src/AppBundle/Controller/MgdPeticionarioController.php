<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MgdPeticionario;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Mgdpeticionario controller.
 *
 * @Route("mgdpeticionario")
 */
class MgdPeticionarioController extends Controller
{
    /**
     * Lists all mgdPeticionario entities.
     *
     * @Route("/", name="mgdpeticionario_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $peticionarios = $em->getRepository('AppBundle:MgdPeticionario')->findBy(
            array('activo' => true)
        );

        $response = array(
            'status' => 'success',
            'code' => 200,
            'msj' => "Lista de peticionarios",
            'data' => $peticionarios, 
        );
        return $helpers->json($response);
    }

    /**
     * Creates a new mgdPeticionario entity.
     *
     * @Route("/new", name="mgdpeticionario_new")
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

            $mgdPeticionario = new Mgdpeticionario();

            $mgdPeticionario->setPrimerNombre($params->primerNombre);
            $mgdPeticionario->setSegundoNombre($params->segundoNombre);
            $mgdPeticionario->setPrimerApellido($params->primerApellido);
            $mgdPeticionario->setSegundoApellido($params->segundoApellido);
            $mgdPeticionario->setIdentificacion($params->identificacion);

            if ($params->entidadNombre) {
                $mgdPeticionario->setEntidadNombre($params->entidadNombre);
            }

            if ($params->entidadCargo) {
                $mgdPeticionario->setEntidadCargo($params->entidadCargo);
            }

            $mgdPeticionario->setDireccion($params->direccion);
            $mgdPeticionario->setTelefono($params->telefono);
            $mgdPeticionario->setCorreoElectronico($params->correoElectronico);
            $mgdPeticionario->setNumeroOficio($params->numeroOficio);
            $mgdPeticionario->setEstado(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($mgdPeticionario);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "Registro creado con exito", 
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
     * Finds and displays a mgdPeticionario entity.
     *
     * @Route("/{id}/show", name="mgdpeticionario_show")
     * @Method("POST")
     */
    public function showAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $peticionario = $em->getRepository('AppBundle:MgdPeticionario')->find($id);
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro encontrado", 
                    'data'=> $peticionario,
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
     * Displays a form to edit an existing mgdPeticionario entity.
     *
     * @Route("/edit", name="mgdpeticionario_edit")
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
            $mgdPeticionario = $em->getRepository("AppBundle:MgdPeticionario")->find($params->id);

            if ($mgdPeticionario!=null) {
                $mgdPeticionario->setPrimerNombre($params->primerNombre);
                $mgdPeticionario->setSegundoNombre($params->segundoNombre);
                $mgdPeticionario->setPrimerApellido($params->primerApellido);
                $mgdPeticionario->setSegundoApellido($params->segundoApellido);
                $mgdPeticionario->setIdentificacion($params->identificacion);

                if ($params->entidadNombre) {
                    $mgdPeticionario->setEntidadNombre($params->entidadNombre);
                }

                if ($params->entidadCargo) {
                    $mgdPeticionario->setEntidadCargo($params->entidadCargo);
                }

                $mgdPeticionario->setDireccion($params->direccion);
                $mgdPeticionario->setTelefono($params->telefono);
                $mgdPeticionario->setCorreoElectronico($params->correoElectronico);
                $mgdPeticionario->setNumeroOficio($params->numeroOficio);
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($mgdPeticionario);
                $em->flush();

                 $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Registro actualizado con exito", 
                        'data'=> $mgdPeticionario,
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
     * Deletes a mgdPeticionario entity.
     *
     * @Route("/{id}/delete", name="mgdpeticionario_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $mgdPeticionario = $em->getRepository('AppBundle:MgdPeticionario')->find($id);

            if ($mgdPeticionario) {
                $mgdPeticionario->setEstado(false);
                $em = $this->getDoctrine()->getManager();
                $em->persist($mgdPeticionario);
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
     * Creates a form to delete a mgdPeticionario entity.
     *
     * @param MgdPeticionario $mgdPeticionario The mgdPeticionario entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MgdPeticionario $mgdPeticionario)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mgdpeticionario_delete', array('id' => $mgdPeticionario->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Busca peticionario por cedula o por nombre entidad y numero de oficio.
     *
     * @Route("/search", name="mgdpeticionario_search")
     * @Method({"GET", "POST"})
     */
    public function buscarPeticionarioAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $peticionario = null;

        if ($authCheck == true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $peticionario = $em->getRepository('AppBundle:MgdPeticionario')->findOneBy(
                array(
                    'activo' => true,
                    'identificacion' => $params->identificacion
                )
            );

            if ($peticionario == null) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Registro no encontrado", 
                );
            }else{
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro encontrado", 
                    'data'=> $peticionario,
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
}
