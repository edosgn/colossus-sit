<?php

namespace JHWEB\FinancieroBundle\Controller;

use JHWEB\FinancieroBundle\Entity\FroFactura;
use JHWEB\FinancieroBundle\Entity\FroFacComparendo;
use JHWEB\FinancieroBundle\Entity\FroFacTramite;
use JHWEB\FinancieroBundle\Entity\FroFacRetefuente;
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
            /* $fechaPago = new \Datetime($params->factura->fechaPago);  */

            $factura->setFechaCreacion($fechaCreacion);
            $factura->setFechaVencimiento($fechaVencimiento);
            //pendiente para validación con banco
            /* $factura->setFechaPago($fechaPago); */
            $factura->setHora(new \Datetime(date('h:i:s A')));
            $factura->setValorBruto($params->factura->valor);
            $factura->setValorMora($params->factura->interes);
            $factura->setValorNeto($params->factura->valor + $params->factura->interes);
            //$factura->setEstado('EMITIDA');
            $factura->setEstado('PAGADA');
            $factura->setActivo(true);

            $consecutivo = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->getMaximo(date('Y'));
           
            $consecutivo = (empty($consecutivo['maximo']) ? 1 : $consecutivo['maximo']+=1);
            $factura->setConsecutivo($consecutivo);
            
            $factura->setNumero(
                $fechaCreacion->format('Y').$fechaCreacion->format('m').str_pad($consecutivo, 3, '0', STR_PAD_LEFT)
            );
            
            if ($params->factura->idOrganismoTransito) {
                $organismoTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find(
                    $params->factura->idOrganismoTransito
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
                $this->registerComparendos($params->factura->comparendos, $factura);
            }elseif (isset($params->factura->tramites)) {
                $this->registerTramites($params, $factura);
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
            $json = $request->get("json",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $factura = $em->getRepository('JHWEBFinancieroBundle:froFactura')->find(
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
     * busca vehiculos por id.
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

            if ($froFactura) {
                if ($froFactura->getEstado() != 'FINALIZADA') {
                    if ($froFactura->getEstado() == 'PAGADA' || $froFactura->getEstado() == 'PENDIENTE DOCUMENTACION') {
                        $response = array(
                            'status' => 'success',
                            'code' => 200,
                            'message' => 'Factura pagada.', 
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
                    $diasHabiles = $helpers->getDiasHabiles($comparendo->getFecha());

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

                                $diasCalendario = $helpers->getDiasCalendario($trazabilidad->getFecha());

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
    public function registerComparendos($params, $factura)
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
                //Actualiza el estado del curso
                if ($comparendoSelect->curso) {
                    $comparendo->setCurso(true);
                }else{
                    $comparendo->setCurso(false);
                }
                
                $diasHabiles = $helpers->getDiasHabiles($comparendo->getFecha());

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

                            $diasCalendario = $helpers->getDiasCalendario($trazabilidad->getFecha());

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
            }
        }

        return true;
    }

    /**
     * Registra los trámites según la factura.
     */
    public function registerTramites($params, $factura)
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

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

                    $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->find( 
                        $params->factura->idVehiculo
                    );
               
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
                $this->generatePdfAmortizacion($id);
                break;
        }
    }

    protected function generatePdfTramites($id){
        $em = $this->getDoctrine()->getManager();

        setlocale(LC_ALL,"es_ES");
        $fechaActual = strftime("%d de %B del %Y");

        $factura = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->find($id);

        $tramites = $em->getRepository('JHWEBFinancieroBundle:FroFacTramite')->findBy(
            array(
                'factura' => $factura->getId()
            )
        );

        $barcode = new BarcodeGenerator();
        $barcode->setText(
            '(415)7709998017603(8020)02075620756(8020)'.$factura->getNumero().'(3900)'.$factura->getValorNeto().'(96)'.$factura->getFechaVencimiento()->format('Ymd')
        );
        $barcode->setNoLengthLimit(true);
        $barcode->setAllowsUnknownIdentifier(true);
        $barcode->setType(BarcodeGenerator::Gs1128);
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(7);
        $code = $barcode->generate();

        //$imgBarcode = \base64_decode($imgBarcode);
        $imgBarcode = $code;

        $html = $this->renderView('@JHWEBFinanciero/Default/pdf.factura.tramites.html.twig', array(
            'fechaActual' => $fechaActual,
            'factura'=> $factura,
            'tramites'=> $tramites,
            'imgBarcode' => $imgBarcode
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

        //.$factura->getFechaVencimiento()->format('Ymd')

        $barcode = new BarcodeGenerator();
        $barcode->setText(
            '(415)7709998017603(8020)02075620756(8020)'.$factura->getNumero().'(3900)'.$factura->getValorNeto().'(96)'
        );
        $barcode->setNoLengthLimit(true);
        $barcode->setAllowsUnknownIdentifier(true);
        $barcode->setType(BarcodeGenerator::Gs1128);
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(7);
        $code = $barcode->generate();

        //$imgBarcode = \base64_decode($code);
        $imgBarcode = $code;

        $html = $this->renderView('@JHWEBFinanciero/Default/pdf.factura.infracciones.html.twig', array(
            'fechaActual' => $fechaActual,
            'factura'=> $factura,
            'comparendos'=> $comparendos,
            'infractor'=> array(
                'nombres' => $infractorNombres,
                'identificacion' => $infractorIdentificacion,
            ),
            'imgBarcode' => $imgBarcode
        ));

        $this->get('app.pdf')->templateFactura($html, $factura);
    }

    protected function generatePdfAmortizacion($idFactura){
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
        $barcode->setText(
            '(415)7709998017603(8020)02075620756(8020)'.$factura->getNumero().'(3900)'.$factura->getValorNeto().'(96)'.$factura->getFechaVencimiento()->format('Ymd')
        );
        $barcode->setNoLengthLimit(true);
        $barcode->setAllowsUnknownIdentifier(true);
        $barcode->setType(BarcodeGenerator::Gs1128);
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(7);
        $code = $barcode->generate();

        //$imgBarcode = \base64_decode($code);
        $imgBarcode = $code;

        $html = $this->renderView('@JHWEBFinanciero/Default/pdf.factura.infracciones.html.twig', array(
            'fechaActual' => $fechaActual,
            'factura'=>$factura,
            'comparendos'=>$comparendos,
            'imgBarcode' => $imgBarcode
        ));

        $this->get('app.pdf.factura')->templateFactura($html, $factura);
    }
}
