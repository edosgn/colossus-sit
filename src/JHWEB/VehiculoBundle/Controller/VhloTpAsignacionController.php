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
     * @Route("/new", name="vhlotpasignacion_new")
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
            $empresaTransporte = $em->getRepository('JHWEBUsuarioBundle:UserEmpresaTransporte')->find($params->idEmpresa);
            $cupo = $em->getRepository('JHWEBVehiculoBundle:VhloTpCupo')->find($params->idCupo);

            $asignacion = new VhloTpAsignacion();

            $asignacion->setEmpresaTransporte($empresaTransporte);
            $asignacion->setVehiculo($vehiculo);
            $asignacion->setCupo($cupo);
            $asignacion->setActivo(true);
            $em->persist($asignacion);
            
            //para cambiar el estado del cupo
            $cupo->setEstado('UTILIZADO');
            $em->persist($cupo);

            $em->flush();

            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Los datos han sido registrados exitosamente.",
            );

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
     * @Route("/{id}", name="vhlotpasignacion_show")
     * @Method("GET")
     */
    public function showAction(VhloTpAsignacion $vhloTpAsignacion)
    {

        return $this->render('vhlotpasignacion/show.html.twig', array(
            'vhloTpAsignacion' => $vhloTpAsignacion,
        ));
    }

    /**
     * Busca empresas por NIT, modadlidadTransporte y clase.
     *
     * @Route("/search/servicio/clase", name="userempresa_transporte_search_servicio_clase")
     * @Method({"GET", "POST"})
     */
    public function searchByServicioAndClaseAction(Request $request)
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
            
            $empresaTransporte = $em->getRepository('JHWEBUsuarioBundle:UserEmpresaTransporte')->findOneBy(
                array(
                    'empresa' => $empresa,
                    'servicio' => $params->idServicio,
                    'clase' => $params->idClase,
                    'activo' => true
                )
            );

            if($empresaTransporte){

                $cupos = $em->getRepository('JHWEBVehiculoBundle:VhloTpCupo')->findBy(
                    array(
                        'empresa' => $empresa->getId(),
                        'claseVehiculo' => $params->idClase,
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
                    'message' => "Empresa encontrada",
                    'data' => $empresaTransporte,
                    'cupos' => $arrayCupos
                );
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
     * @Route("/search/vehiculo", name="search_vehiculo")
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
            
            $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->findOneBy(
                array(
                    'placa' => $placa
                )
            );

            $propietarios = $em->getRepository('JHWEBVehiculoBundle:VhloPropietario')->findBy(
                array(
                    'vehiculo' => $vehiculo->getId(),
                    'activo' => true
                )
            );

            if ($vehiculo) {
                $response = array(
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
}
