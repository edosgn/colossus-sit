<?php

namespace JHWEB\FinancieroBundle\Controller;

use JHWEB\FinancieroBundle\Entity\FroFactura;
use JHWEB\FinancieroBundle\Entity\FroFacComparendo;
use JHWEB\FinancieroBundle\Entity\FroFacTramite;
use JHWEB\FinancieroBundle\Entity\FroFacParqueadero;
use JHWEB\FinancieroBundle\Entity\FroFacRetefuente;
use JHWEB\FinancieroBundle\Entity\FroFacTransferencia;
use JHWEB\VehiculoBundle\Entity\VhloCfgValor;
use JHWEB\ContravencionalBundle\Entity\CvCdoTrazabilidad;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;

/**
 * FrofroFactura controller.
 *
 * @Route("frofactura")
 */
class FroFacturaController extends Controller
{
    /**
     * Lists all cvCfgIntere entities.
     *
     * @Route("/", name="frofactura_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $facturas = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->findBy(
            array(
                'activo' => true
            )
        );

        $response['data'] = array();

        if ($facturas) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($facturas)." registros encontrados", 
                'data'=> $facturas,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new cvCfgIntere entity.
     *
     * @Route("/new", name="frofactura_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);
            
            $em = $this->getDoctrine()->getManager();
           
            $factura = new FroFactura();

            $fechaActual = date('Y-m-d');
            $fechaCreacion = new \Datetime($fechaActual);
            $fechaVencimiento = new \Datetime(date("Y-m-d",strtotime($fechaActual."+ 1 days"))); 
            $factura->setFechaCreacion($fechaCreacion);
            $factura->setFechaVencimiento($fechaVencimiento);
            $factura->setHora(new \Datetime(date('h:i:s A')));
            $factura->setValorBruto($params->factura->valor);
            $factura->setValorMora($params->factura->interes);
            $factura->setValorNeto($params->factura->valor + $params->factura->interes);
            $factura->setEstado('EMITIDA');
            $factura->setActivo(true);

            $consecutivo = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->getMaximo(date('Y'));
           
            $consecutivo = (empty($consecutivo['maximo']) ? 1 : $consecutivo['maximo']+=1);
            $factura->setConsecutivo($consecutivo);
            
            $factura->setNumero(
                $fechaCreacion->format('Y').$fechaCreacion->format('m').str_pad($consecutivo, 8, '0', STR_PAD_LEFT)
            );
            
            if ($params->factura->idOrganismoTransito) {
                $organismoTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find(
                    $params->factura->idOrganismoTransito
                );
                $factura->setOrganismoTransito($organismoTransito);
            }else{
                $organismoTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find(
                    100
                );
                $factura->setOrganismoTransito($organismoTransito);
            }

            if ($params->factura->idTipoRecaudo) {
                $tipoRecaudo = $em->getRepository('JHWEBFinancieroBundle:FroCfgTipoRecaudo')->find(
                    $params->factura->idTipoRecaudo
                );
                $factura->setTipoRecaudo($tipoRecaudo);
            }

            if (isset($params->factura->idCiudadano) && $params->factura->idCiudadano) {
                $solicitante = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->find(
                    $params->factura->idCiudadano
                );
                $factura->setSolicitante($solicitante);
            }

            $em->persist($factura);
            $em->flush();

            if (isset($params->factura->comparendos)) {
                $this->registerFacturaComparendos($params->factura->comparendos, $factura);
            }elseif (isset($params->factura->tramites)) {
                $this->registerFacturaTramites($params, $factura);
            }elseif (isset($params->factura->idInmovilizacion)) {
                $this->registerFacturaParqueadero($params->factura, $factura);
            }

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Factura No. '.$factura->getNumero().' creada con exito.',
                'data' => $factura
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida.', 
            );
        }

        return $helpers->json($response);
    }

    /* =================================== */

    /**
     * Displays a form to edit an existing Combustible entity.
     *
     * @Route("/complete", name="frofactura_complete")
     * @Method({"GET", "POST"})
     */
    public function completeAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $factura = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->find(
                $params->id
            );

