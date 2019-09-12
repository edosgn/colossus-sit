<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloLimitacion;
use JHWEB\VehiculoBundle\Entity\VhloCfgLimitacion;
use JHWEB\VehiculoBundle\Entity\VhloRestriccion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlolimitacion controller.
 *
 * @Route("vhlolimitacion")
 */
class VhloLimitacionController extends Controller
{
    /**
     * Lists all vhloLimitacion entities.
     *
     * @Route("/", name="vhlolimitacion_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $limitaciones = $em->getRepository('JHWEBVehiculoBundle:VhloLimitacion')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($limitaciones) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($limitaciones)." registros encontrados", 
                'data'=> $limitaciones,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new vhloLimitacion entity.
     *
     * @Route("/new", name="vhlolimitacion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $limitacionesOld = $em->getRepository('JHWEBVehiculoBundle:VhloLimitacion')->findBy(
                array(
                    'numeroOrdenJudicial' => $params->numeroOrdenJudicial,
                )
            );

            if (!$limitacionesOld) {
                $demandado = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->find(
                    $params->idDemandado
                );

                $municipio = $em->getRepository('JHWEBConfigBundle:CfgMunicipio')->find(
                    $params->idMunicipio
                );

                $tipo = $em->getRepository('JHWEBVehiculoBundle:VhloCfgLimitacionTipo')->find(
                    $params->idTipoLimitacion
                );

                $tipoProceso = $em->getRepository('JHWEBVehiculoBundle:VhloCfgLimitacionTipoProceso')->find(
                    $params->idTipoProcesoLimitacion
                );

                $causal = $em->getRepository('JHWEBVehiculoBundle:VhloCfgLimitacionCausal')->find(
                    $params->idCausalLimitacion
                );

                $entidadJudicial = $em->getRepository('JHWEBConfigBundle:CfgEntidadJudicial')->find(
                    $params->idEntidadJudicial
                );
                
                foreach ($params->vehiculos as $key => $idVehiculo) {
                    foreach ($params->demandantes as $key => $demandanteArray) {
                        $limitacion = new VhloLimitacion();
                        
                        $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->find(
                            $idVehiculo
                        );
                        $limitacion->setVehiculo($vehiculo);
                        
                        $demandante = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->find(
                            $demandanteArray->id
                        );
                        $limitacion->setDemandante($demandante);

                        $limitacion->setDemandado($demandado);
                        $limitacion->setMunicipio($municipio);                        
                        $limitacion->setTipo($tipo);
                        $limitacion->setTipoProceso($tipoProceso);
                        $limitacion->setCausal($causal);
                        $limitacion->setEntidadJudicial($entidadJudicial);
                        $limitacion->setFechaRadicacion(new \Datetime($params->fechaRadicacion));
                        $limitacion->setFechaExpedicion(new \Datetime($params->fechaExpedicion));
                        $limitacion->setNumeroOrdenJudicial($params->numeroOrdenJudicial);
                        $limitacion->setObservaciones($params->observaciones);
                        $limitacion->setActivo(true);
            
                        $em->persist($limitacion);
                        $em->flush();

                        $restriccion = new VhloRestriccion();

                        $fechaRegistro = new \Datetime(date('Y-m-d'));
                        //$fechaVencimiento = $helpers->getFechaVencimiento($fechaRegistro, 1);
                        
                        $restriccion->setTipo('LIMITACION');
                        $restriccion->setForanea($limitacion->getId());
                        $restriccion->setFechaRegistro($fechaRegistro);
                        $restriccion->setActivo(true);

                        $restriccion->setVehiculo($vehiculo);

                        $em->persist($restriccion);
                        $em->flush();
                    }
                }
    
                $limitaciones = $em->getRepository('JHWEBVehiculoBundle:VhloLimitacion')->findBy(
                    array(
                        'numeroOrdenJudicial' => $params->numeroOrdenJudicial,
                        'activo' => true
                    )
                );
    
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro creado con exito",
                    'data' => $limitaciones
                );
            }else{
                $response = array(
                    'title' => 'Atención!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => "Las limitaciones asociadas al número de orden judicial ".$params->numeroOrdenJudicial." ya se encuentras registradas en el sistema.",
                    'data' => $limitacionesOld
                );
            }
            
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida",
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Finds and displays a vhloLimitacion entity.
     *
     * @Route("/{id}/show", name="vhlolimitacion_show")
     * @Method("GET")
     */
    public function showAction(VhloLimitacion $vhloLimitacion)
    {
        $deleteForm = $this->createDeleteForm($vhloLimitacion);

        return $this->render('vhlolimitacion/show.html.twig', array(
            'vhloLimitacion' => $vhloLimitacion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vhloLimitacion entity.
     *
     * @Route("/{id}/edit", name="vhlolimitacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, VhloLimitacion $vhloLimitacion)
    {
        $deleteForm = $this->createDeleteForm($vhloLimitacion);
        $editForm = $this->createForm('JHWEB\VehiculoBundle\Form\VhloLimitacionType', $vhloLimitacion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vhlolimitacion_edit', array('id' => $vhloLimitacion->getId()));
        }

        return $this->render('vhlolimitacion/edit.html.twig', array(
            'vhloLimitacion' => $vhloLimitacion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a vhloLimitacion entity.
     *
     * @Route("/delete", name="vhlolimitacion_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $limitacion = $em->getRepository('JHWEBVehiculoBundle:VhloLimitacion')->find(
                $params->id
            );

            if ($limitacion) {
                $limitacion->setActivo(false);
    
                $em->flush();
    
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro eliminado con exito.",
                );
            }else{
                $response = array(
                    'title' => 'Atención!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos.",
                );
            }
        } else {
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida",
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a vhloLimitacion entity.
     *
     * @param VhloLimitacion $vhloLimitacion The vhloLimitacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloLimitacion $vhloLimitacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhlolimitacion_delete', array('id' => $vhloLimitacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ============================================== */

    /**
     * Busca las limitaciones activas por numero de placa.
     *
     * @Route("/search/placa/identificacion", name="vhlolimitacion_search_placa_identificacion")
     * @Method({"GET", "POST"})
     */
    public function searchByPlacaOrIdentificacionAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $placa = $em->getRepository('JHWEBVehiculoBundle:VhloCfgPlaca')->findOneBy(
                array(
                    'numero' => $params->numero
                )
            );

            if ($placa) {
                $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->findOneBy(
                    array(
                        'placa' => $placa->getId()
                    )
                );

                if ($vehiculo) {
                    $limitaciones = $em->getRepository('JHWEBVehiculoBundle:VhloLimitacion')->findBy(
                        array(
                            'vehiculo' => $vehiculo->getId(),
                            'activo' => true,
                        )
                    );

                    if ($limitaciones) {
                        $response = array(
                            'title' => 'Perfecto!',
                            'status' => 'success',
                            'code' => 200,
                            'message' => count($limitaciones).' limitaciones encontradas.',
                            'data' => $limitaciones,
                        );
                    }else{
                        $response = array(
                            'title' => 'Atención!',
                            'status' => 'warning',
                            'code' => 400,
                            'message' => 'Ningún registro encontrado.',
                        );
                    }
                }else{
                    $response = array(
                        'title' => 'Error!',
                        'status' => 'error',
                        'code' => 400,
                        'message' => 'No se encuentra ningún vehiculo con el número de placa digitada.',
                    );
                }
            }else{
                $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findOneBy(
                    array(
                        'identificacion' => $params->numero
                    )
                );

                if ($ciudadano) {
                    $limitaciones = $em->getRepository('JHWEBVehiculoBundle:VhloLimitacion')->findBy(
                        array(
                            'demandado' => $ciudadano->getId(),
                            'activo' => true,
                        )
                    );

                    if ($limitaciones) {
                        $response = array(
                            'title' => 'Perfecto!',
                            'status' => 'success',
                            'code' => 200,
                            'message' => count($limitaciones).' limitaciones encontradas.',
                            'data' => $limitaciones,
                        );
                    }else{
                        $response = array(
                            'title' => 'Atención!',
                            'status' => 'warning',
                            'code' => 400,
                            'message' => 'Ningún registro encontrado.',
                        );
                    }
                }else{
                    $response = array(
                        'title' => 'Error!',
                        'status' => 'error',
                        'code' => 400,
                        'message' => 'No se encuentra ningún demandado con el número de identificación digitada.',
                    );
                }
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida",
            );
        }
        
        return $helpers->json($response);
    }
}
