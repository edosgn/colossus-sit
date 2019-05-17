<?php

namespace JHWEB\FinancieroBundle\Controller;

use JHWEB\FinancieroBundle\Entity\FroTrteSolicitud;
use JHWEB\FinancieroBundle\Entity\FroFacInsumo;
use JHWEB\VehiculoBundle\Entity\VhloCfgPlaca;
use JHWEB\VehiculoBundle\Entity\VhloActaTraspaso;
use JHWEB\UsuarioBundle\Entity\UserCiudadano;
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
                foreach ($params->tramitesRealizados as $key => $tramiteRealizado) {
                    if ($tramiteRealizado->idTramiteFactura) {
                        $tramiteFactura = $em->getRepository('JHWEBFinancieroBundle:FroFacTramite')->find(
                            $tramiteRealizado->idTramiteFactura
                        );
        
                        if ($tramiteFactura) {    
                            if ($tramiteFactura->getPrecio()->getTramite()->getId() == 30) {
                                $certificadoTradicion = true;
                            }
        
                            if (isset($params->numeroRunt)) {
                                $factura->setNumeroRunt($params->numeroRunt);
        
                                $em->flush();
                            }

                            if (!$tramiteFactura->getRealizado()) {
                                $funcionario = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->find(
                                    $tramiteRealizado->foraneas->idFuncionario
                                );
    
                                if (isset($params->idVehiculo) && $params->idVehiculo) {
                                    $vehiculoUpdate = $this->vehiculoUpdateAction($tramiteRealizado->foraneas);

                                    if ($vehiculoUpdate->code == 200) {
                                        $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->find($params->idVehiculo);
        
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
        
                                        if (isset($params->idPropietario) && $params->idPropietario) {
                                            $propietario = $em->getRepository('JHWEBVehiculoBundle:VhloPropietario')->find(
                                                $params->idPropietario
                                            );
                                            $tramiteSolicitud->setPropietario($propietario);
                                        }
        
                                        if (isset($params->idSolicitante) && $params->idSolicitante) {
                                            $solicitante = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->find(
                                                $params->idSolicitante
                                            );
                                            $tramiteSolicitud->setSolicitante($solicitante);
                                        }
        
                                        $tramiteSolicitud->setTramiteFactura($tramiteFactura);
        
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

                                    if ($usuarioUpdate->code == 200) {
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
                    }

                    $em->persist($facturaInsumo);
                    $em->flush();

                    //Insertar licencia de conducción o tránsito
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

    public function vehiculoUpdateAction($params)
    {    
        $helpers = $this->get("app.helpers");
               
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
                        $vehiculo->setNumeroEjes($params->ejesTotal);
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
                                $ciudadano->getFechaExpedicionDocumento()
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

                        $usuario = $ciudadano->getUsuario();
        
                        $password = $ciudadano->getPrimerNombre()[0].$ciudadano->getPrimerApellido()[0].$params->identificacionActual;
                        $password = hash('sha256', $password);
                        $usuario->setPassword($password);

                        $ciudadano->setUsuario(null);
                        $ciudadano->setActivo(false);
                        
                        $em->persist($ciudadanoNew);
                        $em->flush();
                        $usuario->setCiudadano($ciudadanoNew);
                    break;
                }
            }

            $em->flush();
            
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'El usuario se actualizó con éxito.',
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'El usuario no se encuentra en la base de datos.',
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
     * @Route("/{idVehiculo}/{tipo}/pdf/certificadotradicion", name="frotrtesolicitud_pdf_certificadotradicion")
     * @Method({"GET", "POST"})
     */
    public function pdfCertificadoTradicionAction(Request $request, $idVehiculo, $tipo)
    {
        setlocale(LC_ALL,"es_ES");
        $fechaActual = strftime("%d de %B del %Y");

        $em = $this->getDoctrine()->getManager();

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
            'vehiculo'=>$vehiculo,
            'propietarios' => $propietarios,
            'limitaciones' => $limitaciones,
            'tramitesSolicitud'=>$tramitesSolicitud,
            'observaciones' => $observaciones,
        ));

        $this->get('app.pdf')->templateCertificadoTradicion($html, $vehiculo);
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
}
