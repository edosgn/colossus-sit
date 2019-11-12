<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCaracterizacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcaracterizacion controller.
 *
 * @Route("svcaracterizacion")
 */
class SvCaracterizacionController extends Controller
{
    /**
     * Lists all svCaracterizacion entities.
     *
     * @Route("/", name="svcaracterizacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $caracterizaciones = $em->getRepository('JHWEBSeguridadVialBundle:SvCaracterizacion')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($caracterizaciones) {
            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => count($caracterizaciones) . " registros encontrados",
                'data' => $caracterizaciones,
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a new svCaracterizacion entity.
     *
     * @Route("/new", name="svcaracterizacion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization",null);
        $authCheck = $helpers->authCheck($hash);
        if($authCheck == true){
            $json = $request->get("data",null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            
            $caracterizacion = new SvCaracterizacion();

            $caracterizacion->setPlaca($params->placa);
            
            if($params->idTipoVehiculo) {
                $tipoVehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloCfgTipoVehiculo')->find($params->idTipoVehiculo);
                $caracterizacion->setTipoVehiculo($tipoVehiculo);
            }

            if($params->idLinea) {
                $linea = $em->getRepository('JHWEBVehiculoBundle:VhloCfgLinea')->find($params->idLinea);
                $caracterizacion->setLinea($linea);
            }

            if($params->idColor) {
                $color = $em->getRepository('JHWEBVehiculoBundle:VhloCfgColor')->find($params->idColor);
                $caracterizacion->setColor($color);
            }

            $caracterizacion->setChasis($params->chasis);
            $caracterizacion->setMotor($params->motor);
            $caracterizacion->setCilindraje($params->cilindraje);
            $caracterizacion->setUsoVehiculo($params->usoVehiculo);
            $caracterizacion->setNumeroInternoDpn($params->numeroInternoDpn);
            $caracterizacion->setFechaVencimientoSoat(new \Datetime($params->fechaVencimientoSoat));
            $caracterizacion->setFechaVencimientoTecnomecanica(new \Datetime($params->fechaVencimientoTecnomecanica));
            $caracterizacion->setNumeroLicenciaTransito($params->numeroLicTransito);
            $caracterizacion->setNumeroValvulasCilindro($params->numeroValvulasCilindro);
            $caracterizacion->setCantidadCilindros($params->numeroCilindros);
            $caracterizacion->setTurbo($params->turbo);
            $caracterizacion->setTipoDireccion($params->tipoDireccion);
            $caracterizacion->setTipoTransicion($params->tipoTransicion);
            $caracterizacion->setTipoRodamientos($params->tipoRodamiento);
            $caracterizacion->setNumeroVelocidades($params->numeroVelocidades);
            $caracterizacion->setSuspensionDelantera($params->suspensionDelantera);
            $caracterizacion->setSuspensionTrasera($params->suspensionTrasera);
            $caracterizacion->setNumeroLlantas($params->numeroLlantas);
            $caracterizacion->setDimensionRines($params->dimensionRines);
            $caracterizacion->setMaterialRines($params->materialRines);
            $caracterizacion->setTipoFrenosDelanteros($params->tipoFrenosDelanteros);
            $caracterizacion->setTipoFrenosTraseros($params->tipoFrenosTraseros);
            $caracterizacion->setTiposPrevencion($params->arrayEquipoPrevencion);
            $caracterizacion->setMantenimientos($params->arrayRelacionMantenimiento);
            
            $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->findOneBy(array('nit' => $params->nit));
            $caracterizacion->setEmpresa($empresa);

            $caracterizacion->setFecha(new \Datetime($params->fecha));

            if($params->municipio){
                $ciudad = $em->getRepository('JHWEBConfigBundle:CfgMunicipio')->find($params->municipio);
                $caracterizacion->setCiudad($ciudad);
            }
            
            $caracterizacion->setNombres($params->nombres);
            $caracterizacion->setApellidos($params->apellidos);
            $caracterizacion->setCedula($params->identificacion);

            if($params->idLugarExpedicionDocumento){
                $lugarExpedicionDocumento = $em->getRepository('JHWEBConfigBundle:CfgMunicipio')->find($params->idLugarExpedicionDocumento);
                $caracterizacion->setLugarExpedicionDocumento($lugarExpedicionDocumento);
            }
            
            if($params->idGrupoSanguineo){
                $grupoSanguineo = $em->getRepository('JHWEBUsuarioBundle:UserCfgGrupoSanguineo')->find($params->idGrupoSanguineo);
                $caracterizacion->setGrupoSanguineo($grupoSanguineo);
            }


            if($params->clc){
                $clc = $em->getRepository('JHWEBUsuarioBundle:UserLcCfgCategoria')->find($params->clc);
                $caracterizacion->setClc($clc->getNombre());
            }
            $caracterizacion->setFechaVigencia(new \Datetime($params->fechaVigencia));
            $caracterizacion->setFechaNacimiento(new \Datetime($params->fechaNacimiento));
            $caracterizacion->setNivelEducativo($params->nivelEducativo);

            if($params->genero){
                $genero = $em->getRepository('JHWEBUsuarioBundle:UserCfgGenero')->find($params->genero);
                $caracterizacion->setGenero($genero);
            }
            $caracterizacion->setGrupoTrabajo($params->grupoTrabajo);
            $caracterizacion->setOtroGrupoTrabajo($params->otroGrupoTrabajo);
            $caracterizacion->setTipoContrato($params->tipoContrato);
            $caracterizacion->setOtroTipoContrato($params->otroTipoContrato);
            $caracterizacion->setExperienciaConduccion($params->experienciaConduccion);
            $caracterizacion->setAccidenteTransito($params->accidente);
            $caracterizacion->setCircunstancias($params->circunstancias);
            $caracterizacion->setIncidente($params->incidente);
            $caracterizacion->setFrecuenciaDesplazamiento($params->frecuenciaDesplazamiento);
            $caracterizacion->setVehiculoPropio($params->propioVehiculo);
            $caracterizacion->setPlanificacionDesplazamiento($params->desplazamientoPlanificado);
            $caracterizacion->setTiempoAntelacion($params->antelacion);
            $caracterizacion->setMedioDesplazamiento($params->medioDesplazamiento);
            $caracterizacion->setTrayecto($params->trayecto);
            $caracterizacion->setTiempoTrayecto($params->tiempoTrayecto);
            $caracterizacion->setKmMensualesRecorridos($params->kmMensualTrayecto);

            $caracterizacion->setPrincipalFactorRiesgo(implode(",", $params->arrayFactoresRiesgo));
            $caracterizacion->setOtroFactorRiesgo($params->otroFactorRiesgo);
            
            $caracterizacion->setCausaRiesgo(implode(",", $params->arrayCausasRiesgo));
            $caracterizacion->setOtraCausaRiesgo($params->otraCausaRiesgo);

            $caracterizacion->setRiesgo($params->riesgoPercibido);
            $caracterizacion->setPropuestaReduccionRiesgo($params->propuestaReduccion);
            $caracterizacion->setActivo(true);
            $em->persist($caracterizacion);
            $em->flush();
            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Caracterización creada con éxito",
            );
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no valida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Finds and displays a svCaracterizacion entity.
     *
     * @Route("/show", name="svcaracterizacion_show")
     * @Method("POST")
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if($authCheck == true ){
            $json = $request->get("data",null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            
            $caracterizacion = $em->getRepository('JHWEBSeguridadVialBundle:SvCaracterizacion')->find($id);
            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Caracterización encontrada",
                'data' => $caracterizacion,
            );
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message'=> "Autorización no válida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing svCaracterizacion entity.
     *
     * @Route("/edit", name="svcaracterizacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if($authCheck==true){
            $json = $request->get("data",null);
            $params = json_decode($json);  
 
            $em = $this->getDoctrine()->getManager();
            $caracterizacion = $em->getRepository('JHWEBSeguridadVialBundle:SvCaracterizacion')->find($params->id);
            if($caracterizacion != null){
                $caracterizacion->setAsistencia($params->asistencia);
                $caracterizacion->setFecha(new \Datetime($params->fecha));
                $caracterizacion->setCiudad($params->ciudad);
                $caracterizacion->setNombres($params->nombres);
                $caracterizacion->setApellidos($params->apellidos);
                $caracterizacion->setCedula($params->cedula);
                $caracterizacion->setClc($params->clc);
                $caracterizacion->setFechaVigencia($params->fechaVigencia);
                $caracterizacion->setEdad($params->edad);
                $caracterizacion->setGenero($params->ciudad);
                $caracterizacion->setGrupoTrabajo($params->grupoTrabajo);
                $caracterizacion->setTipoContrato($params->tipoContrato);
                $caracterizacion->setExperienciaConduccion($params->experienciaConduccion);
                $caracterizacion->setAccidenteTransito($params->accidenteTransito);
                $caracterizacion->setCircunstancias($params->circunstancias);
                $caracterizacion->setIncidente($params->incidente);
                $caracterizacion->setFrecuenciaDesplazamiento($params->frecuenciaDesplazamiento);
                $caracterizacion->setVehiculoPropio($params->vehiculoPropio);
                $caracterizacion->setPlanificacionDesplazamiento($params->planificacionDesplazamiento);
                $caracterizacion->setTiempoAntelacion($params->tiempoAntelacion);
                $caracterizacion->setMedioDesplazamiento($params->medioDesplazamiento);
                $caracterizacion->setTrayecto($params->trayecto);
                $caracterizacion->setTiempoTrayecto($params->tiempoTrayecto);
                $caracterizacion->setKmMensualesRecorridos($params->kmMensualesRecorridos);
                $caracterizacion->setFactorRiesgo($params->factorRiesgo);
                $caracterizacion->setCausaRiesgo($params->causaRiesgo);
                $caracterizacion->setRiesgo($params->riesgo);
                $caracterizacion->setPropuestaReduccionRiesgo($params->propuestaReduccionRiesgo);
                $caracterizacion->setActivo(true);
 
                $em->persist($caracterizacion);
                $em->flush();
 
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Caracterización editada con éxito.", 
                );
            }else{
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "La caracterización no se encuentra en la base de datos", 
                );
            }
        }
        else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no valida", 
         );
        }
     return $helpers->json($response);
    }

    /**
     * Deletes a svCaracterizacion entity.
     *
     * @Route("/delete", name="svcaracterizacion_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if($authCheck == true){
            $json = $request->get("data",null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            $caracterizacion = $em->getRepository('JHWEBSeguridadVialBundle:SvCaracterizacion')->find($params);
            
            $caracterizacion->setActivo(false);
            $em->persist($caracterizacion);
            $em->flush();
            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Caracterización eliminada con éxito", 
            );
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no valida", 
            );
        }
        return $helpers->json($response);
    }

    /**
     * Search empresa entity.
     *
     * @Route("/get/datos/registros", name="sv_caracterizacion_search_registros")
     * @Method({"GET", "POST"})
     */
    public function searchRegistrosAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();

