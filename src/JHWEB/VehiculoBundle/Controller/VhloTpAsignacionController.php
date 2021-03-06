<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloTpAsignacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlotpasignacion controller.
 *
 * @Route("vhlotpasignacion")
 */
class VhloTpAsignacionController extends Controller
{
    /**
     * Lists all vhloTpAsignacion entities.
     *
     * @Route("/", name="vhlotpasignacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $asignaciones = $em->getRepository('JHWEBVehiculoBundle:VhloTpAsignacion')->findBy(
            array('activo'=>true)
        );

        $response['data'] = array();

        if ($asignaciones) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($asignaciones)." Registros encontrados", 
                'data'=> $asignaciones,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Register a vhloTpAsignacion entity.
     *
     * @Route("/new2", name="vhlotpasignacion_new2")
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

            $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->find($params->idVehiculo);
            $empresaTransporte = $em->getRepository('JHWEBUsuarioBundle:UserEmpresaTransporte')->find($params->idEmpresaHabilitadaRango);
            $cupo = $em->getRepository('JHWEBVehiculoBundle:VhloTpCupo')->find($params->idCupo);
            $nivelServicio = $em->getRepository('JHWEBVehiculoBundle:VhloCfgNivelServicio')->find($params->idNivelServicio);

            $vehiculoCupo= $em->getRepository('JHWEBVehiculoBundle:VhloTpAsignacion')->findOneBy(
                array(
                    'vehiculo' => $vehiculo->getId(),
                    'activo' => true
                )
            );
            
            if($vehiculoCupo){
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El vehiculo ya tiene asignado un cupo.",
                );
            } else {
                //calcula la cantidad de capacidad utilizada por la empresa
                if($empresaTransporte->getCapacidadUtilizada() == 0) {
                    if($empresaTransporte->getCapacidadDisponible() < $vehiculo->getNumeroPasajeros()) {
                        $response = array(
                            'title' => 'Error!',
                            'status' => 'error',
                            'code' => 400,
                            'message' => "La capacidad disponible es ". $empresaTransporte->getCapacidadDisponible() . " que es menor a la capacidad del vehículo que intenta asignar el cupo.",
                        );
                    } else {
                        $empresaTransporte->setCapacidadUtilizada($vehiculo->getNumeroPasajeros());
                        $empresaTransporte->setCapacidadDisponible($empresaTransporte->getCapacidadMaxima()-$vehiculo->getNumeroPasajeros());
                        
                        $em->persist($empresaTransporte);

                        //crea la asignacion
                        $asignacion = new VhloTpAsignacion();
            
                        $asignacion->setEmpresaTransporte($empresaTransporte);
                        $asignacion->setVehiculo($vehiculo);
                        $asignacion->setCupo($cupo);
                        $asignacion->setNivelServicio($nivelServicio);
                        $asignacion->setActivo(true);
                        $em->persist($asignacion);
                        
                        //para cambiar el estado del cupo
                        $cupo->setEstado('UTILIZADO');
                        $em->persist($cupo);

                        $response = array(
                            'title' => 'Perfecto!',
                            'status' => 'success',
                            'code' => 200,
                            'message' => "Los datos han sido registrados exitosamente.",
                        );
                    }
                } else {
                    $capacidadUtilizada = 0;

                    if($empresaTransporte->getCapacidadDisponible() < $vehiculo->getNumeroPasajeros()) {
                        $response = array(
                            'title' => 'Error!',
                            'status' => 'error',
                            'code' => 400,
                            'message' => "La capacidad disponible es ". $empresaTransporte->getCapacidadDisponible() . " que es menor a la capacidad del vehículo que intenta asignar el cupo.",
                        );
                    } else {
                        $capacidadUtilizada = $empresaTransporte->getCapacidadUtilizada() + $vehiculo->getNumeroPasajeros();
                        $empresaTransporte->setCapacidadUtilizada($capacidadUtilizada);

                        $empresaTransporte->setCapacidadDisponible($empresaTransporte->getCapacidadMaxima() - $capacidadUtilizada);

                        $em->persist($empresaTransporte);

                        //crea la asignacion
                        $asignacion = new VhloTpAsignacion();
        
                        $asignacion->setEmpresaTransporte($empresaTransporte);
                        $asignacion->setVehiculo($vehiculo);
                        $asignacion->setCupo($cupo);
                        $asignacion->setNivelServicio($nivelServicio);
                        $asignacion->setActivo(true);
                        $em->persist($asignacion);
                        
                        //para cambiar el estado del cupo
                        $cupo->setEstado('UTILIZADO');
                        $em->persist($cupo);
                        
                        $response = array(
                            'title' => 'Perfecto!',
                            'status' => 'success',
                            'code' => 200,
                            'message' => "Los datos han sido registrados exitosamente.",
                        );
                    }
                }
                $em->flush();
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
     * Finds and displays a vhloTpAsignacion entity.
     *
     * @Route("/show", name="vhlotpasignacion_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $asignacion = $em->getRepository('JHWEBVehiculoBundle:VhloTpAsignacion')->find($params->id);
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro Encontrado", 
                'data'=> $asignacion,
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
            );
        }
        return $helpers->json($response);
    }
    
    /**
     * Finds and edit a vhloTpAsignacion entity.
     *
     * @Route("/edit", name="vhlotpasignacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $asignacion = $em->getRepository('JHWEBVehiculoBundle:VhloTpAsignacion')->find($params->asignacion->id);
            $cupo = $em->getRepository('JHWEBVehiculoBundle:VhloTpCupo')->find($params->idCupoAnterior);
            
            $cupoNew = $em->getRepository('JHWEBVehiculoBundle:VhloTpCupo')->find($params->asignacion->idCupo);

            if($asignacion) {
                if($cupo && $cupoNew) {
                    $cupo->setEstado('DISPONIBLE');
                    $cupoNew->setEstado('UTILIZADO');
                }

                $asignacion->setCupo($cupoNew);
    
                $em->persist($asignacion);
                $em->persist($cupo);
                $em->persist($cupoNew);
                $em->flush();
    
                $response = array(
                    'title' => 'Perfecto',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro editado con éxito.", 
                );
            } else {
                $response = array(
                    'title' => 'Error',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Registro no encontrado.", 
                );
            }

        } else {
            $response = array(
                'title' => 'Error',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida", 
            );
        }
        return $helpers->json($response);
    }

    /**
     * Finds and delete a vhloTpAsignacion entity.
     *
     * @Route("/delete", name="vhlotpasignacion_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $asignacion = $em->getRepository('JHWEBVehiculoBundle:VhloTpAsignacion')->find($params->id);

            $asignacion->setActivo(false);

            $em->persist($asignacion);
            $em->flush();

            $response = array(
                    'title' => 'Perfecto',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro Encontrado", 
                    'data'=> $asignacion,
                );
            }else{
                $response = array(
                    'title' => 'Error',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorización no válida", 
                );
        }
        return $helpers->json($response);
    }

    /**
     * Busca cupos disponibles por empresa de transporte
     *
     * @Route("/search/cupos/disponibles", name="vhlotpasignacion_search_cupos_disponibles")
     * @Method({"GET", "POST"})
     */
    public function searchCuposDisponiblesByEmpresaAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        
        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            
            $em = $this->getDoctrine()->getManager();
            
