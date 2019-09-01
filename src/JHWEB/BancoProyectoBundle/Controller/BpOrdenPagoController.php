<?php

namespace JHWEB\BancoProyectoBundle\Controller;

use JHWEB\BancoProyectoBundle\Entity\BpOrdenPago;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Bpordenpago controller.
 *
 * @Route("bpordenpago")
 */
class BpOrdenPagoController extends Controller
{
    /**
     * Lists all bpOrdenPago entities.
     *
     * @Route("/", name="bpordenpago_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $ordenes = $em->getRepository('JHWEBBancoProyectoBundle:BpOrdenPago')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($ordenes) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($ordenes)." registros encontrados", 
                'data'=> $ordenes,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new bpOrdenPago entity.
     *
     * @Route("/new", name="bpordenpago_new")
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

            if ($params->idRegistroCompromiso) {
                $registro = $em->getRepository('JHWEBBancoProyectoBundle:BpRegistroCompromiso')->find(
                    $params->idRegistroCompromiso
                );

                if ($params->valor <= $registro->getSaldo()) {
                        $ordenPago = new BpOrdenPago();

                    $fecha = new \Datetime($params->fecha);

                    $consecutivo = $em->getRepository('JHWEBBancoProyectoBundle:BpOrdenPago')->getMaximo(
                        $fecha->format('Y')
                    );
                    $consecutivo = (empty($consecutivo['maximo']) ? 1 : $consecutivo['maximo']+=1);
                    
                    $ordenPago->setConsecutivo($consecutivo);

                    $numero = str_pad($consecutivo, 3, '0', STR_PAD_LEFT).'-'.$fecha->format('mY');

                    $ordenPago->setNumero($numero);
                    $ordenPago->setFecha($fecha);
                    $ordenPago->setTipo($params->tipo);
                    $ordenPago->setConcepto($params->concepto);
                    $ordenPago->setValor($params->valor);
                    $ordenPago->setActivo(true);

                    $ordenPago->setRegistroCompromiso($registro);
                    $registro->setSaldo($registro->getSaldo() - $params->valor);
                    $proyecto = $registro->getCdp()->getActividad()->getCuenta()->getProyecto();
                    $proyecto->setSaldoTotal($proyecto->getSaldoTotal() - $params->valor);
                    
                    $em->persist($ordenPago);
                    $em->flush();

                    $response = array(
                        'title' => 'Perfecto!',
                        'status' => 'success',
                        'code' => 200,
                        'message' => "Registro creado con exito.",
                        'data' => $registro
                    );
                } else {
                    $response = array(
                        'title' => 'Atención!',
                        'status' => 'warning',
                        'code' => 400,
                        'message' => "El valor no puede ser mayor al saldo del registro de compromiso.", 
                    );
                }
            }else{
                $response = array(
                    'title' => 'Atención!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => "No se encuenta registro de compromiso.", 
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
     * Finds and displays a bpOrdenPago entity.
     *
     * @Route("/{id}", name="bpordenpago_show")
     * @Method("GET")
     */
    public function showAction(BpOrdenPago $bpOrdenPago)
    {
        $deleteForm = $this->createDeleteForm($bpOrdenPago);

        return $this->render('bpordenpago/show.html.twig', array(
            'bpOrdenPago' => $bpOrdenPago,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing bpOrdenPago entity.
     *
     * @Route("/{id}/edit", name="bpordenpago_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, BpOrdenPago $bpOrdenPago)
    {
        $deleteForm = $this->createDeleteForm($bpOrdenPago);
        $editForm = $this->createForm('JHWEB\BancoProyectoBundle\Form\BpOrdenPagoType', $bpOrdenPago);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('bpordenpago_edit', array('id' => $bpOrdenPago->getId()));
        }

        return $this->render('bpordenpago/edit.html.twig', array(
            'bpOrdenPago' => $bpOrdenPago,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a bpOrdenPago entity.
     *
     * @Route("/{id}", name="bpordenpago_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, BpOrdenPago $bpOrdenPago)
    {
        $form = $this->createDeleteForm($bpOrdenPago);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($bpOrdenPago);
            $em->flush();
        }

        return $this->redirectToRoute('bpordenpago_index');
    }

    /**
     * Creates a form to delete a bpOrdenPago entity.
     *
     * @param BpOrdenPago $bpOrdenPago The bpOrdenPago entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BpOrdenPago $bpOrdenPago)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bpordenpago_delete', array('id' => $bpOrdenPago->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
