<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvIpat;
use JHWEB\SeguridadVialBundle\Entity\SvIpatConductor;
use JHWEB\SeguridadVialBundle\Entity\SvIpatVictima;
use JHWEB\SeguridadVialBundle\Entity\SvIpatVehiculo;

use JHWEB\UsuarioBundle\Entity\UserCiudadano;
use Repository\UsuarioBundle\Entity\Usuario;
use JHWEB\VehiculoBundle\Entity\VhloVehiculo;
use JHWEB\VehiculoBundle\Entity\VhloCfgPlaca;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svipat controller.
 *
 * @Route("svipat")
 */
class SvIpatController extends Controller
{
    /**
     * Lists all svIpat entities.
     *
     * @Route("/", name="svipat_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $ipats = $em->getRepository('JHWEBSeguridadVialBundle:SvIpat')->findBy(
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
     * Creates a new svIpat entity.
     *
     * @Route("/new", name="svipat_new")
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

            $ipat = new SvIpat();

            if ($params->idOrganismoTransito) {
                $idOrganismoTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find($params->idOrganismoTransito);
                $ipat->setOrganismoTransito($idOrganismoTransito);
            }
            
            if ($params->idGravedad) {
                $gravedadAccidente = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgGravedadAccidente')->find($params->idGravedad);
                $ipat->setGravedadAccidente($gravedadAccidente);
            }

            $ipat->setLugar($params->lugar);

            $fechaAccidenteDatetime = new \Datetime($params->fechaAccidente);
            $fechaAccidente = $fechaAccidenteDatetime->format('Y-m-d');

            $horaAccidenteDatetime = new \Datetime($params->horaAccidente);
            $horaAccidente = $horaAccidenteDatetime->format('H:i:s');

            $fechaLevantamientoDatetime = new \Datetime($params->fechaLevantamiento);
            $fechaLevantamiento = $fechaLevantamientoDatetime->format('Y-m-d');

            $horaLevantamientoDatetime = new \Datetime($params->horaLevantamiento);
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

            $dia = new \Datetime($params->fechaAccidente);
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

            if ($params->idClaseAccidente) {
                $claseAccidente = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgClaseAccidente')->find($params->idClaseAccidente);
                $ipat->setClaseAccidente($claseAccidente);
            }

            $ipat->setOtroClaseAccidente($params->otroClaseAccidente);

            
            if ($params->idClaseChoque) {
                $claseChoque = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgClaseChoque')->find($params->idClaseChoque);
                $ipat->setClaseChoque($claseChoque);
            }

            if ($params->idObjetoFijo) {
                $objetoFijo = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgObjetoFijo')->find($params->idObjetoFijo);
                $ipat->setObjetoFijo($objetoFijo);
            }
            
            $ipat->setOtroObjetoFijo($params->otroObjetoFijo);

            if ($params->idArea) {
                $area = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgArea')->find(
                    $params->idArea
                );
                $ipat->setArea($area);
            }
            if ($params->idSector) {
                $sector = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSector')->find(
                    $params->idSector
                );
                $ipat->setSector($sector);
            }

            if ($params->idZona) {
                $zona = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgZona')->find(
                    $params->idZona
                );
                $ipat->setZona($zona);
            }

            if ($params->idDisenio) {
                $disenio = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgDisenio')->find(
                    $params->idDisenio
                );
                $ipat->setDisenio($disenio);
            }

            if($params->arrayEstadosTiempo) {
                $ipat->setEstadoTiempo($params->arrayEstadosTiempo);
            }

            if ($params->idGeometria) {
                $geometria = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgGeometria')->find(
                    $params->idGeometria
                );
                $ipat->setGeometria($geometria);
            }

            if ($params->idUtilizacion) {
                $utilizacion = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgUtilizacion')->find(
                    $params->idUtilizacion
                );
                $ipat->setUtilizacion($utilizacion);
            }

            if ($params->idCalzada) {
                $calzada = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgCalzadaCarril')->find(
                    $params->idCalzada
                );
                $ipat->setCalzada($calzada);
            }

            if ($params->idCarril) {
                $carril = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgCalzadaCarril')->find(
                    $params->idCarril
                );
                $ipat->setCarril($carril);
            }

            if ($params->idMaterial) {
                $material = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgMaterial')->find(
                    $params->idMaterial
                );
                $ipat->setMaterial($material);
            }

            if ($params->idEstadoVia) {
                $estadoVia = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgEstadoVia')->find(
                    $params->idEstadoVia
                );
                $ipat->setEstadoVia($estadoVia);
            }

            if ($params->idCondicionVia) {
                $condicionVia = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgCondicionVia')->find(
                    $params->idCondicionVia
                );
                $ipat->setCondicionVia($condicionVia);
            }

            if ($params->idIluminacion) {
                $iluminacion = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgIluminacion')->find(
                    $params->idIluminacion
                );
                $ipat->setIluminacion($iluminacion);
            }

            if ($params->idEstadoIluminacion) {
                $estadoIluminacion = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgEstadoIluminacion')->find(
                    $params->idEstadoIluminacion
                );
                $ipat->setEstadoIluminacion($estadoIluminacion);
            }

            if ($params->idVisual) {
                $visual = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgVisual')->find(
                    $params->idVisual
                );
                $ipat->setVisual($visual);
            }

            if ($params->idVisualDisminuida) {
                $visualDisminuida = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgVisualDisminuida')->find(
                    $params->idVisualDisminuida
                );
                $ipat->setVisualDisminuida($visualDisminuida);
            }

            $ipat->setOtraVisualDisminuida($params->otraVisualDisminuida);
            $ipat->setHaySemaforo($params->haySemaforo);

            if ($params->idEstadoSemaforo) {
                $estadoSemaforo = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgControlVia')->find(
                    $params->idEstadoSemaforo
                );
                $ipat->setEstadoSemaforo($estadoSemaforo);
            }

            $ipat->setSenialVertical($params->arraySenialesVerticales);
            $ipat->setSenialHorizontal($params->arraySenialesHorizontales);
            $ipat->setReductorVelocidad($params->arrayReductoresVelocidad);
            $ipat->setOtroReductorVelocidad($params->otroReductorVelocidad);

            if ($params->idDelineadorPiso) {
                $delineadorPiso = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgControlVia')->find(
                    $params->idDelineadorPiso
                );
                $ipat->setDelineadorPiso($delineadorPiso);
            }

            $ipat->setOtroDelineadorPiso($params->otroDelineadorPiso);
            $ipat->setMismoConductor($params->mismoConductor);
            $ipat->setNombresPropietario($params->nombresPropietario);
            $ipat->setApellidosPropietario($params->apellidosPropietario);


            $idTipoIdentificacion = (isset($params->tipoIdentificacionPropietario)) ? $params->tipoIdentificacionPropietario : null;
            if($idTipoIdentificacion){
                $tipoIdentificacionPropietario = $em->getRepository('JHWEBUsuarioBundle:UserCfgTipoIdentificacion')->find($idTipoIdentificacion);
                $ipat->setTipoIdentificacionPropietario($tipoIdentificacionPropietario->getNombre());
            }
            $ipat->setIdentificacionPropietario($params->identificacionPropietario);
            
            $ipat->setHayTestigo($params->hayTestigo);
            
            $idTipoIdentificacionTestigo = (isset($params->tipoIdentificacionTestigo)) ? $params->tipoIdentificacionTestigo : null;

            if ($idTipoIdentificacionTestigo){
                $tipoIdentificacionTestigo = $em->getRepository('JHWEBUsuarioBundle:UserCfgTipoIdentificacion')->find($params->tipoIdentificacionTestigo);
                $ipat->setTipoIdentificacionTestigo($tipoIdentificacionTestigo->getNombre());
            }
            
            $ipat->setIdentificacionTestigo($params->identificacionTestigo);
            
            $ipat->setDireccionResidenciaTestigo($params->direccionTestigo);
            
            $idCiudadResidenciaTestigo = (isset($params->ciudadResidenciaTestigo)) ? $params->ciudadResidenciaTestigo : null;

            if($idCiudadResidenciaTestigo) {
                $ciudadResidenciaTestigo = $em->getRepository('JHWEBConfigBundle:CfgMunicipio')->find($params->ciudadResidenciaTestigo);    
                $ipat->setCiudadResidenciaTestigo($ciudadResidenciaTestigo->getNombre());
            }
            $ipat->setTelefonoTestigo($params->telefonoTestigo);
            
            $ipat->setGradoAgente($params->gradoAgente);

            $tipoIdentificacionAgente = $em->getRepository('JHWEBUsuarioBundle:UserCfgTipoIdentificacion')->find($params->tipoIdentificacionAgente);
            $ipat->setTipoIdentificacionAgente($tipoIdentificacionAgente->getNombre());

            $ipat->setIdentificacionAgente($params->identificacionAgente);
            $ipat->setNombresAgente($params->nombresAgente);
            $ipat->setApellidosAgente($params->apellidosAgente);
            $ipat->setPlacaAgente($params->placaAgente);
            $ipat->setEntidadAgente($params->entidadAgente);
            
            $consecutivo = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatConsecutivo')->findOneBy(
                array(
                    'numero' => $params->numeroConsecutivo->numero
                )
            );

            $ipat->setConsecutivo($consecutivo);

            if ($consecutivo) {
                $consecutivo->setEstado('UTILIZADO');

                $em->persist($consecutivo);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "IPAT registrado con éxito.",
                );

            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El IPAT no pudo ser registrado.",
                );
            }

            /* $ipat->setDescripcionLesionVictima($params->descripcionLesionVictima); */
            $ipat->setObservaciones($params->observaciones);
            
