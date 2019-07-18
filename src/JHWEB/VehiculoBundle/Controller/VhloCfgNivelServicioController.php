<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloCfgNivelServicio;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlocfgnivelservicio controller.
 *
 * @Route("vhlocfgnivelservicio")
 */
class VhloCfgNivelServicioController extends Controller
{
    /**
     * Lists all vhloCfgNivelServicio entities.
     *
     * @Route("/", name="vhlocfgnivelservicio_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $nivelesServicio = $em->getRepository('JHWEBVehiculoBundle:VhloCfgNivelServicio')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($nivelesServicio) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($nivelesServicio)." registros encontrados", 
                'data'=> $nivelesServicio,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new vhloCfgNivelServicio entity.
     *
     * @Route("/new", name="vhlocfgnivelservicio_new")
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
            
            $servicio = $em->getRepository('JHWEBVehiculoBundle:VhloCfgServicio')->find(
                $params->idServicio
            );

            $nivelServicio = new VhloCfgNivelServicio();

            $nivelServicio->setServicio($servicio);
            $nivelServicio->setNombre(mb_strtoupper($params->nombre, 'utf-8'));
            $nivelServicio->setGestionable(true);
            $nivelServicio->setActivo(true);

            $em->persist($nivelServicio);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con éxito",
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
     * Finds and displays a vhloCfgNivelServicio entity.
     *
     * @Route("/show", name="vhlocfgnivelservicio_show")
     * @Method("POST")
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $nivelServicio = $em->getRepository('JHWEBVehiculoBundle:VhloCfgNivelServicio')->find(
                $params->id
            );

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Registro encontrado con exito.',
                'data' => $nivelServicio
            );
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
     * Displays a form to edit an existing vhloCfgNivelServicio entity.
     *
     * @Route("/edit", name="vhlocfgnivelservicio_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            
            $nivelServicio = $em->getRepository('JHWEBVehiculoBundle:VhloCfgNivelServicio')->find(
                $params->id
            );

            if ($nivelServicio) {

                $servicio = $em->getRepository('JHWEBVehiculoBundle:VhloCfgServicio')->find($params->idServicio);

                $nivelServicio->setServicio($servicio);
                $nivelServicio->setNombre(mb_strtoupper($params->nombre, 'utf-8'));

                $em->persist($nivelServicio);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito",
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'El nivel de servicio no se encuentra en la base de datos', 
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
     * Deletes a vhloCfgNivelServicio entity.
     *
     * @Route("/delete", name="vhlocfgnivelservicio_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $json = $request->get("data", null);
            $params = json_decode($json);
            
            $em = $this->getDoctrine()->getManager();

            $nivelServicio = $em->getRepository('JHWEBVehiculoBundle:VhloCfgNivelServicio')->find($params->id);

            $nivelServicio->setActivo(false);
            
            $em->persist($nivelServicio);
            $em->flush();

            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro eliminado con éxito",
            );

        }else{
            $reponse = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorización no válida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Datos para select 2
     *
     * @Route("/select", name="vhlocfgnivelservicio_select")
     * @Method({"GET", "POST"})
     */

    public function selectAccion(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $json = $request->get("data", null);
        $params = json_decode($json);

        $em = $this->getDoctrine()->getManager();

        $response = null;

        $nivelesServicio = $em->getRepository('JHWEBVehiculoBundle:VhloCfgNivelServicio')->findBy(
            array(
                'activo' => true,
            )
        );

        foreach ($nivelesServicio as $key => $nivelServicio) {
            $response[$key] = array(
                'value' => $nivelServicio->getId(),
                'label' => $nivelServicio->getNombre(),
            );
        }
        
        return $helpers->json($response);
    }
}
