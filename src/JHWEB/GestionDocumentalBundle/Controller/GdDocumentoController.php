<?php

namespace JHWEB\GestionDocumentalBundle\Controller;

use JHWEB\GestionDocumentalBundle\Entity\GdDocumento;
use JHWEB\GestionDocumentalBundle\Entity\GdTrazabilidad;
use JHWEB\GestionDocumentalBundle\Entity\GdRemitente;
use JHWEB\GestionDocumentalBundle\Entity\GdMedidaCautelar;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * Gddocumento controller.
 *
 * @Route("gddocumento")
 */
class GdDocumentoController extends Controller
{
    /**
     * Lists all gdDocumento entities.
     *
     * @Route("/", name="gddocumento_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $documentos = $em->getRepository('JHWEBGestionDocumentalBundle:GdDocumento')->findBy(
            array(
                'estado' => array('PENDIENTE','RECHAZADO','RESPUESTA REALIZADA'),
                'activo'=>true
            )
        );

        $response['data'] = array();

        if ($documentos) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($documentos)." Registros encontrados", 
                'data'=> $documentos,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new gdDocumento entity.
     *
     * @Route("/new", name="gddocumento_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization",null);
        $authCheck = $helpers->authCheck($hash);

        if($authCheck == true){
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $documento = new GdDocumento();

            $fechaRegistro = new \Datetime(date('Y-m-d h:i:s'));

            $consecutivo = $em->getRepository('JHWEBGestionDocumentalBundle:GdDocumento')->getMaximo(
                $fechaRegistro->format('Y')
            );
            $consecutivo = (empty($consecutivo['maximo']) ? 1 : $consecutivo['maximo']+=1);
            $documento->setConsecutivo($consecutivo);

            $documento->setNumeroRadicado(str_pad($consecutivo, 3, '0', STR_PAD_LEFT).'-'.$fechaRegistro->format('Y')
            );

            $documento->setFolios($params->folios);
            $documento->setFechaRegistro($fechaRegistro);

            if ($params->peticionarioNombres) {
                $documento->setPeticionarioNombres(
                    strtoupper($params->peticionarioNombres)
                );
            }

            if ($params->peticionarioApellidos) {
                $documento->setPeticionarioApellidos(
                    strtoupper($params->peticionarioApellidos)
                );
            }

            if ($params->identificacion) {
                $documento->setIdentificacion($params->identificacion);
            }

            if ($params->entidadCargo) {
                $documento->setEntidadCargo(strtoupper($params->entidadCargo));
            }

            if ($params->entidadNombre) {
                $documento->setEntidadNombre(strtoupper($params->entidadNombre));
            }

            if (isset($params->idTipoIdentificacion)) {
                $tipoIdentificacion = $em->getRepository('JHWEBUsuarioBundle:UserCfgTipoIdentificacion')->find(
                    $params->idTipoIdentificacion
                );
                $documento->setTipoIdentificacion($tipoIdentificacion);
            }

            $documento->setEstado('PENDIENTE');
            
            $em->persist($documento);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con éxito, su número de radicado es: ".$documento->getNumeroRadicado(),
                'data' => $documento
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no valida",
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Finds and displays a gdDocumento entity.
     *
     * @Route("/show", name="gddocumento_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $documento = $em->getRepository('JHWEBGestionDocumentalBundle:GdDocumento')->find($params->id);

            if ($documento) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado", 
                    'data'=> $documento,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos",
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorizacion no valida", 
                );
        }

        return $helpers->json($response);

    }

    /**
     * Displays a form to edit an existing gdDocumento entity.
     *
     * @Route("/{id}/edit", name="gddocumento_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, GdDocumento $gdDocumento)
    {
        $deleteForm = $this->createDeleteForm($gdDocumento);
        $editForm = $this->createForm('JHWEB\GestionDocumentalBundle\Form\GdDocumentoType', $gdDocumento);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('gddocumento_edit', array('id' => $gdDocumento->getId()));
        }

        return $this->render('gddocumento/edit.html.twig', array(
            'gdDocumento' => $gdDocumento,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a gdDocumento entity.
     *
     * @Route("/{id}/delete", name="gddocumento_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, GdDocumento $gdDocumento)
    {
        $form = $this->createDeleteForm($gdDocumento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($gdDocumento);
            $em->flush();
        }

        return $this->redirectToRoute('gddocumento_index');
    }

    /**
     * Creates a form to delete a gdDocumento entity.
     *
     * @param GdDocumento $gdDocumento The gdDocumento entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(GdDocumento $gdDocumento)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('gddocumento_delete', array('id' => $gdDocumento->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ========================================================= */

