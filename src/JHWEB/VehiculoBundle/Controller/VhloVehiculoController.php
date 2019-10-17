<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloVehiculo;
use JHWEB\VehiculoBundle\Entity\VhloCfgPlaca;
use JHWEB\UsuarioBundle\Entity\UserLicenciaTransito;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * Vhlovehiculo controller.
 *
 * @Route("vhlovehiculo")
 */
class VhloVehiculoController extends Controller
{
    /**
     * Lists all vhloVehiculo entities.
     *
     * @Route("/", name="vhlovehiculo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $vehiculos = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->findBy(
            array('activo'=>true)
        );

        $response['data'] = array();

        if ($vehiculos) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($vehiculos)." Registros encontrados", 
                'data'=> $vehiculos,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new vhloVehiculo entity.
     *
     * @Route("/new", name="vhlovehiculo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            
            $cfgPlaca = $em->getRepository('JHWEBVehiculoBundle:VhloCfgPlaca')->findOneBy(array('numero' => $params->placa));

            $organismoTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find($params->idOrganismoTransito);

            
            if (!$cfgPlaca) {
                $vehiculo = new VhloVehiculo();

                if ($params->idClase) {
                    $clase = $em->getRepository('JHWEBVehiculoBundle:VhloCfgClase')->find($params->idClase);
                }

                if (isset($params->placa) && $params->placa) {
                    $placa = new VhloCfgPlaca();
                    $placa->setNumero(strtoupper($params->placa));
                    $placa->setTipoVehiculo($clase->getTipoVehiculo());
    
                    $placa->setOrganismoTransito($organismoTransito);

                    $servicio = $em->getRepository('JHWEBVehiculoBundle:VhloCfgServicio')->find($params->idServicio);
                    $placa->setServicio($servicio);

                    if ($params->tipoMatricula == 'RADICADO') {
                        $placa->setEstado('PREREGISTRADA');
                        $em->persist($placa);

                        $em->flush();
                    } else {
                        $placa->setEstado('ASIGNADA');
                        $em->persist($placa);

                        $em->flush();
                    }

                    $vehiculo->setPlaca($placa);
                }

                $fechaFactura = $params->fechaFactura;
                $fechaFactura = new \DateTime($fechaFactura);
                
                $vehiculo->setOrganismoTransito($organismoTransito);
                $vehiculo->setClase($clase);
                
                $vehiculo->setNumeroFactura($params->numeroFactura);
                $vehiculo->setfechaFactura($fechaFactura);
                $vehiculo->setValor($params->valor);

                $vehiculo->setSerie(mb_strtoupper($params->serie, 'utf-8'));
                $vehiculo->setVin(mb_strtoupper($params->vin, 'utf-8'));
                $vehiculo->setChasis(mb_strtoupper($params->chasis, 'utf-8'));
                $vehiculo->setMotor(mb_strtoupper($params->motor, 'utf-8'));
                $vehiculo->setCilindraje($params->cilindraje);
                $vehiculo->setModelo($params->modelo);
                $vehiculo->setTipoMatricula($params->tipoMatricula);
                $vehiculo->setPignorado(false);
                $vehiculo->setCancelado(false);

                if ($params->numeroManifiesto) {
                    $vehiculo->setNumeroManifiesto($params->numeroManifiesto);
                }

                if ($params->fechaManifiesto) {
                    $vehiculo->setFechaManifiesto(
                        new \Datetime($params->fechaManifiesto)
                    );
                }

                if ($params->numeroPasajeros) {
                    $vehiculo->setNumeroPasajeros($params->numeroPasajeros);
                }

                if ($params->capacidadCarga) {
                    $vehiculo->setCapacidadCarga($params->capacidadCarga);
                }

                if ($params->numeroEjes) {
                    $vehiculo->setNumeroEjes($params->numeroEjes);
                }

                $color = $em->getRepository('JHWEBVehiculoBundle:VhloCfgColor')->find(
                    $params->idColor
                );
                $vehiculo->setColor($color);

                $linea = $em->getRepository('JHWEBVehiculoBundle:VhloCfgLinea')->find(
                    $params->idLinea
                );
                $vehiculo->setLinea($linea);

                $carroceria = $em->getRepository('JHWEBVehiculoBundle:VhloCfgCarroceria')->find($params->idCarroceria);
                $vehiculo->setCarroceria($carroceria);

                $combustible = $em->getRepository('JHWEBVehiculoBundle:VhloCfgCombustible')->find($params->idCombustible);
                $vehiculo->setCombustible($combustible);

                $servicio = $em->getRepository('JHWEBVehiculoBundle:VhloCfgServicio')->find($params->idServicio);
                $vehiculo->setServicio($servicio);

                if ($params->idRadioAccion) {
                    $radioAccion = $em->getRepository('JHWEBVehiculoBundle:VhloCfgRadioAccion')->find($params->idRadioAccion);
                    $vehiculo->setRadioAccion($radioAccion);
                }

                if ($params->idModalidadTransporte) {
                    $modalidadTransporte = $em->getRepository('JHWEBVehiculoBundle:VhloCfgModalidadTransporte')->find($params->idModalidadTransporte);
                    $vehiculo->setModalidadTransporte($modalidadTransporte);
                }

                if ($params->idEmpresa) {
                    $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->find($params->idEmpresa);
                    $vehiculo->setEmpresa($empresa);
                }

                $vehiculo->setEstado('PREREGISTRADO');

                /* DATOS DE RADICADO DE CUENTA */
                if ($params->tipoMatricula == 'RADICADO') {
                    if ($params->radicado->fechaIngreso) {
                        $vehiculo->setFechaRegistroRadicado(
                            new \Datetime($params->radicado->fechaIngreso)
                        );
                    }

                    if ($params->radicado->guiaLlegada) {
                        $vehiculo->setNumeroGuiaRadicado($params->radicado->guiaLlegada);
                    }

                    if ($params->radicado->empresaEnvio) {
                        $vehiculo->setEmpresaEnvioRadicado(mb_strtoupper($params->radicado->empresaEnvio, 'utf-8'));
                    }

                    if ($params->radicado->idOrganismoTransito) {
                        $organismoTransitoRadicado = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find($params->radicado->idOrganismoTransito);
                        $vehiculo->setOrganismoTransitoRadicado($organismoTransitoRadicado);
                    }
    
                    if ($params->radicado->numeroLicencia) {
                        $vehiculo->setNumeroLicenciaRadicado(mb_strtoupper($params->radicado->numeroLicencia, 'utf-8'));
                    }
                }

