<?php

namespace JHWEB\FinancieroBundle\Controller;

use JHWEB\FinancieroBundle\Entity\FroTrtePrecio;
use JHWEB\FinancieroBundle\Entity\FroTrteConcepto;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * Frotrteprecio controller.
 *
 * @Route("frotrteprecio")
 */
class FroTrtePrecioController extends Controller
{
    /**
     * Lists all froTrtePrecio entities.
     *
     * @Route("/", name="frotrteprecio_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $tramitesPrecios = $em->getRepository('JHWEBFinancieroBundle:FroTrtePrecio')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($tramitesPrecios) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($tramitesPrecios) . " registros encontrados",
                'data' => $tramitesPrecios,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new froTrtePrecio Concepto entity.
     *
     * @Route("/new", name="frotrteprecio_new")
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

            $tramitePrecio = new FroTrtePrecio();

            $fechaActual = new \Datetime(date('Y-m-d'));
            $fechaInicial = new \Datetime($params->fechaInicial);

            if ($fechaInicial > $fechaActual) {
                $tramitePrecio->setFechaInicial(
                    $fechaInicial
                );
                $tramitePrecio->setValor($params->valor);
                $tramitePrecio->setValorTotal(0);
                $tramitePrecio->setActivo(true);
    
                if ($params->idTramite) {
                    $tramite = $em->getRepository("JHWEBFinancieroBundle:FroTramite")->find(
                        $params->idTramite
                    );
                    $tramitePrecio->setTramite($tramite);
                }
    
                if (isset($params->idTipoVehiculo) && $params->idTipoVehiculo) {
                    $tipoVehiculo = $em->getRepository("JHWEBVehiculoBundle:VhloCfgTipoVehiculo")->find(
                        $params->idTipoVehiculo
                    );
                    $tramitePrecio->setTipoVehiculo($tipoVehiculo);
    
                    $tramitePrecio->setNombre(
                        mb_strtoupper($tramite->getNombre().' '.$tipoVehiculo->getNombre(), 'utf-8')
                    );
                }else{
                    $tramitePrecio->setNombre(
                        mb_strtoupper($tramite->getNombre(), 'utf-8')
                    );
                }
    
                if ($params->idModulo) {
                    $modulo = $em->getRepository('JHWEBConfigBundle:CfgModulo')->find(
                        $params->idModulo
                    );
                    $tramitePrecio->setModulo($modulo);
                }
    
                $tramitePrecio->setActivo(true);
    
                $em->persist($tramitePrecio);
                $em->flush();
    
                $totalConceptos = 0;
                if ($params->conceptos) {
                    foreach ($params->conceptos as $key => $idConcepto) {
                        $tramiteConcepto = new FroTrteConcepto();
    
                        $concepto = $em->getRepository('JHWEBFinancieroBundle:FroTrteCfgConcepto')->find(
                            $idConcepto
                        );
                        $tramiteConcepto->setConcepto($concepto);
    
                        $tramiteConcepto->setPrecio($tramitePrecio);
    
                        $tramiteConcepto->setActivo(true);
    
                        $em->persist($tramiteConcepto);
                        $em->flush();
    
                        $totalConceptos += $concepto->getValor();
                    }
                }
    
                $tramitePrecio->setValorConcepto($totalConceptos);
                $tramitePrecio->setValorTotal(
                    $totalConceptos + $tramitePrecio->getValor()
                );
    
                $em->flush();
                
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Registro creado con éxito',
                );
            } else {
               $response = array(
                    'title' => 'Atención!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => 'La fecha inicial debe ser mayor a la fecha actual.',
                );
            }
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorización no válida', 
            );
        } 
        return $helpers->json($response);
    }

    /**
     * Finds and displays a froTrtePrecio entity.
     *
     * @Route("/show", name="frotrteprecio_show")
     * @Method("POST")
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $tramitePrecio = $em->getRepository('JHWEBFinancieroBundle:FroTrtePrecio')->find(
                $params->id
            );

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Registro encontrado con exito.',
                'data' => $tramitePrecio
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
     * Displays a form to edit an existing froTrtePrecio entity.
     *
     * @Route("/edit", name="frotrteprecio_edit")
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

            $tramitePrecio = $em->getRepository('JHWEBFinancieroBundle:FroTrtePrecio')->find(
                $params->id
            );

            if ($tramitePrecio) {
                $tramitePrecio->setNombre(strtoupper($params->nombre));
                $tramitePrecio->setValor($params->valor);
                $tramitePrecio->setFechaInicial(new \Datetime($params->fechaInicial));
                $tramitePrecio->setValorConcepto($params->valorConcepto);
                $tramitePrecio->setValorTotal($params->valorTotal);

                $tramite = $em->getRepository("JHWEBFinancieroBundle:FroTramite")->find($params->idTramite);
                $tramitePrecio->setTramite($tramite);

                $tipoVehiculo = $em->getRepository("JHWEBVehiculoBundle:VhloCfgTipoVehiculo")->find($params->idTipoVehiculo);
                $tramitePrecio->setTipoVehiculo($tipoVehiculo);

                $tramitePrecio->setActivo(true);

                $em->flush();

                $tramitesConceptoOld = $em->getRepository('JHWEBFinancieroBundle:FroTrteConcepto')->findBy(
                    array(
                        'precio' => $tramitePrecio->getId(),
                        'activo' => true
                    )
                );

                foreach ($tramitesConceptoOld as $key => $tramiteConceptoOld) {
                    $tramiteConceptoOld->setActivo(false);
                }

                if ($params->conceptos) {
                    $totalConceptos = 0;
                    foreach ($params->conceptos as $key => $idConcepto) {
                        $tramiteConcepto = $em->getRepository('JHWEBFinancieroBundle:FroTrteConcepto')->findOneBy(
                            array(
                                'precio' => $tramitePrecio->getId(),
                                'concepto' => $idConcepto
                            )
                        );

                        if ($tramiteConcepto) {
                            $tramiteConcepto->setActivo(true);

                            $totalConceptos += $tramiteConcepto->getConcepto()->getValor();

                            $em->flush();
                        }else{
                            $tramiteConcepto = new FroTrteConcepto();
        
                            $concepto = $em->getRepository('JHWEBFinancieroBundle:FroTrteCfgConcepto')->find(
                                $idConcepto
                            );
                            $tramiteConcepto->setConcepto($concepto);
        
                            $tramiteConcepto->setPrecio($tramitePrecio);
        
                            $tramiteConcepto->setActivo(true);
        
                            $em->persist($tramiteConcepto);
                            $em->flush();
        
                            $totalConceptos += $concepto->getValor();
                        }
                    }
                }
    
                $tramitePrecio->setValorConcepto($totalConceptos);
                $tramitePrecio->setValorTotal(
                    $totalConceptos + $tramitePrecio->getValor()
                );

                $em->flush();

                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito.",
                    'data' => $tramitePrecio,
                );
            } else {
                $response = array(
                    'title' => 'Atención!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos",
                );
            }
        } else {
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida para editar",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Deletes a froTrtePrecio entity.
     *
     * @Route("/delete", name="frotrteprecio_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", true);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $json = $request->get("data", null);
            $params = json_decode($json);

            $tramitePrecio = $em->getRepository('JHWEBFinancieroBundle:FroTrtePrecio')->find(
                $params->id
            );

            if ($tramitePrecio) {
                $tramitePrecio->setActivo(false);
    
                $em->persist($tramitePrecio);
                $em->flush();
    
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Registro eliminado con éxito.',
                );
            }else{
                $response = array(
                    'title' => 'Atención!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => 'El registro no fue encontrado en la base de datos.',
                );
            }
        } else {
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no válida",
            );
        }
        return $helpers->json($response);

    }

    /**
     * Creates a form to delete a froTrtePrecio entity.
     *
     * @param FroTrtePrecio $froTrtePrecio The froTramite entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FroTrtePrecio $froTrtePrecio)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('frotrteprecio_delete', array('id' => $froTrtePrecio->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ======================================================= */