            $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->findOneBy(
                array(
                    'nit' => $params->nit,
                    'activo' => true
                )
            );

            $registros = $em->getRepository('JHWEBSeguridadVialBundle:SvCaracterizacion')->findBy(
                array(
                    'empresa' => $empresa,
                    'activo' => true
                )
            );
            
            $response['data'] = array();

            if($empresa){
                if ($registros) {
                    $response = array(
                        'title' => 'Perfecto!',
                        'status' => 'success',
                        'code' => 200,
                        'message' => count($registros) . " registros encontrados",
                        'data' => $registros,
                    );
                } else {
                    $response = array(
                        'title' => 'Error!',
                        'status' => 'error',
                        'code' => 400,
                        'message' => "No se encontraron registros de caracterización para la empresa con NIT: " . $empresa->getNit(),
                    );
                    return $helpers->json($response);
                }
            } else {
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "La empresa no se encuentra registrada en la Base de Datos",
                );
                return $helpers->json($response);
            }
        } else {
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Search empresa entity.
     *
     * @Route("/get/datos/empresa", name="svcaracterizacion_datos_empresa")
     * @Method({"GET", "POST"})
     */
    public function buscarEmpresaAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->findOneBy(array('nit' => $params->nit));
            /* $licenciaConduccion =  $em->getRepository('AppBundle:LicenciaConduccion')->findOneBy(array('ciudadano' => $empresa->getCiudadano()));
            $edad = $this->get("app.helpers")->calculateAge($empresa->getCiudadano()->getUsuario()->getFechaNacimiento()); */ 
     
            if ($empresa) {
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "empresa encontrada",
                    'data' => $empresa,
                );
            } else {
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "La empresa no se encuentra en la Base de Datos",
                );
                return $helpers->json($response);
            }
        } else {
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida",
            );
        }
        return $helpers->json($response);
    }
}
