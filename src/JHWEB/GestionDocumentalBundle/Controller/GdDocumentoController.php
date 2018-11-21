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

            $usuario = $em->getRepository('UsuarioBundle:Usuario')->findOneByIdentificacion(
                $params->peticionario->identificacion
            );

            if ($usuario) {
                $remitente = $em->getRepository('JHWEBGestionDocumentalBundle:GdRemitente')->findOneByIdentificacion(
                    $params->remitente->identificacion
                );

                if (!$remitente) {
                    $remitente = new GdRemitente();

                    $remitente->setPrimerNombre(strtoupper($params->remitente->primerNombre));
                    if ($params->remitente->segundoNombre) {
                        $remitente->setSegundoNombre(
                            strtoupper($params->remitente->segundoNombre)
                        );
                    }
                    $remitente->setPrimerApellido(
                        strtoupper($params->remitente->primerApellido)
                    );
                    if ($params->remitente->segundoApellido) {
                        $remitente->setSegundoApellido(
                            strtoupper($params->remitente->segundoApellido)
                        );
                    }
                    $remitente->setIdentificacion($params->remitente->identificacion);
                    $remitente->setDireccion($params->remitente->direccion);
                    $remitente->setTelefono($params->remitente->telefono);
                    $remitente->setCorreoElectronico(
                        $params->remitente->correoElectronico
                    );
                    $remitente->setActivo(true);
                    
                    if ($params->remitente->idTipoIdentificacion) {
                        $tipoIdentificacion = $em->getRepository('AppBundle:TipoIdentificacion')->find(
                            $params->remitente->idTipoIdentificacion
                        );
                        $remitente->setTipoIdentificacion($tipoIdentificacion);
                    }

                    $em->persist($remitente);
                    $em->flush();
                }

                $peticionario = $em->getRepository('AppBundle:Ciudadano')->findOneByUsuario(
                    $usuario->getId()
                );

                if ($peticionario) {
                    $documento = new GdDocumento();

                    $fechaRegistro = new \Datetime(date('Y-m-d h:i:s'));

                    $consecutivo = $em->getRepository('JHWEBGestionDocumentalBundle:GdDocumento')->getMaximo(
                        $fechaRegistro->format('Y')
                    );
                    $consecutivo = (empty($consecutivo['maximo']) ? 1 : $consecutivo['maximo']+=1);
                    $documento->setConsecutivo($consecutivo);

                    $documento->setNumeroRadicado(str_pad($consecutivo, 3, '0', STR_PAD_LEFT).'-'.$fechaRegistro->format('Y')
                    );

                    $documento->setNumeroOficio($params->documento->numeroOficio);
                    $documento->setFolios($params->documento->folios);
                    $documento->setFechaRegistro($fechaRegistro);
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

                    $fechaActual = new \Datetime(date('Y-m-d'));
                    if ($params->documento->vigencia) {
                        $vigencia = $params->documento->vigencia;
                    }else{
                        $vigencia = $tipoCorrespondencia->getDiasVigencia();
                    }

                    $fechaVencimiento = $this->get('app.gestion.documental')->getFechaVencimiento(
                        $fechaActual,
                        $vigencia
                    );
                    $documento->setFechaVencimiento($fechaVencimiento);
                    $documento->setDiasVigencia($vigencia);

                    $documento->setPeticionario($peticionario);

                    $file = $request->files->get('file');
                   
                    if ($file) {
                        $extension = $file->guessExtension();
                        $filename = md5(rand().time()).".".$extension;
                        $dir=__DIR__.'/../../../../web/docs';

                        $file->move($dir,$filename);
                        $documento->setUrl($filename);
                    }
                    $documento->setEstado('PENDIENTE');
                    $documento->setRemitente($remitente);
                    
                    $em->persist($documento);
                    $em->flush();

                    if ($params->medidaCautelar) {
                        $medidaCautelar = new GdMedidaCautelar();

                        $medidaCautelar->setNumeroOficio(
                            $params->medidaCautelar->numeroOficio
                        );
                        $medidaCautelar->setQuienOrdena(
                            $params->medidaCautelar->quienOrdena
                        );
                        $medidaCautelar->setFechaInicio(
                            new \Datetime($params->medidaCautelar->fechaInicio)
                        );
                        $medidaCautelar->setFechaFin(
                            new \Datetime($params->medidaCautelar->fechaFin)
                        );
                        $medidaCautelar->setImplicadoidentificacion(
                            $params->medidaCautelar->identificacionImplicado
                        );
                        $medidaCautelar->setDelito($params->medidaCautelar->delito);
                        $medidaCautelar->setDocumento($documento);

                        $em->persist($medidaCautelar);
                        $em->flush();

                        /*if (count($params->vehiculo)) {
                            foreach ($params->vehiculo as $key => $vehiculo) {
                                $mgdMedidaCautelarVehiculo = new MgdMedidaCautelarVehiculo();

                                $mgdMedidaCautelarVehiculo->setLugar($params->vehiculo[0]->lugar);
                                $mgdMedidaCautelarVehiculo->setPlaca($params->vehiculo[0]->placa);

                                if ($params->vehiculo[0]->claseId) {
                                    $clase = $em->getRepository('AppBundle:Clase')->find(
                                        $params->vehiculo[0]->claseId
                                    );
                                    $mgdMedidaCautelarVehiculo->setClase($clase);
                                }
                                $mgdMedidaCautelarVehiculo->setMedidaCautelar($mgdMedidaCautelar);

                                $em->persist($mgdMedidaCautelarVehiculo);
                                $em->flush();
                            }
                        }*/
                    }

                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => "Registro creado con éxito",
                        'data' => $documento
                    );
                }else{
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "El usuario encontrado no tiene datos regostrados como ciudadano",
                    );
                }
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Ningún usuario encontrado",
                );
            }
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
     * @Route("/{id}/show", name="gddocumento_show")
     * @Method("GET")
     */
    public function showAction(GdDocumento $gdDocumento)
    {
        $deleteForm = $this->createDeleteForm($gdDocumento);

        return $this->render('gddocumento/show.html.twig', array(
            'gdDocumento' => $gdDocumento,
            'delete_form' => $deleteForm->createView(),
        ));
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

            $tipoPeticionario = $params->idTipoPeticionario;

            if ($tipoPeticionario == "Persona") {
                $documentos = $em->getRepository('JHWEBGestionDocumentalBundle:GdDocumento')->getByPeticionario(
                    $tipoPeticionario,
                    $params->identificacion
                );
            }else{
                $documentos = $em->getRepository('JHWEBGestionDocumentalBundle:GdDocumento')->getByPeticionario(
                    $tipoPeticionario,
                    $params->entidadNombre,
                    $params->numeroOficio
                );
            }
            
            if ($documentos == null) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No existen documentos registrados aún.", 
                );
            }else{
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($documentos)." Documentos registrados.", 
                    'data'=> $documentos,
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

                if ($params->observaciones) {
                    $trazabilidad->setObservaciones($params->observaciones);
                }

                $trazabilidad->setEstado('PENDIENTE');
                $trazabilidad->setFechaAsignacion(
                    new \Datetime(date('Y-m-d h:i:s'))
                );
                $trazabilidad->setAceptada(false);
                $trazabilidad->setActivo(true);

                $trazabilidad->setDocumento($documento);

                $funcionario = $em->getRepository('AppBundle:MpersonalFuncionario')->find(
                    $params->idFuncionario
                );
                $trazabilidad->setResponsable($funcionario);

                $em->persist($trazabilidad);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Radicado No. ".$documento->getNumeroRadicado()." ha sido derivado y se encuentra ".$trazabilidad->getEstado(),
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
                $sedeOperativa = $em->getRepository('AppBundle:SedeOperativa')->find(
                    $params->idSedeOperativa
                );
                $documento->setSedeOperativa($sedeOperativa);

                $medioCorrespondenciaEnvio = $em->getRepository('JHWEBGestionDocumentalBundle:GdCfgMedioCorrespondencia')->find(
                    $params->idMedioCorrespondenciaEnvio
                );
                $documento->setMedioCorrespondenciaEnvio($medioCorrespondenciaEnvio);

                $documento->setFechaEnvio(new \Datetime(date('Y-m-d h:i:s')));
                $documento->setDetalleEnvio($params->detalleEnvio);
                $documento->setObservaciones($params->observaciones);
                $documento->setNumeroCarpeta($params->numeroCarpeta);
                $documento->setEstado('FINALIZADO');

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
}
