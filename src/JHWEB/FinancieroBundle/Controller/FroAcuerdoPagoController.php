<?php

namespace JHWEB\FinancieroBundle\Controller;

use JHWEB\FinancieroBundle\Entity\FroAcuerdoPago;
use JHWEB\FinancieroBundle\Entity\FroAmortizacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Froacuerdopago controller.
 *
 * @Route("froacuerdopago")
 */
class FroAcuerdoPagoController extends Controller
{
    /**
     * Creates a new froAcuerdoPago entity.
     *
     * @Route("/new", name="frocuerdopago_new")
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

            $porcentajeInicial = $em->getRepository('JHWEBContravencionalBundle:CvCfgPorcentajeInicial')->findOneByActivo(
                true
            );

            if ($params->acuerdoPago->porcentajeInicial >= $porcentajeInicial->getValor()) {
                $acuerdoPago = new FroAcuerdoPago();

                $fecha = new \Datetime(date('Y-m-d'));
                $consecutivo = $em->getRepository('JHWEBFinancieroBundle:FroAcuerdoPago')->findMaximo(
                    $fecha->format('Y')
                );
                $consecutivo = (empty($consecutivo['maximo']) ? 1 : $consecutivo['maximo']+=1);
                $acuerdoPago->setConsecutivo($consecutivo);
                $acuerdoPago->setNumero($fecha->format('Y').str_pad($consecutivo, 3, '0', STR_PAD_LEFT));
                $acuerdoPago->setFecha($fecha);
                $acuerdoPago->setNumeroCuotas($params->acuerdoPago->numeroCuotas);
                $acuerdoPago->setValorBruto($params->acuerdoPago->valorBruto);
                $acuerdoPago->setValorMora($params->acuerdoPago->valorMora);
                $acuerdoPago->setValorNeto($params->acuerdoPago->valorNeto);
                $acuerdoPago->setDiasMoraTotal($params->acuerdoPago->diasMoraTotal);
                $fechaFinal = $helpers->convertDateTime($params->acuerdoPago->fechaFinal);
                $acuerdoPago->setFechaFinal($fechaFinal);
                /*$acuerdoPago->setFechaFinal(
                    new \Datetime($params->acuerdoPago->fechaFinal)
                );*/
                
                if ($params->acuerdoPago->porcentajeInicial) {
                    $acuerdoPago->setPorcentajeInicial(
                        $params->acuerdoPago->porcentajeInicial
                    );
                }

                if ($params->acuerdoPago->idInteres) {
                    $interes = $em->getRepository('JHWEBContravencionalBundle:CvCfgInteres')->find(
                        $params->acuerdoPago->idInteres
                    );
                    $acuerdoPago->setInteres($interes);
                }
                
                $acuerdoPago->setActivo(true);
                $acuerdoPago->setValorCuotaInicial(
                    $params->acuerdoPago->valorCuotaInicial
                );

                $em->persist($acuerdoPago);
                $em->flush();

                if ($params->acuerdoPago->comparendos) {
                    foreach ($params->acuerdoPago->comparendos as $key => $idComparendo) {
                        $comparendo = $em->getRepository('JHWEBContravencionalBundle:CvCdoComparendo')->find(
                            $idComparendo
                        );
                        $comparendo->setAcuerdoPago($acuerdoPago);

                        $estado = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->find(
                            4
                        );
                        $comparendo->setEstado($estado);
                        $em->flush();
                    }
                }

