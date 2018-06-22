<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MgdDocumento;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Mgddocumento controller.
 *
 * @Route("mgddocumento")
 */
class MgdDocumentoController extends Controller
{
    /**
     * Lists all mgdDocumento entities.
     *
     * @Route("/", name="mgddocumento_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $documentos = $em->getRepository('AppBundle:MgdDocumento')->findBy(
            array('activo' => true)
        );

        $response = array(
            'status' => 'success',
            'code' => 200,
            'msj' => "Lista de documentos",
            'data' => $documentos, 
        );
        return $helpers->json($response);
    }

    /**
     * Creates a new mgdDocumento entity.
     *
     * @Route("/new", name="mgddocumento_new")
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
                $documento = new MgdDocumento();

                $documento->setFechaRegistro(new \Datetime(date('Y-m-d h:i:s')));
                $documento->setNumeroRadicado($params->numeroRadicado);
                $documento->setFolios($params->folios);
                $documento->setNumeroOficio($params->numeroOficio);
                $documento->setFechaVencimiento(new \Datetime(date('Y-m-d h:i:s')));
                $documento->setDescripcion($params->descripcion);

                if ($params->correoCertificadoLlegada) {
                    $documento->setCorreoCertificadoLlegada($params->correoCertificadoLlegada);
                    $documento->setNombreTransportadoraLlegada($params->nombreTransportadoraLlegada);
                    $documento->setFechaLlegada(new \Datetime($params->fechaLlegada));
                    $documento->setNumeroGuiaLlegada($params->numeroGuiaLlegada);
                }
                $documento->setActivo(true);

                $em = $this->getDoctrine()->getManager();

                $tipoCorrespondencia = $em->getRepository('AppBundle:MgdTipoCorrespondencia')->find(
                    $params->tipoCorrespondenciaId
                );
                $documento->setTipoCorrespondencia($tipoCorrespondencia);

                $em->persist($documento);
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
     * Finds and displays a mgdDocumento entity.
     *
     * @Route("/{id}/show", name="mgddocumento_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $documento = $em->getRepository('AppBundle:MgdDocumento')->find($id);
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro encontrado", 
                    'data'=> $documento,
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
     * Displays a form to edit an existing mgdDocumento entity.
     *
     * @Route("/edit", name="mgddocumento_edit")
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
            $documento = $em->getRepository("AppBundle:MgdDocumento")->find($params->id);

            if ($documento!=null) {
                $documento->setFechaRegistro(new \Datetime(date('Y-m-d h:i:s')));
                $documento->setNumeroRadicado($params->numeroRadicado);
                $documento->setFolios($params->folios);
                $documento->setNumeroOficio($params->numeroOficio);
                $documento->setFechaVencimiento(new \Datetime(date('Y-m-d h:i:s')));
                $documento->setDescripcion($params->descripcion);

                if ($params->correoCertificadoLlegada) {
                    $documento->setCorreoCertificadoLlegada($params->correoCertificadoLlegada);
                    $documento->setNombreTransportadoraLlegada($params->nombreTransportadoraLlegada);
                    $documento->setFechaLlegada(new \Datetime($params->fechaLlegada));
                    $documento->setNumeroGuiaLlegada($params->numeroGuiaLlegada);
                }
                $documento->setActivo(true);

                $tipoCorrespondencia = $em->getRepository('AppBundle:MgdTipoCorrespondencia')->find(
                    $params->tipoCorrespondenciaId
                );
                $documento->setTipoCorrespondencia($tipoCorrespondencia);
                
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
     * Deletes a mgdDocumento entity.
     *
     * @Route("/{id}/delete", name="mgddocumento_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $documento = $em->getRepository('AppBundle:MgdDocumento')->find($id);

            if ($documento) {
                $documento->setActivo(false);
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
     * Creates a form to delete a mgdDocumento entity.
     *
     * @param MgdDocumento $mgdDocumento The mgdDocumento entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MgdDocumento $mgdDocumento)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mgddocumento_delete', array('id' => $mgdDocumento->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Busca peticionario por cedula o por nombre entidad y numero de oficio.
     *
     * @Route("/search", name="mgddocumento_search")
     * @Method({"GET", "POST"})
     */
    public function buscarDocumentosAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $documentos = null;

        if ($authCheck == true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $tipoPeticionario = $params->tipo;

            if ($tipoPeticionario == "Persona") {
                $documentos = $em->getRepository('AppBundle:MgdDocumento')->getByPeticionario(
                    $tipoPeticionario,
                    $params->identificacion
                );
            }else{
                $documentos = $em->getRepository('AppBundle:MgdDocumento')->getByPeticionario(
                    $tipoPeticionario,
                    $params->entidadNombre,
                    $params->numeroOficio
                );
            }
            
            if ($documentos == null) {
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
                    'data'=> $documentos,
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
