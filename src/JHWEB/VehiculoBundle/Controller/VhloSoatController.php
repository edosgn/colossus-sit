<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloSoat;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlosoat controller.
 *
 * @Route("vhlosoat")
 */
class VhloSoatController extends Controller
{
    /**
     * Lists all vhloSoat entities.
     *
     * @Route("/", name="vhlosoat_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            $soats = $em->getRepository('JHWEBVehiculoBundle:VhloSoat')->findBy(
                array(
                    'activo' => true,
                    'vehiculo' => $params->idVehiculo,
                )
            );
            $response['data'] = array();

            if ($soats) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($soats) . " registros encontrados",
                    'data' => $soats,
                );
            }
            else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No se ha encontrado ningun registro de soat para este vehículo",
                    'data' => $soats,
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
     * Creates a new VhloSoat entity.
     *
     * @Route("/new", name="vhlosoat_new")
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

            $numeroPoliza = $em->getRepository('JHWEBVehiculoBundle:VhloSoat')->findOneBy(
                array(
                    'numeroPoliza' => $params->numeroPoliza,
                    'empresa' => $params->idEmpresa,
                    'activo' => true,
                )
            );

            /* $soatsOld = $em->getRepository('JHWEBVehiculoBundle:VhloSoat')->findBy(
                array(
                    'vehiculo' => $params->idVehiculo,
                    'activo' => true,
                )
            ); */

            if($numeroPoliza){
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'El número de póliza ya se encuentra registrados en la base de datos.',
                );
            } else {   
                //para inactivar los demas soat
                /* if($soatsOld) {
                    foreach ($soatsOld as $key => $soatOld) {
                        $soatOld->setEstado('VENCIDO');
                        $em->persist($soatOld);
                    }
                } */
                //=============================

                $soat = new VhloSoat();

                if ($params->idMunicipio) {
                    $municipio = $em->getRepository('JHWEBConfigBundle:CfgMunicipio')->find(
                        $params->idMunicipio
                    );
                    $soat->setMunicipio($municipio);
                }

                if ($params->idVehiculo) {
                    $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->find(
                        $params->idVehiculo
                    );
                    $soat->setVehiculo($vehiculo);
                }

                if ($params->idEmpresa) {
                    $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->find(
                        $params->idEmpresa
                    );
                    $soat->setEmpresa($empresa);
                }

                $soat->setFechaExpedicion(new \Datetime($params->fechaExpedicion));
                $soat->setFechaVigencia(new \Datetime($params->fechaVigencia));
                $soat->setFechaVencimiento(new \Datetime($params->fechaVencimiento));
                $soat->setNumeroPoliza($params->numeroPoliza);
                $soat->setEstado($params->estado);
                $soat->setActivo(true);

                $em->persist($soat);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Los datos han sido registrados exitosamente.",
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
     * Finds and displays a vhloSoat entity.
     *
     * @Route("/{id}", name="vhlosoat_show")
     * @Method("GET")
     */
    public function showAction(VhloSoat $vhloSoat)
    {
        $deleteForm = $this->createDeleteForm($vhloSoat);
        return $this->render('vhlosoat/show.html.twig', array(
            'vhlosoat' => $vhloSoat,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing VhloSoat entity.
     *
     * @Route("/edit", name="vhlosoat_edit")
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

            $soat = $em->getRepository('JHWEBVehiculoBundle:VhloSoat')->find($params->id);

            if ($params->idMunicipio) {
                $municipio = $em->getRepository('JHWEBConfigBundle:CfgMunicipio')->find(
                    $params->idMunicipio
                );
                $soat->setMunicipio($municipio);
            }

            if ($params->idEmpresa) {
                $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->find(
                    $params->idEmpresa
                );
                $soat->setEmpresa($empresa);
            }

            $soat->setFechaExpedicion(new \Datetime($params->fechaExpedicion));
            $soat->setFechaVigencia(new \Datetime($params->fechaVigencia));
            $soat->setFechaVencimiento(new \Datetime($params->fechaVencimiento));
            $soat->setEstado($params->estado);
            $soat->setActivo(true);

            $em->persist($soat);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Los datos han sido registrados exitosamente.",
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
     * Deletes a VhloSoat entity.
     *
     * @Route("/delete", name="vhlosoat_delete")
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

            $soat = $em->getRepository('JHWEBVehiculoBundle:VhloSoat')->find($params->id);

            $soat->setActivo(false);

            $em->persist($soat);
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
     * Creates a new VhloSoat entity.
     *
     * @Route("/get/fecha/vencimiento", name="soat_fecha_vencimiento")
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
            $fechaVigencia = new \Datetime(date('Y-m-d', strtotime('+1 day', strtotime($params->fechaExpedicion))));

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Fecha de vencimiento del soat calculada con éxito",
                'fechaVencimiento' => $fechaVencimiento->format('Y-m-d'),
                'fechaVigencia' => $fechaVigencia->format('Y-m-d')
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
