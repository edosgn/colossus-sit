<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Peticionario;
use AppBundle\Form\PeticionarioType;

/**
 * Peticionario controller.
 *
 * @Route("/peticionario")
 */ 
class PeticionarioController extends Controller 
{
    /**
     * Lists all Peticionario entities.
     *
     * @Route("/", name="peticionario_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $peticionarios = $em->getRepository('AppBundle:Peticionario')->findBy(
            array('estado' => true)
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
     * Creates a new Peticionario entity.
     *
     * @Route("/new", name="peticionario_new") 
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

            $registroDocumentoId = $params->registroDocumentoId;
            $registroDocumento = $em->getRepository('AppBundle:RegistroDocumento')->find($registroDocumentoId);

            $peticionario = new Peticionario();

            $peticionario->setPrimerNombrePeticionario($params->primerNombre);
            $peticionario->setSegundoNombrePeticionario($params->segundoNombre);
            $peticionario->setPrimerApellidoPeticionario($params->primerApellido);
            $peticionario->setSegundoApellidoPeticionario($params->segundoApellido);
            $peticionario->setIdentificacionPeticionario($params->identificacion);
            $peticionario->setDireccionPeticionario($params->direccion);
            $peticionario->setTelefonoPeticionario($params->telefono);
            $peticionario->setCorreoElectronico($params->correoElectronico);
            $peticionario->setNumeroOficio($params->numeroOficio);
            $peticionario->setTipoPeticionario($params->tipo);
            $peticionario->setEstado(true);
            $peticionario->setRegistroDocumento($registroDocumento);

            $em = $this->getDoctrine()->getManager();
            $em->persist($peticionario);
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
     * Finds and displays a agenteTransito entity.
     *
     * @Route("/{id}/show", name="agentetransito_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request, Peticionario $peticionario)
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
     * Displays a form to edit an existing agenteTransito entity.
     *
     * @Route("/{id}/edit", name="agentetransito_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Peticionario $peticionario)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $primerNombrePeticionario = $params->primerNombrePeticionario;
            $segundoNombrePeticionario = $params->segundoNombrePeticionario;
            $primerApellidoPeticionario = $params->primerApellidoPeticionario;
            $segundoApellidoPeticionario = $params->segundoApellidoPeticionario;
            $identificacionPericionario = $params->identificacionPericionario;
            $direccionPeticionario = $params->direccionPeticionario;
            $telefonoPeticionario = $params->telefonoPeticionario;
            $correoElectronico = $params->correoElectronico;
            $numeroOficio = $params->numeroOficio;
            $tipoPeticionario = $params->tipoPeticionario;
            $estado = true;
            $registroDocumentoId = $params->registroDocumentoId;
            $registroDocumento = $em->getRepository('AppBundle:RegistroDocumento')->find($registroDocumentoId);

            if ($peticionario!=null) {

                $peticionario->setPrimerNombrePeticionario($primerNombrePeticionario);
                $peticionario->setSegundoNombrePeticionario($segundoNombrePeticionario);
                $peticionario->setPrimerApellidoPeticionario($primerApellidoPeticionario);
                $peticionario->setSegundoApellidoPeticionario($segundoApellidoPeticionario);
                $peticionario->setIdentificacionPeticionario($identificacionPericionario);
                $peticionario->setDireccionPeticionario($direccionPeticionario);
                $peticionario->setTelefonoPeticionario($telefonoPeticionario);
                $peticionario->setCorreoElectronico($correoElectronico);
                $peticionario->setNumeroOficio($numeroOficio);
                $peticionario->setTipoPeticionario($tipoPeticionario);
                $peticionario->setEstado($estado);
                $peticionario->setRegistroDocumento($registroDocumento);

                $em = $this->getDoctrine()->getManager();
                $em->flush();

                 $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Registro actualizado con exito", 
                        'data'=> $peticionario,
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
     * Deletes a agenteTransito entity.
     *
     * @Route("/{id}/delete", name="agentetransito_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, Peticionario $peticionario)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();

            $peticionario->setEstado(false);
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
                    'msj' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a Peticionario entity.
     *
     * @param Peticionario $peticionario The Peticionario entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Peticionario $peticionario)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('peticionario_delete', array('id' => $peticionario->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


     /**
     * Lists all Peticionario entities.
     *
     * @Route("/listar/peticionario", name="listar_peticionario")
     * @Method("GET")
     */
    public function listarPeticionarioAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $peticionarios = $em->getRepository('AppBundle:Peticionario')->findBy(
            array('estado' => 1)
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
     * Busca peticionario por cedula o por nombre entidad y numero de oficio.
     *
     * @Route("/buscar/peticionario", name="buscar_peticionario")
     * @Method({"GET", "POST"})
     */
    public function buscarPeticionarioAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $peticionarios = null;

        if ($authCheck == true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $tipoPeticionario = $params->tipo;

            if ($tipoPeticionario == "Persona") {
                $peticionarios = $em->getRepository('AppBundle:Peticionario')->findBy(
                    array(
                        'estado' => true,
                        'identificacion' => $params->identificacion
                    )
                );
            }else{
                $peticionarios = $em->getRepository('AppBundle:Peticionario')->findBy(
                    array(
                        'estado' => true,
                        'nombre' => $params->nombre,
                        'numeroOficio' => $params->numeroOficio
                    )
                );
            }

            if ($peticionarios == null) {
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
                    'data'=> $peticionarios,
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
