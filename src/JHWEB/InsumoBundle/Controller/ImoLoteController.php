<?php

namespace JHWEB\InsumoBundle\Controller;

use JHWEB\InsumoBundle\Entity\ImoLote;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Imolote controller.
 *
 * @Route("imolote")
 */
class ImoLoteController extends Controller
{
    /**
     * Lists all imoLote entities.
     *
     * @Route("/", name="imolote_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $loteInsumos = $em->getRepository('JHWEBInsumoBundle:ImoLote')->findBy(
            array('tipo'=>'INSUMO')
        );
        $loteSustratos = $em->getRepository('JHWEBInsumoBundle:ImoLote')->findBy(
            array('tipo'=>'SUSTRATO')
        );

        $totalesTtpo = $em->getRepository('JHWEBInsumoBundle:ImoLote')->getTotalesTipo();
        
        $data = array(
            'loteInsumos' =>  $loteInsumos, 
            'loteSustratos' =>  $loteSustratos, 
            'totalesTipo' =>  $totalesTtpo, 
        );
        
        $response = array(
            'status' => 'success',
            'code' => 200,
            'message' => count($loteInsumos)+count($loteSustratos)." registros encontrados", 
            'data'=> $data,
        );
        

        return $helpers->json($response);
    }

    /**
     * Creates a new imoLote entity.
     *
     * @Route("/new", name="imolote_new")
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
            
            $fecha = $params->fecha;
            $fecha = new \DateTime($params->fecha);

            $em = $this->getDoctrine()->getManager();

            $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->find($params->idEmpresa);
            $idOrganismoTransito = (isset($params->idOrganismoTransito)) ? $params->idOrganismoTransito : null;

            $loteInsumo = new ImoLote();
            
            if ($idOrganismoTransito) {
                $sedeOperativa = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find($idOrganismoTransito);
                $loteInsumo->setSedeOperativa($sedeOperativa);
                $loteInsumo->setTipo('SUSTRATO');
                $ultimoRango = $em->getRepository('JHWEBInsumoBundle:ImoLote')->getMax($params->imoCfgTipo); 

                if ($ultimoRango['maximo']) {
                    if ($params->rangoInicio < $ultimoRango['maximo']+1) {
                        $response = array(
                            'status' => 'error',
                            'code' => 400,
                            'message' => "El rango ya se encuentra registrado", 
                        );
                        
                        return $helpers->json($response);
                    }
                }
            }else { 
                $loteInsumo->setTipo('INSUMO');
            }

            $tipoInsumo = $em->getRepository('JHWEBInsumoBundle:ImoCfgTipo')->find($params->imoCfgTipo);

            $loteInsumo->setNumeroActa($params->numeroActa);
            $loteInsumo->setEmpresa($empresa);
            $loteInsumo->setTipoInsumo($tipoInsumo); 
            $loteInsumo->setEstado('REGISTRADO');
            $loteInsumo->setRangoInicio($params->rangoInicio);
            $loteInsumo->setRangoFin($params->rangoFin);
            $loteInsumo->setCantidad($params->cantidad);
            $loteInsumo->setRecibido($params->cantidad);
            $loteInsumo->setReferencia($params->referencia);
            $loteInsumo->setFecha($fecha);

            $em->persist($loteInsumo);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Lote de ".$tipoInsumo->getNombre()." creado con exito", 
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
     * Finds and displays a imoLote entity.
     *
     * @Route("/{id}", name="imolote_show")
     * @Method("GET")
     */
    public function showAction(ImoLote $imoLote)
    {
        $deleteForm = $this->createDeleteForm($imoLote);

        return $this->render('imolote/show.html.twig', array(
            'imoLote' => $imoLote,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Linea entity.
     *
     * @Route("/edit", name="imoLote_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $loteInsumo = $em->getRepository('JHWEBInsumoBundle:ImoLote')->find($params->id);
            
            $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->find($params->empresaId);

            $sedeOperativaId = (isset($params->sedeOperativaId)) ? $params->sedeOperativaId : null;

            if ($sedeOperativaId) {
                $sedeOperativa = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find($sedeOperativaId);
                $loteInsumo->setSedeOperativa($sedeOperativa);
            }

            $fecha = new \DateTime($params->fecha);
            
            $tipoInsumo = $em->getRepository('JHWEBInsumoBundle:ImoCfgTipo')->find($params->casoInsumoId);
            
            if ($loteInsumo) {
                $loteInsumo->setNumeroActa($params->numeroActa);
                $loteInsumo->setEmpresa($empresa);
                $loteInsumo->setTipoInsumo($tipoInsumo); 
                $loteInsumo->setRangoInicio($params->rangoInicio);
                $loteInsumo->setRangoFin($params->rangoFin);
                $loteInsumo->setCantidad($params->cantidad);
                $loteInsumo->setReferencia($params->referencia);
                $loteInsumo->setFecha($fecha);

                $em->persist($loteInsumo);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro editado con exito", 
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
                    'message' => "Autorizacion no valida para editar banco", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a imoLote entity.
     *
     * @Route("/{id}", name="imolote_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ImoLote $imoLote)
    {
        $form = $this->createDeleteForm($imoLote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($imoLote);
            $em->flush();
        }

        return $this->redirectToRoute('imolote_index');
    }

    /**
     * Creates a form to delete a imoLote entity.
     *
     * @param ImoLote $imoLote The imoLote entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ImoLote $imoLote)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('imolote_delete', array('id' => $imoLote->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

     /**
     * Lists all loteInsumo entities.
     *
     * @Route("/search/organismotransito/modulo", name="imolote_search_organismotransito_modulo")
     * @Method({"GET", "POST"})
     */
    public function searchByOrganismoTransitoAndModuloAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) { 
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $idOrganismoTransito = (isset($params->idOrganismoTransito)) ? $params->idOrganismoTransito : null;
            $tipo = (isset($params->tipo)) ? $params->tipo : null;
            $idModulo = (isset($params->idModulo)) ? $params->idModulo : null;

            if ($tipo) {
                if (!$idModulo) {
                    $loteInsumo = $em->getRepository('JHWEBInsumoBundle:ImoLote')->findBy(
                        array(
                            'estado' => 'REGISTRADO',
                            'sedeOperativa'=> $idOrganismoTransito,
                            'tipoInsumo' => $tipo,
                        )
                    );
                } else {
                    $loteInsumo = $em->getRepository('JHWEBInsumoBundle:ImoLote')->getByOrganismoTransitoAndModuloAndTipo(
                        $idOrganismoTransito,
                        $idModulo,
                        $tipo
                    );
                }
            }else {            
                if ($idOrganismoTransito) {
                    $loteInsumo = $em->getRepository('JHWEBInsumoBundle:ImoLote')->getByOrganismoTransitoAndModulo(
                        $idOrganismoTransito,
                        $params->tipoInsumo,
                        $idModulo
                    );
                }else{
                    $loteInsumo = $em->getRepository('JHWEBInsumoBundle:ImoLote')->getTotalByTipoInsumo(
                        'REGISTRADO',
                        $params->tipoInsumo
                    );
                    
                    $loteInsumo = array(
                        'id'=> $loteInsumo['idLote'],
                        'tipoInsumo'=>array(
                            'id' => $loteInsumo['idTipoInsumo'],
                            'nombre' => $loteInsumo['nombre'],
                        ),
                        'cantidad' => $loteInsumo['cantidad']
                    );
                }
            }

            if ($loteInsumo) { 
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'data' => $loteInsumo, 
                    'message' => "Lote encontrado con exito", 
                );
            }else{
                $response = array( 
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No hay sustratos para la sede", 
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
     * Lists all loteInsumo entities.
     *
     * @Route("/reasignacion/insumo/lote/sede", name="imolote_reasigancion_Sede_index")
     * @Method({"GET", "POST"})
     */
    public function loteInsumoSedeReasignacionAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) { 
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $idOrganismoTransito = (isset($params->idOrganismoTransito)) ? $params->idOrganismoTransito : null;
            $tipo = (isset($params->tipoInsumo)) ? $params->tipoInsumo : null;

            $loteInsumos = $em->getRepository('JHWEBInsumoBundle:ImoLote')->findBy(
                array(
                    'estado' => 'ASIGNADO',
                    'sedeOperativa'=> $idOrganismoTransito,
                    'tipoInsumo'=> $tipo
                )
            );

            $lotesDisponibles = null;

            foreach ($loteInsumos as $key => $lote) {
                $insumos = $em->getRepository('JHWEBInsumoBundle:ImoInsumo')->findBy(
                    array('lote' => $lote->getId(),'estado'=> 'DISPONIBLE')
                );
                if (count($insumos) == $lote->getCantidad()) {
                    $lotesDisponibles[]=$lote;
                }
            }

            if ($lotesDisponibles != null) { 
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Lote encontrado con exito", 
                    'data' => $lotesDisponibles, 
                );
            }else{
                $response = array( 
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No se encontró un lote para reasignar", 
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
     * @Route("/{numeroActa}/{idOrganismoTransito}/pdf/acta/asignacion", name="imolote_pdf_acta_asignacion")
     * @Method({"GET", "POST"})
     */
    public function pdfAction(Request $request, $numeroActa, $idOrganismoTransito)
    {
        $em = $this->getDoctrine()->getManager();

        setlocale(LC_ALL,"es_ES");
        $fechaActual = strftime("%d de %B del %Y");

        $funcionario = null;
        
        $sustratosActa = $em->getRepository('JHWEBInsumoBundle:ImoLote')->findByNumeroActaEntrega($numeroActa);

        $insumosActa = $em->getRepository('JHWEBInsumoBundle:ImoInsumo')->getByNumeroActa(
            $numeroActa
        );

        if ($insumosActa) {
            $asignacion = $em->getRepository('JHWEBInsumoBundle:ImoAsignacion')->findOneByInsumo(
                $insumosActa[0]->getId()
            );
            $funcionario = $asignacion->getFuncionario();
        }

        $organismoTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find($idOrganismoTransito);

        if ($sustratosActa) {
            $insumo = $em->getRepository('JHWEBInsumoBundle:ImoInsumo')->findOneByActaEntrega($numeroActa);
            $fechaEntrega = $insumo->getFecha();

            $asignacion = $em->getRepository('JHWEBInsumoBundle:ImoAsignacion')->findOneByInsumo(
                $insumo->getId()
            );
            $funcionario = $asignacion->getFuncionario();
        }else{
            $fechaEntrega = $insumosActa[0]->getFecha();
        }

        $html = $this->renderView('@JHWEBInsumo/Default/pdf.acta.asignacion.html.twig', array(
            'sustratosActa' => $sustratosActa,
            'insumosActa' => $insumosActa,
            'funcionario' => $funcionario,
            'numeroActa' => $numeroActa, 
            'organismoTransito' => $organismoTransito, 
            'fechaEntrega' => $fechaEntrega,
        )); 
 
        $this->get('app.pdf')->templateAsignacion($html, $numeroActa); 
    }

    /**
     * Busca todos los lotes pro organismo de transito.
     *
     * @Route("/search/fechas", name="imolote_search_fechas")
     * @Method("POST")
     */
    public function searchByFechas(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        
        if ($authCheck== true) { 
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $fechaInicial = new \Datetime($params->fechaInicial);
            $fechaFinal = new \Datetime($params->fechaFinal);
        
            $loteInsumos = $em->getRepository('JHWEBInsumoBundle:ImoLote')->getByFechasAndTipo(
                $fechaInicial,
                $fechaFinal,
                'INSUMO'
            );
            
            $loteSustratos = $em->getRepository('JHWEBInsumoBundle:ImoLote')->getByFechasAndTipo(
                $fechaInicial,
                $fechaFinal,
                'SUSTRATO'
            );

            $totalesTipo = $em->getRepository('JHWEBInsumoBundle:ImoLote')->getTotalesByTipo(
                $fechaInicial,
                $fechaFinal,
                'INSUMO'
            );
            
            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => count($loteInsumos)+count($loteSustratos)." registros encontrados", 
                'data'=> array(
                    'loteInsumos' =>  $loteInsumos, 
                    'loteSustratos' =>  $loteSustratos, 
                    'totalesTipo' =>  $totalesTipo, 
                )
            );
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
