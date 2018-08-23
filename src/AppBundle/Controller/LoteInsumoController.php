<?php

namespace AppBundle\Controller;

use AppBundle\Entity\LoteInsumo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Loteinsumo controller.
 *
 * @Route("loteinsumo")
 */
class LoteInsumoController extends Controller
{
    /**
     * Lists all loteInsumo entities.
     *
     * @Route("/sustrato", name="loteinsumo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $loteInsumos = $em->getRepository('AppBundle:LoteInsumo')->findBy(
            array('estado' => 'registrado','sedeOperativa'=>!null)
        );

        $response['data'] = array();

        $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado lineas", 
                    'data'=> $loteInsumos,
            );
         
        return $helpers->json($response);
    }

    /**
     * Lists all loteInsumo entities.
     *
     * @Route("/insumo", name="loteinsumoInsumos_index")
     * @Method("GET")
     */
    public function indexInsumoAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $loteInsumos = $em->getRepository('AppBundle:LoteInsumo')->findBy(
            array('estado' => 'registrado','sedeOperativa'=>null)
        );

        $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado lineas", 
                    'data'=> $loteInsumos,
            );
         
        return $helpers->json($response);
    }

    /**
     * Creates a new loteInsumo entity.
     *
     * @Route("/new", name="loteinsumo_new")
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
            // $observacion = $params->observacion;
            // $bancoId = $params->bancoId;
            
            $em = $this->getDoctrine()->getManager();
            $empresa = $em->getRepository('AppBundle:Empresa')->find($params->empresaId);

            $sedeOperativaId = (isset($params->sedeOperativaId)) ? $params->sedeOperativaId : null;

            $loteInsumo = new LoteInsumo();
            if ($sedeOperativaId) {
                $sedeOperativa = $em->getRepository('AppBundle:SedeOperativa')->find($sedeOperativaId);
                $loteInsumo->setSedeOperativa($sedeOperativa);
                
            }
            $casoInsumo = $em->getRepository('AppBundle:CasoInsumo')->find($params->casoInsumoId);

            $loteInsumo->setNumeroActa($params->numeroActa);
            $loteInsumo->setEmpresa($empresa);
            $loteInsumo->setCasoInsumo($casoInsumo); 
            $loteInsumo->setEstado('registrado');
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
                'msj' => "loteInsumo creado con exito", 
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
     * Finds and displays a loteInsumo entity.
     *
     * @Route("/{id}", name="loteinsumo_show")
     * @Method("GET")
     */
    public function showAction(LoteInsumo $loteInsumo)
    {
        $deleteForm = $this->createDeleteForm($loteInsumo);

        return $this->render('loteinsumo/show.html.twig', array(
            'loteInsumo' => $loteInsumo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Linea entity.
     *
     * @Route("/edit", name="loteinsumo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("json",null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            $loteInsumo = $em->getRepository('AppBundle:LoteInsumo')->find($params->id);
            
            $empresa = $em->getRepository('AppBundle:Empresa')->find($params->empresaId);

            $sedeOperativaId = (isset($params->sedeOperativaId)) ? $params->sedeOperativaId : null;

            if ($sedeOperativaId) {
                $sedeOperativa = $em->getRepository('AppBundle:SedeOperativa')->find($sedeOperativaId);
                $loteInsumo->setSedeOperativa($sedeOperativa);
                
            }
            $casoInsumo = $em->getRepository('AppBundle:CasoInsumo')->find($params->casoInsumoId);

            
            if ($loteInsumo!=null) {

                $loteInsumo->setNumeroActa($params->numeroActa);
                $loteInsumo->setEmpresa($empresa);
                $loteInsumo->setCasoInsumo($casoInsumo); 
                $loteInsumo->setRangoInicio($params->rangoInicio);
                $loteInsumo->setRangoFin($params->rangoFin);
                $loteInsumo->setCantidad($params->cantidad);
                $loteInsumo->setReferencia($params->referencia);
                $em->persist($loteInsumo);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "linea editada con exito", 
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "La linea no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar banco", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a loteInsumo entity.
     *
     * @Route("/{id}", name="loteinsumo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, LoteInsumo $loteInsumo)
    {
        $form = $this->createDeleteForm($loteInsumo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($loteInsumo);
            $em->flush();
        }

        return $this->redirectToRoute('loteinsumo_index');
    }

    /**
     * Creates a form to delete a loteInsumo entity.
     *
     * @param LoteInsumo $loteInsumo The loteInsumo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(LoteInsumo $loteInsumo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('loteinsumo_delete', array('id' => $loteInsumo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Lists all loteInsumo entities.
     *
     * @Route("/insumo/lote/sede", name="loteinsumoInsumosSede_index")
     * @Method({"GET", "POST"})
     */
    public function loteInsumoSedeAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck== true) { 
            $json = $request->get("json",null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            $loteInsumo = $em->getRepository('AppBundle:LoteInsumo')->findOneBy(
                array('estado' => 'registrado','sedeOperativa'=> $params->sedeOperativa,'casoInsumo'=>$params->casoInsumo)
            );
            if ($loteInsumo!=null) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Lote encontrado con exito", 
                    'data' => $loteInsumo, 
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "no hay sustratos pa la sede", 
                );
            }
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida para editar banco", 
            );
        }
        return $helpers->json($response);
    }


    /**
     * Lists all loteInsumo entities.
     *
     * @Route("/insumo/lote/sedeOperativa", name="loteinsumoInsumosSedeOperativa_index")
     * @Method({"GET", "POST"})
     */
    public function loteInsumoSedeOperativaAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck== true) { 
            $json = $request->get("json",null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            $lotesInsumo = $em->getRepository('AppBundle:LoteInsumo')->findBy(
                array('estado' => 'registrado','sedeOperativa'=> $params->sedeOperativa,'estado'=>'asignado')
            );
            if ($lotesInsumo!=null) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Lote encontrado con exito", 
                    'data' => $lotesInsumo, 
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "no hay sustratos pa la sede", 
                );
            }
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida para editar banco", 
            );
        }
        return $helpers->json($response);
    }

    /**
     * Lists all loteInsumo entities.
     *
     * @Route("/insumo/lote/insumo", name="loteinsumoInsumosInsumo_index")
     * @Method({"GET", "POST"})
     */
    public function loteInsumoInsumoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck== true) {
            $json = $request->get("json",null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            $loteInsumo = $em->getRepository('AppBundle:LoteInsumo')->findOneBy(
                array('estado' => 'registrado','sedeOperativa'=> null,'casoInsumo'=>$params->casoInsumo)
            );
            if ($loteInsumo!=null) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Lote encontrado con exito", 
                    'data' => $loteInsumo, 
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "no hay sustratos pa la sede", 
                );
            }
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida para editar banco", 
            );
        }
        return $helpers->json($response);
    }
}
