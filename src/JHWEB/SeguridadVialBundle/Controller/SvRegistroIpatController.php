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
                $gravedad = $em->getRepository('AppBundle:CfgGravedad')->find($params[0]->datosLimitacion->idGravedad);
                $ipat->setGravedad($gravedad);
            }

            $ipat->setLugar($params[0]->datosLimitacion->lugar);

            $fechaAccidente = new \Datetime($params[0]->datosLimitacion->fechaAccidente);
            $ipat->setFechaAccidente($fechaAccidente);
            
            $horaAccidente = new \Datetime($params[0]->datosLimitacion->horaAccidente);
            $ipat->setHoraAccidente($horaAccidente);
            
            $fechaLevantamiento = new \Datetime($params[0]->datosLimitacion->fechaLevantamiento);
            $ipat->setFechaLevantamiento($fechaLevantamiento);
            
            $horaLevantamiento = new \Datetime($params[0]->datosLimitacion->horaLevantamiento);
            $ipat->setHoraLevantamiento($horaLevantamiento);
            
            $fechaActual = new \Datetime();

            $accidente = $this->validarCamposAccidente(
                $fechaLevantamiento,
                $horaLevantamiento,
                $fechaAccidente,
                $horaAccidente,
                $fechaActual,
                $params[0]->datosLimitacion->cantidadAcompaniantes
            );

            if ($accidente) {

                if ($params[0]->datosLimitacion->idClaseAccidente) {
                    $claseAccidente = $em->getRepository('AppBundle:CfgClaseAccidente')->find(
                        $params[0]->datosLimitacion->idClaseAccidente
                    );
                    $ipat->setClaseAccidente($claseAccidente);
                }
                $ipat->setOtroClaseAccidente($params[0]->datosLimitacion->otroClaseAccidente);

                if ($params[0]->datosLimitacion->idChoqueCon) {
                    $choqueCon = $em->getRepository('AppBundle:CfgChoqueCon')->find(
                        $params[0]->datosLimitacion->idChoqueCon
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

                if ($params[0]->datosLimitacion->idEstadoTiempo) {
                    $estadoTiempo = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgEstadoTiempo')->find(
                        $params[0]->datosLimitacion->idEstadoTiempo
                    );
                    $ipat->setEstadoTiempo($estadoTiempo);
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

                $ipat->setNombresConductor($params[0]->datosLimitacion->nombresConductor);
                $ipat->setApellidosConductor($params[0]->datosLimitacion->apellidosConductor);
                $ipat->setTipoIdentificacionConductor($params[0]->datosLimitacion->tipoIdentificacionConductor);
                $ipat->setIdentificacionConductor($params[0]->datosLimitacion->identificacionConductor);
                $ipat->setNacionalidadConductor($params[0]->datosLimitacion->nacionalidadConductor);
                $ipat->setFechaNacimientoConductor(new \Datetime($params[0]->datosLimitacion->fechaNacimientoConductor));
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
                $ipat->setChalecoConductor($params[0]->datosLimitacion->chalecoConductor);
                $ipat->setCascoConductor($params[0]->datosLimitacion->cascoConductor);
                $ipat->setCinturonConductor($params[0]->datosLimitacion->cinturonConductor);

                if ($params[0]->datosLimitacion->idHospitalConductor) {
                    $hospitalConductor = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgHospital')->find(
                        $params[0]->datosLimitacion->idHospitalConductor
                    );
                    $ipat->setHospitalConductor($hospitalConductor);
                }

                $ipat->setDescripcionLesion($params[0]->datosLimitacion->descripcionLesion);

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
                $ipat->setNumeroLicenciaTransito($params[0]->datosLimitacion->numeroLicenciaTransito);
                $ipat->setEmpresa($params[0]->datosLimitacion->empresa);
                $ipat->setNitEmpresa($params[0]->datosLimitacion->nitEmpresa);
                $ipat->setmatriculadoEn($params[0]->datosLimitacion->matriculadoEn);
                $ipat->setInmovilizadoEn($params[0]->datosLimitacion->inmovilizadoEn);
                $ipat->setADisposicionDe($params[0]->datosLimitacion->aDisposicionDe);
                $ipat->setTarjetaRegistro($params[0]->datosLimitacion->tarjetaRegistro);
                $ipat->setRevisionTecnomecanica($params[0]->datosLimitacion->revisionTecnomecanica);
                $ipat->setNumeroTecnoMecanica($params[0]->datosLimitacion->numeroTecnoMecanica);
                $ipat->setCantidadAcompaniantes($params[0]->datosLimitacion->cantidadAcompaniantes);
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
                if ($params[0]->datosLimitacion->idFalla) {
                    $falla = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgFalla')->find(
                        $params[0]->datosLimitacion->idFalla
                    );
                    $ipat->setFalla($falla);
                }

                foreach ($params[0]->lugaresImpacto as $key => $lugarImpactoNombre) {
                    $lugarImpacto = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgLugarImpacto')->find($lugarImpactoNombre);
                    $ipat->setLugarImpacto($lugarImpacto);
                }

                $ipat->setGradoTestigo($params[0]->datosLimitacion->gradoTestigo);
                $ipat->setNombresTestigo($params[0]->datosLimitacion->nombresTestigo);
                $ipat->setApellidosTestigo($params[0]->datosLimitacion->apellidosTestigo);
                $ipat->setTipoIdentificacionTestigo($params[0]->datosLimitacion->tipoIdentificacionTestigo);
                $ipat->setIdentificacionTestigo($params[0]->datosLimitacion->identificacionTestigo);
                $ipat->setPlacaTestigo($params[0]->datosLimitacion->placaTestigo);
                $ipat->setEntidadTestigo($params[0]->datosLimitacion->entidadTestigo);

                $ipat->setVictima($params[0]->datosLimitacion->victima);
                $ipat->setnombresVictima($params[0]->datosLimitacion->nombresVictima);
                $ipat->setApellidosVictima($params[0]->datosLimitacion->apellidosVictima);
                $ipat->setTipoIdentificacionVictima($params[0]->datosLimitacion->tipoIdentificacionVictima);
                $ipat->setIdentificacionVictima($params[0]->datosLimitacion->identificacionVictima);
                $ipat->setNacionalidadVictima($params[0]->datosLimitacion->nacionalidadVictima);
                $ipat->setFechaNacimientoVictima(new \Datetime($params[0]->datosLimitacion->fechaNacimientoVictima));
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
                if ($consecutivo != null) {
                    $fechaAsignacion = new \Datetime();
                    $consecutivo->setFechaAsignacion($fechaAsignacion);
                    $consecutivo->setEstado('En Registro');
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

                $ipat->setObservaciones($params[0]->datosLimitacion->observaciones);

                $ipat->setActivo(true);
                $em->persist($ipat);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Los datos han sido registrados exitosamente.",
                );
            } else {
                $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "No se pudieron validar los campos del accidente",
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

    public function validarCamposAccidente($fechaLevantamiento, $horaLevantamiento, $fechaAccidente, $horaAccidente, $fechaActual, $cantidadAcompaniantes)
    {
        $helpers = $this->get("app.helpers");

        if ($cantidadAcompaniantes) {
            if ($cantidadAcompaniantes >= 0) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "La cantidad de acompañantes al momento del accidente es válida.",
                );
            }
            else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "La cantidad de acompañantes debe ser mayor o igual a 0.",
                );
            }
        }
        // Validación fecha de Levantamiento
        if ($fechaLevantamiento <= $fechaActual && $fechaLevantamiento >= $fechaAccidente ) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "La fecha de levantamiento es válida.",
            );
        } elseif ($fechaLevantamiento == $fechaAccidente) {
            if ( $horaLevantamiento > $horaAccidente ) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "La hora de levantamiento es válida.",
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "La hora de levantamiento debe ser mayor a la hora del accidente.",
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "La fecha de levantamiento debe ser menor o igual a la fecha del sistema y mayor o igual a la fecha del accidente.",
            );
            return $helpers->json($response);
        }
    }
}
