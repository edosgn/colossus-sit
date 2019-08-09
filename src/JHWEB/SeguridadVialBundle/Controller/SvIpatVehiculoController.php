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

                $vehiculo->setConsecutivo($consecutivo);
                //=======================================
                
                $vehiculo->setPortaPlaca($params->portaPlaca);
                $vehiculo->setPlaca($params->placa);
                $vehiculo->setPlacaRemolque($params->placaRemolque);
                
                $idNacionalidad = (isset($params->nacionalidad)) ? $params->nacionalidad : null;
                if ($idNacionalidad) {
                    $nacionalidad = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgNacionalidad')->find($idNacionalidad);
                    $vehiculo->setNacionalidad($nacionalidad->getNombre());
                }

                $idMarca = (isset($params->marca)) ? $params->marca : null;
                if($idMarca) {
                    $marca = $em->getRepository('JHWEBVehiculoBundle:VhloCfgMarca')->find($params->marca);
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

                $idCarroceria = (isset($params->carroceria)) ? $params->carroceria : null;
                if($params->carroceria){
                    $vehiculo->setCarroceria($params->carroceria);
                }

                $ton = (isset($params->ton)) ? $params->ton : null;
                if($ton){
                    $vehiculo->setTon($params->ton);
                }

                $pasajeros = (isset($params->pasajeros)) ? $params->pasajeros : null;
                if($pasajeros){
                    $vehiculo->setPasajeros($params->pasajeros);
                }

                $empresa = (isset($params->empresa)) ? $params->empresa : null;
                if($empresa){
                    $vehiculo->setNombreEmpresa($params->empresa);
                }

                $nitEmpresa = (isset($params->nitEmpresa)) ? $params->nitEmpresa : null;
                if($nitEmpresa){
                    $vehiculo->setNitEmpresa($params->nitEmpresa);
                }

                $matriculadoEn = (isset($params->matriculadoEn)) ? $params->matriculadoEn : null;
                if($matriculadoEn){
                    $vehiculo->setmatriculadoEn($params->matriculadoEn[0]);
                }

                $inmovilizado = (isset($params->inmovilizado)) ? $params->inmovilizado : null;
                if($inmovilizado){
                    $vehiculo->setInmovilizado($params->inmovilizado);
                }

                $inmovilizadoEn = (isset($params->inmovilizadoEn)) ? $params->inmovilizadoEn : null;
                if($inmovilizadoEn){
                    $vehiculo->setInmovilizadoEn($params->inmovilizadoEn);
                }

                $idParqueadero = (isset($params->idParqueadero)) ? $params->idParqueadero : null;
                if($idParqueadero){
                    $parqueadero = $em->getRepository('JHWEBParqueaderoBundle:PqoCfgPatio')->find($params->idParqueadero);
                    $vehiculo->setParqueadero($parqueadero);
                }

                $aDisposicionDe = (isset($params->aDisposicionDe)) ? $params->aDisposicionDe : null;
                if($aDisposicionDe){
                    $vehiculo->setADisposicionDe($params->aDisposicionDe);
                }

                $portaTarjetaRegistro = (isset($params->portaTarjetaRegistro)) ? $params->portaTarjetaRegistro : null;
                if($portaTarjetaRegistro){
                    $vehiculo->setPortaTarjetaRegistro($params->portaTarjetaRegistro);
                }

                $tarjetaRegistro = (isset($params->tarjetaRegistro)) ? $params->tarjetaRegistro : null;
                if($tarjetaRegistro){
                    $vehiculo->setTarjetaRegistro($params->tarjetaRegistro);
                }

                $revisionTecnomecanica = (isset($params->revisionTecnomecanica)) ? $params->revisionTecnomecanica : null;
                if($revisionTecnomecanica){
                    $vehiculo->setRevisionTecnomecanica($params->revisionTecnomecanica);
                }

                $numeroTecnoMecanica = (isset($params->numeroTecnoMecanica)) ? $params->numeroTecnoMecanica : null;
                if($numeroTecnoMecanica){
                    $vehiculo->setNumeroTecnoMecanica($params->numeroTecnoMecanica);
                }

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
                /* $vehiculo->setSoat($params->soat); */
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

                $idClase = (isset($params->clase)) ? $params->clase : null;
                if($idClase) {
                    $clase = $em->getRepository('JHWEBVehiculoBundle:VhloCfgClase')->find($params->clase);
                    $vehiculo->setClase($clase->getNombre());
                }

                $servicio = $em->getRepository('JHWEBVehiculoBundle:VhloCfgServicio')->find($params->servicio);
                $vehiculo->setServicio($servicio->getNombre());

                $idModalidadTransporte = (isset($params->modalidadTransporte)) ? $params->modalidadTransporte : null;
                if($idModalidadTransporte) {
                    $modalidadTransporte = $em->getRepository('JHWEBVehiculoBundle:VhloCfgModalidadTransporte')->find($params->modalidadTransporte);
                    $vehiculo->setModalidadTransporte($modalidadTransporte->getNombre());
                }

                $idRadioAccion = (isset($params->radioAccion[0])) ? $params->radioAccion[0] : null;
                if($idRadioAccion) {
                    $radioAccion = $em->getRepository('JHWEBVehiculoBundle:VhloCfgRadioAccion')->find($params->radioAccion[0]);
                    $vehiculo->setRadioAccion($radioAccion->getNombre());
                }

                $vehiculo->setDescripcionDanios($params->descripcionDanios);

                $vehiculo->setFallas(implode(",", $params->arrayFallas));
                $vehiculo->setLugaresImpacto(implode(",", $params->arrayLugaresImpacto));

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
