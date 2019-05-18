<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloTecnoMecanica;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * Vhlotecnomecanica controller.
 *
 * @Route("vhlotecnomecanica")
 */
class VhloTecnoMecanicaController extends Controller
{
    /**
     * Lists all vhloTecnoMecanica entities.
     *
     * @Route("/", name="vhlotecnomecanica_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
        
            $tecnoMecanicas = $em->getRepository('JHWEBVehiculoBundle:VhloTecnoMecanica')->findBy(
                array(
                    'activo' => true,
                    'vehiculo' => $params->idVehiculo
                )
            );

            $response['data'] = array();

            if ($tecnoMecanicas) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($tecnoMecanicas)." registros encontrados", 
                    'data'=> $tecnoMecanicas,
                );
            } 
            else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No se ha encontrado ningun registro de revisiones técnico mecánicas para este vehículo",
                    'data' => $tecnoMecanicas,
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
     * Creates a new vhloTecnoMecanica entity.
     *
     * @Route("/new", name="vhloTecnomecanica_new")
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

            $numeroPoliza = $em->getRepository('JHWEBVehiculoBundle:VhloTecnoMecanica')->findOneBy(
                array(
                    'numeroControl' => $params->numeroControl,
                    'cda' => $params->idCda,
                    'estado' => 'UTILIZADO',
                    'activo' => true,
                )
            );

            if($numeroPoliza){
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'El número de control ya se encuentra registrado en la base de datos para este CDA.',
                );
            } else { 
                $tecnoMecanica = new VhloTecnoMecanica();

                if ($params->idCda) {
                    $cfgCda = $em->getRepository('JHWEBVehiculoBundle:VhloCfgCda')->find(
                        $params->idCda
                    );
                    $tecnoMecanica->setCda($cfgCda);
                }

                if ($params->idVehiculo) {
                    $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->find(
                        $params->idVehiculo
                    );
                    $tecnoMecanica->setVehiculo($vehiculo);
                }

                $tecnoMecanica->setNumeroControl($params->numeroControl);
                $tecnoMecanica->setFechaExpedicion(new \Datetime($params->fechaExpedicion));
                $tecnoMecanica->setFechaVencimiento(new \Datetime($params->fechaVencimiento));
                $tecnoMecanica->setEstado($params->estado);
                $tecnoMecanica->setActivo(true);

                $em->persist($tecnoMecanica);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro creado con exito",
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
     * Finds and displays a vhloTecnoMecanica entity.
     *
     * @Route("/{id}", name="vhlotecnomecanica_show")
     * @Method("GET")
     */
    public function showAction(VhloTecnoMecanica $vhloTecnoMecanica)
    {
        $deleteForm = $this->createDeleteForm($vhloTecnoMecanica);

        return $this->render('vhlotecnomecanica/show.html.twig', array(
            'vhlotecnoMecanica' => $vhloTecnoMecanica,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vhloTecnoMecanica entity.
     *
     * @Route("/edit", name="vhlotecnomecanica_edit")
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

            $tecnoMecanica = $em->getRepository('JHWEBVehiculoBundle:VhloTecnoMecanica')->find($params->id);

             if ($params->idCda) {
                $cfgCda = $em->getRepository('JHWEBVehiculoBundle:VhloCfgCda')->find(
                    $params->idCda
                );
                $tecnoMecanica->setCda($cfgCda);
            }

            $tecnoMecanica->setFechaExpedicion(new \Datetime($params->fechaExpedicion));
            $tecnoMecanica->setFechaVencimiento(new \Datetime($params->fechaVencimiento));
            $tecnoMecanica->setEstado($params->estado);

            $em->persist($tecnoMecanica);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Los datos han sido editados exitosamente.",
            );
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
     * Deletes a vhloTecnoMecanica entity.
     *
     * @Route("/delete", name="vhlotecnomecanica_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", true);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $json = $request->get("data", null);
            $params = json_decode($json);

            $tecnoMecanica = $em->getRepository('JHWEBVehiculoBundle:VhloTecnoMecanica')->find($params->id);

            $tecnoMecanica->setActivo(false);

            $em->persist($tecnoMecanica);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro eliminado con éxito.",
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no válida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a vhloTecnoMecanica entity.
     *
     * @param VhloTecnoMecanica $vhloTecnoMecanica The vhloTecnoMecanica entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloTecnoMecanica $vhloTecnoMecanica)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhlotecnomecanica_delete', array('id' => $vhloTecnoMecanica->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Creates a new cfgCda entity.
     *
     * @Route("/get/fecha/vencimiento", name="vhlo_tecnomecanica_fecha_vencimiento")
     * @Method({"GET", "POST"})
     */
    public function getFechaVencimientoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $fechaVencimiento = new \Datetime(date('Y-m-d', strtotime('+1 year', strtotime($params->fechaExpedicion))));

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Fecha de vencimiento calculada con exito",
                'data' => $fechaVencimiento->format('Y-m-d')
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
}
