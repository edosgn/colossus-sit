<?php

namespace JHWEB\InsumoBundle\Controller;

use JHWEB\InsumoBundle\Entity\ImoInsumo;
use JHWEB\InsumoBundle\Entity\ImoTrazabilidad;
use JHWEB\InsumoBundle\Entity\ImoAsignacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

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
     * @Route("/{id}/delete", name="insumo_delete")
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

            $insumo->setEstado('dañado');
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
            array('tipo'=>'Sustrato','estado' => 'disponible','tipo'=>$params->casoInsumo,'organismoTransito'=>$params->sedeOrigen), 
            array('id' => 'DESC'),$params->cantidad
        );

        $fecha = new \DateTime('now');

        $organismoTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find($params->sedeDestino);

        $imoTrazabilidad = new ImoTrazabilidad();

        $imoTrazabilidad->setOrganismoTransito($organismoTransito);
        $imoTrazabilidad->setFecha($fecha);
        $imoTrazabilidad->setEstado('REASIGNACION');
        $imoTrazabilidad->setActivo(true);

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


}
