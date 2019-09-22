<?php

namespace JHWEB\ContravencionalBundle\Controller;

use JHWEB\ContravencionalBundle\Entity\CvCdoComparendo;
use JHWEB\ContravencionalBundle\Entity\CvCdoTrazabilidad;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use JHWEB\PersonalBundle\Entity\PnalCfgCdoConsecutivo;

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

            if (isset($params->comparendo->idOrganismoTransitoMatriculado) && $params->comparendo->idOrganismoTransitoMatriculado) {
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
                $comparendo->setClase($clase);
            }

            if (isset($params->comparendo->vehiculoServicio)) {
                $servicio = $em->getRepository('JHWEBVehiculoBundle:VhloCfgServicio')->find(
                    $params->comparendo->vehiculoServicio
                );
                $comparendo->setServicio($servicio);
            }

            if (isset($params->comparendo->vehiculoRadioAccion)) {
                $radioAccion = $em->getRepository('JHWEBVehiculoBundle:VhloCfgRadioAccion')->find(
                    $params->comparendo->vehiculoRadioAccion
                );
                $comparendo->setRadioAccion($radioAccion);
            }

            if (isset($params->comparendo->vehiculoModalidadTransporte)) {
                $modalidadTransporte = $em->getRepository('JHWEBVehiculoBundle:VhloCfgModalidadTransporte')->find(
                    $params->comparendo->vehiculoModalidadTransporte
                );
                $comparendo->setModalidadTransporte($modalidadTransporte);
            }

            if (isset($params->comparendo->vehiculoTransportePasajero)) {
                $transportePasajero = $em->getRepository('JHWEBVehiculoBundle:VhloCfgTransportePasajero')->find(
                    $params->comparendo->vehiculoTransportePasajero
                );
                $comparendo->setTransportePasajero($transportePasajero);
            }

            if (isset($params->comparendo->vehiculoTransporteEspecial)) {
                $transporteEspecial = $em->getRepository('JHWEBVehiculoBundle:VhloCfgTransporteEspecial')->find(
                    $params->comparendo->vehiculoTransporteEspecial
                );
                $comparendo->setTransporteEspecial($transporteEspecial);
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
            if (isset($params->infractor->idTipoIdentificacion) && $params->infractor->idTipoIdentificacion) {
                $tipoIdentificacion = $em->getRepository('JHWEBUsuarioBundle:UserCfgTipoIdentificacion')->find(
                    $params->infractor->idTipoIdentificacion
                );
                $comparendo->setInfractorTipoIdentificacion(
                    $tipoIdentificacion
                );
            }

            if (isset($params->infractor->idCategoriaLicenciaConduccion) && $params->infractor->idCategoriaLicenciaConduccion) {
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

            if (isset($params->comparendo->idOrganismoTransitoLicencia) && $params->comparendo->idOrganismoTransitoLicencia) {
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
            if (isset($params->propietario->idTipoIdentificacion) && $params->propietario->idTipoIdentificacion) {
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

            if (isset($params->comparendo->gradoAlcoholemia) && $params->comparendo->gradoAlcoholemia) {
                $comparendo->setGradoAlcoholemia($params->comparendo->gradoAlcoholemia);
            }

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
                    'data' => $comparendo,
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
     * @Route("/upload", name="cvcdocomparendo_upload")
     * @Method("POST")
     */
    public function uploadAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);
            
            $em = $this->getDoctrine()->getManager();
            $file = $request->files->get('file');

            if ($file->guessExtension() == 'txt') {
                    $documentoName = md5(uniqid()).$file->guessExtension();
                $file->move(
                    $this->getParameter('data_upload'),
                    $documentoName
                ); 

                $archivo = fopen($this->getParameter('data_upload').$documentoName , "r" );

                $batchSize = 100;
                $arrayComparendos = null;
                $transacciones = null;
                $procesados = 0;
                $errores = 0;
                $rows = 0;
                $cols = 0;

                if ($params->tipoFuente == 1) {
                    $length = 59;
                }elseif ($params->tipoFuente == 2) {
                    $length = 57;
                }

                if($params->idOrganismoTransito) {
                    $organismoTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find($params->idOrganismoTransito);
                }

                if ($archivo) {
                    //Leo cada linea del archivo hasta un maximo de caracteres (0 sin limite)
                    while ($datos = fgets($archivo))
                    {
                        $datos = explode(",",$datos);
                        $cols = count($datos);

                        if ($cols == $length) {
                            $datos = array_map("utf8_encode", $datos);
        
                            $arrayComparendos[] = array(
                                'consecutivo'=>$datos[1],
                                'fecha'=>$helpers->convertDateTime($datos[2]),
                                'hora'=>$datos[3],
                                'direccion'=>$datos[4],
                                'localidad'=>$datos[6],
                                'placa'=>$datos[7],
                                'identificacion'=>$datos[14],
                                'idTipoIdentificacion'=>$datos[15],
                                'nombres'=>$datos[16],
                                'apellidos'=>$datos[17],
                                'codigoInfraccion' => $datos[55],
                                'valor'=>$datos[56],
                                'organismoTransito'=>$organismoTransito,
                                'tipoFuente'=>$params->tipoFuente,
                            );
                            
                            if ((count($arrayComparendos) % $batchSize) == 0 && $arrayComparendos != null) {
                                $transacciones[] =  $this->insertBatch($arrayComparendos, $rows);
                                $arrayComparendos = null;
                            }
                        }else{
                            $fila = $rows + 1;
                            $registros[] = array(
                                    'title' => 'Atencion!',
                                    'status' => 'warning',
                                    'code' => 400,
                                    'message' => "Error! Fila:(".$fila.") No cumple con la longitud del formato estandar.",
                            );
                            
                            $transacciones[] = array(
                                'errores' => 1,
                                'registros' => $registros,
                            );
                        }

                        $rows++;
                    }

                    fclose($archivo);

                    if ($arrayComparendos) {
                        $transacciones[] =  $this->insertBatch($arrayComparendos, $rows);
                    }

                    $response = array(
                        'title' => 'Perfecto!',
                        'status' => 'success',
                        'code' => 200,
                        'message' => 'Se han procesado '.$rows.' líneas.', 
                        'data' => $transacciones,
                    );
                }else{
                    $response = array(
                        'title' => 'Atención!',
                        'status' => 'warning',
                        'code' => 400,
                        'message' => "No se pudo leer el archivo.", 
                    );
                }
            } else {
                $response = array(
                    'title' => 'Atención!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => "El formato del archivo no corresponde a .txt.", 
                );
            }            
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
            );
        } 
        
        return $helpers->json($response);
    }

    public function insertBatch($arrayComparendos, $rows){
        $helpers = $this->get("app.helpers");

        $arrayProcesos = null;
        $procesados = 0;
        $errores = 0;
        $fila = 0;

        foreach ($arrayComparendos as $key => $arrayComparendo) {
            $fila = $rows - count($arrayComparendos) + $key + 1;

            $em = $this->getDoctrine()->getManager();

            //Busca si ya existe el numero consecutivo
            $consecutivo = $em->getRepository('JHWEBPersonalBundle:PnalCfgCdoConsecutivo')->findOneBy(
                array(
                    'numero' => $arrayComparendo['consecutivo'],
                )
            );

            //Analiza el tipo de fuente que desea cargar 1 = STTDN o 2 = POLCA
            if ($arrayComparendo['tipoFuente'] == 1) {
                //Si la fuente es STTDN el consecutivo debe estar previamente asignado a la sede
                if($consecutivo){
                    if ($consecutivo->getEstado() == 'ASIGNADO') {
                        $comparendo->setConsecutivo($consecutivo);
                        $consecutivo->setEstado('UTILIZADO');
                        $consecutivo->setActivo(false);
                        $em->flush();

                        $response = $this->register($arrayComparedndo, $consecutivo);
                    } else {
                        $response = array(
                            'title' => 'Atención!',
                            'status' => 'warning',
                            'code' => 400,
                            'message' => "Error! Fila:(".$fila.") El consecutivo se encuentra en estado ".$consecutivo->getEstado()." y no puede ser utilizado para este registro.",
                        );    
                    }
                }else{
                    $response = array(
                        'title' => 'Atención!',
                        'status' => 'warning',
                        'code' => 400,
                        'message' => "Error! Fila:(".$fila.") El número consecutivo aún no se encuentra registrado en el sistema.",
                    ); 
                }
            }elseif ($arrayComparendo['tipoFuente'] == 2) {
                if($consecutivo){
                    if ($consecutivo->getEstado() == 'ASIGNADO') {
                        $comparendo->setConsecutivo($consecutivo);
                        $consecutivo->setEstado('UTILIZADO');
                        $consecutivo->setActivo(false);
                        $em->flush();

                        $response = $this->register($arrayComparendo, $consecutivo);
                    } else {
                        $response = array(
                            'title' => 'Atención!',
                            'status' => 'warning',
                            'code' => 400,
                            'message' => "Error! Fila:(".$fila.") El consecutivo se encuentra en estado ".$consecutivo->getEstado()." y no puede ser utilizado para este registro.",
                        );    
                    }
                }else{
                    $consecutivo = new PnalCfgCdoConsecutivo();

                    $consecutivo->setNumero($arrayComparendo['consecutivo']);
                    $consecutivo->setFechaAsignacion(new \Datetime(date('Y-m-d')));
                    $consecutivo->setEstado('UTILIZADO');
                    $consecutivo->setActivo(false);
                    $consecutivo->setOrganismoTransito($arrayComparendo['organismoTransito']);

                    $em->persist($consecutivo);
                    $em->flush();

                    $response = $this->register($arrayComparendo, $consecutivo);
                }
            }

            if ($response['code'] == 200) {
                $procesados++;
            } else {
                $errores++;
            }
            $arrayProcesos[] = $response;
        }

        $em->flush();

        return array(
            'registros'=>$arrayProcesos, 
            'procesados'=>$procesados, 
            'errores'=>$errores
        );
    }

    /*
     * Realiza el registro del talonario y la secuencia de consecutivos según el rango solicitado
    */
    public function register($arrayComparendo, $consecutivo){
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $comparendo = new CvCdoComparendo();

        $comparendo->setConsecutivo($consecutivo);

        if ($arrayComparendo['tipoFuente'] == 1) {
            $length = 59;
            $comparendo->setPolca(false);
        }elseif ($arrayComparendo['tipoFuente'] == 2) {
            $length = 57;
            $comparendo->setPolca(true);
        }

        if (isset($arrayComparendo['placa']) && $arrayComparendo['placa'] != '') {
            $comparendo->setPlaca($arrayComparendo['placa']);
        }

        $comparendo->setFecha($arrayComparendo['fecha']);
        $hora = substr($arrayComparendo['hora'], 0, 2).':'.substr($arrayComparendo['hora'], 2, 2).':00';
        $comparendo->setHora(new \DateTime($hora));        
        $comparendo->setDireccion($arrayComparendo['direccion']);
        $comparendo->setLocalidad($arrayComparendo['localidad']);

        $comparendo->setObservacionesAgente(
            $params->comparendo->observacionesAgente
        );

        /* INFRACTOR */
        if ($arrayComparendo['idTipoIdentificacion']) {
            $tipoIdentificacion = $em->getRepository('JHWEBUsuarioBundle:UserCfgTipoIdentificacion')->find(
                $arrayComparendo['idTipoIdentificacion']
            );
            $comparendo->setInfractorTipoIdentificacion(
                $tipoIdentificacion
            );
        }

        $comparendo->setInfractorIdentificacion(
            $arrayComparendo['identificacion']
        );

        $comparendo->setInfractorNombres(
            $arrayComparendo['nombres'].' '.$arrayComparendo['apellidos']
        );

        $comparendo->setPagado(false);
        $comparendo->setCurso(false);
        $comparendo->setAudiencia(false);
        $comparendo->setRecurso(false);
        $comparendo->setNotificado(false);
        $comparendo->setPorcentajeDescuento(0);

        $estado = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->find(
            1
        );
        $comparendo->setEstado($estado);
        $comparendo->setActivo(true);

        /* INFRACCION */
        if ($arrayComparendo['codigoInfraccion'] != 'F') {
            $infraccion = $em->getRepository('JHWEBFinancieroBundle:FroInfraccion')->findOneByCodigo(
                $arrayComparendo['codigoInfraccion']
            );
        } else {
            $infraccion = $em->getRepository('JHWEBFinancieroBundle:FroInfraccion')->findOneByCategoria(
                5
            );
        }

        if ($infraccion) {
            $comparendo->setInfraccion($infraccion);
            
            //Calcula valor de infracción
            $smlmv = $em->getRepository('JHWEBConfigBundle:CfgSmlmv')->findOneByActivo(
                true
            );
    
            if ($smlmv) {
                $valorInfraccion = round(($smlmv->getValor() / 30) * $infraccion->getCategoria()->getSmldv());
    
                $comparendo->setValorInfraccion($valorInfraccion);
            }else{
                $response = array(
                    'title' => 'Atención!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => "Error! Fila:(".$key++.") No se puede registrar el valor de la infraccipon porque aún no se ha configurado el SMLMV.",
                );

                return $helpers->json($response);
            }
        }
        
        $em->persist($comparendo);

        $trazabilidad = new CvCdoTrazabilidad();

        $trazabilidad->setFecha(
            $comparendo->getFecha()
        );
        $trazabilidad->setHora(
            new \DateTime(date('h:i:s'))
        );
        $trazabilidad->setActivo(true); 
        $trazabilidad->setComparendo($comparendo);
        $estado = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->find(1);
        $trazabilidad->setEstado($estado);

        $em->persist($trazabilidad);

        $response = array(
            'title' => 'Perfecto!',
            'status' => 'success',
            'code' => 200,
            'message' => "Perfecto! Fila:(".$key++.") Registro creado con exito.",
        );

        $em->flush();

        return $response;
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
                $diasHabiles = $helpers->getDiasHabiles($comparendo->getFecha()->format('d/m/Y'));

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
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Comparendo encontrado satisfactoriamente.", 
                    'data' => $comparendo,
                );
            }else{
                 $response = array(
                    'title' => 'Atención!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => "No existe ningún comparendo con el número que desea buscar.", 
                );
            }
        }else{
            $response = array(
                'title' => 'Error!',
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
     * @Route("/{idUsuario}/pazysalvo/pdf", name="cvcdocomparendo_pazysalvo_pdf")
     * @Method({"GET", "POST"})
     */
    public function pdfPazSalvoAction(Request $request, $idUsuario)
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
     * Crea PDF con resumen de comparendo .
     *
     * @Route("/{id}/pdf", name="cvcdocomparendo_pdf")
     * @Method({"GET", "POST"})
     */
    public function pdfAction(Request $request, $id)
    {
        setlocale(LC_ALL,"es_ES");
        $fechaActual = strftime("%d de %B del %Y");

        $em = $this->getDoctrine()->getManager();

        $comparendo = $em->getRepository('JHWEBContravencionalBundle:CvCdoComparendo')->find(
            $id
        );
        
        $html = $this->renderView('@JHWEBContravencional/Default/pdf.comparendo.html.twig', array(
            'fechaActual' => $fechaActual,
            'comparendo'=> $comparendo,
        ));

        $this->get('app.pdf')->templatePreview($html, 'Comparendo_'.$comparendo->getConsecutivo()->getNumero());
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

    /**
     * Crear archivo plano según filtros.
     *
     * @Route("/create/file", name="cvcdocomparendo_create_file")
     * @Method({"GET", "POST"})
     */
    public function createFileAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);
            
            $em = $this->getDoctrine()->getManager();
            
            $fechaInicial = new \Datetime($params->fechaInicial);
            $fechaFinal = new \Datetime($params->fechaFinal);
            
            if($params->tipoReporte == 1) {
                $comparendos = $em->getRepository('JHWEBContravencionalBundle:CvCdoComparendo')->getByFechasForFile(
                    $params->idOrganismoTransito,
                    $fechaInicial,
                    $fechaFinal
                );

                $dir=__DIR__.'/../../../../web/docs/';
                $file = $dir."COMPARENDOS.DAT"; 

                if( file_exists("datos.txt") == false ){
                    $abrir = fopen($file,"r"); 
                }else{
                    $archivo = fopen($file, "w+b");    // Abrir el archivo, creándolo si no existe
                }
 
                if($archivo == false){
                    echo("Error al crear el archivo");
                }else{
                    foreach ($comparendos as $key => $comparendo) {
                        fwrite($archivo, str_pad($comparendo->getConsecutivo()->getNumero(), 20, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad($comparendo->getFecha()->format('d/m/Y'), 10, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad($comparendo->getHora()->format('hhmm'), 4, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad($comparendo->getDireccion(), 80, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad($comparendo->getMunicipio()->getCodigoDane(), 8, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad($comparendo->getLocalidad(), 30, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad($comparendo->getPlaca(), 6, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad($comparendo->getOrganismoTransitoMatriculado()->getDivipo(), 8, ' ', STR_PAD_RIGHT));
                        if($comparendo->getClase()) {
                            fwrite($archivo, str_pad($comparendo->getClase()->getCodigo(), 2, ' ', STR_PAD_RIGHT));
                        } elseif($comparendo->getClase() == null) {
                            fwrite($archivo, str_pad("", 2, ' ', STR_PAD_RIGHT));
                        }
                        if($comparendo->getServicio()) {
                            fwrite($archivo, str_pad($comparendo->getServicio()->getCodigo(), 1, ' ', STR_PAD_RIGHT));
                        } elseif($comparendo->getServicio() == null) {
                            fwrite($archivo, str_pad("", 2, ' ', STR_PAD_RIGHT));
                        }
                        if($comparendo->getRadioAccion()) {
                            fwrite($archivo, str_pad($comparendo->getRadioAccion()->getCodigo(), 1, ' ', STR_PAD_RIGHT));
                        } elseif($comparendo->getRadioAccion() == null) {
                            fwrite($archivo, str_pad("", 2, ' ', STR_PAD_RIGHT));
                        }
                        if($comparendo->getModalidadTransporte()) {
                            fwrite($archivo, str_pad($comparendo->getModalidadTransporte()->getId(), 1, ' ', STR_PAD_RIGHT));
                        } elseif($comparendo->getModalidadTransporte() == null) {
                            fwrite($archivo, str_pad("", 2, ' ', STR_PAD_RIGHT));
                        }
                        if($comparendo->getTransportePasajero()) {
                            fwrite($archivo, str_pad($comparendo->getTransportePasajero()->getId(), 1, ' ', STR_PAD_RIGHT));
                        } elseif($comparendo->getTransportePasajero() == null) {
                            fwrite($archivo, str_pad("", 2, ' ', STR_PAD_RIGHT));
                        }
                        fwrite($archivo, str_pad($comparendo->getInfractorIdentificacion(), 15, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad($comparendo->getInfractorTipoIdentificacion()->getCodigo(), 1, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad($comparendo->getInfractorNombres(), 18, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad($comparendo->getInfractorApellidos(), 20, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad($comparendo->getInfractorDireccion(), 40, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad($comparendo->getInfractorEmail(), 40, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad($comparendo->getInfractorTelefono(), 15, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad($comparendo->getInfractorMunicipioResidencia(), 8, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad($comparendo->getInfractorNumeroLicenciaConduccion(), 14, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad($comparendo->getCategoria(), 2, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad($comparendo->getOrganismoTransitoMatriculado()->getDivipo(), 8, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad($comparendo->getFechaVencimiento()->format('d/m/Y'), 10, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad($comparendo->getTipoInfractor()->getId(), 1, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad($comparendo->getNumeroLicenciaTransito(), 16, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad($comparendo->getOrganismoTransitoMatriculado()->getDivipo(), 8, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad($comparendo->getPropietarioIdentificacion(), 15, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad($comparendo->getPropietarioTipoIdentificacion()->getCodigo(), 1, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad($comparendo->getPropietarioNombre() . " " . $comparendo->getPropietarioApellidos(), 50, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad($comparendo->getEmpresaNombre(), 30, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad($comparendo->getEmpresaNit(), 15, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad($comparendo->getTarjetaOperacion(), 10, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad($comparendo->getAgenteTransito()->getNumeroPlaca(), 10, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad($comparendo->getObservacionesAgente(), 50, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad($comparendo->getFuga(), 1, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad($comparendo->getAccidente(), 1, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad("", 1, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad("", 1, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad("", 1, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad($comparendo->getTestigoIdentificacion(), 15, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad($comparendo->getTestigoNombres() . " " . $comparendo->getTestigoApellidos(), 50, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad($comparendo->getTestigoDireccion(), 40, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad($comparendo->getTestigoTelefono(), 15, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad($comparendo->getValorPagar(), 8, ' ', STR_PAD_RIGHT));
                        /* fwrite($archivo, str_pad($comparendo->getValorAdicional(), 8, ' ', STR_PAD_RIGHT)); */
                        fwrite($archivo, str_pad("", 8, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad($comparendo->getOrganismoTransito()->getDivipo(), 1, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad($comparendo->getEstado()->getCodigo(), 1, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad($comparendo->getPolca(), 1, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad($comparendo->getInfraccion()->getId(), 5, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad($comparendo->getValorInfraccion(), 8, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad("N", 1, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad("", 10, ' ', STR_PAD_RIGHT));
                        fwrite($archivo, str_pad($comparendo->getGradoAlcoholemia(), 8, ' ', STR_PAD_RIGHT). "\r\n");
                    }
                    fflush($archivo);
                }

                fclose($archivo);   // Cerrar el archivo

                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Archivo generado",
                    'data' => "COMPARENDOS.DAT"
                );
            } elseif($params->tipoReporte == 2){
                
            
            } elseif($params->tipoReporte == 3){
                
            }
            else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'No hay registros para los filtros estipulados.', 
                );
            }            
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
}
