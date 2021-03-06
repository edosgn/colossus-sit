<?php

namespace JHWEB\FinancieroBundle\Controller;

use JHWEB\FinancieroBundle\Entity\FroReporteIngresos;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Froreporteingreso controller.
 *
 * @Route("froreporteingresos")
 */
class FroReporteIngresosController extends Controller
{
    /**
     * Lists all froReporteIngreso entities.
     *
     * @Route("/", name="froreporteingresos_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $froReporteIngresos = $em->getRepository('JHWEBFinancieroBundle:FroReporteIngresos')->findAll();

        return $this->render('froreporteingresos/index.html.twig', array(
            'froReporteIngresos' => $froReporteIngresos,
        ));
    }

    /**
     * Finds and displays a froReporteIngreso entity.
     *
     * @Route("/{id}", name="froreporteingresos_show")
     * @Method("GET")
     */
    public function showAction(FroReporteIngresos $froReporteIngreso)
    {

        return $this->render('froreporteingresos/show.html.twig', array(
            'froReporteIngreso' => $froReporteIngreso,
        ));
    }

    /**
     * datos para obtener tramites por rango de fechas
     *
     * @Route("/pdf/tramite/fecha", name="frotramite_rango_fechas")
     * @Method({"GET", "POST"})
     */
    public function tramitesByFechaAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            setlocale(LC_ALL,"es_ES");
            $fechaActual = strftime("%d de %B del %Y");

            $fechaInicioDatetime = new \Datetime($params->filtros->fechaDesde);
            $fechaFinDatetime = new \Datetime($params->filtros->fechaHasta);
            
            $organismoTransito = null;

            $reporteGeneral = false;
            $reporteDetallado = false;

            if(count($params->filtros->arrayOrganismosTransito) == 1){
                $organismoTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find($params->filtros->arrayOrganismosTransito[0]);
            }
            
            $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findOneBy(
                array(
                    'identificacion' => $params->identificacion,
                    )
                );
                
            $funcionario = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->findOneBy(
                array(
                    'ciudadano' => $ciudadano->getId(),
                )
            );
            
