<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloCfgPlaca;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlocfgplaca controller.
 *
 * @Route("vhlocfgplaca")
 */
class VhloCfgPlacaController extends Controller
{
    /**
     * Lists all vhloCfgPlaca entities.
     *
     * @Route("/", name="vhlocfgplaca_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        
        $em = $this->getDoctrine()->getManager();

        $placas = $em->getRepository('JHWEBVehiculoBundle:VhloCfgPlaca')->findAll();

        $response['data'] = array();

        if ($placas) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($placas)." registros encontrados.",
                'data' => $placas,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new vhloCfgPlaca entity.
     *
     * @Route("/new", name="vhlocfgplaca_new")
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
            
            $placa = $em->getRepository('JHWEBVehiculoBundle:VhloCfgPlaca')->findOneByNumero(
                $params->numero
            );

            if (!$placa) {
                $placa = new VhloCfgPlaca();

                $placa->setNumero(mb_strtoupper($params->numero, 'utf-8'));
                $placa->setEstado('FABRICADA');

                $tipoVehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloCfgTipoVehiculo')->find(
                    $params->idTipoVehiculo
                );
                $placa->setTipoVehiculo($tipoVehiculo);

                $organismoTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find(
                    $params->idOrganismoTransito
                );
                $placa->setOrganismoTransito($organismoTransito);

                $em->persist($placa);
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
                    'message' => 'La placa ya existe', 
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
     * Finds and displays a vhloCfgPlaca entity.
     *
     * @Route("/show/{id}", name="vhlocfgplaca_show")
     * @Method("GET")
     */
    public function showAction(VhloCfgPlaca $vhloCfgPlaca)
    {
        $deleteForm = $this->createDeleteForm($vhloCfgPlaca);

        return $this->render('vhlocfgplaca/show.html.twig', array(
            'vhloCfgPlaca' => $vhloCfgPlaca,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vhloCfgPlaca entity.
     *
     * @Route("/edit", name="vhlocfgplaca_edit")
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
            
            $placa = $em->getRepository('JHWEBVehiculoBundle:VhloCfgPlaca')->find(
                $params->id
            );

            if ($placa) {
                $placa->setNumero(mb_strtoupper($numero, 'utf-8'));
                $placa->setEstado('FABRICADA');

                $tipoVehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloCfgTipoVehiculo')->find(
                    $params->idTipoVehiculo
                );
                $placa->setTipoVehiculo($tipoVehiculo);

                $organismoTransito = $em->getRepository('JHWEBConfigBundle:OrganismoTransito')->find(
                    $params->idOrganismoTransito
                );
                $placa->setOrganismoTransito($organismoTransito);

                $em->persist($placa);
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
                    'message' => 'La placa no se encuentra en la base de datos', 
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
     * Deletes a vhloCfgPlaca entity.
     *
     * @Route("/delete", name="vhlocfgplaca_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $json = $request->get("json", null);
            $params = json_decode($json);

            $placa = $em->getRepository('JHWEBVehiculoBundle:VhloCfgPlaca')->find($params);

            $placa->setEstado(0);
            $em = $this->getDoctrine()->getManager();
            $em->persist($placa);
            $em->flush();
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Placa eliminada con éxto",
            );

        }else{
            $reponse = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorización no válida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a vhloCfgPlaca entity.
     *
     * @param VhloCfgPlaca $vhloCfgPlaca The vhloCfgPlaca entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloCfgPlaca $vhloCfgPlaca)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhlocfgplaca_delete', array('id' => $vhloCfgPlaca->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ================================================= */

    /**
     * Libera una placa seleccionado.
     *
     * @Route("/liberate", name="vhlocfgplaca_liberate")
     * @Method("POST")
     */
    public function liberateAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $json = $request->get("json", null);
            $params = json_decode($json);

            $cfgPlaca = $em->getRepository('AppBundle:CfgPlaca')->find($params);

            $cfgPlaca->setEstado('Fabricada');
            $em = $this->getDoctrine()->getManager();
                $em->persist($cfgPlaca);
                $em->flush();
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Placa eliminada con éxto",
            );

        }else{
            $reponse = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorización no válida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Datos para select 2 por modulo
     *
     * @Route("/select/organismotransito/tipovehiculo", name="vhlocfgplaca_select_organismotransito_tipovehiculo")
     * @Method({"GET", "POST"})
     */

    public function selectByOrganismoTransitoAndTipoVehiculo(Request $request)
    {
        $json = $request->get("data", null);
        $params = json_decode($json);
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $response = null;

        $placas = $em->getRepository('JHWEBVehiculoBundle:VhloCfgPlaca')->findBy(
            array(
                'organismoTransito' => $params->idOrganismoTransito,
                'tipoVehiculo' => $params->idTipoVehiculo,
                'estado' => 'FABRICADA'
            )
        );

        foreach ($placas as $key => $placa) {
            $response[$key] = array(
                'value' => $placa->getNumero(),
                'label' => $placa->getNumero(),
            );
        }

        return $helpers->json($response);
    }

    /**
     * Datos para select 2 por organismo de transito
     *
     * @Route("/select/organismotransito", name="vhlocfgplaca_select_organismotransito")
     * @Method({"GET", "POST"})
     */

    public function selectPlacaByOrganismoTransito(Request $request)
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $response = null;

        $placas = $em->getRepository('JHWEBVehiculoBundle:VhloCfgPlaca')->findBy(
            array(
                'organismoTransito' => $params->idOrganismoTransito,
                'estado' => 'FABRICADA'
            )
        );

        foreach ($placas as $key => $placa) {
            $response[$key] = array(
                'value' => $placa->getNumero(),
                'label' => $placa->getNumero(),
            );
        }
        
        return $helpers->json($response);
    }
}