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

                $servicio = $em->getRepository('JHWEBVehiculoBundle:VhloCfgServicio')->find(
                    $params->idServicio
                );
                $placa->setServicio($servicio);

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
     * @Route("/show", name="vhlocfgplaca_show")
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

            $placa = $em->getRepository('JHWEBVehiculoBundle:VhloCfgPlaca')->find(
                $params->id
            );

            if($placa){
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Registro encontrado con exito.',
                    'data' => $placa
                );
            }else{
                $response = array(
                    'status' => 'warning',
                    'code' => 400,
                    'message' => 'Registro no encontrado.',
                    'data' => $placa
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
                    'message' => "Placa eliminada con éxito",
            );

        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorización no válida",
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
     * @Route("/search/numero", name="vhlocfgplaca_search_numero")
     * @Method("POST")
     */
    public function searchByNumeroAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $json = $request->get("data", null);
            $params = json_decode($json);

            $placas = $em->getRepository('JHWEBVehiculoBundle:VhloCfgPlaca')->findBy(
                array(
                    'numero' => $params->numero,
                )
            );

            if($placas){
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'data' => $placas,
                    'message' => count($placas).' registros encontrados.',
                );
            }else{
                $response = array(
                    'title' => 'Atención!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => "Ningún registro encontrado.",
                );
            }
        }else{
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
     * Cambia el estado de una placa seleccionada.
     *
     * @Route("/state", name="vhlocfgplaca_state")
     * @Method("POST")
     */
    public function stateAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $json = $request->get("data", null);
            $params = json_decode($json);

            $placa = $em->getRepository('JHWEBVehiculoBundle:VhloCfgPlaca')->find(
                $params->id
            );

            if($placa){
                if ($params->estado == 'DISPONIBLE') {
                    $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->findOneByPlaca(
                        $placa->getId()
                    );

                    $vehiculo->setPlaca(null);
                }
                $placa->setEstado($params->estado);
    
                $em = $this->getDoctrine()->getManager();
                $em->flush();
    
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Placa ha sido configurada en estado ".$params->estado." con éxito.",
                );
            }else{
                $response = array(
                    'title' => 'Atención!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => "La placa no fue encontrada.",
                );
            }
        }else{
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
     * Datos para select 2 por modulo
     *
     * @Route("/select/organismotransito/tipovehiculo/servicio", name="vhlocfgplaca_select_organismotransito_tipovehiculo_servicio")
     * @Method({"GET", "POST"})
     */

    public function selectByOrganismoTransitoAndTipoVehiculoAndServicio(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $json = $request->get("data", null);
        $params = json_decode($json);

        $em = $this->getDoctrine()->getManager();

        $response = null;

        if($params->idServicio) {
            $placas = $em->getRepository('JHWEBVehiculoBundle:VhloCfgPlaca')->findBy(
                array(
                    'organismoTransito' => $params->idOrganismoTransito,
                    'tipoVehiculo' => $params->idTipoVehiculo,
                    'servicio' => $params->idServicio,
                    'estado' => 'DISPONIBLE'
                )
            ); 
        } else {
            $placas = $em->getRepository('JHWEBVehiculoBundle:VhloCfgPlaca')->findBy(
                array(
                    'organismoTransito' => $params->idOrganismoTransito,
                    'tipoVehiculo' => $params->idTipoVehiculo,
                    'estado' => 'DISPONIBLE'
                )
            ); 
        }

        foreach ($placas as $key => $placa) {
            $response[$key] = array(
                'value' => $placa->getId(),
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

    public function selectByOrganismoTransito(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $json = $request->get("data", null);
        $params = json_decode($json);

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
                'value' => $placa->getId(),
                'label' => $placa->getNumero(),
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Creates a new vhloCfgPlaca entity.
     *
     * @Route("/make", name="vhlocfgplaca_make")
     * @Method({"GET", "POST"})
     */
    public function makeAction(Request $request)
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
                $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->find(
                    $params->idVehiculo
                );

                $placa = new VhloCfgPlaca();

                $placa->setNumero(mb_strtoupper($params->numero, 'utf-8'));
                $placa->setEstado('FABRICADA');

                $placa->setTipoVehiculo($vehiculo->getTipoVehiculo());
                $placa->setServicio($vehiculo->getServicio());
                $placa->setOrganismoTransito($vehiculo->getOrganismoTransito());

                $em->persist($placa);
                $em->flush();

                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro creado con éxito",
                );
            }else{
                $response = array(
                    'title' => 'Atención',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => 'La placa ya existe', 
                );
            }
        }else{
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
     * Buscar por organismo de transito y estado.
     *
     * @Route("/search/organismotransito/estado", name="vhlocfgplaca_search_organismotransito_estado")
     * @Method("POST")
     */
    public function searchByOrganismoTransitoAndEstadoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();

            $json = $request->get("data", null);
            $params = json_decode($json);

            $placas = $em->getRepository('JHWEBVehiculoBundle:VhloCfgPlaca')->findBy(
                array(
                    'organismoTransito' => $params->idOrganismoTransito,
                    'estado' => $params->estado,
                )
            );

            if($placas){
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'data' => $placas,
                    'message' => count($placas).' registros encontrados.',
                );
            }else{
                $response = array(
                    'title' => 'Atención!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => "Ningún registro encontrado.",
                );
            }
        }else{
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
     * Buscar por asignacion a sede.
     *
     * @Route("/search/asignacion", name="vhlocfgplaca_asignacion")
     * @Method("POST")
     */
    public function searchByAsignacionAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();

            $json = $request->get("data", null);
            $params = json_decode($json);

            $placas = $em->getRepository('JHWEBVehiculoBundle:VhloCfgPlaca')->findBy(
                array(
                    'asignacion' => $params->idAsignacion,
                    'estado' => 'DISPONIBLE',
                )
            );

            if($placas){
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'data' => $placas,
                    'message' => count($placas).' registros encontrados.',
                );
            }else{
                $response = array(
                    'title' => 'Atención!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => "Ningún registro encontrado.",
                );
            }
        }else{
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
     * Reporte de placas por tramites.
     *
     * @Route("/report/tramites", name="vhlocfgplaca_report_tramites")
     * @Method({"GET", "POST"})
     */
    public function reportByTramitesAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            
            $fechaInicial = new \Datetime($params->fechaInicial);
            $fechaFinal = new \Datetime($params->fechaFinal);

            if ($fechaInicial <= $fechaFinal) {
                $placas = $em->getRepository('JHWEBVehiculoBundle:VhloCfgPlaca')->getByTramiteAndFechas(
                    $fechaInicial,
                    $fechaFinal
                );
    
                if($placas) {
                    $response = array(
                        'title' => 'Perfecto!',
                        'status' => 'success',
                        'code' => 200,
                        'message' => count($placas).' placas encomtrada(s).', 
                        'data' => $placas, 
                    );
                }else{
                    $response = array(
                        'title' => 'Atención!',
                        'status' => 'warning',
                        'code' => 400,
                        'message' => 'No hay registros para las fechas estipuladas.', 
                    );
                }            
            }else{
                $response = array(
                    'title' => 'Atención!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => 'La fecha inicial no puede ser mayer a que la fecha final.', 
                );
            }
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorización no válida.', 
            );
        }

        return $helpers->json($response);
    }
}
