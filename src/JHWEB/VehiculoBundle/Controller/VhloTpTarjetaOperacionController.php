<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloTpTarjetaOperacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlotptarjetaoperacion controller.
 *
 * @Route("vhlotptarjetaoperacion")
 */
class VhloTpTarjetaOperacionController extends Controller
{
    /**
     * Lists all vhloTpTarjetaOperacion entities.
     *
     * @Route("/", name="vhlotptarjetaoperacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $tarjetasOperacion = $em->getRepository('JHWEBVehiculoBundle:VhloTpTarjetaOperacion')->findBy(
            array('activo'=>true)
        );

        $response['data'] = array();

        if ($tarjetasOperacion) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($tarjetasOperacion)." Registros encontrados", 
                'data'=> $tarjetasOperacion,
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

            $asignacion = $em->getRepository('JHWEBVehiculoBundle:VhloTpAsignacion')->find($params->idAsignacion);

            $tarjetaOperacion = new VhloTpTarjetaOperacion();
            
            $tarjetaOperacion->setAsignacion($asignacion);
            $tarjetaOperacion->setFechaVencimiento(new \Datetime($params->fechaVencimiento));
            $tarjetaOperacion->setNumeroTarjetaOperacion($params->numeroTarjetaOperacion);
            $tarjetaOperacion->setActivo(true);
            
            $em->persist($tarjetaOperacion);
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
     * Finds and displays a vhloTpTarjetaOperacion entity.
     *
     * @Route("/{id}", name="vhlotptarjetaoperacion_show")
     * @Method("GET")
     */
    public function showAction(VhloTpTarjetaOperacion $vhloTpTarjetaOperacion)
    {

        return $this->render('vhlotptarjetaoperacion/show.html.twig', array(
            'vhloTpTarjetaOperacion' => $vhloTpTarjetaOperacion,
        ));
    }

    /**
     * Edit a vhloTpTarjetaOperacion entity.
     *
     * @Route("/edit", name="vhlotptarjetaoperacion_edit")
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
            
            

            $tarjetaOperacion = $em->getRepository('JHWEBVehiculoBundle:VhloTpTarjetaOperacion')->find($params[0]->id);

            $tarjetaOperacion->setFechaVencimiento(new \Datetime($params[0]->fechaVencimiento));
            $tarjetaOperacion->setNumeroTarjetaOperacion($params[0]->numeroTarjetaOperacion);
            
            $em->persist($tarjetaOperacion);
            $em->flush();

            $response = array(
                'title' => 'Perfecto!',
                'status' => 'succces',
                'code' => 200,
                'message' => "Registro editado con éxito",
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
     * Search asignacion entity.
     *
     * @Route("/search/asignacion", name="search_asignacion")
     * @Method({"GET", "POST"})
     */
    public function searchAsignacionAction(Request $request)
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

            if(!$vehiculo){
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El vehiculo no se encuentra registrado en la base de datos.",
                );
            } else {
                if($vehiculo->getServicio()->getNombre() != 'Público') {
                    $response = array(
                        'title' => 'Error!',
                        'status' => 'error',
                        'code' => 400,
                        'message' => "El servicio del vehiculo no es público",
                    );
                } else {
                    $asignacion = $em->getRepository('JHWEBVehiculoBundle:VhloTpAsignacion')->findOneBy(
                        array(
                            'vehiculo' => $vehiculo->getId()
                        )
                    );
    
                    if ($asignacion) {
                        $response = array(
                            'title' => 'Perfecto!',
                            'status' => 'success',
                            'code' => 200,
                            'message' => "Asignación de transporte público encontrada",
                            'data' => $asignacion
                        );
                    } else {
                        $response = array(
                            'title' => 'Error!',
                            'status' => 'error',
                            'code' => 400,
                            'message' => "El vehiculo no tiene asignado cupo.",
                        );
                    }
                }
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
     * Busca empresas de transporte habilitadas por NIT.
     *
     * @Route("/search/empresaTransporte", name="vhlotpasignacion_search_nit")
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
     * Busca tarjetas de operación de una empresa de transporte.
     *
     * @Route("/search/tarjetasOperacion", name="vhlotptarjetaoperacion_search_tarjetas")
     * @Method({"GET", "POST"})
     */
    public function searchTarjetasOperacionByEmpresaAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        
        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            
            $em = $this->getDoctrine()->getManager();

            $asignaciones = $em->getRepository('JHWEBVehiculoBundle:VhloTpAsignacion')->findBy(
                array(
                    'empresaTransporte' => $params->idEmpresa,
                    'activo' => true
                )
            );

            $arrayTarjetas = null;

            foreach ($asignaciones as $key => $asignacion) {
                $tarjetasOperacion = $em->getRepository('JHWEBVehiculoBundle:VhloTpTarjetaOperacion')->findBy(
                    array(
                        'asignacion' => $asignacion->getId(),
                        'activo' => true
                    )
                );  
                
                foreach ($tarjetasOperacion as $key => $tarjetaOperacion) {
                    $arrayTarjetas [] = array(
                        $tarjetaOperacion,
                    );
                }
            }

            if ($arrayTarjetas) {
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($arrayTarjetas) . " tarjetas de operación encontradas",
                    'data' => $arrayTarjetas,
                );
            } else {
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No se encontraron tarjetas de operación asignadas para la empresa",
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
