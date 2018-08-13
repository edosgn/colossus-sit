<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MsvCaracterizacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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
        $msvCaracterizaciones = $em->getRepository('AppBundle:MsvCaracterizacion')->findBy(array('estado'=>1));

        $response = array(
            'status' => 'succes',
            'code' => 200,
            'msj' => "listado festivos",
            'data' => $cfgFestivos,
        );
        return $helpers -> json($response);
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
                $caracterizacion->setAsistencia($params->asistencia);
                $caracterizacion->setFecha(new \Datetime($params->fecha));
                $caracterizacion->setCiudad($params->ciudad);
                $caracterizacion->setNombres($params->nombres);
                $caracterizacion->setApellidos($params->apellidos);
                $caracterizacion->setCedula($params->cedula);
                $caracterizacion->setLugarExpedicion($params->lugarExpedicion);
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
                $caracterizacion->setEstado(true);
                $em->persist($caracterizacion);
                $em->flush();
                $response = array(
                            'status' => 'success',
                            'code' => 200,
                            'msj' => "Caracterización creada con éxito",
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
                $caracterizacion->setLugarExpedicion($params->lugarExpedicion);
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
                $caracterizacion->setEstado(true);
 
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
            
            $caracterizacion->setEstado(0);
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
}
