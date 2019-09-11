<?php

namespace JHWEB\FinancieroBundle\Controller;

use JHWEB\FinancieroBundle\Entity\FroTrteSolicitud;
use JHWEB\FinancieroBundle\Entity\FroFacInsumo;
use JHWEB\VehiculoBundle\Entity\VhloCfgPlaca;
use JHWEB\VehiculoBundle\Entity\VhloActaTraspaso;
use JHWEB\VehiculoBundle\Entity\VhloAcreedor;
use JHWEB\VehiculoBundle\Entity\VhloPropietario;
use JHWEB\VehiculoBundle\Entity\VhloTpTarjetaOperacion;
use JHWEB\VehiculoBundle\Entity\VhloTpAsignacion;
use JHWEB\UsuarioBundle\Entity\UserCiudadano;
use JHWEB\UsuarioBundle\Entity\UserLicenciaTransito;
use JHWEB\UsuarioBundle\Entity\UserLicenciaConduccion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Frotrtesolicitud controller.
 *
 * @Route("frotrtesolicitud")
 */
class FroTrteSolicitudController extends Controller
{
    /**
     * Lists all froTrteSolicitud entities.
     *
     * @Route("/", name="frotrtesolicitud_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $tramitesSolicitud = $em->getRepository('JHWEBFinancieroBundle:FroTrteSolicitud')->findBy(
            array(
                'activo' => true
            )
        );

        $response['data'] = array();

        if ($tramitesSolicitud) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($tramitesSolicitud)." registros encontrados", 
                'data'=> $tramitesSolicitud,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new froTrteSolicitud entity.
     *
     * @Route("/new", name="frotrtesolicitud_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            
            $factura = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->find(
                $params->idFactura
            );

            $documentacionCompleta = true;
            $certificadoTradicion = false;

            if ($params->documentacionPendiente) {
                foreach ($params->documentacionPendiente as $key => $novedad) {
                    $tramiteFactura = $em->getRepository('JHWEBFinancieroBundle:FroFacTramite')->find(
                        $novedad->idTramiteFactura
                    );

                    if ($tramiteFactura) {
                        $tramiteFactura->setDocumentacion($novedad->documentacion);
                        $tramiteFactura->setObservacion($novedad->observacion);
                    }

                    $em->flush();
                }

                $factura->setEstado('PENDIENTE DOCUMENTACION');
            
                $em->flush();

                $response = array(
                    'status' => 'warning',
                    'code' => 401,
                    'message' => 'Esta factura estara pendiente hasta que se entregue la documentación completa o se anule.',
                    'data' => array(
                        'factura' => $factura
                    )
                );
            }else{
                if (isset($params->numeroRunt) || (isset($params->idModulo) && $params->idModulo == 6) || (count($params->tramitesRealizados) == 1)) {
                    if(isset($params->idModulo) && $params->idModulo == 6){
                        $numeroRuntOld = false;
                    } elseif (isset($params->numeroRunt)) {
                        $numeroRuntOld = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->findOneByNumeroRunt(
                            $params->numeroRunt
                        );
                    } else {
                        $tramiteFactura = $em->getRepository('JHWEBFinancieroBundle:FroFacTramite')->find(
                            $params->tramitesRealizados[0]->idTramiteFactura
                        );

                        if ($tramiteFactura->getPrecio()->getTramite()->getId() == 30) {
                            $numeroRuntOld = false;
                        } else {
                            $response = array(
                                'title' => 'Atención!',
                                'status' => 'warning',
                                'code' => 400,
                                'message' => 'No se puede terminar el registro porque no ha digitado el número RUNT.',
                            );

                            return $helpers->json($response);
                        }
                    }
                    
                    if ($numeroRuntOld) {
                        $response = array(
                            'title' => 'Atención!',
                            'status' => 'warning',
                            'code' => 400,
                            'message' => 'El número RUNT que digito ya fue asignado.'
                        );
                    }else{
                        if (isset($params->numeroRunt)) {
                            $factura->setNumeroRunt($params->numeroRunt);
                            $em->flush();
                        }

                        foreach ($params->tramitesRealizados as $key => $tramiteRealizado) {
                            if ($tramiteRealizado->idTramiteFactura) {
                                $tramiteFactura = $em->getRepository('JHWEBFinancieroBundle:FroFacTramite')->find(
                                    $tramiteRealizado->idTramiteFactura
                                );
                                
                                if ($tramiteFactura) {    
                                    if ($tramiteFactura->getPrecio()->getTramite()->getId() == 30) {
                                        $certificadoTradicion = true;
                                    }
                                    
                                    if (!$tramiteFactura->getRealizado()) {
                                        $funcionario = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->find(
                                            $params->idFuncionario
                                        );
                                        
                                        if (isset($params->idVehiculo) && $params->idVehiculo) {
                                            $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->find(
                                                $params->idVehiculo
                                            );
                                            $vehiculoUpdate = $this->vehiculoUpdateAction($tramiteRealizado->foraneas, $params->idVehiculo);
        
                                            if ($vehiculoUpdate) {
                                                $tramiteSolicitud = new FroTrteSolicitud();
                
                                                $tramiteSolicitud->setTramiteFactura($tramiteFactura);
                
                                                $tramiteSolicitud->setFecha(new \DateTime(date('Y-m-d')));
                                                $tramiteSolicitud->setHora(new \DateTime(date('h:i:s')));
                
                                                $tramiteSolicitud->setForaneas(
                                                    (array)$tramiteRealizado->foraneas
                                                );
                                                
                                                $tramiteSolicitud->setResumen($tramiteRealizado->resumen);
                                                $tramiteSolicitud->setActivo(true);
                
                                                $tramiteSolicitud->setVehiculo($vehiculo);
                
                                                if (isset($params->idCiudadano) && $params->idCiudadano) {
                                                    $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->find(
                                                        $params->idCiudadano
                                                    );
                                                    $tramiteSolicitud->setCiudadano($ciudadano);
                                                }
                
                                                if (isset($params->idSolicitante) && $params->idSolicitante) {
                                                    $solicitante = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->find(
                                                        $params->idSolicitante
                                                    );
                                                    $tramiteSolicitud->setSolicitante($solicitante);
                                                }
                
                                                $tramiteSolicitud->setTramiteFactura($tramiteFactura);
                                                $tramiteSolicitud->setFuncionario($funcionario);
                                                $tramiteSolicitud->setOrganismoTransito($funcionario->getOrganismoTransito());
                
                                                $tramiteSolicitud->setNumeroFolios($params->numeroFolios);
                                                $tramiteSolicitud->setNumeroArchivador($params->numeroArchivador);
                                                $tramiteSolicitud->setBandeja($params->bandeja);
                                                $tramiteSolicitud->setNumeroCaja($params->numeroCaja);
                                                
                                                $tramiteFactura->setRealizado(true);

                                                $em->persist($tramiteSolicitud);
                                                $em->flush();
                
                                                if(isset($params->numeroActa)){
                                                    $vhloActaTraspaso = new VhloActaTraspaso();
                
                                                    $vhloActaTraspaso->setTramiteSolicitud($tramiteSolicitud);
                
                                                    $vhloActaTraspaso->setNumero($params->numeroActa);
                                                    $vhloActaTraspaso->setFecha(
                                                        new \DateTime($params->fechaActa)
                                                    );
                
                                                    $entidadJudicial = $em->getRepository('JHWEBConfigBundle:CfgEntidadJudicial')->find(
                                                        $params->idEntidadJudicial
                                                    );
                                                    $vhloActaTraspaso->setEntidadJudicial($entidadJudicial);
                
                                                    $em->persist($vhloActaTraspaso);
                                                    $em->flush();
                                                }
                                            }
                                        }else{
                                            $usuarioUpdate = $this->usuarioUpdateAction($tramiteRealizado->foraneas);
        
                                            if ($usuarioUpdate) {
                                                $tramiteFactura->setDocumentacion($tramiteRealizado->documentacion);
                
                                                $tramiteSolicitud = new FroTrteSolicitud();
                
                                                $tramiteSolicitud->setTramiteFactura($tramiteFactura);
                
                                                $tramiteSolicitud->setFecha(new \DateTime(date('Y-m-d')));
                                                $tramiteSolicitud->setHora(new \DateTime(date('h:i:s')));
                
                                                $tramiteSolicitud->setForaneas(
                                                    (array)$tramiteRealizado->foraneas
                                                );
                                                
                                                $tramiteSolicitud->setResumen($tramiteRealizado->resumen);
                                                $tramiteSolicitud->setActivo(true);
                
                                                if (isset($params->idSolicitante) && $params->idSolicitante) {
                                                    $solicitante = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->find(
                                                        $params->idSolicitante
                                                    );
                                                    $tramiteSolicitud->setSolicitante($solicitante);
                                                }
                
                                                $tramiteSolicitud->setTramiteFactura($tramiteFactura);
                                                $tramiteSolicitud->setFuncionario($funcionario);
                                                $tramiteSolicitud->setOrganismoTransito($funcionario->getOrganismoTransito());
                
                                                $tramiteFactura->setRealizado(true);
                
                                                $em->persist($tramiteSolicitud);
                                                $em->flush();
                                            }
                                        }                      
                                    }
                                }
                            }
                        }
        
                        $factura->setEstado('FINALIZADA');
                        
                        $em->flush();
                        
                        if ($params->insumoEntregado) {
                            $facturaInsumo = new FroFacInsumo();
            
                            $facturaInsumo->setFactura($factura);
        
                            $facturaInsumo->setFecha(new \DateTime(date('Y-m-d')));
                            $facturaInsumo->setdescripcion($params->insumoEntregado->descripcion);
                            $facturaInsumo->setEntregado(true);
        
                            if ($params->insumoEntregado->idCiudadano) {
                                $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->find(
                                    $params->insumoEntregado->idCiudadano
                                );
                                $facturaInsumo->setCiudadano($ciudadano);
                            }
        
                            if ($params->insumoEntregado->idInsumo) {
                                $insumo = $em->getRepository('JHWEBInsumoBundle:ImoInsumo')->find(
                                    $params->insumoEntregado->idInsumo
                                );
                                $facturaInsumo->setInsumo($insumo);
                                $insumo->setEstado('ASIGNADO');
                            }
        
                            $em->persist($facturaInsumo);
                            $em->flush();
        
                            //Insertar licencia de conducción o tránsito
                            if ($insumo) {
                                if ($insumo->getTipo()->getNombre() == 'SUSTRATO') {
                                    if ($insumo->getTipo()->getId() == 1) {
                                        //Si el tipo de insumo es Licencia de Conducción
                                        $licenciaConduccion = new UserLicenciaConduccion();
                                        
                                        $licenciaConduccion->setFechaExpedicion(new \Datetime(date('Y-m-d')));
                                        $licenciaConduccion->setFechavencimiento(new \Datetime(date('Y-m-d')));
                                        $licenciaConduccion->setNumero($params->insumoEntregado->licenciaConduccion);
                                        $licenciaConduccion->setEstado('ACTIVA');
                                        $licenciaConduccion->setActivo(true);
        
                                        $licenciaConduccion->setFuncionario($funcionario->getOrganismoTransito());
                                        $licenciaConduccion->setCiudadano($solicitante);
        
                                        $em->persist($licenciaConduccion);
                                        $em->flush();
                                    }elseif ($insumo->getTipo()->getId() == 2) {
                                        //Si el tipo de insumo es Licencia de Transito
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
                                }
                            }
                        }
        
                        if ($certificadoTradicion) {
                            $response = array(
                                'status' => 'success',
                                'code' => 200,
                                'message' => 'Todos los trámites de la factura fueron registrados con exito, recuerde imprimir el certificado de tradición.',
                                'data' => array(
                                    'factura' => $factura,
                                    'certificadoTradicion' => $certificadoTradicion,
                                    'idVehiculo' => $vehiculo->getId(),
                                )
                            );
                        }else{
                            $response = array(
                                'status' => 'success',
                                'code' => 200,
                                'message' => 'Todos los trámites de la factura fueron registrados con exito.',
                                'data' => array(
                                    'factura' => $factura
                                )
                            );
                        }
                    }
                    //Cierre validación numero RUNT
                }else{
                    $response = array(
                        'title' => 'Atención!',
                        'status' => 'warning',
                        'code' => 400,
                        'message' => 'No se puede terminar el registro porque no ha digitado el número RUNT.',
                    );
                }
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
     * Finds and displays a froTrteSolicitud entity.
     *
     * @Route("/{id}", name="frotrtesolicitud_show")
     * @Method("GET")
     */
    public function showAction(FroTrteSolicitud $froTrteSolicitud)
    {
        $deleteForm = $this->createDeleteForm($froTrteSolicitud);

        return $this->render('frotrtesolicitud/show.html.twig', array(
            'froTrteSolicitud' => $froTrteSolicitud,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing froTrteSolicitud entity.
     *
     * @Route("/{id}/edit", name="frotrtesolicitud_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FroTrteSolicitud $froTrteSolicitud)
    {
        $deleteForm = $this->createDeleteForm($froTrteSolicitud);
        $editForm = $this->createForm('JHWEB\FinancieroBundle\Form\FroTrteSolicitudType', $froTrteSolicitud);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('frotrtesolicitud_edit', array('id' => $froTrteSolicitud->getId()));
        }

        return $this->render('frotrtesolicitud/edit.html.twig', array(
            'froTrteSolicitud' => $froTrteSolicitud,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a froTrteSolicitud entity.
     *
     * @Route("/{id}", name="frotrtesolicitud_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FroTrteSolicitud $froTrteSolicitud)
    {
        $form = $this->createDeleteForm($froTrteSolicitud);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($froTrteSolicitud);
            $em->flush();
        }

        return $this->redirectToRoute('frotrtesolicitud_index');
    }

    /**
     * Creates a form to delete a froTrteSolicitud entity.
     *
     * @param FroTrteSolicitud $froTrteSolicitud The froTrteSolicitud entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FroTrteSolicitud $froTrteSolicitud)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('frotrtesolicitud_delete', array('id' => $froTrteSolicitud->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ================================================ */

    public function vehiculoUpdateAction($params, $idVehiculo)
    {    
        $helpers = $this->get("app.helpers");
               
        $em = $this->getDoctrine()->getManager();

        $vehiculo = $em->getRepository("JHWEBVehiculoBundle:VhloVehiculo")->find(
            $idVehiculo
        );

        if ($vehiculo) {
            if (isset($params->campos)) {
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
                                $params->placaNueva
                            );
    
                            if (!$placa) {
                                $placa = new VhloCfgPlaca();
    
                                $placa->setNumero(
                                    strtoupper($params->placaNueva)
                                );

                                if ($vehiculo->getPlaca()) {
                                    $placa->setTipoVehiculo($vehiculo->getPlaca()->getTipoVehiculo());
                                }elseif ($vehiculo->getClase()) {
                                    $placa->setTipoVehiculo($vehiculo->getClase()->getTipoVehiculo());
                                }
                                $placa->setEstado('UTILIZADA');
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
                            $vehiculo->setNumeroEjes($params->ejesTotal);
                            break;
                            
                        case 'cancelacionmatricula':
                            $vehiculo->setCancelado(true);
                            $placa = $vehiculo->getPlaca();
                            $placa->setEstado('CANCELADA');
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

                        case 'radicado':
                            $placa = $vehiculo->getPlaca();
                            $placa->setEstado('SOLICITADA');
                            $vehiculo->setActivo(true);
                            break;

                        case 'matriculaInicial':
                            $this->vehiculoPropietarioRegisterAction($params);
                            break;
    
                        case 'registrarPignorado':
                            $this->vehiculoAcreedorRegisterAction($params);
                            break;

                        case 'cambioAcreedor':
                            $this->vehiculoAcreedorUpdateAction($params);
                            break;

                        case 'eliminarPignorado':
                            $this->vehiculoAcreedorDeleteAction($params);
                            break;

                        case 'traspaso':
                            $this->vehiculoPropietarioUpdateAction($params);
                            break;

                        case 'traspasoIndeterminada':
                            $this->vehiculoIndeterminadaUpdateAction($params);
                            break;

                        case 'expedicionTarjetaOperacion':
                            $this->vehiculoExpedicionTarjetaOperacionAction($params);
                            break;

                        case 'duplicadoTarjetaOperacion':
                            $this->vehiculoDuplicadoTarjetaOperacionAction($params);
                            break;

                        case 'cambioNivelServicio':
                            $this->vehiculoCambioNivelServicioAction($params);
                            break;
                        case 'renovacionTarjetaOperacion':
                            $this->vehiculoRenovacionTarjetaOperacionAction($params);
                            break;
                        case 'cambioEmpresa':
                            $this->vehiculoCambioEmpresaAction($params);
                            break;
                        case 'conceptoFavorable':
                            $this->vehiculoConceptoFavorableAction($params);
                            break;
                        case 'desvinculacionCambioServicio':
                            $this->vehiculoDesvinculacionCambioServicioAction($params);
                            break;
                        case 'desvinculacionComunAcuerdo':
                            $this->vehiculoDesvinculacionComunAcuerdoAction($params);
                            break;
                    }
                }
    
                $em->flush();
            }

            return true;
        } else {
            return false;
        }
       

        return $helpers->json($response);
    }

    public function vehiculoPropietarioRegisterAction($params)
    {        
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();  

        if ($params->idVehiculo) {
            $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->find(
                $params->idVehiculo
            );
        }

        if ($vehiculo) {
            $placa = $vehiculo->getPlaca();
            $placa->setEstado('FABRICADA');
            $em->flush();
            foreach ($params->propietarios as $key => $propietarioArray) {
                $propietario = new VhloPropietario();

                if ($propietarioArray->tipo == 'Empresa') {
                    $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->findOneBy(
                        array(
                            'id' => $propietarioArray->id,
                            'activo' => true,
                        )
                    );

                    $propietario->setEmpresa($empresa);
                }elseif ($propietarioArray->tipo == 'Ciudadano') {
                    $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findOneBy(
                        array(
                            'id' => $propietarioArray->id,
                            'activo' => true,
                        )
                    );

                    $propietario->setCiudadano($ciudadano);
                }

                if ($propietarioArray->idApoderado) {
                    $apoderado = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findOneBy(
                        array(
                            'id' => $propietarioArray->idApoderado,
                            'activo' => true,
                        )
                    );

                    $propietario->setApoderado($apoderado);
                }

                $propietario->setPermiso($propietarioArray->permiso);
                $propietario->setFechaInicial(new \Datetime(date('Y-m-d')));

                if ($params->tipoPropiedad == 1) {
                    $propietario->setLeasing(true);
                }else{
                    $propietario->setLeasing(false);
                }

                $propietario->setActivo(true);

                $propietario->setVehiculo($vehiculo);

                $em->persist($propietario);
                $em->flush();
            }

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Propietario creado con exito.', 
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Vehiculo no encontrado.', 
            );
        }                    
       
        return $helpers->json($response);
    }

    public function vehiculoAcreedorRegisterAction($params)
    {        
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();  

        if ($params->idVehiculo) {
            $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->find(
                $params->idVehiculo
            );
        }

        if ($vehiculo) {
            $propietario = $em->getRepository('JHWEBVehiculoBundle:VhloPropietario')->findOneBy(
                array(
                    'ciudadano' => $params->idSolicitante,
                    'vehiculo' => $vehiculo->getId(),
                    'activo' => true,
                )
            );

            if ($propietario->getCiudadano()) {
                $acreedorOld = $em->getRepository('JHWEBVehiculoBundle:VhloAcreedor')->findOneBy(
                    array(
                        'ciudadano' => $propietario->getCiudadano()->getId(),
                        'vehiculo' => $vehiculo->getId(),
                        'activo' => true,
                    )
                );
            } elseif($propietario->getEmpresa()) {
                $acreedorOld = $em->getRepository('JHWEBVehiculoBundle:VhloAcreedor')->findOneBy(
                    array(
                        'empresa' => $propietario->getEmpresa()->getId(),
                        'vehiculo' => $vehiculo->getId(),
                        'activo' => true,
                    )
                );
            }

            if (!$acreedorOld) {
                $acreedor = new VhloAcreedor();

                if ($params->idEmpresa) {
                    $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->findOneBy(
                        array(
                            'id' => $params->idEmpresa,
                            'activo' => true,
                        )
                    );

                    $acreedor->setEmpresa($empresa);
                }elseif ($params->idCiudadano) {
                    $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findOneBy(
                        array(
                            'id' => $params->idCiudadano,
                            'activo' => true,
                        )
                    );

                    $acreedor->setCiudadano($ciudadano);
                }

                $acreedor->setPropietario($propietario);

                $tipoAlerta = $em->getRepository('JHWEBVehiculoBundle:VhloCfgTipoAlerta')->find(
                    $params->idTipoAlerta
                );
                $acreedor->setTipoAlerta($tipoAlerta);

                $acreedor->setGradoAlerta($params->gradoAlerta);
                $acreedor->setActivo(true);
                $acreedor->setVehiculo($vehiculo);

                $vehiculo->setPignorado(true);

                $em->persist($acreedor);
                $em->flush();
                
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Registro creado con exito.', 
                );
            }else{
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'El propietario no puede ser el mismo acreedor.', 
                ); 
            }
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => 'Vehiculo no encontrado.', 
            );
        }                    

        return $helpers->json($response);
    }

