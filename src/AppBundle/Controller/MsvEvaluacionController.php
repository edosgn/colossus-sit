<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MsvEvaluacion;
use AppBundle\Entity\MsvCategoria;
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

        $em = $this->getDoctrine()->getManager();
        $msvEvaluacion = new MsvEvaluacion();

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
        $msvEvaluacion->setResultadoFortalecimiento(number_format($valorResultadoFortalecimiento), 2, '.');

        $msvEvaluacion->setPilarComportamiento("COMPORTAMIENTO HUMANO");
        $msvEvaluacion->setValorObtenidoComportamiento($params->valorObtenidoComportamiento);
        $msvEvaluacion->setValorPonderadoComportamiento(0.3);
        $valorResultadoComportamiento = $params->valorObtenidoComportamiento * 0.3;
        $msvEvaluacion->setResultadoComportamiento(number_format($valorResultadoComportamiento), 2, '.');

        $msvEvaluacion->setPilarVehiculoSeguro("VEHÍCULOS SEGUROS");
        $msvEvaluacion->setValorObtenidoVehiculoSeguro($params->valorObtenidoVehiculoSeguro);
        $msvEvaluacion->setValorPonderadoVehiculoSeguro(0.2);
        $valorResultadoVehiculoSeguro = $params->valorObtenidoVehiculoSeguro * 0.2;
        $msvEvaluacion->setResultadoVehiculoSeguro(number_format($valorResultadoVehiculoSeguro), 2, '.');

        $msvEvaluacion->setPilarInfraestructuraSegura("INFRAESTRUCTURA SEGURA ");
        $msvEvaluacion->setValorObtenidoInfraestructuraSegura($params->valorObtenidoInfraestructuraSegura);
        $msvEvaluacion->setValorPonderadoInfraestructuraSegura(0.1);
        $valorResultadoInfraestructuraSegura = $params->valorObtenidoInfraestructuraSegura * 0.1;
        $msvEvaluacion->setResultadoInfraestructuraSegura(number_format($valorResultadoInfraestructuraSegura), 2, '.');

        $msvEvaluacion->setPilarAtencionVictima("ATENCIÓN A VÍCTIMAS");
        $msvEvaluacion->setValorObtenidoAtencionVictima($params->valorObtenidoAtencionVictima);
        $msvEvaluacion->setValorPonderadoAtencionVictima(0.1);
        $valorResultadoAtencionVictima = $params->valorObtenidoAtencionVictima * 0.1;
        $msvEvaluacion->setResultadoAtencionVictima(number_format($valorResultadoAtencionVictima), 2, '.');

        $datosValorAgregadoArray= (array)$params->datosValorAgregado;
        
        $msvEvaluacion->setPilarValorAgregado(implode(",", $datosValorAgregadoArray));
        $msvEvaluacion->setValorObtenidoValorAgregado($params->valorObtenidoValorAgregado);
        $msvEvaluacion->setValorPonderadoValorAgregado(0.05);
        $valorResultadoValorAgregado = $params->valorObtenidoValorAgregado * 0.05;
        $msvEvaluacion->setResultadoValorAgregado(number_format($valorResultadoValorAgregado), 2, '.');

        $resultadoFinal = $valorResultadoFortalecimiento + $valorResultadoComportamiento + $valorResultadoVehiculoSeguro + $valorResultadoInfraestructuraSegura + $valorResultadoAtencionVictima + $valorResultadoValorAgregado;

        $msvEvaluacion->setResultadoFinal(number_format($resultadoFinal), 2, '.');

        $minimoAval = 95 * 0.75;
        if ($resultadoFinal >= $minimoAval) {
            $msvEvaluacion->setAval(true);
        } else {
            $msvEvaluacion->setAval(false);
        }
        $msvEvaluacion->setActivo(true);

        //volver a esta habilitado todas las categorias de la evaluación
        $categorias = $em->getRepository('AppBundle:MsvCategoria')->findBy(
            array(
                'activo' => 1,
                'habilitado' => 0,
            )
        );

        foreach ($categorias as $key => $categoria) {
            $categoria->setHabilitado(true);
            $em->persist($categoria);
        }

        $em->persist($msvEvaluacion);
        $em->flush();

        if ($resultadoFinal >= $minimoAval) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Los datos han sido registrados exitosamente. <br> El resultado final es: " . $resultadoFinal . ", cumple con el aval.",
                'data' => $msvEvaluacion,
            );
        } else {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Los datos han sido registrados exitosamente. <br> El resultado final es: " . $resultadoFinal . ", no cumple con el aval.",
                'data' => $msvEvaluacion,
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
                    'message' => "Evaluacion encontrada",
                    'data' => $evaluacion,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 401,
                    'message'=> "Evaluación no encontrada",
                );
            }
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message'=> "Autorización no valida",
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
                 'message' => "Evaluación editada con éxito.", 
             );
            }else{
             $response = array(
                 'status' => 'error',
                 'code' => 400,
                 'message' => "La evaluación no se encuentra en la base de datos", 
             );
            }
        }
        else{
         $response = array(
             'status' => 'error',
             'code' => 400,
             'message' => "Autorización no valida para editar banco", 
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
                    'message' => "Evaluación eliminada con éxito", 
            );
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

    /**
     * Genera pdf del aval o no aval de una evaluacion.
     *
     * @Route("/{idUsuario}/{id}/aval/pdf", name="aval_pdf")
     * @Method({"GET","POST"})
     */
    public function pdfAction(Request $request, $id, $idUsuario)
    {        
        $em = $this->getDoctrine()->getManager();
        
        setlocale(LC_ALL, "es_ES");
        $fechaActual = strftime("%d de %B del %Y");

        $evaluacion = $em->getRepository('AppBundle:MsvEvaluacion')->find($id);

        $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->find($idUsuario);

        if ($ciudadano) {
            $funcionario = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->findOneBy(
                array(
                    'ciudadano' => $ciudadano->getId(),
                    'activo' => true,
                )
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'EL registro no existe en la base de datos.',
            );
        }
        switch ($evaluacion->getAval()) {
            case true:
                $html = $this->renderView('@App/msvEvaluacion/pdfAval.template.html.twig', array(
                    'fechaActual' => $fechaActual,
                    'evaluacion' => $evaluacion,
                    'funcionario' => $funcionario,
                ));
                break;        
            case false:
                $html = $this->renderView('@App/msvEvaluacion/pdfNoAval.template.html.twig', array(
                    'fechaActual' => $fechaActual,
                    'evaluacion' => $evaluacion,
                    'funcionario' => $funcionario,
                ));
                break;
        }

        $this->get('app.pdf')->templateEvaluacion($html, $evaluacion);
    }

    /**
     * Displays a form to edit an existing msvevaluacion entity.
     *
     * @Route("/{id}/calificacion/pdf", name="msvevaluacion_pdf_calificacion")
     * @Method({"GET", "POST"})
     */
    public function shoyCalificacionByEvaluacionAction($id)
    {
            $em = $this->getDoctrine()->getManager();

            setlocale(LC_ALL, "es_ES");
            $fechaActual = strftime("%d de %B del %Y");

            $revision = $em->getRepository('AppBundle:MsvRevision')->find($id);
            $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->find($revision->getEmpresa());
 
            $calificaciones = $em->getRepository('AppBundle:MsvCalificacion')->findBy(
                array(
                    'revision' => $revision,
                    'estado' => true,
                )
            );

            foreach ($calificaciones as $key => $calificacion) {
                # code...
                switch ($calificacion->getCriterio()->getVariable()->getParametro()->getCategoria()->getId()) {
                    case 1:
                        # code...
                        $calificacionesFortalecimiento[] = array(
                            'calif' => $calificacion,
                        );
                        break;
                    case 2:
                        $calificacionesComportamiento[] = array(
                            'calif' => $calificacion,
                        );
                        break;
                    case 3:
                        $calificacionesVehiculoSeguro[] = array(
                            'calif' => $calificacion,
                        );
                        break;
                    case 4:
                        $calificacionesInfraestructuraSegura[] = array(
                            'calif' => $calificacion,
                        );
                        break;
                    case 5:
                        $calificacionesAtencionVictima[] = array(
                            'calif' => $calificacion,
                        );
                        break;
                }
            }

            $html = $this->renderView('@App/msvEvaluacion/pdf.calificacion.evaluacion.html.twig', array(
                'fechaActual' => $fechaActual,
                'empresa' => $empresa,
                'calificacionesFortalecimiento' => $calificacionesFortalecimiento,
                'calificacionesComportamiento' => $calificacionesComportamiento,
                'calificacionesVehiculoSeguro' => $calificacionesVehiculoSeguro,
                'calificacionesInfraestructuraSegura' => $calificacionesInfraestructuraSegura,
                'calificacionesAtencionVictima' => $calificacionesAtencionVictima,
        ));

        $this->get('app.pdf')->templateCalificacion($html, $empresa); 
        
    }
}
