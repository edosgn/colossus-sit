<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvRegistroIpat;
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

            $conductores = (isset($params[2]->dataConductores)) ? $params[2]->dataConductores : null;
            $ipat->setConductores($conductores);

            
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

            $hospitalConductor = (isset($params[0]->datosLimitacion->idHospitalConductor)) ? $params[0]->datosLimitacion->idHospitalConductor : null;
            if ($hospitalConductor) {
                $hospitalConductor = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgHospital')->find(
                    $params[0]->datosLimitacion->idHospitalConductor
                );
                $ipat->setHospitalConductor($hospitalConductor);
            }

            $ipat->setDescripcionLesionConductor($params[0]->datosLimitacion->descripcionLesionConductor);

            $vehiculos = (isset($params[3]->dataVehiculos)) ? $params[3]->dataVehiculos : null;
            $ipat->setVehiculos($vehiculos);
        
            $ipat->setMismoConductor($params[0]->datosLimitacion->mismoConductor);
            $ipat->setNombresPropietario($params[0]->datosLimitacion->nombresPropietario);
            $ipat->setApellidosPropietario($params[0]->datosLimitacion->apellidosPropietario);


            $idTipoIdentificacion = (isset($params[0]->datosLimitacion->tipoIdentificacionPropietario)) ? $params[0]->datosLimitacion->tipoIdentificacionPropietario : null;
            if($idTipoIdentificacion){
                $tipoIdentificacionPropietario = $em->getRepository('JHWEBUsuarioBundle:UserCfgTipoIdentificacion')->find($idTipoIdentificacion);
                $ipat->setTipoIdentificacionPropietario($tipoIdentificacionPropietario->getNombre());
            }
            $ipat->setIdentificacionPropietario($params[0]->datosLimitacion->identificacionPropietario);

            $ipat->setDescripcionDanios($params[0]->datosLimitacion->descripcionDanios);

            $ipat->setFalla($params[0]->datosLimitacion->arrayFallas);
            $ipat->setLugarImpacto($params[0]->datosLimitacion->arrayLugaresImpacto);

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

            $ipat->setVictima($params[0]->datosLimitacion->victima);

            $victimas = (isset($params[4]->dataVictimas)) ? $params[4]->dataVictimas : null;
            $ipat->setVictimas($victimas);

            $idSexoVictima = (isset($params[0]->datosLimitacion->sexoVictima)) ? $params[0]->datosLimitacion->sexoVictima : null;
            if($idSexoVictima){
                $sexoVictima = $em->getRepository('JHWEBUsuarioBundle:UserCfgGenero')->find($idSexoVictima);
                $ipat->setSexoVictima($sexoVictima->getSigla());
            }

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

            $ipat->setDescripcionLesionVictima($params[0]->datosLimitacion->descripcionLesionVictima);
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

            $ipats = $em->getRepository('JHWEBSeguridadVialBundle:SvRegistroIpat')->getIpatByRango($params);
            
            //$ipatExport = $em->getRepository('JHWEBSeguridadVialBundle:SvRegistroIpat')->findOneBy(array('consecutivo'=>207));

            /* if($params->file == null) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Por favor seleccione un archivo para subir",
                );
            } else {
                foreach($params->file as $key => $dato) {
                    
                    $ipat = new SvRegistroIpat();
                    if($ipat -> getNombresConductor() != $dato[7] && $ipat -> getApellidosConductor() != $dato[8] && $ipat -> getFechaAccidente() != $dato[2] && $ipat -> getHoraAccidente() != $dato[3]) {
                        $consecutivo = $em->getRepository('AppBundle:MsvTConsecutivo')->findOneBy(array('consecutivo' => $dato[35]));
                        $ipat -> setConsecutivo($consecutivo);
                        $ipat -> setFechaAccidente(new \Datetime($dato[2]));
                        $ipat -> setHoraAccidente(new \Datetime($dato[3]));
                        $ipat -> setDiaAccidente($dato[4]);
                        $gravedadFile = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgGravedadAccidente')->findOneBy(array('nombre' => $dato[11]));
                        $ipat -> setGravedadAccidente($gravedadFile);
                        $tipoVictimaFile = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTipoVictima')->findOneBy(array('nombre' => $dato[13]));
                        $ipat -> setTipoVictima($tipoVictimaFile);
                        //$ipat -> setNombresConductor($dato[7]);
                        //$ipat -> setApellidosConductor($dato[8]);
                        $ipat -> setCiudadResidenciaConductor($dato[0]);
                        $sexoConductorFile = $em->getRepository('JHWEBUsuarioBundle:UserCfgGenero')->findOneBy(array('nombre' => $dato[6]));
                        $ipat -> setSexoConductor($sexoConductorFile->getSigla());
                        $ipat -> setEdadConductor($dato[10]);
                        $claseAccidenteFile = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgClaseAccidente')->findOneBy(array('nombre' => $dato[12]));
                        $ipat -> setClaseAccidente($claseAccidenteFile);
                        $ipat->setActivo(true);

                        $conductorIpat = new SvRegistroIpat();
                        $dataConductores = array(
                            'nombres' => $dato[7],
                            'apellidos' => $dato[8],
                            'sexo' => $sexoConductorFile->getSigla(),
                            'ciudad residencia' => $dato[0],
                        );
                        $ipat->setConductores($dataConductores);
                        $em->persist($ipat);
                        $em->flush();
                    }
                }
            }

            $conductoresArray = false;
            $victimassArray = false;
            $dataNombresConductores = null;
            $dataApellidosConductores = null;
            $dataNombresVictimas = null;
            $dataApellidosVictimas = null; */

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
                    'data' => $ipats,
                    /* 'conductores' => $conductoresArray,
                    'victimas' => $victimasArray, */
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
     * Exporta ipats total.
     *
     * @Route("/buscaripatexport", name="buscar_ipat_export")
     * @Method({"GET", "POST"})
     */
    public function buscarIpatExportAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        $em = $this->getDoctrine()->getManager();

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();

            $ipats = $em->getRepository('JHWEBSeguridadVialBundle:SvRegistroIpat')->findAll();    

            if($params->file == null) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Por favor seleccione un archivo para subir",
                );
            } else {
                foreach($params->file as $key => $dato) {

                        $response = array(
                            'status' => 'success',
                            'code' => 200,
                            'message' => count($ipats) . " ipats encontrado(s)",
                            'data' => $ipats,
                        );
               
                    
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
                            $ipat -> setNombresVictima($dato[7]);
                            $ipat -> setApellidosVictima($dato[8]);
                            $ipat -> setCiudadResidenciaConductor($dato[0]);
                            $sexoConductorFile = $em->getRepository('JHWEBUsuarioBundle:UserCfgGenero')->findOneBy(array('nombre' => $dato[6]));
                            $ipat -> setSexoConductor($sexoConductorFile->getSigla());
                            $ipat -> setEdadConductor($dato[10]);
                            $claseAccidenteFile = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgClaseAccidente')->findOneBy(array('nombre' => $dato[12]));
                            $ipat -> setClaseAccidente($claseAccidenteFile);
                            $ipat->setActivo(true);

                            /* $dataConductores = array(
                                'nombres' => $dato[7],
                                'apellidos' => $dato[8],
                                'sexo' => $sexoConductorFile->getSigla(),
                                'ciudad residencia' => $dato[0],
                            );
                            $ipat->setConductores($dataConductores);
                            $dataVictimas = array(
                                'nombres' => $dato[7],
                                'apellidos' => $dato[8],
                                'sexo' => $sexoConductorFile->getSigla(),
                                'ciudad residencia' => $dato[0],
                            );
                            $ipat->setVictimas($dataVictimas); */

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
                    'message' => "correspondió generado.",
                    'data' => $correspondio,
                );
            } else {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
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
     * Creates a new ciudadanoIpat entity.
     *
     * @Route("/newCiudadanoIpat", name="ciudadano_ipat_new")
     * @Method({"GET", "POST"})
     */
    public function newCiudadanoIpatAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $response = null;
        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $identificacionConductor = (isset($params->identificacionConductor)) ? $params->identificacionConductor : null;
            $conductor = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findOneBy(array('identificacion' => $identificacionConductor));
            if($conductor){
                $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "El ciudadano ya se encuentra registrado en la Base de Datos",
                );
                return $helpers->json($response);
            } else{
                $ciudadano = new UserCiudadano();

                $tipoIdentificacionConductor = (isset($params->tipoIdentificacionConductor)) ? $params->tipoIdentificacionConductor : null;

                if($tipoIdentificacionConductor != null){
                    $tipoIdentificacion = $em->getRepository('JHWEBUsuarioBundle:UserCfgTipoIdentificacion')->find($tipoIdentificacionConductor);
                    $ciudadano->setTipoIdentificacion($tipoIdentificacion);
                } else {
                    $response = 
                    array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "El tipo de identificación del conductor es un campo obligatorio",
                    );
                }

                if($params->fechaNacimientoConductor != null){
                    $fechaNacimientoDateTime = new \DateTime($params->fechaNacimientoConductor);
                    $ciudadano->setFechaNacimiento($fechaNacimientoDateTime);
                } else {
                    $response = 
                    array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "La fecha de nacimiento del conductor es un campo obligatorio",
                    );
                }
                
                $ciudadResidenciaConductor = (isset($params->ciudadResidenciaConductor)) ? $params->ciudadResidenciaConductor : null;
                if($ciudadResidenciaConductor != null){
                    $municipioResidenciaConductor = $em->getRepository('JHWEBConfigBundle:CfgMunicipio')->find($ciudadResidenciaConductor);
                    $ciudadano->setMunicipioResidencia($municipioResidenciaConductor);
                } 
                $sexo = (isset($params->sexoConductor)) ? $params->sexoConductor : null;

                if($sexo != null) {
                    $sexoConductor = $em->getRepository('JHWEBUsuarioBundle:UserCfgGenero')->find($sexo);
                    $ciudadano->setGenero($sexoConductor);
                }
                
                if($params->direccionResidenciaConductor != null){
                    $ciudadano->setDireccionPersonal($params->direccionResidenciaConductor);
                }else{
                    $response = 
                    array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "La dirección del conductor es un campo obligatorio",
                    );
                }
            
                if($params->nombresConductor){
                    $ciudadano->setPrimerNombre($params->nombresConductor);
                } else {
                    $response = 
                    array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "Los nombres del conductor es un campo obligatorio",
                    );
                }
                if($params->apellidosConductor){
                    $ciudadano->setPrimerApellido($params->apellidosConductor);
                } else {
                    $response = 
                    array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "Los apellidos del conductor es un campo obligatorio",
                    );
                }
                if($params->identificacionConductor){
                    $ciudadano->setIdentificacion($params->identificacionConductor);
                } else {
                    $response = 
                    array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "La identificación del conductor es un campo obligatorio",
                    );
                }
                $ciudadano->setTelefono($params->telefonoConductor);

                $ciudadano->setActivo(true);
                $ciudadano->setEnrolado(false);

                $usuario = new Usuario();
                
                $usuario->setCorreo('null');
                $usuario->setActivo(true);
                $usuario->setRole("ROLE_USER");
                $password = $params->nombresConductor[0] . $params->apellidosConductor[0] . $params->identificacionConductor;
                $pwd = hash('sha256', $password);
                $usuario->setPassword($pwd);
                    
                    
                $usuario->setCreatedAt();
                $usuario->setUpdatedAt();     
                $usuario->setCiudadano($ciudadano);
                    
                $ciudadano->setUsuario($usuario);

                $em->persist($usuario);
                $em->persist($ciudadano);
                    
                $em->flush();
                        
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Ciudadano creado con éxito para IPAT.",
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
     * Creates a new victimaIpat entity.
     *
     * @Route("/newVictimaIpat", name="victima_ipat_new")
     * @Method({"GET", "POST"})
     */
    public function newVictimaIpatAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $response = null;
        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $identificacionVictima = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findOneBy(array('identificacion' => $params->identificacionVictima));
            if($identificacionVictima){
                $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "El ciudadano ya se encuentra registrado en la Base de Datos",
                );
                return $helpers->json($response);
            } else{
                $tipoIdentificacion = $em->getRepository('JHWEBUsuarioBundle:UserCfgTipoIdentificacion')->find($params->tipoIdentificacionVictima);
                $fechaNacimientoDateTime = new \DateTime($params->fechaNacimientoVictima);

                $municipioResidenciaVictima = $em->getRepository('JHWEBConfigBundle:CfgMunicipio')->find($params->ciudadResidenciaVictima);
                $sexoVictima = $em->getRepository('JHWEBUsuarioBundle:UserCfgGenero')->find($params->sexoVictima);

                $ciudadano = new UserCiudadano();
                $ciudadano->setPrimerNombre($params->nombresVictima);
                $ciudadano->setPrimerApellido($params->apellidosVictima);
                $ciudadano->setTipoIdentificacion($tipoIdentificacion);
                $ciudadano->setIdentificacion($params->identificacionVictima);
                $ciudadano->setTelefono($params->telefonoVictima);
                $ciudadano->setFechaNacimiento($fechaNacimientoDateTime);
                $ciudadano->setMunicipioResidencia($municipioResidenciaVictima);
                $ciudadano->setDireccionPersonal($params->direccionResidenciaVictima);
                $ciudadano->setGenero($sexoVictima);
                $ciudadano->setActivo(true);
                $ciudadano->setEnrolado(false);

                $usuario = new Usuario();
                
                $usuario->setCorreo('null');
                $usuario->setActivo(true);
                $usuario->setRole("ROLE_USER");
                $password = $params->nombresConductor[0] . $params->apellidosConductor[0] . $params->identificacionConductor;
                $pwd = hash('sha256', $password);
                $usuario->setPassword($pwd);                    
                $usuario->setCreatedAt();
                $usuario->setUpdatedAt();     
                $usuario->setCiudadano($ciudadano);
                    
                $ciudadano->setUsuario($usuario);

                $em->persist($usuario);
                $em->persist($ciudadano);
                    
                $em->flush();
                        
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Ciudadano creado con éxito para IPAT.",
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
     * Creates a new vehiculoIpat entity.
     *
     * @Route("/newVehiculoIpat", name="vehiculo_ipat_new")
     * @Method({"GET", "POST"})
     */
    public function newVehiculoIpatAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $response = null;
        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager(); 

            $cfgPlaca = $em->getRepository('JHWEBVehiculoBundle:VhloCfgPlaca')->findOneBy(array('numero' => $params->placa));
            if($cfgPlaca) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El vehiculo ya se encuentra registrado en la Base de datos",
                );
            } else {
                $nacionalidadVehiculo = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgNacionalidad')->findOneBy(array('id' => $params->nacionalidadVehiculo));
                $marca = $em->getRepository('JHWEBVehiculoBundle:VhloCfgMarca')->findOneBy(array('id' => $params->marca));
                $linea = $em->getRepository('JHWEBVehiculoBundle:VhloCfgLinea')->find($params->linea);
                $color = $em->getRepository('JHWEBVehiculoBundle:VhloCfgColor')->findOneBy(array('id' => $params->color));
                $carroceria = $em->getRepository('JHWEBVehiculoBundle:VhloCfgCarroceria')->findOneBy(array('id' => $params->carroceria));
                $clase = $em->getRepository('JHWEBVehiculoBundle:VhloCfgClase')->findOneBy(array('id' => $params->clase));
                $servicio = $em->getRepository('JHWEBVehiculoBundle:VhloCfgServicio')->findOneBy(array('id' => $params->servicio));
                $municipio = $em->getRepository('JHWEBConfigBundle:CfgMunicipio')->findOneBy(array('nombre' => $params->matriculadoEn));
                $modalidadTransporte = $em->getRepository('JHWEBVehiculoBundle:VhloCfgModalidadTransporte')->findOneBy(array('id' => $params->modalidadTransporte));
                
                $idRadioAccion = (isset($params->radioAccion)) ? $params->radioAccion : null;
                $radioAccion = $em->getRepository('JHWEBVehiculoBundle:VhloCfgRadioAccion')->findOneBy(array('id' => $idRadioAccion));
                
                $vehiculo = new VhloVehiculo();
                
                $placa = new VhloCfgPlaca();
                $placa->setNumero($params->placa);
                $placa->setEstado('FABRICADA');

                $em->persist($placa);
                $em->flush();

                $vehiculo->setPlaca($placa);
                $vehiculo->setNacionalidad($nacionalidadVehiculo);
                $vehiculo->setLinea($linea);
                $vehiculo->setColor($color);
                $vehiculo->setModelo($params->modelo);
                $vehiculo->setCarroceria($carroceria);
                $vehiculo->setClase($clase);
                $vehiculo->setServicio($servicio);
                $vehiculo->setMunicipio($municipio);
                $vehiculo->setModalidadTransporte($modalidadTransporte);
                $vehiculo->setRadioAccion($radioAccion);
                $vehiculo->setNumeroPasajeros($params->pasajeros);
                $vehiculo->setActivo(true);

                $em->persist($vehiculo);
                $em->flush();
                
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Vehiculo registrado con éxito para IPAT.",
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