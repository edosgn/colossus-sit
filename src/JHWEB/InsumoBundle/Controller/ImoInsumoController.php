<?php

namespace JHWEB\InsumoBundle\Controller;

use JHWEB\InsumoBundle\Entity\ImoInsumo;
use JHWEB\InsumoBundle\Entity\ImoLote;
use JHWEB\InsumoBundle\Entity\ImoTrazabilidad;
use JHWEB\InsumoBundle\Entity\ImoAsignacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Imoinsumo controller.
 *
 * @Route("imoinsumo")
 */
class ImoInsumoController extends Controller
{
    /**
     * Lists all imoInsumo entities.
     *
     * @Route("/", name="imoinsumo_index")
     * @Method("POST")
     */
    public function indexAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        $json = $request->get("data",null);
        $params = json_decode($json);

        $em = $this->getDoctrine()->getManager();
        
        $insumos = $em->getRepository('JHWEBInsumoBundle:ImoInsumo')->findBy(
            array(
                'estado' => 'disponible',
                'tipo' => $params->tipo
            )
        );

        $response['data'] = array();

        if ($insumos) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($insumos)." registros encontrados", 
                'data'=> $insumos,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new imoInsumo entity.
     *
     * @Route("/new", name="imoinsumo_new")
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

            $fecha = new \DateTime($params->asignacionInsumos->fecha);
            $em = $this->getDoctrine()->getManager();

            $sedeOperativa = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find($params->asignacionInsumos->sedeOperativaId);
            $numeroActa = $em->getRepository('JHWEBInsumoBundle:ImoLote')->getMaxActa();

            if ($numeroActa['maximo'] == '') { 
                $numeroActa = 1; 
            }else{
               $numeroActa = $numeroActa['maximo']+1;
            }

            $imoTrazabilidad = new ImoTrazabilidad();

            $imoTrazabilidad->setOrganismoTransitoDestino($sedeOperativa);
            $imoTrazabilidad->setFecha($fecha);
            $imoTrazabilidad->setEstado('ASIGNACION');
            $imoTrazabilidad->setActivo(true);

            $em->persist($imoTrazabilidad);
            $em->flush();
            
