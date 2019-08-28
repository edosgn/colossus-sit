<?php

namespace JHWEB\UsuarioBundle\Controller;

use JHWEB\UsuarioBundle\Entity\UserEmpresaTransporte;
use JHWEB\VehiculoBundle\Entity\VhloTpConvenioEmpresa;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Userempresatransporte controller.
 *
 * @Route("userempresatransporte")
 */
class UserEmpresaTransporteController extends Controller
{
    /**
     * Lists all userEmpresaTransporte entities.
     *
     * @Route("/", name="userempresatransporte_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $empresas = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->findBy(
            array(
                'tipoEmpresa' => 2,
                'activo' => true
            )
        ); 

        if ($empresas) {
            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => count($empresas) . "empresas encontradas",
                'data' => $empresas,
            );
        } else {
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "No se encontraron registros",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Create a userEmpresaTransporte entity.
     *
     * @Route("/new", name="userempresatransporte_new")
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

            $empresa  = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->find($params->idEmpresa);
            $radioAccion = $em->getRepository('JHWEBVehiculoBundle:VhloCfgRadioAccion')->find($params->idRadioAccion);
            $modalidadTransporte = $em->getRepository('JHWEBVehiculoBundle:VhloCfgModalidadTransporte')->find($params->idModalidadTransporte);
            $clase = $em->getRepository('JHWEBVehiculoBundle:VhloCfgClase')->find($params->idClase);
            $servicio = $em->getRepository('JHWEBVehiculoBundle:VhloCfgServicio')->find(2);
            
            if($params->idCarroceria){
                $carroceria = $em->getRepository('JHWEBVehiculoBundle:VhloCfgCarroceria')->find($params->idCarroceria);
                $empresaTransporte->setCarroceria($carroceria);
            }
            
            if($params->capacidadMinima > $params->capacidadMaxima) {
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "La capacidad miníma debe ser menor a la capacidad máxima",
                );
            } else {

                $empresaTransporte  = $em->getRepository('JHWEBUsuarioBundle:UserEmpresaTransporte')->findOneBy(
                    array(
                        'numeroActo' => $params->numeroActo,
                        'activo' => true
                    )
                );

                if($empresaTransporte){
                    $response = array(
                        'title' => 'Error!',
                        'status' => 'error',
                        'code' => 400,
                        'message' => "El número de acto ya se encuentra registrado.",
                    );
                } else {
                    $empresaTransporteNew  = new UserEmpresaTransporte();

                    $empresaTransporteNew->setEmpresa($empresa);
                    $empresaTransporteNew->setRadioAccion($radioAccion);
                    $empresaTransporteNew->setModalidadTransporte($modalidadTransporte);
                    $empresaTransporteNew->setServicio($servicio);
                    $empresaTransporteNew->setClase($clase);
                    $empresaTransporteNew->setNumeroActo($params->numeroActo);
                    $empresaTransporteNew->setFechaExpedicionActo(new \Datetime($params->fechaExpedicionActo));
                    $empresaTransporteNew->setFechaEjecutoriaActo(new \Datetime($params->fechaEjecutoriaActo));
                    $empresaTransporteNew->setNumeroEjecutoriaActo($params->numeroEjecutoriaActo);
                    $empresaTransporteNew->setColores($params->arrayColores);
                    $empresaTransporteNew->setMunicipios($params->arrayMunicipios);
                    $empresaTransporteNew->setCapacidadMinima($params->capacidadMinima);
                    $empresaTransporteNew->setCapacidadMaxima($params->capacidadMaxima);
                    $empresaTransporteNew->setCapacidadDisponible($params->capacidadDisponible);
                    $empresaTransporteNew->setCapacidadUtilizada(0);
                    $empresaTransporteNew->setDobleCabina($params->dobleCabina);
                    $empresaTransporteNew->setActivo(true);
                    
                    $em->persist($empresaTransporteNew);
                    
                    $convenio = $em->getRepository('JHWEBVehiculoBundle:VhloTpConvenio')->findOneBy(
                        array (
                            'numeroConvenio' => $params->numeroConvenio,
                            'activo' => true
                        )
                    );
                        
                    $convenioEmpresa = new VhloTpConvenioEmpresa();
                    
                    $convenioEmpresa->setEmpresa($empresa);
                    $convenioEmpresa->setVhloTpConvenio($convenio);
                    $convenioEmpresa->setActivo(true);
                    
                    $em->persist($convenioEmpresa);

                    $em->flush();

                    $response = array(
                        'title' => 'Perfecto!',
                        'status' => 'success',
                        'code' => 200,
                        'message' => "Registro creado con éxito",
                    );
                }
            }
        }else{
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
     * Finds and displays a userEmpresaTransporte entity.
     *
     * @Route("/{id}", name="userempresatransporte_show")
     * @Method("GET")
     */
    public function showAction(UserEmpresaTransporte $userEmpresaTransporte)
    {

        return $this->render('userempresatransporte/show.html.twig', array(
            'userEmpresaTransporte' => $userEmpresaTransporte,
        ));
    }

