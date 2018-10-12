<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvRegistroIpat;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
            //var_dump($params);
            $sedeOperativaId = (isset($params->sedeOperativa)) ? $params->sedeOperativa : null;
            $gravedadId = (isset($params->gravedad)) ? $params->gravedad : null;
            $lugar = (isset($params->lugar)) ? $params->lugar : null;

            if ($sedeOperativaId ) {
                $sedeOperativa = $em->getRepository('AppBundle:SedeOperativa')->find($sedeOperativaId);
                $ipat->setSedeOperativa($sedeOperativa);
            }

            if ($gravedadId) {
                $gravedad = $em->getRepository('AppBundle:CfgGravedad')->find($gravedadId);
                $ipat->setGravedad($gravedad);
            }

            $ipat->setLugar($lugar);
            $ipat->setFechaAccidente(new \Datetime($params->fechaAccidente));
            $ipat->setFechaLevantamiento(new \Datetime($params->fechaLevantamiento));

            if ($params->claseAccidente) {
                $claseAccidente = $em->getRepository('AppBundle:CfgClaseAccidente')->find(
                    $params->claseAccidente
                );
                $ipat->setClaseAccidente($claseAccidente);
            }

            $ipat->setOtroClaseAccidente($params->otroClaseAccidente);

            if ($params->choqueCon) {
                $choqueCon = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgChoqueCon')->find(
                    $params->choqueCon
                );
                $ipat->setChoqueCon($choqueCon);
            }

            if ($params->objetoFijo) {
                $objetoFijo = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgObjetoFijo')->find(
                    $params->objetoFijo
                );
                $ipat->setObjetoFijo($objetoFijo);
            }

            $ipat->setOtroObjetoFijo($params->otroObjetoFijo);

            if ($params->area) {
                $area = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgArea')->find(
                    $params->area
                );
                $ipat->setArea($area);
            }

            if ($params->sector) {
                $sector = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSector')->find(
                    $params->sector
                );
                $ipat->setSector($sector);
            }

            if ($params->zona) {
                $zona = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgZona')->find(
                    $params->zona
                );
                $ipat->setZona($zona);
            }

            if ($params->disenio) {
                $disenio = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgDisenio')->find(
                    $params->disenio
                );
                $ipat->setDisenio($disenio);
            }

            if ($params->estadoTiempo) {
                $estadoTiempo = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgEstadoTiempo')->find(
                    $params->estadoTiempo
                );
                $ipat->setEstadoTiempo($estadoTiempo);
            }

            if ($params->geometria) {
                $geometria = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgGeometria')->find(
                    $params->geometria
                );
                $ipat->setGeometria($geometria);
            }

            if ($params->utilizacion) {
                $utilizacion = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgUtilizacion')->find(
                    $params->utilizacion
                );
                $ipat->setUtilizacion($utilizacion);
            }

            if ($params->calzada) {
                $calzada = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgCalzadaCarril')->find(
                    $params->calzada
                );
                $ipat->setCalzada($calzada);
            }

            if ($params->carril) {
                $carril = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgCalzadaCarril')->find(
                    $params->carril
                );
                $ipat->setCarril($carril);
            }

            if ($params->material) {
                $material = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgMaterial')->find(
                    $params->material
                );
                $ipat->setMaterial($material);
            }

            if ($params->estadoVia) {
                $estadoVia = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgEstadoVia')->find(
                    $params->estadoVia
                );
                $ipat->setEstadoVia($estadoVia);
            }

            if ($params->condicionVia) {
                $condicionVia = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgCondicionVia')->find(
                    $params->condicionVia
                );
                $ipat->setCondicionVia($condicionVia);
            }

            if ($params->iluminacion) {
                $iluminacion = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgIluminacion')->find(
                    $params->iluminacion
                );
                $ipat->setIluminacion($iluminacion);
            }

            if ($params->estadoIluminacion) {
                $estadoIluminacion = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgEstadoIluminacion')->find(
                    $params->estadoIluminacion
                );
                $ipat->setEstadoIluminacion($estadoIluminacion);
            }

            if ($params->visual) {
                $visual = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgVisual')->find(
                    $params->visual
                );
                $ipat->setVisual($visual);
            }

            if ($params->visualDisminuida) {
                $visualDisminuida = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgVisualDisminuida')->find(
                    $params->visualDisminuida
                );
                $ipat->setVisualDisminuida($visualDisminuida);
            }
            
            $ipat->setPlaca($placa);
            $ipat->setPlacaRemolque($placaRemolque);
            $ipat->setNacionalidadVehiculo($nacionalidadVehiculo);
            $ipat->setMarca($marca);
            $ipat->setLinea($linea);
            $ipat->setColor($color);
            $ipat->setModelo($modelo);
            $ipat->setCarroceria($carroceria);
            $ipat->setTon($ton);
            $ipat->setPasajeros($pasajeros);
            $ipat->setNumeroLicenciaTransito($numeroLicenciaTransito);
            $ipat->setEmpresa($empresa);
            $ipat->setNitEmpresa($nitEmpresa);
            $ipat->setmatriculadoEn($matriculadoEn);
            $ipat->setInmovilizadoEn($inmovilizadoEn);
            $ipat->setADisposicionDe($aDisposicionDe);
            $ipat->setTarjetaRegistro($tarjetaRegistro);
            $ipat->setRevisionTecnomecanica($revisionTecnomecanica);
            $ipat->setCantidadAcompaniantes($cantidadAcompaniantes);
            $ipat->setPortaSoat($portaSoat);
            $ipat->setSoat($soat);
            $ipat->setNumeroPoliza($numeroPoliza);
            $ipat->setAseguradoraSoat($aseguradoraSoat);
            $ipat->setFechaVencimientoSoat(new \Datetime($fechaVencimientoSoat));
            $ipat->setPortaSeguroResponsabilidadCivil($portaSeguroResponsabilidadCivil);
            $ipat->setNumeroSeguroResponsabilidadCivil($numeroSeguroResponsabilidadCivil);
            $ipat->setAseguradoraSeguroResponsabilidadCivil($aseguradoraSeguroResponsabilidadCivil);
            $ipat->setFechaVencimientoSeguroResponsabilidadCivil(new \Datetime($fechaVencimientoSeguroResponsabilidadCivil));
            $ipat->setPortaSeguroExtracontractual($portaSeguroExtracontractual);
            $ipat->setNumeroSeguroExtracontractual($numeroSeguroExtracontractual);
            $ipat->setAseguradoraSeguroExtracontractual($aseguradoraSeguroExtracontractual);
            $ipat->setFechaVencimientoSeguroExtracontractual(new \Datetime($fechaVencimientoSeguroExtracontractual));
            $ipat->setMismoConductor($mismoConductor);
            $ipat->setNombresPropietario($nombresPropietario);
            $ipat->setApellidosPropietario($apellidosPropietario);
            $ipat->setTipoIdentificacionPropietario($tipoIdentificacionPropietario);
            $ipat->setIdentificacionPropietario($identificacionPropietario);
            $ipat->setClase($clase);
            $ipat->setServicio($servicio);
            $ipat->setModalidadTransporte($modalidadTransporte);
            $ipat->setRadioAccion($radioAccion);
            $ipat->setDescripcionDanios($descripcionDanios);
            if ($params->falla) {
                $falla = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgFalla')->find(
                    $params->falla
                );
                $ipat->setFalla($falla);
            }

            if ($params->lugarImpacto) {
                $lugarImpacto = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgLugarImpacto')->find(
                    $params->lugarImpacto
                );
                $ipat->setLugarImpacto($lugarImpacto);
            }

            $ipat->setNombresConductor($nombresConductor);
            $ipat->setApellidosConductor($apellidosConductor);
            $ipat->setTipoIdentificacionConductor($tipoIdentificacionConductor);
            $ipat->setIdentificacionConductor($identificacionConductor);
            $ipat->setNacionalidadConductor($nacionalidadConductor);
            $ipat->setFechaNacimientoConductor(new \Datetime($fechaNacimientoConductor));
            $ipat->setSexoConductor($sexoConductor);
            $ipat->setGravedadConductor($gravedadConductor);

            if ($params->gravedadConductor) {
                $gravedadConductor = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgGravedad')->find(
                    $params->gravedadConductor
                );
                $ipat->setGravedadConductor($gravedadConductor);
            }

            $ipat->setDireccionResidenciaConductor($direccionResidenciaConductor);
            $ipat->setCiudadResidenciaConductor($ciudadResidenciaConductor);
            $ipat->setTelefonoConductor($telefonoConductor);
            $ipat->setPraticoExamenConductor($praticoExamenConductor);
            $ipat->setAutorizoConductor($autorizoConductor);   

            if ($params->resultadoExamenConductor) {
                $resultadoExamenConductor = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgResultadoExamen')->find(
                    $params->resultadoExamenConductor
                );
                $ipat->setResultadoExamenConductor($resultadoExamenConductor);
            }

            if ($params->gradoExamenConductor) {
                $gradoExamenConductor = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgGradoExamen')->find(
                    $params->gradoExamenConductor
                );
                $ipat->setGradoExamenConductor($gradoExamenConductor);
            }

            $ipat->setSustanciasPsicoactivasConductor($params->sustanciasPsicoactivasConductor);
            $ipat->setPortaLicencia($params->portaLicencia);
            $ipat->setNumeroLicenciaConduccion($params->numeroLicenciaConduccion);            
            $ipat->setCategoriaLicenciaConduccion($params->categoriaLicenciaConduccion);            
            $ipat->setRestriccionConductor($params->restriccionConductor);            
            $ipat->setFechaExpedicionLicenciaConduccion(new \Datetime($params->fechaExpedicionLicenciaConduccion));            
            $ipat->setFechaVenciminetoLicenciaConduccion(new \Datetime($params->fechaVenciminetoLicenciaConduccion));            
            $ipat->setChalecoConductor($params->chalecoConductor);            
            $ipat->setCascoConductor($params->cascoConductor);            
            $ipat->setCinturonConductor($params->cinturonConductor);            
            
            if ($params->hospitalConductor) {
                $hospitalConductor = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgHospital')->find(
                    $params->hospitalConductor
                );
                $ipat-setHospitalConductor($hospitalConductor);
            }
            
            $ipat->setDescripcionLesion($params->descripcionLesion);            
            $ipat->setVictima($params->victima);            
            $ipat->setnombresVictima($params->nombresVictima);            
            $ipat->setApellidosVictima($params->apellidosVictima);            
            $ipat->setTipoIdentificacionVictima($params->tipoIdentificacionVictima);            
            $ipat->setIdentificacionVictima($params->identificacionVictima);            
            $ipat->setNacionalidadVictima($params->nacionalidadVictima);            
            $ipat->setFechaNacimientoVictima(new \Datetime($params->fechaNacimientoVictima));            
            $ipat->setSexoVictima($params->sexoVictima);            
            $ipat->setDireccionResidenciaVictima($params->direccionResidenciaVictima);            
            $ipat->setCiudadResidenciaVictima($params->ciudadResidenciaVictima);            
            $ipat->setTelefonoVictima($params->telefonoVictima);            
            
            if ($params->hospitalVictima) {
                $hospitalVictima = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgHospital')->find(
                    $params->hospitalVictima
                );
                $ipat -> setHospitalVictima($HospitalVictima);
            }
            $ipat -> setPraticoExamenVictima($praticoExamenVictima);

            if ($params->resultadoExamenVictima) {
                $resultadoExamenVictima = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgResultadoExamen')->find(
                    $params->resultadoExamenVictima
                );
                $ipat->setResultadoExamenVictima($resultadoExamenVictima);
            }

            if ($params->gradoExamenVictima) {
                $gradoExamenVictima = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgGradoExamen')->find(
                    $params->gradoExamenVictima
                );
                $ipat->setGradoExamenVictima($gradoExamenVictima);
            }

            $ipat->setSustanciasPsicoactivasVictima($params->sustanciasPsicoactivasVictima);
            $ipat->setChalecoVictima($params->chalecoVictima);            
            $ipat->setCascoVictima($params->cascoVictima);            
            $ipat->setCinturonVictima($params->cinturonVictima); 

            if ($params->tipoVictima) {
                $tipoVictima = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTipoVictima')->find(
                    $params->tipoVictima
                );
                $ipat -> setTipoVictima($tipoVictima);
            }

            if ($params->gravedadVictima) {
                $gravedadVictima = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgGravedadVictima')->find(
                    $params->gravedadVictima
                );
                $ipat -> setGravedadVictima($gravedadVictima);
            }

            $ipat->setObservaciones($observaciones);

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
}
