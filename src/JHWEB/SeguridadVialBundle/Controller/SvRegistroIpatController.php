<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvRegistroIpat;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svregistroipat controller.
 *
 * @Route("svregistroipat")
 */
class SvRegistroIpatController extends Controller
{
    /**
     * Lists all svRegistroIpat entities.
     *
     * @Route("/", name="svregistroipat_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $ipats = $em->getRepository('JHWEBSeguridadVialBundle:SvRegistroIpat')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($ipats) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($ipats) . " registros encontrados",
                'data' => $ipats,
            );
        }
        return $helpers->json($response);

    }

    /**
     * Creates a new svRegistroIpat entity.
     *
     * @Route("/new", name="svregistroipat_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $response = null;
        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);

            $ipat = new SvRegistroIpat();

            $em = $this->getDoctrine()->getManager();

            if ($params[0]->datosLimitacion->idSedeOperativa) {
                $sedeOperativa = $em->getRepository('AppBundle:SedeOperativa')->find($params[0]->datosLimitacion->idSedeOperativa);
                $ipat->setSedeOperativa($sedeOperativa);
            }
            if ($params[0]->datosLimitacion->idGravedad) {
                //$gravedad = $em->getRepository('AppBundle:CfgGravedad')->find($params[0]->datosLimitacion->idGravedad);
                $gravedad = $em->getRepository('AppBundle:CfgGravedad')->findOneBy(
                    array(
                        'nombre' => $params[0]->datosLimitacion->idGravedad,
                    )
                );

                $ipat->setGravedad($gravedad);
            }

            $ipat->setLugar($params[0]->datosLimitacion->lugar);

            $fechaAccidenteDatetime = new \Datetime($params[0]->datosLimitacion->fechaAccidente);
            $fechaAccidente = $fechaAccidenteDatetime->format('Y-m-d');

            $horaAccidenteDatetime = new \Datetime($params[0]->datosLimitacion->horaAccidente);
            $horaAccidente = $horaAccidenteDatetime->format('H:i:s');

            $fechaLevantamientoDatetime = new \Datetime($params[0]->datosLimitacion->fechaLevantamiento);
            $fechaLevantamiento = $fechaLevantamientoDatetime->format('Y-m-d');

            $horaLevantamientoDatetime = new \Datetime($params[0]->datosLimitacion->horaLevantamiento);
            $horaLevantamiento = $horaLevantamientoDatetime->format('H:i:s');

            $fechaActualDatetime = new \Datetime();
            $fechaActual = $fechaActualDatetime->format('Y-m-d');

            if ($fechaLevantamiento <= $fechaActual && $fechaLevantamiento > $fechaAccidente) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "La fecha de levantamiento es válida.",
                );
                $ipat->setFechaAccidente($fechaAccidenteDatetime);
                $ipat->setFechaLevantamiento($fechaLevantamientoDatetime);
                $ipat->setHoraAccidente($horaAccidenteDatetime);
                $ipat->setHoraLevantamiento($horaLevantamientoDatetime);

            } elseif ($fechaLevantamiento == $fechaAccidente) {
                if ($horaLevantamiento > $horaAccidente) {
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => "Las hora de levantamiento y accidente son válidas.",
                    );
                } else {
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "Hora de levantamiento o accidente incorrectas.",
                    );
                    $ipat->setFechaAccidente($fechaAccidenteDatetime);
                    $ipat->setFechaLevantamiento($fechaLevantamientoDatetime);
                    $ipat->setHoraAccidente($horaAccidenteDatetime);
                    $ipat->setHoraLevantamiento($horaLevantamientoDatetime);
                }
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "La fecha de levantamiento debe ser menor o igual a la fecha del sistema y mayor o igual a la fecha del accidente.",
                );
            }

            $dia = new \Datetime($params[0]->datosLimitacion->fechaAccidente);
            $diaSemana = $dia->format('l');
            switch ($diaSemana) {
                case 'Monday':
                    $ipat->setDiaAccidente('LUNES');
                    break;
                case 'Tuesday':
                    $ipat->setDiaAccidente('MARTES');
                    break;
                case 'Wednesday':
                    $ipat->setDiaAccidente('MIERCOLES');
                    break;
                case 'Thursday':
                    $ipat->setDiaAccidente('JUEVES');
                    break;
                case 'Friday':
                    $ipat->setDiaAccidente('VIERNES');
                    break;
                case 'Saturday':
                    $ipat->setDiaAccidente('SABADO');
                    break;
                case 'Sunday':
                    $ipat->setDiaAccidente('DOMINGO');
                    break;
            }

            if ($params[0]->datosLimitacion->idClaseAccidente) {
                $claseAccidente = $em->getRepository('AppBundle:CfgClaseAccidente')->findOneBy(
                    array(
                        'nombre' => $params[0]->datosLimitacion->idClaseAccidente,
                    )
                );
                $ipat->setClaseAccidente($claseAccidente);
            }

            $ipat->setOtroClaseAccidente($params[0]->datosLimitacion->otroClaseAccidente);

            if ($params[0]->datosLimitacion->idChoqueCon) {
                $choqueCon = $em->getRepository('AppBundle:CfgChoqueCon')->findOneBy(
                    array(
                        'nombre' => $params[0]->datosLimitacion->idChoqueCon,
                    )
                );
                $ipat->setChoqueCon($choqueCon);
            }

            if ($params[0]->datosLimitacion->idObjetoFijo) {
                $objetoFijo = $em->getRepository('AppBundle:CfgObjetoFijo')->find(
                    $params[0]->datosLimitacion->idObjetoFijo                    
                );
                $ipat->setObjetoFijo($objetoFijo);
            }
            
            $ipat->setOtroObjetoFijo($params[0]->datosLimitacion->otroObjetoFijo);

            if ($params[0]->datosLimitacion->idArea) {
                $area = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgArea')->find(
                    $params[0]->datosLimitacion->idArea
                );
                $ipat->setArea($area);
            }
            if ($params[0]->datosLimitacion->idSector) {
                $sector = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSector')->find(
                    $params[0]->datosLimitacion->idSector
                );
                $ipat->setSector($sector);
            }

            if ($params[0]->datosLimitacion->idZona) {
                $zona = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgZona')->find(
                    $params[0]->datosLimitacion->idZona
                );
                $ipat->setZona($zona);
            }

            if ($params[0]->datosLimitacion->idDisenio) {
                $disenio = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgDisenio')->find(
                    $params[0]->datosLimitacion->idDisenio
                );
                $ipat->setDisenio($disenio);
            }

            if ($params[0]->datosLimitacion->idGeometria) {
                $geometria = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgGeometria')->find(
                    $params[0]->datosLimitacion->idGeometria
                );
                $ipat->setGeometria($geometria);
            }

            if ($params[0]->datosLimitacion->idUtilizacion) {
                $utilizacion = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgUtilizacion')->find(
                    $params[0]->datosLimitacion->idUtilizacion
                );
                $ipat->setUtilizacion($utilizacion);
            }

            if ($params[0]->datosLimitacion->idCalzada) {
                $calzada = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgCalzadaCarril')->find(
                    $params[0]->datosLimitacion->idCalzada
                );
                $ipat->setCalzada($calzada);
            }

            if ($params[0]->datosLimitacion->idCarril) {
                $carril = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgCalzadaCarril')->find(
                    $params[0]->datosLimitacion->idCarril
                );
                $ipat->setCarril($carril);
            }

            if ($params[0]->datosLimitacion->idMaterial) {
                $material = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgMaterial')->find(
                    $params[0]->datosLimitacion->idMaterial
                );
                $ipat->setMaterial($material);
            }

            if ($params[0]->datosLimitacion->idEstadoVia) {
                $estadoVia = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgEstadoVia')->find(
                    $params[0]->datosLimitacion->idEstadoVia
                );
                $ipat->setEstadoVia($estadoVia);
            }

            if ($params[0]->datosLimitacion->idCondicionVia) {
                $condicionVia = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgCondicionVia')->find(
                    $params[0]->datosLimitacion->idCondicionVia
                );
                $ipat->setCondicionVia($condicionVia);
            }

            if ($params[0]->datosLimitacion->idIluminacion) {
                $iluminacion = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgIluminacion')->find(
                    $params[0]->datosLimitacion->idIluminacion
                );
                $ipat->setIluminacion($iluminacion);
            }

            if ($params[0]->datosLimitacion->idEstadoIluminacion) {
                $estadoIluminacion = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgEstadoIluminacion')->find(
                    $params[0]->datosLimitacion->idEstadoIluminacion
                );
                $ipat->setEstadoIluminacion($estadoIluminacion);
            }

            if ($params[0]->datosLimitacion->idVisual) {
                $visual = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgVisual')->find(
                    $params[0]->datosLimitacion->idVisual
                );
                $ipat->setVisual($visual);
            }

            if ($params[0]->datosLimitacion->idVisualDisminuida) {
                $visualDisminuida = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgVisualDisminuida')->find(
                    $params[0]->datosLimitacion->idVisualDisminuida
                );
                $ipat->setVisualDisminuida($visualDisminuida);
            }

            $ipat->setOtraVisualDisminuida($params[0]->datosLimitacion->otraVisualDisminuida);
            $ipat->setSemaforo($params[0]->datosLimitacion->semaforo);

            if ($params[0]->datosLimitacion->idEstadoSemaforo) {
                $estadoSemaforo = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgControlVia')->find(
                    $params[0]->datosLimitacion->idEstadoSemaforo
                );
                $ipat->setEstadoSemaforo($estadoSemaforo);
            }

            $ipat->setSenialVertical($params[5]->senialesVerticales);
            $ipat->setSenialHorizontal($params[6]->senialesHorizontales);
            $ipat->setReductorVelocidad($params[7]->reductoresVelocidad);
            $ipat->setOtroReductorVelocidad($params[0]->datosLimitacion->otroReductorVelocidad);

            if ($params[0]->datosLimitacion->idDelineadorPiso) {
                $delineadorPiso = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgControlVia')->find(
                    $params[0]->datosLimitacion->idDelineadorPiso
                );
                $ipat->setDelineadorPiso($delineadorPiso);
            }

            $ipat->setDelineadorPiso($params[0]->datosLimitacion->otroDelineadorPiso);

            $ipat->setNombresConductor($params[0]->datosLimitacion->nombresConductor);
            $ipat->setApellidosConductor($params[0]->datosLimitacion->apellidosConductor);
            $ipat->setTipoIdentificacionConductor($params[0]->datosLimitacion->tipoIdentificacionConductor);
            $ipat->setIdentificacionConductor($params[0]->datosLimitacion->identificacionConductor);
            $ipat->setNacionalidadConductor($params[0]->datosLimitacion->nacionalidadConductor);
            $ipat->setFechaNacimientoConductor(new \Datetime($params[0]->datosLimitacion->fechaNacimientoConductor));

            $edadConductor = $this->get("app.helpers")->calculateAge($params[0]->datosLimitacion->fechaNacimientoConductor);
            $ipat->setEdadConductor($edadConductor);

            $ipat->setSexoConductor($params[0]->datosLimitacion->sexoConductor);

            if ($params[0]->datosLimitacion->idGravedadConductor) {
                $gravedadConductor = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgGravedadVictima')->find(
                    $params[0]->datosLimitacion->idGravedadConductor
                );
                $ipat->setGravedadConductor($gravedadConductor);
            }

            $ipat->setDireccionResidenciaConductor($params[0]->datosLimitacion->direccionResidenciaConductor);
            $ipat->setCiudadResidenciaConductor($params[0]->datosLimitacion->ciudadResidenciaConductor);
            $ipat->setTelefonoConductor($params[0]->datosLimitacion->telefonoConductor);
            $ipat->setPracticoExamenConductor($params[0]->datosLimitacion->practicoExamenConductor);
            $ipat->setAutorizoConductor($params[0]->datosLimitacion->autorizoConductor);

            if ($params[0]->datosLimitacion->idResultadoExamenConductor) {
                $resultadoExamenConductor = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgResultadoExamen')->find(
                    $params[0]->datosLimitacion->idResultadoExamenConductor
                );
                $ipat->setResultadoExamenConductor($resultadoExamenConductor);
            }

            if ($params[0]->datosLimitacion->idGradoExamenConductor) {
                $gradoExamenConductor = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgGradoExamen')->find(
                    $params[0]->datosLimitacion->idGradoExamenConductor
                );
                $ipat->setGradoExamenConductor($gradoExamenConductor);
            }

            $ipat->setSustanciasPsicoactivasConductor($params[0]->datosLimitacion->sustanciasPsicoactivasConductor);
            $ipat->setPortaLicencia($params[0]->datosLimitacion->portaLicencia);
            $ipat->setNumeroLicenciaConduccion($params[0]->datosLimitacion->numeroLicenciaConduccion);
            $ipat->setCategoriaLicenciaConduccion($params[0]->datosLimitacion->categoriaLicenciaConduccion);
            $ipat->setRestriccionConductor($params[0]->datosLimitacion->restriccionConductor);
            $ipat->setFechaExpedicionLicenciaConduccion(new \Datetime($params[0]->datosLimitacion->fechaExpedicionLicenciaConduccion));
            $ipat->setFechaVencimientoLicenciaConduccion(new \Datetime($params[0]->datosLimitacion->fechaVencimientoLicenciaConduccion));
            $ipat->setOrganismoTransito($params[0]->datosLimitacion->organismoTransito);
            $ipat->setChalecoConductor($params[0]->datosLimitacion->chalecoConductor);
            $ipat->setCascoConductor($params[0]->datosLimitacion->cascoConductor);
            $ipat->setCinturonConductor($params[0]->datosLimitacion->cinturonConductor);

            if ($params[0]->datosLimitacion->idHospitalConductor) {
                $hospitalConductor = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgHospital')->find(
                    $params[0]->datosLimitacion->idHospitalConductor
                );
                $ipat->setHospitalConductor($hospitalConductor);
            }

            $ipat->setDescripcionLesionConductor($params[0]->datosLimitacion->descripcionLesionConductor);

            $ipat->setPlaca($params[0]->datosLimitacion->placa);
            $ipat->setPlacaRemolque($params[0]->datosLimitacion->placaRemolque);
            $ipat->setNacionalidadVehiculo($params[0]->datosLimitacion->nacionalidadVehiculo);
            $ipat->setMarca($params[0]->datosLimitacion->marca);
            $ipat->setLinea($params[0]->datosLimitacion->linea);
            $ipat->setColor($params[0]->datosLimitacion->color);
            $ipat->setModelo($params[0]->datosLimitacion->modelo);
            $ipat->setCarroceria($params[0]->datosLimitacion->carroceria);
            $ipat->setTon($params[0]->datosLimitacion->ton);
            $ipat->setPasajeros($params[0]->datosLimitacion->pasajeros);
            $ipat->setEmpresa($params[0]->datosLimitacion->empresa);
            $ipat->setNitEmpresa($params[0]->datosLimitacion->nitEmpresa);
            $ipat->setmatriculadoEn($params[0]->datosLimitacion->matriculadoEn);
            $ipat->setInmovilizadoEn($params[0]->datosLimitacion->inmovilizadoEn);
            $ipat->setADisposicionDe($params[0]->datosLimitacion->aDisposicionDe);
            $ipat->setTarjetaRegistro($params[0]->datosLimitacion->tarjetaRegistro);
            $ipat->setRevisionTecnomecanica($params[0]->datosLimitacion->revisionTecnomecanica);
            $ipat->setNumeroTecnoMecanica($params[0]->datosLimitacion->numeroTecnoMecanica);

            $cantidadAcompaniantes = $params[0]->datosLimitacion->cantidadAcompaniantes;
            if ($cantidadAcompaniantes) {
                if (intval($cantidadAcompaniantes) >= 0) {
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => "La cantidad de acompañantes al momento del accidente es válida.",
                    );
                    $ipat->setCantidadAcompaniantes($cantidadAcompaniantes);
                } else {
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "La cantidad de acompañantes debe ser mayor o igual a 0.",
                    );
                    return $helpers->json($response);
                }
            }

            $ipat->setPortaSoat($params[0]->datosLimitacion->portaSoat);
            $ipat->setSoat($params[0]->datosLimitacion->soat);
            $ipat->setNumeroPoliza($params[0]->datosLimitacion->numeroPoliza);
            $ipat->setAseguradoraSoat($params[0]->datosLimitacion->aseguradoraSoat);
            $ipat->setFechaVencimientoSoat(new \Datetime($params[0]->datosLimitacion->fechaVencimientoSoat));
            $ipat->setPortaSeguroResponsabilidadCivil($params[0]->datosLimitacion->portaSeguroResponsabilidadCivil);
            $ipat->setNumeroSeguroResponsabilidadCivil($params[0]->datosLimitacion->numeroSeguroResponsabilidadCivil);
            $ipat->setAseguradoraSeguroResponsabilidadCivil($params[0]->datosLimitacion->idAseguradoraSeguroResponsabilidadCivil);
            $ipat->setFechaVencimientoSeguroResponsabilidadCivil(new \Datetime($params[0]->datosLimitacion->fechaVencimientoSeguroResponsabilidadCivil));
            $ipat->setPortaSeguroExtracontractual($params[0]->datosLimitacion->portaSeguroExtracontractual);
            $ipat->setNumeroSeguroExtracontractual($params[0]->datosLimitacion->numeroSeguroExtracontractual);
            $ipat->setAseguradoraSeguroExtracontractual($params[0]->datosLimitacion->idAseguradoraSeguroExtracontractual);
            $ipat->setFechaVencimientoSeguroExtracontractual(new \Datetime($params[0]->datosLimitacion->fechaVencimientoSeguroExtracontractual));
            $ipat->setMismoConductor($params[0]->datosLimitacion->mismoConductor);
            $ipat->setNombresPropietario($params[0]->datosLimitacion->nombresPropietario);
            $ipat->setApellidosPropietario($params[0]->datosLimitacion->apellidosPropietario);
            $ipat->setTipoIdentificacionPropietario($params[0]->datosLimitacion->tipoIdentificacionPropietario);
            $ipat->setIdentificacionPropietario($params[0]->datosLimitacion->identificacionPropietario);
            $ipat->setClase($params[0]->datosLimitacion->clase);
            $ipat->setServicio($params[0]->datosLimitacion->servicio);
            $ipat->setModalidadTransporte($params[0]->datosLimitacion->modalidadTransporte);
            $ipat->setRadioAccion($params[0]->datosLimitacion->radioAccion);
            $ipat->setDescripcionDanios($params[0]->datosLimitacion->descripcionDanios);

            $ipat->setFalla($params[8]->fallas);
            $ipat->setLugarImpacto($params[3]->lugaresImpacto);

            $ipat->setTipoIdentificacionTestigo($params[0]->datosLimitacion->tipoIdentificacionTestigo);
            $ipat->setIdentificacionTestigo($params[0]->datosLimitacion->identificacionTestigo);
            $ipat->setDepartamentoResidenciaTestigo($params[0]->datosLimitacion->departamentoResidenciaTestigo);
            $ipat->setDireccionResidenciaTestigo($params[0]->datosLimitacion->direccionTestigo);
            $ipat->setCiudadResidenciaTestigo($params[0]->datosLimitacion->ciudadResidenciaTestigo);
            $ipat->setTelefonoTestigo($params[0]->datosLimitacion->telefonoTestigo);

            $ipat->setGradoAgente($params[0]->datosLimitacion->gradoAgente);
            $ipat->setTipoIdentificacionAgente($params[0]->datosLimitacion->tipoIdentificacionAgente);
            $ipat->setIdentificacionAgente($params[0]->datosLimitacion->identificacionAgente);
            $ipat->setNombresAgente($params[0]->datosLimitacion->nombresAgente);
            $ipat->setApellidosAgente($params[0]->datosLimitacion->apellidosAgente);
            $ipat->setPlacaAgente($params[0]->datosLimitacion->placaAgente);
            $ipat->setEntidadAgente($params[0]->datosLimitacion->entidadAgente);

            $ipat->setVictima($params[0]->datosLimitacion->victima);
            $ipat->setnombresVictima($params[0]->datosLimitacion->nombresVictima);
            $ipat->setApellidosVictima($params[0]->datosLimitacion->apellidosVictima);
            $ipat->setTipoIdentificacionVictima($params[0]->datosLimitacion->tipoIdentificacionVictima);
            $ipat->setIdentificacionVictima($params[0]->datosLimitacion->identificacionVictima);
            $ipat->setNacionalidadVictima($params[0]->datosLimitacion->nacionalidadVictima);
            $ipat->setFechaNacimientoVictima(new \Datetime($params[0]->datosLimitacion->fechaNacimientoVictima));

            $edadVictima = $this->get("app.helpers")->calculateAge($params[0]->datosLimitacion->fechaNacimientoVictima);
            $ipat->setEdadVictima($edadVictima);

            $ipat->setSexoVictima($params[0]->datosLimitacion->sexoVictima);
            $ipat->setDireccionResidenciaVictima($params[0]->datosLimitacion->direccionResidenciaVictima);
            $ipat->setCiudadResidenciaVictima($params[0]->datosLimitacion->ciudadResidenciaVictima);
            $ipat->setTelefonoVictima($params[0]->datosLimitacion->telefonoVictima);

            if ($params[0]->datosLimitacion->idHospitalVictima) {
                $hospitalVictima = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgHospital')->find(
                    $params[0]->datosLimitacion->idHospitalVictima
                );
                $ipat->setHospitalVictima($hospitalVictima);
            }

            $ipat->setPracticoExamenVictima($params[0]->datosLimitacion->practicoExamenVictima);
            $ipat->setAutorizoVictima($params[0]->datosLimitacion->autorizoVictima);

            if ($params[0]->datosLimitacion->idResultadoExamenVictima) {
                $resultadoExamenVictima = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgResultadoExamen')->find(
                    $params[0]->datosLimitacion->idResultadoExamenVictima
                );
                $ipat->setResultadoExamenVictima($resultadoExamenVictima);
            }

            if ($params[0]->datosLimitacion->idGradoExamenVictima) {
                $gradoExamenVictima = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgGradoExamen')->find(
                    $params[0]->datosLimitacion->idGradoExamenVictima
                );
                $ipat->setGradoExamenVictima($gradoExamenVictima);
            }

            $ipat->setSustanciasPsicoactivasVictima($params[0]->datosLimitacion->sustanciasPsicoactivasVictima);
            $ipat->setChalecoVictima($params[0]->datosLimitacion->chalecoVictima);
            $ipat->setCascoVictima($params[0]->datosLimitacion->cascoVictima);
            $ipat->setCinturonVictima($params[0]->datosLimitacion->cinturonVictima);

            if ($params[0]->datosLimitacion->idTipoVictima) {
                $tipoVictima = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTipoVictima')->find(
                    $params[0]->datosLimitacion->idTipoVictima
                );
                $ipat->setTipoVictima($tipoVictima);
            }

            if ($params[0]->datosLimitacion->idGravedadVictima) {
                $gravedadVictima = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgGravedadVictima')->find(
                    $params[0]->datosLimitacion->idGravedadVictima
                );
                $ipat->setGravedadVictima($gravedadVictima);
            }

            $consecutivo = $em->getRepository('AppBundle:MsvTConsecutivo')->findOneBy(array('consecutivo' => $params[2]->consecutivo->consecutivo));
            $ipat->setConsecutivo($consecutivo);

            if ($consecutivo) {
                $fechaAsignacion = new \Datetime();
                $consecutivo->setFechaAsignacion($fechaAsignacion);
                $usuario = $em->getRepository('UsuarioBundle:Usuario')->findOneBy(array('identificacion' => $params[0]->datosLimitacion->identificacionAgente));
                $ciudadano = $em->getRepository('AppBundle:Ciudadano')->findOneBy(array('usuario' => $usuario));
                $funcionario = $em->getRepository('AppBundle:MpersonalFuncionario')->findOneBy(array('ciudadano' => $ciudadano));
                $consecutivo->setFuncionario($funcionario);
                $consecutivo->setEstado('UTILIZADO');

                $em->persist($consecutivo);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "consecutivo modificado",
                );

            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "no se pudo modificar el consecutivo",
                );
            }

            $ipat->setDescripcionLesionVictima($params[0]->datosLimitacion->descripcionLesionVictima);
            $ipat->setObservaciones($params[0]->datosLimitacion->observaciones);
            $ipat->setActivo(true);
            $em->persist($ipat);
            $em->flush();
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
     * Finds and displays a svRegistroIpat entity.
     *
     * @Route("/{id}/show", name="svregistroipat_show")
     * @Method("GET")
     */
    public function showAction(SvRegistroIpat $svRegistroIpat)
    {

        return $this->render('svregistroipat/show.html.twig', array(
            'svRegistroIpat' => $svRegistroIpat,
        ));
    }