    /**
     * Busca si existen documentos radicado por identificaccion de peticionario, nombre de la entidad o numero de oficio.
     *
     * @Route("/search", name="gddocumento_search")
     * @Method({"GET", "POST"})
     */
    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $documentos = null;

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $documentos = $em->getRepository('JHWEBGestionDocumentalBundle:GdDocumento')->getByFilter(
                $params
            );

            if ($documentos) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($documentos)." Documentos registrados.", 
                    'data'=> $documentos,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Ningún resultado encontrado.", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorizacion no valida", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Busca si existen documentos radicado por el estado.
     *
     * @Route("/search/state", name="gddocumento_search_state")
     * @Method({"GET", "POST"})
     */
    public function searchByStateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $documentos = null;

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $documentos = $em->getRepository('JHWEBGestionDocumentalBundle:GdDocumento')->findByEstado(
                $params->state
            );

            if ($documentos) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($documentos)." Documentos registrados.", 
                    'data'=> $documentos,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Ningún resultado encontrado.", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorizacion no valida", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Asigna el documento a un funcionario para que genere un respuesta.
     *
     * @Route("/update", name="gddocumento_update")
     * @Method({"GET", "POST"})
     */
    public function updateAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $documentos = null;

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $documento = $em->getRepository('JHWEBGestionDocumentalBundle:GdDocumento')->find(
                $params->documento->id
            );
            
            if ($documento) {
                if ($params->documento->direccion) {
                    $documento->setDireccion(
                        $params->documento->direccion
                    );
                }

                if ($params->documento->telefono) {
                    $documento->setTelefono(
                        $params->documento->telefono
                    );
                }

                if ($params->documento->correo) {
                    $documento->setCorreo(
                        $params->documento->correo
                    );
                }

                if ($params->documento->municipio) {
                    $medioCorrespondenciaLlegada = $em->getRepository('JHWEBGestionDocumentalBundle:GdCfgMedioCorrespondencia')->find(
                        $params->documento->municipio
                    );
                    $documento->setMedioCorrespondenciaLlegada($medioCorrespondenciaLlegada);
                }

                $fechaActual = new \Datetime(date('Y-m-d'));

                if ($params->documento->numeroOficio) {
                    $documento->setNumeroOficio(
                        $params->documento->numeroOficio
                    );
                }else{
                    $documento->setNumeroOficio('No registra');
                }

                $documento->setDescripcion($params->documento->descripcion);

                if ($params->documento->detalleLlegada) {
                    $documento->setDetalleLlegada(
                        $params->documento->detalleLlegada
                    );
                }

                if ($params->documento->fechaLlegada) {
                    $documento->setFechaLlegada(
                        new \Datetime($params->documento->fechaLlegada)
                    );
                }

                if ($params->documento->municipio) {
                    $municipio = $em->getRepository('JHWEBConfigBundle:CfgMunicipio')->find(
                        $params->documento->municipio
                    );
                    $documento->setMunicipio($municipio);
                }

                if ($params->documento->idMedioCorrespondenciaLlegada) {
                    $medioCorrespondenciaLlegada = $em->getRepository('JHWEBGestionDocumentalBundle:GdCfgMedioCorrespondencia')->find(
                        $params->documento->idMedioCorrespondenciaLlegada
                    );
                    $documento->setMedioCorrespondenciaLlegada($medioCorrespondenciaLlegada);
                }

                if ($params->documento->idTipoCorrespondencia) {
                    $tipoCorrespondencia = $em->getRepository('JHWEBGestionDocumentalBundle:GdCfgTipoCorrespondencia')->find(
                        $params->documento->idTipoCorrespondencia
                    );
                    $documento->setTipoCorrespondencia($tipoCorrespondencia);
                }

                if ($params->documento->vigencia) {
                    $vigencia = $params->documento->vigencia;
                }else{
                    $vigencia = $tipoCorrespondencia->getDiasVigencia();
                }

                $fechaVencimiento = $this->get('app.gestion.documental')->getFechaVencimiento(
                    new \Datetime($params->documento->fechaLlegada),
                    $vigencia + 1
                );
                $documento->setFechaVencimiento($fechaVencimiento);
                $documento->setDiasVigencia($vigencia);
                $documento->setNumeroCarpeta($params->documento->numeroCarpeta);

                $file = $request->files->get('file');
               
                if ($file) {
                    $extension = $file->guessExtension();
                    //$filename = md5(rand().time()).".".$extension;
                    $filename = 'radicado_'.$documento->getNumeroRadicado().".".$extension;
                    $dir=__DIR__.'/../../../../web/docs';

                    $file->move($dir,$filename);
                    $documento->setUrl($filename);
                }

                if ($params->idComparendo) {
                    $comparendo = $em->getRepository('JHWEBContravencionalBundle:CvCdoComparendo')->find(
                        $params->idComparendo
                    );
                    $documento->setComparendo($comparendo);
                }

                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Radicado No. ".$documento->getNumeroRadicado()." ha registrado la información complementaria",
                    'data' => $documento
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Registro no encontrado"
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($response);
    }