                if ($params->cuotas) {
                    $amortizacion = new FroAmortizacion();
                        
                    $fecha = new \Datetime(date('Y-m-d'));
                    $amortizacion->setValorBruto($acuerdoPago->getValorCuotaInicial());
                    $amortizacion->setValorMora(0);
                    $amortizacion->setValorNeto($acuerdoPago->getValorCuotaInicial());
                    $amortizacion->setFechaLimite($fecha);
                    $amortizacion->setNumeroCuota(0);
                    $amortizacion->setPagada(false);

                    $amortizacion->setAcuerdoPago($acuerdoPago);

                    $em->persist($amortizacion);
                    $em->flush();
                    
                    foreach ($params->cuotas as $key => $cuota) {
                        $amortizacion = new FroAmortizacion();
                        
                        $fecha = $helpers->convertDateTime($cuota->fechaMensual);

                        $amortizacion->setValorBruto($cuota->valorBruto);
                        $amortizacion->setValorMora($cuota->valorMora);
                        $amortizacion->setValorNeto($cuota->valorNeto);
                        $amortizacion->setFechaLimite($fecha);
                        $amortizacion->setNumeroCuota($key + 1);
                        $amortizacion->setPagada(false);

                        $amortizacion->setAcuerdoPago($acuerdoPago);

                        $em->persist($amortizacion);
                        $em->flush();
                    }
                }

                //Registra trazabilidad de acuerdo de pago
                $estado = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->find(4);
                $helpers->generateTrazabilidad($comparendo, $estado);

                $amortizaciones = $em->getRepository('JHWEBFinancieroBundle:FroAmortizacion')->findByAcuerdoPago($acuerdoPago->getId());

                $trazabilidad = $em->getRepository('JHWEBContravencionalBundle:CvCdoTrazabilidad')->findOneByEstado(4);

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Registro creado con exito.',
                    'data' => array(
                        'acuerdoPago' => $acuerdoPago,
                        'amortizaciones' => $amortizaciones,
                        'trazabilidad' => $trazabilidad,
                    )
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El porcentaje inicial no puede ser inferior al ".$porcentajeInicial->getValor()."%", 
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
     * Finds and displays a froAcuerdoPago entity.
     *
     * @Route("/show", name="frocuerdopago_show")
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

            $acuerdoPago = $em->getRepository('JHWEBFinancieroBundle:FroAcuerdoPago')->find(
                $params->id
            );

