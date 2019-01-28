<?php

namespace JHWEB\ContravencionalBundle\Controller;

use JHWEB\ContravencionalBundle\Entity\CvAcuerdoPago;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Cvacuerdopago controller.
 *
 * @Route("cvacuerdopago")
 */
class CvAcuerdoPagoController extends Controller
{
    /**
     * Lists all cvAcuerdoPago entities.
     *
     * @Route("/", name="cvacuerdopago_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cvAcuerdoPagos = $em->getRepository('JHWEBContravencionalBundle:CvAcuerdoPago')->findAll();

        return $this->render('cvacuerdopago/index.html.twig', array(
            'cvAcuerdoPagos' => $cvAcuerdoPagos,
        ));
    }

    /**
     * Creates a new cvAcuerdoPago entity.
     *
     * @Route("/new", name="cvacuerdopago_new")
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
            
            $acuerdoPago = new CvAcuerdoPago();

            $fecha = new \Datetime($params->fecha);
            $consecutivo = $em->getRepository('JHWEBContravencionalBundle:CvAcuerdoPago')->findMaximo(
                $fecha->format('Y')
            );
            $consecutivo = (empty($consecutivo['maximo']) ? 1 : $consecutivo['maximo']+=1);
            $acuerdoPago->setConsecutivo($consecutivo);
            $acuerdoPago->setNumero($fecha->format('Y').str_pad($consecutivo, 3, '0', STR_PAD_LEFT));

            $acuerdoPago->setFecha($fecha);
            $acuerdoPago->setNumeroCuotas($params->numeroCuotas);
            $acuerdoPago->setValor($params->valorCapital);
            $acuerdoPago->setCuotasPagadas(0);
            
            if ($params->idPorcentajeInicial) {
                $porcentajeInicial = $em->getRepository('JHWEBContravencionalBundle:CvCfgPorcentajeInicial')->find(
                    $params->idPorcentajeInicial
                );
                $acuerdoPago->setPorcentajeInicial($porcentajeInicial);
            }

            if ($params->idInteres) {
                $interes = $em->getRepository('JHWEBContravencionalBundle:CvCfgInteres')->find(
                    $params->idInteres
                );
                $acuerdoPago->setInteres($interes);
            }
            
            $acuerdoPago->setActivo(true);

            $em->persist($acuerdoPago);
            $em->flush();

            if ($params->comparendos) {
                foreach ($params->comparendos as $key => $idComparendo) {
                    $comparendo = $em->getRepository('AppBundleBundle:Comparendo')->find(
                        $idComparendo
                    );
                    $comparendo->setAcuerdoPago($acuerdoPago);

                    $estado = $em->getRepository('AppBundleBundle:CfgComparendoEstado')->find(
                        4
                    );
                    $comparendo->setEstado($estado);
                    $em->flush();
                }
            }

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con exito",
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

    /**
     * Finds and displays a cvAcuerdoPago entity.
     *
     * @Route("/{id}/show", name="cvacuerdopago_show")
     * @Method("GET")
     */
    public function showAction(CvAcuerdoPago $cvAcuerdoPago)
    {
        $deleteForm = $this->createDeleteForm($cvAcuerdoPago);

        return $this->render('cvacuerdopago/show.html.twig', array(
            'cvAcuerdoPago' => $cvAcuerdoPago,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cvAcuerdoPago entity.
     *
     * @Route("/{id}/edit", name="cvacuerdopago_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CvAcuerdoPago $cvAcuerdoPago)
    {
        $deleteForm = $this->createDeleteForm($cvAcuerdoPago);
        $editForm = $this->createForm('JHWEB\ContravencionalBundle\Form\CvAcuerdoPagoType', $cvAcuerdoPago);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cvacuerdopago_edit', array('id' => $cvAcuerdoPago->getId()));
        }

        return $this->render('cvacuerdopago/edit.html.twig', array(
            'cvAcuerdoPago' => $cvAcuerdoPago,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cvAcuerdoPago entity.
     *
     * @Route("/{id}/delete", name="cvacuerdopago_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CvAcuerdoPago $cvAcuerdoPago)
    {
        $form = $this->createDeleteForm($cvAcuerdoPago);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cvAcuerdoPago);
            $em->flush();
        }

        return $this->redirectToRoute('cvacuerdopago_index');
    }

    /**
     * Creates a form to delete a cvAcuerdoPago entity.
     *
     * @param CvAcuerdoPago $cvAcuerdoPago The cvAcuerdoPago entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CvAcuerdoPago $cvAcuerdoPago)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cvacuerdopago_delete', array('id' => $cvAcuerdoPago->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Busca comparendo por número.
     *
     * @Route("/calculate/value", name="cvacuerdopago_calculate_value")
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
                    if ($comparendo->getValorAdicional()) {
                        $valorTotal += $comparendo->getValorAdicional();
                    }
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
     * @Route("/calculate/date/end", name="cvacuerdopago_calculate_date_end")
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
     * @Route("/calculate/dues", name="cvacuerdopago_calculate_dues")
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
            $subtotal = $params->valorCapital - $params->valorCuotaInicial;
            $cuotaMensual = $subtotal / $params->numeroCuotas;
            $interes = $em->getRepository('JHWEBContravencionalBundle:CvCfgInteres')->find(
                $params->idInteres
            );

            for ($i=1; $i < $params->numeroCuotas ; $i++) { 
                $fechaMensual = date("d/m/Y", strtotime("+".$i." month", $fecha));
                $valorInteres = ($cuotaMensual * $interes->getValor()) /100;
                $valorTotal = $cuotaMensual + $valorInteres;
                $cuotas[] = array(
                    'valorCapital' => $cuotaMensual,
                    'valorInteres' => $valorInteres,
                    'valorTotal' => $valorTotal,
                    'fechaMensual' => $fechaMensual
                );
            }
            
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Calculo generado',
                'data' => $cuotas
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
