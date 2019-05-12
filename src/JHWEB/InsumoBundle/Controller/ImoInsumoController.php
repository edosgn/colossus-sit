<?php

namespace JHWEB\InsumoBundle\Controller;

use JHWEB\InsumoBundle\Entity\ImoInsumo;
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

            $imoTrazabilidad->setOrganismoTransito($sedeOperativa);
            $imoTrazabilidad->setFecha($fecha);
            $imoTrazabilidad->setEstado('asignacion');
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
                        $insumo->setCategoria('SUSTRATO');
                        $insumo->setEstado('DISPONIBLE');
                        $em->persist($insumo);
                        $em->flush();
      
                        $imoAsignacion = new ImoAsignacion();
    
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

                    $lotesInsumo = $em->getRepository('JHWEBInsumoBundle:ImoLote')->findBy(
                        array('estado' => 'REGISTRADO','tipo'=>'Insumo')
                    );

                    $insumo->setLote($loteInsumo);
                    $insumo->setNumero($lote->cantidad);
                    $insumo->setTipo($tipoInsumo);
                    $insumo->setOrganismoTransito($sedeOperativa);
                    $insumo->setEstado('DISPONIBLE');
                    $insumo->setFecha($fecha);
                    $insumo->setCategoria('INSUMO');
                    $insumo->setActaEntrega($numeroActa);

                    $em->persist($insumo);
                    $em->flush();

                    foreach ($lotesInsumo as $key => $loteInsumo){
                        if ($loteInsumo->getCantidad() <= $lote->cantidad) {
                            $cantidad =  $lote->cantidad - $loteInsumo->getCantidad();
                            $lote->cantidad = $cantidad;
                            $loteInsumo->setCantidad(0);
                            $loteInsumo->setEstado('ASIGNADO');

                            $em->flush(); 
                        }else {
                            if ($lote->cantidad > 0) {
                                $cantidad =  $loteInsumo->getCantidad() - $lote->cantidad;
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
     * @Route("/{id}/delete", name="imoinsumo_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $insumo = $em->getRepository('JHWEBInsumoBundle:ImoInsumo')->find($id);

            $insumo->setEstado('ANULADO');
            $em = $this->getDoctrine()->getManager();
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
     * @Route("/search/numero/modulo", name="insumo_search_numero")
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
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'data'=> $sustrato,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 300,
                    'message'=> 'sustrato no encontrado',
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
     * @Route("/isExistencia", name="imo_insumo_isExistencia")
     * @Method({"GET", "POST"})
     */
    public function isExistenciaAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $json = $request->get("data",null);
        $params = json_decode($json);

        $insumos = $em->getRepository('JHWEBInsumoBundle:ImoInsumo')->findBy(
            array('tipo'=>'Sustrato','estado' => 'disponible','tipo'=>$params->casoInsumo,'organismoTransito'=>$params->sedeOrigen)
        );

        if (count($insumos) >= $params->cantidad) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => 'Total de registros encontrados',
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => 'la sede tiene '.count($insumos).' sustratos para reasignar',
            );
        }

        return $helpers->json($response);
    }

    /**
     * Lists all insumo entities.
     *
     * @Route("/reasignacionSustrato", name="imo_insumo_reasignacionSustrato")
     * @Method({"GET", "POST"})
     */
    public function reasignacionByTypeSustratoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager(); 
        $json = $request->get("data",null);
        $params = json_decode($json);

        $sustratos = $em->getRepository('JHWEBInsumoBundle:ImoInsumo')->findBy(
            array('lote'=>$params->lote->id)
        );
     
        $fecha = new \DateTime('now');

        $organismoTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find($params->sedeOperativaDestino);

        $lote = $em->getRepository('JHWEBInsumoBundle:ImoLote')->find($params->lote->id);
        $lote->setSedeOperativa($organismoTransito); 

        $imoTrazabilidad = new ImoTrazabilidad();

        $imoTrazabilidad->setOrganismoTransito($organismoTransito);
        $imoTrazabilidad->setFecha($fecha);
        $imoTrazabilidad->setEstado('REASIGNACION');
        $imoTrazabilidad->setActivo(true);

        $em->persist($lote);
        $em->persist($imoTrazabilidad);
        $em->flush();

        foreach ($sustratos as $key => $sustrato) {
        
            $imoAsignacionOld = $em->getRepository('JHWEBInsumoBundle:ImoAsignacion')->findOneByInsumo($sustrato->getId());
            if ($imoAsignacionOld) {
                $imoAsignacionOld->setActivo(false);
                $em->flush();
            }

            $imoAsignacion = new ImoAsignacion();

            $imoAsignacion->setImotrazabilidad($imoTrazabilidad); 
            $imoAsignacion->setInsumo($sustrato);
            $imoAsignacion->setActivo(true);

            $sustrato->setOrganismoTransito($organismoTransito);

            $em->persist($sustrato);
            $em->persist($imoAsignacion);
            $em->flush();
        }
        
        $response = array(
            'status' => 'success',
            'code' => 400,
            'msj' => 'Sustratos reasignados:'.count($sustratos),
        );
        
        return $helpers->json($response);
    }

    /**
     * Lists all insumo entities.
     *
     * @Route("/show/ultimo/sustrato/disponible", name="insumo_sustrato_ultimo_disponible")
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
                'msj' => 'sin sustratos',
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Finds and displays a insumo entity.
     *
     * @Route("/show/loteInsumo", name="imo_insumo_show_loteInsumo")
     * @Method({"GET", "POST"})
     */
    public function showLoteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck== true) {
            $em = $this->getDoctrine()->getManager();
            
            $insumos = $em->getRepository('JHWEBInsumoBundle:ImoInsumo')->findBy(
                array('categoria'=>'SUSTRATO',)
            );
    
            $response = array(
                'status' => 'success',
                'code' => 200,
                'datos' => $insumos,
                'msj' => "insumo creado con exito", 
            );
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
     * Creates a new Cuenta entity.
     *
     * @Route("/pdf/acta/insumos", name="pdf_acta_imoImo")
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

        
        $fechaInicioDatetime = new \Datetime($params->fechaInicio);
        $fechaFinDatetime = new \Datetime($params->fechaFin);
        $organismoTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find($params->organismoTransito);

        $insumos = $em->getRepository('JHWEBInsumoBundle:ImoInsumo')->getInsumoRango($fechaInicioDatetime,$fechaFinDatetime,$organismoTransito->getId());

        $disponibles = [];
        $anulados = [];
        $asignados = [];

        foreach ($insumos as $key => $insumo) {
            switch ($insumo->getEstado()) {
                case 'DISPONIBLE':
                    $disponibles[]=$insumo;
                    break;
                case 'ANULADO':
                    $anulados[]=$insumo;
                    break;
                case 'ASIGNADO':
                    $asignados[]=$insumo;
                    break;
            }
        }

        $tipos = $em->getRepository('JHWEBInsumoBundle:ImoCfgTipo')->findBy(
            array('tipo'=>'Sustrato')
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
                array('imoCfgTipo'=>$tipo->getId(), 'activo'=>true) 
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

            /*$disponiblesTipo = array();
            $anuladosTipo = array();
            $asignadosTipo = array();*/
        }

        $totalSede = 0;
        $valorSerde = 0;
        $valorTotalSede = 0;
        
        $OrganismosTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->findByActivo(true);
        foreach ($OrganismosTransito as $key => $organismoTransitoTotal) {
            $insumosOrganismos = $em->getRepository('JHWEBInsumoBundle:ImoInsumo')->findBy(
                array(
                   'organismoTransito' =>  $organismoTransitoTotal->getId(),
                   'estado' => 'ASIGNADO'
                )
            );
            $totalSede = $totalSede + COUNT($insumosOrganismos);

            foreach ($insumosOrganismos as $key => $insumoOrganismo) {
                $valorTipo = $em->getRepository('JHWEBInsumoBundle:ImoCfgValor')->findOneBy(
                    array('imoCfgTipo'=>$insumoOrganismo->getTipo()->getId(), 'activo'=>true) 
                );
    
                if ($valorTipo) {
                   $valorInsumo = $valorTipo->getValor();
                }else {
                    $valorInsumo = 0;
                }
                $valorSerde = $valorSerde + $valorInsumo;
            }

            $valorTotalSede =  $valorTotalSede +$valorSerde;

            $totalOrganismos[] = array(
                'nombreOrganismo' => $organismoTransitoTotal->getNombre(),
                'sustratosCantidad' => COUNT($insumosOrganismos),
                'valorSerde' => $valorSerde, 

            );
            $valorSerde=0;
        }
        $totalConsignar = $valorTotalSede * $totalSede;

        $html = $this->renderView('@JHWEBInsumo/Default/pdf.acta.insumo.html.twig', array(
            'organismoTransito' => $organismoTransito, 
            'tiposArray' => $tiposArray, 
            'disponibles' => $disponibles,
            'total' => $total,
            'anulados' => $anulados,
            'asignados' => $asignados, 
            'ifDisponibles' => $params->disponibles, 
            'ifAnulados' => $params->anulado, 
            'totalValor' => $totalValor,
            'ifAsignado' => $params->asignado, 
            'tipoActa' => $params->tipoActa, 
            'totalOrganismos' => $totalOrganismos, 
            'totalSede' => $totalSede, 
            'valorTotalSede' => $valorTotalSede, 
            'totalConsignar' => $totalConsignar, 
        )); 
              
        return new Response(
            $this->get('app.pdf')->templatePreview($html, $organismoTransito),
            200,
            array(
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="fichero.pdf"'
            )
        );

    }



}