    /**
     * Asigna el documento a un funcionario para que genere un respuesta.
     *
     * @Route("/finish", name="gddocumento_finish")
     * @Method({"GET", "POST"})
     */
    public function finishAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $documentos = null;

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $documento = $em->getRepository('JHWEBGestionDocumentalBundle:GdDocumento')->find(
                $params->idDocumento
            );
            
            if ($documento) {

                $file = $request->files->get('file');
               
                if ($file) {
                    $extension = $file->guessExtension();
                    //$filename = md5(rand().time()).".".$extension;
                    $filename = 'radicado_'.$documento->getNumeroRadicado().".".$extension;
                    $dir=__DIR__.'/../../../../web/docs';

                    $file->move($dir,$filename);
                    $documento->setUrlFinalizado($filename);
                    $documento->setEstado('FINALIZADO');
                }


                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Radicado No. ".$documento->getNumeroRadicado()." ha Sido finalizado",
                    'data' => $documento
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Registro no encontrado"
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($response);
    }

    /**
     * Asigna el documento a un fiuncionario para que genere un respuesta.
     *
     * @Route("/assign", name="gddocumento_assign")
     * @Method({"GET", "POST"})
     */
    public function assignAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $documentos = null;

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $documento = $em->getRepository('JHWEBGestionDocumentalBundle:GdDocumento')->find(
                $params->idDocumento
            );
            