            $cupos = $em->getRepository('JHWEBVehiculoBundle:VhloTpCupo')->findBy(
                array(
                    'empresaTransporte' => $params->idEmpresa,
                    'estado' => 'DISPONIBLE',
                    'activo' => true
                )
            );

            $arrayCupos = null;

            foreach ($cupos as $key => $cupo) {
                $arrayCupos[$key] = array(
                    'value' => $cupo->getId(),
                    'label' => $cupo->getNumero(),
                );
            }

            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Cupos disponibles encontrados",
                'data' => $arrayCupos,
                'cupos' => $arrayCupos
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
     * Search vehiculo entity.
     *
     * @Route("/search/vehiculo", name="vhlotpasignacion_search_vehiculo")
     * @Method({"GET", "POST"})
     */
    public function searchVehiculoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            
            $em = $this->getDoctrine()->getManager();
            
            $placa = $em->getRepository('JHWEBVehiculoBundle:VhloCfgPlaca')->findOneBy(
                array(
                    'numero' => $params->placa
                )
            );

            $clase = $em->getRepository('JHWEBVehiculoBundle:VhloCfgClase')->find($params->idClase);
            
            if($placa){
                $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->findOneBy(
                    array(
                        'placa' => $placa,
                        'clase' => $clase->getId(),
                        'servicio' => 2
                    )
                );

                if ($vehiculo) {
                    $propietarios = $em->getRepository('JHWEBVehiculoBundle:VhloPropietario')->findBy(
                        array(
                            'vehiculo' => $vehiculo->getId(),
                            'activo' => true
                        )
                    );
                    $response = array(
                        'title' => 'Perfecto!',
                        'status' => 'success',
                        'code' => 200,
                        'message' => "Vehiculo encontrado",
                        'data' => array(
                            'vehiculo' => $vehiculo,
                            'propietarios' => $propietarios
                        )
                    );
                } else { 
                    $response = array(
                        'title' => 'Error!',
                        'status' => 'error',
                        'code' => 400,
                        'message' => "Puede que el vehículo no pertenezca a transporte público, o su clase no conincide con la
                                    empresa habilitada para asignar cupo.",
                    );
                }
            } else {
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No se encuentra la placa en la Base de Datos ",
                );
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
     * Busca empresas de transporte habilitadas por NIT.
     *
     * @Route("/search/empresaTransporte", name="vhlotpasignacion_search_nit2")
     * @Method({"GET", "POST"})
     */
    public function searchEmpresaTransporteByNitAction(Request $request)
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
                    'nit' => $params,
                    'tipoEmpresa' => 2,
                    'activo' => true
                )
            ); 

            if ($empresa) {
                $empresaHabilitada = $em->getRepository('JHWEBUsuarioBundle:UserEmpresaTransporte')->findOneBy(
                    array(
                        'empresa' => $empresa,
                        'activo' => true
                    )
                );

                if($empresaHabilitada) {
                    $response = array(
                        'title' => 'Perfecto!',
                        'status' => 'success',
                        'code' => 200,
                        'message' => "Empresa encontrada",
                        'data' => $empresaHabilitada,
                    );

                } else {
                    $response = array(
                        'title' => 'Error!',
                        'status' => 'error',
                        'code' => 400,
                        'message' => "No se ha creado rangos para que la empresa pueda asignar cupos.",
                    );
                }
            } else {
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Empresa no encontrada",
                );
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
     * Busca cupos de una empresa de transporte.
     *
     * @Route("/search/cupos", name="vhlotpasignacion_search_cupos")
     * @Method({"GET", "POST"})
     */
    public function searchCuposByEmpresaAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        
        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            
            $em = $this->getDoctrine()->getManager();

            $cupos = $em->getRepository('JHWEBVehiculoBundle:VhloTpAsignacion')->findBy(
                array(
                    'empresaTransporte' => $params->idEmpresa,
                    'activo' => true
                )
            ); 

            if ($cupos) {
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($cupos) . " cupos encontrados",
                    'data' => $cupos,
                );
            } else {
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No se encontraron cupos asignados para la empresa",
                );
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
     * Busca cupos por vehiculo.
     *
     * @Route("/search/cupo/vehiculo", name="vhlotpasignacion_by_vehiculo")
     * @Method({"GET", "POST"})
     */
    public function searchCuposByVehiculoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        
        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            
            $em = $this->getDoctrine()->getManager();

            $cupo = $em->getRepository('JHWEBVehiculoBundle:VhloTpAsignacion')->findOneBy(
                array(
                    'vehiculo' => $params->idVehiculo,
                    'activo' => true
                )
            );

            if ($cupo) {
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado",
                    'data' => $cupo,
                );
            } else {
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No se encontraron cupos para el vehiculo",
                );
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
