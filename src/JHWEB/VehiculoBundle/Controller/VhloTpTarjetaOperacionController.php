<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloTpTarjetaOperacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlotptarjetaoperacion controller.
 *
 * @Route("vhlotptarjetaoperacion")
 */
class VhloTpTarjetaOperacionController extends Controller
{
    /**
     * Lists all vhloTpTarjetaOperacion entities.
     *
     * @Route("/", name="vhlotptarjetaoperacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $tarjetasOperacion = $em->getRepository('JHWEBVehiculoBundle:VhloTpTarjetaOperacion')->findBy(
            array('activo'=>true)
        );

        $response['data'] = array();

        if ($tarjetasOperacion) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($tarjetasOperacion)." Registros encontrados", 
                'data'=> $tarjetasOperacion,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Register a vhloTpAsignacion entity.
     *
     * @Route("/new", name="vhlotpasignacion_new")
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

            $asignacion = $em->getRepository('JHWEBVehiculoBundle:VhloTpAsignacion')->find($params->idAsignacion);

            $tarjetaOperacion = new VhloTpTarjetaOperacion();
            
            $tarjetaOperacion->setAsignacion($asignacion);
            $tarjetaOperacion->setFechaVencimiento(new \Datetime($params->fechaVencimiento));
            $tarjetaOperacion->setNumeroTarjetaOperacion($params->numeroTarjetaOperacion);
            $tarjetaOperacion->setActivo(true);
            
            $em->persist($tarjetaOperacion);
            $em->flush();

            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Los datos han sido registrados exitosamente.",
            );
        } else {
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Finds and displays a vhloTpTarjetaOperacion entity.
     *
     * @Route("/{id}", name="vhlotptarjetaoperacion_show")
     * @Method("GET")
     */
    public function showAction(VhloTpTarjetaOperacion $vhloTpTarjetaOperacion)
    {

        return $this->render('vhlotptarjetaoperacion/show.html.twig', array(
            'vhloTpTarjetaOperacion' => $vhloTpTarjetaOperacion,
        ));
    }

    /**
     * Search asignacion entity.
     *
     * @Route("/search/asignacion", name="search_asignacion")
     * @Method({"GET", "POST"})
     */
    public function searchAsignacionAction(Request $request)
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
                    'numero' => $params->placa
                )
            );
            
            $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->findOneBy(
                array(
                    'placa' => $placa
                )
            );

            if(!$vehiculo){
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El vehiculo no se encuentra registrado en la base de datos.",
                );
            } else {
                $asignacion = $em->getRepository('JHWEBVehiculoBundle:VhloTpAsignacion')->findOneBy(
                    array(
                        'vehiculo' => $vehiculo->getId()
                    )
                );

                if ($asignacion) {
                    $response = array(
                        'title' => 'Perfecto!',
                        'status' => 'success',
                        'code' => 200,
                        'message' => "Asignación de transporte público encontrada",
                        'data' => $asignacion
                    );
                } else {
                    $response = array(
                        'title' => 'Error!',
                        'status' => 'error',
                        'code' => 400,
                        'message' => "El vehiculo no tiene asignado cupo.",
                    );
                }
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
}
