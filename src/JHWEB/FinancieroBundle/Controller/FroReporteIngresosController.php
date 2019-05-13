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
                        'ciudadano' => $ciudadano,
                )
            );
            
            $reporteMensual = false;
            
            if($fechaInicioDatetime ==  $fechaFinDatetime) {
                $tramites = $em->getRepository('JHWEBFinancieroBundle:FroReporteIngresos')->findTramitesDiario($fechaInicioDatetime, $organismoTransito->getId());

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
                $totalConceptos = 0;
                $totalTramites = 0;

                $arrayConceptos = [];
                $arrayTramites = [];
                $arraySustratos = [];
                
                if($tramites){
                    foreach ($tramites as $key => $tramite) {
                        $numeros[] = $tramite->getTramiteFactura()->getFactura()->getNumero();
                        switch ($tramite->getTramiteFactura()->getFactura()->getEstado() ) {
                            case 'PAGADA':
                            case 'FINALIZADA':
                                $pagadas[] = $tramite;
                                $valorTramitesPagados += $tramite->getTramiteFactura()->getPrecio()->getValor(); 
                                
                                //=================================================
                                $cantTramites = $em->getRepository('JHWEBFinancieroBundle:FroReporteIngresos')->getTramiteByName($tramite->getTramiteFactura()->getPrecio()->getTramite()->getId());
                                $total2 = intval(implode($cantTramites)) * $tramite->getTramiteFactura()->getPrecio()->getValor();
                                $totalTramites += intval(implode($cantTramites)) * $tramite->getTramiteFactura()->getPrecio()->getValor();
                                $arrayTramites[] = array(
                                    'id' => $tramite->getTramiteFactura()->getPrecio()->getTramite()->getCodigo(),
                                    'nombre' => $tramite->getTramiteFactura()->getPrecio()->getTramite()->getNombre(),
                                    'cantidad' => intval(implode($cantTramites)),
                                    'valor' => $tramite->getTramiteFactura()->getPrecio()->getValor(),
                                    'total2' => $total2,
                                );
                                
                                $conceptos = $em->getRepository('JHWEBFinancieroBundle:FroTrteConcepto')->findBy(
                                    array(
                                        'precio' => $tramite->getTramiteFactura()->getPrecio()->getId(),
                                        )
                                    );

                                //================================================================para sustratos ====================================================================
                                $insumos = $em->getRepository('JHWEBInsumoBundle:ImoInsumo')->findBy(
                                    array(
                                        'factura' => $tramite->getTramiteFactura()->getFactura(),
                                        'categoria' => 'SUSTRATO'
                                    )
                                );

                                foreach ($insumos as $key => $sustrato) {
                                    $cantSustratos = $em->getRepository('JHWEBFinancieroBundle:FroReporteIngresos')->getSustratosByName($tramite->getTramiteFactura()->getFactura()->getId()); 

                                    $imoValor = $em->getRepository('JHWEBInsumoBundle:ImoCfgValor')->findOneBy(
                                        array(
                                            'imoCfgTipo' => $sustrato->getTipo(),
                                        )
                                    );

                                    $total3 = intval(implode($cantSustratos)) * $imoValor->getValor();
                                    $totalSustratos += intval(implode($cantSustratos)) * $imoValor->getValor();

                                    $arraySustratos[] = array(
                                        'nombre' => $sustrato->getTipo()->getNombre(),
                                        'cantidad' => intval(implode($cantSustratos)),
                                        'valor' => $imoValor->getValor(),
                                        'total' => $total3,
                                    );
                                }
                                //==================================================================================================================================================

                                break;
                            case 'ANULADA':
                                $anuladas[] = $tramite;
                                $numerosAnulados[] = $tramite->getTramiteFactura()->getFactura()->getNumero();
                                $valorTramitesAnulados += $tramite->getTramiteFactura()->getPrecio()->getValor(); 
                                if($tramite->getTramiteFactura()->getPrecio()->getTramite()->getNombre() == 'TRASPASO') {
                                    $traspasos[] = $tramite;
                                }
                                break;
                        }     
                    }
                    foreach ($conceptos as $key => $concepto) {
                        $cantConceptos = $em->getRepository('JHWEBFinancieroBundle:FroReporteIngresos')->getByName($concepto->getConcepto()->getId(), $tramite->getTramiteFactura()->getPrecio()->getId());
                        $total = intval(implode($cantConceptos)) * $concepto->getConcepto()->getValor();
                        $totalConceptos += intval(implode($cantConceptos)) * $concepto->getConcepto()->getValor();
                        $arrayConceptos[] = array(
                            'id' => $concepto->getConcepto()->getId(),
                            'nombre' => $concepto->getConcepto()->getNombre(),
                            'cantidad' => intval(implode($cantConceptos)),
                            'valor' => $concepto->getConcepto()->getValor(),
                            'total' => $total,
                        );    
                    }

                    $html = $this->renderView('@JHWEBFinanciero/Default/ingresos/pdf.ingresos.tramites.html.twig', array(
                        'organismoTransito' => $organismoTransito, 
                        'pagadas' => $pagadas, 
                        'anuladas' => $anuladas, 
                        'cantPagadas' => count($pagadas), 
                        'cantAnuladas' => count($anuladas), 
                        'valorTramitesPagados' => $valorTramitesPagados, 
                        'valorTramitesAnulados' => $valorTramitesAnulados, 
                        'conceptos' => $conceptos,
                        'arraySustratos' => $arraySustratos,
                        'cantConceptos' => $cantConceptos,
                        'arrayConceptos' => $arrayConceptos,
                        'arrayTramites' => $arrayTramites,
                        'totalConceptos' => $totalConceptos,
                        'totalSustratos' => $totalSustratos,
                        'totalTramites' => $totalTramites,
                        'traspasosAnulados' => $traspasos,
                        'cantTraspasos' => count($traspasos),
                        'min' =>min($numeros),
                        'max' =>max($numeros),
                        'reporteMensual' =>$reporteMensual,
                        'minAnulados' =>min($numerosAnulados),
                        'maxAnulados' =>max($numerosAnulados),
                    )); 
        
                    return new Response(
                        $this->get('app.pdf')->templateIngresos($html, $organismoTransito),
                        200,
                        array(
                            'Content-Type'        => 'application/pdf',
                            'Content-Disposition' => 'attachment; filename="fichero.pdf"'
                            )
                        );
                } else {
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "No se encontraron registros.",
                    );
                }
            } else if ($fechaInicioDatetime < $fechaFinDatetime) {
                $arrayReporteMensual = [];
                $totalReporteMensual = 0;
                
                $tramites = $em->getRepository('JHWEBFinancieroBundle:FroReporteIngresos')->findTramitesMensual($fechaInicioDatetime,$fechaFinDatetime, $organismoTransito->getId());
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

                        $arrayReporteMensual[] = array(
                            'numeroFactura' => $tramite->getTramiteFactura()->getFactura()->getNumero(),
                            'fecha' => $tramite->getTramiteFactura()->getFactura()->getFechaPago(),
                            'placaCedula' => $placaCedula,
                            'nombre' => $tramite->getTramiteFactura()->getPrecio()->getTramite()->getNombre(),
                            'valorPagado' => $tramite->getTramiteFactura()->getPrecio()->getValor(),
                        );
                    }
                    
                    $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "registros encontrados",
                );
                
                $html = $this->renderView('@JHWEBFinanciero/Default/ingresos/pdf.ingresos.tramites.html.twig', array(
                    'organismoTransito' => $organismoTransito, 
                    'arrayReporteMensual' => $arrayReporteMensual,
                    'reporteMensual' => $reporteMensual,
                    'funcionario' => $funcionario,
                    'mesReporte' => strftime("%B del %Y", strtotime($params->filtros->fechaDesde)),
                    'fechaActual' => $fechaActual,
                    'totalReporteMensual' => $totalReporteMensual
                    /* 'totalSustratos' => $totalSustratos, */
                )); 
                    
                return new Response(
                    $this->get('app.pdf')->templateIngresos($html, $organismoTransito),
                    200,
                    array(
                        'Content-Type'        => 'application/pdf',
                        'Content-Disposition' => 'attachment; filename="fichero.pdf"'
                        )
                    );
                } else {
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "No existen registros aún para la fecha estipulada.",
                    );
                }
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No existen registros para la generación de reportes en el rango de las fechas estipuladas.",
                );
            }
            return $helpers->json($response);
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
     * @Route("/pdf/comparendo/fecha", name="frocomparendo_rango_fechas")
     * @Method({"GET", "POST"})
     */
    public function comparendosByFechaAction(Request $request) {
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
            
            $organismoTransito = $em->getRepository('JHWEBContravencialBundle:CvCdoComparendo')->find($params->filtros->idOrganismoTransito);

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
                
            $tramites = $em->getRepository('JHWEBFinancieroBundle:FroReporteIngresos')->findTramitesMensual($fechaInicioDatetime,$fechaFinDatetime, $organismoTransito->getId());
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

                        $arrayReporteMensual[] = array(
                            'numeroFactura' => $tramite->getTramiteFactura()->getFactura()->getNumero(),
                            'fecha' => $tramite->getTramiteFactura()->getFactura()->getFechaPago(),
                            'placaCedula' => $placaCedula,
                            'nombre' => $tramite->getTramiteFactura()->getPrecio()->getTramite()->getNombre(),
                            'valorPagado' => $tramite->getTramiteFactura()->getPrecio()->getValor(),
                        );
                    }
                    
                    $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "registros encontrados",
                );
                
                $html = $this->renderView('@JHWEBFinanciero/Default/ingresos/pdf.ingresos.tramites.html.twig', array(
                    'organismoTransito' => $organismoTransito, 
                    'arrayReporteMensual' => $arrayReporteMensual,
                    'reporteMensual' => $reporteMensual,
                    'funcionario' => $funcionario,
                    'mesReporte' => strftime("%B del %Y", strtotime($params->filtros->fechaDesde)),
                    'fechaActual' => $fechaActual,
                    'totalReporteMensual' => $totalReporteMensual
                    /* 'totalSustratos' => $totalSustratos, */
                )); 
                    
                return new Response(
                    $this->get('app.pdf')->templateIngresos($html, $organismoTransito),
                    200,
                    array(
                        'Content-Type'        => 'application/pdf',
                        'Content-Disposition' => 'attachment; filename="fichero.pdf"'
                        )
                    );
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
