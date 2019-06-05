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
     * @Route("/search/placa", name="vhlovehiculo_search_by_placa")
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
            
            $fechaDesde = new \Datetime($params->fechaDesde);
            $fechaHasta = new \Datetime($params->fechaHasta);
            
            $placa = $em->getRepository('JHWEBVehiculoBundle:VhloCfgPlaca')->findOneBy(
                array(
                    'numero' => $params->placa
                )
            );

            $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->findOneBy(
                array(
                    'placa' => $placa
                )
            );
            
            $tramitesSolicitud = null;
            $propietariosActuales = null;
            $tramites = null;
            $medidasCautelares = null;
            $cancelacionesMatricula = null;
            $vehiculosPlaca = [];
            if($params->tipoReporte == 1) {
                $tramitesSolicitud = $em->getRepository('JHWEBFinancieroBundle:FroTrteSolicitud')->getByPlaca($params->idOrganismoTransito, $params->idModulo, $fechaDesde, $fechaHasta);
            }
            else if($params->tipoReporte == 2){
                $propietariosActuales = $em->getRepository('JHWEBFinancieroBundle:FroTrteSolicitud')->getPropietariosActualesByPlaca($params->idOrganismoTransito, $params->idModulo, $vehiculo->getId());
            }
            else if($params->tipoReporte == 3) {
                $tramites = $em->getRepository('JHWEBFinancieroBundle:FroTrteSolicitud')->getByTramites($params->idOrganismoTransito, $params->idModulo, $fechaDesde, $fechaHasta);
            }
            else if($params->tipoReporte == 4) {
                $medidasCautelares = $em->getRepository('JHWEBFinancieroBundle:FroTrteSolicitud')->getByMedidasCautelares($fechaDesde, $fechaHasta);

                foreach ($medidasCautelares as $key => $medidaCautelar) {
                    $propietarios = $em->getRepository('JHWEBVehiculoBundle:VhloPropietario')->findBy(
                        array(
                            'ciudadano' => $medidaCautelar->getCiudadano()->getId(),
                            'activo' => 1
                        )
                    );
                }

                foreach ($propietarios as $key => $propietario) {
                    $vehiculosPlaca = array(
                        'numero' => $propietario->getVehiculo()->getPlaca()->getNumero()
                    );
                }
                /* if($vehiculosPlaca){
                    $placasString = implode(',', '$vehiculosPlaca');
                } */

                /* $arrayMedidasCautelares = array(

                ); */
            }
            else if($params->tipoReporte == 5) {
                $cancelacionesMatricula = $em->getRepository('JHWEBFinancieroBundle:FroTrteSolicitud')->getByCancelacionMatricula($params->idOrganismoTransito, $params->idModulo, $fechaDesde, $fechaHasta);
            }
            if ($tramitesSolicitud || $propietariosActuales || $tramites || $medidasCautelares || $cancelacionesMatricula) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Registros encontrados.', 
                    'tramitesSolicitud'=> $tramitesSolicitud,
                    'propietariosActuales'=> $propietariosActuales,
                    'tramites'=> $tramites,
                    'medidasCautelares' => $medidasCautelares,
                    'cancelacionesMatricula' => $cancelacionesMatricula
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'No registros para los filtros estipulados.', 
                );
            }            
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorización no válida.', 
            );
        }

        return $helpers->json($response);
    }
}
