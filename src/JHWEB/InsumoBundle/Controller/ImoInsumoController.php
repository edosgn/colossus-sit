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
            $json = $request->get("json",null);
            $params = json_decode($json);

            $fecha = new \DateTime($params->asignacionInsumos->fecha);
            $em = $this->getDoctrine()->getManager();


            $sedeOperativa = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find($params->asignacionInsumos->sedeOperativaId);

            $imoTrazabilidad = new ImoTrazabilidad();
            $imoTrazabilidad->setOrganismoTransito($sedeOperativa);
            $imoTrazabilidad->setFecha($fecha);
            $imoTrazabilidad->setEstado('asignacion');
            $imoTrazabilidad->setActivo(1);
            $em->persist($imoTrazabilidad);
            $em->flush();
            
            
            foreach ($params->array as $key => $lote) {
                $loteInsumo = $em->getRepository('JHWEBInsumoBundle:ImoLote')->find($lote->idLote);
                $tipoInsumo = $em->getRepository('JHWEBInsumoBundle:ImoCfgTipo')->find($lote->idTipo);
                
                $loteInsumo->setEstado('ASIGNADO');
                $em->persist($loteInsumo);
                $em->flush();
                // var_dump($loteInsumo->getId());

                $desde = $loteInsumo->getRangoInicio();
                $hasta = $loteInsumo->getRangoFin();

                if ($loteInsumo->getTipo() == 'Sustrato') {
                    while ($desde <= $hasta) {
                        $insumo = new ImoInsumo();
                        $em = $this->getDoctrine()->getManager();
                        $insumo->setNumero($tipoInsumo->getModulo()->getSiglaSustrato().$desde);
                        $insumo->setOrganismoTransito($sedeOperativa);
                        $insumo->setTipo($tipoInsumo);
                        $insumo->setLote($loteInsumo); 
                        $insumo->setFecha($fecha);
                        $insumo->setCategoria('sustrato');
                        $insumo->setEstado('disponible');
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
                        'message' => "Insumo creado con exito",
                    );
                    
                }else{
                    $insumo = new ImoInsumo();
                    $insumo->setLote($loteInsumo);
                    $insumo->setTipo($tipoInsumo);
                    $insumo->setEstado('disponible');
                    $insumo->setOrganismoTransito($sedeOperativa);
                    $insumo->setFecha($fecha);
                    $insumo->setCategoria('insumo');
                    $em->persist($insumo);
                    $em->flush();
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "insumo creado con exito", 
                    );
                }
                
            }
            // die();

              
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
            $insumo = $em->getRepository('AppBundle:Insumo')->find($id);

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
     * @Route("/showInsumo/numero/modulo", name="insumo_show_numero")
     * @Method({"GET", "POST"})
     */
    public function showNumeroAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            $sustrato = $em->getRepository('AppBundle:Insumo')->getNumeroModulo(
                $params->numero,$params->idModulo,$params->idSedeOperativa
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
     * @Route("/isExistencia", name="insumo_isExistencia")
     * @Method({"GET", "POST"})
     */
    public function isExistenciaAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $json = $request->get("json",null);
        $params = json_decode($json);
        $insumos = $em->getRepository('AppBundle:Insumo')->findBy(
            array('tipo'=>'Sustrato','estado' => 'disponible','casoInsumo'=>$params->casoInsumo,'sedeOperativa'=>$params->sedeOrigen)
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
     * @Route("/reasignacionSustrato", name="insumo_reasignacionSustrato")
     * @Method({"GET", "POST"})
     */
    public function reasignacionByTypeSustratoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager(); 
        $json = $request->get("json",null);
        $params = json_decode($json);

        $sustratos = $em->getRepository('AppBundle:Insumo')->findBy(
            array('tipo'=>'sustrato','estado' => 'disponible','casoInsumo'=>$params->casoInsumo,'sedeOperativa'=>$params->sedeOrigen), 
            array('id' => 'DESC'),$params->cantidad
        );

        $fecha = new \DateTime('now');

        $sedeOperativa = $em->getRepository('AppBundle:SedeOperativa')->find($params->sedeDestino);

        $imoTrazabilidad = new ImoTrazabilidad();

        $imoTrazabilidad->setSedeOperativa($sedeOperativa);
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
        $json = $request->get("json",null);
        $params = json_decode($json);

        
        $numeroSustrato = $em->getRepository('AppBundle:Insumo')->getLastByFuncionario($params->sedeOperativa);
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


}
