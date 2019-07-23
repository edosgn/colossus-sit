<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MsvCaracterizacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * Msvcaracterizacion controller.
 *
 * @Route("msvcaracterizacion")
 */
class MsvCaracterizacionController extends Controller
{
    /**
     * Lists all msvCaracterizacion entities.
     *
     * @Route("/", name="msvcaracterizacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $caracterizaciones = $em->getRepository('AppBundle:MsvCaracterizacion')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($caracterizaciones) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($caracterizaciones) . " registros encontrados",
                'data' => $caracterizaciones,
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a new cfgFestivo entity.
     *
     * @Route("/new", name="msvcaracterizacion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization",null);
        $authCheck = $helpers->authCheck($hash);
        if($authCheck == true){
            $json = $request->get("json",null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();

            $caracterizacion = new MsvCaracterizacion();
            
            $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->findOneBy(array('nit' => $params->nit));
            $caracterizacion->setEmpresa($empresa);

            $caracterizacion->setFecha(new \Datetime($params->fecha));

            if($params->municipio){
                $ciudad = $em->getRepository('JHWEBConfigBundle:CfgMunicipio')->find($params->municipio);
                $caracterizacion->setCiudad($ciudad->getNombre());
            }

            $caracterizacion->setNombres($params->nombres);
            $caracterizacion->setApellidos($params->apellidos);
            $caracterizacion->setCedula($params->identificacion);
            //$caracterizacion->setLugarExpedicion($params->lugarExpedicion);
            if($params->clc){
                $clc = $em->getRepository('JHWEBUsuarioBundle:UserLcCfgCategoria')->find($params->clc);
                $caracterizacion->setClc($clc->getNombre());
            }
            $caracterizacion->setFechaVigencia(new \Datetime($params->fechaVigencia));
            $caracterizacion->setEdad($params->edad);

            if($params->genero){
                $genero = $em->getRepository('JHWEBUsuarioBundle:UserCfgGenero')->find($params->genero);
                $caracterizacion->setGenero($genero->getSigla());
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
                'status' => 'success',
                'code' => 200,
                'message' => "Caracterización creada con éxito",
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no valida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Finds and displays a msvCaracterizacion entity.
     *
     * @Route("/{id}", name="msvcaracterizacion_show")
     * @Method("POST")
     */
    public function showAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if(authCheck == true ){
            $em = $this->getDoctrine()->getManager();
            $caracterizacion = $em->getRepository('AppBundle:MsvCaracterizacion')->find($id);
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "Caracterización encontrada",
                'data' => $caracterizacion,
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj'=> "Autorización no valida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing msvCaracterizacion entity.
     *
     * @Route("/edit", name="msvcaracterizacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if($authCheck==true){
            $json = $request->get("json",null);
            $params = json_decode($json);  
 
            $em = $this->getDoctrine()->getManager();
            $caracterizacion = $em->getRepository('AppBundle:MsvCaracterizacion')->find($params->id);
            if($caracterizacion != null){
                $caracterizacion = new MsvCaracterizacion();
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
                 'status' => 'success',
                 'code' => 200,
                 'msj' => "Caracterización editada con éxito.", 
             );
            }else{
             $response = array(
                 'status' => 'error',
                 'code' => 400,
                 'msj' => "La caracterización no se encuentra en la base de datos", 
             );
            }
        }
        else{
         $response = array(
             'status' => 'error',
             'code' => 400,
             'msj' => "Autorización no valida para editar banco", 
         );
        }
     return $helpers->json($response);
    }

    /**
     * Deletes a msvCaracterizacion entity.
     *
     * @Route("/delete", name="msvcaracterizacion_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if($authCheck == true){
            $json = $request->get("json",null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            $caracterizacion = $em->getRepository('AppBundle:MsvCaracterizacion')->find($params);
            
            $caracterizacion->setActivo(false);
            $em->persist($caracterizacion);
            $em->flush();
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Caracterización eliminada con éxito", 
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorización no valida", 
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a msvCaracterizacion entity.
     *
     * @param MsvCaracterizacion $msvCaracterizacion The msvCaracterizacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MsvFestivo $msvFestivo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('msvcaracterizacion_delete', array('id' => $msvCaracterizacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Search empresa entity.
     *
     * @Route("/get/datos/registros", name="datos_registros")
     * @Method({"GET", "POST"})
     */
    public function buscarRegistrosAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            /* $empresa = $em->getRepository('AppBundle:Empresa')->findOneBy(array('nit' => $params->nit));
            $licenciaConduccion =  $em->getRepository('AppBundle:LicenciaConduccion')->findOneBy(array('ciudadano' => $empresa->getCiudadano()));
            $edad = $this->get("app.helpers")->calculateAge($empresa->getCiudadano()->getUsuario()->getFechaNacimiento()); */
            $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->findOneBy(array('nit' => $params->nit));
            $registros = $em->getRepository('AppBundle:MsvCaracterizacion')->findBy(array('empresa' => $empresa));
            
            $response['data'] = array();

            if($empresa){
                if ($registros) {
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => count($registros) . " registros encontrados",
                        'data' => $registros,
                    );
                } else {
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "No se encontraron registros de caracterización para la empresa con NIT: " . $empresa->getNit(),
                    );
                    return $helpers->json($response);
                }
            } else {
                $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "La empresa no se encuentra registrada en la Base de Datos",
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
     * Search empresa entity.
     *
     * @Route("/get/datos/empresa", name="datos_empresa")
     * @Method({"GET", "POST"})
     */
    public function buscarEmpresaAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->findOneBy(array('nit' => $params->nit));
            /* $licenciaConduccion =  $em->getRepository('AppBundle:LicenciaConduccion')->findOneBy(array('ciudadano' => $empresa->getCiudadano()));
            $edad = $this->get("app.helpers")->calculateAge($empresa->getCiudadano()->getUsuario()->getFechaNacimiento()); */ 
     
            if ($empresa) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "empresa encontrada",
                    'data' => $empresa,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "La empresa no se encuentra en la Base de Datos",
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
}