    /**
     * Search usuario entity.
     *
     * @Route("/get/datos/conductor", name="datos_conductor")
     * @Method({"GET", "POST"})
     */
    public function buscarConductorAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            $conductor = $em->getRepository('UsuarioBundle:Usuario')->findBy(array('identificacion' => $params->identificacion));

            if ($conductor) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "conductor encontrado",
                    'data' => $conductor,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El ciudadano no se encuentra en la Base de Datos",
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
     * Search vehiculo entity.
     *
     * @Route("/get/datos/vehiculo", name="datos_vehiculo")
     * @Method({"GET", "POST"})
     */
    public function buscarVehiculoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            $placa = $em->getRepository('AppBundle:CfgPlaca')->findOneBy(array('numero' => $params->placa));
            $vehiculo = $em->getRepository('AppBundle:Vehiculo')->findOneBy(array('placa' => $placa));
            if ($vehiculo) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "vehiculo encontrado",
                    'data' => $vehiculo,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El vehiculo no se encuentra en la Base de Datos",
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
     * Search vehiculo entity.
     *
     * @Route("/get/datos/licenciaconduccion", name="datos_licencia__conduccion_conductor")
     * @Method({"GET", "POST"})
     */
    public function buscarLicenciaConductorAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            $licenciaConduccion = $em->getRepository('AppBundle:LicenciaConduccion')->findOneBy(array('numero' => $params->numero));
            if ($licenciaConduccion) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "licencia conducción encontrada",
                    'data' => $licenciaConduccion,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "La licencia de conducción no se encuentra en la Base de Datos",
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
     * Search agente entity.
     *
     * @Route("/get/datos/agente", name="datos_agente")
     * @Method({"GET", "POST"})
     */
    public function buscarAgenteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            $agente = $em->getRepository('UsuarioBundle:Usuario')->findBy(array('identificacion' => $params->identificacionAgente));
            $funcionario = $em->getRepository('AppBundle:MpersonalFuncionario')->findOneBy(array('id' => $agente));
            if ($funcionario) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "agente encontrado",
                    'data' => $funcionario,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El agente no se encuentra en la Base de Datos",
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
     * Search victima entity.
     *
     * @Route("/get/datos/victima", name="datos_victima")
     * @Method({"GET", "POST"})
     */
    public function buscarVictimaAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            $victima = $em->getRepository('UsuarioBundle:Usuario')->findBy(array('identificacion' => $params->identificacionVictima));
            if ($victima) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "victima encontrada",
                    'data' => $victima,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "La victima no se encuentra en la Base de Datos",
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
     * Search testigo entity.
     *
     * @Route("/get/datos/testigo", name="datos_testigo")
     * @Method({"GET", "POST"})
     */
    public function buscarTestigoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            $testigo = $em->getRepository('UsuarioBundle:Usuario')->findBy(array('identificacion' => $params->identificacionTestigo));
            if ($testigo) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "testigo encontrada",
                    'data' => $testigo,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "La testigo no se encuentra en la Base de Datos",
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
     * Exporta ipats.
     *
     * @Route("/export", name="ipat_export")
     * @Method("GET")
     */
    public function exportAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $ipats = $em->getRepository('JHWEBSeguridadVialBundle:SvRegistroIpat')->findAll();

