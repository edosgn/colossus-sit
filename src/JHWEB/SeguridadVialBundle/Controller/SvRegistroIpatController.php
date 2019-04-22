<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvRegistroIpat;
use JHWEB\SeguridadVialBundle\Entity\SvIpatConductor;
use JHWEB\SeguridadVialBundle\Entity\SvIpatVictima;

use JHWEB\UsuarioBundle\Entity\UserCiudadano;
use Repository\UsuarioBundle\Entity\Usuario;
use JHWEB\VehiculoBundle\Entity\VhloVehiculo;
use JHWEB\VehiculoBundle\Entity\VhloCfgPlaca;

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

            $em = $this->getDoctrine()->getManager();

            $ipat = new SvRegistroIpat();

            if ($params[0]->datosLimitacion->idOrganismoTransito) {
                $idOrganismoTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find($params[0]->datosLimitacion->idOrganismoTransito);
                $ipat->setOrganismoTransito($idOrganismoTransito);
            }
            
            if ($params[0]->datosLimitacion->idGravedad) {
                $gravedadAccidente = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgGravedadAccidente')->find($params[0]->datosLimitacion->idGravedad);
                $ipat->setGravedadAccidente($gravedadAccidente);
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
                $claseAccidente = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgClaseAccidente')->findOneBy(
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

            if($params[0]->datosLimitacion->arrayEstadosTiempo) {
                $ipat->setEstadoTiempo($params[0]->datosLimitacion->arrayEstadosTiempo);
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

            $ipat->setSenialVertical($params[0]->datosLimitacion->arraySenialesVerticales);
            $ipat->setSenialHorizontal($params[0]->datosLimitacion->arraySenialesHorizontales);
            $ipat->setReductorVelocidad($params[0]->datosLimitacion->arrayReductoresVelocidad);
            $ipat->setOtroReductorVelocidad($params[0]->datosLimitacion->otroReductorVelocidad);

            if ($params[0]->datosLimitacion->idDelineadorPiso) {
                $delineadorPiso = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgControlVia')->find(
                    $params[0]->datosLimitacion->idDelineadorPiso
                );
                $ipat->setDelineadorPiso($delineadorPiso);
            }

            $ipat->setOtroDelineadorPiso($params[0]->datosLimitacion->otroDelineadorPiso);
            $ipat->setMismoConductor($params[0]->datosLimitacion->mismoConductor);
            $ipat->setNombresPropietario($params[0]->datosLimitacion->nombresPropietario);
            $ipat->setApellidosPropietario($params[0]->datosLimitacion->apellidosPropietario);


            $idTipoIdentificacion = (isset($params[0]->datosLimitacion->tipoIdentificacionPropietario)) ? $params[0]->datosLimitacion->tipoIdentificacionPropietario : null;
            if($idTipoIdentificacion){
                $tipoIdentificacionPropietario = $em->getRepository('JHWEBUsuarioBundle:UserCfgTipoIdentificacion')->find($idTipoIdentificacion);
                $ipat->setTipoIdentificacionPropietario($tipoIdentificacionPropietario->getNombre());
            }
            $ipat->setIdentificacionPropietario($params[0]->datosLimitacion->identificacionPropietario);

            $idTipoIdentificacionTestigo = (isset($params[0]->datosLimitacion->tipoIdentificacionTestigo)) ? $params[0]->datosLimitacion->tipoIdentificacionTestigo : null;

            if ($idTipoIdentificacionTestigo){
                $tipoIdentificacionTestigo = $em->getRepository('JHWEBUsuarioBundle:UserCfgTipoIdentificacion')->find($params[0]->datosLimitacion->tipoIdentificacionTestigo);
                $ipat->setTipoIdentificacionTestigo($tipoIdentificacionTestigo->getNombre());
            }
            
            $ipat->setIdentificacionTestigo($params[0]->datosLimitacion->identificacionTestigo);
            
            $ipat->setDireccionResidenciaTestigo($params[0]->datosLimitacion->direccionTestigo);
            
            $idCiudadResidenciaTestigo = (isset($params[0]->datosLimitacion->ciudadResidenciaTestigo)) ? $params[0]->datosLimitacion->ciudadResidenciaTestigo : null;

            if($idCiudadResidenciaTestigo) {
                $ciudadResidenciaTestigo = $em->getRepository('JHWEBConfigBundle:CfgMunicipio')->find($params[0]->datosLimitacion->ciudadResidenciaTestigo);    
                $ipat->setCiudadResidenciaTestigo($ciudadResidenciaTestigo->getNombre());
            }
            $ipat->setTelefonoTestigo($params[0]->datosLimitacion->telefonoTestigo);
            
            $ipat->setGradoAgente($params[0]->datosLimitacion->gradoAgente);

            $tipoIdentificacionAgente = $em->getRepository('JHWEBUsuarioBundle:UserCfgTipoIdentificacion')->find($params[0]->datosLimitacion->tipoIdentificacionAgente);
            $ipat->setTipoIdentificacionAgente($tipoIdentificacionAgente->getNombre());

            $ipat->setIdentificacionAgente($params[0]->datosLimitacion->identificacionAgente);
            $ipat->setNombresAgente($params[0]->datosLimitacion->nombresAgente);
            $ipat->setApellidosAgente($params[0]->datosLimitacion->apellidosAgente);
            $ipat->setPlacaAgente($params[0]->datosLimitacion->placaAgente);
            $ipat->setEntidadAgente($params[0]->datosLimitacion->entidadAgente);
            
            $consecutivo = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatConsecutivo')->findOneBy(
                array(
                    'numero' => $params[1]->consecutivo->numero
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

            /* $ipat->setDescripcionLesionVictima($params[0]->datosLimitacion->descripcionLesionVictima); */
            $ipat->setObservaciones($params[0]->datosLimitacion->observaciones);
            
            $ipat->setTotalPeaton($params[0]->datosLimitacion->totalPeatones);
            $ipat->setTotalAcompaniante($params[0]->datosLimitacion->totalAcompaniantes);
            $ipat->setTotalPasajero($params[0]->datosLimitacion->totalPasajeros);
            $ipat->setTotalConductor($params[0]->datosLimitacion->totalConductores);
            $ipat->setTotalHerido($params[0]->datosLimitacion->totalHeridos);
            $ipat->setTotalHerido($params[0]->datosLimitacion->totalHeridos);
            $ipat->setTotalMuerto($params[0]->datosLimitacion->totalMuertos);
            
            $idMunicipio = (isset($params[0]->datosLimitacion->idMunicipio)) ? $params[0]->datosLimitacion->idMunicipio : null;

            if($idMunicipio) {
                $municipio = $em->getRepository('JHWEBConfigBundle:CfgMunicipio')->find($params[0]->datosLimitacion->idMunicipio);
                $ipat->setMunicipioCorrespondio($municipio);
            }

            $idEntidadAccidente = (isset($params[0]->datosLimitacion->idEntidad)) ? $params[0]->datosLimitacion->idEntidad : null;
            if($idEntidadAccidente){
                $entidadAccidente = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgEntidadAccidente')->find($params[0]->datosLimitacion->idEntidad);
                $ipat->setEntidadCorrespondio($entidadAccidente);
            }

            $idUnidadReceptora = (isset($params[0]->datosLimitacion->idUnidad)) ? $params[0]->datosLimitacion->idUnidad : null;
            if($idUnidadReceptora){
                $unidadReceptora = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgUnidadReceptora')->find($params[0]->datosLimitacion->idUnidad);
                $ipat->setUnidadCorrespondio($unidadReceptora);
            }

            
            $ipat->setAnioCorrespondio($params[0]->datosLimitacion->idAnio);
            $ipat->setConsecutivoCorrespondio($params[0]->datosLimitacion->consecutivo);
            $ipat->setCorrespondio($params[0]->datosLimitacion->correspondio);

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
            $json = $request->get("json", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            $placa = $em->getRepository('JHWEBVehiculoBundle:VhloCfgPlaca')->findOneBy(array('numero' => $params->placa));
            $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->findOneBy(array('placa' => $placa));
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
            $licenciaConduccion = $em->getRepository('JHWEBUsuarioBundle:UserLicenciaConduccion')->findOneBy(array('numero' => $params->numero));
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
                    'message' => "La licencia de conducción no se encuentra registrada.",
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
            $json = $request->get("json", null);
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
            $json = $request->get("json", null);
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

            /* if($params->file == null) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Por favor seleccione un archivo para subir",
                );
            } */ 
            if ($params->file != null) {
                foreach($params->file as $key => $dato) {
                    
                    $ipat = new SvRegistroIpat();
                    $conductor = new SvIpatConductor();
                    /* if($ipat -> getNombresConductor() != $dato[7] && $ipat -> getApellidosConductor() != $dato[8] && $ipat -> getFechaAccidente() != $dato[2] && $ipat -> getHoraAccidente() != $dato[3]) { */
                        $consecutivo = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatConsecutivo')->findOneBy(array('numero' => $dato[0]));
                        $ipat -> setConsecutivo($consecutivo);
                        
                        $gravedad = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgGravedadAccidente')->findOneBy(array('nombre' => $dato[1]));
                        $ipat -> setGravedadAccidente($gravedad);

                        
                        $ipat -> setHoraAccidente(new \Datetime($dato[3]));
                        $ipat -> setFechaAccidente(new \Datetime($dato[4]));
                        $ipat -> setDiaAccidente($dato[4]);

                        $claseAccidente = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgClaseAccidente')->findOneBy(array('nombre' => $dato[13]));
                        $ipat -> setClaseAccidente($claseAccidente);

                        $claseChoque = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgClaseChoque')->findOneBy(array('nombre' => $dato[14]));
                        $ipat -> setClaseChoque($claseChoque);



                        //$ipat -> setNombresConductor($dato[7]);
                        //$ipat -> setApellidosConductor($dato[8]);
                        $sexoConductorFile = $em->getRepository('JHWEBUsuarioBundle:UserCfgGenero')->findOneBy(array('nombre' => $dato[6]));
                        $ipat -> setSexoConductor($sexoConductorFile->getSigla());
                        $ipat->setActivo(true);
                        
                        $tipoVictima = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTipoVictima')->findOneBy(array('nombre' => $dato[2]));
                        $ipat -> setTipoVictima($tipoVictima);
                        $ipat -> setCiudadResidenciaConductor($dato[0]);
                        $ipat -> setEdadConductor($dato[10]);

                        $em->persist($ipat);
                        $em->flush();
                    /* } */
                }
            }

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
            
            var_dump($params);
            die();

            /* foreach ($ipats as $ipatExport) {
                foreach ((array)$ipatExport->getConductores() as $key => $value) {
                    $dataNombresConductores[] = $value->nombres;
                    $dataApellidosConductores[] = $value->apellidos;
                }
                $conductoresArray = array(
                    'nombres' => $dataNombresConductores,
                    'apellidos' => $dataApellidosConductores,
                );
                foreach ((array)$ipatExport->getVictimas() as $key => $value) {
                    $dataNombresVictimas[] = $value->nombres;
                    $dataApellidosVictimas[] = $value->apellidos;
                }
                $victimasArray = array(
                    'nombres' => $dataNombresVictimas,
                    'apellidos' => $dataApellidosVictimas,
                );
            } */
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
            $json = $request->get("json", null);
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
}