    //Actualiza el acreedor prendario
    public function vehiculoAcreedorUpdateAction($params)
    {        
        $helpers = $this->get("app.helpers");
            
        $em = $this->getDoctrine()->getManager();  

        if ($params->idVehiculo) {
            $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->find(
                $params->idVehiculo
            );
        }

        if ($vehiculo) {
            if ($params->tipo == 'ACREEDOR') {
                $acreedorOld = null;

                if ($params->idCiudadano) {
                    $propietario = $em->getRepository('JHWEBVehiculoBundle:VhloPropietario')->findOneBy(
                        array(
                            'ciudadano' => $params->idCiudadano,
                            'vehiculo' => $params->idVehiculo,
                            'activo' => true,
                        )
                    );
                }elseif ($params->idEmpresa) {
                    $propietario = $em->getRepository('JHWEBVehiculoBundle:VhloPropietario')->findOneBy(
                        array(
                            'empresa' => $params->idCiudadano,
                            'vehiculo' => $params->idVehiculo,
                            'activo' => true,
                        )
                    );
                }
                
                if ($propietario) {
                    if ($propietario->getCiudadano()) {
                        $acreedorOld = $em->getRepository('JHWEBVehiculoBundle:VhloAcreedor')->findOneBy(
                            array(
                                'ciudadano' => $propietario->getCiudadano()->getId(),
                                'vehiculo' => $vehiculo->getId(),
                                'activo' => true,
                            )
                        );
                    } elseif($propietario->getEmpresa()) {
                        $acreedorOld = $em->getRepository('JHWEBVehiculoBundle:VhloAcreedor')->findOneBy(
                            array(
                                'empresa' => $propietario->getEmpresa()->getId(),
                                'vehiculo' => $vehiculo->getId(),
                                'activo' => true,
                            )
                        );
                    }
                }

                if (!$acreedorOld) {
                    $acreedorOld = $em->getRepository('JHWEBVehiculoBundle:VhloAcreedor')->find(
                        $params->idAcreedor
                    );

                    $acreedorOld->setActivo(false);

                    $acreedor = new VhloAcreedor();

                    if ($params->idEmpresa) {
                        $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->findOneBy(
                            array(
                                'id' => $params->idEmpresa,
                                'activo' => true,
                            )
                        );

                        $acreedor->setEmpresa($empresa);
                    }elseif ($params->idCiudadano) {
                        $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findOneBy(
                            array(
                                'id' => $params->idCiudadano,
                                'activo' => true,
                            )
                        );

                        $acreedor->setCiudadano($ciudadano);
                    }

                    $acreedor->setGradoAlerta($acreedorOld->getGradoAlerta());
                    $acreedor->setTipoAlerta($acreedorOld->getTipoAlerta());
                    
                    $acreedor->setActivo(true);

                    $acreedor->setVehiculo($vehiculo);

                    $em->persist($acreedor);
                    $em->flush();

                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => 'Registros actualizados con exito.', 
                    );
                }else{
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => 'El propietario no puede ser el mismo acreedor.', 
                    ); 
                }
            }elseif ($params->tipo == 'PROPIETARIO') {
                $propietario = $em->getRepository('JHWEBVehiculoBundle:VhloPropietario')->findOneBy(
                    array(
                        'id' => $params->idPropietarioNew,
                        'activo' => true,
                    )
                );

                if ($propietario->getCiudadano()) {
                    $acreedorOld = $em->getRepository('JHWEBVehiculoBundle:VhloAcreedor')->findOneBy(
                        array(
                            'ciudadano' => $propietario->getCiudadano()->getId(),
                            'vehiculo' => $vehiculo->getId(),
                            'activo' => true,
                        )
                    );
                } elseif($propietario->getEmpresa()) {
                    $acreedorOld = $em->getRepository('JHWEBVehiculoBundle:VhloAcreedor')->findOneBy(
                        array(
                            'empresa' => $propietario->getEmpresa()->getId(),
                            'vehiculo' => $vehiculo->getId(),
                            'activo' => true,
                        )
                    );
                }

                if (!$acreedorOld) {
                    $acreedorOld = $em->getRepository('JHWEBVehiculoBundle:VhloAcreedor')->findOneBy(
                        array(
                            'id' => $params->idAcreedor,
                            'activo' => true,
                        )
                    );

                    $acreedorOld->setActivo(false);

                    $acreedor = new VhloAcreedor();

                    $acreedor->setPropietario($propietario);

                    if ($acreedorOld->getEmpresa()) {
                        $acreedor->setEmpresa(
                            $acreedorOld->getEmpresa()
                        );
                    }elseif ($acreedorOld->getCiudadano()) {
                        $acreedor->setCiudadano(
                            $acreedorOld->getCiudadano()
                        );
                    }

                    $acreedor->setGradoAlerta(
                        $acreedorOld->getGradoAlerta()
                    );
                    $acreedor->setTipoAlerta(
                        $acreedorOld->getTipoAlerta()
                    );
                    
                    $acreedor->setActivo(true);

                    $acreedor->setVehiculo($vehiculo);

                    $em->persist($acreedor);
                    $em->flush();

                    $response = array(
                        'title' => 'Perfecto!',
                        'status' => 'success',
                        'code' => 200,
                        'message' => 'Registros actualizados con exito.', 
                    );
                }else{
                    $response = array(
                        'title' => 'Error!',
                        'status' => 'error',
                        'code' => 400,
                        'message' => 'El propietario no puede ser el mismo acreedor.', 
                    ); 
                }
            }
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => 'Vehiculo no encontrado.', 
            );
        }                    
        

        return $helpers->json($response);
    }

    public function vehiculoAcreedorDeleteAction($params)
    {     
        $helpers = $this->get("app.helpers");
              
        $em = $this->getDoctrine()->getManager();

        $acreedor = $em->getRepository('JHWEBVehiculoBundle:VhloAcreedor')->find(
            $params->idAcreedor
        );

        $acreedor->getVehiculo()->setPignorado(false);
        $acreedor->setActivo(false);

        $em->flush();

        $response = array(
            'title' => 'Perfecto!',
            'status' => 'success',
            'code' => 200,
            'message' => "Registro eliminado con éxito.", 
        );

        return $helpers->json($response);
    }

    public function vehiculoPropietarioUpdateAction($params)
    {
        $helpers = $this->get("app.helpers");
       
        $em = $this->getDoctrine()->getManager();

        foreach ($params->retenciones as $key => $retencion) {
            $propietario = $em->getRepository('JHWEBVehiculoBundle:VhloPropietario')->find(
               $retencion->propietario->id
            );

            if ($propietario) {
                $propietario->setFechaFinal(new \DateTime(date('Y-m-d')));
                $propietario->setActivo(false);

                $em->flush();
            }
        }

        foreach ($params->propietarios as $key => $propietario) {
            $propietarioNew = new VhloPropietario();

            if ($propietario->tipo == 'EMPRESA') {
                $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->findOneBy(
                    array(
                        'id' => $propietario->id,
                        'activo' => true,
                    )
                );

                $propietarioNew->setEmpresa($empresa);
            }elseif ($propietario->tipo == 'CIUDADANO') {
                $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findOneBy(
                    array(
                        'id' => $propietario->id,
                        'activo' => true,
                    )
                );

                $propietarioNew->setCiudadano($ciudadano);
            }

            if ($propietario->tipoPropiedad == 1) {
                $propietarioNew->setLeasing(true);
            }else{
                $propietarioNew->setLeasing(false);
            }

            $propietarioNew->setFechaInicial(new \DateTime(date('Y-m-d')));
            $propietarioNew->setVehiculo($propietario->getVehiculo());
            $propietarioNew->setPermiso($params->permiso);
            $propietarioNew->setActivo(true);

            $em->persist($propietarioNew);
            $em->flush();
        
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Propietario actualizado con exito.',
                'data' => $propietarioNew
            );
        }
        
        return $helpers->json($response);
    }

    //Actualiza el propietario a persona indeterminada
    public function vehiculoIndeterminadaUpdateAction($params)
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $propietario = $em->getRepository('JHWEBVehiculoBundle:VhloPropietario')->findOneBy(
            array(
                'id' => $params->idPropietario,
                'activo' => true,
            )
        );

        if ($propietario) {
            $propietario->setFechaFinal(new \DateTime(date('Y-m-d')));
            $propietario->setActivo(false);

            $propietarioNew = new VhloPropietario();

            if ($params->idEmpresa) {
                $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->findOneBy(
                    array(
                        'id' => $params->idEmpresa,
                        'activo' => true,
                    )
                );

                $propietarioNew->setEmpresa($empresa);
            }elseif ($params->idCiudadano) {
                $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findOneBy(
                    array(
                        'id' => $params->idCiudadano,
                        'activo' => true,
                    )
                );

                $propietarioNew->setCiudadano($ciudadano);
            }

            if ($params->tipoPropiedad == 1) {
                $propietarioNew->setLeasing(true);
            }else{
                $propietarioNew->setLeasing(false);
            }

            $propietarioNew->setFechaInicial(new \DateTime(date('Y-m-d')));
            $propietarioNew->setVehiculo($propietario->getVehiculo());
            $propietarioNew->setPermiso($params->permiso);
            $propietarioNew->setActivo(true);

            $em->persist($propietarioNew);
            $em->flush();
        
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Propietario actualizado con exito.',
                'data' => $propietarioNew
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'El solicitante no es propietario del vehiculo.', 
            );
        }            
       
        return $helpers->json($response);
    }

    //expedición de la tarjeta de operacion a un vehiculo de servicio público
    public function vehiculoExpedicionTarjetaOperacionAction($params)
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        
        $cupo = $em->getRepository('JHWEBVehiculoBundle:VhloTpAsignacion')->findOneBy(
            array(
                'vehiculo' => $params->idVehiculo,
                'activo' => true,
                )
            );
        
        $tarjetaOperacion = $em->getRepository('JHWEBVehiculoBundle:VhloTpTarjetaOperacion')->findOneBy(
            array(
                'vehiculo' => $params->idVehiculo,
                'activo' => true,
                )
            );

        if($tarjetaOperacion){
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => 'La tarjeta de operación para este vehículo ya fue expedida, puede realizar un duplicado.', 
            );
        } else {
            if($cupo) {
                $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->find($params->idVehiculo);
                    
                $tarjetaOperacionNew = new VhloTpTarjetaOperacion();
                $tarjetaOperacionNew->setFechaVencimiento(new \Datetime($params->fechaVencimiento));
                $tarjetaOperacionNew->setNumeroTarjetaOperacion($params->numeroTarjetaOperacion);
                $tarjetaOperacionNew->setVehiculo($vehiculo);
                $tarjetaOperacionNew->setActivo(true);

                /* $tarjetaOperacion->setActivo(false); */
                
                /* $em->persist($tarjetaOperacion); */
                $em->persist($tarjetaOperacionNew);
                $em->flush();
            
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Tarjeta de Operación expedida con éxito.',
                    'data' => $tarjetaOperacionNew
                );
            
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'No encontró un cupo asignado al vehiculo, por favor asigne un cupo para el vehículo.', 
                );
            }
        }        
        return $helpers->json($response);
    }

    //Actualiza el propietario a persona indeterminada
    public function vehiculoDuplicadoTarjetaOperacionAction($params)
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $tarjetaOperacion = $em->getRepository('JHWEBVehiculoBundle:VhloTpTarjetaOperacion')->findOneBy(
            array(
                'id' => $params->idTarjetaOperacion,
                'activo' => true,
            )
        );

        if($tarjetaOperacion) {
            $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->find($params->idVehiculo);

            $tarjetaOperacionNew = new VhloTpTarjetaOperacion();
            $tarjetaOperacionNew->setFechaVencimiento(new \Datetime($params->fechaVencimiento));
            $tarjetaOperacionNew->setNumeroTarjetaOperacion($params->nuevoNumeroTarjetaOperacion);
            $tarjetaOperacionNew->setVehiculo($vehiculo);
            $tarjetaOperacionNew->setActivo(true);
            
            $tarjetaOperacion->setActivo(false);

            $em->persist($tarjetaOperacion);
            $em->persist($tarjetaOperacionNew);
            $em->flush();
        
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Tarjeta de Operación actualizado con exito.',
                'data' => $tarjetaOperacionNew
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'No se encontró la tarjeta de operación actual del vehiculo.', 
            );
        }            
       
        return $helpers->json($response);
    }

    //Actualiza el propietario a persona indeterminada
    public function vehiculoCambioNivelServicioAction($params)
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $cupo = $em->getRepository('JHWEBVehiculoBundle:VhloTpAsignacion')->findOneBy(
            array(
                'vehiculo' => $params->idVehiculo,
                'activo' => true,
            )
        );

        $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->find($params->idVehiculo);
        
        if($cupo) {
            $nivelServicioNew = $em->getRepository('JHWEBVehiculoBundle:VhloCfgNivelServicio')->findOneBy(
                array(
                    'id' => $params->idNivelServicioNuevo,
                    'activo' => true,
                )
            );    

            $cupo->setActivo(false);

            $cupoNew = new VhloTpAsignacion();

            $cupoNew->setEmpresaTransporte($cupo->getEmpresaTransporte());
            $cupoNew->setVehiculo($cupo->getVehiculo());
            $cupoNew->setCupo($cupo->getCupo());
            $cupoNew->setNivelServicio($nivelServicioNew);
            $cupoNew->setActivo(true);

            $em->persist($cupo);
            $em->persist($cupoNew);

            $tarjetaOperacion = $em->getRepository('JHWEBVehiculoBundle:VhloTpTarjetaOperacion')->findOneBy(
                array(
                    'vehiculo' => $params->idVehiculo,
                    'activo' => true,
                )
            );

            if($tarjetaOperacion) {

                $tarjetaOperacionNew = new VhloTpTarjetaOperacion();
                $tarjetaOperacionNew->setFechaVencimiento(new \Datetime($params->fechaVigencia));
                $tarjetaOperacionNew->setNumeroTarjetaOperacion($params->nuevoNumeroTarjetaOperacion);
                $tarjetaOperacionNew->setVehiculo($vehiculo);
                $tarjetaOperacionNew->setActivo(true);
                
                $tarjetaOperacion->setActivo(false);

                $em->persist($tarjetaOperacion);
                $em->persist($tarjetaOperacionNew);
                $em->flush();
            
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Tarjeta de Operación actualizada con exito.',
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'No se encontró la tarjeta de operación actual del vehiculo.', 
                );
            }     
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'No se encontró cupo actual para el vehiculo.', 
            );
        }       
        return $helpers->json($response);
    }

    //Actualiza el propietario a persona indeterminada
    public function vehiculoRenovacionTarjetaOperacionAction($params)
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $tarjetaOperacion = $em->getRepository('JHWEBVehiculoBundle:VhloTpTarjetaOperacion')->findOneBy(
            array(
                'id' => $params->idTarjetaOperacion,
                'activo' => true,
            )
        );

        
        if($tarjetaOperacion) {
            $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->find($params->idVehiculo);

            $tarjetaOperacionNew = new VhloTpTarjetaOperacion();
            $tarjetaOperacionNew->setFechaVencimiento(new \Datetime($params->fechaVencimiento));
            $tarjetaOperacionNew->setNumeroTarjetaOperacion($params->nuevoNumeroTarjetaOperacion);
            $tarjetaOperacionNew->setVehiculo($vehiculo);
            $tarjetaOperacionNew->setActivo(true);
            
            $tarjetaOperacion->setActivo(false);

            $em->persist($tarjetaOperacion);
            $em->persist($tarjetaOperacionNew);
            $em->flush();
        
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Tarjeta de Operación actualizado con exito.',
                'data' => $tarjetaOperacionNew
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'No se encontró la tarjeta de operación actual del vehiculo.', 
            );
        }            
       
        return $helpers->json($response);
    }

    //desvincula un vehiculo de transporte público
    public function vehiculoDesvinculacionCambioServicioAction($params)
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->find($params->idVehiculo);

        $servicioNew = $em->getRepository('JHWEBVehiculoBundle:VhloCfgServicio')->find($params->idServicioNuevo);

        $vehiculo->setServicio($servicioNew);

        $asignacion = $em->getRepository('JHWEBVehiculoBundle:VhloTpAsignacion')->findOneBy(
            array(
                'vehiculo' => $params->idVehiculo,
                'activo' => true
            )
        );
        
        if($asignacion) {
            $asignacion->setActivo(false);

            $cupo = $em->getRepository('JHWEBVehiculoBundle:VhloTpCupo')->find($asignacion->getId());
            $cupo->setEstado('DISPONIBLE');
            
            $tarjetaOperacion = $em->getRepository('JHWEBVehiculoBundle:VhloTpTarjetaOperacion')->findOneBy(
                array(
                    'vehiculo' => $params->idVehiculo,
                    'activo' => true
                )
            );

            if($tarjetaOperacion){
                $tarjetaOperacion->setActivo(false);
                $em->persist($tarjetaOperacion);
                
                $em->persist($vehiculo);
                $em->persist($asignacion);
                $em->persist($cupo);
                $em->flush();
            
                $response = 
                    array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => 'Se cambio el servicio del vehiculo con éxito.',
                    );
            } else {
                $response = 
                array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'El vehículo no tiene una tarjeta de operación.',
                );
            }
        } else {
            $response = 
                array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'El vehículo no tiene un cupo.',
                );
        }
                    
        return $helpers->json($response);
    }
    //desvincula un vehiculo de transporte público por cumón acuerdo
    public function vehiculoDesvinculacionComunAcuerdoAction($params)
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->find($params->idVehiculo);

        $asignacion = $em->getRepository('JHWEBVehiculoBundle:VhloTpAsignacion')->findOneBy(
            array(
                'vehiculo' => $params->idVehiculo,
                'activo' => true
            )
        );
        
        $asignacion->setActivo(false);

        $cupo = $em->getRepository('JHWEBVehiculoBundle:VhloTpCupo')->find($asignacion->getId());
        $cupo->setEstado('DISPONIBLE');
        
        $tarjetaOperacion = $em->getRepository('JHWEBVehiculoBundle:VhloTpTarjetaOperacion')->findOneBy(
            array(
                'vehiculo' => $params->idVehiculo,
                'activo' => true
            )
        );

        $tarjetaOperacion->setActivo(false);

        $em->persist($vehiculo);
        $em->persist($asignacion);
        $em->persist($cupo);
        $em->persist($tarjetaOperacion);
        $em->flush();
    
        $response = 
            array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Se desvinculó el vehiculo por común acuerdo.',
            );
                    
        return $helpers->json($response);
    }

    //cambia un vehiculo de empresa de transporte público
    public function vehiculoCambioEmpresaAction($params)
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->find($params->idVehiculo);

        $asignacion = $em->getRepository('JHWEBVehiculoBundle:VhloTpAsignacion')->findOneBy(
            array(
                'vehiculo' => $params->idVehiculo,
                'activo' => true
            )
        );
        
        $asignacion->setActivo(false);
        
        $tarjetaOperacion = $em->getRepository('JHWEBVehiculoBundle:VhloTpTarjetaOperacion')->findOneBy(
            array(
                'vehiculo' => $params->idVehiculo,
                'activo' => true
            )
        );
        
        $tarjetaOperacion->setActivo(false);

        /* $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->findOneBy(
            array(
                'id' => $params->idEmpresaNueva,
                'activo' => true
            )
        ); */

        $empresaTransporte = $em->getRepository('JHWEBUsuarioBundle:UserEmpresaTransporte')->findOneBy(
            array(
                'id' => $params->idEmpresaNueva,
                'activo' => true
                )
            );
        
        $cupo = $em->getRepository('JHWEBVehiculoBundle:VhloTpCupo')->findOneBy(
            array(
                'numero' => $params->numeroCupoActual,
                'activo' => true
            )
        );

        $cupo->setEstado('DISPONIBLE');

        $cupoNew = $em->getRepository('JHWEBVehiculoBundle:VhloTpCupo')->findOneBy(
            array(
                'id' => $params->idCupoNuevo,
                'activo' => true
            )
        );

        $cupoNew->setEstado('UTILIZADO');

        $nivelServicio = $em->getRepository('JHWEBVehiculoBundle:VhloCfgNivelServicio')->findOneBy(
            array(
                'id' => $params->idNivelServicioAnterior,
                'activo' => true
            )
        );


        $em->persist($asignacion);
        $em->persist($cupo);
        $em->persist($cupoNew);
        $em->persist($tarjetaOperacion);

        $asignacionNew = new VhloTpAsignacion();
        $asignacionNew->setEmpresaTransporte($empresaTransporte);
        $asignacionNew->setVehiculo($vehiculo);
        $asignacionNew->setCupo($cupoNew);
        $asignacionNew->setNivelServicio($nivelServicio);
        $asignacionNew->setActivo(true);

        $em->persist($asignacionNew);

        $tarjetaOperacionNew = new VhloTpTarjetaOperacion();
        $tarjetaOperacionNew->setFechaVencimiento(new \Datetime($params->fechaVigencia));
        $tarjetaOperacionNew->setNumeroTarjetaOperacion($params->numeroTarjetaOperacionNuevo);
        $tarjetaOperacionNew->setVehiculo($vehiculo);
        $tarjetaOperacionNew->setActivo(true);

        $em->persist($tarjetaOperacionNew);
        $em->flush();
    
        $response = 
            array(
                'status' => 'success',
                'code' => 200,
                'message' => 'El trámite de cambio de servicio se realizó con éxito',
            );
                    
        return $helpers->json($response);
    }

    //cambia un vehiculo de empresa de transporte público por concepto Favorable
    public function vehiculoConceptoFavorableAction($params)
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->find($params->idVehiculo);

        $asignacion = $em->getRepository('JHWEBVehiculoBundle:VhloTpAsignacion')->findOneBy(
            array(
                'vehiculo' => $params->idVehiculo,
                'activo' => true
            )
        );
        
        $asignacion->setActivo(false);

        $cupo = $em->getRepository('JHWEBVehiculoBundle:VhloTpCupo')->find($asignacion->getId());
        $cupo->setEstado('DISPONIBLE');
        
        $tarjetaOperacion = $em->getRepository('JHWEBVehiculoBundle:VhloTpTarjetaOperacion')->findOneBy(
            array(
                'vehiculo' => $params->idVehiculo,
                'activo' => true
            )
        );
        
        $tarjetaOperacion->setActivo(false);

        $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->findOneBy(
            array(
                'id' => $params->idEmpresaNueva,
                'activo' => true
            )
        );

        $empresaTransporte = $em->getRepository('JHWEBUsuarioBundle:UserEmpresaTransporte')->findOneBy(
            array(
                'empresa' => $empresa->getId(),
                'activo' => true
            )
        );

        $cupoNew = $em->getRepository('JHWEBVehiculoBundle:VhloTpCupo')->findOneBy(
            array(
                'id' => $params->idCupoNuevo,
                'activo' => true
            )
        );

        $cupoNew->setEstado('UTILIZADO');

        $nivelServicio = $em->getRepository('JHWEBVehiculoBundle:VhloCfgNivelServicio')->findOneBy(
            array(
                'id' => $params->idNivelServicioAnterior,
                'activo' => true
            )
        );


        $em->persist($asignacion);
        $em->persist($cupo);
        $em->persist($cupoNew);
        $em->persist($tarjetaOperacion);

        $asignacionNew = new VhloTpAsignacion();
        $asignacionNew->setEmpresaTransporte($empresaTransporte);
        $asignacionNew->setVehiculo($vehiculo);
        $asignacionNew->setCupo($cupoNew);
        $asignacionNew->setNivelServicio($nivelServicio);
        $asignacionNew->setActivo(true);

        $em->persist($asignacionNew);

        $tarjetaOperacionNew = new VhloTpTarjetaOperacion();
        $tarjetaOperacionNew->setFechaVencimiento(new \Datetime($params->fechaVigencia));
        $tarjetaOperacionNew->setNumeroTarjetaOperacion($params->numeroTarjetaOperacionNuevo);
        $tarjetaOperacionNew->setVehiculo($vehiculo);
        $tarjetaOperacionNew->setActivo(true);

        $em->persist($tarjetaOperacionNew);
        $em->flush();
    
        $response = 
            array(
                'status' => 'success',
                'code' => 200,
                'message' => 'El trámite de cambio de servicio por concepto favorable se realizó con éxito',
            );
                    
        return $helpers->json($response);
    }

    public function usuarioUpdateAction($params)
    {    
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $ciudadano = $em->getRepository("JHWEBUsuarioBundle:UserCiudadano")->find(
            $params->idSolicitante
        );

        if ($ciudadano) {
            foreach ($params->campos as $key => $campo) {
                switch ($campo) {
                    case 'cambioDocumento':
                        $ciudadanoNew = new UserCiudadano();

                        $ciudadanoNew->setPrimerNombre($ciudadano->getPrimerNombre());
                        $ciudadanoNew->setSegundoNombre($ciudadano->getSegundoNombre());
                        $ciudadanoNew->setPrimerApellido($ciudadano->getPrimerApellido());
                        $ciudadanoNew->setSegundoApellido($ciudadano->getSegundoApellido());
        
                        $ciudadanoNew->setIdentificacion(
                            $params->identificacionActual
                        );
        
                        $ciudadanoNew->setTelefonoCelular($ciudadano->getTelefonoCelular());
        
                        if ($ciudadano->getTelefonoFijo()) {
                            $ciudadanoNew->setTelefonoFijo($ciudadano->getTelefonoFijo());
                        }
        
                        if ($ciudadano->getFechaNacimiento()) {
                            $ciudadanoNew->setFechaNacimiento(
                                $ciudadano->getFechaNacimiento()
                            );
                        }
        
                        if ($ciudadano->getFechaExpedicionDocumento()) {
                            $ciudadanoNew->setFechaExpedicionDocumento(
                                new \Datetime($params->fechaExpedicion)
                            );
                        }
        
                        $ciudadanoNew->setDireccionPersonal(
                            $ciudadano->getDireccionPersonal()
                        );
        
                        if ($ciudadano->getDireccionTrabajo()) {
                            $ciudadanoNew->setDireccionTrabajo(
                                $ciudadano->getDireccionTrabajo()
                            );
                        }
        
                        $ciudadanoNew->setEnrolado(true);
                        $ciudadanoNew->setActivo(true);
        
                        $tipoIdentificacion = $em->getRepository('JHWEBUsuarioBundle:UserCfgTipoIdentificacion')->find(
                            1
                        );
                        $ciudadanoNew->setTipoIdentificacion($tipoIdentificacion);
        
                        if ($ciudadano->getMunicipioNacimiento()) {
                            $ciudadanoNew->setMunicipioNacimiento($ciudadano->getMunicipioNacimiento());
                        }
        
                        if ($ciudadano->getMunicipioResidencia()) {
                            $ciudadanoNew->setMunicipioResidencia($ciudadano->getMunicipioResidencia());
                        }
        
                        if ($ciudadano->getGenero()) {
                            $ciudadanoNew->setGenero($ciudadano->getGenero());
                        }
        
                        if ($ciudadano->getGrupoSanguineo()) {
                            $ciudadanoNew->setGrupoSanguineo($ciudadano->getGrupoSanguineo());
                        }
                        
                        $em->persist($ciudadanoNew);
                        $em->flush();

                        $usuario = $ciudadano->getUsuario();
                        
                        if ($usuario) {
                            $password = $ciudadano->getPrimerNombre()[0].$ciudadano->getPrimerApellido()[0].$params->identificacionActual;
                            $password = hash('sha256', $password);
                            $usuario->setPassword($password);
    
                            $ciudadano->setUsuario(null);
                            $ciudadano->setActivo(false);
                            
                            $usuario->setCiudadano($ciudadanoNew);
                            $em->flush();
                        }
                    break;
                }
            }

            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Registro actualizado con éxito.", 
            );
        } else {
            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Ciudadano no encontrado.", 
            );
        }
       

        return $helpers->json($response);
    }

    /**
     * Busca trámites por módulo y parametros (No. placa, No. factura y fecha).
     *
     * @Route("/search/modulo/filter", name="frotrtesolicitud_search_modulo_filter")
     * @Method({"GET", "POST"})
     */
    public function searchByModuloAndFilterAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $tramites = $em->getRepository('JHWEBFinancieroBundle:FroTrteSolicitud')->getByModuloAndFilter(
                $params
            );

            if ($tramites) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($tramites)." trámites encontrados", 
                    'data' => $tramites,
            );
            }else{
                 $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'No existen trámites para esos filtros de búsqueda, si desea registralo por favor presione el botón "NUEVO"', 
                );
            }
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
     * Busca trámites por módulo y parametros (No. placa, No. factura y fecha).
     *
     * @Route("/show/tramitefactura", name="frotrtesolicitud_show_tramitefactura")
     * @Method({"GET", "POST"})
     */
    public function showByTramiteFacturaAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $tramiteSolicitud = $em->getRepository('JHWEBFinancieroBundle:FroTrteSolicitud')->findOneBy(
                array(
                    'tramiteFactura' => $params->idTramiteFactura
                )
            );

            if ($tramiteSolicitud) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Registro encontrado.', 
                    'data' => $tramiteSolicitud,
                );
            }else{
                 $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'No existen trámites para esos filtros de búsqueda, si desea registralo por favor presione el botón "NUEVO"', 
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
     * Lists all tramiteSolicitud entities.
     *
     * @Route("/search/matricula/cancelada", name="frotrtesolicitud_matricula_cancelada")
     * @Method({"GET", "POST"})
     */
    public function searchMatriculaCanceladaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);

        $json = $request->get("data",null);
        $params = json_decode($json);

        $matriculaCancelada = $em->getRepository('JHWEBFinancieroBundle:FroTrteSolicitud')->getMatriculaCancelada(
            $params->idVehiculo
        );

        if ($matriculaCancelada) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'La matricula se encuentra cancelada',
                'data' => $matriculaCancelada,
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'El vehiculo no presenta un tramite de cancelación previo, no es posible continuar con el trámite de Rematricula.',
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a new Cuenta entity.
     *
     * @Route("/{idFuncionario}/{idVehiculo}/pdf/certificadotradicion", name="frotrtesolicitud_pdf_certificadotradicion")
     * @Method({"GET", "POST"})
     */
    public function pdfCertificadoTradicionAction(Request $request, $idFuncionario, $idVehiculo)
    {
        setlocale(LC_ALL,"es_ES");
        $fechaActual = strftime("%d de %B del %Y");

        $em = $this->getDoctrine()->getManager();

        $funcionario = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->find(
            $idFuncionario
        );

        $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->find(
            $idVehiculo
        );

        if ($vehiculo) {
            $propietarios = $em->getRepository('JHWEBVehiculoBundle:VhloPropietario')->findBy(
                array(
                    'vehiculo' => $vehiculo->getId(),
                    'activo' => true,
                ),
                array(
                    'fechaInicial' => 'ASC'
                )
            );

            $tramitesSolicitud = $em->getRepository('JHWEBFinancieroBundle:FroTrteSolicitud')->findByVehiculo(
                $vehiculo->getId()
            );

            $observaciones = null;
            foreach ($tramitesSolicitud as $key => $tramiteSolicitud) {
                if ($tramiteSolicitud->getTramiteFactura()->getPrecio()->getTramite()->getId() == 30) {
                    $foraneas = (object)$tramiteSolicitud->getForaneas();
                    $observaciones = $foraneas->observaciones;
                }
            }

            $limitaciones = $em->getRepository('JHWEBVehiculoBundle:VhloLimitacion')->findBy(
                array(
                    'vehiculo' => $vehiculo->getId(),
                    'activo' => true
                )
            );
        }   

        $html = $this->renderView('@JHWEBFinanciero/Default/pdf.certificadotradicion.html.twig', array(
            'fechaActual' => $fechaActual,
            'funcionario'=>$funcionario,
            'vehiculo'=>$vehiculo,
            'propietarios' => $propietarios,
            'limitaciones' => $limitaciones,
            'tramitesSolicitud'=>$tramitesSolicitud,
            'observaciones' => $observaciones,
        ));

        $this->get('app.pdf')->templateCertificadoTradicion($html, $vehiculo->getPlaca()->getNumero(), 'normal');
    }

    /**
     * Genera un PDF con las observaciones de documentación incompleta de la factura.
     *
     * @Route("/{idFactura}/pdf/documentacion", name="frotrtesolicitud_pdf_documentacion")
     * @Method({"GET", "POST"})
     */
    public function pdfDocumentacionAction(Request $request, $idFactura)
    {
        setlocale(LC_ALL,"es_ES");
        $fechaActual = strftime("%d de %B del %Y");

        $em = $this->getDoctrine()->getManager();

        $factura = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->find(
            $idFactura
        );

        $tramitesFactura = $em->getRepository('JHWEBFinancieroBundle:FroFacTramite')->findBy(
            array(
                'factura' => $factura->getId(),
                'documentacion' => false,
            )
        );

        if ($tramitesFactura) {
            $html = $this->renderView('@JHWEBFinanciero/Default/pdf.documentacion.html.twig', array(
                'fechaActual' => $fechaActual,
                'factura' => $factura,
                'tramitesFactura' => $tramitesFactura,
            ));
        }

        $this->get('app.pdf')->templateDocumentacion($html, $factura);
    }

    /**
     * Validaciones de tramites.
     *
     * @Route("/validations", name="frotrtesolicitud_validations")
     * @Method("POST")
     */
    public function validationsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        $json = $request->get("data",null);
        $params = json_decode($json);       

        if ($params->idTramiteFactura) {
            $tramiteFactura = $em->getRepository('JHWEBFinancieroBundle:FroFacTramite')->find(
                $params->idTramiteFactura
            );
        }

        if ($tramiteFactura) {
            $funcionario = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->find(
                $params->idFuncionario
            );
    
            if ($tramiteFactura->getRealizado()) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'El tramite ya fue realizado.', 
                );
            }else{
                if ($tramiteFactura->getPrecio()->getModulo()->getAbreviatura() == 'RNC') {
                    if (isset($params->idSolicitante) && $params->idSolicitante) {
                        $solicitante = $em->getRepository('JHWEBUsuarioBundle:UserUsuario')->find($params->idSolicitante);
                    }
    
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => 'Trámite autorizado.',
                    );
                }else{
                    if (isset($params->idVehiculo) && $params->idVehiculo) {
                        $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->find($params->idVehiculo);
                    }

                    if (!$vehiculo->getCancelado()) {                        
                        if ($funcionario->getOrganismoTransito()->getId() == $vehiculo->getOrganismoTransito()->getId()) {
                            $limitaciones = $em->getRepository('JHWEBVehiculoBundle:VhloLimitacion')->findBy(
                                array(
                                    'vehiculo' => $vehiculo->getId(),
                                    'activo' => true,
                                )
                            );
    
                            if ($limitaciones) {
                                //Valida si el tramite a realizar es diferente de TRASPASO
                                if ($tramiteFactura->getPrecio()->getTramite()->getId() != 2) {
                                    $response = array(
                                        'status' => 'success',
                                        'code' => 200,
                                        'message' => 'Trámite autorizado.',
                                    );
                                }else{
                                    $response = array(
                                        'status' => 'error',
                                        'code' => 400,
                                        'message' => 'Este trámite no se puede realizar porque este vehiculo presenta limitación a la propiedad.',
                                    );
                                }
                            }else{
                                $response = array(
                                    'status' => 'success',
                                    'code' => 200,
                                    'message' => 'Trámite autorizado.',
                                );
                            }
                        }else{
                            $response = array(
                                'status' => 'success',
                                'code' => 200,
                                'message' => 'Trámite autorizado.',
                            );
                        }
                    }else{
                        //Valida si el tramite a realizar es REMATRICULA
                        if ($tramiteFactura->getPrecio()->getTramite()->getId() == 18) {
                            //Busca el último tramite de cancelación de vehiculo
                            $tramiteCancelacion = $em->getRepository('JHWEBFinancieroBundle:FroTrteSolicitud')->getOneByVehiculoAndTramite(
                                $vehiculo->getId(), 18
                            );
                            
                            $foraneas = (object)$tramiteCancelacion->getForaneas();
                            $motivoCancelacion = $foraneas->idMotivoCancelacion;
                            
                            if ($motivoCancelacion == 'HURTO') {
                                $response = array(
                                    'status' => 'success',
                                    'code' => 200,
                                    'message' => 'Trámite autorizado.',
                                );
                            }else{
                                $response = array(
                                    'status' => 'error',
                                    'code' => 400,
                                    'message' => 'Este trámite no se pude realizar porque el motivo de la cancelación es HURTO.',
                                );
                            }
                        }

                        $response = array(
                            'status' => 'success',
                            'code' => 200,
                            'message' => 'Trámite autorizado.',
                        );
                    }
                }
            }
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'No existe el trámite que desea realizar.', 
            );
        }

        return $helpers->json($response);
    }

    
    /**
     * Genera pdf resolucion del cambio de servicio.
     *
     * @Route("/{idVehiculo}/{numeroResolucion}/resolucion/cambioServicio/pdf", name="resolucion_cambio_servicio_pdf")
     * @Method({"GET","POST"})
     */
    public function pdfResolucionCambioServicioAction(Request $request, $idVehiculo, $numeroResolucion)
    {        
        $em = $this->getDoctrine()->getManager();
        
        setlocale(LC_ALL, "es_ES");
        $fechaActual = strftime("%d de %B del %Y");

        $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->find($idVehiculo);

        $propietario = $em->getRepository('JHWEBVehiculoBundle:VhloPropietario')->findOneBy(
            array(
                'vehiculo' => $idVehiculo,
                'activo' => true
            )
        );
        
        $asignacion = $em->getRepository('JHWEBVehiculoBundle:VhloTpAsignacion')->findOneBy(
            array(
                'vehiculo' => $idVehiculo,
            )
        );
        
        $html = $this->renderView('@JHWEBFinanciero/Default/resoluciones/pdf.resolucion.desvinculacionCambioServicio.html.twig', array(
            'fechaActual' => $fechaActual,
            'vehiculo' => $vehiculo,
            'propietario' => $propietario,
            'numeroResolucion' => $numeroResolucion,
            'empresaTransporte' => $asignacion->getEmpresaTransporte(),
        ));

        $this->get('app.pdf')->templateResoluciones($html);
    }

    /**
     * Genera pdf resolucion del cambio de empresa.
     *
     * @Route("/{idVehiculo}/{idEmpresaActual}/{numeroResolucion}/resolucion/cambioEmpresa/pdf", name="resolucion_cambio_empresa_pdf_export")
     * @Method({"GET","POST"})
     */
    public function pdfResolucionCambioEmpresaAction(Request $request, $idVehiculo, $idEmpresaActual, $numeroResolucion)
    {        
        $em = $this->getDoctrine()->getManager();
        
        setlocale(LC_ALL, "es_ES");
        $fechaActual = strftime("%d de %B del %Y");

        $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->find($idVehiculo);

        $empresaActual = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->findOneBy(
            array(
                'id' => $idEmpresaActual,
                'activo' => true
            )
        );

        $propietario = $em->getRepository('JHWEBVehiculoBundle:VhloPropietario')->findOneBy(
            array(
                'vehiculo' => $idVehiculo,
                'activo' => true
            )
        );
        
        $asignacion = $em->getRepository('JHWEBVehiculoBundle:VhloTpAsignacion')->findOneBy(
            array(
                'vehiculo' => $idVehiculo,
            )
        );
        
        $html = $this->renderView('@JHWEBFinanciero/Default/resoluciones/pdf.resolucion.cambioEmpresa.html.twig', array(
            'fechaActual' => $fechaActual,
            'vehiculo' => $vehiculo,
            'propietario' => $propietario,
            'numeroResolucion' => $numeroResolucion,
            'asignacion' => $asignacion,
            'empresaActual' => $empresaActual,
        ));

        $this->get('app.pdf')->templateResoluciones($html);
    }

    /**
     * Genera pdf resolucion de desvinculacion por Común Acuerdo.
     *
     * @Route("/{idVehiculo}/{numeroResolucion}/resolucion/desvinculacionComunAcuerdo/pdf", name="resolucion_desvinculacion_comun_acuerdo_pdf")
     * @Method({"GET","POST"})
     */
    public function pdfResolucionDesvinculacionComunAcuerdoAction(Request $request, $idVehiculo, $numeroResolucion)
    {        
        $em = $this->getDoctrine()->getManager();
        
        setlocale(LC_ALL, "es_ES");
        $fechaActual = strftime("%d de %B del %Y");

        $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->find($idVehiculo);

        $propietario = $em->getRepository('JHWEBVehiculoBundle:VhloPropietario')->findOneBy(
            array(
                'vehiculo' => $idVehiculo,
                'activo' => true
            )
        );
        
        $asignacion = $em->getRepository('JHWEBVehiculoBundle:VhloTpAsignacion')->findOneBy(
            array(
                'vehiculo' => $idVehiculo,
            )
        );
        
        $html = $this->renderView('@JHWEBFinanciero/Default/resoluciones/pdf.resolucion.desvinculacionPorComunAcuerdo.html.twig', array(
            'fechaActual' => $fechaActual,
            'vehiculo' => $vehiculo,
            'propietario' => $propietario,
            'numeroResolucion' => $numeroResolucion,
            'asignacion' => $asignacion,
        ));

        $this->get('app.pdf')->templateResoluciones($html);
    }

    /**
     * Genera pdf resolucion del cambio de empresa por concepto favorable.
     *
     * @Route("/{idVehiculo}/{idEmpresaActual}/{numeroConceptoFavorable}/{numeroResolucion}/resolucion/cambioEmpresaConceptoFavorable/pdf", name="resolucion_cambio_empresa_pdf")
     * @Method({"GET","POST"})
     */
    public function pdfResolucionCambioEmpresaConceptoFavorableAction(Request $request, $idVehiculo, $idEmpresaActual, $numeroConceptoFavorable, $numeroResolucion)
    {        
        $em = $this->getDoctrine()->getManager();
        
        setlocale(LC_ALL, "es_ES");
        $fechaActual = strftime("%d de %B del %Y");

        $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->find($idVehiculo);

        $empresaActual = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->findOneBy(
            array(
                'id' => $idEmpresaActual,
                'activo' => true
            )
        );

        $propietario = $em->getRepository('JHWEBVehiculoBundle:VhloPropietario')->findOneBy(
            array(
                'vehiculo' => $idVehiculo,
                'activo' => true
            )
        );
        
        $asignacion = $em->getRepository('JHWEBVehiculoBundle:VhloTpAsignacion')->findOneBy(
            array(
                'vehiculo' => $idVehiculo,
            )
        );
        
        $html = $this->renderView('@JHWEBFinanciero/Default/resoluciones/pdf.resolucion.conceptoFavorable.html.twig', array(
            'fechaActual' => $fechaActual,
            'vehiculo' => $vehiculo,
            'propietario' => $propietario,
            'numeroResolucion' => $numeroResolucion,
            'numeroConceptoFavorable' => $numeroConceptoFavorable,
            'asignacion' => $asignacion,
            'empresaActual' => $empresaActual,
        ));

        $this->get('app.pdf')->templateResoluciones($html);
    }

    /**
     * Busca tramites realizados entre fechas según el tipo.
     *
     * @Route("/search/tramite/dates", name="frotrtesolicitud_search_tramite_dates")
     * @Method("POST")
     */
    public function searchByTramiteAndDatesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        $json = $request->get("data",null);
        $params = json_decode($json);       

        if ($params->idTramiteFactura) {
            $tramiteFactura = $em->getRepository('JHWEBFinancieroBundle:FroFacTramite')->find(
                $params->idTramiteFactura
            );
        }

        if ($tramiteFactura) {
            $funcionario = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->find(
                $params->idFuncionario
            );
    
            if ($tramiteFactura->getRealizado()) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'El tramite ya fue realizado.', 
                );
            }else{
                if ($tramiteFactura->getPrecio()->getModulo()->getAbreviatura() == 'RNC') {
                    if (isset($params->idSolicitante) && $params->idSolicitante) {
                        $solicitante = $em->getRepository('JHWEBUsuarioBundle:UserUsuario')->find($params->idSolicitante);
                    }
    
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => 'Trámite autorizado.',
                    );
                }else{
                    if (isset($params->idVehiculo) && $params->idVehiculo) {
                        $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->find($params->idVehiculo);
                    }

                    if (!$vehiculo->getCancelado()) {                        
                        if ($funcionario->getOrganismoTransito()->getId() == $vehiculo->getOrganismoTransito()->getId()) {
                            $limitaciones = $em->getRepository('JHWEBVehiculoBundle:VhloLimitacion')->findBy(
                                array(
                                    'vehiculo' => $vehiculo->getId(),
                                    'activo' => true,
                                )
                            );
    
                            if ($limitaciones) {
                                //Valida si el tramite a realizar es diferente de TRASPASO
                                if ($tramiteFactura->getPrecio()->getTramite()->getId() != 2) {
                                    $response = array(
                                        'status' => 'success',
                                        'code' => 200,
                                        'message' => 'Trámite autorizado.',
                                    );
                                }else{
                                    $response = array(
                                        'status' => 'error',
                                        'code' => 400,
                                        'message' => 'Este trámite no se puede realizar porque este vehiculo presenta limitación a la propiedad.',
                                    );
                                }
                            }else{
                                $response = array(
                                    'status' => 'success',
                                    'code' => 200,
                                    'message' => 'Trámite autorizado.',
                                );
                            }
                        }else{
                            $response = array(
                                'status' => 'success',
                                'code' => 200,
                                'message' => 'Trámite autorizado.',
                            );
                        }
                    }else{
                        //Valida si el tramite a realizar es REMATRICULA
                        if ($tramiteFactura->getPrecio()->getTramite()->getId() == 18) {
                            //Busca el último tramite de cancelación de vehiculo
                            $tramiteCancelacion = $em->getRepository('JHWEBFinancieroBundle:FroTrteSolicitud')->getOneByVehiculoAndTramite(
                                $vehiculo->getId(), 18
                            );
                            
                            $foraneas = (object)$tramiteCancelacion->getForaneas();
                            $motivoCancelacion = $foraneas->idMotivoCancelacion;
                            
                            if ($motivoCancelacion == 'HURTO') {
                                $response = array(
                                    'status' => 'success',
                                    'code' => 200,
                                    'message' => 'Trámite autorizado.',
                                );
                            }else{
                                $response = array(
                                    'status' => 'error',
                                    'code' => 400,
                                    'message' => 'Este trámite no se pude realizar porque el motivo de la cancelación es HURTO.',
                                );
                            }
                        }

                        $response = array(
                            'status' => 'success',
                            'code' => 200,
                            'message' => 'Trámite autorizado.',
                        );
                    }
                }
            }
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'No existe el trámite que desea realizar.', 
            );
        }

        return $helpers->json($response);
    }
}
