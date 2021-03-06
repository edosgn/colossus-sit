<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Insumo;
use JHWEB\InsumoBundle\Entity\ImoTrazabilidad;
use JHWEB\InsumoBundle\Entity\ImoAsignacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Insumo controller.
 *
 * @Route("insumo")
 */
class InsumoController extends Controller
{
    /**
     * Lists all insumo entities.
     *
     * @Route("/sustrato", name="insumo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $insumos = $em->getRepository('AppBundle:Insumo')->findBy(
            array('estado' => 'disponible','tipo'=>'sustrato')
        );

        $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado lineas", 
                    'data'=> $insumos,
            );
         
        return $helpers->json($response);
    }

    /**
     * Lists all insumo entities.
     *
     * @Route("/insumo", name="insumoInsumos_index")
     * @Method("GET")
     */
    public function indexInsumoAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $insumos = $em->getRepository('AppBundle:Insumo')->findBy(
            array('estado' => 'disponible','tipo'=>'insumo')
        );

        $response = array(
                    'status' => 'success',
                    'code' => 200, 
                    'msj' => "listado lineas", 
                    'data'=> $insumos,
            );
         
        return $helpers->json($response);
    }

    /**
     * Creates a new insumo entity.
     *
     * @Route("/new", name="insumo_new")
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


            $fecha = $params->fecha;
            $fecha = new \DateTime($params->fecha);
           
            
            $em = $this->getDoctrine()->getManager();

            $rangoInicio = (isset($params->rangoInicio)) ? $params->rangoInicio : null;

            // var_dump($params->sedeOperativaId);
            // die();
            $sedeOperativa = $em->getRepository('AppBundle:SedeOperativa')->find($params->sedeOperativaId);
            $loteInsumo = $em->getRepository('AppBundle:LoteInsumo')->find($params->loteInsumoId);

            $loteInsumo->setEstado('ASIGNADO');
            $em->persist($loteInsumo);
            $em->flush();
            
            if ($rangoInicio) {
                $imoTrazabilidad = new ImoTrazabilidad();
                $imoTrazabilidad->setSedeOperativa($sedeOperativa);
                $imoTrazabilidad->setFecha($fecha);
                $imoTrazabilidad->setEstado('asignacion');
                $imoTrazabilidad->setActivo(1);
                $em->persist($imoTrazabilidad);
                $em->flush();
                $desde = $params->rangoInicio;
                $hasta = $params->rangoFin;
                
                while ($desde <= $hasta) {
                    
                    
                    $insumo = new Insumo();
                    $em = $this->getDoctrine()->getManager();
                    $casoInsumo = $em->getRepository('AppBundle:CasoInsumo')->find($params->casoInsumoId);
                    
                    $insumo->setNumero($casoInsumo->getModulo()->getSiglaSustrato().$desde);
                    $insumo->setSedeOperativa($sedeOperativa);
                    $insumo->setCasoInsumo($casoInsumo);
                    $insumo->setLoteInsumo($loteInsumo); 
                    $insumo->setFecha($fecha);
                    $insumo->setTipo('sustrato');
                    $insumo->setEstado('disponible');
                    $em->persist($insumo);
                    $em->flush();

                    $imoAsignacion = new ImoAsignacion();

                    $imoAsignacion->setImotrazabilidad($imoTrazabilidad);
                    $imoAsignacion->setInsumo($insumo);
                    $imoAsignacion->setActivo(true);
                    $em->persist($imoAsignacion);
                    $em->flush();
                    $desde++;
                }
                
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "insumo creado con exito", 
                );
                
            }else{
                $insumo = new Insumo();
                $casoInsumo = $em->getRepository('AppBundle:CasoInsumo')->find($params->casoInsumoId);
                $insumo->setLoteInsumo($loteInsumo);
                $insumo->setCasoInsumo($casoInsumo); 
                $insumo->setEstado('disponible');
                $insumo->setNumero($params->numero);
                $insumo->setSedeOperativa($sedeOperativa);
                $insumo->setFecha($fecha);
                $insumo->setTipo('insumo');
                $em->persist($insumo);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "insumo creado con exito", 
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
     * Finds and displays a insumo entity.
     *
     * @Route("/{id}/show", name="insumo_show")
     * @Method("GET")
     */
    public function showAction(Insumo $insumo)
    {
        $deleteForm = $this->createDeleteForm($insumo);

        return $this->render('insumo/show.html.twig', array(
            'insumo' => $insumo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Finds and displays a insumo entity.
     *
     * @Route("/show/loteInsumo", name="insumo_show_loteInsumo")
     * @Method({"GET", "POST"})
     */
    public function showLoteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck== true) {
            $em = $this->getDoctrine()->getManager();
            $insumos = $em->getRepository('AppBundle:Insumo')->findBy(
                array('tipo'=>'sustrato',)
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
     * Displays a form to edit an existing insumo entity.
     *
     * @Route("/{id}/edit", name="insumo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Insumo $insumo)
    {
        $deleteForm = $this->createDeleteForm($insumo);
        $editForm = $this->createForm('AppBundle\Form\InsumoType', $insumo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('insumo_edit', array('id' => $insumo->getId()));
        }

        return $this->render('insumo/edit.html.twig', array(
            'insumo' => $insumo,
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
                        'msj' => "insumo eliminado con exito", 
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
     * Creates a form to delete a insumo entity.
     *
     * @param Insumo $insumo The insumo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Insumo $insumo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('insumo_delete', array('id' => $insumo->getId())))
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
            // var_dump($params);
            // die();
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
                        'msj'=> 'sustrato no encontrado',
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
