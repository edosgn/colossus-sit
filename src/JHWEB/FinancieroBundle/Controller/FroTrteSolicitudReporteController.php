<?php

namespace JHWEB\FinancieroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * FroTrteSolicitudReporteController controller.
 *
 * @Route("frotrtesolicitudreporte")
 */
class FroTrteSolicitudReporteController extends Controller
{
    
    /**
     * Lists vhloVehiculoByPlaca.
     *
     * @Route("/search/placa", name="vhlovehiculo_propietario_search_placa")
     * @Method({"GET", "POST"})
     */
    public function searchByPlacaAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            
            /* $placa = $em->getRepository('JHWEBVehiculoBundle:VhloCfgPlaca')->findOneBy(
                array(
                    'numero' => $params->placa
                )
            );

            $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->findBy(
                array(
                    'placa' => $placa
                )
            ); */

            $tramitesSolicitud = $em->getRepository('JHWEBFinancieroBundle:FroTrteSolicitud')->getByPlaca($params->idOrganismoTransito, $params->idModulo);

            if ($tramitesSolicitud) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($tramitesSolicitud).' registros encontrados.', 
                    'data'=> $tramitesSolicitud,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'No existes tramites de matricula inicial.', 
                );
            }            
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida para editar', 
            );
        }

        return $helpers->json($response);
    }
}
