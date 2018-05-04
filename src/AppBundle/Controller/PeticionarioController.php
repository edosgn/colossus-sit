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

                $peticionario = new Peticionario();


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
     * Finds and displays a peticionario entity.
     *
     * @Route("/{id}/show", name="peticionario_show")
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
     * @Route("/{id}/edit", name="peticionario_edit")
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
     * Deletes a peticionario entity.
     *
     * @Route("/{id}/delete", name="almacen_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {

            $em = $this->getDoctrine()->getManager();
            $peticionario = $em->getRepository('AppBundle:Peticionario')->find($id);

            if ($peticionario!=null) {

                $peticionario->setEstado(0);
                $em->persist($peticionario);
                $em->flush();

                $responce = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Peticionario eliminado con exito", 
                );
            }else{
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El Peticionario no se encuentra en la base de datos", 
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
     * datos para select 2 
     *
     * @Route("/select", name="peticionario_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $peticionarios = $em->getRepository('AppBundle:Peticionario')->findBy(
        array('estado' => 1)
    );
      foreach ($peticionarios as $key => $peticionario) {
        $response[$key] = array(
            'value' => $peticionario->getId(),
            'label' => $peticionario->getIdentificacionPeticionario()."_".$peticionario->getPrimerNombrePeticionario()."_".$peticionario->getPrimerApellidoPeticionario(),
            );
      }
       return $helpers->json($response);
    }
}