    /**
     * Edit a userEmpresaTransporte entity.
     *
     * @Route("/edit", name="userempresatransporte_edit")
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

            $empresaTransporte = $em->getRepository('JHWEBUsuarioBundle:UserEmpresaTransporte')->find($params->id);

            $radioAccion = $em->getRepository('JHWEBVehiculoBundle:VhloCfgRadioAccion')->find($params->idRadioAccion);
            $modalidadTransporte = $em->getRepository('JHWEBVehiculoBundle:VhloCfgModalidadTransporte')->find($params->idModalidadTransporte);
            $clase = $em->getRepository('JHWEBVehiculoBundle:VhloCfgClase')->find($params->idClase);
            $servicio = $em->getRepository('JHWEBVehiculoBundle:VhloCfgServicio')->find($params->idServicio);
            
            $idCarroceria = (isset($params->idCarroceria)) ? $params->idCarroceria : null;
            if($idCarroceria){
                $carroceria = $em->getRepository('JHWEBVehiculoBundle:VhloCfgCarroceria')->find($params->idCarroceria);
                $empresaTransporte->setCarroceria($carroceria);
            }

            if($params->capacidadMinima > $params->capacidadMaxima) {
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "La capacidad miníma debe ser menor a la capacidad máxima",
                );
            } else {
                $empresaTransporte->setRadioAccion($radioAccion);
                $empresaTransporte->setModalidadTransporte($modalidadTransporte);
                $empresaTransporte->setServicio($servicio);
                $empresaTransporte->setClase($clase);
                $empresaTransporte->setNumeroActo($params->numeroActo);
                $empresaTransporte->setFechaExpedicionActo(new \Datetime($params->fechaExpedicionActo));
                $empresaTransporte->setFechaEjecutoriaActo(new \Datetime($params->fechaEjecutoriaActo));
                $empresaTransporte->setNumeroEjecutoriaActo($params->numeroEjecutoriaActo);
                $empresaTransporte->setColores($params->arrayColores);
                $empresaTransporte->setMunicipios($params->arrayMunicipios);
                $empresaTransporte->setCapacidad($params->capacidad);
                $empresaTransporte->setCapacidadMinima($params->capacidadMinima);
                $empresaTransporte->setCapacidadMaxima($params->capacidadMaxima);
                
                $em->flush();

                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro editado con éxito",
                );
            }
        }else{
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
     * Delete a userEmpresaTransporte entity.
     *
     * @Route("/delete", name="userempresatransporte_delete")
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

            $empresaTransporte = $em->getRepository('JHWEBUsuarioBundle:UserEmpresaTransporte')->find($params->id);

            $empresaTransporte->setActivo(false);

            $em->persist($empresaTransporte);
            $em->flush();

            $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro eliminado con éxito",
                );
        } else{
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
     * Busca empresas por NIT.
     *
     * @Route("/search/nit", name="userempresa_transporte_search_nit")
     * @Method({"GET", "POST"})
     */
    public function searchByNitAction(Request $request)
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
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Empresa encontrada",
                    'data' => $empresa,
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
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Busca habilitaciones de una empresa de transporte.
     *
     * @Route("/search/habilitaciones", name="userempresa_transporte_search_habilitacion")
     * @Method({"GET", "POST"})
     */
    public function searchHabilitacionesByEmpresaAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        
        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            
            $em = $this->getDoctrine()->getManager();