                if($params->tipoMatricula != 'CARPETA') {
                    $vehiculo->setActivo(false);
                } else{
                    $vehiculo->setActivo(true);
                }

                $em->persist($vehiculo);
                $em->flush();

                /*if ($vehiculo->getTipoMatricula()) {
                    if ($params->radicado->numeroLicencia) {
                        $licenciaTransito = new UserLicenciaTransito();

                        $propietario = $em->getRepository('JHWEBVehiculoBundle:VhloPropietario')->findOneBy(
                            array(
                                'ciudadano' => $ciudadano->getId(),
                                'vehiculo' => $vehiculo->getId(),
                            )
                        );

                        if ($propietario) {
                            $licenciaTransito->setPropietario($propietario);
                            $licenciaTransito->setFecha(new \Datetime(date('Y-m-d h:i:s')));
                            $licenciaTransito->setNumero($params->insumoEntregado->licenciaTransito);
                            $licenciaTransito->setActivo(true);
                            
                            $em->persist($licenciaTransito);
                            $em->flush();
                        }
                    }
                }*/
                
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro creado con exito",
                    'data' => $vehiculo
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El número de placa ya existe",
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida",
            );
        }

        return $helpers->json($response);
    }

    /**
     * Finds and displays a vhloVehiculo entity.
     *
     * @Route("/show", name="vhlovehiculo_show")
     * @Method("POST")
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->find(
                $params->id
            );

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Registro encontrado con exito.',
                'data' => $vehiculo
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida.', 
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing vhloVehiculo entity.
     *
     * @Route("/edit", name="vhlovehiculo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->find(
                $params->vehiculo->id
            );

            if ($vehiculo) {
                $cfgPlaca = $em->getRepository('JHWEBVehiculoBundle:VhloCfgPlaca')->findOneBy(array('numero' => $params->vehiculo->placa));

                $organismoTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find(
                    $vehiculo->getOrganismoTransito()->getId()
                );
                
                if ($params->vehiculo->idClase) {
                    $clase = $em->getRepository('JHWEBVehiculoBundle:VhloCfgClase')->find($params->vehiculo->idClase);
                }

                if (!$cfgPlaca) {   
                    if (isset($params->vehiculo->placa) && $params->vehiculo->placa) {
                        $placa = new VhloCfgPlaca();
                        $placa->setNumero(strtoupper($params->vehiculo->placa));
                        $placa->setTipoVehiculo($clase->getTipoVehiculo());
        
                        $placa->setOrganismoTransito($organismoTransito);
                        $placa->setEstado('ASIGNADA');
                        $em->persist($placa);
                        $em->flush();
    
                        $vehiculo->setPlaca($placa);
                    }
                } else {
                    $vehiculo->setPlaca($cfgPlaca);
                }
    
                $fechaFactura = $params->vehiculo->fechaFactura;
                $fechaFactura = new \DateTime($fechaFactura);
                
                $vehiculo->setOrganismoTransito($organismoTransito);
                $vehiculo->setClase($clase);
                
                $vehiculo->setNumeroFactura($params->vehiculo->numeroFactura);
                $vehiculo->setfechaFactura($fechaFactura);
                $vehiculo->setValor($params->vehiculo->valor);

                $vehiculo->setSerie($params->vehiculo->serie);
                $vehiculo->setVin($params->vehiculo->vin);
                $vehiculo->setChasis($params->vehiculo->chasis);
                $vehiculo->setMotor($params->vehiculo->motor);
                $vehiculo->setCilindraje($params->vehiculo->cilindraje);
                $vehiculo->setModelo($params->vehiculo->modelo);
                $vehiculo->setTipoMatricula($params->vehiculo->tipoMatricula);
                $vehiculo->setPignorado(false);
                $vehiculo->setCancelado(false);

                if ($params->vehiculo->numeroManifiesto) {
                    $vehiculo->setNumeroManifiesto($params->vehiculo->numeroManifiesto);
                }

                if ($params->vehiculo->fechaManifiesto) {
                    $vehiculo->setFechaManifiesto(
                        new \Datetime($params->vehiculo->fechaManifiesto)
                    );
                }

                if ($params->vehiculo->numeroPasajeros) {
                    $vehiculo->setNumeroPasajeros($params->vehiculo->numeroPasajeros);
                }

                if ($params->vehiculo->capacidadCarga) {
                    $vehiculo->setCapacidadCarga($params->vehiculo->capacidadCarga);
                }

                if ($params->vehiculo->numeroEjes) {
                    $vehiculo->setNumeroEjes($params->vehiculo->numeroEjes);
                }

                $color = $em->getRepository('JHWEBVehiculoBundle:VhloCfgColor')->find(
                    $params->vehiculo->idColor
                );
                $vehiculo->setColor($color);

                $linea = $em->getRepository('JHWEBVehiculoBundle:VhloCfgLinea')->find(
                    $params->vehiculo->idLinea
                );
                $vehiculo->setLinea($linea);

                $carroceria = $em->getRepository('JHWEBVehiculoBundle:VhloCfgCarroceria')->find($params->vehiculo->idCarroceria);
                $vehiculo->setCarroceria($carroceria);

                $combustible = $em->getRepository('JHWEBVehiculoBundle:VhloCfgCombustible')->find($params->vehiculo->idCombustible);
                $vehiculo->setCombustible($combustible);

                $servicio = $em->getRepository('JHWEBVehiculoBundle:VhloCfgServicio')->find($params->vehiculo->idServicio);
                $vehiculo->setServicio($servicio);

                if ($params->vehiculo->idRadioAccion) {
                    $radioAccion = $em->getRepository('JHWEBVehiculoBundle:VhloCfgRadioAccion')->find($params->vehiculo->idRadioAccion);
                    $vehiculo->setRadioAccion($radioAccion);
                }

                if ($params->vehiculo->idModalidadTransporte) {
                    $modalidadTransporte = $em->getRepository('JHWEBVehiculoBundle:VhloCfgModalidadTransporte')->find($params->vehiculo->idModalidadTransporte);
                    $vehiculo->setModalidadTransporte($modalidadTransporte);
                }

                if ($params->vehiculo->idEmpresa) {
                    $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->find($params->vehiculo->idEmpresa);
                    $vehiculo->setEmpresa($empresa);
                }

                /* DATOS DE RADICADO DE CUENTA */
                if ($params->vehiculo->tipoMatricula == 'RADICADO') {
                    if ($params->radicado->fechaIngreso) {
                        $vehiculo->setFechaRegistroRadicado(
                            new \Datetime($params->radicado->fechaIngreso)
                        );
                    }

                    if ($params->radicado->guiaLlegada) {
                        $vehiculo->setNumeroGuiaRadicado($params->radicado->guiaLlegada);
                    }

                    if ($params->radicado->empresaEnvio) {
                        $vehiculo->setEmpresaEnvioRadicado(mb_strtoupper($params->radicado->empresaEnvio, 'utf-8'));
                    }

                    if ($params->radicado->numeroLicencia) {
                        $vehiculo->setNumeroLicenciaRadicado(mb_strtoupper($params->radicado->numeroLicencia, 'utf-8'));
                    }

                    if ($params->radicado->idOrganismoTransito) {
                        $organismoTransitoRadicado = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find($params->radicado->idOrganismoTransito);
                        $vehiculo->setOrganismoTransitoRadicado($organismoTransitoRadicado);
                    }
                }

                $em->flush();
                
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Registro actualizado con exito.',
                    'data' => $vehiculo
                );
            }else{
                $response = array(
                    'title' => 'Atención!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => 'El vehiculo no se encuentra en la base de datos.',
                );
            }
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida.', 
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Deletes a vhloVehiculo entity.
     *
     * @Route("/delete", name="vhlovehiculo_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->find(
                $params->id
            );

            if ($vehiculo) {
                $vehiculo->setActivo(false);

                $em->flush();

                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Registro eliminado con exito.',
                    'data' => $vehiculo
                );
            }else{
                $response = array(
                    'title' => 'Atención!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => 'El vehiculo no se encuentra en la base de datos.',
                );
            }
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida.', 
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a vhloVehiculo entity.
     *
     * @param VhloVehiculo $vhloVehiculo The vhloVehiculo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloVehiculo $vhloVehiculo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhlovehiculo_delete', array('id' => $vhloVehiculo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ============================================== */

    /**
     * Busca si un vehiculo es maquinaria o remolque.
     *
     * @Route("/show/maquinaria/remolque", name="vhlovehiculo_show_maquinaria_remolque")
     * @Method("POST")
     */
    public function showMaquinariaOrRemolqueAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $maquinaria = $em->getRepository('JHWEBVehiculoBundle:VhloMaquinaria')->findOneBy(
                array(
                    'vehiculo' => $params->idVehiculo,
                )
            );

            $remolque = $em->getRepository('JHWEBVehiculoBundle:VhloRemolque')->findOneBy(
                array(
                    'vehiculo' => $params->idVehiculo,
                )
            );

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Registro encontrado con exito.',
                'data' => array(
                    'maquinaria' => $maquinaria,
                    'remolque' => $remolque,
                )
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida.', 
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Lista de vehiculos segun los filtros .
     *
     * @Route("/search/filter", name="vhlovehiculo_search_filter")
     * @Method({"GET", "POST"})
     */
    public function searchByFilterAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->getByFilter($params->filtro);

            if ($vehiculo) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Registro encontrado.', 
                    'data'=> $vehiculo
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Registro no encontrado en base de datos.', 
                );
            }            
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida para editar', 
            );
        }

        return $helpers->json($response);
    }

    /**
     * Lista de vehiculos segun uno o varios parametros.
     *
     * @Route("/search/parameters", name="vhlovehiculo_search_parameters")
     * @Method({"GET", "POST"})
     */
    public function searchByParametersAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $vehiculos = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->getByParameters($params);

            if ($vehiculos) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($vehiculos).' registros encontrados.', 
                    'data'=> $vehiculos
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Registro no encontrado en base de datos.', 
                );
            }            
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida para editar', 
            );
        }

        return $helpers->json($response);
    }

    /**
     * Obtiene un unico vehiculo segun uno o varios parametros.
     *
     * @Route("/show/parameters", name="vhlovehiculo_show_parameters")
     * @Method({"GET", "POST"})
     */
    public function showByParametersAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $vehiculos = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->getOneByParameters($params);

            if ($vehiculos) {
                if (count($vehiculos) > 1) {
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => 'Realice un filtro más especifico, la búsqueda esta arrojando varios resultados aún.', 
                    );
                }else{
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => 'Registro encontrado.', 
                        'data'=> $vehiculos[0]
                    );
                }
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Registro no encontrado en base de datos.', 
                );
            }            
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida para editar', 
            );
        }

        return $helpers->json($response);
    }

    /**
     * Lista de vehiculos segun los filtros .
     *
     * @Route("/search/placa", name="vhlovehiculo_search_placa")
     * @Method({"GET", "POST"})
     */
    public function searchByPlacaAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->getByPlaca($params->numero);

            if ($vehiculo) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Registro encontrado.', 
                    'data'=> $vehiculo
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Registro no encontrado en base de datos.', 
                );
            }            
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida.', 
            );
        }

        return $helpers->json($response);
    }

    /**
     * Busca vehiculos segun la placa para la devolucion por radicado .
     *
     * @Route("/search/placa/devolucion", name="vhlovehiculo_search_placa_for_devolucion")
     * @Method({"GET", "POST"})
     */
    public function searchByPlacaForDevolucionAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $placa = $em->getRepository('JHWEBVehiculoBundle:VhloCfgPlaca')->findOneBy(
                array(
                    'numero' => $params->numero
                )
            );

            if($placa) {
                $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->findOneBy(
                    array(
                        'placa' => $placa->getId(),
                        'tipoMatricula' => array('RADICADO', 'DEVOLUCION'),
                        'activo' => true
                        )
                    );
            
                if ($vehiculo) {
                    $tramiteRadicado = null;
                    $tramiteRadicado = $em->getRepository('JHWEBFinancieroBundle:FroTrteSolicitud')->findByVehiculo($vehiculo->getId());
                    
                    if(count($tramiteRadicado) > 0) {
                        $response = array(
                            'title' => 'Atención!',
                            'status' => 'warning',
                            'code' => 400,
                            'message' => 'El vehículo ya esta radicado en ' . $tramiteRadicado[0]->getOrganismoTransito()->getNombre(), 
                        ); 
                    } else {
                        $response = array(
                            'title' => 'Perfecto!',
                            'status' => 'success',
                            'code' => 200,
                            'message' => 'El vehículo aún no realiza el tramite de radicado de cuenta', 
                            'data' => $vehiculo
                        );
                    }
                }else{
                    $response = array(
                        'title' => 'Error!',
                        'status' => 'error',
                        'code' => 400,
                        'message' => 'El vehículo no fue registrado por RADICADO DE CUENTA.', 
                    );
                }      
            }elseif(!$placa) {
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'La placa no existe en la base de datos.', 
                );
            }
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida.', 
            );
        }

        return $helpers->json($response);
    }

    /**
     * Displays a form to update an existing Vehiculo entity.
     *
     * @Route("/update", name="vhlovehiculo_update")
     * @Method({"GET", "POST"})
     */
    public function updateAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            
            $em = $this->getDoctrine()->getManager();

            $vehiculo = $em->getRepository("JHWEBVehiculoBundle:VhloVehiculo")->find(
                $params->idVehiculo
            );

            if ($vehiculo) {
                foreach ($params->campos as $key => $campo) {
                    switch ($campo) {
                        case 'color':
                            $color = $em->getRepository('JHWEBVehiculoBundle:VhloCfgColor')->find(
                                $params->idColor
                            );
                            $vehiculo->setColor($color);
                            break;

                        case 'combustible':
                            $combustible = $em->getRepository('JHWEBVehiculoBundle:VhloCfgCombustible')->find(
                                $params->idCombustible
                            );
                            $vehiculo->setCombustible($combustible);
                            break;

                        case 'gas':
                            $gas = $em->getRepository('JHWEBVehiculoBundle:VhloCfgCombustible')->find(
                                $params->idCombustibleCambio
                            );
                            $vehiculo->setCombustible($gas);
                            break;

                        case 'organismoTransito':
                            $organismoTransito = $em->getRepository("JHWEBConfigBundle:CfgOrganismoTransito")->find(
                                $params->idOrganismoTransitoNew
                            );
                            $vehiculo->setOrganismoTransito($organismoTransito);
                            break;

                        case 'blindaje':
                            $vehiculo->setTipoBlindaje($params->idTipoBlindaje);
                            $vehiculo->setNivelBlindaje($params->idNivelBlindaje);
                            $vehiculo->setEmpresaBlindadora(
                                $params->empresaBlindadora
                            );
                            break;

                        case 'carroceria':
                            $carroceria = $em->getRepository("JHWEBVehiculoBundle:VhloCfgCarroceria")->find(
                                $params->idCarroceria
                            );
                            $vehiculo->setCarroceria($carroceria);
                            break;

                        case 'motor':
                            $vehiculo->setMotor($params->numeroMotor);
                            break;

                        case 'placa':
                            $placa = $em->getRepository("JHWEBVehiculoBundle:VhloCfgPlaca")->findOneByNumero(
                                $params->nuevaPlaca
                            );

                            if (!$placa) {
                                $placa = new VhloCfgPlaca();

                                $placa->setNumero(
                                    strtoupper($params->nuevaPlaca)
                                );
                                $placa->setEstado('ASIGNADA');
                                $placa->setTipoVehiculo($vehiculo->getTipoVehiculo());
                                $placa->setOrganismoTransito($vehiculo->getOrganismoTransito());

                                $em->persist($placa);
                                $em->flush();
                            }

                            $vehiculo->setPlaca($placa);
                            break;
                            
                        case 'servicio':
                            $servicio = $em->getRepository('JHWEBVehiculoBundle:VhloCfgServicio')->find(
                                $params->idServicio
                            );
                            $vehiculo->setServicio($servicio);
                            break;

                        case 'ejes':
                            $vehiculo->setNumeroEjes($paramas->ejesTotal);
                            break;
                            
                        case 'cancelacionmatricula':
                            $vehiculo->setCancelado(true);
                            break;

                        case 'rematricula':
                            $vehiculo->setCancelado(false);
                            break;

                        case 'regrabarchasis':
                            $vehiculo->setChasis($params->nuevoNumero);
                            break;

                        case 'regrabarmotor':
                            $vehiculo->setMotor($params->nuevoNumero);
                            break;

                        case 'regrabarserie':
                            $vehiculo->setSerie($params->nuevoNumero);
                            break;

                        case 'regrabarvin':
                            $vehiculo->setVin($params->nuevoNumero);
                            break;

                        case 'conjunto':
                            $vehiculo->setModelo($params->nuevoModelo);
                            break;

                        case 'repotenciacion':
                            $vehiculo->setModelo($params->modelo);
                            break;

                        case 'pignorado':
                            $vehiculo->setPignorado(true);
                            break;
                    }
                }

                $em->flush();
                
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'El vehiculo se actualizó con éxito.',
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'El vehiculo no se encuentra en la base de datos.',
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorización no válida para editar vehiculo.',
            );
        }

        return $helpers->json($response);
    }

    /**
     * Displays a form to asignacionPlca an existing Vehiculo entity.
     *
     * @Route("/assign", name="vhlovehiculo_assign")
     * @Method({"GET", "POST"})
     */

    public function assignAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $organismoTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find(
                $params->idOrganismoTransito
            );

            $placa = $em->getRepository('JHWEBVehiculoBundle:VhloCfgPlaca')->find(
                $params->idPlaca
            );

            $vehiculo = $em->getRepository("JHWEBVehiculoBundle:VhloVehiculo")->find(
                $params->idVehiculo
            );

            if ($vehiculo) {
                if (!$vehiculo->getPlaca()) {
                    $vehiculo->setPlaca($placa);
                    $vehiculo->setOrganismoTransito($organismoTransito);
                    $vehiculo->setFechaPlaca(new \Datetime($params->fechaAsignacion));
    
                    $placa->setEstado('PREASIGNADA');
    
                    $em->persist($vehiculo);
                    $em->flush();
    
                    $response = array(
                        'title' => 'Perfecto!',
                        'status' => 'success',
                        'code' => 200,
                        'message' => "Placa asignada con exito.",
                        'data' => $vehiculo,
                    );
                }else{
                    $response = array(
                        'title' => 'Atención!',
                        'status' => 'warning',
                        'code' => 400,
                        'message' => "El vehiculo ya tiene una placa asignada.",
                    );
                }
            } else {
                $response = array(
                    'title' => 'Atención!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => "El vehiculo no se encuentra en la base de datos.",
                );
            }
        } else {
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida para editar vehiculo",
            );
        }

        return $helpers->json($response);
    }

    /**
     * Validaciones de tramites.
     *
     * @Route("/validations", name="vhlovehiculo_validations")
     * @Method("POST")
     */
    public function validationsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck) {
            $json = $request->get("data",null);
            $params = json_decode($json);
            
            $tramiteFactura = $em->getRepository('JHWEBFinancieroBundle:FroTrteFactura')->find(
                $params->idTramiteFactura
            );

            if($tramiteFactura){
                $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->find(
                    $params->id
                );

                if($tramiteFactura){
                    switch ($tramiteFactura->getPrecio()->getTramite()->getId()) {
                        case '18':
                            //Busca el último tramite de cancelación de vehiculo
                            $tramiteCancelacion = $em->getRepository('JHWEBFinancieroBundle:FroTrteSolicitud')->getOneByVehiculoAndTramite(
                                $vehiculo->getId(), 18
                            );

                            $foraneas = (object)$tramiteCancelacion->getForaneas();

                            if ($foraneas->idMotivoCancelacion == 1 || $foraneas->idMotivoCancelacion == 7 || $foraneas->idMotivoCancelacion == 8) {
                                $response = array(
                                    'title' => 'Perfecto!',
                                    'status' => 'success',
                                    'code' => 200,
                                    'message' => 'Trámite autorizado.',
                                );
                            }else{
                                $response = array(
                                    'title' => 'Error',
                                    'status' => 'error',
                                    'code' => 400,
                                    'message' => 'Este trámite no se pude realizar porque el motivo de la cancelación no es HURTO, DESAPARICIÓN DOCUMENTAL o PERDIDA DEFINITIVA.',
                                );
                            }
                            break;
                        
                        default:
                            $response = array(
                                'title' => 'Perfecto!',
                                'status' => 'success',
                                'code' => 200,
                                'message' => 'No se realizaron validaciones.',
                            );
                            break;
                    }
                }else{
                    $response = array(
                        'title' => 'Error!',
                        'status' => 'No se encuentra el vehiculo.',
                        'code' => 400,
                        'message' => 'Trámite autorizado.',
                    );
                }
            }else{
                $response = array(
                    'title' => 'Error!',
                    'status' => 'No se encuentra el tramite de la factura.',
                    'code' => 400,
                    'message' => 'Trámite autorizado.',
                );
            }
            
            $limitaciones = $em->getRepository('JHWEBVehiculoBundle:VhloLimitacion')->findBy(
                array(
                    'vehiculo' => $params->idVehiculo,
                    'activo' => true,
                )
            );

            /*if ($limitaciones) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Trámite no autorizado porque el vehiculo presenta limitaciones a la propiedad.',
                );
            }else{
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Trámite autorizado.',
                );
            }*/
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorización no válida.',
            );
        }        

        return $helpers->json($response);
    }

    /**
     * Crea PDF con preasignación de placa .
     *
     * @Route("/{idFuncionario}/{id}/pdf/preasignacion/placa", name="vhlovehivulo_pdf_preasignacion_placa")
     * @Method({"GET", "POST"})
     */
    public function pdfAction(Request $request, $idFuncionario, $id)
    {
        setlocale(LC_ALL,"es_ES");
        $fechaActual = strftime("%d de %B del %Y");

        $em = $this->getDoctrine()->getManager();

        $funcionario = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->find(
            $idFuncionario
        );
        
        $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->find(
            $id
        );
        
        if ($vehiculo) {
            $html = $this->renderView('@JHWEBVehiculo/Default/pdf.preasignacion.placa.html.twig', array(
                'fechaActual' => $fechaActual,
                'funcionario'=> $funcionario,
                'vehiculo'=> $vehiculo,
            ));
    
            $this->get('app.pdf')->templatePreview($html, 'Preasignacion_'.$vehiculo->getPlaca()->getNumero());
        }else{
            $response = array(
                'title' => 'Atención!!',
                'status' => 'warning',
                'code' => 400,
                'message' => 'Vehiculo no encontrado.', 
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Deletes a comparendo entity.
     *
     * @Route("/certificado/tradicion/file", name="vhlovehiculo_certificado_tradicion_file")
     * @Method("POST")
     */
    public function certificadoTradicionByFileAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $json = $request->get("data", null);
        
        $params = json_decode($json);

        setlocale(LC_ALL,"es_ES");
        $fechaActual = strftime("%d de %B del %Y");

        $em = $this->getDoctrine()->getManager();

        $file = $request->files->get('file'); 

        if ($file->guessExtension() == 'txt') {
            $documentoName = md5(uniqid()).$file->guessExtension();
            $file->move(
                $this->getParameter('data_upload'),
                $documentoName
            ); 
            
            $funcionario = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->find(
                $params->idFuncionario
            );
    
            $tramitesSolicitudArray = null;
            $certificadosArray = null;
    
            $count = 0;
    
            $valores = fopen($this->getParameter('data_upload').$documentoName , "r" );

            while (($datos = fgetcsv($valores,0,";")) !== FALSE )
            {
                $datos = array_map("utf8_encode", $datos);
        
                if ($params->tipo == 'PLACA') {
                    $placa = $em->getRepository('JHWEBVehiculoBundle:VhloCfgPlaca')->findOneByNumero(
                        $datos[0]
                    );
    
                    if ($placa) {
                        $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->findOneByPlaca(
                            $placa->getId()
                        );
        
                        if ($vehiculo) {
                            $propietarios = $em->getRepository('JHWEBVehiculoBundle:VhloPropietario')->findByVehiculo(
                                $vehiculo->getId()
                            );

                            $limitaciones = $em->getRepository('JHWEBVehiculoBundle:VhloLimitacion')->findBy(
                                array(
                                    'vehiculo' => $vehiculo->getId(),
                                    'activo' => true
                                )
                            );
                
                            $tramitesSolicitud = $em->getRepository('JHWEBFinancieroBundle:FroTrteSolicitud')->findByVehiculo(
                                $vehiculo->getId()
                            );
        
                            $observaciones = null;
                            foreach ($tramitesSolicitud as $tramiteSolicitud) {
                                if ($tramiteSolicitud->getTramiteFactura()->getPrecio()->getTramite()->getId() == 30) {
                                    $foraneas = (object)$tramiteSolicitud->getForaneas();
                                    $observaciones = $foraneas->observaciones;
                                }

                                $tramitesSolicitudArray[]= array(
                                    'fecha' => $tramiteSolicitud->getFecha(),
                                    'tramiteNombre' => $tramiteSolicitud->getTramiteFactura()->getPrecio()->getTramite()->getNombre(),
                                    'datos' => $tramiteSolicitud->getResumen()
                                );
                            }
        
                            if ($tramitesSolicitudArray) {
                                $certificadosArray[] = array(
                                    'vehiculo' => $vehiculo,
                                    'propietarios' => $propietarios,
                                    'tramitesSolicitud' => $tramitesSolicitudArray,
                                    'limitaciones' => $limitaciones,
                                    'observaciones' => $observaciones,
                                );
                            }
                        } 
                    }
                }elseif ($params->tipo == 'IDENTIFICACION') {                    
                    $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findOneByIdentificacion(
                        $datos[0]
                    );
    
                    if ($ciudadano) {
                        $propiedades = $em->getRepository('JHWEBVehiculoBundle:VhloPropietario')->findByCiudadano(
                            $ciudadano->getId()
                        );

                        if ($propiedades) {
                            foreach ($propiedades as $key => $propietario) {
                                $vehiculo = $propietario->getVehiculo();
        
                                if ($propietario->getVehiculo()) {
                                    $propietarios = $em->getRepository('JHWEBVehiculoBundle:VhloPropietario')->findByVehiculo(
                                        $vehiculo->getId()
                                    );

                                    $limitaciones = $em->getRepository('JHWEBVehiculoBundle:VhloLimitacion')->findBy(
                                        array(
                                            'vehiculo' => $vehiculo->getId(),
                                            'activo' => true
                                        )
                                    );
                        
                                    $tramitesSolicitud = $em->getRepository('JHWEBFinancieroBundle:FroTrteSolicitud')->findByVehiculo(
                                        $vehiculo->getId()
                                    );
                                    
                                    $observaciones = null;
                                    foreach ($tramitesSolicitud as $tramiteSolicitud) {
                                        if ($tramiteSolicitud->getTramiteFactura()->getPrecio()->getTramite()->getId() == 30) {
                                            $foraneas = (object)$tramiteSolicitud->getForaneas();
                                            $observaciones = $foraneas->observaciones;
                                        }

                                        $tramitesSolicitudArray[]= array(
                                            'fecha' => $tramiteSolicitud->getFecha(),
                                            'tramiteNombre' => $tramiteSolicitud->getTramiteFactura()->getPrecio()->getTramite()->getNombre(),
                                            'datos' => $tramiteSolicitud->getResumen()
                                        );
                                    }
                
                                    if ($tramitesSolicitudArray) {
                                        $certificadosArray[] = array(
                                            'vehiculo' => $vehiculo,
                                            'propietarios' => $propietarios,
                                            'tramitesSolicitud' => $tramitesSolicitudArray,
                                            'limitaciones' => $limitaciones,
                                            'observaciones' => $observaciones,
                                        );
                                    }
                                } 
                            }
                        }
                    }
                }
    
                $count++;
            }

            if ($certificadosArray) {
                $html = $this->renderView('@JHWEBVehiculo/Default/pdfCertificadoTradicionOficial.html.twig', array(
                    'certificadosArray'=> $certificadosArray,
                    'funcionario'=> $funcionario,
                    'fechaActual' => $fechaActual,
                ));

    
                return new Response(
                    $this->get('app.pdf.certificado.tradicion')->templatePreview($html, 'Certificado de tradición para uso oficial'),
                    200,
                    array(
                        'Content-Type'        => 'application/pdf',
                        'Content-Disposition' => 'attachment; filename="fichero.pdf"'
                    )
                );
            }else{
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'No existen tramites realizados.', 
                );
            }
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => 'Solo se admite archivo .CSV', 
            );
        }

        return $helpers->json($response);
    }
}