            if ($acuerdoPago) {

                $amortizaciones = $em->getRepository('JHWEBFinancieroBundle:FroAmortizacion')->findByAcuerdoPago(
                    $acuerdoPago->getId()
                );

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Acuerdo de pago encontrado", 
                    'data' => array(
                        'acuerdoPago' => $acuerdoPago,
                        'amortizaciones' => $amortizaciones,
                    )
            );
            }else{
                 $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No existen acuerdos de pago para esos filtros de búsqueda", 
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
     * Displays a form to edit an existing froAcuerdoPago entity.
     *
     * @Route("/{id}/edit", name="frocuerdopago_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FroAcuerdoPago $froAcuerdoPago)
    {
        $deleteForm = $this->createDeleteForm($froAcuerdoPago);
        $editForm = $this->createForm('JHWEB\ContravencionalBundle\Form\FroAcuerdoPagoType', $froAcuerdoPago);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('frocuerdopago_edit', array('id' => $froAcuerdoPago->getId()));
        }

        return $this->render('frocuerdopago/edit.html.twig', array(
            'froAcuerdoPago' => $froAcuerdoPago,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a froAcuerdoPago entity.
     *
     * @Route("/{id}/delete", name="frocuerdopago_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FroAcuerdoPago $froAcuerdoPago)
    {
        $form = $this->createDeleteForm($froAcuerdoPago);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($froAcuerdoPago);
            $em->flush();
        }

        return $this->redirectToRoute('frocuerdopago_index');
    }

    /**
     * Creates a form to delete a froAcuerdoPago entity.
     *
     * @param FroAcuerdoPago $froAcuerdoPago The froAcuerdoPago entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FroAcuerdoPago $froAcuerdoPago)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('frocuerdopago_delete', array('id' => $froAcuerdoPago->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Calcula el valor según los comparendos seleecionados.
     *
     * @Route("/calculate/value", name="frocuerdopago_calculate_value")
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

            $valorTotal = 0;

            foreach ($params->comparendos as $key => $idComparendo) {
                $comparendo = $em->getRepository('JHWEBContravencionalBundle:CvCdoComparendo')->find(
                    $idComparendo
                );

                if ($comparendo) {
                    $valorTotal += $comparendo->getValorInfraccion();
                    /*if ($comparendo->getValorAdicional()) {
                        $valorTotal += $comparendo->getValorAdicional();
                    }*/
                }
            }
            
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Calculo generado',
                'data' => $valorTotal
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
     * Busca comparendo por número.
     *
     * @Route("/calculate/date/end", name="frocuerdopago_calculate_date_end")
     * @Method("POST")
     */
    public function calculateDateEndAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $porcentajeInicial = $em->getRepository('JHWEBContravencionalBundle:CvCfgPorcentajeInicial')->findOneByActivo(
                true
            );

            if ($params->porcentajeInicial >= $porcentajeInicial->getValor()) {
                $fecha = strtotime(date('Y-m-d'));

                $fechaFinal = date('Y-m-d', strtotime("+".$params->numeroCuotas." month", $fecha));

                $fechaFinal = $helpers->getFechaVencimiento(
                    new \Datetime($fechaFinal),
                    5
                );

                $diasMoraTotal = $helpers->getDiasCalendarioInverse(
                    $fechaFinal->format('d/m/Y')
                );
                
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Calculo generado',
                    'data' => array(
                        'fechaFinal' => $fechaFinal->format('d/m/Y'),
                        'diasMoraTotal' => $diasMoraTotal
                    )
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'El porcentaje inicial no puede ser inferior al '.$porcentajeInicial->getValor().'%',
                );
            }
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
     * Busca comparendo por número.
     *
     * @Route("/calculate/dues", name="frocuerdopago_calculate_dues")
     * @Method("POST")
     */
    public function calculateDuesAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $fecha = strtotime(date('Y-m-d'));

            $subtotal = $params->valorNeto - $params->valorCuotaInicial;
            $subtotalMora = $subtotal * (25 / 100);
            $subtotalBruto = $subtotal * (75 / 100);
            $cuotaMora = $subtotalMora / $params->numeroCuotas;
            $cuotaBruto = $subtotalBruto / $params->numeroCuotas;

            $totalPagar = 0;

            for ($i=0; $i < $params->numeroCuotas ; $i++) { 
                $mes = $i + 1;
                $fechaMensual = date("Y-m-d", strtotime("+".$mes." month", $fecha));

                $fechaMensual = $helpers->getFechaVencimiento(
                    new \Datetime($fechaMensual),
                    5
                );

                $totalPagar += $cuotaMora + $cuotaBruto;
                $cuotas[] = array(
                    'valorMora' => number_format(round($cuotaMora), 0, ',', '.'),
                    'valorBruto' => number_format(round($cuotaBruto), 0, ',', '.'),
                    'valorNeto' => number_format(round($cuotaMora + $cuotaBruto), 0, ',', '.'),
                    'fechaMensual' => $fechaMensual->format('d/m/Y')
                );
            }
            
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Preliquidación generada.',
                'data' => array (
                    'cuotas'=> $cuotas,
                    'totalPagar'=> number_format(round($totalPagar), 0, ',', '.')
                ),
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
     * Busca acuerdos de pago por parametros (identificacion, No. acuerdo pago o No. comparendo).
     *
     * @Route("/search/filtros", name="froacuerdopago_search_filtros")
     * @Method({"GET","POST"})
     */
    public function searchByFiltros(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $acuerdosPago = $em->getRepository('JHWEBFinancieroBundle:FroAcuerdoPago')->getByFilter(
                $params
            );

            if ($acuerdosPago) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($acuerdosPago)." acuerdosPago encontrados", 
                    'data' => $acuerdosPago,
            );
            }else{
                 $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No existen acuerdos de pago para esos filtros de búsqueda", 
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
