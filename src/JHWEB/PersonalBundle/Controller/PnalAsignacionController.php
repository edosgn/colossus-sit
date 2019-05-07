<?php

namespace JHWEB\PersonalBundle\Controller;

use JHWEB\PersonalBundle\Entity\PnalAsignacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Pnalasignacion controller.
 *
 * @Route("pnalasignacion")
 */
class PnalAsignacionController extends Controller
{
    /**
     * Lists all pnalAsignacion entities.
     *
     * @Route("/", name="pnalasignacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        $asignaciones = $em->getRepository('JHWEBPersonalBundle:PnalAsignacion')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($asignaciones) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($asignaciones).' registros encontrados.', 
                'data'=> $asignaciones,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new pnalAsignacion entity.
     *
     * @Route("/new", name="pnalasignacion_new")
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

            $em = $this->getDoctrine()->getManager();

            $fecha = new \Datetime($params->fecha);

            $funcionario = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->find(
                $params->idFuncionario
            );

            $rangoDisponible = $em->getRepository('JHWEBPersonalBundle:PnalAsignacion')->getLastByFecha();

            if ($rangoDisponible) {
                $cantidadDisponible = $em->getRepository('JHWEBPersonalBundle:PnalAsignacion')->getCantidadDisponibleByOrganismoTransito(
                    $params->idOrganismoTransito
                );
    
                $cantidadDisponible = (empty($cantidadDisponible['total']) ? 0 : $cantidadDisponible['total']);
    
                $cantidadValidar = ($rangoDisponible->getCantidadRecibida() * 80) / 100;
                $cantidadValidar = $rangoDisponible->getCantidadRecibida() - $cantidadValidar;
    
                if ($cantidadDisponible > $cantidadValidar) {
                    $registro = $this->register($params);

                    if($registro){
                        $response = array(
                            'status' => 'success',
                            'code' => 200,
                            'message' => "El registro se ha realizado con exito",
                        );
                    }else{
                        $response = array(
                            'status' => 'error',
                            'code' => 400,
                            'message' => "El rango ya se encuentra registrado para este organismo de tránsito.", 
                        );
                    }
                }else{
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => 'No se pueden asignar nuevos rangos porque aún tiene existencias vigentes.',
                    );
                }
            }else{
                $registro = $this->register($params);

                if($registro){
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => "El registro se ha realizado con exito",
                    );
                }else{
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "El rango ya se encuentra registrado para este organismo de tránsito.", 
                    );
                }
            }
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida.', 
            );
        }

        return $helpers->json($response);
    }

    /**
     * Finds and displays a pnalAsignacion entity.
     *
     * @Route("/{id}", name="pnalasignacion_show")
     * @Method("GET")
     */
    public function showAction(PnalAsignacion $pnalAsignacion)
    {
        $deleteForm = $this->createDeleteForm($pnalAsignacion);

        return $this->render('pnalasignacion/show.html.twig', array(
            'pnalAsignacion' => $pnalAsignacion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing pnalAsignacion entity.
     *
     * @Route("/{id}/edit", name="pnalasignacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, PnalAsignacion $pnalAsignacion)
    {
        $deleteForm = $this->createDeleteForm($pnalAsignacion);
        $editForm = $this->createForm('JHWEB\PersonalBundle\Form\PnalAsignacionType', $pnalAsignacion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pnalasignacion_edit', array('id' => $pnalAsignacion->getId()));
        }

        return $this->render('pnalasignacion/edit.html.twig', array(
            'pnalAsignacion' => $pnalAsignacion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a pnalAsignacion entity.
     *
     * @Route("/{id}", name="pnalasignacion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, PnalAsignacion $pnalAsignacion)
    {
        $form = $this->createDeleteForm($pnalAsignacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pnalAsignacion);
            $em->flush();
        }

        return $this->redirectToRoute('pnalasignacion_index');
    }

    /**
     * Creates a form to delete a pnalAsignacion entity.
     *
     * @param PnalAsignacion $pnalAsignacion The pnalAsignacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PnalAsignacion $pnalAsignacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pnalasignacion_delete', array('id' => $pnalAsignacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ================================================== */

    public function register($params){
        $helpers = $this->get("app.helpers");
        
        $em = $this->getDoctrine()->getManager();

        $ultimoRango = $em->getRepository('JHWEBPersonalBundle:PnalTalonario')->getMaximoByOrganismoTransito(
            $params->idOrganismoTransito
        ); 

        if ($ultimoRango) {
            if ($params->desde <= $ultimoRango['maximo']) {
                return false;
            }
        }

        $asignacion = new PnalAsignacion();

        $funcionario = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->find(
            $params->idFuncionario
        );

        $consecutivo = $em->getRepository('JHWEBPersonalBundle:PnalAsignacion')->getMaximo(
            date('Y')
        );
           
        $consecutivo = (empty($consecutivo['maximo']) ? 1 : $consecutivo['maximo']+=1);
        $asignacion->setConsecutivo($consecutivo);

        $fechaCreacion = new \Datetime(date('Y-m-d'));
        $asignacion->setNumeroActa(
            $fechaCreacion->format('Y').$fechaCreacion->format('m').str_pad($consecutivo, 3, '0', STR_PAD_LEFT)
        );

        $asignacion->setDesde($params->desde);
        $asignacion->setHasta($params->hasta);
        $asignacion->setCantidadDisponible($params->cantidadRecibida);
        $asignacion->setCantidadRecibida($params->cantidadRecibida);
        $asignacion->setFecha($fecha);
        $asignacion->setActivo(true);
        
        $asignacion->setOrganismoTransito($funcionario->getOrganismoTransito());

        $em->persist($asignacion);
        $em->flush();

        $divipo = $funcionario->getOrganismoTransito()->getDivipo();

        for ($numero=$asignacion->getDesde(); $numero <= $asignacion->getHasta(); $numero++) {
            if ($funcionario->getOrganismoTransito()->getAsignacionRango()) {
                $numeroComparendo = $divipo.$numero;
            }else{
                $numeroComparendo = $numero;
            }
            
            $consecutivo = $em->getRepository('JHWEBPersonalBundle:PnalCfgCdoConsecutivo')->findOneByNumero(
                $numeroComparendo
            );

            if ($consecutivo) {
                $consecutivo->setAsignacion($asignacion);
                $consecutivo->setOrganismoTransito($funcionario->getOrganismoTransito());
                $consecutivo->setEstado('ASIGNADO');

                $em->flush();
            }
        }

        $response = array(
            'status' => 'success',
            'code' => 200,
            'message' => 'Registro creado con exito.',  
        );

        return true;
    }

    /**
     * Lists all mpersonalFuncionario entities.
     *
     * @Route("/search/funcionario/agente", name="pnalasignacion_search_funcionario_agente")
     * @Method({"GET", "POST"})
     */
    public function searchFuncionarioAgenteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        $funcionarios['data'] = array();

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $funcionarios = $em->getRepository('JHWEBPersonalBundle:PnalAsignacion')->getFuncionariosByCargo(
                $params, 1
            );
                
            if ($funcionarios) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Registro encontrado.', 
                    'data'=> $funcionarios,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Ningún registro encontrado.',
                );
            }            
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Autorizacion no valida.', 
                );
        }
        return $helpers->json($response);
    }

    /**
     * Lists all mpersonalFuncionario entities.
     *
     * @Route("/record/funcionario", name="pnalasignacion_record_funcionario")
     * @Method({"GET", "POST"})
     */
    public function recordFuncionarioAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        $asignaciones['data'] = array();

        if ($authCheck == true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $asignaciones = $em->getRepository('JHWEBPersonalBundle:PnalAsignacion')->findByFuncionario(
                $params->id
            );
                
            if ($asignaciones) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($asignaciones)." registros encontrados",  
                    'data'=> $asignaciones,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Ningún registro encontrado",
                    'data' => $response['data'] = array(),
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
     * Genera pdf con la asignacion solicitada.
     *
     * @Route("/acta/{id}/pdf", name="pnalasignacion_pdf")
     * @Method({"GET", "POST"})
     */
    public function pdfAction(Request $request, $id)
    {
        setlocale(LC_ALL,"es_ES");
        $fechaActual = strftime("%d de %B del %Y");

        $em = $this->getDoctrine()->getManager();

        $asignacion = $em->getRepository('JHWEBPersonalBundle:PnalAsignacion')->find(
            $id
        );

        $consecutivos = $em->getRepository('JHWEBPersonalBundle:PnalCfgCdoConsecutivo')->findByAsignacion(
            $asignacion->getId()
        );

        $html = $this->renderView('@JHWEBPersonal/Default/pdf.acta.organismo.transito.html.twig', array(
            'asignacion' => $asignacion,
            'consecutivos' => $consecutivos,
            'fechaActual' => $fechaActual
        ));

        $this->get('app.pdf')->templateAsignacionTalonarios($html, $asignacion);
    }
}
