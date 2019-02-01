<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comparendo;
use AppBundle\Entity\Inmovilizacion;
use JHWEB\ContravencionalBundle\Entity\CvCdoTrazabilidad;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;


/**
 * Comparendo controller.
 *
 * @Route("comparendo")
 */
class ComparendoController extends Controller
{
    /** 
     * Lists all comparendo entities.
     *
     * @Route("/", name="comparendo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $comparendos = $em->getRepository('AppBundle:Comparendo')->findBy(
            array('estado' => 1)
        );

        $response = array(
            'status' => 'success',
            'code' => 200,
            'msj' => "lista de comparendos",
            'data' => $comparendos,
        );
        return $helpers->json($response);
    }

    /**
     * Creates a new comparendo entity.
     *
     * @Route("/new", name="comparendo_new")
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

            $em = $this->getDoctrine()->getManager();

            $comparendo = new Comparendo();

            if (isset($params->comparendo->vehiculoPlaca)) {
                $comparendo->setPlaca($params->comparendo->vehiculoPlaca);
            }

            if ($params->comparendo->idOrganismoTransitoMatriculado) {
                $organismoTransitoMatriculado = $em->getRepository('AppBundle:OrganismoTransito')->find(
                    $params->comparendo->idOrganismoTransitoMatriculado
                );
                $comparendo->setOrganismoTransitoMatriculado(
                    $organismoTransitoMatriculado
                );
            }

            if (isset($params->comparendo->vehiculoClase)) {
                $clase = $em->getRepository('AppBundle:Clase')->find(
                    $params->comparendo->vehiculoClase
                );
                $comparendo->setClase($clase->getNombre());
            }

            if (isset($params->comparendo->vehiculoServicio)) {
                $servicio = $em->getRepository('AppBundle:Servicio')->find(
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

            $agenteTransito = $em->getRepository('AppBundle:MpersonalFuncionario')->find(
                $params->comparendo->idFuncionario
            );
            $comparendo->setAgenteTransito($agenteTransito);
            $comparendo->setSedeOperativa($agenteTransito->getSedeOperativa());

            $consecutivo = $em->getRepository('AppBundle:MpersonalComparendo')->find(
                $params->comparendo->idConsecutivo
            );
            $comparendo->setConsecutivo($consecutivo);

            $municipio = $em->getRepository('AppBundle:Municipio')->find(
                $params->comparendo->idMunicipioLugar
            );
            $comparendo->setMunicipio($municipio);

            if (isset( $params->infractor->idTipoInfractor)) {
                $tipoInfractor = $em->getRepository('AppBundle:CfgTipoInfractor')->find(
                    $params->infractor->idTipoInfractor
                );
                $comparendo->setTipoInfractor($tipoInfractor);
            }

            /* INFRACTOR */
            if ($params->infractor->idTipoIdentificacion) {
                $tipoIdentificacion = $em->getRepository('AppBundle:TipoIdentificacion')->find(
                    $params->infractor->idTipoIdentificacion
                );
                $comparendo->setInfractorTipoIdentificacion(
                    $tipoIdentificacion
                );
            }