            $habilitaciones = $em->getRepository('JHWEBUsuarioBundle:UserEmpresaTransporte')->findBy(
                array(
                    'empresa' => $params->idEmpresa,
                    'activo' => true
                )
            ); 

            if ($habilitaciones) {
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($habilitaciones) . " habilitaciones encontradas",
                    'data' => $habilitaciones,
                );
            } else {
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No se encontraron habilitaciones para la empresa",
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
     * Busca empresas por NIT.
     *
     * @Route("/search/empresa/vehiculo", name="userempresa_transporte_search_nit_vehiculo")
     * @Method({"GET", "POST"})
     */
    public function searchByVehiculoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        
        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            
            $asignacion = $em->getRepository('JHWEBVehiculoBundle:VhloTpAsignacion')->findOneBy(
                array(
                    'vehiculo' => $params->idVehiculo,
                    'activo' => true
                )
            ); 

            $tarjetaOperacion = $em->getRepository('JHWEBVehiculoBundle:VhloTpTarjetaOperacion')->findOneBy(
                array(
                    'vehiculo' => $params->idVehiculo,
                    'activo' => true
                )
            ); 

            if ($asignacion && $tarjetaOperacion) {
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Asignación encontrada",
                    'data' => array(
                        'asignacion' => $asignacion,
                        'empresaTransporte' => $asignacion->getEmpresaTransporte(),
                        'cupo' => $asignacion->getCupo(),
                        'nivelServicio' => $asignacion->getNivelServicio(),
                        'tarjetaOperacion' => $tarjetaOperacion
                    )
                );
            } else {
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No se encontro un cupo ni tarjeta de operación para el vehiculo",
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
     * Busca empresas por NIT.
     *
     * @Route("/search/nit/numeroActo", name="userempresa_transporte_search_nit_numeroActo")
     * @Method({"GET", "POST"})
     */
    public function searchByNitAndNumeroActoAction(Request $request)
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
                    'tipoEmpresa' => 2,
                    'activo' => true
                )
            ); 
            
            if ($empresa) {
                $empresaTransporte = $em->getRepository('JHWEBUsuarioBundle:UserEmpresaTransporte')->findOneBy(
                    array(
                        'empresa' => $empresa,
                        'numeroActo' => $params->numeroActo,
                        'activo' => true
                        )
                    ); 
                    
                if($empresaTransporte){
                    $idAsignacion = (isset($params->idAsignacion)) ? $params->idAsignacion : null;
                    if($idAsignacion != null){

                        $asignacionActual = $em->getRepository('JHWEBVehiculoBundle:VhloTpAsignacion')->find($params->idAsignacion); 

                        if($asignacionActual->getEmpresaTransporte()->getId() == $empresaTransporte->getId()){
                            $response = array(
                                'title' => 'Error!',
                                'status' => 'error',
                                'code' => 400,
                                'message' => "La empresa nueva que está buscando es la misma empresa actual a la que pertenece el vehíulo.",
                            );
                        } else {
                            $response = array(
                                'title' => 'Perfecto!',
                                'status' => 'success',
                                'code' => 200,
                                'message' => "Empresa encontrada",
                                'data' => $empresaTransporte,
                            );
                        }
                    }
                    $response = array(
                        'title' => 'Perfecto!',
                        'status' => 'success',
                        'code' => 200,
                        'message' => "Empresa de transporte encontrada",
                        'data' => $empresaTransporte,
                    );
                } else {
                    $response = array(
                        'title' => 'Error!',
                        'status' => 'error',
                        'code' => 400,
                        'message' => "Empresa de transporte público no encontrada",
                    );
                }
            } else {
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Empresa no encontrada o no es de transporte público",
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
