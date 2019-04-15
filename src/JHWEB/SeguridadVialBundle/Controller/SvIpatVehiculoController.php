<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvIpatVehiculo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svipatvehiculo controller.
 *
 * @Route("svipatvehiculo")
 */
class SvIpatVehiculoController extends Controller
{
    /**
     * Lists all svIpatVehiculo entities.
     *
     * @Route("/", name="svipatvehiculo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $svIpatVehiculos = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatVehiculo')->findAll();

        return $this->render('svipatvehiculo/index.html.twig', array(
            'svIpatVehiculos' => $svIpatVehiculos,
        ));
    }

    /**
     * Creates a new svIpatVehiculo entity.
     *
     * @Route("/new", name="svipatvehiculo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $consecutivo = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatConsecutivo')->findOneBy(
                    array(
                        'numero' => $params->consecutivo
                    )
                );
            //===========================================0

            $vehiculo = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatVehiculo')->findOneBy(
                array(
                    'placa' => $params->placa,
                    'consecutivo' => $consecutivo,
                    'activo' => true,
                )
            );

            if($vehiculo){
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El vehiculo ya se encuentra registrado para este IPAT",
                    );
                return $helpers->json($response);
            } else {
                $vehiculo = new SvIpatVehiculo();
                
                //consecutivo del ipat
                /* $consecutivo = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatConsecutivo')->findOneBy(
                    array(
                        'numero' => $params->consecutivo
                    )
                ); */
                $vehiculo->setConsecutivo($consecutivo);
                //=======================================
                
                $vehiculo->setPortaPlaca($params->portaPlaca);
                $vehiculo->setPlaca($params->placa);
                $vehiculo->setPlacaRemolque($params->placaRemolque);
                
                $idNacionalidadVehiculo = (isset($params->nacionalidadVehiculo)) ? $params->nacionalidadVehiculo : null;
                if ($idNacionalidadVehiculo) {
                    $nacionalidadVehiculo = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgNacionalidad')->find($params->nacionalidadVehiculo);
                    $vehiculo->setNacionalidadVehiculo($nacionalidadVehiculo->getNombre());
                }

                $idMarca = (isset($params->marca)) ? $params->marca : null;
                if($idMarca) {
                    $marca = $em->getRepository('JHWEBVehiculoBundle:VhloCfgMarca')->find($params->nacionalidadVehiculo);
                    $vehiculo->setMarca($marca->getNombre());
                }

                $idLinea = (isset($params->linea)) ? $params->linea : null;
                if($idLinea) {
                    $linea = $em->getRepository('JHWEBVehiculoBundle:VhloCfgLinea')->find($params->linea);
                    $vehiculo->setLinea($linea->getNombre());
                }
                $idColor = (isset($params->color)) ? $params->color : null;
                if($idColor) {
                    $color = $em->getRepository('JHWEBVehiculoBundle:VhloCfgColor')->find($params->color);
                    $vehiculo->setColor($color->getNombre());
                }

                $vehiculo->setModelo($params->modelo);

                $idCarroceria = (isset($params->carroceria)) ? $params->carroceria : null;
                if($idCarroceria) {
                    $carroceria = $em->getRepository('JHWEBVehiculoBundle:VhloCfgCarroceria')->find($params->carroceria);
                    $vehiculo->setCarroceria($carroceria->getNombre());
                }

                $vehiculo->setCarroceria($params->carroceria);
                $vehiculo->setTon($params->ton);
                $vehiculo->setPasajeros($params->pasajeros);
                $vehiculo->setEmpresa($params->empresa);
                $vehiculo->setNitEmpresa($params->nitEmpresa);
                $vehiculo->setmatriculadoEn($params->matriculadoEn);
                $vehiculo->setInmovilizado($params->inmovilizado);
                $vehiculo->setInmovilizadoEn($params->inmovilizadoEn);
                $vehiculo->setADisposicionDe($params->aDisposicionDe);
                $vehiculo->setPortaTarjetaRegistro($params->portaTarjetaRegistro);
                $vehiculo->setTarjetaRegistro($params->tarjetaRegistro);
                $vehiculo->setRevisionTecnomecanica($params->revisionTecnomecanica);
                $vehiculo->setNumeroTecnoMecanica($params->numeroTecnoMecanica);

                $cantidadAcompaniantes = $params->cantidadAcompaniantes;
                if ($cantidadAcompaniantes) {
                    if (intval($cantidadAcompaniantes) >= 0) {
                        $response = array(
                            'status' => 'success',
                            'code' => 200,
                            'message' => "La cantidad de acompañantes al momento del accidente es válida.",
                        );
                        $vehiculo->setCantidadAcompaniantes($cantidadAcompaniantes);
                    } else {
                        $response = array(
                            'status' => 'error',
                            'code' => 400,
                            'message' => "La cantidad de acompañantes debe ser mayor o igual a 0.",
                        );
                        return $helpers->json($response);
                    }
                }