            if ($params->infractor->idCategoriaLicenciaConduccion) {
                $categoria = $em->getRepository('AppBundle:CfgLicenciaConduccionCategoria')->find(
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
                $organismoTransitoLicencia = $em->getRepository('AppBundle:OrganismoTransito')->find(
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
                $tipoIdentificacion = $em->getRepository('AppBundle:TipoIdentificacion')->find(
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
            $infraccion = $em->getRepository('AppBundle:MflInfraccion')->find(
                $params->comparendo->idInfraccion
            );
            $comparendo->setInfraccion($infraccion);

            //Calcula valor de infracción
            $smlmv = $em->getRepository('AppBundle:CfgSmlmv')->findOneByActivo(
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
                $estado = $em->getRepository('AppBundle:CfgComparendoEstado')->find(1);
                $trazabilidad->setEstado($estado);

                $em->persist($trazabilidad);
                $em->flush();

                if ($params->comparendo->inmovilizacion) {
                    $inmovilizacion = new Inmovilizacion();

                    $inmovilizacion->setNumero(123);
                    $inmovilizacion->setConsecutivo(0);
                    $inmovilizacion->setFecha(
                        new \Datetime($params->comparendo->fecha)
                    );

                    $grua = $em->getRepository('JHWEBPaqueaderoBundle:PqoCfgGrua')->find(
                        $params->inmovilizacion->idGrua
                    );
                    $inmovilizacion->setGrua($grua);

                    $patio = $em->getRepository('JHWEBPaqueaderoBundle:PqoCfgPatio')->find(
                        $params->inmovilizacion->idPatio
                    );
                    $inmovilizacion->setPatio($patio);
                    $inmovilizacion->setComparendo($comparendo);

                    $em->persist($inmovilizacion);
                    $em->flush();
                }

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
     * Finds and displays a comparendo entity.
     *
     * @Route("/{id}/show", name="comparendo_show")
     * @Method("GET")
     */
    public function showAction(Request $request, Comparendo $comparendo)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "Registro encontrado",
                'data' => $comparendo,
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
     * Displays a form to edit an existing comparendo entity.
     *
     * @Route("/{id}/edit", name="comparendo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Comparendo $comparendo)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);

            $numeroOrden = $params->numeroOrden;
            $fechaDiligenciamiento = (isset($params->fechaDiligenciamiento)) ? $params->fechaNacimiento : null;
            $fechaDiligenciamientoDateTime = new \DateTime($fechaDiligenciamiento);
            $lugarInfraccion = $params->lugarInfraccion;
            $barrioInfraccion = $params->barrioInfraccion;
            $observacionesAgente = $params->observacionesAgente;
            $observacionesDigitador = $params->observacionesDigitador;
            $tipoInfractor = $params->tipoInfractor;
            $tarjetaOperacionInfractor = $params->tarjetaOperacionInfractor;
            $fuga = $params->fuga;
            $accidente = $params->accidente;
            $polca = $params->polca;
            $fechaNotificacion = (isset($params->fechaNotificacion)) ? $params->fechaNacimiento : null;
            $fechaNotificacionDateTime = new \DateTime($fechaNotificacion);
            $gradoAlchoholemia = $params->gradoAlchoholemia;

            $em = $this->getDoctrine()->getManager();

            $municipio = $em->getRepository('AppBundle:Municipio')->find($municipioId);
            $vehiculo = $em->getRepository('AppBundle:Vehiculo')->find($vehiculoId);
            $ciudadano = $em->getRepository('AppBundle:Ciudadano')->find($ciudadanoId);
            $agenteTransito = $em->getRepository('AppBundle:AgenteTransito')->find($agenteTransitoId);
            $seguimientoEntrega = $em->getRepository('AppBundle:SeguimientoEntrega')->find($seguimientoEntregaId);

            if ($comparendo) {
                $comparendo->setNumeroOrden($numeroOrden);
                $comparendo->setFechaDiligenciamiento($fechaDiligenciamientoDateTime);
                $comparendo->setLugarInfraccion($lugarInfraccion);
                $comparendo->setBarrioInfraccion($barrioInfraccion);
                $comparendo->setObservacionesAgente($observacionesAgente);
                $comparendo->setTarjetaOperacionInfractor($tarjetaOperacionInfractor);
                $comparendo->setFuga($fuga);
                $comparendo->setAccidente($accidente);
                $comparendo->setPolca($polca);
                $comparendo->setFechaNotificacion($fechaNotificacionDateTime);
                $comparendo->setGradoAlchoholemia($gradoAlchoholemia);
                $comparendo->setObservacionesDigitador($observacionesDigitador);
                //Relación llaves foraneas
                $comparendo->setMunicipio($municipio);
                $comparendo->setVehiculo($vehiculo);
                $comparendo->setCiudadano($ciudadano);
                $comparendo->setAgenteTransito($agenteTransito);
                $comparendo->setSeguimientoEntrega($seguimientoEntrega);

                $em->persist($comparendo);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro actualizado con exito",
                    'data' => $comparendo,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El registro no se encuentra en la base de datos",
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida para editar banco",
            );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a comparendo entity.
     *
     * @Route("/{id}/delete", name="comparendo_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, Comparendo $comparendo)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();

            $comparendo->setEstado(false);
            $em = $this->getDoctrine()->getManager();
            $em->persist($comparendo);
            $em->flush();
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "Registro eliminado con exito",
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
     * Creates a form to delete a comparendo entity.
     *
     * @param Comparendo $comparendo The comparendo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Comparendo $comparendo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('comparendo_delete', array('id' => $comparendo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Deletes a comparendo entity.
     *
     * @Route("/{polca}/archivo", name="comparendo_delete")
     * @Method("POST")
     */
    public function uploadFileAction(Request $request, $polca)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $json = $request->get("json", null);
        $params = json_decode($json);
        foreach ($params as $key => $comparendo) {
            $municipio = $em->getRepository('AppBundle:Municipio')->findOneByCodigoDian($comparendo[0]);
            $vehiculo = $em->getRepository('AppBundle:Vehiculo')->findOneByPlaca($comparendo[1]);
            $ciudadano = $em->getRepository('AppBundle:Ciudadano')->findOneByNumeroIdentificacion($comparendo[2]);
            $agenteTransito = $em->getRepository('AppBundle:AgenteTransito')->findOneByPlaca($comparendo[3]);
            $seguimientoEntrega = $em->getRepository('AppBundle:SeguimientoEntrega')->findOneByNumeroOficio($comparendo[4]);
            $comparendoNew = new Comparendo();
            $comparendoNew->setNumeroOrden($comparendo[5]);
            $fechaDiligenciamiento = new \DateTime($comparendo[6]);
            $comparendoNew->setFechaDiligenciamiento($fechaDiligenciamiento);
            $comparendoNew->setLugarInfraccion($comparendo[7]);
            $comparendoNew->setBarrioInfraccion($comparendo[8]);
            $comparendoNew->setObservacionesAgente($comparendo[9]);
            $comparendoNew->setTipoInfractor($comparendo[10]);
            $comparendoNew->setTarjetaOperacionInfractor($comparendo[11]);
            $comparendoNew->setFuga($comparendo[12]);
            $comparendoNew->setAccidente($comparendo[13]);
            $comparendoNew->setPolca($polca);
            $fechaNotificacion = new \DateTime($comparendo[14]);
            $comparendoNew->setFechaNotificacion($fechaNotificacion);
            $comparendoNew->setGradoAlchoholemia($comparendo[15]);
            $comparendoNew->setFotomulta($comparendo[16]);
            $comparendoNew->setObservacionesDigitador($comparendo[17]);
            $comparendoNew->setRetencionLicencia($comparendo[18]);
            $comparendoNew->setEstado(true);
            //Relación llaves foraneas
            $comparendoNew->setMunicipio($municipio);
            $comparendoNew->setVehiculo($vehiculo);
            $comparendoNew->setCuidadano($ciudadano);
            $comparendoNew->setAgenteTransito($agenteTransito);
            $comparendoNew->setSeguimientoEntrega($seguimientoEntrega);

            $em->persist($comparendoNew);
            $em->flush();
        }

        $response = array(
            'status' => 'success',
            'code' => 200,
            'msj' => "Registro creado con exito",
        );
        return $helpers->json($response);
    }

    /**
     * Busca comparendo por número.
     *
     * @Route("/search", name="comparendo_search")
     * @Method("POST")
     */
    public function searchAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            
            $comparendo = $em->getRepository('AppBundle:Comparendo')->findOneBy(
                array('numeroOrden' => $params->numeroOrden)
            );

            if ($comparendo != null) {
                $response = array(
                    'status' => 'error',
                    'code' => 200,
                    'msj' => "Número de comparendo ya existe",
                );
            } else {
                $response = array(
                    'status' => 'success',
                    'code' => 400,
                    'msj' => "Número de orden no encontrada en la base de datos",
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
     * Busca comparendo por ciudadano.
     *
     * @Route("/search/infractor", name="comparendo_search_infractor")
     * @Method({"GET", "POST"})
     */
    public function searchByInfractorAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);
            
            $em = $this->getDoctrine()->getManager();

            $comparendos = $em->getRepository('AppBundle:Comparendo')->findBy(
                array(
                    'infractorIdentificacion' => $params->infractorIdentificacion
                )
            );

            if ($comparendos) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "El infractor tiene ".count($comparendos)." comparendos",
                    'data' => $comparendos,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El ciudadano no tiene comparendos en la base de datos",
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
     * Busca comparendo por número.
     *
     * @Route("/search/estado", name="comparendo_search_estado")
     * @Method("POST")
     */
    public function searchByEstadoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);


        if ($authCheck == true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $comparendos = $em->getRepository('AppBundle:Comparendo')->findBy(
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
     * @Route("/search/parametros", name="comparendo_search_parametros")
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
            $comparendos = $em->getRepository('AppBundle:Comparendo')->findByParametros($params);
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
                    'msj' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($response);
    }

    /**
     * Busca comparendos por parametros (nombres, identificacion, placa o numero).
     *
     * @Route("/search/filtros", name="comparendo_search_filtros")
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

            $comparendos = $em->getRepository('AppBundle:Comparendo')->getByFilter(
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
                    'msj' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($response);
    }

    /**
     * Busca comparendos por parametros (nombres, identificacion, placa o numero).
     *
     * @Route("/search/filtros/factura", name="comparendo_search_filtros_factura")
     * @Method({"GET","POST"})
     */
    public function searchByFiltrosFactura(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);


        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $comparendos = $em->getRepository('AppBundle:Comparendo')->getByFilterForFactura(
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
                    'msj' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($response);
    }

    /**
     * Valida si puede marcar la opción curso según la fecha de liquidación.
     *
     * @Route("/validate/curso", name="comparendo_validate_curso")
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

            $comparendo = $em->getRepository('AppBundle:Comparendo')->find(
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
     * @Route("/search/number", name="comparendo_search_number")
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

            $comparendo = $em->getRepository('AppBundle:Comparendo')->getByNumber(
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
                    'msj' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($response);
    }

    /**
     * Exporta un comparendo en un archivo plano.
     *
     * @Route("/export", name="comparendo_export")
     * @Method("GET")
     */
    public function exportAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $comparendos = $em->getRepository('AppBundle:Comparendo')->findAll();
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
            'msj' => "lista de comparendos",
            'data' => $comparendos,
        );
        return $helpers->json($response);
    }

    /**
     * Busca peticionario por cedula o por nombre entidad y numero de oficio.
     *
     * @Route("/{idUsuario}/pazysalvo/pdf", name="comparendo_pdf")
     * @Method({"GET", "POST"})
     */
    public function pdfAction(Request $request, $idUsuario)
    {
        setlocale(LC_ALL,"es_ES");
        $fechaActual = strftime("%d de %B del %Y");

        $em = $this->getDoctrine()->getManager();

        $usuario = $em->getRepository('UsuarioBundle:Usuario')->find($idUsuario);

        $html = $this->renderView('@App/comparendo/pdf.template.html.twig', array(
            'usuario'=>$usuario,
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
        $pdf->SetTitle('Planilla');
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
     * @Route("/record", name="comparendo_record")
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

            $trazabilidades = $em->getRepository('JHWEBContravencionalBundle:CvCdoTrazabilidad')->findBy(
                array(
                    'comparendo' => $params->id
                ),
                array(
                    'fecha' => 'DESC'
                )
            );
            
            if ($trazabilidades) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($trazabilidades)." Documentos registrados.", 
                    'data'=> $trazabilidades,
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
     * @Route("/search/agente", name="comparendo_search_agente")
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

            if($params->sedeOperativaId) {
                $nombreSedeOperativa = $em->getRepository('AppBundle:SedeOperativa')->find($params->sedeOperativaId);
            }

            $comparendos = $em->getRepository('AppBundle:Comparendo')->getByAgente($params);

            if ($comparendos) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Comparendos encontrados satisfactoriamente.", 
                    'data' => $comparendos,
                    'nombreSedeOperativa' => $nombreSedeOperativa->getNombre(),
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
                    'msj' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($response);
    }

}
