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
            // var_dump($params);
            // die();
            $em = $this->getDoctrine()->getManager();
            $froFactura = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->findOneBy(
                array('numero' => $params->numeroFactura)
            );

            if ($froFactura!=null) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Factura encontrada", 
                    'data'=> $froFactura,
            );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Factura no encontrada", 
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
