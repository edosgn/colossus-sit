<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Vehiculo;
use AppBundle\Entity\PropietarioVehiculo;
use AppBundle\Entity\CfgPlaca;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Vehiculo controller.
 *
 * @Route("/app/vehiculo")
 */
class VehiculoController extends Controller
{
    /**
     * Lists all Vehiculo entities.
     *
     * @Route("/", name="vehiculo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $vehiculos = $em->getRepository('AppBundle:Vehiculo')->getOnlyVehiculos();

        if ($vehiculos) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "listado vehiculo",
                'data' => $vehiculos,
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "No existen registros",
            );
        }

        return $helpers->json($response);

    }

    /**
     * Creates a new Vehiculo entity.
     *
     * @Route("/new", name="vehiculo_new")
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
            // var_dump($params);
            // die();

            $numeroFactura = $params->vehiculo->numeroFactura;
            $fechaFactura = $params->vehiculo->fechaFactura;
            $valor = $params->vehiculo->valor;
            $numeroManifiesto = $params->vehiculo->numeroManifiesto;
            $cilindraje = $params->vehiculo->cilindraje;
            $modelo = $params->vehiculo->modelo;
            $motor = $params->vehiculo->motor;
            $chasis = $params->vehiculo->chasis;
            $serie = $params->vehiculo->serie;
            // $tipoVehiculo = $params->vehiculo->tipoVehiculo;

            $vin = $params->vehiculo->vin;
            $numeroPasajeros = $params->vehiculo->numeroPasajeros;
            $municipioId = $params->vehiculo->municipioId;
            $lineaId = $params->vehiculo->lineaId;
            $servicioId = $params->vehiculo->servicioId;
            $colorId = $params->vehiculo->colorId;
            $combustibleId = $params->vehiculo->combustibleId;
            $carroceriaId = $params->vehiculo->carroceriaId;
            $sedeOperativaId = $params->vehiculo->sedeOperativaId;
            $claseId = $params->vehiculo->claseId;
            $pignorado = (isset($params->vehiculo->pignorado)) ? $params->vehiculo->pignorado : false;
            $cancelado = (isset($params->vehiculo->cancelado)) ? $params->vehiculo->cancelado : false;
            $placa = (isset($params->vehiculo->placa)) ? $params->vehiculo->placa : false;
            $em = $this->getDoctrine()->getManager();
            $municipio = $em->getRepository('AppBundle:Municipio')->find($municipioId);
            $linea = $em->getRepository('AppBundle:Linea')->find($lineaId);
            $servicio = $em->getRepository('AppBundle:Servicio')->find($servicioId);
            $color = $em->getRepository('AppBundle:Color')->find($colorId);
            $combustible = $em->getRepository('AppBundle:Combustible')->find($combustibleId);
            $carroceria = $em->getRepository('AppBundle:Carroceria')->find($carroceriaId);
            $sedeOperativa = $em->getRepository('AppBundle:SedeOperativa')->find($sedeOperativaId);
            $radioAccion = $em->getRepository('AppBundle:CfgRadioAccion')->find(
                $params->vehiculo->radioAccionId
            );
            $modalidadTransporte = $em->getRepository('AppBundle:CfgModalidadTransporte')->find(
                $params->vehiculo->modalidadTransporteId
            );
            $clase = $em->getRepository('AppBundle:Clase')->find($claseId);
            $vehiculo = new Vehiculo();

            $fechaFactura = new \DateTime($fechaFactura);

            if ($placa) {
                $CfgPlacaBd = $em->getRepository('AppBundle:CfgPlaca')->findOneByNumero($params->vehiculo->placa);
                if ($CfgPlacaBd) {
                    $response = array(
                        'status' => 'error',
                        'code' => 200,
                        'msj' => "La placa ".$params->vehiculo->placa.' ya se encontra registrada'.'para la sede '.$CfgPlacaBd->getSedeOperativa()->getNombre(),
                    );
                    return $helpers->json($response);
                }else{
                    $cfgPlaca = new CfgPlaca();
                    $sedeOperativaCfgPlaca = $em->getRepository('AppBundle:SedeOperativa')->find($params->sedeOperativaId);
                    $cfgPlaca->setClase($clase);
                    $cfgPlaca->setSedeOperativa($sedeOperativaCfgPlaca);
                    $cfgPlaca->setNumero($params->vehiculo->placa);
                    $cfgPlaca->setEstado('asignado');
                    $em->persist($cfgPlaca);
                    $em->flush();
                    $vehiculo->setPlaca($cfgPlaca);
                }
            }
            $vehiculo->setNumeroFactura($numeroFactura);
            $vehiculo->setfechaFactura($fechaFactura);
            $vehiculo->setValor($valor);
            $vehiculo->setNumeroManifiesto($numeroManifiesto);
            $vehiculo->setFechaManifiesto(new \DateTime($params->vehiculo->fechaManifiesto));
            $vehiculo->setCilindraje($cilindraje);
            $vehiculo->setModelo($modelo);
            $vehiculo->setMotor($motor);
            $vehiculo->setChasis($chasis);
            $vehiculo->setSerie($serie);
            $vehiculo->setRadioAccion($radioAccion);
            $vehiculo->setModalidadTransporte($modalidadTransporte);
            $vehiculo->setSerie($serie);
            $vehiculo->setSerie($serie);
            $vehiculo->setVin($vin);
            $vehiculo->setNumeroPasajeros($numeroPasajeros);
            $vehiculo->setMunicipio($municipio);
            $vehiculo->setLinea($linea);
            $vehiculo->setServicio($servicio);
            $vehiculo->setColor($color);
            $vehiculo->setCombustible($combustible);
            $vehiculo->setCarroceria($carroceria);
            $vehiculo->setSedeOperativa($sedeOperativa);
            $vehiculo->setClase($clase);
            $vehiculo->setPignorado($pignorado);
            $vehiculo->setCancelado($cancelado);

            $vehiculo->setEstado(true);
            $em = $this->getDoctrine()->getManager();
            $em->persist($vehiculo);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "Vehiculo creado con exito",
            );
 
            // }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Finds and displays a Vehiculo entity.
     *
     * @Route("/show/{id}", name="vehiculo_show")
     * @Method("POST")
     */
    public function showAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $vehiculo = $em->getRepository('AppBundle:Vehiculo')->find($id);
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "vehiculo",
                'data' => $vehiculo,
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * busca vehiculos por placa.
     *
     * @Route("/placa", name="vehiculo_search_placa")
     * @Method("POST")
     */
    public function searchByPlacaAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            
            $vehiculo = $em->getRepository('AppBundle:Vehiculo')->getByPlaca(
                $params->placa
            );

