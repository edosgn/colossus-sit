<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MsvEvaluacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Msvevaluacion controller.
 *
 * @Route("msvevaluacion")
 */
class MsvEvaluacionController extends Controller
{
    /**
     * Lists all msvEvaluacion entities.
     *
     * @Route("/", name="msvevaluacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $msvEvaluaciones = $em->getRepository('AppBundle:MsvEvaluacion')->findBy(array('estado' => 1));

        $response = array(
            'status' => 'succes',
            'code' => 200,
            'msj' => "listado evaluaciones",
            'data' => $msvEvaluaciones,
        );
        return $helpers -> json($response);
    }

    /**
     * Creates a new msvEvaluacion entity.
     *
     * @Route("/new", name="msvevaluacion")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization",null);
        $authCheck = $helpers->authCheck($hash);
        if($authCheck == true){
            $json = $request->get("json",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            
                $evaluacion = new MsvEvaluacion();
                $evaluacion->setNumero($params->numero);
                $evaluacion->setParametro($params->parametro);
                $evaluacion->setItem($params->item);
                $evaluacion->setVariable($params->variable);
                $evaluacion->setCriterio($params->criterio);
                if($params->aplica == 'true'){
                    $evaluacion->setAplica(true);
                }else{
                    $evaluacion->setAplica(false);
                }
                if($params->evidencia == 'true'){
                    $evaluacion->setEvidencia(true);
                }else{
                    $evaluacion->setEvidencia(true);
                }
                if($params->responde == 'true'){
                    $evaluacion->setResponde(true);
                }else{
                    $evaluacion->setResponde(true);
                }
                $evaluacion->setObservacion($params->observacion);
                $evaluacion->setEstado(true);
                $em->persist($evaluacion);
                $em->flush();
                $response = array(
                            'status' => 'success',
                            'code' => 200,
                            'msj' => "Evaluación creada con éxito",
                );
            
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorización no valida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Finds and displays a msvEvaluacion entity.
     *
     * @Route("/{id}", name="msvevaluacion_show")
     * @Method("POST")
     */
    public function showAction(MsvEvaluacion $msvEvaluacion)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if($authCheck == true ){
            $em = $this->getDoctrine()->getManager();
            $evaluacion = $em->getRepository('AppBundle:MsvEvaluacion')->find($id);
            if($evaluacion){
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Evaluacion encontrada",
                    'data' => $evaluacion,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 401,
                    'msj'=> "Evaluación no encontrada",
                );
            }
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj'=> "Autorización no valida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing msvevaluacion entity.
     *
     * @Route("/edit", name="msvevaluacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if($authCheck==true){
            $json = $request->get("json",null);
            $params = json_decode($json);  
 
            $em = $this->getDoctrine()->getManager();
            $evaluacion = $em->getRepository('AppBundle:MsvEvaluacion')->find($params->id);
            if($evaluacion != null){
                $evaluacion->setNumero($params->numero);
                $evaluacion->setParametro($params->parametro);
                $evaluacion->setItem($params->item);
                $evaluacion->setVariable($params->variable);
                $evaluacion->setCriterio($params->criterio);
                if($params->aplica == 'true'){
                    $evaluacion->setAplica(true);
                }else{
                    $evaluacion->setAplica(false);
                }
                if($params->evidencia == 'true'){
                    $evaluacion->setEvidencia(true);
                }else{
                    $evaluacion->setEvidencia(true);
                }
                if($params->responde == 'true'){
                    $evaluacion->setResponde(true);
                }else{
                    $evaluacion->setResponde(true);
                }
                $evaluacion->setOservacion($params->observacion);
                $evaluacion->setEstado(true);
                $em->persist($evaluacion);
                $em->flush();
 
                $response = array(
                 'status' => 'success',
                 'code' => 200,
                 'msj' => "Evaluación editada con éxito.", 
             );
            }else{
             $response = array(
                 'status' => 'error',
                 'code' => 400,
                 'msj' => "La evaluación no se encuentra en la base de datos", 
             );
            }
        }
        else{
         $response = array(
             'status' => 'error',
             'code' => 400,
             'msj' => "Autorización no valida para editar banco", 
         );
        }
     return $helpers->json($response);
    }

    /**
     * Deletes a msvevaluacion entity.
     *
     * @Route("/delete", name="msvevaluacion_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if($authCheck == true){
            $json = $request->get("json",null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            $evaluacion = $em->getRepository('AppBundle:MsvEvaluacion')->find($params);
            
            $evaluacion->setEstado(0);
            $em->persist($evaluacion);
            $em->flush();
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Evaluación eliminada con éxito", 
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorización no valida", 
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a msvEvaluacion entity.
     *
     * @param MsvEvaluacion $msvEvaluacion The msvEvaluacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MsvEvaluacion $msvEvaluacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('msvevaluacion_delete', array('id' => $msvEvaluacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