            if ($factura) {
                $factura->setEstado('COMPLETAR TRAMITES');

                $em->flush();

                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Factura lista para completar trámites.", 
                    'data' => $factura, 
                );
            }else{
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorización no válida.", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new cvCfgIntere entity.
     *
     * @Route("/new/amortizacion", name="frofactura_new_amortizacion")
     * @Method({"GET", "POST"})
     */
    public function newAmortizacionAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
           
            $factura = new FroFactura();

            $fechaActual = new \Datetime(date('Y-m-d'));
            $fechaCreacion = $fechaActual;

            if ($params->idAmortizacion) {
                $amortizacion = $em->getRepository('JHWEBFinancieroBundle:FroAmortizacion')->find(
                    $params->idAmortizacion
                );
            }

            $factura->setFechaCreacion($fechaCreacion);
            $factura->setFechaVencimiento($fechaActual->modify('+1 days'));
            $factura->setHora(new \Datetime(date('h:i:s A')));
            $factura->setValorBruto($amortizacion->getValorBruto());
            $factura->setValorMora($amortizacion->getValorMora());
            $factura->setValorNeto($amortizacion->getValorNeto());
            $factura->setEstado('EMITIDA');
            $factura->setActivo(true);

            $consecutivo = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->getMaximo(date('Y'));
           
            $consecutivo = (empty($consecutivo['maximo']) ? 1 : $consecutivo['maximo']+=1);
            $factura->setConsecutivo($consecutivo);
            
            $factura->setNumero(
                $fechaCreacion->format('Y').$fechaCreacion->format('m').str_pad($consecutivo, 3, '0', STR_PAD_LEFT)
            );
            
            if ($params->idOrganismoTransito) {
                $organismoTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find(
                    $params->idOrganismoTransito
                );
                $factura->setOrganismoTransito($organismoTransito);
            }

            if ($params->idTipoRecaudo) {
                $tipoRecaudo = $em->getRepository('JHWEBFinancieroBundle:FroCfgTipoRecaudo')->find(
                    $params->idTipoRecaudo
                );
                $factura->setTipoRecaudo($tipoRecaudo);
            }

            $em->persist($factura);
            $em->flush();

            $amortizacion->setFactura($factura);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Factura No.".$factura->getNumero()." creada con exito",
                'data' => $factura
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
            );
        }

        return $helpers->json($response);
    }

    /* =================================== */

    /**
     * Busca factura por numero.
     *
     * @Route("/search/numero", name="frofactura_search_numero")
     * @Method({"GET", "POST"})
     */
    public function searchByNumero(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);


        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $froFactura = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->findOneBy(
                array(
                    'numero' => $params->numeroFactura,
                )
            );

            if(isset($params->idModulo)) {
                $modulo = $em->getRepository('JHWEBConfigBundle:CfgModulo')->find($params->idModulo);
            }

            if ($froFactura) {
                $facturaValida = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->validateByModulo($froFactura->getId(), $params->idModulo);

                if($facturaValida) {
                    if ($froFactura->getEstado() != 'FINALIZADA') {
                        if ($froFactura->getEstado() == 'PAGADA' || $froFactura->getEstado() == 'PENDIENTE DOCUMENTACION'  || $froFactura->getEstado() == 'COMPLETAR TRAMITES') {
                            $response = array(
                                'status' => 'success',
                                'code' => 200,
                                'message' => 'Factura aprobada.', 
                                'data'=> $froFactura
                            );
                        }else{
                            $response = array(
                                'status' => 'error',
                                'code' => 400,
                                'message' => 'Factura pendiente de pago.', 
                                'data'=> $froFactura
                            );
                        }
                    }else{
                        $response = array(
                            'status' => 'error',
                            'code' => 400,
                            'message' => 'La factura ya fue tramitada y se encuentra finalizada.', 
                            'data'=> $froFactura
                        );
                    }
                } else {
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => 'La factura no pertenece a ' . $modulo->getAbreviatura(), 
                        'data'=> $froFactura
                    );
                }
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'La factura no existe.' 
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
     * Busca si la factura genera excedentes por cambio de precios en los tramites.
     *
     * @Route("/validate/excedente", name="frofactura_validate_excedente")
     * @Method({"GET", "POST"})
     */
    public function validateExcedente(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);


        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $excedentes = null;

            $factura = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->find(
                $params->id
            );

            if ($factura) {
                $excedentesActuales = $em->getRepository('JHWEBFinancieroBundle:FroFacExcedente')->findBy(
                    array(
                        'factura' => $factura->getId(),
                        'pagado' => false,
                    )
                );

                if ($excedentesActuales) {
                    foreach ($excedentesActuales as $key => $excedenteActual) {
                        $excedentes[] = array(
                            'valor' => $excedenteActual->getValor(),  
                            'tramiteNombre' => $excedenteActual->getTramite()->getNombre(),
                            'facturaNumero' => $excedenteActual->getFactura()->getNunero(),
                            'idTramite' => $excedenteActual->getTramite()->getId(),
                            'idFactura' => $excedenteActual->getFactura()->getId(),
                        );
                    }

                    $response = array(
                        'title' => 'Atención!',
                        'status' => 'warning',
                        'code' => 401,
                        'message' => count($excedentesActuales).' trámites presentan valor excedente, no podra continuar hasta no realizar el pago del valor por excendentes.', 
                        'data'=> $excedentesActuales
                    );
                } else {
                    $facturaTramites = $em->getRepository('JHWEBFinancieroBundle:FroFacTramite')->findBy(
                        array(
                            'factura' => $factura->getId()
                        )
                    );
    
                    if ($facturaTramites) {
                        foreach ($facturaTramites as $key => $facturaTramite) {
                            if (!$facturaTramite->getPrecio()->getActivo()) {
                                $precioActual = $em->getRepository('JHWEBFinancieroBundle:FroFacPrecio')->findBy(
                                    array(
                                        'tramite' => $facturaTramite->getPrecio()->getTramite()->getId(),
                                        'tipoVehiculo' => $facturaTramite->getPrecio()->getTipoVehiculo()->getId(),
                                        'modulo' => $facturaTramite->getPrecio()->getModulo()->getId(),
                                    )
                                );
    
                                if ($precioActual && $precioActual->getValorTotal() > $facturaTramite->getPrecio()->getValorTotal()) {
                                    $excedentes[] = array(
                                        'valor' => $precioActual->getValorTotal() - $facturaTramite->getPrecio()->getValorTotal(),  
                                        'tramiteNombre' => $precioActual->getTramite()->getNombre(),
                                        'facturaNumero' => $factura->getNumero(),
                                        'idTramite' => $precioActual->getTramite()->getId(),  
                                        'idFactura' => $factura->getId(),
                                    );
                                }
                            }
                        }
    
                        if ($excedentes) {
                            $response = array(
                                'title' => 'Atención!',
                                'status' => 'warning',
                                'code' => 401,
                                'message' => count($excedentes).' trámites presentan valor excedente, no podra continuar hasta no realizar el pago del valor por excendentes.', 
                                'data'=> $excedentes
                            );
                        } else {
                            $response = array(
                                'title' => 'Prefecto!',
                                'status' => 'success',
                                'code' => 200,
                                'message' => 'Níngún trámite presenta excedente.', 
                            );
                        }
                    }else{
                        $response = array(
                            'title' => 'Atención!',
                            'status' => 'warning',
                            'code' => 400,
                            'message' => 'La factura no tiene ningún trámite registrado.', 
                        );
                    }
                }
            }else{
                $response = array(
                    'title' => 'Atención!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => 'La factura no existe.' 
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

    /**
     * Busca comparendos por parametros (nombres, identificacion, placa o numero).
     *
     * @Route("/search/filters", name="frofactura_search_filters")
     * @Method({"GET","POST"})
     */
    public function searchByFilters(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);


        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $facturas = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->getByFilters(
                $params
            );

            if ($facturas) {
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($facturas)." facturas encontradas.", 
                    'data' => $facturas,
            );
            }else{
                 $response = array(
                    'title' => 'Atención!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => "No existen facturas para los filtros de búsqueda.", 
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

    /**
     * Calcula el valor según los comparendos seleecionados.
     *
     * @Route("/calculate/value", name="frofactura_calculate_value")
     * @Method("POST")
     */
    public function calculateValueByComparendosAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $totalPagar = 0;
            $totalInteres = 0;

            foreach ($params as $key => $comparendoSelect) {
                $comparendo = $em->getRepository('JHWEBContravencionalBundle:CvCdoComparendo')->find(
                    $comparendoSelect->id
                );

                $interes = 0;
                $valorPagar = 0;

                if ($comparendo) {                   
                    $diasHabiles = $helpers->getDiasHabiles($comparendo->getFecha()->format('d/m/Y'));

                    if ($diasHabiles < 6 && $comparendoSelect->curso) {
                        $valorPagar = $comparendo->getValorInfraccion() / 2;
                    }elseif($diasHabiles > 5 && $diasHabiles < 21 && $comparendoSelect->curso){
                        $valorPagar = $comparendo->getValorInfraccion() - ($comparendo->getValorInfraccion() * 0.25);
                    }else{
                        if ($comparendo->getEstado()->getId() == 1 || $comparendo->getEstado()->getId() == 2 || $comparendo->getEstado()->getId() == 3) {

                            if ($comparendo->getEstado()->getId() == 2 || $comparendo->getEstado()->getId() == 3) {
                                //Busca la sanción en la trazabilidad del comparendo
                                $trazabilidad = $em->getRepository('JHWEBContravencionalBundle:CvCdoTrazabilidad')->findOneBy(
                                    array(
                                        'comparendo' => $comparendo->getId(),
                                        'estado' => 2
                                    )
                                );

                                $diasCalendario = $helpers->getDiasCalendario($trazabilidad->getFecha()->format('d/m/Y'));

                                $porcentajeInteres = $em->getRepository('JHWEBContravencionalBundle:CvCfgInteres')->findOneByActivo(
                                   true
                                );

                                $interes = $comparendo->getValorInfraccion() * ($porcentajeInteres->getValor() / 100);
                                $interes = $interes * $diasCalendario;
                            }
                            $totalInteres = $totalInteres + $interes;
                            $valorPagar = $comparendo->getValorInfraccion() + $interes;
                        }
                    }

                    $totalPagar += $valorPagar;
                }
            }
            
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Calculo generado',
                'data' => array(
                    'totalPagar' => round($totalPagar),
                    'totalInteres'=> round($totalInteres)
                )
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida",
            );
        }

        return $helpers->json($response);
    }

    /**
     * Registra los comparendos según la factura y calcula el valor según los comparendos seleccionados y actualiza los valores.
     */
    public function registerFacturaComparendos($params, $factura)
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $totalPagar = 0;
        $totalInteres = 0;

        foreach ($params as $key => $comparendoSelect) {
            $comparendo = $em->getRepository('JHWEBContravencionalBundle:CvCdoComparendo')->find(
                $comparendoSelect->id
            );

            //Inserta la relación de factura con comparendos seleccionados
            $facturaComparendo = new FroFacComparendo();

            $facturaComparendo->setFactura($factura);
            $facturaComparendo->setComparendo($comparendo);

            $em->persist($facturaComparendo);
            $em->flush();

            $interes = 0;

            if ($comparendo) {
                $factura->setPlaca($comparendo->getPlaca());

                //Actualiza el estado del curso
                if ($comparendoSelect->curso) {
                    $comparendo->setCurso(true);
                }else{
                    $comparendo->setCurso(false);
                }
                
                $diasHabiles = $helpers->getDiasHabiles($comparendo->getFecha()->format('d/m/Y'));

                if ($diasHabiles < 6 && $comparendoSelect->curso) {
                    $comparendo->setValorPagar($comparendo->getValorInfraccion() / 2);
                    $comparendo->setPorcentajeDescuento(50);
                }elseif($diasHabiles > 5 && $diasHabiles < 21 && $comparendoSelect->curso){
                    $comparendo->setValorPagar(
                        $comparendo->getValorInfraccion() - ($comparendo->getValorInfraccion() * 0.25)
                    );
                    $comparendo->setPorcentajeDescuento(25);
                }else{
                    $comparendo->setPorcentajeDescuento(0);

                    if ($comparendo->getEstado()->getId() == 1 || $comparendo->getEstado()->getId() == 2 || $comparendo->getEstado()->getId() == 3) {
                        if ($comparendo->getEstado()->getId() == 2 || $comparendo->getEstado()->getId() == 3) {
                            //Busca la sanción en la trazabilidad del comparendo
                            $trazabilidad = $em->getRepository('JHWEBContravencionalBundle:CvCdoTrazabilidad')->findOneBy(
                                array(
                                    'comparendo' => $comparendo->getId(),
                                    'estado' => 2
                                )
                            );

                            $diasCalendario = $helpers->getDiasCalendario($trazabilidad->getFecha()->format('d/m/Y'));

                            $porcentajeInteres = $em->getRepository('JHWEBContravencionalBundle:CvCfgInteres')->findOneByActivo(
                               true
                            );

                            $interes = $comparendo->getValorInfraccion() * ($porcentajeInteres->getValor() / 100);
                            $interes = $interes * $diasCalendario;
                        }
                        $totalInteres = $totalInteres + $interes;

                        $comparendo->setInteresMora($interes);
                        $comparendo->setValorPagar(
                            $comparendo->getValorInfraccion() + $interes
                        );
                    }
                }

                $em->flush();

                $totalPagar += $comparendo->getValorPagar();

                /* ========= Forzar tranferencia */
                $transferencia = new FroFacTransferencia();

                $transferencia->setFecha(new \Datetime(date('Y-m-d')));
                $transferencia->setHora(new \Datetime(date('h:i:s A')));

                if ($comparendo->getPolca()) {
                    $transferencia->setTipo('POLCA');
                    $transferencia->setValorSttdn($comparendo->getValorPagar() * (45 / 100));
                    $transferencia->setValorSimit($comparendo->getValorPagar() * (10 / 100));
                    $transferencia->setValorPolca($comparendo->getValorPagar() * (45 / 100));
                } else {
                    $transferencia->setTipo('STTDN');
                    $transferencia->setValorSttdn($comparendo->getValorPagar() * (90 / 100));
                    $transferencia->setValorSimit($comparendo->getValorPagar() * (10 / 100));
                    $transferencia->setValorPolca(0);
                }

                $transferencia->setActivo(true);
                $transferencia->setFactura($factura);
                $transferencia->setComparendo($comparendo);

                $em->persist($transferencia);
                $em->flush();
            }
        }

        return true;
    }

    /**
     * Registra los trámites según la factura.
     */
    public function registerFacturaTramites($params, $factura)
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        if ($params->factura->idVehiculo) {
            $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->find( 
                $params->factura->idVehiculo
            );

            $factura->setPlaca($vehiculo->getPlaca()->getNumero());
            $em->flush();
        }

        foreach ($params->factura->tramites as $key => $tramitePrecioSelect) {
            $tramitePrecio = $em->getRepository('JHWEBFinancieroBundle:FroTrtePrecio')->find(
                $tramitePrecioSelect->id
            );

            //Inserta la relación de factura con trámites seleccionados
            $facturaTramite = new FroFacTramite();

            $facturaTramite->setFactura($factura);
            $facturaTramite->setPrecio($tramitePrecio);
            $facturaTramite->setRealizado(false);
            $facturaTramite->setActivo(true);

            $em->persist($facturaTramite);
            $em->flush();

            if($tramitePrecio->getTramite()->getId() == 2){   
                foreach ($params->propietarios as $key => $idPropietarioRetefuente) {
                    $retefuente = new FroFacRetefuente();
               
                    $retefuente->setVehiculo($vehiculo);

                    $propietario = $em->getRepository('JHWEBVehiculoBundle:VhloPropietario')->find( 
                        $idPropietarioRetefuente
                    );

                    $retefuente->setPropietario($propietario);

                    if (isset($params->idVehiculoValor)) {
                        $valorVehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloCfgValor')->find(
                            $params->idVehiculoValor
                        );
                        $retefuente->setValorVehiculo($valorVehiculo);
                    } else {
                        $valorVehiculo = new VhloCfgValor();

                        $valorVehiculo->setMarca($vehiculo->getLinea()->getMarca());
                        $valorVehiculo->setLinea($vehiculo->getLinea());
                        $valorVehiculo->setClase($vehiculo->getClase());
                        $valorVehiculo->setCilindraje($vehiculo->getCilindraje());
                        $valorVehiculo->setAnio($vehiculo->getModelo());
                        $valorVehiculo->setPesaje(0);
                        $valorVehiculo->setTonelaje(0);
                        $valorVehiculo->setValor($params->valorVehiculo);
                        $valorVehiculo->setActivo(true);
                        $em->persist($valorVehiculo);
                        $retefuente->setValorVehiculo($valorVehiculo);
                    }
                    $fechaCreacion = new \Datetime(date('Y-m-d'));
                    
                    $retefuente->setFactura($factura);
                    $retefuente->setFecha($fechaCreacion);
                    $retefuente->setRetencion($params->retencion);
                    $retefuente->setActivo(true);

                    $em->persist($retefuente);

                    $em->flush();
                }
            }
        }

        return true;
    }

    /**
     * Registra los datos individuales para factura de parqueadero.
     */
    public function registerFacturaParqueadero($params, $factura)
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        var_dump($params->factura);
        die();

        $inmovilizacion = $em->getRepository('JHWEBParqueaderoBundle:PqoInmovilizacion')->find(
            $params->factura->idInmovilizacion
        );
        $inmovilizacion->setFactura($factura);

        $em->flush();

        $minutos = $helpers->calculateTimeBetweenDates(
            new \Datetime(date($params->fechaSalida.' '.$params->horaSalida)), 
            new \Datetime(date('Y-m-d h:i:s'))
        );

        $facturaParqueadero = new FroFacParqueadero();

        $facturaParqueadero->setFactura($factura);
        $facturaParqueadero->setInmovilizacion($inmovilizacion);
        $facturaParqueadero->setValorGrua($params->valorGrua);
        $facturaParqueadero->setValorParqueadero($params->valorParqueadero);
        $facturaParqueadero->setValorTotal($params->valor);
        $facturaParqueadero->setActivo(true);

        $em->persist($facturaParqueadero);
        $em->flush();

        return true;
    }

    /**
     * Genera pdf de factura seleccionada.
     *
     * @Route("/{tipoRecaudo}/{id}/pdf", name="frofactura_pdf")
     * @Method("GET")
     */
    public function pdfAction(Request $request, $tipoRecaudo, $id)
    {
        switch ($tipoRecaudo) {
            case 1:
                $this->generatePdfTramites($id);
                break;
            
            case 2:
                $this->generatePdfInfracciones($id);
                break;

            case 3:
                $this->generatePdfAcuerdoPago($id);
                break;

            case 5:
                $this->generatePdfParqueadero($id);
                break;
        }
    }

    protected function generatePdfTramites($id){
        $em = $this->getDoctrine()->getManager();

        setlocale(LC_ALL,"es_ES");
        $fechaActual = strftime("%d de %B del %Y");

        $factura = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->find($id);

        $retenciones = $em->getRepository('JHWEBFinancieroBundle:FroFacRetefuente')->getTotalByFactura(
            $factura->getId()
        );

        $retenciones = (empty($retenciones['total']) ? 0 : $retenciones['total']);

        $tramites = $em->getRepository('JHWEBFinancieroBundle:FroFacTramite')->findBy(
            array(
                'factura' => $factura->getId()
            )
        );

        switch ($factura->getOrganismoTransito()->getId()) {
            case 31:
                //Buesaco
                $code = '7707273659692';
                break;
            
            case 100:
                //Guachucal
                $code = '7707273659142';
                break;

            case 110:
                //Imues
                $code = '7707273655779';
                break;

            case 126:
                //Unión
                $code = '7707273655083';
                break;

            case 180:
                //Pupiales
                $code = '7707273652075';
                break;

            case 199:
                //Samaniego
                $code = '7707273652693';
                break;

            case 208:
                //Sandoná
                $code = '7707273654109';
                break;

            case 229:
                //Tangua
                $code = '7707273652402';
                break;
            
            case 254:
                //Pasto
                $code = '7707273658299';
                break;
        }

        $barcode = new BarcodeGenerator();
        $barcodeText = '415'.$code.'8020'.$factura->getNumero().'3900'.str_pad($factura->getValorNeto(), 10, '0', STR_PAD_LEFT).'96'.$factura->getFechaVencimiento()->format('Ymd');
        $barcode->setText(
            $barcodeText
        );
        $barcode->setType(BarcodeGenerator::Gs1128);
        $barcode->setNoLengthLimit(true);
        $barcode->setAllowsUnknownIdentifier(true);
        $barcode->setScale(1);
        $barcode->setThickness(20);
        $barcode->setFontSize(10);

        $imgBarcode = $barcode->generate();
        
        $html = $this->renderView('@JHWEBFinanciero/Default/pdf.factura.tramites.html.twig', array(
            'fechaActual' => $fechaActual,
            'factura'=> $factura,
            'tramites'=> $tramites,
            'retenciones'=> $retenciones,
            'imgBarcode' => $imgBarcode,
        ));

        $this->get('app.pdf')->templateFactura($html, $factura);
    }

    protected function generatePdfInfracciones($id){
        $em = $this->getDoctrine()->getManager();

        setlocale(LC_ALL,"es_ES");
        $fechaActual = strftime("%d de %B del %Y");

        $factura = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->find($id);

        $comparendos = $em->getRepository('JHWEBFinancieroBundle:FroFacComparendo')->findBy(
            array(
                'factura' => $factura->getId()
            )
        );

        $infractorNombres = $comparendos[0]->getComparendo()->getInfractorNombres().' '.$comparendos[0]->getComparendo()->getInfractorApellidos();
        $infractorIdentificacion = $comparendos[0]->getComparendo()->getInfractorIdentificacion();

        switch ($factura->getOrganismoTransito()->getId()) {
            case 31:
                //Buesaco
                $code = '7707273656868';
                break;
            
            case 100:
                //Guachucal
                $code = '7707273656103';
                break;

            case 110:
                //Imues
                $code = '7707273652907';
                break;

            case 126:
                //Unión
                $code = '7707273653706';
                break;

            case 180:
                //Pupiales
                $code = '7707273652457';
                break;

            case 199:
                //Samaniego
                $code = '7707273652167';
                break;

            case 208:
                //Sandoná
                $code = '7707273654826';
                break;

            case 229:
                //Tangua
                $code = '7707273652839';
                break;

            case 254:
                //Pasto
                $code = '7707273658633';
                break;
        }

        $barcode = new BarcodeGenerator();
        $barcodeText = '(415)'.$code.'(8020)'.$factura->getNumero().'(3900)'.str_pad($factura->getValorNeto(), 10, '0', STR_PAD_LEFT).'(96)'.$factura->getFechaVencimiento()->format('Ymd');
        $barcode->setText(
            $barcodeText
        );
        $barcode->setType(BarcodeGenerator::Gs1128);
        $barcode->setNoLengthLimit(true);
        $barcode->setScale(1);
        $barcode->setThickness(20);
        $barcode->setFontSize(10);
        //$barcode->setAllowsUnknownIdentifier(true);
        $imgBarcode = $barcode->generate();

        $html = $this->renderView('@JHWEBFinanciero/Default/pdf.factura.infracciones.html.twig', array(
            'fechaActual' => $fechaActual,
            'factura'=> $factura,
            'comparendos'=> $comparendos,
            'infractor'=> array(
                'nombres' => $infractorNombres,
                'identificacion' => $infractorIdentificacion,
            ),
            'imgBarcode' => $imgBarcode,
        ));

        $this->get('app.pdf')->templateFactura($html, $factura);
    }

    protected function generatePdfAcuerdoPago($id){
        $em = $this->getDoctrine()->getManager();

        setlocale(LC_ALL,"es_ES");
        $fechaActual = strftime("%d de %B del %Y");

        $factura = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->find($id);

        if ($factura) {
            $fechaCreacion = new \Datetime(date('Y-m-d'));

            $factura->setFechaCreacion($fechaCreacion);
            $factura->setFechaVencimiento($fechaCreacion->modify('+1 days'));
            $factura->setHora(new \Datetime(date('h:i:s A')));

            $em->flush();
        }

        $amortizacion = $em->getRepository('JHWEBFinancieroBundle:FroFacComparendo')->findOneByFactura($factura->getId());

        $barcode = new BarcodeGenerator();
        $barcodeText = '(770)7709998017603(8020)02075620756(8020)'.$factura->getNumero().'(3900)'.str_pad($factura->getValorNeto(), 10, '0', STR_PAD_LEFT).'(96)'.$factura->getFechaVencimiento()->format('Ymd');
        $barcode->setText(
            $barcodeText
        );
        $barcode->setType(BarcodeGenerator::Gs1128);
        $barcode->setNoLengthLimit(true);
        $barcode->setScale(1);
        $barcode->setThickness(20);
        $barcode->setFontSize(10);
        //$barcode->setAllowsUnknownIdentifier(true);
        $imgBarcode = $barcode->generate();

        $img_base64_encoded = 'data:image/png;base64,'.$imgBarcode;
        $imageContent = file_get_contents($img_base64_encoded);
        $path = tempnam(sys_get_temp_dir(), 'prefix');

        file_put_contents ($path, $imageContent);

        $html = $this->renderView('@JHWEBFinanciero/Default/pdf.factura.acuerdopago.html.twig', array(
            'fechaActual' => $fechaActual,
            'factura'=>$factura,
            'amortizacion'=>$amortizacion,
            'imgBarcode' => $imgBarcode,
        ));

        $this->get('app.pdf')->templateFactura($html, $factura);
    }

    protected function generatePdfParqueadero($id){
        $em = $this->getDoctrine()->getManager();

        setlocale(LC_ALL,"es_ES");
        $fechaActual = strftime("%d de %B del %Y");

        $factura = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->find($id);

        $inmovilizacion = $em->getRepository('JHWEBParqueaderoBundle:PqoInmovilizacion')->findOneBy(
            array(
                'factura' => $factura->getId()
            )
        );
        
        $barcode = new BarcodeGenerator();
        $barcodeText = '(770)7709998017603(8020)02075620756(8020)'.$factura->getNumero().'(3900)'.str_pad($factura->getValorNeto(), 10, '0', STR_PAD_LEFT).'(96)'.$factura->getFechaVencimiento()->format('Ymd');
        $barcode->setText(
            $barcodeText
        );
        $barcode->setType(BarcodeGenerator::Gs1128);
        $barcode->setNoLengthLimit(true);
        $barcode->setScale(1);
        $barcode->setThickness(20);
        $barcode->setFontSize(10);
        //$barcode->setAllowsUnknownIdentifier(true);
        $imgBarcode = $barcode->generate();

        $img_base64_encoded = 'data:image/png;base64,'.$imgBarcode;
        $imageContent = file_get_contents($img_base64_encoded);
        $path = tempnam(sys_get_temp_dir(), 'prefix');

        file_put_contents ($path, $imageContent);

        $html = $this->renderView('@JHWEBFinanciero/Default/pdf.factura.parqueadero.html.twig', array(
            'fechaActual' => $fechaActual,
            'factura'=> $factura,
            'inmovilizacion'=> $inmovilizacion,
            'imgBarcode' => $imgBarcode,
        ));

        $this->get('app.pdf')->templateFactura($html, $factura);
    }

    /**
     * Creates a new vhloTpConvenio entity.
     *
     * @Route("/last/vehiculo", name="frofactura_last_by_vehiculo")
     * @Method({"GET", "POST"})
     */
    public function searchLastByVehiculoAction(Request $request)
    {        
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        
        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            
            $em = $this->getDoctrine()->getManager();

            //valida si la factura que se va a realizar es MATRICULA INICIAL o RADICADO DE CUENTA
            $tramiteFactura = $em->getRepository('JHWEBFinancieroBundle:FroFacTramite')->validateByFactura($params->idFactura);

            if(!$tramiteFactura) {
                //Busca el ultimo tramite realizado para buscar los datos del archivo del vehiculo
                $tramiteSolicitud = $em->getRepository('JHWEBFinancieroBundle:FroTrteSolicitud')->getLastByVehiculo($params->idVehiculo);

                if($tramiteSolicitud) {
                    $facturaArchivo = $em->getRepository('JHWEBFinancieroBundle:FroFacArchivo')->findOneBy(
                        array(
                            'factura' => $tramiteSolicitud['idFactura']
                        )
                    );
                }
            }
            
            if($tramiteFactura || $facturaArchivo) {
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado con éxito",
                    'data' => !empty($facturaArchivo) ? $facturaArchivo: null,
                    
                );
            }
            else {
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No se encontraton los datos de archivo", 
                );
            }
        } else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida", 
            );
        }    
        return $helpers->json($response);
    }
}
