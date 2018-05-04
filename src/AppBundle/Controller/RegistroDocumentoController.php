<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\RegistroDocumento;
use AppBundle\Form\RegistroDocumentoType;

/**
 * RegistroDocumento controller.
 *
 * @Route("/registrodocumento")
 */
class RegistroDocumentoController extends Controller
{
    /** 
     * Lists all RegistroDocumento entities.
     *
     * @Route("/", name="registro_documento_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $registroDocumentos = $em->getRepository('AppBundle:RegistroDocumento')->findBy(
            array('estado' => 1)
        );

        $response = array(
            'status' => 'success',
            'code' => 200,
            'msj' => "Lista de registroDocumentos",
            'data' => $registroDocumentos, 
        );
        return $helpers->json($response);
    }

    /**
     * Creates a new RegistroDocumento entity.
     *
     * @Route("/new", name="registro_documento_new") 
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
           
                $codigoRadicado = $params->codigoRadicado;
                $tiempoRadicacion = $params->tiempoRadicacion;
                $asuntoDocumento = $params->asuntoDocumento;
                $estadoDocumento = $params->estadoDocumento;
                $urlDocumentoEscaneado = $params->urlDocumentoEscaneado;
                $tiempoTranscurrido = $params->tiempoTranscurrido;
                $numeroFolios = $params->numeroFolios;
                $estado = true;
                $tipoDocumentoId = $params->tipoDocumentoId;
                $tipoDocumento = $em->getRepository('AppBundle:TipoDocuemnto')->find($tipoDocumentoId);

                $registroDocumento = new RegistroDocumento();


                $registroDocumento->setCodigoRadicado($codigoRadicado);
                $registroDocumento->setTiempoRAdicacion($tiempoRadicacion);
                $registroDocumento->setAsuntoDocumento($asuntoDocumento);
                $registroDocumento->setEstadoDocumento($estadoDocumento);
                $registroDocumento->setUrlDocumentoEscaneado($urlDocumentoEscaneado);
                $registroDocumento->setTiempoTranscurrido($tiempoTranscurrido);
                $registroDocumento->setNumeroDeFolios($numeroFolios);
                $registroDocumento->setEstado($estado);
                $registroDocumento->setTipoDocumento($tipoDocumento);
                

                $em = $this->getDoctrine()->getManager();
                $em->persist($registroDocumento);
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
     * Finds and displays a registro documento entity.
     *
     * @Route("/{id}/show", name="registro_documento_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request, RegistroDocumento $registroDocumento)
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
                    'data'=> $registroDocumento,
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
     * @Route("/{id}/edit", name="registro_documento_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, RegistroDocumento $registroDocumento)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $codigoRadicado = $params->codigoRadicado;
                $tiempoRadicacion = $params->tiempoRadicacion;
                $asuntoDocumento = $params->asuntoDocumento;
                $estadoDocumento = $params->estadoDocumento;
                $urlDocumentoEscaneado = $params->urlDocumentoEscaneado;
                $tiempoTranscurrido = $params->tiempoTranscurrido;
                $numeroFolios = $params->numeroFolios;
                $estado = true;
                $tipoDocumentoId = $params->tipoDocumentoId;
                $tipoDocumento = $em->getRepository('AppBundle:TipoDocuemnto')->find($tipoDocumentoId);

            if ($registroDocumento!=null) {

                $registroDocumento->setCodigoRadicado($codigoRadicado);
                $registroDocumento->setTiempoRAdicacion($tiempoRadicacion);
                $registroDocumento->setAsuntoDocumento($asuntoDocumento);
                $registroDocumento->setEstadoDocumento($estadoDocumento);
                $registroDocumento->setUrlDocumentoEscaneado($urlDocumentoEscaneado);
                $registroDocumento->setTiempoTranscurrido($tiempoTranscurrido);
                $registroDocumento->setNumeroDeFolios($numeroFolios);
                $registroDocumento->setEstado($estado);
                $registroDocumento->setTipoDocumento($tipoDocumento);

                $em->flush();

                 $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Registro actualizado con exito", 
                        'data'=> $registroDocumento,
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
     * Deletes a registroDocumento entity.
     *
     * @Route("/{id}/delete", name="registro_documento_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {

            $em = $this->getDoctrine()->getManager();
            $registroDocumento = $em->getRepository('AppBundle:RegistroDocumento')->find($id);

            if ($registroDocumento!=null) {

                $registroDocumento->setEstado(0);
                $em->persist($registroDocumento);
                $em->flush();

                $responce = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "RegistroDocumento eliminado con exito", 
                );
            }else{
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El RegistroDocumento no se encuentra en la base de datos", 
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
     * Creates a form to delete a RegistroDocumento entity.
     *
     * @param RegistroDocumento $registroDocumento The RegistroDocumento entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(RegistroDocumento $registroDocumento)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('registroDocumento_delete', array('id' => $registroDocumento->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2 
     *
     * @Route("/select", name="registroDocumento_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $registroDocumentos = $em->getRepository('AppBundle:RegistroDocumento')->findBy(
        array('estado' => 1)
    );
      foreach ($registroDocumentos as $key => $registroDocumento) {
        $response[$key] = array(
            'value' => $registroDocumento->getId(),
            'label' => $registroDocumento->getCodigoRadicado(),
            );
      }
       return $helpers->json($response);
    }
}