            if ($vehiculo) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado",
                    'data' => $vehiculo,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Registro no encontrado", 
                );
            }
        }else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * busca vehiculos por placa y modulo.
     *
     * @Route("/modulo/placa", name="modulo_vehiculo_search_placa")
     * @Method({"GET", "POST"})
     */
    public function searchByPlacaModuloAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            $vehiculo = $em->getRepository('AppBundle:Vehiculo')->getByPlacaModulo(
                $params->placa,
                $params->moduloId
            );

            if ($vehiculo != null) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro encontrado",
                    'data' => $vehiculo,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Registro no encontrado", 
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing Vehiculo entity.
     *
     * @Route("/edit", name="vehiculo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);
            /*$numeroFactura = $params->numeroFactura;
            $fechaFactura = $params->fechaFactura;
            $valor = $params->valor;
            $linea = $params->linea;
            $clase = $params->clase;
            $carroceria = $params->carroceriaId;
            $servicio = $params->servicioId;
            $color = $params->color;
            $combustible = $params->combustible;
            $sedeOperativa = $params->sedeOperativa;
            $numeroManifiesto = $params->numeroManifiesto;
            $municipio = $params->municipio;
            $fechaManifiesto = $params->fechaManifiesto;
            $cilindraje = $params->cilindraje;
            $modelo = $params->modelo;
            $motor = $params->motor;
            $chasis = $params->chasis;
            $serie = $params->serie;
            $vin = $params->vin;
            $numeroPasajeros = $params->numeroPasajeros;
            $radioAccion = $params->radioAccion;
            $modalidadTransporte = $params->modalidadTransporte;*/

            // $pignorado = (isset($params->pignorado)) ? $params->pignorado : false;
            $vehiculo = $em->getRepository("AppBundle:Vehiculo")->find($params->id);

            if ($vehiculo != null) {

                /*$fechaFactura = (isset($params->fechaFactura)) ? $params->fechaFactura : null;
                $fechaFactura = new \DateTime($fechaFactura);
                $fechaManifiesto = (isset($params->fechaManifiesto)) ? $params->fechaManifiesto : null;
                $fechaManifiesto = new \DateTime($fechaManifiesto);
                $linea = $em->getRepository('AppBundle:Linea')->find($linea);
                $marca = $linea->getMarca();
                $clase = $em->getRepository('AppBundle:Clase')->find($clase);
                $carroceria = $em->getRepository('AppBundle:Carroceria')->find($carroceria);
                $servicio = $em->getRepository('AppBundle:Servicio')->find($servicio);
                $color = $em->getRepository('AppBundle:Color')->find($color);
                $combustible = $em->getRepository('AppBundle:Combustible')->find($combustible);
                $sedeOperativa = $em->getRepository('AppBundle:SedeOperativa')->find($sedeOperativa);
                $municipio = $em->getRepository('AppBundle:Municipio')->find($municipio);
                $radioAccion = $em->getRepository('AppBundle:CfgRadioAccion')->find($radioAccion);
                $modalidadTransporte = $em->getRepository('AppBundle:CfgModalidadTransporte')->find($modalidadTransporte);

                $vehiculo->setNumeroFactura($numeroFactura);
                $vehiculo->setFechaFactura($fechaFactura);
                $vehiculo->setValor($valor);
                $vehiculo->setLinea($linea);
                $vehiculo->setClase($clase);
                $vehiculo->setCarroceria($carroceria);
                $vehiculo->setServicio($servicio);
                $vehiculo->setColor($color);
                $vehiculo->setCombustible($combustible);
                $vehiculo->setSedeOperativa($sedeOperativa);
                $vehiculo->setNumeroManifiesto($numeroManifiesto);
                $vehiculo->setMunicipio($municipio);
                $vehiculo->setFechaManifiesto($fechaManifiesto);
                $vehiculo->setCilindraje($cilindraje);
                $vehiculo->setModelo($modelo);
                $vehiculo->setMotor($motor);
                $vehiculo->setChasis($chasis);
                $vehiculo->setSerie($serie);
                $vehiculo->setVin($vin);
                $vehiculo->setNumeroPasajeros($numeroPasajeros);
                $vehiculo->setRadioAccion($radioAccion);
                $vehiculo->setModalidadTransporte($modalidadTransporte);
                $vehiculo->setEstado(true);
                // var_dump($params);
                //  die();

                $em->flush();*/

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Vehiculo editado con exito",
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El vehiculo no se encuentra en la base de datos",
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida para editar vehiculo",
            );
        }

        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing Vehiculo entity.
     *
     * @Route("/edit/color", name="vehiculo_edit_color")
     * @Method({"GET", "POST"})
     */
    public function editColorAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            $color = $em->getRepository('AppBundle:Color')->find($params->colorId);
            $vehiculo = $em->getRepository("AppBundle:Vehiculo")->find($params->id);

            if ($vehiculo != null) {
                $vehiculo->setColor($color);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Vehiculo editado con éxito",
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El vehiculo no se encuentra en la base de datos",
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida para editar vehiculo",
            );
        }

        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing Vehiculo entity.
     *
     * @Route("/edit/combustible", name="vehiculo_edit_combustible")
     * @Method({"GET", "POST"})
     */
    public function editCombustibleAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            $combustible = $em->getRepository('AppBundle:Combustible')->find($params->combustibleCambioId);
            $vehiculo = $em->getRepository("AppBundle:Vehiculo")->find($params->vehiculoId);

            if ($vehiculo != null) {
                $vehiculo->setCombustible($combustible);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Vehiculo editado con éxito",
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El vehiculo no se encuentra en la base de datos",
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida para editar vehiculo",
            );
        }

        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing Vehiculo entity.
     *
     * @Route("/edit/sedeOperativa", name="vehiculo_edit_sedeOperativa")
     * @Method({"GET", "POST"})
     */
    public function editSedeOperativaAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $vehiculo = $em->getRepository("AppBundle:Vehiculo")->find($params->id);
            $sedeOperativa = $em->getRepository("AppBundle:SedeOperativa")->find($params->sedeOperativaId);

            if ($vehiculo != null) {
                $vehiculo->setSedeOperativa($sedeOperativa);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Vehiculo editado con exito",
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El vehiculo no se encuentra en la base de datos",
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida para editar vehiculo",
            );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a Vehiculo entity.
     *
     * @Route("/{id}/delete", name="vehiculo_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $vehiculo = $em->getRepository('AppBundle:Vehiculo')->find($id);

            $vehiculo->setEstado(0);
            $em = $this->getDoctrine()->getManager();
            $em->persist($vehiculo);
            $em->flush();
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "vehiculo eliminado con exito",
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a Vehiculo entity.
     *
     * @param Vehiculo $vehiculo The Vehiculo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Vehiculo $vehiculo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vehiculo_delete', array('id' => $vehiculo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="vehiculo_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $vehiculos = $em->getRepository('AppBundle:Vehiculo')->findBy(
            array('estado' => 1)
        );
        foreach ($vehiculos as $key => $vehiculo) {
            $response[$key] = array(
                'value' => $vehiculo->getId(),
                'label' => $vehiculo->getPlaca(),
            );
        }
        return $helpers->json($response);
    }

    /**
     * Filtra los vehiculos por los parametros estado clase y sede operativa.
     *
     * @Route("/fin/by/parameters", name="vehiculo_find_by_parameters")
     * @Method({"GET", "POST"})
     */
    public function findByParametersAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $json = $request->get("json", null);
            $params = json_decode($json);

            $estado = $params->estado;
            $claseId = (isset($params->claseId)) ? $params->claseId : 0;
            $sedeOperativaId = (isset($params->sedeOperativaId)) ? $params->sedeOperativaId : 0;
            $pignorado = 0;
            $cancelado = 0;

            if ($estado == 1) {
                $pignorado = 1;
            } elseif ($estado == 2) {
                $cancelado = 1;
            }

            if ($claseId == 0 and $sedeOperativaId == 0) {
                $vehiculos = $em->getRepository('AppBundle:Vehiculo')->findBy(
                    array(
                        'pignorado' => $pignorado,
                        'cancelado' => $cancelado,
                        'estado' => 1,
                    )
                );
            } elseif ($claseId == 0 and $sedeOperativaId != 0) {
                $vehiculos = $em->getRepository('AppBundle:Vehiculo')->findBy(
                    array(
                        'pignorado' => $pignorado,
                        'cancelado' => $cancelado,
                        'sedeOperativa' => $sedeOperativaId,
                        'estado' => 1,
                    )
                );
            } elseif ($claseId != 0 and $sedeOperativaId == 0) {
                $vehiculos = $em->getRepository('AppBundle:Vehiculo')->findBy(
                    array(
                        'pignorado' => $pignorado,
                        'cancelado' => $cancelado,
                        'clase' => $claseId,
                        'estado' => 1,
                    )
                );
            } elseif ($claseId != 0 and $sedeOperativaId != 0) {
                $vehiculos = $em->getRepository('AppBundle:Vehiculo')->findBy(
                    array(
                        'pignorado' => $pignorado,
                        'cancelado' => $cancelado,
                        'clase' => $claseId,
                        'sedeOperativa' => $sedeOperativaId,
                        'estado' => 1,
                    )
                );
            }

            if (count($vehiculos) > 0) {
                $response = array(
                    'status' => 'success',
                    'code' => 500,
                    'data' => $vehiculos,
                );
            } else {
                $response = array(
                    'status' => 'notFound',
                    'code' => 600,
                    'msj' => "No se encontraron registros con los parametros seleccionados",
                );
            }

        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no validaaaaaaa",
            );
        }

        return $helpers->json($response);
    }

    /**
     * Displays a form to asignacionPlca an existing Vehiculo entity.
     *
     * @Route("/asignacionPlaca", name="vehiculo_asignacionPlaca")
     * @Method({"GET", "POST"})
     */

    public function asignacionPlaca(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);

            $placa = $params->placa;
            $sedeOperativaId = $params->sedeOperativaId;

            $em = $this->getDoctrine()->getManager();
            $sedeOperativa = $em->getRepository('AppBundle:SedeOperativa')->find($sedeOperativaId);
            //bucar en una tabla x
            $CfgPlaca = $em->getRepository('AppBundle:CfgPlaca')->findOneByNumero($placa);

            $em = $this->getDoctrine()->getManager();
            $vehiculo = $em->getRepository("AppBundle:Vehiculo")->find($params->id);

            if ($vehiculo != null) {
                $vehiculo->setPlaca($CfgPlaca);
                $vehiculo->setSedeOperativa($sedeOperativa);
                $CfgPlaca->setEstado('asignado');

                $em = $this->getDoctrine()->getManager();
                $em->persist($vehiculo);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Vehiculo editado con exito",
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El vehiculo no se encuentra en la base de datos",
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida para editar vehiculo",
            );
        }

        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing Vehiculo entity.
     *
     * @Route("/edit/pignorado", name="vehiculo_edit_pignorado")
     * @Method({"GET", "POST"})
     */
    public function editPignoradoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            $pignorado = $params->pignorado;
            $vehiculo = $em->getRepository("AppBundle:Vehiculo")->find($params->id);

            if ($vehiculo != null) {
                $vehiculo->setPignorado($pignorado);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Vehiculo editado con éxito",
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El vehiculo no se encuentra en la base de datos",
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida para editar vehiculo",
            );
        }

        return $helpers->json($response);
    }

    /**
     * busca vehiculos por parametros: vin,placa,chasis,motor,propietario,serie.
     *
     * @Route("/parametros", name="vehiculo_show_parametros")
     * @Method({"POST","GET"})
     */
    public function vehiculoPorParametros(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            $vehiculo = $em->getRepository('AppBundle:Vehiculo')->findOneByParametros($params);
            if ($vehiculo != null) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Vehículo encontrado.",
                    'data' => $vehiculo,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Vehículo no encontrado.",
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 401,
                'msj' => "Autorización no valida.",
            );
        }
        return $helpers->json($response);
    }

    /**
     * busca vehiculos por id para obtener el tipo
     *
     * @Route("/tipo", name="vehiculo_show_tipo")
     * @Method("POST")
     */
    public function vehiculoPorTipo(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            $vehiculoPesado = $em->getRepository('AppBundle:VehiculoRemolque')->findOneByVehiculo($params);
            $vehiculoMaquinaria = $em->getRepository('AppBundle:VehiculoMaquinaria')->findOneByVehiculo($params);
            if ($vehiculoPesado != null) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Pesado",
                    'data' => $vehiculoPesado,
                );
            } else if ($vehiculoMaquinaria != null) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Maquinaria",
                    'data' => $vehiculoMaquinaria,
                );

            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Vehículo no encontrado en maquinaria ni pesado.",
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 401,
                'msj' => "Autorización no valida.",
            );
        }
        return $helpers->json($response);
    }

}
