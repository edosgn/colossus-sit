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
                $documento->setEntidadNombre($params->entidadNombre);
                $documento->setEntidadCargo($params->entidadCargo);

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
                $documento->setEntidadNombre($params->entidadNombre);
                $documento->setEntidadCargo($params->entidadCargo);

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

    /**
     * Busca peticionario por cedula o por nombre entidad y numero de oficio.
     *
     * @Route("/assign", name="mgddocumento_assign")
     * @Method({"GET", "POST"})
     */
    public function assignAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $documentos = null;

        if ($authCheck == true) {
            $json = $request->get("json",null);
            $params = json_decode($json);
            
            $em = $this->getDoctrine()->getManager();

            $documento = $em->getRepository('AppBundle:MgdDocumento')->find(
                $params->documentoId
            );
            
            if ($documento) {
                $usuario = $em->getRepository('UsuarioBundle:Usuario')->find(
                    $params->usuarioId
                );
                $documento->setResponsable($usuario);
                $documento->setObservaciones($params->observaciones);
                $documento->setEstado('En proceso');
                $documento->setFechaAsignacion(new \Datetime(date('Y-m-d h:i:s')));
                $documento->setAsignado(true);

                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Radicado No. ".$documento->getNumeroRadicado()." ".$documento->getEstado(),
                    'data' => $documento
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Registro no encontrado"
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
     * Busca peticionario por cedula o por nombre entidad y numero de oficio.
     *
     * @Route("/process", name="mgddocumento_process")
     * @Method({"GET", "POST"})
     */
    public function processAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $documentos = null;

        if ($authCheck == true) {
            $json = $request->get("json",null);
            $params = json_decode($json);
            
            $em = $this->getDoctrine()->getManager();

            $documento = $em->getRepository('AppBundle:MgdDocumento')->find(
                $params->documentoId
            );
            
            if ($documento) {
                if ($params->aceptada == 'true') {
                    $estado = 'Aceptado';
                    $documento->setAceptada(true);
                }else{
                    $estado = 'Rechazado';
                }
                $documento->setObservaciones($params->observaciones);
                $documento->setEstado($estado);

                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Radicado No. ".$documento->getNumeroRadicado()." ".$documento->getEstado(),
                    'data' => $documento
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Registro no encontrado"
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
     * Busca peticionario por cedula o por nombre entidad y numero de oficio.
     *
     * @Route("/response", name="mgddocumento_response")
     * @Method({"GET", "POST"})
     */
    public function responseAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $documentos = null;

        if ($authCheck == true) {
            $json = $request->get("json",null);
            $params = json_decode($json);
            
            $em = $this->getDoctrine()->getManager();

            $documento = $em->getRepository('AppBundle:MgdDocumento')->find(
                $params->documentoId
            );
            
            if ($documento) {
                $documento->setRespuesta($params->descripcion);
                $documento->setEstado('Respuesta Generada');

                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Radicado No. ".$documento->getNumeroRadicado()." ".$documento->getEstado(),
                    'data' => $documento
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Registro no encontrado"
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
     * Busca peticionario por cedula o por nombre entidad y numero de oficio.
     *
     * @Route("/print", name="mgddocumento_print")
     * @Method({"GET", "POST"})
     */
    public function printAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $documentos = null;

        if ($authCheck == true) {
            $json = $request->get("json",null);
            $params = json_decode($json);
            
            $em = $this->getDoctrine()->getManager();

            $documento = $em->getRepository('AppBundle:MgdDocumento')->find(
                $params->documentoId
            );
            
            if ($documento) {
                if ($params->correoCertificadoEnvio == 'true') {
                    $documento->setCorreoCertificadoEnvio(true);
                    $documento->setNombreTransportadoraEnvio($params->nombreTransportadoraEnvio);
                    $documento->setNumeroGuia($params->numeroGuia);
                }else{
                    $documento->setMedioEnvio($params->medioEnvio);
                }
                $documento->setFechaEnvio(new \Datetime(date('Y-m-d h:i:s')));
                $documento->setNumeroCarpeta($params->numeroCarpeta);
                $documento->setEstado('Finalizado');

                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Radicado No. ".$documento->getNumeroRadicado()." ".$documento->getEstado(),
                    'data' => $documento
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Registro no encontrado"
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
     * Busca peticionario por cedula o por nombre entidad y numero de oficio.
     *
     * @Route("/{id}/pdf", name="mgddocumento_pdf")
     * @Method({"GET", "POST"})
     */
    public function pdfAction(Request $request, MgdDocumento $mgdDocumento)
    {
        
        $html = $this->renderView('@App/mgddocumento/pdf.template.html.twig', array(
            'mgdDocumento'=>$mgdDocumento,
        ));

        $pdf = $this->container->get("white_october.tcpdf")->create(
            'PORTRAIT',
            PDF_UNIT,
            PDF_PAGE_FORMAT,
            true,
            'UTF-8',
            false
        );
        $pdf->SetAuthor('qweqwe');
        $pdf->SetTitle('Prueba TCPDF');
        $pdf->SetSubject('Your client');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        $pdf->setFontSubsetting(true);

        $pdf->SetFont('helvetica', '', 11, '', true);
        $pdf->SetMargins('25', '25', '25');
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetFont('helvetica', '', 11, '', true);
        $pdf->AddPage();

        $pdf->writeHTMLCell(
            $w = 0,
            $h = 0,
            $x = '',
            $y = '',
            $html,
            $border = 0,
            $ln = 1,
            $fill = 0,
            $reseth = true,
            $align = '',
            $autopadding = true
        );

        $pdf->Output("example.pdf", 'I');
        die();
    }
}
