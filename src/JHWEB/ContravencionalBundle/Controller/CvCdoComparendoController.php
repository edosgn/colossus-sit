<?php

namespace JHWEB\ContravencionalBundle\Controller;

use JHWEB\ContravencionalBundle\Entity\CvCdoComparendo;
use JHWEB\ContravencionalBundle\Entity\CvCdoTrazabilidad;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Cvcdocomparendo controller.
 *
 * @Route("cvcdocomparendo")
 */
class CvCdoComparendoController extends Controller
{
    /**
     * Lists all cvCdoComparendo entities.
     *
     * @Route("/", name="cvcdocomparendo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $comparendos = $em->getRepository('JHWEBContravencionalBundle:CvCdoComparendo')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($comparendos) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($comparendos)." registros encontrados.",
                'data' => $comparendos,
            );
        }


        return $helpers->json($response);
    }

    /**
     * Creates a new cvCdoComparendo entity.
     *
     * @Route("/new", name="cvcdocomparendo_new")
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

            $comparendo = new CvCdoComparendo();

            if (isset($params->comparendo->vehiculoPlaca)) {
                $comparendo->setPlaca($params->comparendo->vehiculoPlaca);
            }

            if ($params->comparendo->idOrganismoTransitoMatriculado) {
                $organismoTransitoMatriculado = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find(
                    $params->comparendo->idOrganismoTransitoMatriculado
                );
                $comparendo->setOrganismoTransitoMatriculado(
                    $organismoTransitoMatriculado
                );
            }

            if (isset($params->comparendo->vehiculoClase)) {
                $clase = $em->getRepository('JHWEBVehiculoBundle:VhloCfgClase')->find(
                    $params->comparendo->vehiculoClase
                );
                $comparendo->setClase($clase->getNombre());
            }

            if (isset($params->comparendo->vehiculoServicio)) {
                $servicio = $em->getRepository('JHWEBVehiculoBundle:VhloCfgServicio')->find(
                    $params->comparendo->vehiculoServicio
                );
                $comparendo->setServicio($servicio->getNombre());
            }

            if (isset($params->comparendo->vehiculoRadioAccion)) {
                $radioAccion = $em->getRepository('JHWEBVehiculoBundle:VhloCfgRadioAccion')->find(
                    $params->comparendo->vehiculoRadioAccion
                );
                $comparendo->setRadioAccion($radioAccion->getNombre());
            }

            if (isset($params->comparendo->vehiculoModalidadTransporte)) {
                $modalidadTransporte = $em->getRepository('JHWEBVehiculoBundle:VhloCfgModalidadTransporte')->find(
                    $params->comparendo->vehiculoModalidadTransporte
                );
                $comparendo->setModalidadTransporte(
                    $modalidadTransporte->getNombre()
                );
            }

            if (isset($params->comparendo->vehiculoTransportePasajero)) {
                $transportePasajero = $em->getRepository('JHWEBVehiculoBundle:VhloCfgTransportePasajero')->find(
                    $params->comparendo->vehiculoTransportePasajero
                );
                $comparendo->setTransportePasajero(
                    $transportePasajero->getNombre()
                );
            }

            if (isset($params->comparendo->vehiculoTransporteEspecial)) {
                $transporteEspecial = $em->getRepository('JHWEBVehiculoBundle:VhloCfgTransporteEspecial')->find(
                    $params->comparendo->vehiculoTransporteEspecial
                );
                $comparendo->setTransporteEspecial(
                    $transporteEspecial->getNombre()
                );
            }

            $comparendo->setFecha(new \DateTime($params->comparendo->fecha));
            $hora = $params->comparendo->hora;
            $minutos = $params->comparendo->minutos;
            
            $comparendo->setHora(new \DateTime($hora.':'.$minutos.':00'));
            
            $comparendo->setDireccion($params->comparendo->direccion);
            $comparendo->setLocalidad($params->comparendo->localidad);
            $comparendo->setFuga($params->comparendo->fuga);
            $comparendo->setAccidente($params->comparendo->accidente);
            $comparendo->setRetencionLicencia(
                $params->comparendo->retencionLicencia
            );

            //$comparendo->setFotomulta(false);
            //$comparendo->setGradoAlcohol($params->comparendo->gradoAlchoholemia); 
            
            $comparendo->setObservacionesDigitador(
                $params->comparendo->observacionesDigitador
            );

            $comparendo->setObservacionesAgente(
                $params->comparendo->observacionesAgente
            );
            //$comparendo->setValorAdicional(0);

            if (isset($params->fechaNotificacion)) {
                $comparendo->setFechaNotificacion(
                    new \DateTime($params->fechaNotificacion)
                );
            }

            $agenteTransito = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->find(
                $params->comparendo->idFuncionario
            );
            $comparendo->setAgenteTransito($agenteTransito);
            $comparendo->setOrganismoTransito($agenteTransito->getOrganismoTransito());

            $consecutivo = $em->getRepository('JHWEBPersonalBundle:PnalCfgCdoConsecutivo')->find(
                $params->comparendo->idConsecutivo
            );
            $comparendo->setConsecutivo($consecutivo);

            $municipio = $em->getRepository('JHWEBConfigBundle:CfgMunicipio')->find(
                $params->comparendo->idMunicipioLugar
            );
            $comparendo->setMunicipio($municipio);

            if (isset( $params->infractor->idTipoInfractor)) {
                $tipoInfractor = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgTipoInfractor')->find(
                    $params->infractor->idTipoInfractor
                );
                $comparendo->setTipoInfractor($tipoInfractor);
            }

            /* INFRACTOR */
            if ($params->infractor->idTipoIdentificacion) {
                $tipoIdentificacion = $em->getRepository('JHWEBUsuarioBundle:UserCfgTipoIdentificacion')->find(
                    $params->infractor->idTipoIdentificacion
                );
                $comparendo->setInfractorTipoIdentificacion(
                    $tipoIdentificacion
                );
            }