    /**
     * Listado de tramites y valores para selección con búsqueda
     *
     * @Route("/select", name="frotrteprecio_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $tramitesPrecio = $em->getRepository('JHWEBFinancieroBundle:FroTramite')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($tramitesPrecios as $key => $tramitePrecio) {
            $response[$key] = array(
                'value' => $tramitePrecio->getId(),
                'label' => $tramitePrecio->getNombre(),
            );
        }

        return $helpers->json($response);
    }

    /**
     * Listado de tramites y valores por modulo para selección con búsqueda
     *
     * @Route("/select/modulo", name="frotrteprecio_select_modulo")
     * @Method({"GET", "POST"})
     */
    public function selectByModuloAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        
        $json = $request->get("data",null);
        $params = json_decode($json);
        
        $em = $this->getDoctrine()->getManager();
        
        $tramitesPrecio = null;

        $modulo = $em->getRepository('JHWEBConfigBundle:CfgModulo')->find(
            $params->idModulo
        );

        
        /* if ($modulo->getId() == 1) { */
        if ($modulo) {
            $tramitesPrecio = $em->getRepository('JHWEBFinancieroBundle:FroTrtePrecio')->findBy(
                array(
                    'modulo' => $modulo->getId(),
                    'activo' => true
                    )
                );
        }elseif (isset($params->idTipoVehiculo)) {
            $tramitesPrecio = $em->getRepository('JHWEBFinancieroBundle:FroTrtePrecio')->findBy(
                array(
                    'modulo' => $modulo->getId(),
                    'tipoVehiculo' => $params->idTipoVehiculo,
                    'activo' => true
                )
            );
        }
        
