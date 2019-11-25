<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvIpatImpresoAsignacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Svipatimpresoasignacion controller.
 *
 * @Route("svipatimpresoasignacion")
 */
class SvIpatImpresoAsignacionController extends Controller
{
    /**
     * Lists all svIpatImpresoAsignacion entities.
     *
     * @Route("/", name="svipatimpresoasignacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $asignaciones = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatImpresoAsignacion')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($asignaciones) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($asignaciones) . " registros encontrados",
                'data' => $asignaciones,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new svIpatImpresoAsignacion entity.
     *
     * @Route("/new", name="svipatimpresoasignacion_new")
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

            $rangoDisponible = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatImpresoAsignacion')->getLastByFechaAndOrganismoTransito(
                $params->idOrganismoTransito
            );

            $cantidadDisponibleBodega = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatImpresoBodega')->getTotalDisponible();
            $cantidadDisponibleBodega = (empty($cantidadDisponibleBodega['cantidad']) ? 0 : $cantidadDisponibleBodega['cantidad']);
    
            if ($cantidadDisponibleBodega > 0) {
                if ($params->cantidad <= $cantidadDisponibleBodega) {
                    if ($rangoDisponible) {
                        $cantidadValidar = ($rangoDisponible->getCantidadRecibida() * 80) / 100;
                        $cantidadValidar = $rangoDisponible->getCantidadRecibida() - $cantidadValidar;

                        $cantidadDisponible = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatImpresoAsignacion')->getCantidadDisponibleByOrganismoTransito(
                            $params->idOrganismoTransito
                        );
                        $cantidadDisponible = (empty($cantidadDisponible['total']) ? 0 : $cantidadDisponible['total']);
                    
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
                                    'message' => "No se asignaron los impresos.", 
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
                                'message' => "No se asignaron los impresos.", 
                            );
                        }
                    }

                    
                }else{
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => 'La cantidad solicitada supera los '.$cantidadDisponibleBodega.' impresos disponibles en bodega.', 
                    );
                }
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'No tiene impresos disponibles en bodega.', 
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
     * Finds and displays a svIpatImpresoAsignacion entity.
     *
     * @Route("/{id}", name="svipatimpresoasignacion_show")
     * @Method("GET")
     */
    public function showAction(SvIpatImpresoAsignacion $svIpatImpresoAsignacion)
    {
        $deleteForm = $this->createDeleteForm($svIpatImpresoAsignacion);

        return $this->render('svipatimpresoasignacion/show.html.twig', array(
            'svIpatImpresoAsignacion' => $svIpatImpresoAsignacion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing svIpatImpresoAsignacion entity.
     *
     * @Route("/edit", name="svipatimpresoasignacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $impresoAsignacion = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatImpresoAsignacion')->find($params->id);

            if ($impresoAsignacion != null) {

                var_dump($params);
                die();
                
                $impresoAsignacion->setNombre(strtoupper($params->nombre));

                $em->persist($impresoAsignacion);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $impresoAsignacion,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos",
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida para editar",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Deletes a svIpatImpresoAsignacion entity.
     *
     * @Route("/{id}", name="svipatimpresoasignacion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SvIpatImpresoAsignacion $svIpatImpresoAsignacion)
    {
        $form = $this->createDeleteForm($svIpatImpresoAsignacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($svIpatImpresoAsignacion);
            $em->flush();
        }

        return $this->redirectToRoute('svipatimpresoasignacion_index');
    }

    /**
     * Creates a form to delete a svIpatImpresoAsignacion entity.
     *
     * @param SvIpatImpresoAsignacion $svIpatImpresoAsignacion The svIpatImpresoAsignacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvIpatImpresoAsignacion $svIpatImpresoAsignacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svipatimpresoasignacion_delete', array('id' => $svIpatImpresoAsignacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ======================================================= */

    public function register($params){
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $asignacion = new SvIpatImpresoAsignacion();
        
        $consecutivo = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatImpresoAsignacion')->getMaximo(date('Y'));
        
        $consecutivo = (empty($consecutivo['maximo']) ? 1 : $consecutivo['maximo']+=1);
        $asignacion->setConsecutivo($consecutivo);

        $fecha = new \Datetime($params->fecha);
        
        $asignacion->setNumeroActa(
            $fecha->format('Y').str_pad($consecutivo, 3, '0', STR_PAD_LEFT)
        );

        $asignacion->setFecha($fecha);
        
        $asignacion->setCantidadDisponible($params->cantidad);
        $asignacion->setCantidadRecibida($params->cantidad);
        $asignacion->setActivo(true);

        if ($params->idOrganismoTransito) {
            $organismoTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find(
                $params->idOrganismoTransito
            );
        }
        $asignacion->setOrganismoTransito($organismoTransito);
        
        $em->persist($asignacion);
        $em->flush();

        $bodegas = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatImpresoBodega')->findBy(
            array(
                'estado' => 'DISPONIBLE'
            )
        );

        foreach ($bodegas as $key => $bodega){
            if ($bodega->getCantidadDisponible() <= $params->cantidad) {
                $cantidad =  $params->cantidad - $bodega->getCantidadDisponible();
                $params->cantidad = $cantidad;
                $bodega->setCantidadDisponible(0);
                $bodega->setEstado('ASIGNADO');

                $em->flush(); 
            }else {
                if ($params->cantidad > 0) {
                    $cantidad =  $bodega->getCantidadDisponible() - $params->cantidad;
                    $bodega->setCantidadDisponible($cantidad);
                    $params->cantidad = 0;

                    $em->flush(); 
                }
            }
        }

        return true;
    }

    /**
     * Genera pdf con la asignacion solicitada.
     *
     * @Route("/acta/{id}/pdf", name="svipatimpresoasignacion_pdf")
     * @Method({"GET", "POST"})
     */
    public function pdfAction(Request $request, $id)
    {
        setlocale(LC_ALL,"es_ES");
        $fechaActual = strftime("%d de %B del %Y");

        $em = $this->getDoctrine()->getManager();

        $asignacion = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatImpresoAsignacion')->find(
            $id
        );

        $html = $this->renderView('@JHWEBSeguridadVial/Default/pdf.acta.asignacion.html.twig', array(
            'asignacion' => $asignacion,
            'fechaActual' => $fechaActual
        ));

        $this->get('app.pdf')->templateAsignacionTalonarios($html, $asignacion);
    }
}