            if ($params->infractor->idCategoriaLicenciaConduccion) {
                $categoria = $em->getRepository('JHWEBUsuarioBundle:UserLcCfgCategoria')->find(
                    $params->infractor->idCategoriaLicenciaConduccion
                );
                $comparendo->setCategoria($categoria->getNombre());
            }

            $comparendo->setInfractorIdentificacion(
                $params->infractor->identificacion
            );

            $comparendo->setFechaExpedicion(
                new \Datetime($params->infractor->fechaExpedicion)
            );

            $comparendo->setFechaVencimiento(
                new \Datetime($params->infractor->fechaVencimiento)
            );

            $comparendo->setInfractorNombres(
                $params->infractor->nombres
            );

            if ($params->infractor->direccion) {
                $comparendo->setInfractorDireccion(
                    $params->infractor->direccion
                );
            }

            if ($params->infractor->telefono) {
                $comparendo->setInfractorTelefono(
                    $params->infractor->telefono
                );
            }

            if ($params->infractor->correo) {
                $comparendo->setInfractorEmail(
                    $params->infractor->correo
                );
            }

            if ($params->comparendo->idOrganismoTransitoLicencia) {
                $organismoTransitoLicencia = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find(
                    $params->comparendo->idOrganismoTransitoLicencia
                );
                $comparendo->setOrganismoTransitoLicencia(
                    $organismoTransitoLicencia
                );
            }

            if ($params->comparendo->licenciaTransitoNumero) {
                $comparendo->setNumeroLicenciaTransito(
                    $params->comparendo->licenciaTransitoNumero
                );
            }

            /* PROPIETARIO */
            if ($params->propietario->idTipoIdentificacion) {
                $tipoIdentificacion = $em->getRepository('JHWEBUsuarioBundle:UserCfgTipoIdentificacion')->find(
                    $params->propietario->idTipoIdentificacion
                );
                $comparendo->setPropietarioTipoIdentificacion(
                    $tipoIdentificacion
                );
            }

            if ($params->propietario->identificacion) {
                $comparendo->setPropietarioIdentificacion(
                    $params->propietario->identificacion
                );
            }

            if ($params->propietario->nombres) {
                $comparendo->setPropietarioNombre(
                    $params->propietario->nombres
                );
            }

            /* EMPRESA */
            if ($params->empresa->nombre) {
                $comparendo->setEmpresaNombre(
                    $params->empresa->nombre
                );
            }

            if ($params->empresa->nit) {
                $comparendo->setEmpresaNit(
                    $params->empresa->nit
                );
            }