        $response = null;

        if ($tramitesPrecio) {
            foreach ($tramitesPrecio as $key => $tramitePrecio) {
                $response[$key] = array(
                    'value' => $tramitePrecio->getId(),
                    'label' => $tramitePrecio->getNombre(),
                );
            }

            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => count($tramitesPrecio) . ' registros encontrados.',
                'data' => $response,
            );
        }else{
            $response = array(
                'title' => 'Atención!',
                'status' => 'warning',
                'code' => 400,
                'message' => 'No existen tramites configurados para este tipo de vehiculo.',
                'data' => $response
            );
        }

        return $helpers->json($response);
    }

    /**
     * Busca todos los tramites y valores por modulo
     *
     * @Route("/search/modulo", name="frotrteprecio_search_modulo")
     * @Method({"GET", "POST"})
     */
    public function searchByModuloAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $modulo = $em->getRepository('JHWEBConfigBundle:CfgModulo')->find(
                $params->idModulo
            );

            $tramitesPrecio = $em->getRepository('JHWEBFinancieroBundle:FroTrtePrecio')->findBy(
                array(
                    'modulo' => $modulo->getId(),
                    'activo' => true
                )
            );

            $response['data'] = array();

            if ($tramitesPrecio) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($tramitesPrecio) . ' registros encontrados.',
                    'data' => array(
                        'modulo' => $modulo,
                        'tramitesPrecio' => $tramitesPrecio,
                    )
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Ningún registro encontrado.', 
                    'data' => array(
                        'modulo' => $modulo,
                        'tramitesPrecio' => null,
                    )
                );
            }
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida', 
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Valida que la fecha modificada sea mayor a la fecha actual
     *
     * @Route("/validate/date", name="frotrteprecio_validate_date")
     * @Method({"GET", "POST"})
     */
    public function validateDate(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $tramitePrecio = $em->getRepository('JHWEBFinancieroBundle:FroTrtePrecio')->find(
                $params->id
            );

            $fechaAnterior = $tramitePrecio->getFechaInicial();
            $fechaNueva = $helpers->convertDateTime($params->date);
            $fechaActual = new \Datetime(date('Y-m-d'));

            if ($fechaAnterior != $fechaNueva) {
                if ($fechaAnterior < $fechaNueva && $fechaActual < $fechaNueva) {
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => 'Fecha nueva es superior a la fecha fecha anterior.',
                        'data' => $fechaNueva->format('d/m/Y'),
                    );
                }else{
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => 'Fecha nueva no puede ser inferior a la fecha fecha anterior y/o la fecha actual.',
                        'data' => $fechaAnterior->format('d/m/Y'),
                    );
                }
            }else{
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Fecha no fue modificada.',
                    'data' => $fechaNueva->format('d/m/Y'),
                );
            }
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida', 
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Actualiza los tramites y valores según el arreglo recibido.
     *
     * @Route("/update", name="frotrteprecio_update")
     * @Method({"GET", "POST"})
     */
    public function updateAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);
            
            $em = $this->getDoctrine()->getManager();

            if ($params->tramitesPrecios) {
                $actualizados = 0;

                foreach ($params->tramitesPrecios as $tramitePrecioNew) {
                    $tramitePrecioOld = $em->getRepository("JHWEBFinancieroBundle:FroTrtePrecio")->find(
                        $tramitePrecioNew->id
                    );

                    if ($tramitePrecioOld->getFechaInicial() != $tramitePrecioNew->fechaInicio || $tramitePrecioOld->getValor() != $tramitePrecioNew->valor) {

                        $tramitePrecioOld->setFechaFinal(
                            new \Datetime('Y-m-d')
                        );
                        $tramitePrecioOld->setActivo(false);

                        $tramitePrecio = new FroTrtePrecio();

                        $tramitePrecio->setFechaInicial(
                            $helpers->convertDateTime($tramitePrecioNew->fechaInicial)
                        );
                        $tramitePrecio->setValor($tramitePrecioNew->valor);
                        $tramitePrecio->setValorTotal(0);
                        $tramitePrecio->setActivo(true);

                        if ($tramitePrecioNew->tramite) {
                            $tramite = $em->getRepository("JHWEBFinancieroBundle:FroTramite")->find(
                                $tramitePrecioNew->tramite->id
                            );
                            $tramitePrecio->setTramite($tramite);
                        }


                        if ($tramitePrecioNew->tipoVehiculo) {
                            $tipoVehiculo = $em->getRepository("JHWEBVehiculoBundle:VhloCfgTipoVehiculo")->find(
                                $tramitePrecioNew->tipoVehiculo->id
                            );
                            $tramitePrecio->setTipoVehiculo($tipoVehiculo);

                            $tramitePrecio->setNombre(
                                mb_strtoupper($tramite->getNombre().' '.$tipoVehiculo->getNombre(), 'utf-8')
                            );
                        }else{
                            $tramitePrecio->setNombre(
                                mb_strtoupper($tramite->getNombre(), 'utf-8')
                            );
                        }                        

                        if ($tramitePrecioNew->modulo) {
                            $modulo = $em->getRepository('JHWEBConfigBundle:CfgModulo')->find(
                                $tramitePrecioNew->modulo->id
                            );
                            $tramitePrecio->setModulo($modulo);
                        }

                        $tramitePrecio->setActivo(true);

                        $em->persist($tramitePrecio);
                        $em->flush();


                        $totalConceptos = 0;
                        if ($tramitePrecioNew->conceptos) {
                            foreach ($tramitePrecioNew->conceptos as $key => $conceptos) {
                                $tramiteConcepto = new FroTrteConcepto();

                                $concepto = $em->getRepository('JHWEBFinancieroBundle:FroTrteCfgConcepto')->find(
                                    $conceptos->concepto->id
                                );
                                $tramiteConcepto->setConcepto($concepto);

                                $tramiteConcepto->setPrecio($tramitePrecio);

                                $tramiteConcepto->setActivo(true);

                                $em->persist($tramiteConcepto);
                                $em->flush();

                                $totalConceptos += $concepto->getValor();
                            }
                        }

                        $tramitePrecio->setValorConcepto($totalConceptos);
                        $tramitePrecio->setValorTotal(
                            $totalConceptos + $tramitePrecio->getValor()
                        );

                        $em->flush();

                        $actualizados += 1;
                    }
                }

                if ($actualizados > 0) {
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => $actualizados.' Registros actualizados con éxito.',
                    );
                }else{
                    $response = array(
                        'status' => 'warning',
                        'code' => 401,
                        'message' => 'Ningún registro actualizado.',
                    );
                }
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Ningún valor de trámite disponible para actualizar.', 
                );
            }
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorización no válida', 
            );
        }

        return $helpers->json($response);
    }

    /**
     * Finds and displays a froTrtePrecio entity.
     *
     * @Route("/record", name="frotrteprecio_record")
     * @Method("POST")
     */
    public function recordAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $tramitesPrecio = $em->getRepository('JHWEBFinancieroBundle:FroTrtePrecio')->getRecordByFechas(
                $params
            );

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($tramitesPrecio).' registros encontrados con exito.',
                'data' => $tramitesPrecio
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
     * Finds and displays a froTrtePrecio entity.
     *
     * @Route("/search/tramite", name="frotrteprecio_record")
     * @Method("POST")
     */
    public function searchTramiteByIdAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $tramitePrecio = $em->getRepository('JHWEBFinancieroBundle:FroTrtePrecio')->find(
                $params->idTramitePrecio
            );

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Registro encontrado con éxito.',
                'data' => $tramitePrecio->getTramite()->getCodigo()
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
}