            $ipat->setTotalPeaton($params->totalPeatones);
            $ipat->setTotalAcompaniante($params->totalAcompaniantes);
            $ipat->setTotalPasajero($params->totalPasajeros);
            $ipat->setTotalConductor($params->totalConductores);
            $ipat->setTotalHerido($params->totalHeridos);
            $ipat->setTotalHerido($params->totalHeridos);
            $ipat->setTotalMuerto($params->totalMuertos);
            
            $idMunicipio = (isset($params->idMunicipio)) ? $params->idMunicipio : null;

            if($idMunicipio) {
                $municipio = $em->getRepository('JHWEBConfigBundle:CfgMunicipio')->find($params->idMunicipio);
                $ipat->setMunicipioCorrespondio($municipio);
            }

            $idEntidadAccidente = (isset($params->idEntidad)) ? $params->idEntidad : null;
            if($idEntidadAccidente){
                $entidadAccidente = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgEntidadAccidente')->find($params->idEntidad);
                $ipat->setEntidadCorrespondio($entidadAccidente);
            }

            $idUnidadReceptora = (isset($params->idUnidad)) ? $params->idUnidad : null;
            if($idUnidadReceptora){
                $unidadReceptora = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgUnidadReceptora')->find($params->idUnidad);
                $ipat->setUnidadCorrespondio($unidadReceptora);
            }

            
            $ipat->setAnioCorrespondio($params->idAnio);
            $ipat->setConsecutivoCorrespondio($params->consecutivo);
            $ipat->setCorrespondio($params->correspondio);

