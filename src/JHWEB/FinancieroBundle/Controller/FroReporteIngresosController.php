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
            
            $organismoTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find($params->filtros->idOrganismoTransito);

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

            $reporteMensual = false;
            
            if(intval($params->tipoArchivoTramite) == 1) {
                $tramites = null;

                $tramites = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->findTramites($fechaInicioDatetime,$fechaFinDatetime, $organismoTransito->getId());

                $pagadas = [];
                $finalizadas = [];
                $anuladas = [];
                $traspasos = [];
                $conceptos = [];
                $numeros = [];
                $numerosaAnulados = [];
                
                //SUSTRATO
                $sustratos = [];

                $valorTramitesPagados = 0;
                $valorTramitesVencidos = 0;
                $valorTramitesAnulados = 0;
                
                $totalSustratos = 0;
                $cantSustratos = 0;
                $nombreSustrato;
                $valorUnitarioSustrato = 0;
                
                $idConcepto;
                $cantConceptos = 0;
                $valorUnitarioConcepto = 0;
                $valorConceptos = 0;
                $totalConceptos = 0;
                $totalTramites = 0;

                $arrayConceptos = [];
                $arrayTramites = [];
                $arraySustratos = [];
                $numerosAnulados[] = null;
                
                if($tramites){
                    foreach ($tramites as $key => $tramite) {
                        $numeros[] = $tramite->getTramiteFactura()->getFactura()->getNumero();
                        switch ($tramite->getTramiteFactura()->getFactura()->getEstado() ) {
                            case 'FINALIZADA':
                                $pagadas[] = $tramite;
                                $valorTramitesPagados += $tramite->getTramiteFactura()->getPrecio()->getValor(); 
                                
                                //=================================================
                                $cantTramites = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->getTramiteByName($tramite->getTramiteFactura()->getPrecio()->getTramite()->getId());
                                $total2 = intval(implode($cantTramites)) * $tramite->getTramiteFactura()->getPrecio()->getValor();
                                $totalTramites += intval(implode($cantTramites)) * $tramite->getTramiteFactura()->getPrecio()->getValor();
                                $arrayTramites[] = array(
                                    'id' => $tramite->getTramiteFactura()->getPrecio()->getTramite()->getCodigo(),
                                    'nombre' => $tramite->getTramiteFactura()->getPrecio()->getTramite()->getNombre(),
                                    'cantidad' => intval(implode($cantTramites)),
                                    'valor' => $tramite->getTramiteFactura()->getPrecio()->getValor(),
                                    'total2' => $total2,
                                );

                                //================================================================para sustratos ====================================================================
                                $sustratos = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->getSustratoByFactura(
                                    $tramite->getTramiteFactura()->getFactura()->getId()
                                );
                                
                                foreach ($sustratos as $key => $sustrato) {
                                    $totalSustratos += $sustrato['total'];
                                }
                                //==================================================================================================================================================
                                
                                break;
                            case 'DEVOLUCION':
                            $anuladas[] = $tramite;
                            $numerosAnulados[] = array(
                                $tramite->getTramiteFactura()->getFactura()->getNumero()
                            );
                            
                            $valorTramitesAnulados += $tramite->getTramiteFactura()->getPrecio()->getValor(); 
                            if($tramite->getTramiteFactura()->getPrecio()->getTramite()->getNombre() == 'TRASPASO') {
                                $traspasos[] = $tramite;
                            }
                            break;
                        }     
                    }
                    
                    // =========================================================================fin recorrido para los tramites========================================================
                    $conceptos = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->getConceptos($fechaInicioDatetime, $fechaFinDatetime);

                    foreach ($conceptos as $key => $concepto) {
                        $totalConceptos += intval($concepto['total']);
                    }

                    //=========================================total de facturas por estado==========================================
                    $facturasPagadas = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->findBy(
                        array(
                            'estado' => 'PAGADA' 
                        )
                    );

                    $facturasVencidas = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->findBy(
                        array(
                            'estado' => 'VENCIDA' 
                        )
                    );
                        
                    $facturas = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->findAll();
                    
                    //===============================================================================================================
                    $html = $this->renderView('@JHWEBFinanciero/Default/ingresos/pdf.ingresos.tramites.html.twig', array(
                        'organismoTransito' => $organismoTransito, 
                        'pagadas' => $pagadas, 
                        'anuladas' => $anuladas, 
                        'cantPagadas' => count($pagadas), 
                        'cantAnuladas' => count($anuladas), 
                        'valorTramitesPagados' => $valorTramitesPagados, 
                        'valorTramitesAnulados' => $valorTramitesAnulados, 
                        'sustratos' => $sustratos,
                        'totalSustratos' => $totalSustratos,
                        'arrayTramites' => $arrayTramites,
                        'totalTramites' => $totalTramites,
                        'conceptos' =>  $conceptos,
                        'totalConceptos' =>  $totalConceptos,
                        'traspasosAnulados' => $traspasos,
                        'cantTraspasos' => count($traspasos),
                        'totalFacturasPagadas' => count($facturasPagadas),
                        'totalFacturasVencidas' => count($facturasVencidas),
                        'totalFacturas' => count($facturas),
                        'reporteMensual' =>$reporteMensual,
                    )); 

                    $data = (object)
                        array(
                        'template' => 'templateExcelByTramites',
                        'organismoTransito' => $organismoTransito, 
                        'pagadas' => $pagadas, 
                        'anuladas' => $anuladas, 
                        'cantPagadas' => count($pagadas), 
                        'cantAnuladas' => count($anuladas), 
                        'valorTramitesPagados' => $valorTramitesPagados, 
                        'valorTramitesAnulados' => $valorTramitesAnulados, 
                        'arraySustratos' => $arraySustratos,
                        'totalSustratos' => $totalSustratos,
                        'conceptos' => $conceptos,
                        'totalConceptos' => $totalConceptos,
                        'arrayTramites' => $arrayTramites,
                        'totalTramites' => $totalTramites,
                        'traspasosAnulados' => $traspasos,
                        'cantTraspasos' => count($traspasos),
                        'totalFacturasPagadas' => count($facturasPagadas),
                        'totalFacturasVencidas' => count($facturasVencidas),
                        'totalFacturas' => count($facturas),
                        'reporteMensual' =>$reporteMensual,
                    ); 
        
                    if($params->exportarEn == 1) {
                        return $this->get('app.excel')->newExcel($data);
                    }else if($params->exportarEn == 2){
                        return new Response(
                            $this->get('app.pdf')->templateIngresos($html, $organismoTransito),
                            200,
                            array(
                                'Content-Type'        => 'application/pdf',
                                'Content-Disposition' => 'attachment; filename="fichero.pdf"'
                            )
                        );
                    }
                } else {
                    $response = array(
                        'title' => 'Error!',
                        'status' => 'error',
                        'code' => 400,
                        'message' => 'No se encontraron registros.',
                    );
                }
            } else if ($params->tipoArchivoTramite == 0) {
                $arrayReporteMensual = [];
                $totalReporteMensual = 0;
                
                $tramites = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->findTramites($fechaInicioDatetime,$fechaFinDatetime, $organismoTransito->getId());
                if($tramites){
                    $reporteMensual = true;
                    foreach ($tramites as $key => $tramite) {
                        $placaCedula;
                        if($tramite->getVehiculo() != null) {
                            $placaCedula = $tramite->getVehiculo()->getPlaca()->getNumero();
                        } else if($tramite->getVehiculo() == null) {
                            $placaCedula = $tramite->getSolicitante()->getIdentificacion();
                        }

                        $totalReporteMensual += $tramite->getTramiteFactura()->getPrecio()->getValor();

                        $sustratos = $em->getRepository('JHWEBFinancieroBundle:FroFacInsumo')->findBy(
                            array(
                                'factura' => $tramite->getTramiteFactura()->getFactura()->getId(),
                            )
                        );
                        
                        foreach ($sustratos as $key => $sustrato) {
                            switch ($sustrato->getInsumo()->getTipo()->getCategoria()) {
                                case 'SUSTRATO':
                                    $numeroSustrato = $sustrato->getInsumo()->getNumero();
                                    $moduloSustrato = $sustrato->getInsumo()->getTipo()->getModulo()->getAbreviatura();
                                    break;
                            }
                        }


                        $arrayReporteMensual[] = array(
                            'numeroFactura' => $tramite->getTramiteFactura()->getFactura()->getNumero(),
                            'fecha' => $tramite->getTramiteFactura()->getFactura()->getFechaPago(),
                            'placaCedula' => $placaCedula,
                            'numeroSustrato' => $numeroSustrato,
                            'moduloSustrato' => $moduloSustrato,
                            'nombre' => $tramite->getTramiteFactura()->getPrecio()->getTramite()->getNombre(),
                            'fechaTramite' => $tramite->getFecha(),
                            'valorPagado' => $tramite->getTramiteFactura()->getPrecio()->getValor(),
                            'numeroRunt' => $tramite->getTramiteFactura()->getFactura()->getNumeroRunt()
                        );
                    }
                    
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => "Registros encontrados",
                );
                
                $html = $this->renderView('@JHWEBFinanciero/Default/ingresos/pdf.ingresos.tramites.html.twig', array(
                    'organismoTransito' => $organismoTransito, 
                    'arrayReporteMensual' => $arrayReporteMensual,
                    'reporteMensual' => $reporteMensual,
                    'funcionario' => $funcionario,
                    'mesReporteDesde' => strtoupper(strftime("%B del %Y", strtotime($params->filtros->fechaDesde))),
                    'mesReporteHasta' => strtoupper(strftime("%B del %Y", strtotime($params->filtros->fechaHasta))),
                    'fechaActual' => $fechaActual,
                    'totalReporteMensual' => $totalReporteMensual,
                    /* 'totalSustratos' => $totalSustratos, */
                )); 

                $data = (object) array(
                    'template' => 'templateExcelByTramites',
                    'organismoTransito' => $organismoTransito, 
                    'arrayReporteMensual' => $arrayReporteMensual,
                    'reporteMensual' => $reporteMensual,
                    'funcionario' => $funcionario,
                    'mesReporteDesde' => strtoupper(strftime("%B del %Y", strtotime($params->filtros->fechaDesde))),
                    'mesReporteHasta' => strtoupper(strftime("%B del %Y", strtotime($params->filtros->fechaHasta))),
                    'fechaActual' => $fechaActual,
                    'totalReporteMensual' => $totalReporteMensual,
                    /* 'totalSustratos' => $totalSustratos, */
                ); 

                if($params->exportarEn == 1) {
                    return $this->get('app.excel')->newExcel($data);
                } else if($params->exportarEn == 2) {
                    return new Response(
                        $this->get('app.pdf')->templateIngresos($html, $organismoTransito),
                        200,
                        array(
                            'Content-Type'        => 'application/pdf',
                            'Content-Disposition' => 'attachment; filename="fichero.pdf"'
                            )
                        );
                    }
                } else {
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "No existen registros aún para la fecha estipulada.",
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

            /* $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findOneBy(
                array(
                    'identificacion' => $params->identificacion,
                    )
                );
                
            $funcionario = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->findOneBy(
                array(
                    'ciudadano' => $ciudadano,
                    )
                );
        
            $totalReporteMensual = 0; */
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
                        'placa' => $inmovilizacion->getPlaca(),
                        'fechaIngreso' => $inmovilizacion->getInmovilizacion()->getFechaIngreso(),
                        'fechaSalida' => $inmovilizacion->getInmovilizacion()->getFechaSalida(),
                        'horaSalida' => $inmovilizacion->getInmovilizacion()->getHoraSalida(),
                        'horas' => $inmovilizacion->getHoras(),
                        'valorHora' => $inmovilizacion->getValorHora(),
                        'costoGrua' => $inmovilizacion->getInmovilizacion()->getCostoGrua(),
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
