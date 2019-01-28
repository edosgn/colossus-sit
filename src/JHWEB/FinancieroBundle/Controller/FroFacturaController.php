<?php

namespace JHWEB\FinancieroBundle\Controller;

use JHWEB\FinancieroBundle\Entity\FroFactura;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

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

            $factura->setFechaCreacion(new \Datetime(date('Y-m-d')));
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

            $em->persist($factura);
            $em->flush();

            

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
}