            if($params->tipoArchivoTramite == 'GENERAL') {
                $reporteGeneral = true;
                $reporteDetallado = false;

                foreach ($params->filtros->arrayOrganismosTransito as $key => $idOrganismoTransito) {
                    $organismoTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find($idOrganismoTransito);

                    $cantidadFacturasDevolucionadas = 0;
                    $cantidadFacturasPagadas = 0;
                    $cantidadFacturasRetefuente = 0;
                    $cantidadFacturasVencidas = 0;
                    
                    $totalTramitesFinalizados = 0;
                    $totalConceptos = 0;
                    $totalSustratos = 0;

                    $tramitesFinalizados = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->findTramitesFinalizados($params->tipoArchivoTramite, $fechaInicioDatetime,$fechaFinDatetime, [$idOrganismoTransito]);
                    $facturasDevolucionadas = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->findFacturasDevolucionadas($fechaInicioDatetime,$fechaFinDatetime, [$idOrganismoTransito]);
                    $facturasPagadas = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->findFacturasPagadas($fechaInicioDatetime,$fechaFinDatetime, [$idOrganismoTransito]);
                    $facturasVencidas = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->findFacturasVencidas($fechaInicioDatetime,$fechaFinDatetime, [$idOrganismoTransito]);
                    $facturasRetefuente = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->findFacturasRetefuente($fechaInicioDatetime,$fechaFinDatetime, [$idOrganismoTransito]);

                    foreach ($tramitesFinalizados as $key => $tramiteFinalizado) {
                        $totalTramitesFinalizados += intval($tramiteFinalizado['total']);
                    }
                    foreach ($facturasDevolucionadas as $key => $facturaDevolucionada) {
                        $cantidadFacturasDevolucionadas = intval($facturaDevolucionada['cantidad']);
                    }
                    foreach ($facturasPagadas as $key => $facturaPagada) {
                        $cantidadFacturasPagadas = intval($facturaPagada['cantidad']);
                    }
                    foreach ($facturasRetefuente as $key => $facturaRetefuente) {
                        $cantidadFacturasRetefuente = intval($facturaRetefuente['cantidad']);
                    }
                    foreach ($facturasVencidas as $key => $facturaVencida) {
                        $cantidadFacturasVencidas = intval($facturaVencida['cantidad']);
                    }
                    //================================================================para sustratos ====================================================================
                    $sustratos = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->getSustratos($fechaInicioDatetime, $fechaFinDatetime, [$idOrganismoTransito]);
                    
                    foreach ($sustratos as $key => $sustrato) {
                        $totalSustratos += intval($sustrato['total']);
                    }

                    $conceptos = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->getConceptos($fechaInicioDatetime, $fechaFinDatetime, [$idOrganismoTransito]);

                    foreach ($conceptos as $key => $concepto) {
                        $totalConceptos += intval($concepto['total']);
                    }
                    
                    $cantidadFacturasGeneradas = 0;
                    $cantidadFacturasGeneradas = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->getFacturasGeneradasByFecha($fechaInicioDatetime, $fechaFinDatetime, [$idOrganismoTransito]);

                    $datos [] = array(
                        'organismoTransito' => $organismoTransito->getMunicipio(),
                        'tramitesFinalizados' => $tramitesFinalizados,
                        'totalTramitesFinalizados' => $totalTramitesFinalizados,
                        'sustratos' => $sustratos,
                        'totalSustratos' => $totalSustratos,
                        'conceptos' =>  $conceptos,
                        'totalConceptos' =>  $totalConceptos,
                        'cantidadFacturasDevolucionadas' => $cantidadFacturasDevolucionadas,
                        'cantidadFacturasRetefuente' => $cantidadFacturasRetefuente,
                        'cantidadFacturasPagadas' => $cantidadFacturasPagadas,
                        'cantidadFacturasVencidas' => $cantidadFacturasVencidas,
                        'cantidadFacturasGeneradas' => count($cantidadFacturasGeneradas),
                    );
                    
                    //===========================para pdf reporte general ================================================================================================================================
                }

                $html = $this->renderView('@JHWEBFinanciero/Default/ingresos/pdf.ingresos.tramites.html.twig', array(
                    'data' => $datos,
                    'reporteGeneral' =>$reporteGeneral,
                    'reporteDetallado' =>$reporteDetallado
                ));
                //===============================================================================================================

                $data = (object)
                    array(
                    'template' => 'templateExcelByTramites',
                    'tramitesFinalizados' => $tramitesFinalizados,
                    'totalTramitesFinalizados' => $totalTramitesFinalizados,
                    'sustratos' => $sustratos,
                    'totalSustratos' => $totalSustratos,
                    'conceptos' =>  $conceptos,
                    'totalConceptos' =>  $totalConceptos,
                    'cantidadFacturasDevolucionadas' => $cantidadFacturasDevolucionadas,
                    'cantidadFacturasRetefuente' => $cantidadFacturasRetefuente,
                    'cantidadFacturasPagadas' => $cantidadFacturasPagadas,
                    'cantidadFacturasVencidas' => $cantidadFacturasVencidas,
                    'cantidadFacturasGeneradas' => count($cantidadFacturasGeneradas),
                    'reporteGeneral' => $reporteGeneral,
                    'reporteDetallado' => $reporteDetallado,
                    'filtros' => array(
                        'tipoArchivoTramite' => $params->tipoArchivoTramite, 
                        'fechaInicio' => $fechaInicioDatetime,
                        'fechaFin' => $fechaFinDatetime,
                        'organismosTransito' => $params->filtros->arrayOrganismosTransito
                    )
                ); 
    
                if($params->exportarEn == 'EXCEL') {
                    return $this->get('app.excel')->newExcel($data);
                }else if($params->exportarEn == 'PDF'){
                    return new Response(
                        $this->get('app.pdf')->templateIngresos($html, $organismoTransito),
                        200,
                        array(
                            'Content-Type'        => 'application/pdf',
                            'Content-Disposition' => 'attachment; filename="fichero.pdf"'
                        )
                    );
                }
            } else if ($params->tipoArchivoTramite == 'DETALLADO') {
                $reporteGeneral = false;
                $reporteDetallado = true;

                foreach ($params->filtros->arrayOrganismosTransito as $key => $idOrganismoTransito) {
                    $organismoTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find($idOrganismoTransito);
                    
                    $totalTramitesFinalizados = 0;
                    $tramitesFinalizados = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->findTramitesFinalizados($params->tipoArchivoTramite, $fechaInicioDatetime,$fechaFinDatetime, [$idOrganismoTransito]);
                
                    foreach ($tramitesFinalizados as $key => $tramiteFinalizado) {
                        $totalTramitesFinalizados += $tramiteFinalizado['valorPagado'];
                    }

                    $datos[] = array(
                        'organismoTransito' => $organismoTransito->getMunicipio(), 
                        'tramitesFinalizados' => $tramitesFinalizados,
                        'totalTramitesFinalizados' => $totalTramitesFinalizados,
                    );
                    
                    $html = $this->renderView('@JHWEBFinanciero/Default/ingresos/pdf.ingresos.tramites.html.twig', array(
                        'data' => $datos,
                        'mesReporteDesde' => strtoupper(strftime("%B del %Y", strtotime($params->filtros->fechaDesde))),
                        'mesReporteHasta' => strtoupper(strftime("%B del %Y", strtotime($params->filtros->fechaHasta))),
                        'fechaActual' => $fechaActual,
                        'funcionario' => $funcionario,
                        'reporteGeneral' =>$reporteGeneral,
                        'reporteDetallado' =>$reporteDetallado
                    ));

                    $data = (object) array(
                        'template' => 'templateExcelByTramites',
                        'tramitesFinalizados' => $tramitesFinalizados,
                        'funcionario' => $funcionario,
                        'mesReporteDesde' => strtoupper(strftime("%B del %Y", strtotime($params->filtros->fechaDesde))),
                        'mesReporteHasta' => strtoupper(strftime("%B del %Y", strtotime($params->filtros->fechaHasta))),
                        'fechaActual' => $fechaActual,
                        'totalTramitesFinalizados' => $totalTramitesFinalizados,
                        'reporteGeneral' =>$reporteGeneral,
                        'reporteDetallado' =>$reporteDetallado,
                        'filtros' => array(
                            'tipoArchivoTramite' => $params->tipoArchivoTramite, 
                            'fechaInicio' => $fechaInicioDatetime,
                            'fechaFin' => $fechaFinDatetime,
                            'organismosTransito' => $params->filtros->arrayOrganismosTransito
                        )
                    );
                }   
                if($params->exportarEn == 'EXCEL') {
                    return $this->get('app.excel')->newExcel($data);
                } else if($params->exportarEn == 'PDF') {
                    return new Response(
                        $this->get('app.pdf')->templateIngresos($html),
                        200,
                        array(
                            'Content-Type'        => 'application/pdf',
                            'Content-Disposition' => 'attachment; filename="fichero.pdf"'
                            )
                        );
                    }
                }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida',
            );
        }

        return $helpers->json($response);
    }

    
    /**
     * datos para obtener comparendos por rango de fechas
     *
     * @Route("/pdf/infraccion/fecha", name="froinfraccion_rango_fechas")
     * @Method({"GET", "POST"})
     */
    public function infraccionesByFechaAction(Request $request) {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        
        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            setlocale(LC_ALL,"es_ES");
            $fechaActual = strftime("%d de %B del %Y");

            $fechaInicioDatetime = new \Datetime($params->fechaDesde);
            $fechaFinDatetime = new \Datetime($params->fechaHasta);
            
            $organismoTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find($params->idOrganismoTransito);

            $arrayInfracciones = []; 
            $totalInfracciones = 0;

            $infracciones = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->getInfraccionesByFecha($fechaInicioDatetime,$fechaFinDatetime, $organismoTransito->getId());
            
            if($infracciones){
                foreach ($infracciones as $key => $infraccion) {
                    $factura = $em->getRepository('JHWEBFinancieroBundle:FroFacComparendo')->findOneBy(
                        array(
                            'comparendo' => $infraccion->getId(),
                        )
                    );


                    $totalInfracciones += $factura->getFactura()->getValorNeto();

                    $arrayInfracciones[] = array(
                        'numeroConsecutivo' => $infraccion->getConsecutivo()->getNumero(),
                        'codigoInfraccion' => $infraccion->getInfraccion()->getCodigo(),
                        'numeroFactura' => $factura->getFactura()->getNumero(),
                        'infractorIdentificacion' => $infraccion->getInfractorIdentificacion(),
                        'infractorNombres' => $infraccion->getInfractorNombres(),
                        'infractorApellidos' => $infraccion->getInfractorApellidos(),
                        'porcentajeDescuento' => $infraccion->getPorcentajeDescuento(),
                        'total' => $factura->getFactura()->getValorNeto(),
                    );
                }
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => 'registros encontrados"',
                        'data' => array( 
                            'organismoTransito' => $organismoTransito,
                            'arrayInfracciones' => $arrayInfracciones,
                            'totalInfracciones' => $totalInfracciones
                        )
                    );
                    
                    /* $html = $this->renderView('@JHWEBFinanciero/Default/ingresos/pdf.ingresos.infracciones.html.twig', array(
                        'organismoTransito' => $organismoTransito, 
                        'arrayInfracciones' => $arrayInfracciones,
                        'totalInfracciones' => $totalInfracciones,
                    )); 
    
                    return new Response(
                        $this->get('app.pdf')->templateIngresos($html, $organismoTransito),
                        200,
                        array(
                            'Content-Type'        => 'application/pdf',
                            'Content-Disposition' => 'attachment; filename="fichero.pdf"'
                        )
                    ); */
                } else {
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "No existen registros aún para la fecha estipulada.",
                    );
                }
        } else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida',
            );
        }
        return $helpers->json($response);
    }

    /**
     * datos para obtener acuerdos de pago por rango de fechas
     *
     * @Route("/pdf/acuerdopago/fecha", name="froacuerdo_pago_rango_fechas")
     * @Method({"GET", "POST"})
     */
    public function acuerdosPagoByFechaAction(Request $request) {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        
        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            setlocale(LC_ALL,"es_ES");
            $fechaActual = strftime("%d de %B del %Y");

            $fechaInicioDatetime = new \Datetime($params->fechaDesde);
            $fechaFinDatetime = new \Datetime($params->fechaHasta);
            
            $organismoTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find($params->idOrganismoTransito);

            $arrayAcuerdosPago = []; 
            $totalAcuerdosPago = 0;

            $acuerdosPago = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->getAcuerdosPagoByFecha($fechaInicioDatetime,$fechaFinDatetime, $organismoTransito->getId());

            if($acuerdosPago){
                foreach ($acuerdosPago as $key => $acuerdoPago) {
                    $comparendo = $em->getRepository('JHWEBFinancieroBundle:FroFacComparendo')->findOneBy(
                        array(
                            'comparendo' => $acuerdoPago->getAcuerdoPago()->getId(),
                        )
                    );

                    $totalAcuerdosPago += $comparendo->getFactura()->getValorNeto();

                    $arrayAcuerdosPago[] = array(
                        'numeroAcuerdoPago' => $acuerdoPago->getAcuerdoPago()->getNumero(),
                        'numeroComparendo' => $acuerdoPago->getAcuerdoPago()->getConsecutivo(),
                        'identificacionInfractor' => $acuerdoPago->getAcuerdoPago()->getCiudadano()->getIdentificacion(),
                        'nombreCompletoInfractor' => $acuerdoPago->getAcuerdoPago()->getCiudadano()->getPrimerNombre() . ' ' . $acuerdoPago->getAcuerdoPago()->getCiudadano()->getSegundoNombre(). ' ' . $acuerdoPago->getAcuerdoPago()->getCiudadano()->getPrimerApellido(). ' ' . $acuerdoPago->getAcuerdoPago()->getCiudadano()->getSegundoApellido(),
                        'codigoInfraccion' => $comparendo->getComparendo()->getInfraccion()->getCodigo(),
                        'numeroFactura' => $comparendo->getFactura()->getNumero(),
                        'numeroCuotaPagada' => $acuerdoPago->getPagada(),
                        'estado' => $comparendo->getComparendo()->getEstado()->getNombre(),
                        'valorAdeudado' => $acuerdoPago->getValorMora(),
                        'total' => $comparendo->getFactura()->getValorNeto(),
                    );
                }
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => 'registros encontrados"',
                        'data' => array(
                            'organismoTransito' => $organismoTransito,
                            'arrayAcuerdosPago' => $arrayAcuerdosPago,
                            'totalAcuerdosPago' => $totalAcuerdosPago,
                        )
                    );
                    
                    /* $html = $this->renderView('@JHWEBFinanciero/Default/ingresos/pdf.ingresos.acuerdosPago.html.twig', array(
                        'organismoTransito' => $organismoTransito, 
                        'arrayAcuerdosPago' => $arrayAcuerdosPago,
                        'totalAcuerdosPago' => $totalAcuerdosPago,
                    )); 
    
                    return new Response(
                        $this->get('app.pdf')->templateIngresos($html, $organismoTransito),
                        200,
                        array(
                            'Content-Type'        => 'application/pdf',
                            'Content-Disposition' => 'attachment; filename="fichero.pdf"'
                        )
                    ); */
                } else {
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "No existen registros aún para la fecha estipulada.",
                    );
                }
        } else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida',
            );
        }
        return $helpers->json($response);
    }

    /**
     * datos para obtener inmovilizaciones por rango de fechas
     *
     * @Route("/pdf/parqueadero/fecha", name="froinmovilizacion_rango_fechas")
     * @Method({"GET", "POST"})
     */
    public function inmovilizacionByFechaAction(Request $request) {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        
        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            setlocale(LC_ALL,"es_ES");
            $fechaActual = strftime("%d de %B del %Y");

            $fechaInicioDatetime = new \Datetime($params->fechaDesde);
            $fechaFinDatetime = new \Datetime($params->fechaHasta);
            
            $organismoTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find($params->idOrganismoTransito);

            $arrayInmovilizaciones = []; 
            $totalInmovilizaciones = 0;

            $inmovilizaciones = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->getInmovilizacionesByFecha($fechaInicioDatetime,$fechaFinDatetime, $organismoTransito->getId());

            if($inmovilizaciones){
                foreach ($inmovilizaciones as $key => $inmovilizacion) {
                    $factura = $em->getRepository('JHWEBFinancieroBundle:FroFacParqueadero')->findOneBy(
                        array(
                            'inmovilizacion' => $inmovilizacion->getId(),
                        )
                    );

                    $totalInmovilizaciones += $factura->getFactura()->getValorNeto();

                    $arrayInmovilizaciones[] = array(
                        'numeroRecibo' => $inmovilizacion->getInmovilizacion()->getNumeroRecibo(),
                        'placa' => $inmovilizacion->getInmovilizacion()->getPlaca(),
                        'fechaIngreso' => $inmovilizacion->getInmovilizacion()->getFechaIngreso(),
                        'fechaSalida' => $inmovilizacion->getInmovilizacion()->getFechaSalida(),
                        'horaSalida' => $inmovilizacion->getInmovilizacion()->getHoraSalida(),
                        'horas' => $inmovilizacion->getMinutos(),
                        'valorHora' => $inmovilizacion->getValorParqueadero(),
                        'costoGrua' => $inmovilizacion->getValorGrua(),
                        'valor' => $factura->getFactura()->getValorNeto(),
                    );
                }
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => 'registros encontrados"',
                        'data' => array(
                            'organismoTransito' => $organismoTransito,
                            'arrayInmovilizaciones' => $arrayInmovilizaciones,
                            'totalInmovilizaciones' => $totalInmovilizaciones,
                        )
                    );
                    
                    /* $html = $this->renderView('@JHWEBFinanciero/Default/ingresos/pdf.ingresos.parqueadero.html.twig', array(
                        'organismoTransito' => $organismoTransito, 
                        'arrayInmovilizaciones' => $arrayInmovilizaciones,
                        'totalInmovilizaciones' => $totalInmovilizaciones,
                    )); 
    
                    return new Response(
                        $this->get('app.pdf')->templateIngresos($html, $organismoTransito),
                        200,
                        array(
                            'Content-Type'        => 'application/pdf',
                            'Content-Disposition' => 'attachment; filename="fichero.pdf"'
                        )
                    ); */
                } else {
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "No existen registros aún para la fecha estipulada.",
                    );
                }
        } else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida',
            );
        }
        return $helpers->json($response);
    }

    /**
     * datos para obtener retefuente por rango de fechas
     *
     * @Route("/pdf/retefuente/fecha", name="froretefuente_rango_fechas")
     * @Method({"GET", "POST"})
     */
    public function retefuenteByFechaAction(Request $request) {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        
        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            setlocale(LC_ALL,"es_ES");
            $fechaActual = strftime("%d de %B del %Y");

            $fechaInicioDatetime = new \Datetime($params->datos->fechaDesde);
            $fechaFinDatetime = new \Datetime($params->datos->fechaHasta);
            
            $organismoTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find($params->datos->idOrganismoTransito);

            $arrayRetefuentesExogena = []; 
            $arrayRetefuentesTesoreria = []; 
            $totalRetefuentesExogena = 0;
            $totalRetefuentesTesoreria = 0;

            $retefuentes = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->getRetefuentesByFecha($fechaInicioDatetime,$fechaFinDatetime, $organismoTransito->getId());

            if($retefuentes){
                foreach ($retefuentes as $key => $retefuente) {
                    $totalRetefuentesExogena += $retefuente->getRetencion();
                    $totalRetefuentesTesoreria += $retefuente->getRetencion();

                    $arrayRetefuentesExogena[] = array(
                        'ciudadano' => !empty($retefuente->getPropietario()->getCiudadano()) ? $retefuente->getPropietario()->getCiudadano(): null,
                        'empresa' => !empty($retefuente->getPropietario()->getEmpresa()) ? $retefuente->getPropietario()->getEmpresa(): null,
                        'valorVehiculo' => $retefuente->getValorVehiculo()->getValor(),
                        'retencion' => $retefuente->getRetencion()
                    );

                    $arrayRetefuentesTesoreria[] = array(
                        'fechaFactura' => $retefuente->getFactura()->getFechaCreacion(),
                        'placa' => $retefuente->getVehiculo()->getPlaca()->getNumero(),
                        'reciboCaja' => $retefuente->getFactura()->getNumero(),
                        'estadoFactura' => $retefuente->getFactura()->getEstado(),
                        'marca' => $retefuente->getVehiculo()->getLinea()->getMarca()->getNombre(),
                        'clase' => $retefuente->getVehiculo()->getClase()->getNombre(),
                        'modelo' => $retefuente->getVehiculo()->getModelo(),
                        'ciudadano' => !empty($retefuente->getPropietario()->getCiudadano()) ? $retefuente->getPropietario()->getCiudadano(): null,
                        'empresa' => !empty($retefuente->getPropietario()->getEmpresa()) ? $retefuente->getPropietario()->getEmpresa(): null,
                        'valorVehiculo' => $retefuente->getValorVehiculo()->getValor(),
                        'retencion' => $retefuente->getRetencion(),
                    );

                }
                
                if(intval($params->tipoArchivo) == 1){
                    $dataExogena = array(
                        'organismoTransito' => $organismoTransito, 
                        'arrayRetefuentesExogena' => $arrayRetefuentesExogena,
                        'totalRetefuentesExogena' => $totalRetefuentesExogena,
                    );
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => 'Registros encontrados"',
                        'dataExogena' => $dataExogena
                    );
                }
                if(intval($params->tipoArchivo) == 0){
                    $dataTesoreria = array(
                        'organismoTransito' => $organismoTransito, 
                        'arrayRetefuentesTesoreria' => $arrayRetefuentesTesoreria,
                        'totalRetefuentesTesoreria' => $totalRetefuentesTesoreria,
                    );
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => 'Registros encontrados"',
                        'dataTesoreria' => $dataTesoreria
                    );
                }

                    /* $html = $this->renderView('@JHWEBFinanciero/Default/ingresos/pdf.ingresos.retefuente.html.twig', array(
                        'organismoTransito' => $organismoTransito, 
                        'arrayRetefuentes' => $arrayRetefuentes,
                        'totalRetefuentes' => $totalRetefuentes,
                    )); 
    
                    return new Response(
                        $this->get('app.pdf')->templateIngresos($html, $organismoTransito),
                        200,
                        array(
                            'Content-Type'        => 'application/pdf',
                            'Content-Disposition' => 'attachment; filename="fichero.pdf"'
                        )
                    ); */
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No existen registros aún para la fecha estipulada.",
                );
            }
        } else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida',
            );
        }
        return $helpers->json($response);
    }
}