            foreach ($params->array as $key => $lote) {
                $loteInsumo = $em->getRepository('JHWEBInsumoBundle:ImoLote')->find($lote->idLote);
                $tipoInsumo = $em->getRepository('JHWEBInsumoBundle:ImoCfgTipo')->find($lote->idTipo);
                             
                $desde = $loteInsumo->getRangoInicio();
                $hasta = $loteInsumo->getRangoFin();

                if ($loteInsumo->getTipo() == 'SUSTRATO') {
                    $loteInsumo->setEstado('ASIGNADO');
                    $loteInsumo->setNumeroActaEntrega($numeroActa);

                    while ($desde <= $hasta) {
                        $insumo = new ImoInsumo();

                        $em = $this->getDoctrine()->getManager();
                        $insumo->setNumero($tipoInsumo->getModulo()->getSiglaSustrato().$desde);
                        $insumo->setOrganismoTransito($sedeOperativa);
                        $insumo->setTipo($tipoInsumo);
                        $insumo->setLote($loteInsumo); 
                        $insumo->setFecha($fecha);
                        $insumo->setActaEntrega($numeroActa);
                        $insumo->setEstado('DISPONIBLE');
                        $em->persist($insumo);
                        $em->flush();
      
                        $imoAsignacion = new ImoAsignacion();

                        $funcionario = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->find($params->asignacionInsumos->idFuncionario);
                        $imoAsignacion->setFuncionario($funcionario);
    
                        $imoAsignacion->setImoTrazabilidad($imoTrazabilidad);
                        $imoAsignacion->setInsumo($insumo);
                        $imoAsignacion->setActivo(true);

                        $em->persist($imoAsignacion);
                        $em->flush();
                        
                        $desde++;
                    }
                    
                    $response = array(
                        'status' => 'success',
                        'code' => 200, 
                        'data' => $numeroActa,
                        'message' => "insumo creado con exito", 
                    );
                    
                }else{
                    $insumo = new ImoInsumo();
                    
                    $insumo->setLote($loteInsumo);
                    $insumo->setNumero($lote->cantidad);
                    $insumo->setTipo($tipoInsumo);
                    $insumo->setOrganismoTransito($sedeOperativa);
                    $insumo->setEstado('DISPONIBLE');
                    $insumo->setFecha($fecha);
                    $insumo->setActaEntrega($numeroActa);
                    
                    $em->persist($insumo);
                    $em->flush();
                    
                    $lotesInsumo = $em->getRepository('JHWEBInsumoBundle:ImoLote')->findBy(
                        array(
                            'estado' => 'REGISTRADO',
                            'tipo' => 'INSUMO',
                            'tipoInsumo' => $tipoInsumo->getId()
                        )
                    );

                    foreach ($lotesInsumo as $key => $loteInsumo){
                        if ($lote->cantidad > 0) {
                            if ($loteInsumo->getCantidad() <= $lote->cantidad) {
                                $cantidad =  $lote->cantidad - $loteInsumo->getCantidad();
                                $lote->cantidad = $cantidad;
                                $loteInsumo->setCantidad(0);
                                $loteInsumo->setEstado('ASIGNADO');
    
                                $em->flush(); 
                            }else {
                                
                                $cantidad = $loteInsumo->getCantidad() - $lote->cantidad;
                                $loteInsumo->setCantidad($cantidad);
                                $loteInsumo->setEstado('REGISTRADO');
                                
                                $lote->cantidad = 0;
                                
                                $em->flush();
                            }
                        }
                    }
                   
                    $response = array(
                        'status' => 'success',
                        'code' => 200, 
                        'data' => $numeroActa,
                        'message' => "insumo creado con exito", 
                    );
                }
                
            }
        }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorización no valida", 
                );
            } 
        return $helpers->json($response);
    }

    /**
     * Finds and displays a imoInsumo entity.
     *
     * @Route("/{id}", name="imoinsumo_show")
     * @Method("GET")
     */
    public function showAction(ImoInsumo $imoInsumo)
    {
        $deleteForm = $this->createDeleteForm($imoInsumo);

        return $this->render('imoinsumo/show.html.twig', array(
            'imoInsumo' => $imoInsumo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing imoInsumo entity.
     *
     * @Route("/{id}/edit", name="imoinsumo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ImoInsumo $imoInsumo)
    {
        $deleteForm = $this->createDeleteForm($imoInsumo);
        $editForm = $this->createForm('JHWEB\InsumoBundle\Form\ImoInsumoType', $imoInsumo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('imoinsumo_edit', array('id' => $imoInsumo->getId()));
        }

        return $this->render('imoinsumo/edit.html.twig', array(
            'imoInsumo' => $imoInsumo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

     /**
     * Deletes a insumo entity.
     *
     * @Route("/delete", name="imoinsumo_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $insumo = $em->getRepository('JHWEBInsumoBundle:ImoInsumo')->find(
                $params->id
            );

            $insumo->setMotivoAnulacion(
                $params->motivo
            );
            $insumo->setEstado('ANULADO');

            $em->persist($insumo);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "insumo eliminado con exito", 
            );
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
     * Creates a form to delete a imoInsumo entity.
     *
     * @param ImoInsumo $imoInsumo The imoInsumo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ImoInsumo $imoInsumo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('imoinsumo_delete', array('id' => $imoInsumo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ======================================================= */

    /**
     * Finds and displays a sustrato entity.
     *
     * @Route("/search/numero/modulo", name="imoinsumo_search_numero")
     * @Method({"GET", "POST"})
     */
    public function searchByNumeroAndModuloAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $sustrato = $em->getRepository('JHWEBInsumoBundle:ImoInsumo')->getByNumeroAndModulo(
                $params->numero,
                $params->idModulo,
                $params->idOrganismoTransito
            );

            if ($sustrato) {
                if ($sustrato['estado'] == 'DISPONIBLE') {
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'data'=> $sustrato,
                    );
                }else{
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message'=> 'El sustrato ya fue asignado.',
                    );
                }
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message'=> 'Sustrato no disponible para este módulo.',
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
     * Lists all insumo entities.
     *
     * @Route("/isExistencia", name="imoinsumo_isExistencia")
     * @Method({"GET", "POST"})
     */
    public function isExistenciaAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $json = $request->get("data",null);
        $params = json_decode($json);

        $insumos = $em->getRepository('JHWEBInsumoBundle:ImoInsumo')->getInsumoCantidad($params->sedeOrigen,$params->casoInsumo,$params->cantidad);


        if ($insumos) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'data' => $insumos,
                'message' => 'Total de registros encontrados',
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'la sede tiene '.count($insumos).' sustratos para reasignar',
            );
        }

        return $helpers->json($response);
    }

    /**
     * Lists all insumo entities.
     *
     * @Route("/reasignacion/sustrato", name="imoinsumo_reasignacion_sustrato")
     * @Method({"GET", "POST"})
     */
    public function reasignacionByTypeSustratoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager(); 
        $json = $request->get("data",null);
        $params = json_decode($json);
        
        $sustratos = $params->insumos;
        
     
        $fecha = new \DateTime('now');

        $organismoTransitoDestino = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find(
            $params->sedeOperativaDestino
        );

        
        $tipoInsumo = $em->getRepository('JHWEBInsumoBundle:ImoCfgTipo')->find(1);
        // var_dump($params->tipoInsumo);
        // die();

        $organismoTransitoOrigen = $em->getRepository('JHWEBInsumoBundle:ImoLote')->find(
            $params->sedeOperativaOrigen
        );

        $loteReasignacion = new ImoLote();

        
        $loteReasignacion->setNumeroActa(null);
        $loteReasignacion->setEstado('REASIGNADO');
        $loteReasignacion->setTipoInsumo($tipoInsumo);
        $loteReasignacion->setTipo('SUSTRATO');
        $loteReasignacion->setRangoInicio(0);
        $loteReasignacion->setRangoFin(0);
        $loteReasignacion->setCantidad(count($sustratos));
        $loteReasignacion->setRecibido(count($sustratos));
        $loteReasignacion->setReferencia(null);
        $loteReasignacion->setFecha($fecha);

        $em->persist($loteReasignacion);
        $em->flush();

        $imoTrazabilidad = new ImoTrazabilidad();

        $imoTrazabilidad->setOrganismoTransitoOrigen($organismoTransitoOrigen);
        $imoTrazabilidad->setOrganismoTransitoDestino($organismoTransitoDestino);
        $imoTrazabilidad->setLote($loteReasignacion);
        $imoTrazabilidad->setFecha($fecha);
        $imoTrazabilidad->setEstado('REASIGNACION');
        $imoTrazabilidad->setActivo(true);

        $em->persist($imoTrazabilidad);
        $em->flush();

        foreach ($sustratos as $key => $sustrato) {
            $sustrato = $em->getRepository('JHWEBInsumoBundle:ImoInsumo')->find(
                $sustrato->id
            );
            $imoAsignacionOld = $em->getRepository('JHWEBInsumoBundle:ImoAsignacion')->findOneByInsumo($sustrato->getId());
            if ($imoAsignacionOld) {
                $imoAsignacionOld->setActivo(false);
                $em->flush();
            }
            // var_dump($sustrato->id);
            // die();

            $imoAsignacion = new ImoAsignacion();

            $imoAsignacion->setImotrazabilidad($imoTrazabilidad); 
            $imoAsignacion->setInsumo($sustrato);
            $imoAsignacion->setActivo(true);

            $sustrato->setOrganismoTransito($organismoTransitoDestino);

            $em->persist($sustrato);
            $em->persist($imoAsignacion);
            $em->flush();
        }
        
        $response = array(
            'status' => 'success',
            'code' => 200,
            'message' => 'Sustratos reasignados:'.count($sustratos),
        );
        
        return $helpers->json($response);
    }

    /**
     * Lists all insumo entities.
     *
     * @Route("/show/ultimo/sustrato/disponible", name="imoinsumo_sustrato_ultimo_disponible")
     * @Method({"GET", "POST"})
     */
    public function showUltimoSustratoDisponibleAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager(); 
        $json = $request->get("data",null);
        $params = json_decode($json);

        
        $numeroSustrato = $em->getRepository('JHWEBInsumoBundle:ImoAsignacion')->getLastByFuncionario($params->sedeOperativa);
        if ($numeroSustrato['numero']) {
            $response = array(
                'status' => 'success',
                'code' => 400,
                'numero' => $numeroSustrato['numero'],
                'idInsumo' => $numeroSustrato['id'],
            );
        }else {
            $response = array(
                'status' => 'error',
                'code' => 200,
                'message' => 'sin sustratos',
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Finds and displays a insumo entity.
     *
     * @Route("/show/loteInsumo", name="imoinsumo_show_loteinsumo")
     * @Method({"GET", "POST"})
     */
    public function showLoteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $json = $request->get("data",null);
        $params = json_decode($json);
        
      
        if ($authCheck== true) {
            $em = $this->getDoctrine()->getManager();
            
            $sustratos = [];
            $insumos = $em->getRepository('JHWEBInsumoBundle:ImoInsumo')->findByLote($params);

            foreach ($insumos as $key => $insumo) {
                if($insumo->getTipo()->getCategoria() == 'SUSTRATO')  {
                    $sustratos[] = $insumo;
                }
            }

            if($sustratos){
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'data' => $sustratos,
                    'message' => "Registros encontrados", 
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Registros no encontrados", 
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
     * Creates a new Cuenta entity.
     *
     * @Route("/pdf/acta/insumos", name="imoinsumo_pdf_acta")
     * @Method({"GET", "POST"})
     */
    public function pdfAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        setlocale(LC_ALL,"es_ES");
        $fechaActual = strftime("%d de %B del %Y");

        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager(); 
        $json = $request->get("data",null);
        $params = json_decode($json);

        $fechaInicio = new \Datetime($params->fechaInicio);
        $fechaFin = new \Datetime($params->fechaFin);
        $funcionario = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->find(
            $params->idFuncionario
        );

        /* ================= */
        if ($params->tipoActa == "totales") {
            $totalSede = 0;
            $valorTotalSede = 0;
            
            $organismosTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->findBy(
                array(
                    'sede' => true,
                    'activo' => true
                )
            );
            $totalAsignados=0;
            foreach ($organismosTransito as $key => $organismoTransito) {
                $valorSede = 0;

                $insumos = $em->getRepository('JHWEBInsumoBundle:ImoInsumo')->findBy(
                    array(
                        'organismoTransito' =>  $organismoTransito->getId(),
                        'estado' => 'ASIGNADO'
                    )
                );

                $insumosTotal = $em->getRepository('JHWEBInsumoBundle:ImoInsumo')->findBy(
                    array(
                        'organismoTransito' =>  $organismoTransito->getId(),
                    )
                );

                $totalSede = $totalSede + COUNT($insumos);

                if ($insumos) {
                    foreach ($insumos as $key => $insumo) {
                        $valorTipo = $em->getRepository('JHWEBInsumoBundle:ImoCfgValor')->findOneBy(
                            array(
                                'tipo' => $insumo->getTipo()->getId(),
                                'activo' => true
                            ) 
                        );
                        
                        if ($valorTipo) {
                            $valorSede += $valorTipo->getValor();
                        }else {
                            $valorSede += 0;
                        }
                    }
                }

                $valorTotalSede = $valorTotalSede + $valorSede;
                $totalAsignados = $totalAsignados + COUNT($insumosTotal);

                $totalOrganismos[] = array(
                    'nombreOrganismo' => $organismoTransito->getNombre(),
                    'sustratosCantidad' => COUNT($insumos),
                    'insumosTotal' => COUNT($insumosTotal),
                    'valorSede' => $valorSede, 
                );

            }

            $totalConsignar = $valorTotalSede * $totalSede;

            $html = $this->renderView('@JHWEBInsumo/Default/pdf.acta.insumo.html.twig', array(
                'tipoActa' => $params->tipoActa, 
                'totalOrganismos' => $totalOrganismos, 
                'totalSede' => $totalSede, 
                'valorTotalSede' => $valorTotalSede, 
                'totalConsignar' => $totalConsignar,
                'funcionario' => $funcionario,
                'totalAsignados' => $totalAsignados,
            )); 
        }else{
            $organismoTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find(
                $params->idOrganismoTransito 
            );
    
            $insumos = $em->getRepository('JHWEBInsumoBundle:ImoInsumo')->getInsumoRango(
                $fechaInicio,
                $fechaFin,
                $organismoTransito->getId()
            );
    
            $disponibles = [];
            $anulados = [];
            $asignados = [];
    
            foreach ($insumos as $key => $insumo) {
                switch ($insumo->getEstado()) {
                    case 'DISPONIBLE':
                        $disponibles[] = $insumo;
                        break;
                    case 'ANULADO':
                        $anulados[] = $insumo;
                        break;
                    case 'ASIGNADO':
                        $asignados[] = $insumo;
                        break;
                }
            }
    
            $lotesOrganismo = $em->getRepository('JHWEBInsumoBundle:ImoLote')->findBySedeOperativa(
                $params->idOrganismoTransito 
            );
    
            $loteArray=[];
            $disponiblesLote=[];
            $anuladosLote=[];
            $asignadosLote=[];
    
            $disponiblesLoteTotal=0;
            $anuladosLoteTotal=0;
            $asignadosLoteTotal=0;
            $totalAsignados=0;
            
            foreach ($lotesOrganismo as $key => $loteOrganismo) {
                foreach ($insumos as $key => $insumo) {
                    switch ($insumo->getEstado()) {
                        case 'DISPONIBLE':
                            if($loteOrganismo->getId() == $insumo->getLote()->getId()){
                                $disponiblesLote[] = $insumo;
                            }
                            break;
                        case 'ANULADO':
                            if($loteOrganismo->getId() == $insumo->getLote()->getId()){
                                $anuladosLote[] = $insumo;
                            }
                            break;
                        case 'ASIGNADO':
                            if($loteOrganismo->getId() == $insumo->getLote()->getId()){
                                $asignadosLote[] = $insumo;
                            }
                            break;
                    }
                }
                $disponiblesLoteTotal=$disponiblesLoteTotal + COUNT($disponiblesLote);
                $anuladosLoteTotal=$anuladosLoteTotal + COUNT($anuladosLote);
                $asignadosLoteTotal=$asignadosLoteTotal + COUNT($asignadosLote);
                $totalAsignados = $totalAsignados + COUNT($asignadosLote) + COUNT($anuladosLote) + COUNT($disponiblesLote);
                
                if($loteOrganismo->getTipo() == 'SUSTRATO'){
                    $loteArray[] = array(
                        'id'=>$loteOrganismo->getTipoInsumo()->getNombre(), 
                        'rangoInicio'=>$loteOrganismo->getRangoInicio(),
                        'rangoFIn'=>$loteOrganismo->getRangoFIn(),
                        'disponiblesLote'=>COUNT($disponiblesLote),
                        'anuladosLote'=>COUNT($anuladosLote),
                        'asignadosLote'=>COUNT($asignadosLote),
                        'totalAsignados'=>COUNT($asignadosLote) + COUNT($anuladosLote) + COUNT($disponiblesLote),
                    );
                }
                $disponiblesLote=[];
                $anuladosLote=[];
                $asignadosLote=[];
    
            }
    
            $tipos = $em->getRepository('JHWEBInsumoBundle:ImoCfgTipo')->findBy(
                array(
                    'categoria'=>'SUSTRATO'
                )
            );
            
            $tiposArray = [];
            $totalOrganismos=[];
            $total = 0;
            $totalValor = 0;
            
            foreach ($tipos as $key => $tipo) {
                $disponiblesTipo = array();
                $anuladosTipo = array();
                $asignadosTipo = array();
    
                foreach ($disponibles as $key => $disponible) {
                    if ($tipo->getId() == $disponible->getTipo()->getId()) {
                        $disponiblesTipo[] = $disponible;
                    }
                }
    
                foreach ($anulados as $key => $anulado) {
                    if ($tipo->getId() == $anulado->getTipo()->getId()) {
                        $anuladosTipo[] = $anulado;
                    }
                }
    
                foreach ($asignados as $key => $asignado) {
                    if ($tipo->getId() == $asignado->getTipo()->getId()) {
                        $asignadosTipo[] = $asignado;
                    }
                }
           
                $valorTipo = $em->getRepository('JHWEBInsumoBundle:ImoCfgValor')->findOneBy(
                    array('tipo'=>$tipo->getId(), 'activo'=>true) 
                );
    
                if ($valorTipo) {
                   $valorInsumo = $valorTipo->getValor();
                }else {
                    $valorInsumo = 0;
                }
    
                $subTotal = COUNT($asignadosTipo) * $valorInsumo;
                $total = $total + COUNT($asignadosTipo);
    
                $totalValor = $totalValor + $subTotal;
    
                $tiposArray[] = array(
                    'nombre' => $tipo->getNombre(),
                    'disponilbes' => COUNT($disponiblesTipo),
                    'anulados' => COUNT($anuladosTipo),
                    'asignados' => COUNT($asignadosTipo),
                    'totalValor' => $totalValor,
                    'valorInsumo' => $valorInsumo,
                    'total' => $total,
                    'subTotal' => $subTotal,
                );
    
            }

            $html = $this->renderView('@JHWEBInsumo/Default/pdf.acta.insumo.html.twig', array(
                'organismoTransito' => $organismoTransito, 
                'tiposArray' => $tiposArray, 
                'loteArray' => $loteArray, 
                'disponibles' => $disponibles,
                'total' => $total,
                'anulados' => $anulados,
                'asignados' => $asignados, 
                'ifDisponibles' => $params->disponibles, 
                'ifAnulados' => $params->anulado, 
                'totalValor' => $totalValor,
                'totalAsignados' => $totalAsignados,
                'ifAsignado' => $params->asignado, 
                'tipoActa' => $params->tipoActa,
                'disponiblesLoteTotal'=>$disponiblesLoteTotal,
                'anuladosLoteTotal'=>$anuladosLoteTotal,
                'asignadosLoteTotal'=>$asignadosLoteTotal,
                'funcionario'=>$funcionario,
            )); 
        }
        /* ================= */
         
        
        return new Response(
            $this->get('app.pdf')->templatePreview($html, 'Acta '.$params->tipoActa),
            200,
            array(
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="fichero.pdf"'
            )
        );

    }
}
