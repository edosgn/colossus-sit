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

            $fecha = new \DateTime($params->comparendo->fecha);

            $expedienteConsecutivo = $em->getRepository('JHWEBContravencionalBundle:CvCdoComparendo')->getMaximo(
                $fecha->format('Y')
            );
            $expedienteConsecutivo = (empty($expedienteConsecutivo['maximo']) ? 1 : $expedienteConsecutivo['maximo']+=1);
            $comparendo->setExpedienteConsecutivo($expedienteConsecutivo);

            $comparendo->setExpedienteNumero($fecha->format('Y').'-'.str_pad($expedienteConsecutivo, 3, '0', STR_PAD_LEFT));

            $comparendo->setFecha($fecha);
            $hora = $params->comparendo->hora;
            $minutos = $params->comparendo->minutos;
            
            $comparendo->setHora(new \DateTime($hora.':'.$minutos.':00'));
            
            $comparendo->setDireccion($params->comparendo->direccion);
            $comparendo->setLocalidad($params->comparendo->localidad);

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
            $comparendo->setValorAdicional(0);

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

            if ($params->infractor->identificacion) {
                $comparendo->setInfractorIdentificacion(
                    $params->infractor->identificacion
                );

                //Buscar si el infractor es reincidente en los ultimos 6 meses
                $comparendosOld = $em->getRepository('JHWEBContravencionalBundle:CvCdoComparendo')->getReincidenciasByMonths(
                    $params->infractor->idCategoriaLicenciaConduccion,
                    $comparendo->getFecha(),
                    6
                );
            }

            if (isset($comparendosOld) && $comparendosOld) {
                $comparendo->setReincidencia(true);
            } else {
                $comparendo->setReincidencia(false);
            }

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

                if ($comparendo->getReincidencia()) {
                    $response = array(
                        'title' => 'Perfecto!',
                        'status' => 'success',
                        'code' => 200,
                        'message' => "Registro creado con éxito, el infractor es reincidente.",
                        'data' => $comparendo,
                    );
                } else {
                    $response = array(
                        'title' => 'Perfecto!',
                        'status' => 'success',
                        'code' => 200,
                        'message' => "Registro creado con éxito",
                        'data' => $comparendo,
                    );
                }
                
                
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
                    'message' => "Registro encontrado con éxito",
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

                $batchSize = 500;
                $arrayComparendos = null;
                $transacciones = null;
                $procesados = 0;
                $errores = 0;
                $rows = 0;
                $cols = 0;

                //Longitud de columnas según el tipo de fuente: 1-STTDN, 2-POLCA, 3 SIMIT
                if ($params->tipoFuente == 1) {
                    $length = 59;
                }elseif ($params->tipoFuente == 2) {
                    $length = 57;
                }elseif ($params->tipoFuente == 3) {
                    $length = 63;
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
                                'divipoDireccion'=>$datos[5],
                                'localidad'=>$datos[6],
                                'placa'=>$datos[7],
                                'divipoMatriculado'=>$datos[8],
                                'vehiculoClase'=>$datos[9],
                                'vehiculoServicio'=>$datos[10],
                                'vehiculoRadioAccion'=>$datos[11],
                                'vehiculoModalidaTransporte'=>$datos[12],
                                'vehiculoTransportePasajeros'=>$datos[13],
                                'identificacion'=>$datos[14],
                                'idTipoIdentificacion'=>$datos[15],
                                'nombres'=>$datos[16],
                                'apellidos'=>$datos[17],
                                'infractorEdad'=>$datos[18],
                                'infractorDireccion'=>$datos[19],
                                'infractorCorreo'=>$datos[20],
                                'infractorTelefono'=>$datos[21],
                                'infractorDivipoResidencia'=>$datos[22],
                                'licenciaConduccionNumero'=>$datos[23],
                                'licenciaConduccionCategoria'=>$datos[24],
                                'licenciaConduccionDivipo'=>$datos[25],
                                'licenciaConduccionFechaVencimiento'=>$datos[26],
                                'tipoInfractor'=>$datos[27],
                                'licenciaTransitoNumero'=>$datos[28],
                                'licenciaTransitoDivipo'=>$datos[29],
                                'infraccionCodigo' => $datos[55],
                                'infraccionValor'=>$datos[56],
                                'gradoAlcoholemia'=>$datos[57],
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

                        $response = $this->register($arrayComparendo, $consecutivo, $fila);
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
            }elseif ($arrayComparendo['tipoFuente'] == 2 || $arrayComparendo['tipoFuente'] == 3) {
                if($consecutivo){
                    if ($consecutivo->getEstado() == 'ASIGNADO') {
                        $comparendo->setConsecutivo($consecutivo);
                        $consecutivo->setEstado('UTILIZADO');
                        $consecutivo->setActivo(false);

                        $response = $this->register($arrayComparendo, $consecutivo, $fila);
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

                    $response = $this->register($arrayComparendo, $consecutivo, $fila);
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
    public function register($arrayComparendo, $consecutivo, $fila){
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

        $fecha = $arrayComparendo['fecha'];
        $comparendo->setFecha($fecha);

        if($fila > 0){
            $comparendo->setExpedienteConsecutivo($fila);
            $comparendo->setExpedienteNumero($fecha->format('Y').'-'.str_pad($fila, 3, '0', STR_PAD_LEFT));
        }else{
            $expedienteConsecutivo = $em->getRepository('JHWEBContravencionalBundle:CvCdoComparendo')->getMaximo(
                $fecha->format('Y')
            );
            $expedienteConsecutivo = (empty($expedienteConsecutivo['maximo']) ? 1 : $expedienteConsecutivo['maximo']+=1);
            $comparendo->setExpedienteConsecutivo($expedienteConsecutivo);
            $comparendo->setExpedienteNumero($fecha->format('Y').'-'.str_pad($expedienteConsecutivo, 3, '0', STR_PAD_LEFT));
        }

        if (strlen($arrayComparendo['hora']) == 5){
            $hora = substr($arrayComparendo['hora'], 0, 2).substr($arrayComparendo['hora'], 2, 2).':00';
        }else{
            $hora = substr($arrayComparendo['hora'], 0, 1).substr($arrayComparendo['hora'], 2, 2).':00';
        }

        $comparendo->setHora(new \DateTime($hora));        
        $comparendo->setDireccion($arrayComparendo['direccion']);
        $comparendo->setLocalidad($arrayComparendo['localidad']);

        /*$comparendo->setObservacionesAgente(
            $params->comparendo->observacionesAgente
        );*/

        /* INFRACTOR */
        if ($arrayComparendo['idTipoIdentificacion']) {
            $tipoIdentificacion = $em->getRepository('JHWEBUsuarioBundle:UserCfgTipoIdentificacion')->find(
                $arrayComparendo['idTipoIdentificacion']
            );
            $comparendo->setInfractorTipoIdentificacion(
                $tipoIdentificacion
            );
        }
        
        if ($arrayComparendo['identificacion'] && $arrayComparendo['identificacion'] != '') {
            $comparendo->setInfractorIdentificacion(
                $arrayComparendo['identificacion']
            );

            //Buscar si el infractor es reincidente en los ultimos 6 meses
            $comparendosOld = $em->getRepository('JHWEBContravencionalBundle:CvCdoComparendo')->getReincidenciasByMonths(
                $arrayComparendo['identificacion'],
                $comparendo->getFecha(),
                6
            );

            if ($comparendosOld) {
                $comparendo->setReincidencia(true);
            } else {
                $comparendo->setReincidencia(false);
            }
        }

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
        if ($arrayComparendo['infraccionCodigo'] != 'F') {
            $infraccion = $em->getRepository('JHWEBFinancieroBundle:FroInfraccion')->findOneByCodigo(
                $arrayComparendo['infraccionCodigo']
            );
        } else {
            $infraccion = $em->getRepository('JHWEBFinancieroBundle:FroInfraccion')->findOneByCategoria(
                5
            );
            $comparendo->setGradoAlcoholemia($arrayComparendo['gradoAlcoholemia']);
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
                    'message' => "Error! Fila:(".$rows.") No se puede registrar el valor de la infracción porque aún no se ha configurado el SMLMV.",
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
            'message' => "Perfecto! Fila:(".$fila.") Registro creado con éxito.",
        );

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

            $organismoTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find($params->idOrganismoTransito);
            
            if($params->tipoReporte == 1) {
                $dir=__DIR__.'/../../../../web/docs/';
                $file = $dir. $organismoTransito->getDivipo() . 'comp.txt'; 
                
                if( file_exists($organismoTransito->getDivipo() . 'comp.txt') == false ){
                    $archivo = fopen($file, "w+b");    // Abrir el archivo, creándolo si no existe
                }else{
                    $archivo = fopen($file,"r"); 
                }
                
                if($archivo == false){
                    echo("Error al crear el archivo");
                }else{
                    $comparendos = $em->getRepository('JHWEBContravencionalBundle:CvCdoComparendo')->getByFechasForFile(
                        $params->idOrganismoTransito,
                        $fechaInicial,
                        $fechaFinal
                    );

                    $sumatoriaValorComparendo = 0;
                    $cont = 0;
                    foreach ($comparendos as $key => $comparendo) {
                        $sumatoriaValorComparendo += $comparendo->getValorPagar();
                        $cont ++;

                        fwrite($archivo, $key + 1 . ',');
                        if($comparendo->getConsecutivo() != null) {
                            fwrite($archivo, $comparendo->getConsecutivo()->getNumero() . ",");
                        } elseif ($comparendo->getConsecutivo() == null) {
                            fwrite($archivo, "" . ",");
                        }
                        fwrite($archivo, $comparendo->getFecha()->format('d/m/Y') . ",");
                        fwrite($archivo, $comparendo->getHora()->format('hm') . ",");
                        fwrite($archivo, substr($comparendo->getDireccion(),0,79) . ",");
                        if($comparendo->getMunicipio() != null) {
                            fwrite($archivo, $comparendo->getMunicipio()->getCodigoDane() . ",");
                        } elseif ($comparendo->getMunicipio() == null) {
                            fwrite($archivo, "" . ",");
                        }
                        fwrite($archivo, substr($comparendo->getLocalidad(),0,29) . ",");
                        fwrite($archivo, $comparendo->getPlaca() . ",");
                        if($comparendo->getOrganismoTransitoMatriculado() != null) {
                            fwrite($archivo, $comparendo->getOrganismoTransitoMatriculado()->getDivipo() . ",");
                        } else if($comparendo->getOrganismoTransitoMatriculado() == null) {
                            fwrite($archivo, "" . ",");
                        }
                        if($comparendo->getClase() != null) {
                            fwrite($archivo, str_pad($comparendo->getClase()->getCodigo(), 2, '0', STR_PAD_LEFT)  . ",");
                        } elseif($comparendo->getClase() == null) {
                            fwrite($archivo, "" . ",");
                        }
                        if($comparendo->getServicio()) {
                            fwrite($archivo, $comparendo->getServicio()->getCodigo() . ",");
                        } elseif($comparendo->getServicio() == null) {
                            fwrite($archivo, "" . ",");
                        }
                        if($comparendo->getRadioAccion()) {
                            fwrite($archivo, $comparendo->getRadioAccion()->getCodigo() . ",");
                        } elseif($comparendo->getRadioAccion() == null) {
                            fwrite($archivo, "" . ",");
                        }
                        if($comparendo->getModalidadTransporte()) {
                            fwrite($archivo, $comparendo->getModalidadTransporte()->getId() . ",");
                        } elseif($comparendo->getModalidadTransporte() == null) {
                            fwrite($archivo, "" . ",");
                        }
                        if($comparendo->getTransportePasajero()) {
                            fwrite($archivo, $comparendo->getTransportePasajero()->getId() . ",");
                        } elseif($comparendo->getTransportePasajero() == null) {
                            fwrite($archivo, "" . ",");
                        }
                        fwrite($archivo, $comparendo->getInfractorIdentificacion() . ",");
                        if($comparendo->getInfractorTipoIdentificacion() != null){
                            fwrite($archivo, $comparendo->getInfractorTipoIdentificacion()->getCodigo() . ",");
                        } elseif ($comparendo->getInfractorTipoIdentificacion() == null) {
                            fwrite($archivo, "" . ",");
                        }
                        fwrite($archivo, substr($comparendo->getInfractorNombres(),0,17) . ",");
                        fwrite($archivo, substr($comparendo->getInfractorApellidos(),0,19) . ",");

                        if ($comparendo->getInfractorFechaNacimiento()) {
                            $infractorEdad = $this->get("app.helpers")->calculateAge($comparendo->getInfractorFechaNacimiento()->format('Y/m/d'));
                            fwrite($archivo, substr($infractorEdad,0,1) . ",");
                        }else{
                            fwrite($archivo, ",");
                        }

                        fwrite($archivo, substr($comparendo->getInfractorDireccion(),0,39) . ",");
                        fwrite($archivo, substr($comparendo->getInfractorEmail(),0,39) . ",");
                        fwrite($archivo, substr($comparendo->getInfractorTelefono(),0,14) . ",");
                        fwrite($archivo, substr($comparendo->getInfractorMunicipioResidencia(),0,7) . ",");
                        fwrite($archivo, substr($comparendo->getInfractorNumeroLicenciaConduccion(),0,13) . ",");
                        fwrite($archivo, $comparendo->getCategoria() . ",");
                        if($comparendo->getOrganismoTransitoMatriculado() != null) {
                            fwrite($archivo, $comparendo->getOrganismoTransitoMatriculado()->getDivipo() . ",");
                        } elseif ($comparendo->getOrganismoTransitoMatriculado() == null) {
                            fwrite($archivo, "" . ",");
                        }
                        fwrite($archivo, $comparendo->getFechaVencimiento()->format('d/m/Y') . ",");
                        if($comparendo->getTipoInfractor() != null) {
                            fwrite($archivo, $comparendo->getTipoInfractor()->getId() . ",");
                        } else {
                            fwrite($archivo, "" . ",");
                        }                        
                        fwrite($archivo, substr($comparendo->getNumeroLicenciaTransito(),0,15) . ",");
                        if($comparendo->getOrganismoTransitoMatriculado() != null) {
                            fwrite($archivo, $comparendo->getOrganismoTransitoMatriculado()->getDivipo() . ",");
                        } elseif ($comparendo->getOrganismoTransitoMatriculado() == null) {
                            fwrite($archivo, "" . ",");
                        }
                        fwrite($archivo, substr($comparendo->getPropietarioIdentificacion(),0,14) . ",");
                        if($comparendo->getPropietarioTipoIdentificacion() != null) {
                            fwrite($archivo, $comparendo->getPropietarioTipoIdentificacion()->getCodigo() . ",");
                        } elseif($comparendo->getPropietarioTipoIdentificacion() == null) {
                            fwrite($archivo, "" . ",");
                        }
                        fwrite($archivo, substr($comparendo->getPropietarioNombre() . " " . $comparendo->getPropietarioApellidos(),0,49) . ",");
                        fwrite($archivo, substr($comparendo->getEmpresaNombre(),0,29) . ",");
                        fwrite($archivo, substr($comparendo->getEmpresaNit(),0,14) . ",");
                        fwrite($archivo, substr($comparendo->getTarjetaOperacion(),0,9) . ",");
                        if($comparendo->getAgenteTransito() != null){
                            fwrite($archivo, substr($comparendo->getAgenteTransito()->getNumeroPlaca(),0,9) . ",");
                        } elseif ($comparendo->getAgenteTransito() == null) {
                            fwrite($archivo, "" . ",");
                        }
                        fwrite($archivo, substr($comparendo->getObservacionesAgente(),0,49) . ",");
                        fwrite($archivo, $comparendo->getFuga() . ",");
                        fwrite($archivo, $comparendo->getAccidente() . ",");

                        $inmovilizacion = $em->getRepository('JHWEBParqueaderoBundle:PqoInmovilizacion')->findOneBy(
                            array(
                                'numeroComparendo' => $comparendo->getConsecutivo()->getNumero()
                            )
                        );

                        if($comparendo->getInfraccion()->getCategoria()->getNombre() == 'F') {
                            fwrite($archivo, 'S' . "," );
                        } elseif($comparendo->getInfraccion()->getCategoria()->getNombre() != 'F') {
                            if($inmovilizacion) {
                                /* fwrite($archivo, 'S' . "," );
                                fwrite($archivo, substr($inmovilizacion->getPatio()->getDireccion(),0,30) . "," ); */
                                //datos para revision 
                                fwrite($archivo, 'N' . "," );
                                fwrite($archivo, substr($inmovilizacion->getPatio()->getNombre(),0,29) . "," );
                                fwrite($archivo, substr($inmovilizacion->getPatio()->getDireccion(),0,29) . "," );
                                //fin datos de la revision
                                if($inmovilizacion->getGrua()) {
                                    fwrite($archivo, substr($inmovilizacion->getGrua()->getCodigo(),0,9) . "," );
                                    fwrite($archivo, substr($inmovilizacion->getGrua()->getPlaca(),0,5) . "," );
                                } else {
                                    fwrite($archivo, "" . "," );
                                    fwrite($archivo, "" . "," );
                                }
                                fwrite($archivo, substr($inmovilizacion->getNumeroInventario(),0,14) . "," );
                            } else {
                                fwrite($archivo, "" . "," );
                                fwrite($archivo, "" . "," );
                                fwrite($archivo, "" . "," );
                                fwrite($archivo, "" . "," );
                                fwrite($archivo, "" . "," );
                            }
                        }
                        fwrite($archivo, substr($comparendo->getTestigoIdentificacion(),0,14) . ",");
                        fwrite($archivo, substr($comparendo->getTestigoNombres() . " " . $comparendo->getTestigoApellidos(),0,49) . ",");
                        fwrite($archivo, substr($comparendo->getTestigoDireccion(),0,39) . ",");
                        fwrite($archivo, substr($comparendo->getTestigoTelefono(),0,14) . ",");
                        fwrite($archivo, substr($comparendo->getValorPagar(),0,7) . ",");
                        if($comparendo->getValorAdicional() != null) {
                            fwrite($archivo, substr($comparendo->getValorAdicional(),0,7) . ",");
                        } elseif ($comparendo->getValorAdicional() == null) {
                            fwrite($archivo, "0" . ",");
                        }
                        if($comparendo->getOrganismoTransito() != null) {
                            fwrite($archivo, $comparendo->getOrganismoTransito()->getDivipo() . ",");
                        } elseif ($comparendo->getOrganismoTransito() == null) {
                            fwrite($archivo, "" . ",");
                        }
                        if($comparendo->getEstado() != null) {
                            fwrite($archivo, $comparendo->getEstado()->getCodigo() . ",");
                        } elseif ($comparendo->getEstado() == null) {
                            fwrite($archivo, "" . ",");
                        }
                        if($comparendo->getPolca() == 1) {
                            fwrite($archivo, "S" . ",");
                        } elseif ($comparendo->getPolca() == 0) {
                            fwrite($archivo, "N" . ",");
                        }
                        if($comparendo->getInfraccion() != null){
                            fwrite($archivo, substr($comparendo->getInfraccion()->getCodigo(),0,4) . ",");
                        } elseif ($comparendo->getInfraccion() == null) {
                            fwrite($archivo, "" . ",");
                        }
                        fwrite($archivo, substr($comparendo->getValorInfraccion(),0,7) . ",");
                        fwrite($archivo, "N" . ",");
                        fwrite($archivo, "" . ",");
                        fwrite($archivo, substr($comparendo->getGradoAlcoholemia(),0,7) . ",". "\r\n");
                    }
                    
                    fwrite($archivo, $cont . ",");
                    fwrite($archivo, $sumatoriaValorComparendo . ",");
                    fwrite($archivo, "0" . ",");
                    fwrite($archivo, "0" .  "\r\n");

                    fflush($archivo);
                }

                fclose($archivo);   // Cerrar el archivo

                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Archivo generado",
                    'data' => $organismoTransito->getDivipo() . 'comp.txt'
                );
            } elseif($params->tipoReporte == 2){
                $dir=__DIR__.'/../../../../web/docs/';
                $file = $dir. $organismoTransito->getDivipo() . 'resol.txt'; 
                
                if( file_exists($organismoTransito->getDivipo() . 'resol.txt') == false ){
                    $archivo = fopen($file, "w+b");    // Abrir el archivo, creándolo si no existe
                }else{
                    $archivo = fopen($file,"r"); 
                }
                
                if($archivo == false){
                    echo("Error al crear el archivo");
                }else{
                    $resoluciones = $em->getRepository('JHWEBContravencionalBundle:CvCdoComparendo')->getResolucionesByFechasForFile(
                        $params->idOrganismoTransito,
                        $fechaInicial, 
                        $fechaFinal
                    );

                    $sumatoriaValorComparendo = 0;
                    $cont = 0;

                    foreach ($resoluciones as $key => $resolucion) {
                        $cont ++;
                        $sumatoriaValorComparendo += $resolucion->getComparendo()->getValorPagar();

                        fwrite($archivo, $key + 1 . ",");
                        fwrite($archivo, substr($resolucion->getActoAdministrativo()->getNumero(),0,14) . ",");
                        fwrite($archivo, "" . ",");
                        fwrite($archivo, $resolucion->getActoAdministrativo()->getFecha()->format('d/m/Y') . ",");
                        fwrite($archivo, $resolucion->getEstado()->getCodigo() . ",");
                        if($resolucion->getRestriccion() != null) {
                            fwrite($archivo, $resolucion->getRestriccion()->getFechaFin()->format('d/m/Y') . ",");
                        } elseif ($resolucion->getRestriccion() == null) {
                            fwrite($archivo, "" . ",");
                        }
                        if($resolucion->getComparendo()->getConsecutivo() != null) {
                            fwrite($archivo, $resolucion->getComparendo()->getConsecutivo()->getNumero() . ",");
                        } elseif ($resolucion->getComparendo()->getConsecutivo() == null) {
                            fwrite($archivo, "" . ",");
                        }
                        fwrite($archivo, $resolucion->getComparendo()->getFecha()->format('d/m/Y') . ",");
                        fwrite($archivo, substr($resolucion->getComparendo()->getInfractorIdentificacion(),0,14) . ",");
                        if($resolucion->getComparendo()->getInfractorTipoIdentificacion() != null) {
                            fwrite($archivo, $resolucion->getComparendo()->getInfractorTipoIdentificacion()->getCodigo() . ",");
                        } elseif ($resolucion->getComparendo()->getInfractorTipoIdentificacion() == null) {
                            fwrite($archivo, "" . ",");
                        }
                        fwrite($archivo, substr($resolucion->getComparendo()->getInfractorNombres(),0,17) . ",");
                        fwrite($archivo, substr($resolucion->getComparendo()->getInfractorApellidos(),0,19) . ",");
                        fwrite($archivo, substr($resolucion->getComparendo()->getInfractorDireccion(),0,39) . ",");
                        fwrite($archivo, substr($resolucion->getComparendo()->getInfractorTelefono(),0,14) . ",");
                        fwrite($archivo, $resolucion->getComparendo()->getInfractorMunicipioResidencia() . ",");
                        fwrite($archivo, substr($resolucion->getComparendo()->getValorPagar(),0,7) . ",");
                        fwrite($archivo, substr($resolucion->getComparendo()->getValorAdicional(),0,7) . ",");
                        /* fwrite($archivo, $resolucion->getComparendo()->getFotomulta() . ","); */
                        // eliminarlos luego
                        /* fwrite($archivo, "0" . ","); */
                        fwrite($archivo, "N" . ",");
                        //=============================================================================
                        if($resolucion->getComparendo()->getOrganismoTransito() != null) {
                            fwrite($archivo, $resolucion->getComparendo()->getOrganismoTransito()->getDivipo() . ",");
                        } elseif (condition) {
                            fwrite($archivo, "" . ",");
                        }
                        if($resolucion->getComparendo()->getPolca() == 0) {
                            fwrite($archivo, "N" . ",");
                        } elseif ($resolucion->getComparendo()->getPolca() == 1) {
                            fwrite($archivo, "S" . ",");
                        }
                        if($resolucion->getComparendo()->getInfraccion() != null) {
                            fwrite($archivo, substr($resolucion->getComparendo()->getInfraccion()->getId(),0,4) . ",");
                        } elseif ($resolucion->getComparendo()->getInfraccion() == null) {
                            fwrite($archivo, "" . ",");
                        }
                        fwrite($archivo, substr($resolucion->getComparendo()->getValorInfraccion(),0,7) . ",");
                        fwrite($archivo, substr($resolucion->getComparendo()->getValorPagar(),0,7) . ",");
                        fwrite($archivo, substr($resolucion->getComparendo()->getGradoAlcoholemia(),0,7) . ",");
                        if($resolucion->getRestriccion() != null) {
                            if($resolucion->getRestriccion()->getHorasComunitarias() == 1) {
                                fwrite($archivo, "S" . "\r\n");
                            } elseif ($resolucion->getRestriccion()->getHorasComunitarias() == 0) {
                                fwrite($archivo, "N" . "\r\n");
                            }
                        } elseif ($resolucion->getRestriccion() == null) {
                            fwrite($archivo, "" . "\r\n");
                        }
                    }
                    
                    fwrite($archivo, substr($cont,0,4) . ",");
                    fwrite($archivo, substr($sumatoriaValorComparendo,0,7) . ",");
                    fwrite($archivo, "0" . ",");
                    fwrite($archivo, "0" .  "\r\n");

                    fflush($archivo);
                }

                fclose($archivo);   // Cerrar el archivo

                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Archivo generado",
                    'data' => $organismoTransito->getDivipo() . "resol.txt"
                );  
            
            } elseif($params->tipoReporte == 3){
                $dir=__DIR__.'/../../../../web/docs/';
                $file = $dir. $organismoTransito->getDivipo() . 'rec.txt'; 
                
                if( file_exists($organismoTransito->getDivipo() . 'rec.txt') == false ){
                    $archivo = fopen($file, "w+b");    // Abrir el archivo, creándolo si no existe
                }else{
                    $archivo = fopen($file,"r"); 
                }
                
                if($archivo == false){
                    echo("Error al crear el archivo");
                }else{
                    $recaudos = $em->getRepository('JHWEBContravencionalBundle:CvCdoComparendo')->getRecaudosByFechasForFile(
                        $params->idOrganismoTransito,
                        $fechaInicial,
                        $fechaFinal
                    );

                    $fechaActual = new \Datetime();

                    $sumatoriaValorComparendo = 0;
                    $cont = 0;
                    
                    foreach ($recaudos as $key => $recaudo) {
                        //===================encabezado =============================================
                        fwrite($archivo, "0" . ",");
                        fwrite($archivo, $fechaActual->format('d/m/Y') . ",");
                        fwrite($archivo, $fechaActual->format('d/m/Y') . ",");
                        fwrite($archivo, $recaudo->getFactura()->getOrganismoTransito()->getDivipo() . ",");
                        fwrite($archivo, "1" . "\r\n");
                        
                        //============================ fin encabezado ===============================
                        $cont ++;
                        $sumatoriaValorComparendo += $recaudo->getComparendo()->getValorPagar();
    
                        fwrite($archivo, substr($key + 1 ,0,4) . ",");
                        if($recaudo->getFactura() != null) {
                            fwrite($archivo, $recaudo->getFactura()->getFechaPago()->format('d/m/Y') . ",");
                            fwrite($archivo, $recaudo->getFactura()->getHoraPago()->format('H:m') . ",");
                        } elseif ($recaudo->getFactura() == null) {
                            fwrite($archivo, "" . ",");
                            fwrite($archivo, "" . ",");
                        }
                        fwrite($archivo, $recaudo->getFactura()->getFechaPago()->format('d/m/Y') . ","); //fecha real transaccion
                        fwrite($archivo, "0". ","); //cod canal de origen
                        fwrite($archivo, "TAQUILLA TRANSITO" . ","); // descripcion del origen
                        if($recaudo->getFactura() != null) {
                            fwrite($archivo, substr($recaudo->getFactura()->getValorNeto(),0,11) . ",");
                        } elseif($recaudo->getFactura() == null){
                            fwrite($archivo, "" . ",");
                        }
                        fwrite($archivo, 0 . ",");
                        if($recaudo->getFactura() != null) {
                            fwrite($archivo, substr($recaudo->getFactura()->getValorNeto(),0,11) . ",");
                        } elseif($recaudo->getFactura() == null){
                            fwrite($archivo, "" . ",");
                        }fwrite($archivo, 0 . ",");
                        if($recaudo->getComparendo()->getConsecutivo() != null) {
                            fwrite($archivo, $recaudo->getComparendo()->getConsecutivo()->getNumero() . ",");
                        } elseif ($recaudo->getComparendo()->getConsecutivo() == null) {
                            fwrite($archivo, "" . ",");
                        }
                        if($recaudo->getComparendo()->getPolca() == 0) {
                            fwrite($archivo, "N". ",");
                        } elseif ($recaudo->getComparendo()->getPolca() == 1) {
                            fwrite($archivo, "S". ",");
                        }
                        fwrite($archivo, substr($recaudo->getComparendo()->getInfractorIdentificacion(),0,14) . ",");
                        if($recaudo->getFactura() != null) {
                            fwrite($archivo, $recaudo->getFactura()->getTipoRecaudo()->getCodigo() . ",");
                        } elseif ($recaudo->getFactura() != null) {
                            fwrite($archivo, "" . ",");
                        }
                        if($recaudo->getComparendo()->getOrganismoTransito() != null) {
                            fwrite($archivo, $recaudo->getComparendo()->getOrganismoTransito()->getDivipo() . ",");
                        } elseif ($recaudo->getComparendo()->getOrganismoTransito() == null) {
                            fwrite($archivo, "" . ",");
                        }
                        if($recaudo->getFactura() != null) {
                            fwrite($archivo, substr($recaudo->getFactura()->getNumero(),0,15) . ",");
                        } elseif ($recaudo->getFactura() == null) {
                            fwrite($archivo, "" . ",");
                        }
                        if($recaudo->getComparendo()->getAcuerdoPago() != null) {
                            fwrite($archivo, substr($recaudo->getComparendo()->getAcuerdoPago()->getNumeroCuotas(),0,1) . ",");
                        } elseif($recaudo->getComparendo()->getAcuerdoPago() == null) {
                            fwrite($archivo, '' . "," );
                        }
                        if($recaudo->getComparendo()->getAcuerdoPago() != null) {
                            fwrite($archivo, $recaudo->getComparendo()->getAcuerdoPago()->getCiudadano()->getTipoIdentificacion()->getCodigo() . "\r\n");
                        }
                    }

                    fwrite($archivo, substr($cont,0,4) . ",");
                    fwrite($archivo, substr($sumatoriaValorComparendo,0,7) . ",");
                    fwrite($archivo, "0" . ",");
                    fwrite($archivo, "0" .  "\r\n");
                    
                    fflush($archivo);
                }

                fclose($archivo);   // Cerrar el archivo

                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Archivo generado",
                    'data' => $organismoTransito->getDivipo() . "rec.txt"
                );
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

    /**
     * Crea PDF con resumen de comparendo .
     *
     * @Route("/{id}/hojacontrol/pdf", name="cvcdocomparendo_hojacontrol_pdf")
     * @Method({"GET", "POST"})
     */
    public function pdfHojaControlAction(Request $request, $id)
    {
        setlocale(LC_ALL,"es_ES");
        $fechaActual = strftime("%d de %B del %Y");

        $em = $this->getDoctrine()->getManager();

        $comparendo = $em->getRepository('JHWEBContravencionalBundle:CvCdoComparendo')->find(
            $id
        );

        $trazabilidades = $em->getRepository('JHWEBContravencionalBundle:CvCdoTrazabilidad')->findBy(
            array(
                'comparendo' => $comparendo->getId()
            )
        );
        
        $html = $this->renderView('@JHWEBContravencional/Default/pdf.hojacontrol.html.twig', array(
            'fechaActual' => $fechaActual,
            'comparendo'=> $comparendo,
            'trazabilidades'=> $trazabilidades,
        ));

        $this->get('app.pdf')->templatePreview($html, 'Hoja_Control_Exp_'.$comparendo->getExpedienteNumero());
    }

    /**
     * Obtiene los datos de inventario documental por rango de fechas
     *
     * @Route("/create/excel/inventory", name="cvcdocomparendo_excel_inventory")
     * @Method({"GET", "POST"})
     */
    public function excelInventoryAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            setlocale(LC_ALL,"es_ES");
            $fechaActual = strftime("%d de %B del %Y");

            $fechaInicial = new \Datetime($params->fechaInicial);
            $fechaFinal = new \Datetime($params->fechaFinal);

            $inventarios = $em->getRepository('JHWEBContravencionalBundle:CvInventarioDocumental')->getByFechas(
                $fechaInicial, $fechaFinal
            );

            if($inventarios){
                $data = (object)
                    array(
                    'template' => 'templateExcelByInventarioDocumental',
                    'inventarios' => $inventarios,
                );

                return $this->get('app.excel')->newExcel($data);
            }else{
                $response = array(
                    'title' => 'Atención!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => 'No existen registros para el rango de fechas estipulados.', 
                );
            }

            return $helpers->json($response);
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorización no válida.', 
            );
        }
    }

    /**
     * genera un reporte para gráficas segun filtros.
     *
     * @Route("/generate/reporte", name="cvcdocomparendo_generate_reporte")
     * @Method({"GET","POST"})
     */
    public function generateReporteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
    
    
        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);
    
            $em = $this->getDoctrine()->getManager();

            if($params->tipoReporte == 1) {
                $comparendos = $em->getRepository('JHWEBContravencionalBundle:CvCdoComparendo')->getTopByInfraccion(
                    $params->idOrganismoTransito, $params->fechaInicial, $params->fechaFinal
                );
            }
            elseif($params->tipoReporte == 2) {
                $comparendos = $em->getRepository('JHWEBContravencionalBundle:CvCdoComparendo')->getTopByEdad(
                    $params->idOrganismoTransito, $params->fechaInicial, $params->fechaFinal
                );
            }
    
            if ($comparendos) {
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Comparendos encontrados satisfactoriamente.", 
                    'data' => $comparendos,
                );
            }else{
                 $response = array(
                    'title' => 'Atención!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => "No existe ningún comparendo con los filtros estipulados.", 
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
}
