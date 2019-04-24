<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloVehiculo;
use JHWEB\VehiculoBundle\Entity\VhloCfgPlaca;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

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
                $placa = new VhloCfgPlaca();
                $placa->setNumero(strtoupper($params->placa));

                if ($params->idClase) {
                    $clase = $em->getRepository('JHWEBVehiculoBundle:VhloCfgClase')->find($params->idClase);
                }
                $placa->setTipoVehiculo($clase->getTipoVehiculo());

                $placa->setOrganismoTransito($organismoTransito);
                $placa->setEstado('ASIGNADA');
                $em->persist($placa);
                $em->flush();

                $fechaFactura = $params->fechaFactura;
                $fechaFactura = new \DateTime($fechaFactura);

                $vehiculo = new VhloVehiculo();

                $vehiculo->setPlaca($placa);
                $vehiculo->setOrganismoTransito($organismoTransito);
                $vehiculo->setClase($clase);
                
                $vehiculo->setNumeroFactura($params->numeroFactura);
                $vehiculo->setfechaFactura($fechaFactura);
                $vehiculo->setValor($params->valor);

                $vehiculo->setSerie($params->serie);
                $vehiculo->setVin($params->vin);
                $vehiculo->setChasis($params->chasis);
                $vehiculo->setMotor($params->motor);
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

                $vehiculo->setActivo(true);

                $em->persist($vehiculo);
                $em->flush();
                
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
     * @Route("/{id}/edit", name="vhlovehiculo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, VhloVehiculo $vhloVehiculo)
    {
        $deleteForm = $this->createDeleteForm($vhloVehiculo);
        $editForm = $this->createForm('JHWEB\VehiculoBundle\Form\VhloVehiculoType', $vhloVehiculo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vhlovehiculo_edit', array('id' => $vhloVehiculo->getId()));
        }

        return $this->render('vhlovehiculo/edit.html.twig', array(
            'vhloVehiculo' => $vhloVehiculo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a vhloVehiculo entity.
     *
     * @Route("/{id}/delete", name="vhlovehiculo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, VhloVehiculo $vhloVehiculo)
    {
        $form = $this->createDeleteForm($vhloVehiculo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vhloVehiculo);
            $em->flush();
        }

        return $this->redirectToRoute('vhlovehiculo_index');
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
                'message' => 'Autorizacion no valida para editar', 
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
                                //Revisar$placa->setClase($clase);
                                //Revisar$placa->setSedeOperativa($sedeOperativa);

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

            $placa = $params->placa;
            $sedeOperativaId = $params->sedeOperativaId;

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
    
                    $placa->setEstado('ASIGNADA');
    
                    $em->persist($vehiculo);
                    $em->flush();
    
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => "Vehiculo editado con exito.",
                    );
                }else{
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "El vehiculo ya tiene una placa asignada.",
                    );
                }
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El vehiculo no se encuentra en la base de datos.",
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida para editar vehiculo",
            );
        }

        return $helpers->json($response);
    }
}
