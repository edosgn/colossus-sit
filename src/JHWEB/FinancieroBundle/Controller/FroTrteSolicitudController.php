<?php

namespace JHWEB\FinancieroBundle\Controller;

use JHWEB\FinancieroBundle\Entity\FroTrteSolicitud;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

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

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            if ($params->datos->foraneas) {
                if ($params->datos->foraneas->idTramiteFactura) {
                    $tramiteFactura = $em->getRepository('JHWEBFinancieroBundle:FroFacTramite')->find(
                        $params->datos->foraneas->idTramiteFactura
                    );

                    if ($tramiteFactura) {
                        if ($tramiteFactura->getRealizado()) {
                            $response = array(
                                'status' => 'error',
                                'code' => 400,
                                'message' => 'El tramite ya fue realizado.', 
                            );
                        }else{
                            $funcionario = $vehiculo = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->find(
                                $params->idFuncionario
                            );

                            if (isset($params->idVehiculo) && $params->idVehiculo) {
                                $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->find($params->idVehiculo);
                            }

                            if ($funcionario->getOrganismoTransito()->getId() == $vehiculo->getOrganismoTransito()->getId()) {
                                if ($params->documentacion) {
                                    $tramiteFactura->setDocumentacion($params->documentacion);

                                    $tramiteSolicitud = new FroTrteSolicitud();

                                    $tramiteSolicitud->setTramiteFactura($tramiteFactura);

                                    $tramiteSolicitud->setFecha(new \DateTime(date('Y-m-d')));
                                    $tramiteSolicitud->setHora(new \DateTime(date('h:i:s')));

                                    $tramiteSolicitud->setForaneas(
                                        (array)$params->datos->foraneas
                                    );
                                    
                                    $tramiteSolicitud->setResumen($params->datos->resumen);
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

                                    $em->flush();

                                    $response = array(
                                        'status' => 'success',
                                        'code' => 200,
                                        'message' => 'Registro creado con exito.',
                                        'data' => $tramiteSolicitud
                                    );
                                }else{
                                    $tramiteFactura->setDocumentacion($params->documentacion);

                                    if ($params->observacion) {
                                        $tramiteFactura->setObservacion($observacion);
                                    }

                                    $response = array(
                                        'status' => 'error',
                                        'code' => 400,
                                        'message' => 'Este trámite no se puede realizar porque no presenta la documentación completa.',
                                    );
                                }
                            }else{
                                //Valida si el tramite a realizar es RADICADO DE CUENTA o CERTIFICADO DE TRADICION
                                if ($tramiteFactura->getPrecio()->getTramite()->getId() == 4 || $tramiteFactura->getPrecio()->getTramite()->getId() == 30) {
                                    if ($params->documentacion) {
                                        $tramiteFactura->setDocumentacion($params->documentacion);

                                        $tramiteSolicitud = new FroTrteSolicitud();

                                        $tramiteSolicitud->setTramiteFactura($tramiteFactura);

                                        $tramiteSolicitud->setFecha(new \DateTime(date('Y-m-d')));
                                        $tramiteSolicitud->setHora(new \DateTime(date('h:i:s')));

                                        $tramiteSolicitud->setForaneas(
                                            (array)$params->datos->foraneas
                                        );
                                        
                                        $tramiteSolicitud->setResumen($params->datos->resumen);
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

                                        $em->flush();

                                        $response = array(
                                            'status' => 'success',
                                            'code' => 200,
                                            'message' => 'Registro creado con exito.',
                                            'data' => $tramiteSolicitud
                                        );
                                    }else{
                                        $tramiteFactura->setDocumentacion($params->documentacion);

                                        if ($params->observacion) {
                                            $tramiteFactura->setObservacion($observacion);
                                        }

                                        $response = array(
                                            'status' => 'error',
                                            'code' => 400,
                                            'message' => 'Este trámite no se puede realizar porque no presenta la documentación completa.',
                                        );
                                    }
                                }else{
                                    $response = array(
                                        'status' => 'error',
                                        'code' => 400,
                                        'message' => 'Este trámite no se puede realizar porque este vehiculo se encuentra trasladado a otro organismo de transito.',
                                    );
                                }
                            }                                
                        }
                    }else{
                        $response = array(
                            'status' => 'error',
                            'code' => 400,
                            'message' => 'El tramite ya fue realizado.', 
                        );
                    }
                }else{
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => 'Se requieren los datos de tramite y/o factura.', 
                    );
                }
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'No puede realizar este trámite porque no llegan los datos necesarios.', 
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
            $propietarios = $em->getRepository('JHWEBVehiculoBundle:VhloPropietario')->findByVehiculo(
                $vehiculo->getId()
            );

            $tramitesSolicitud = $em->getRepository('JHWEBFinancieroBundle:FroTrteSolicitud')->findByVehiculo(
                $vehiculo->getId()
            );
        }        

        $html = $this->renderView('@JHWEBFinanciero/Default/pdf.certificadotradicion.html.twig', array(
            'fechaActual' => $fechaActual,
            'vehiculo'=>$vehiculo,
            'propietarios' => $propietarios,
            'fechaActual' => $fechaActual,
            'tramitesSolicitud'=>$tramitesSolicitud
        ));

        $this->get('app.pdf.factura')->templateCertificadoTradicion($html, $vehiculo);
    }
}