            if ($params->empresa->tarjeta) {
                $comparendo->setTarjetaOperacion(
                    $params->empresa->tarjeta
                );
            }

            /* TESTIGO */
            if ($params->testigo->nombres) {
                $comparendo->setTestigoNombres(
                    $params->testigo->nombres
                );
            }

            if ($params->testigo->identificacion) {
                $comparendo->setTestigoIdentificacion(
                    $params->testigo->identificacion
                );
            }

            if ($params->testigo->direccion) {
                $comparendo->setTestigoDireccion(
                    $params->testigo->direccion
                );
            }

            if ($params->testigo->telefono) {
                $comparendo->setTestigoTelefono(
                    $params->testigo->telefono
                );
            }

            /* INFRACCION */
            $infraccion = $em->getRepository('JHWEBFinancieroBundle:FroInfraccion')->find(
                $params->comparendo->idInfraccion
            );
            $comparendo->setInfraccion($infraccion);

            //Calcula valor de infracción
            $smlmv = $em->getRepository('JHWEBConfigBundle:CfgSmlmv')->findOneByActivo(
                true
            );

            if ($smlmv) {
                $valorInfraccion = round(($smlmv->getValor() / 30) * $infraccion->getCategoria()->getSmldv());

                //Valida si hay fuga el valor de la infracción se duplica
                if ($params->comparendo->fuga) {
                    $valorInfraccion = $valorInfraccion * 2;
                }
                $comparendo->setValorInfraccion($valorInfraccion);

                $comparendo->setPagado(false);
                $comparendo->setCurso(false);
                $comparendo->setAudiencia(false);
                $comparendo->setRecurso(false);
                $comparendo->setNotificado(false);
                $comparendo->setPorcentajeDescuento(0);

                $estado = $helpers->comparendoState($params);
                $comparendo->setEstado($estado);
                $comparendo->setActivo(true);
                
                $em->persist($comparendo);
                $em->flush();

                $trazabilidad = new CvCdoTrazabilidad();

                $trazabilidad->setFecha(
                    new \Datetime($params->comparendo->fecha)
                );
                $trazabilidad->setHora(
                    new \DateTime($hora.':'.$minutos.':00')
                );
                $trazabilidad->setActivo(true); 
                $trazabilidad->setComparendo($comparendo);
                $estado = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->find(1);
                $trazabilidad->setEstado($estado);

                $em->persist($trazabilidad);
                $em->flush();

                if ($consecutivo) {
                    $consecutivo->setEstado('UTILIZADO');
                    $consecutivo->setActivo(false);
                    $em->flush();
                }

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro creado con exito",
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No se ha registrado el valor del SMLMV.",
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
     * Finds and displays a cvCdoComparendo entity.
     *
     * @Route("/show", name="cvcdocomparendo_show")
     * @Method("POSt")
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

            $comparendo = $em->getRepository('JHWEBContravencionalBundle:CvCdoComparendo')->find(
                $params->id
            );

            if ($comparendo) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado con exito",
                    'data' => $comparendo
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos", 
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
     * Displays a form to edit an existing cvCdoComparendo entity.
     *
     * @Route("/{id}/edit", name="cvcdocomparendo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CvCdoComparendo $cvCdoComparendo)
    {
        $deleteForm = $this->createDeleteForm($cvCdoComparendo);
        $editForm = $this->createForm('JHWEB\ContravencionalBundle\Form\CvCdoComparendoType', $cvCdoComparendo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cvcdocomparendo_edit', array('id' => $cvCdoComparendo->getId()));
        }

        return $this->render('cvcdocomparendo/edit.html.twig', array(
            'cvCdoComparendo' => $cvCdoComparendo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cvCdoComparendo entity.
     *
     * @Route("/{id}", name="cvcdocomparendo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CvCdoComparendo $cvCdoComparendo)
    {
        $form = $this->createDeleteForm($cvCdoComparendo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cvCdoComparendo);
            $em->flush();
        }

        return $this->redirectToRoute('cvcdocomparendo_index');
    }

    /**
     * Creates a form to delete a cvCdoComparendo entity.
     *
     * @param CvCdoComparendo $cvCdoComparendo The cvCdoComparendo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CvCdoComparendo $cvCdoComparendo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cvcdocomparendo_delete', array('id' => $cvCdoComparendo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* =============================================== */

    /**
     * Deletes a comparendo entity.
     *
     * @Route("/{polca}/archivo", name="cvcdocomparendo_upload")
     * @Method("POST")
     */
    public function uploadFileAction(Request $request, $polca)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $json = $request->get("data", null);
        
        $params = json_decode($json);

        foreach ($params as $key => $comparendo) {
            $comparendoNew = new CvCdoComparendo();

            $comparendoNew->setNumeroOrden($comparendo[5]);
            $comparendoNew->setFechaDiligenciamiento(
                new \DateTime($comparendo[6])
            );
            $comparendoNew->setLugarInfraccion($comparendo[7]);
            $comparendoNew->setBarrioInfraccion($comparendo[8]);
            $comparendoNew->setObservacionesAgente($comparendo[9]);
            $comparendoNew->setTipoInfractor($comparendo[10]);
            $comparendoNew->setTarjetaOperacionInfractor($comparendo[11]);
            $comparendoNew->setFuga($comparendo[12]);
            $comparendoNew->setAccidente($comparendo[13]);
            $comparendoNew->setPolca($polca);
            $comparendoNew->setFechaNotificacion(
                new \DateTime($comparendo[14])
            );
            $comparendoNew->setGradoAlchoholemia($comparendo[15]);
            $comparendoNew->setFotomulta($comparendo[16]);
            $comparendoNew->setObservacionesDigitador($comparendo[17]);
            $comparendoNew->setRetencionLicencia($comparendo[18]);
            $comparendoNew->setEstado(true);

            //Relación llaves foraneas
            $municipio = $em->getRepository('JHWEBConfigBundle:CfgMunicipio')->getOneByCodigoDian($comparendo[0]);
            $comparendoNew->setMunicipio($municipio);

            $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->getOneByPlaca($comparendo[1]);
            $comparendoNew->setVehiculo($vehiculo);

            $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->getOneByNumeroIdentificacion($comparendo[2]);
            $comparendoNew->setCuidadano($ciudadano);

            $funcionario = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->findOneByPlaca($comparendo[3]);
            $comparendoNew->setFuncionario($funcionario);

            $seguimientoEntrega = $em->getRepository('JHWEBContravencionalBundle:CvCdoSeguimientoEntrega')->findOneByNumeroOficio($comparendo[4]);
            $comparendoNew->setSeguimientoEntrega($seguimientoEntrega);
            
            $em->persist($comparendoNew);
            $em->flush();
        }

        $response = array(
            'status' => 'success',
            'code' => 200,
            'message' => "Registro creado con exito",
        );
        return $helpers->json($response);
    }

    /**
     * Busca comparendo por ciudadano.
     *
     * @Route("/search/infractor", name="cvcdocomparendo_search_infractor")
     * @Method({"GET", "POST"})
     */
    public function searchByInfractorAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            
            $em = $this->getDoctrine()->getManager();

            $comparendos = $em->getRepository('JHWEBContravencionalBundle:CvCdoComparendo')->findBy(
                array(
                    'infractorIdentificacion' => $params->infractorIdentificacion,
                    'estado' => array(1,2,3,4,5)
                )
            );

            if ($comparendos) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "El infractor tiene ".count($comparendos)." comparendos.",
                    'data' => $comparendos,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El ciudadano no tiene comparendos en la base de datos.",
                );
            }

        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida.",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Busca comparendo por número.
     *
     * @Route("/search/estado", name="cvcdocomparendo_search_estado")
     * @Method("POST")
     */
    public function searchByEstadoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);


        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $comparendos = $em->getRepository('JHWEBContravencionalBundle:CvCdoComparendo')->findBy(
                array(
                    'estado' => $params->idEstado
                )
            );

            if ($comparendos) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($comparendos)." registros encontrados.",
                    'data' => $comparendos
            );
            }else{
                 $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Ningún registro encontrado.", 
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
     * Busca comparendo por parametros (agente, fecha desde y hasta, por tipo infracción).
     *
     * @Route("/search/parametros", name="cvcdocomparendo_search_parametros")
     * @Method({"GET","POST"})
     */
    public function searchByParametros(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);


        if ($authCheck == true) {
            $json = $request->get("json",null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            $comparendos = $em->getRepository('JHWEBContravencionalBundle:CvCdoComparendo')->findByParametros($params);
            if ($comparendos) {
                $response = array(
                    'status' => 'error',
                    'code' => 200,
                    'message' => count($comparendos)." Comparendos encontrados.", 
                    'data' => $comparendos,
            );
            }else{
                 $response = array(
                    'status' => 'success',
                    'code' => 400,
                    'message' => "No existe comparendos para esos parametros de busqueda", 
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
     * Busca comparendos por parametros (nombres, identificacion, placa o numero).
     *
     * @Route("/search/filtros", name="cvcdocomparendo_search_filtros")
     * @Method({"GET","POST"})
     */
    public function searchByFiltros(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);


        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $comparendos = $em->getRepository('JHWEBContravencionalBundle:CvCdoComparendo')->getByFilter(
                $params
            );

            if ($comparendos) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($comparendos)." Comparendos encontrados", 
                    'data' => $comparendos,
            );
            }else{
                 $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No existen comparendos para esos filtros de búsqueda", 
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
     * Busca comparendos por parametros (nombres, identificacion, placa o numero).
     *
     * @Route("/search/filtros/factura", name="cvcdocomparendo_search_filtros_factura")
     * @Method({"GET","POST"})
     */
    public function searchByFiltrosForFactura(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $comparendos = $em->getRepository('JHWEBContravencionalBundle:CvCdoComparendo')->getByFilterForFactura(
                $params
            );

            if ($comparendos) {
                $infractor = $comparendos[0]->getInfractorNombres().' '.$comparendos[0]->getInfractorApellidos();
                $infractorIdentificacion = $comparendos[0]->getInfractorIdentificacion();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($comparendos)." Comparendos encontrados", 
                    'data' => array(
                        'infractor' => array(
                            'nombres' => $infractor,
                            'identificacion' => $infractorIdentificacion,
                        ),
                        'comparendos' => $comparendos,
                    )
            );
            }else{
                 $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No existen comparendos para esos filtros de búsqueda", 
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
     * Valida si puede marcar la opción curso según la fecha de liquidación.
     *
     * @Route("/validate/curso", name="cvcdocomparendo_validate_curso")
     * @Method({"GET", "POST"})
     */
    public function validateCursoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $comparendo = $em->getRepository('JHWEBContravencionalBundle:CvCdoComparendo')->find(
                $params->id
            );
            
            if ($comparendo) {
                $diasHabiles = $helpers->getDiasHabiles($comparendo->getFecha());

                if ($diasHabiles < 21) {
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => 'Selección de curso permitida.', 
                        'data'=> 21 - $diasHabiles,
                    );
                }else{
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => 'Selección de curso no permitida.', 
                        'data'=> 21 - $diasHabiles,
                    );
                }
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El comparendo no existe.", 
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
     * Busca un unico comparendo por numero.
     *
     * @Route("/search/number", name="cvcdocomparendo_search_number")
     * @Method({"GET","POST"})
     */
    public function searchByNumber(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);


        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $comparendo = $em->getRepository('JHWEBContravencionalBundle:CvCdoComparendo')->getByNumber(
                $params->numero
            );

            if ($comparendo) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Comparendo encontrado satisfactoriamente.", 
                    'data' => $comparendo,
            );
            }else{
                 $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No existe ningún comparendo con el número que desea buscar.", 
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
     * Exporta un comparendo en un archivo plano.
     *
     * @Route("/export", name="cvcdocomparendo_export")
     * @Method("GET")
     */
    public function exportAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $comparendos = $em->getRepository('JHWEBContravencionalBundle:CvCdoComparendo')->findAll();
        /*foreach ($comparendos as $key => $comparendo) {
            $comparendoId = $comparendo->getId();
            $vehiculoId = $comparendo->getVehiculo()->getId();
            
            $inmovilizacion = $em->getRepository('AppBundle:Inmovilizacion')->findOneBy(array('comparendo' => $comparendoId));      
           $comparendo->{"inmovilizacion"}  = $inmovilizacion;

            //$propietarioVehiculo = $em->getRepository('AppBundle:PropietarioVehiculo')->findBy(array('vehiculo' => $vehiculoId));
            //var_dump($comparendo);
            //die();
        }*/
        
        $response = array(
            'status' => 'success',
            'code' => 200,
            'message' => "lista de comparendos",
            'data' => $comparendos,
        );
        return $helpers->json($response);
    }

    /**
     * Busca peticionario por cedula o por nombre entidad y numero de oficio.
     *
     * @Route("/{idUsuario}/pazysalvo/pdf", name="cvcdocomparendo_pdf")
     * @Method({"GET", "POST"})
     */
    public function pdfAction(Request $request, $idUsuario)
    {
        setlocale(LC_ALL,"es_ES");
        $fechaActual = strftime("%d de %B del %Y");

        $em = $this->getDoctrine()->getManager();

        $usuario = $em->getRepository('UsuarioBundle:Usuario')->find($idUsuario);

        $comparendos = $em->getRepository('JHWEBContravencionalBundle:CvCdoComparendo')->findBy(
            array(
                'infractorIdentificacion' => $usuario->getIdentificacion(),
                'estado' => array(1,2,3,4,5)
            )
        );

        $html = $this->renderView('@App/comparendo/pdf.template.html.twig', array(
            'usuario'=>$usuario,
            'comparendos'=>$comparendos,
            'fechaActual' => $fechaActual
        ));

        $pdf = $this->container->get("white_october.tcpdf")->create(
            'PORTRAIT',
            PDF_UNIT,
            PDF_PAGE_FORMAT,
            true,
            'UTF-8',
            false
        );
        $pdf->SetAuthor('qweqwe');
        $pdf->SetTitle('Paz y salvo');
        $pdf->SetSubject('Your client');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        $pdf->setFontSubsetting(true);

        $pdf->SetFont('helvetica', '', 11, '', true);
        $pdf->SetMargins('25', '25', '25');
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->AddPage();

        $pdf->writeHTMLCell(
            $w = 0,
            $h = 0,
            $x = '',
            $y = '',
            $html,
            $border = 0,
            $ln = 1,
            $fill = 0,
            $reseth = true,
            $align = '',
            $autopadding = true
        );

        $pdf->Output("example.pdf", 'I');
        die();
    }

    /**
     * Busca si existen trazabilidades por id de documento.
     *
     * @Route("/record", name="cvcdocomparendo_record")
     * @Method({"GET", "POST"})
     */
    public function recordAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $trazabilidades = $em->getRepository('JHWEBContravencionalBundle:CvCdoTrazabilidad')->getByComparendo(
                $params->id
            );

            $comparendo = $em->getRepository('JHWEBContravencionalBundle:CvCdoComparendo')->find($params->id);
            $acuerdoPago = $comparendo->getAcuerdoPago();

            $amortizaciones = null;
            if ($acuerdoPago) {
                $amortizaciones = $em->getRepository('JHWEBFinancieroBundle:FroAmortizacion')->findByAcuerdoPago($acuerdoPago->getId());
            }

            if ($trazabilidades) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($trazabilidades)." Documentos registrados.", 
                    'data'=> array(
                        'trazabilidades' => $trazabilidades,
                        'acuerdoPago' => $acuerdoPago,
                        'amortizaciones' => $amortizaciones,
                    )
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El comparendo no tiene trazabilidades aún.", 
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
     * Busca un comparendo por agente y fecha.
     *
     * @Route("/search/agente", name="cvcdocomparendo_search_agente")
     * @Method({"GET","POST"})
     */
    public function searchByAgente(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);


        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);
            
            $em = $this->getDoctrine()->getManager();

            if($params->idOrganismoTransito) {
                $organismoTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find($params->idOrganismoTransito);
            }

            $comparendos = $em->getRepository('JHWEBContravencionalBundle:CvCdoComparendo')->getByAgente($params);

            if ($comparendos) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Comparendos encontrados satisfactoriamente.", 
                    'data' => $comparendos,
                    'organismoTransito' => $organismoTransito->getNombre(),
            );
            }else{
                 $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No existe ningún comparendo asociado al agente de transito.", 
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
     * Finds and displays a comparendo entity by date.
     *
     * @Route("/comparendo/fecha", name="cvcdocomparendo_date")
     * @Method("GET")
     */
    public function getComparendoByFechaAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();

            $comparendos = $em->getRepository('JHWEBContravencionalBundle:CvCdoComparendo')->getByFecha($params);

            if($comparendos){
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado",
                    'data' => $comparendo,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No se encontraron comparendos diligenciados para el rango de fechas establecido.",
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
}