                $vehiculo->setPortaSoat($params->portaSoat);
                $vehiculo->setSoat($params->soat);
                $vehiculo->setNumeroPoliza($params->numeroPoliza);
                $vehiculo->setAseguradoraSoat($params->aseguradoraSoat);
                $vehiculo->setFechaVencimientoSoat(new \Datetime($params->fechaVencimientoSoat));
                $vehiculo->setPortaSeguroResponsabilidadCivil($params->portaSeguroResponsabilidadCivil);
                $vehiculo->setNumeroSeguroResponsabilidadCivil($params->numeroSeguroResponsabilidadCivil);
                $vehiculo->setAseguradoraSeguroResponsabilidadCivil($params->idAseguradoraSeguroResponsabilidadCivil);
                $vehiculo->setFechaVencimientoSeguroResponsabilidadCivil(new \Datetime($params->fechaVencimientoSeguroResponsabilidadCivil));
                $vehiculo->setPortaSeguroExtracontractual($params->portaSeguroExtracontractual);
                $vehiculo->setNumeroSeguroExtracontractual($params->numeroSeguroExtracontractual);
                $vehiculo->setAseguradoraSeguroExtracontractual($params->idAseguradoraSeguroExtracontractual);
                $vehiculo->setFechaVencimientoSeguroExtracontractual(new \Datetime($params->fechaVencimientoSeguroExtracontractual));
                /* $vehiculo->setMismoConductor($params->mismoConductor); */
                /* $vehiculo->setNombresPropietario($params->nombresPropietario);
                $vehiculo->setApellidosPropietario($params->apellidosPropietario);


                $idTipoIdentificacion = (isset($params->tipoIdentificacionPropietario)) ? $params->tipoIdentificacionPropietario : null;
                if($idTipoIdentificacion){
                    $tipoIdentificacionPropietario = $em->getRepository('JHWEBUsuarioBundle:UserCfgTipoIdentificacion')->find($idTipoIdentificacion);
                    $vehiculo->setTipoIdentificacionPropietario($tipoIdentificacionPropietario->getNombre());
                }
                $vehiculo->setIdentificacionPropietario($params->identificacionPropietario); */

                $claseVehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloCfgClase')->find($params->clase);
                $vehiculo->setClase($claseVehiculo->getNombre());

                $servicio = $em->getRepository('JHWEBVehiculoBundle:VhloCfgServicio')->find($params->servicio);
                $vehiculo->setServicio($servicio->getNombre());

                $modalidadTransporte = $em->getRepository('JHWEBVehiculoBundle:VhloCfgModalidadTransporte')->find($params->modalidadTransporte);
                $vehiculo->setModalidadTransporte($modalidadTransporte->getNombre());
                
                $idRadioAccion = (isset($params->radioAccion)) ? $params->radioAccion : null;
                if($idRadioAccion) {
                    $radioAccion = $em->getRepository('JHWEBVehiculoBundle:VhloCfgRadioAccion')->find($params->radioAccion);
                    $vehiculo->setRadioAccion($radioAccion->getNombre());
                }

                $vehiculo->setDescripcionDanios($params->descripcionDanios);

                $vehiculo->setFalla($params->arrayFallas);
                $vehiculo->setLugarImpacto($params->arrayLugaresImpacto);

                $vehiculo->setActivo(true);
                $em->persist($vehiculo);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Los datos han sido registrados exitosamente.",
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Finds and displays a svIpatVehiculo entity.
     *
     * @Route("/{id}", name="svipatvehiculo_show")
     * @Method("GET")
     */
    public function showAction(SvIpatVehiculo $svIpatVehiculo)
    {

        return $this->render('svipatvehiculo/show.html.twig', array(
            'svIpatVehiculo' => $svIpatVehiculo,
        ));
    }

    /**
     * datos para select 2
     *
     * @Route("/select/consecutivo", name="vehiulo_consecutivo_select")
     * @Method({"GET", "POST"})
     */
    public function selectByConsecutivoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            
            $consecutivo = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatConsecutivo')->findOneBy(
                array(
                    'numero' => $params
                )
            );
            
            $vehiculos = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatVehiculo')->findBy(
                array(
                    'consecutivo' => $consecutivo->getId(),
                    'activo' => 1
                    )
            );

            $response = null;

            foreach ($vehiculos as $key => $vehiculo) {
                $response[$key] = array(
                    'value' => $vehiculo->getId(),
                    'label' => $vehiculo->getPlaca(),
                );
            }
           
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida",
            );
        }
        return $helpers->json($response);
    }
}