            $ipat->setActivo(true);
            $em->persist($ipat);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 4200,
                'message' => "Registro creado con éxito.",
                'data' => $ipat
            );
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
     * Finds and displays a svIpat entity.
     *
     * @Route("/{id}", name="svipat_show")
     * @Method("GET")
     */
    public function showAction(SvIpat $svIpat)
    {

        return $this->render('svipat/show.html.twig', array(
            'svIpat' => $svIpat,
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
            $json = $request->get("data", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findOneBy(array('identificacion' => $params->identificacion));
            if ($ciudadano) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "ciudadano encontrado",
                    'data' => $ciudadano,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El ciudadano no se encuentra en la Base de Datos",
                );
                return $helpers->json($response);
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
            $json = $request->get("data", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            $placa = $em->getRepository('JHWEBVehiculoBundle:VhloCfgPlaca')->findOneBy(array('numero' => $params->placa));
            $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->findOneBy(array('placa' => $placa));
            if ($vehiculo) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Vehiculo encontrado",
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
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();            

            $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findOneBy(
                array(
                    'identificacion' => $params->identificacion
                )
            );
            $licenciaConduccion = $em->getRepository('JHWEBUsuarioBundle:UserLicenciaConduccion')->findOneBy(
                array(
                    'numero' => $params->numero,
                    'estado' => 'ACTIVA',
                    'ciudadano' => $ciudadano,
                ));

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
                    'message' => "La licencia de conducción no se encuentra registrada para este ciudadano.",
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
            $json = $request->get("data", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            $agente = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findBy(array('identificacion' => $params->identificacionAgente));
            $funcionario = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->findOneBy(array('ciudadano' => $agente));
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
            $json = $request->get("data", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            $victima = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findOneBy(array('identificacion' => $params->identificacionVictima));
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
            $json = $request->get("data", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            $testigo = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findOneBy(array('identificacion' => $params->identificacionTestigo));
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
     * @Route("/buscaripat", name="buscar_ipat")
     * @Method({"GET", "POST"})
     */
    public function buscarIpatAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();

            //====================busqueda de ipat por parametros
            $ipats = $em->getRepository('JHWEBSeguridadVialBundle:SvRegistroIpat')->getIpatByRango($params);
            
            foreach ($ipats as $key => $ipat) {
                $conductores = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatConductor')->findBy(
                    array(
                        'consecutivo' => $ipat->getConsecutivo(),
                        'activo' => true,
                    )
                );
                
                $victimas = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatVictima')->findBy(
                    array(
                        'consecutivo' => $ipat->getConsecutivo(),
                        'activo' => true,
                        )
                    );
                    
                $arrayIpats[] = array(
                    'ipat' => $ipat,
                    'conductores' => $conductores,
                    'victimas' => $victimas,
                );
            }
            
            if ($ipats) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($ipats) . " ipats encontrado(s)",
                    'data' => $arrayIpats,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No se encontraron coincidencias en la Base de Datos",
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
     * Carga ipats.
     *
     * @Route("/cargar/ipats", name="cargar_ipats")
     * @Method({"GET", "POST"})
     */

    public function cargarIpatsAction(Request $request){
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            
            $em = $this->getDoctrine()->getManager();
            
            if($params->file == null) {
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "Por favor seleccione un archivo para subir",
                    );
                } 

            if ($params->file != null) {
                foreach($params->file as $key => $dato) {    
                    //================datos ipat========================//
                    $ipat = new SvRegistroIpat();
                    
                    $consecutivo = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatConsecutivo')->findOneBy(array('numero' => $dato[0]));
                    $ipat->setConsecutivo($consecutivo);
                    
                    $gravedadAccidente = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgGravedadAccidente')->findOneBy(array('nombre' => $dato[1]));
                    $ipat->setGravedadAccidente($gravedadAccidente);
                    
                    $ipat->setHoraAccidente(new \Datetime($dato[2]));
                    $ipat->setFechaAccidente(new \Datetime($dato[3]));
                    $ipat->setDiaAccidente($dato[4]);
                    
                    $claseAccidente = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgClaseAccidente')->findOneBy(array('nombre' => $dato[5]));
                    $ipat->setClaseAccidente($claseAccidente);
                    
                    $claseChoque = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgClaseChoque')->findOneBy(array('nombre' => $dato[6]));
                    $ipat->setClaseChoque($claseChoque);
                    
                    $objetoFijo = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgObjetoFijo')->findOneBy(array('nombre' => $dato[7]));
                    $ipat->setObjetoFijo($objetoFijo);
                    $ipat->setActivo(true);
                    
                    $em->persist($ipat);
                    //=================fin datos ipat==================//
                    
                    //=================datos conductor=================//
                    $conductor = new SvIpatConductor();
                    
                    $conductor->setConsecutivo($consecutivo);
                    $conductor->setCiudadResidenciaConductor($dato[8]);
                    $conductor->setEdadConductor($dato[9]);
                    $conductor->setNombresConductor($dato[10]);
                    $conductor->setApellidosConductor($dato[11]);
                    $conductor->setSexoConductor($dato[12]);
                    $conductor->setPlacaVehiculoConductor($dato[13]);
                    $conductor->setActivo(true);

                    $em->persist($conductor);
                    //===================fin datos conductor ===========//

                    //==================datos vehiculoConductor ========//
                    $vehiculoConductor = new SvIpatVehiculo();
                    $vehiculoConductor->setConsecutivo($consecutivo);
                    $vehiculoConductor->setPlaca($dato[13]);
                    $vehiculoConductor->setClase($dato[14]);
                    $vehiculoConductor->setActivo(true);

                    $em->persist($vehiculoConductor);
                    //=============fin datos vehiculo conductor ========//
                    
                    //===================datos victima =================//
                    $victima = new SvIpatVictima();

                    $tipoVictima = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTipoVictima')->findOneBy(array('nombre' => $dato[15]));
                    $victima->setTipoVictima($tipoVictima);

                    $victima->setConsecutivo($consecutivo);
                    $victima->setEdadVictima($dato[16]);
                    $victima->setCiudadResidenciaVictima($dato[17]);
                    $victima->setNombresVictima($dato[18]);
                    $victima->setApellidosVictima($dato[19]);
                    $victima->setSexoVictima($dato[20]);
                    $victima->setPlacaVehiculoVictima($dato[21]);
                    $victima->setActivo(true);

                    $em->persist($victima);
                    //=============fin datos victima ========//
                    
                    //==================datos vehiculo victima ========//
                    $vehiculoVictima = new SvIpatVehiculo();
                    $vehiculoVictima->setConsecutivo($consecutivo);
                    $vehiculoVictima->setPlaca($dato[21]);
                    $vehiculoVictima->setClase($dato[22]);
                    $vehiculoVictima->setActivo(true);

                    $em->persist($vehiculoVictima);
                    //=============fin datos vehiculo victima ========//

                    $em->flush();
                }

                $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registros cargados con éxito",
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
     * Obtener Correspondio.
     *
     * @Route("/getCorrespondio", name="get_correspondio")
     * @Method({"GET", "POST"})
     */
    public function getCorrespondioAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        $em = $this->getDoctrine()->getManager();

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();

            $idMunicipio = (isset($params->idMunicipio)) ? $params->idMunicipio : null;
            $idEntidad = (isset($params->idEntidad)) ? $params->idEntidad : null;
            $idUnidad = (isset($params->idUnidad)) ? $params->idUnidad : null;
            $idAnio = (isset($params->idAnio)) ? $params->idAnio : null;

            $correspondio = null;

            if($idMunicipio != null && $idEntidad != null && $idUnidad  != null && $idAnio != null) {
                $municipio = $em->getRepository('JHWEBConfigBundle:CfgMunicipio')->find($idMunicipio);
                $entidad = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgEntidadAccidente')->find($params->idEntidad);
                $unidad = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgUnidadReceptora')->find($params->idUnidad);
                //$anio = $params->idAnio;
                //$consecutivo = strval($params->consecutivo);
                if(strlen(strval($params->consecutivo)) != 5){
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El consecutivo debe tener solo 5 dígitos.",
                ); 
                return $helpers->json($response);
                }
                $municipioDane = $municipio->getCodigoDane();
                if(strlen($municipio->getCodigoDane()) <= 4){
                    $municipioDane = '0' . $municipio->getCodigoDane();
                }

                $correspondio = $municipioDane . $entidad->getCodigo() . $unidad->getCodigo() . $idAnio . $params->consecutivo;
            }

            if ($correspondio) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Correspondió generado.",
                    'data' => $correspondio,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No se pudo calcular el número de correspondió. Por favor complete todos los datos para generar el número único de investigación",
                );
            }
        }
        else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Search Ipat by Consecutivo.
     *
     * @Route("/ipat/by/consecutivo", name="SVipat_by_consecutivo")
     * @Method({"GET", "POST"})
     */
    public function buscarIpatByConsecutivoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $ipat = $em->getRepository('JHWEBSeguridadVialBundle:SvIpat')->findOneByConsecutivo($params->id);

            if ($ipat) {
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Registro encontrado',
                    'data' => $ipat,
                );
            } else {
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'No tiene ipat asignado',
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorización no válida',
            );
        }
        return $helpers->json($response);
    }
}
