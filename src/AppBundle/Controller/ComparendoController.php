<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comparendo;
use AppBundle\Entity\Inmovilizacion;
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

            $comparendo->setFecha(new \DateTime($params->comparendo->fecha));
            $comparendo->setHora(new \DateTime($params->comparendo->hora));
            $comparendo->setDireccion($params->comparendo->direccion);
            $comparendo->setLocalidad($params->comparendo->localidad);
            $comparendo->setInmovilizacion($params->comparendo->inmovilizacion);
            $comparendo->setFuga($params->comparendo->fuga);
            $comparendo->setAccidente($params->comparendo->accidente);
            $comparendo->setRetencionLicencia($params->comparendo->retencionLicencia);
            $comparendo->setFotomulta($params->comparendo->fotomulta);
            $comparendo->setGradoAlchohol($params->comparendo->gradoAlchoholemia);
            $comparendo->setObservacionesDigitador($params->comparendo->observacionesDigitador);
            $comparendo->setObservacionesAgente($params->comparendo->observacionesAgente);
            $comparendo->setValorAdicional($params->comparendo->infraccionValorAdicional);

            if (isset($params->fechaNotificacion)) {
                $comparendo->setFechaNotificacion(new \DateTime($params->fechaNotificacion));
            }
            //$comparendo->setUrlDocumento($urlDocumento);

            $agenteTransito = $em->getRepository('AppBundle:MpersonalFuncionario')->find(
                $params->comparendo->funcionarioId
            );
            $comparendo->setAgenteTransito($agenteTransito);

            $consecutivo = $em->getRepository('AppBundle:MpersonalComparendo')->find(
                $params->comparendo->consecutivoId
            );
            $comparendo->setConsecutivo($consecutivo);

            $municipio = $em->getRepository('AppBundle:Municipio')->find(
                $params->comparendo->municipioId
            );
            $comparendo->setMunicipio($municipio);

            $vehiculo = $em->getRepository('AppBundle:Vehiculo')->find(
                $params->comparendo->vehiculoId
            );
            $comparendo->setVehiculo($vehiculo);

            $estado = $helpers->comparendoState($params);
            $comparendo->setEstado($estado);

            if (isset( $params->comparendo->tipoInfractorId)) {
                $tipoInfractor = $em->getRepository('AppBundle:CfgTipoInfractor')->find(
                    $params->comparendo->tipoInfractorId
                );
                $comparendo->setTipoInfractor($tipoInfractor);
            }

            if (isset($params->comparendo->testigoId)) {
                $testigo = $em->getRepository('AppBundle:Ciudadano')->find(
                    $params->comparendo->testigoId
                );
                $comparendo->setCuidadanoTestigo($testigo);
            }

            $infraccion = $em->getRepository('AppBundle:MflInfraccion')->find(
                $params->comparendo->infraccionId
            );
            $comparendo->setInfraccion($infraccion);

            //Calcula valor de infracción
            $smlmv = $em->getRepository('AppBundle:CfgSmlmv')->findOneByActivo(
                true
            );

            $valorInfraccion = round(($smlmv->getValor() / 30) * $infraccion->getCategoria()->getSmldv());
            $comparendo->setValorInfraccion($valorInfraccion);

            $em->persist($comparendo);
            $em->flush();

            if ($params->comparendo->inmovilizacion) {
                $inmovilizacion = new Inmovilizacion();

                $inmovilizacion->setNumero(123);
                $inmovilizacion->setConsecutivo(0);
                $inmovilizacion->setFecha(new \Datetime($params->comparendo->fecha));

                $grua = $em->getRepository('AppBundle:MparqGrua')->find(
                    $params->inmovilizacion->gruaId
                );
                $inmovilizacion->setGrua($grua);

                $patio = $em->getRepository('AppBundle:MparqPatio')->find(
                    $params->inmovilizacion->patioId
                );
                $inmovilizacion->setPatio($patio);
                $inmovilizacion->setComparendo($comparendo);

                $em->persist($inmovilizacion);
                $em->flush();
            }

            if ($consecutivo) {
                $consecutivo->setEstado('Utilizado');
                $consecutivo->setActivo(false);
                $em->flush();
            }

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con exito",
            );
            //}
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

            if ($comparendo != null) {
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
     * @Route("/ciudadano/search", name="ciudadano_infractor_comparendo_search")
     * @Method({"GET", "POST"})
     */
    public function searchByCiudadanoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);
            
            $em = $this->getDoctrine()->getManager();

            $comparendos = $em->getRepository('AppBundle:Comparendo')->getByCiudadanoInfractor($params->ciudadanoId);

            if ($comparendos != null) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "El ciudadano tiene ".count($comparendos)." comparendos",
                    'data' => $comparendos,
                );
            } else {
                $response = array(
                    'status' => 'success',
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
                    'msj' => "Lista de Comparendos", 
                    'data' => $comparendos,
            );
            }else{
                 $response = array(
                    'status' => 'success',
                    'code' => 400,
                    'msj' => "No existe comparendos para esos parametros de busqueda", 
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

        $response = array(
            'status' => 'success',
            'code' => 200,
            'msj' => "lista de comparendos",
            'data' => $comparendos,
        );
        return $helpers->json($response);
    }
}
