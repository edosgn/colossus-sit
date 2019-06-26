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

            $arrayVehiculos = null;
            $propietariosActuales = null;
            $tramites = null;
            $medidasCautelares = null;
            $cancelacionesMatricula = null;
            $vehiculosPlaca = [];
            $arrayMedidaCautelar = null;
            $arrayPrendas = null;
            $radicadosCuenta = null;
            $arrayTramites = null;
            
            if($params->tipoReporte == 1) {
                $vehiculos = $em->getRepository('JHWEBFinancieroBundle:FroTrteSolicitud')->getByPlaca($params->idOrganismoTransito, $params->idModulo, $fechaDesde, $fechaHasta);
                
                foreach ($vehiculos as $key => $vehiculo) {
                    $propietario = $em->getRepository('JHWEBVehiculoBundle:VhloPropietario')->findOneBy(
                        array(
                            'vehiculo' => $vehiculo->getVehiculo()->getId(),
                            'activo' => true
                        )
                    );

                    $licenciaTransito = $em->getRepository('JHWEBUsuarioBundle:UserLicenciaTransito')->findOneBy(
                        array(
                            'propietario' => $propietario->getId(),
                            'activo' => true
                        )
                    );

                    $arrayVehiculos [] = array(
                        'organismoTransito' => $vehiculo->getVehiculo()->getOrganismoTransito()->getNombre(),
                        'placa' => $vehiculo->getVehiculo()->getPlaca()->getNumero(),
                        'marca' => $vehiculo->getVehiculo()->getLinea()->getMarca()->getNombre(),
                        'linea' => $vehiculo->getVehiculo()->getLinea()->getNombre(),
                        'clase' => $vehiculo->getVehiculo()->getClase()->getNombre(),
                        'color' => $vehiculo->getVehiculo()->getColor()->getNombre(),
                        'servicio' => $vehiculo->getVehiculo()->getServicio()->getNombre(),
                        'carroceria' => $vehiculo->getVehiculo()->getCarroceria()->getNombre(),
                        'modalidadTransporte' => $vehiculo->getVehiculo()->getModalidadTransporte()->getNombre(),
                        'cilindraje' => $vehiculo->getVehiculo()->getCilindraje(),
                        'modelo' => $vehiculo->getVehiculo()->getModelo(),
                        'motor' => $vehiculo->getVehiculo()->getMotor(),
                        'chasis' => $vehiculo->getVehiculo()->getChasis(),
                        'serie' => $vehiculo->getVehiculo()->getSerie(),
                        'capacidadCarga' => $vehiculo->getVehiculo()->getCapacidadCarga(),
                        'numeroPasajeros' => $vehiculo->getVehiculo()->getNumeroPasajeros(),
                        'fechaMatricula' => $vehiculo->getFecha(),
                        'licenciaTransito' => !empty($licenciaTransito) ? $licenciaTransito: null,
                        'numeroFactura' => 'N',
                        'combustible' => $vehiculo->getVehiculo()->getCombustible()->getCodigo(),
                        'estado' => $vehiculo->getVehiculo()->getActivo(),
                    );
                }
            }
            else if($params->tipoReporte == 2){
                if(!$vehiculo){
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'El vehículo no se encuentra registrado en la base de datos.', 
                );
                return $helpers->json($response);
                } else {
                    $propietariosActuales = $em->getRepository('JHWEBFinancieroBundle:FroTrteSolicitud')->getPropietariosActualesByPlaca($params->idOrganismoTransito, $params->idModulo, $vehiculo->getId());
                }
            }
            else if($params->tipoReporte == 3) {
                $tramites = $em->getRepository('JHWEBFinancieroBundle:FroTrteSolicitud')->getByTramites($params->idOrganismoTransito, $params->idModulo, $fechaDesde, $fechaHasta);
                foreach ($tramites as $key => $tramite) {
                    $propietario = $em->getRepository('JHWEBVehiculoBundle:VhloPropietario')->findOneBy(
                        array(
                            'vehiculo' => $tramite->getVehiculo()->getId()
                            )
                        );    

                    $licenciaTransito = $em->getRepository('JHWEBUsuarioBundle:UserLicenciaTransito')->findOneBy(
                        array(
                            'propietario' => $propietario->getId()
                        )
                    );

                    $arrayTramites [] = array(
                        'tipoTramite' => $tramite->getTramiteFactura()->getPrecio()->getTramite()->getCodigo(),
                        'placa' => $tramite->getVehiculo()->getPlaca()->getNumero(),
                        'fecha' => $tramite->getFecha(),
                        'organismoTransito' => $tramite->getOrganismoTransito()->getDivipo(),
                        'licenciaTransito' => !empty($licenciaTransito) ? $licenciaTransito: null,
                        'numeroPago' => 'N'
                    );
                }
            }
            else if($params->tipoReporte == 4) {
                $medidasCautelares = $em->getRepository('JHWEBFinancieroBundle:FroTrteSolicitud')->getByMedidasCautelares($fechaDesde, $fechaHasta);

                foreach ($medidasCautelares as $key => $medidaCautelar) {
                    $propietarios = $em->getRepository('JHWEBVehiculoBundle:VhloPropietario')->findBy(
                        array(
                            'ciudadano' => $medidaCautelar->getCiudadano(),
                            'activo' => 1
                        )
                    );
                    foreach ($propietarios as $key => $propietario) {                        
                        array_push($vehiculosPlaca, $propietario->getVehiculo()->getPlaca()->getNumero());
                        $placas = implode(", ", array_unique($vehiculosPlaca));                    
                    }
                    $arrayMedidaCautelar [] = array(
                        'placa' => $placas,
                        'tipoMedida' => $medidaCautelar->getTipoMedida()->getCodigo(),
                        'ente' => $medidaCautelar->getEntidadJudicial()->getNombre(),
                        'numeroOficio' => $medidaCautelar->getNumeroOficio(),
                        'fechaExpedicion' => $medidaCautelar->getFechaRegistro(),
                        'activo' => $medidaCautelar->getActivo(),
                        'numeroLevantamiento' => $medidaCautelar->getNumeroRadicado(),
                        'observaciones' => $medidaCautelar->getObservacionesLevantamiento()

                    );
                }
            }
            else if($params->tipoReporte == 5) {
                $cancelacionesMatricula = $em->getRepository('JHWEBFinancieroBundle:FroTrteSolicitud')->getByCancelacionMatricula($params->idOrganismoTransito, $params->idModulo, $fechaDesde, $fechaHasta);
            }
            else if($params->tipoReporte == 6) {
                $prendas = $em->getRepository('JHWEBFinancieroBundle:FroTrteSolicitud')->getByPrendas($params->idOrganismoTransito, $params->idModulo, $fechaDesde, $fechaHasta);

                foreach ($prendas as $key => $prenda) {
                    $vehiculoAcreedor = $em->getRepository('JHWEBVehiculoBundle:VhloAcreedor')->findOneBy(
                        array(
                            'vehiculo' => $prenda->getVehiculo()->getId(),
                            'activo' => true
                        )
                    );

                    $arrayPrendas [] = array(
                        'organismoTransito' => $prenda->getOrganismoTransito()->getDivipo(),
                        'placa' => $prenda->getVehiculo()->getPlaca()->getNumero(),
                        'ciudadano' => !empty($vehiculoAcreedor->getCiudadano()) ? $vehiculoAcreedor->getCiudadano(): null,
                        'empresa' => !empty($vehiculoAcreedor->getEmpresa()) ? $vehiculoAcreedor->getEmpresa(): null,
                        'gradoAlerta' => $vehiculoAcreedor->getGradoAlerta(),
                        'fecha' => $prenda->getFecha(),
                        'estadoPrenda' => $vehiculoAcreedor->getActivo(),
                        'tipoAlerta' => $vehiculoAcreedor->getTipoAlerta()->getId()
                    );
                }
            }
            else if($params->tipoReporte == 7) {
                $radicadosCuenta = $em->getRepository('JHWEBFinancieroBundle:FroTrteSolicitud')->getByRadicadosCuenta($params->idOrganismoTransito, $params->idModulo, $fechaDesde, $fechaHasta);
            }
    
            if ($arrayVehiculos || $propietariosActuales || $tramites || $medidasCautelares || $cancelacionesMatricula || $arrayPrendas || $radicadosCuenta) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Registros encontrados.', 
                    'tramitesSolicitud'=> $arrayVehiculos,
                    'propietariosActuales'=> $propietariosActuales,
                    'tramites'=> $arrayTramites,
                    'medidasCautelares' => $arrayMedidaCautelar,
                    'cancelacionesMatricula' => $cancelacionesMatricula,
                    'prendas' => $arrayPrendas,
                    'radicadosCuenta' => $radicadosCuenta,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'No hay registros para los filtros estipulados.', 
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
