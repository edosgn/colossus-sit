<?php

namespace JHWEB\FinancieroBundle\Controller;

use JHWEB\FinancieroBundle\Entity\FroFactura;
use JHWEB\FinancieroBundle\Entity\FroFacturaComparendo;
use JHWEB\ContravencionalBundle\Entity\CvCdoTrazabilidad;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;

/**
 * FrofroFactura controller.
 *
 * @Route("froFactura")
 */
class FroFacturaController extends Controller
{
    /**
     * Lists all cvCfgIntere entities.
     *
     * @Route("/", name="froFactura_index")
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
     * @Route("/new", name="froFactura_new")
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

            $em = $this->getDoctrine()->getManager();
           
            $factura = new FroFactura();

            $fechaCreacion = new \Datetime(date('Y-m-d'));

            $factura->setFechaCreacion($fechaCreacion);
            $factura->setFechaVencimiento(new \Datetime(date('Y-m-d')));
            $factura->setHora(new \Datetime(date('h:i:s A')));
            $factura->setValor($params->valor);
            $factura->setEstado('EMITIDA');
            $factura->setActivo(true);

            $consecutivo = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->getMaximo(date('Y'));
           
            $consecutivo = (empty($consecutivo['maximo']) ? 1 : $consecutivo['maximo']+=1);
            $factura->setConsecutivo($consecutivo);
            
            $factura->setNumero(
                '770'.str_pad($consecutivo, 3, '0', STR_PAD_LEFT).$fechaCreacion->format('Y')
            );
            
            if ($params->idSedeOperativa) {
                $sedeOperativa = $em->getRepository('AppBundle:SedeOperativa')->find(
                    $params->idSedeOperativa
                );
                $factura->setSedeOperativa($sedeOperativa);
            }

            if ($params->idTipoRecaudo) {
                $tipoRecaudo = $em->getRepository('JHWEBFinancieroBundle:FroCfgTipoRecaudo')->find(
                    $params->idTipoRecaudo
                );
                $factura->setTipoRecaudo($tipoRecaudo);
            }

            $em->persist($factura);
            $em->flush();

            $this->calculateValueUpdate($params->comparendos);

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con exito",
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
     * @Route("/search/numero", name="froFactura_search_numero")
     * @Method({"GET", "POST"})
     */
    public function searchByNumero(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);


        if ($authCheck == true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $froFactura = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->findOneBy(
                array('numero' => $params->numeroFactura)
            );

            if ($froFactura!=null) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Factura encontrada", 
                    'data'=> $froFactura,
            );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Factura no encontrada", 
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
     * @Route("/calculate/value", name="froFactura_calculate_value")
     * @Method("POST")
     */
    public function calculateValueByComparendosAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $totalPagar = 0;
            $totalInteres = 0;

            foreach ($params as $key => $comparendoSelect) {
                $comparendo = $em->getRepository('AppBundle:Comparendo')->find(
                    $comparendoSelect->id
                );

                $interes = 0;

                if ($comparendo) {
                    //Actualiza el estado del curso
                    if ($comparendoSelect->curso) {
                        $comparendo->setCurso(true);
                    }else{
                        $comparendo->setCurso(false);
                    }
                    
                    $diasHabiles = $helpers->getDiasHabiles($comparendo->getFecha());

                    if ($diasHabiles < 6) {
                        $comparendo->setValorPagar($comparendo->getValorInfraccion() / 2);
                        $comparendo->setPorcentajeDescuento(50);
                    }elseif($diasHabiles > 5 && $diasHabiles < 21){
                        $comparendo->setValorPagar(
                            $comparendo->getValorInfraccion() - ($comparendo->getValorInfraccion() * 0.25)
                        );
                        $comparendo->setPorcentajeDescuento(25);
                    }else{
                        $comparendo->setPorcentajeDescuento(0);

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
            
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Calculo generado',
                'data' => array(
                    'totalPagar' => $totalPagar,
                    'totalInteres'=> $totalInteres
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
     * Calcula el valor según los comparendos seleccionados y actualiza los valores.
     */
    public function calculateValueUpdate($params)
    {
        $em = $this->getDoctrine()->getManager();

        $totalPagar = 0;
        $totalInteres = 0;

        foreach ($params as $key => $comparendoSelect) {
            $comparendo = $em->getRepository('AppBundle:Comparendo')->find(
                $comparendoSelect->id
            );

            //Inserta la relación de factura con comparendos seleccionados
            $facturaComparendo = new FroFacturaComparendo();

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

                if ($diasHabiles < 6) {
                    $comparendo->setValorPagar($comparendo->getValorInfraccion() / 2);
                    $comparendo->setPorcentajeDescuento(50);
                }elseif($diasHabiles > 5 && $diasHabiles < 21){
                    $comparendo->setValorPagar(
                        $comparendo->getValorInfraccion() - ($comparendo->getValorInfraccion() * 0.25)
                    );
                    $comparendo->setPorcentajeDescuento(25);
                }else{
                    $comparendo->setPorcentajeDescuento(0);

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
     * Genera pdf de factura seleccionada.
     *
     * @Route("/{id}/pdf", name="froFactura_pdf")
     * @Method({"GET", "POST"})
     */
    public function pdfAction(Request $request, $id)
    {
        setlocale(LC_ALL,"es_ES");
        $fechaActual = strftime("%d de %B del %Y");

        $em = $this->getDoctrine()->getManager();

        $factura = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->find($id);

        $comparendos = $em->getRepository('JHWEBFinancieroBundle:FroFacturaComparendo')->findBy(
            array(
                'factura' => $factura->getId()
            )
        );

        $barcode = new BarcodeGenerator();
        $barcode->setText($factura->getNumero());
        $barcode->setNoLengthLimit(true);
        $barcode->setAllowsUnknownIdentifier(true);
        $barcode->setType(BarcodeGenerator::Gs1128);
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(7);
        $code = $barcode->generate();

        //$imgBarcode = \base64_decode($code);
        $imgBarcode = $code;

        $html = $this->renderView('@JHWEBFinanciero/Default/pdf.factura.html.twig', array(
            'fechaActual' => $fechaActual,
            'factura'=>$factura,
            'comparendos'=>$comparendos,
            'imgBarcode' => $imgBarcode
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
        $pdf->SetTitle('Factura No.'.$factura->getNumero());
        $pdf->SetSubject('SUBDETRA');
        $pdf->SetKeywords('Factura, Infracciones');
        $pdf->setFontSubsetting(true);

        $pdf->SetFont('helvetica', '', 11, '', true);
        $pdf->SetMargins('2', '25', '2');
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->AddPage();

        $mi = $ms = $md = 10;

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

        //$pdf->Image('@'.$imgBarcode, $mi + 4, $ms + 242, 90, 18, 'png');

        $pdf->Output("example.pdf", 'I');
        die();
    }
}