        $response['data'] = array();

        if ($ipats) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($ipats) . " registros encontrados",
                'data' => $ipats,
            );
        }
        return $helpers->json($response);
    }

    /**
     * Exporta ipats.
     *
     * @Route("/buscaripat", name="buscar_ipat")
     * @Method({"GET", "POST"})
     */
    public function buscarIpatAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        $em = $this->getDoctrine()->getManager();

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();

            $ipats = $em->getRepository('JHWEBSeguridadVialBundle:SvRegistroIpat')->getIpatByRango($params);
            
            if($params->file == null) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Por favor seleccione un archivo para subir",
                );
            } else {
                foreach($params->file as $key => $dato) {
                    
                    $ipat = new SvRegistroIpat();
                    if($ipat -> getNombresConductor() != $dato[7] && $ipat -> getApellidosConductor() != $dato[8] && $ipat -> getFechaAccidente() != $dato[2] && $ipat -> getHoraAccidente() != $dato[3]) {

                        $ipat -> setFechaAccidente(new \Datetime($dato[2]));
                        $ipat -> setHoraAccidente(new \Datetime($dato[3]));
                        $ipat -> setDiaAccidente($dato[4]);
                        $gravedadFile = $em->getRepository('AppBundle:CfgGravedad')->findOneBy(array('nombre' => $dato[11]));
                        $ipat -> setGravedad($gravedadFile);
                        $tipoVictimaFile = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTipoVictima')->findOneBy(array('nombre' => $dato[13]));
                        $ipat -> setTipoVictima($tipoVictimaFile);
                        $ipat -> setNombresConductor($dato[7]);
                        $ipat -> setApellidosConductor($dato[8]);
                        $ipat -> setCiudadResidenciaConductor($dato[0]);
                        $sexoConductorFile = $em->getRepository('AppBundle:Genero')->findOneBy(array('nombre' => $dato[6]));
                        $ipat -> setSexoConductor($sexoConductorFile->getSigla());
                        $ipat -> setEdadConductor($dato[10]);
                        $claseAccidenteFile = $em->getRepository('AppBundle:CfgClaseAccidente')->findOneBy(array('nombre' => $dato[12]));
                        $ipat -> setClaseAccidente($claseAccidenteFile);
                        $ipat->setActivo(true);

                        $em->persist($ipat);
                        $em->flush();
                    }
                }
            }
            if ($ipats) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($ipats) . " ipats encontrado(s)",
                    'data' => $ipats,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No se encontraron registros en la Base de Datos",
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
