<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MsvEvaluacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


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
        $evaluaciones = $em->getRepository('AppBundle:MsvEvaluacion')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($evaluaciones) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($evaluaciones) . " registros encontrados",
                'data' => $evaluaciones,
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a new msvEvaluacion entity.
     *
     * @Route("/new", name="msvevaluacion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
    $helpers = $this->get("app.helpers");
    $hash = $request->get("authorization", null);
    $authCheck = $helpers->authCheck($hash);

    if ($authCheck == true) {
        $json = $request->get("json", null);
        $params = json_decode($json);

        $msvEvaluacion = new MsvEvaluacion();
        $em = $this->getDoctrine()->getManager();

        $msvEvaluacion->setFecha(new \Datetime(date('Y-m-d h:i:s')));
        $idEmpresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->find($params->idEmpresa);
        $msvEvaluacion->setEmpresa($idEmpresa);

        $revision = $em->getRepository('AppBundle:MsvRevision')->find($params->idRevision);
        
        if($revision){
            $revision->setEvaluacion($msvEvaluacion);
            $em->persist($revision);
        }
        $msvEvaluacion->setRevision($revision);
        
        $msvEvaluacion->setPilarFortalecimiento("FORTALECIMIENTO EN LA GESTIÓN INSTITUCIONAL");
        $msvEvaluacion->setValorObtenidoFortalecimiento($params->valorObtenidoFortalecimiento);
        $msvEvaluacion->setValorPonderadoFortalecimiento(0.3);
        $valorResultadoFortalecimiento = $params->valorObtenidoFortalecimiento * 0.3;
        $msvEvaluacion->setResultadoFortalecimiento($valorResultadoFortalecimiento);

        $msvEvaluacion->setPilarComportamiento("COMPORTAMIENTO HUMANO");
        $msvEvaluacion->setValorObtenidoComportamiento($params->valorObtenidoComportamiento);
        $msvEvaluacion->setValorPonderadoComportamiento(0.3);
        $valorResultadoComportamiento = $params->valorObtenidoComportamiento * 0.3;
        $msvEvaluacion->setResultadoComportamiento($valorResultadoComportamiento);

        $msvEvaluacion->setPilarVehiculoSeguro("VEHÍCULOS SEGUROS");
        $msvEvaluacion->setValorObtenidoVehiculoSeguro($params->valorObtenidoVehiculoSeguro);
        $msvEvaluacion->setValorPonderadoVehiculoSeguro(0.2);
        $valorResultadoVehiculoSeguro = $params->valorObtenidoVehiculoSeguro * 0.2;
        $msvEvaluacion->setResultadoVehiculoSeguro($valorResultadoVehiculoSeguro);

        $msvEvaluacion->setPilarInfraestructuraSegura("INFRAESTRUCTURA SEGURA ");
        $msvEvaluacion->setValorObtenidoInfraestructuraSegura($params->valorObtenidoInfraestructuraSegura);
        $msvEvaluacion->setValorPonderadoInfraestructuraSegura(0.1);
        $valorResultadoInfraestructuraSegura = $params->valorObtenidoInfraestructuraSegura * 0.1;
        $msvEvaluacion->setResultadoInfraestructuraSegura($valorResultadoInfraestructuraSegura);

        $msvEvaluacion->setPilarAtencionVictima("ATENCIÓN A VÍCTIMAS");
        $msvEvaluacion->setValorObtenidoAtencionVictima($params->valorObtenidoAtencionVictima);
        $msvEvaluacion->setValorPonderadoAtencionVictima(0.1);
        $valorResultadoAtencionVictima = $params->valorObtenidoAtencionVictima * 0.1;
        $msvEvaluacion->setResultadoAtencionVictima($valorResultadoAtencionVictima);

        $msvEvaluacion->setPilarValorAgregado("VALORES AGREGADOS O INNOVACIONES");
        $msvEvaluacion->setValorObtenidoValorAgregado($params->valorObtenidoValorAgregado);
        $msvEvaluacion->setValorPonderadoValorAgregado(0.05);
        $valorResultadoValorAgregado = $params->valorObtenidoValorAgregado * 0.05;
        $msvEvaluacion->setResultadoValorAgregado($valorResultadoValorAgregado);

        $resultadoFinal = $valorResultadoFortalecimiento + $valorResultadoComportamiento + $valorResultadoVehiculoSeguro + $valorResultadoInfraestructuraSegura + $valorResultadoAtencionVictima + $valorResultadoValorAgregado;

        $msvEvaluacion->setResultadoFinal($resultadoFinal);

        $minimoAval = 95 * 0.75;
        if ($resultadoFinal >= $minimoAval) {
            $msvEvaluacion->setAval(true);
        } else {
            $msvEvaluacion->setAval(false);
        }
        $msvEvaluacion->setActivo(true);
        $em->persist($msvEvaluacion);
        $em->flush();

        if ($resultadoFinal >= $minimoAval) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Los datos han sido registrados exitosamente.",
                'message2' => "El resultado final es: " . $resultadoFinal . ", cumple con el aval.",
                'puntajeEvaluacion' => $resultadoFinal,
            );
        } else {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Los datos han sido registrados exitosamente.",
                'message2' => "El resultado final es: " . $resultadoFinal . ", no cumple con el aval.",
                'puntajeEvaluacion' => $resultadoFinal,
            );

        }
    } else {
        $response = array(
            'status' => 'error',
            'code' => 400,
            'message' => "Autorización no válida",
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

    /**
     * @Route("/find/aval/evaluacion", name="msvevaluacion_aval")
     * @Method({"GET","POST"})
     */
    public function findAvalByEvaluacionAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            
            $evaluacion = $em->getRepository('AppBundle:MsvEvaluacion')->findOneBy(array('revision' => $params->id));

            $response['data'] = array();

            if ($evaluacion) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' =>"Registro encontrado",
                    'data' => $evaluacion,
                );
            }
            return $helpers->json($response);
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida",
            );
        }
        return $helpers->json($response);
    }
}
