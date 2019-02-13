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

                $fecha = new \Datetime($params->acuerdoPago->fecha);
                $consecutivo = $em->getRepository('JHWEBFinancieroBundle:FroAcuerdoPago')->findMaximo(
                    $fecha->format('Y')
                );
                $consecutivo = (empty($consecutivo['maximo']) ? 1 : $consecutivo['maximo']+=1);
                $acuerdoPago->setConsecutivo($consecutivo);
                $acuerdoPago->setNumero($fecha->format('Y').str_pad($consecutivo, 3, '0', STR_PAD_LEFT));
                $acuerdoPago->setFecha($fecha);
                $acuerdoPago->setNumeroCuotas($params->acuerdoPago->numeroCuotas);
                $acuerdoPago->setValorBruto($params->acuerdoPago->valorCapital);
                $acuerdoPago->setValorMora(0);
                $acuerdoPago->setValorNeto($params->acuerdoPago->valorCapital);
                
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
                $acuerdoPago->setValorCuotaInicial($params->acuerdoPago->valorCuotaInicial);

                $em->persist($acuerdoPago);
                $em->flush();

                if ($params->acuerdoPago->comparendos) {
                    foreach ($params->acuerdoPago->comparendos as $key => $idComparendo) {
                        $comparendo = $em->getRepository('AppBundle:Comparendo')->find(
                            $idComparendo
                        );
                        $comparendo->setAcuerdoPago($acuerdoPago);

                        $estado = $em->getRepository('AppBundle:CfgComparendoEstado')->find(
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
                        
                        $fecha = new \Datetime($cuota->fechaMensual);
                        $amortizacion->setValorBruto($cuota->valorCapital);
                        $amortizacion->setValorMora(0);
                        $amortizacion->setValorNeto($cuota->valorCapital);
                        $amortizacion->setFechaLimite($fecha);
                        $amortizacion->setNumeroCuota($key + 1);
                        $amortizacion->setPagada(false);

                        $amortizacion->setAcuerdoPago($acuerdoPago);

                        $em->persist($amortizacion);
                        $em->flush();
                    }
                }

                //Registra trazabilidad de acuerdo de pago
                $estado = $em->getRepository('AppBundle:CfgComparendoEstado')->find(4);
                $helpers->generateTrazabilidad($comparendo, $estado);

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro creado con exito",
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
     * @Route("/{id}/show", name="frocuerdopago_show")
     * @Method("GET")
     */
    public function showAction(FroAcuerdoPago $froAcuerdoPago)
    {
        $deleteForm = $this->createDeleteForm($froAcuerdoPago);

        return $this->render('frocuerdopago/show.html.twig', array(
            'froAcuerdoPago' => $froAcuerdoPago,
            'delete_form' => $deleteForm->createView(),
        ));
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
                $comparendo = $em->getRepository('AppBundle:Comparendo')->find(
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

            $fecha = strtotime($params->fecha);
            $fechaFinal = date("d/m/Y", strtotime("+".$params->numeroCuotas." month", $fecha));
            
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Calculo generado',
                'data' => $fechaFinal
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

            $fecha = strtotime($params->fecha);

            // var_dump($params->valorCapital);
            // die();

            $subtotal = $params->valorCapital - $params->valorCuotaInicial;
            $cuotaMensual = $subtotal / $params->numeroCuotas;
            $interes = $em->getRepository('JHWEBContravencionalBundle:CvCfgInteres')->find(
                $params->idInteres
            );

            $totalPagar = 0;

            for ($i=0; $i < $params->numeroCuotas ; $i++) { 
                $fechaMensual = date("Y-m-d", strtotime("+".$i." month", $fecha));
                $totalPagar += $cuotaMensual;
                $cuotas[] = array(
                    'valorCapital' => $cuotaMensual,
                    'fechaMensual' => $fechaMensual
                );
            }
            
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Calculo generado',
                'data' => array (
                    'cuotas'=> $cuotas,
                    'totalPagar'=> $totalPagar,
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
}