            if ($documento) {
                $documento->setEstado('ASIGNADO');

                $trazabilidad = new GdTrazabilidad();

                if (isset($params->observaciones)) {
                    $trazabilidad->setObservaciones($params->observaciones);
                }

                $trazabilidad->setEstado('PENDIENTE');
                $trazabilidad->setFechaAsignacion(
                    new \Datetime(date('Y-m-d h:i:s'))
                );
                $trazabilidad->setAceptada(false);
                $trazabilidad->setActivo(true);

                $trazabilidad->setDocumento($documento);

                $funcionario = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->find(
                    $params->idFuncionario
                );
                $trazabilidad->setResponsable($funcionario);

                $em->persist($trazabilidad);
                $em->flush();

                if ($documento->getComparendo()) {
                    $estado = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->find(27);
                    $comparendo = $documento->getComparendo();

                    $trazabilidadComparendo = $helpers->generateTrazabilidad($comparendo, $estado);
                    $trazabilidadComparendo->setFuncionario($funcionario);
                    $em->flush();
                }

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Radicado No. ".$trazabilidad->getDocumento()->getNumeroRadicado()." se encuentra ".$trazabilidad->getDocumento()->getEstado(),
                    'data' => $trazabilidad
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Registro no encontrado"
                );
            }
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
            );
        }
        return $helpers->json($response);
    }

    /**
     * Busca peticionario por cedula o por nombre entidad y numero de oficio.
     *
     * @Route("/print", name="gddocumento_print")
     * @Method({"GET", "POST"})
     */
    public function printAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $documentos = null;

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);
            
            $em = $this->getDoctrine()->getManager();

            $documento = $em->getRepository('JHWEBGestionDocumentalBundle:GdDocumento')->find(
                $params->idDocumento
            );
            
            if ($documento) {
                $organismoTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find(
                    $params->idOrganismoTransito
                );
                $documento->setOrganismoTransito($organismoTransito);

                $medioCorrespondenciaEnvio = $em->getRepository('JHWEBGestionDocumentalBundle:GdCfgMedioCorrespondencia')->find(
                    $params->idMedioCorrespondenciaEnvio
                );
                $documento->setMedioCorrespondenciaEnvio($medioCorrespondenciaEnvio);
                $documento->setFechaEnvio(new \Datetime(date('Y-m-d h:i:s')));
                $documento->setDetalleEnvio($params->detalleEnvio);
                $documento->setObservaciones($params->observaciones);
                $documento->setEstado('ENVIADA');

                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Radicado No. ".$documento->getNumeroRadicado()." ".$documento->getEstado(),
                    'data' => $documento
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Registro no encontrado"
                );
            }            
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($response);
    }

    /**
     * Asigna el documento a un fiuncionario para que genere un respuesta.
     *
     * @Route("/template", name="gddocumento_template")
     * @Method({"GET", "POST"})
     */
    public function templateAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $documentos = null;

        if ($authCheck == true) {
            $file = $request->files->get('file');
                   
            if ($file) {
                $extension = $file->guessExtension();
                if ($extension == 'docx') {
                    $filename = "template.".$extension;
                    $dir=__DIR__.'/../../../../web/uploads';

                    $file->move($dir,$filename);

                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => 'Plantilla cargada con exito.'
                    );
                }else{
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "Solo se admite formato .docx"
                    );
                }
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Ningún archivo seleccionado"
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($response);
    }

    /**
     * Busca peticionario por cedula o por nombre entidad y numero de oficio.
     *
     * @Route("/{id}/pdf", name="gddocumento_pdf")
     * @Method({"GET", "POST"})
     */
    public function pdfAction(Request $request, GdDocumento $gdDocumento)
    {
        $html = $this->renderView('@JHWEBGestionDocumental/gddocumento/pdf.template.html.twig', array(
            'gdDocumento'=>$gdDocumento,
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

    /**
     * Busca si existen documentos entre fechas.
     *
     * @Route("/report", name="gddocumento_report")
     * @Method({"GET", "POST"})
     */
    public function reportAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $documentos = null;

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $fechaInicial = new \Datetime($params->fechaInicial);
            $fechaFinal = new \Datetime($params->fechaFinal);

            if ($fechaInicial < $fechaFinal) {
                $documentos = $em->getRepository('JHWEBGestionDocumentalBundle:GdDocumento')->getByDates(
                    $fechaInicial, $fechaFinal
                );
    
                if ($documentos) {
                    $response = array(
                        'title' => 'Perfecto!',
                        'status' => 'success',
                        'code' => 200,
                        'message' => count($documentos)." Documentos registrados.", 
                        'data'=> $documentos,
                    );
                }else{
                    $response = array(
                        'title' => 'Atención!',
                        'status' => 'warning',
                        'code' => 400,
                        'message' => "Ningún resultado encontrado.", 
                    );
                }
            }else{
                $response = array(
                    'title' => 'Atención!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => "La fecha inicial debe ser menor a la fecha final.", 
                );
            }
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
            );
        }

        return $helpers->json($response);
    }
}
