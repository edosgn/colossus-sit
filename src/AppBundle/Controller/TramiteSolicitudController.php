<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TramiteSolicitud;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Tramitesolicitud controller.
 *
 * @Route("tramitesolicitud")
 */
class TramiteSolicitudController extends Controller
{
    /**
     * Lists all tramiteSolicitud entities.
     *
     * @Route("/index", name="tramitesolicitud_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $json = $request->get("json", null);
        $params = json_decode($json);
        $moduloId = $params;

            $tramitesSolicitud = $em->getRepository('AppBundle:TramiteSolicitud')->getTramitesModulo(
                $moduloId
            );

        $response = array(
            'status' => 'success',
            'code' => 200,
            'msj' => "Lista de tramites",
            'data' => $tramitesSolicitud,
        );
        return $helpers->json($response);
    }

    /**
     * Finds and displays a seguimientoEntrega entity.
     *
     * @Route("/{tramiteSolicitudId}/show/tramiteSolicitud", name="tramite_solicitud_tramiteFactura")
     * @Method({"GET", "POST"})
     */ 
    public function showAction(Request $request, $tramiteSolicitudId)
    {$em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $tramiteSolicitud = $em->getRepository('AppBundle:TramiteSolicitud')->findOneByTramiteFactura($tramiteSolicitudId);

        $tramiteSolicitud->setDatos((array) $tramiteSolicitud->getDatos());

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "Registro encontrado",
                'data' => $tramiteSolicitud,
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Finds and displays a seguimientoEntrega entity.
     *
     * @Route("/tramiteSolicitud/search/idFactura/formulario", name="tramite_solicitud_tramiteFactura_formulario")
     * @Method({"GET", "POST"})
     */ 
    public function showFacturaFormularioAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
   
        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $tramite = $em->getRepository('AppBundle:Tramite')->findOneByFormulario(
                $params->tramiteFormulario
            );

            $tramiteFactura = $em->getRepository('AppBundle:TramiteFactura')->getByFacturaAndTramite($params->idFactura,$tramite->getId());

            $tramiteSolicitud = $em->getRepository('AppBundle:TramiteSolicitud')->findOneBy(
                array(
                    'estado' => 1, 
                    'tramiteFactura'=> $tramiteFactura->getId(),
                )
            );
            
            $tramiteSolicitud->setDatos($helpers->json($tramiteSolicitud->getDatos()));

            $em = $this->getDoctrine()->getManager();
            if ($tramiteSolicitud) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado",
                    'data' => $tramiteSolicitud,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Tramite no realizado",
                    'data' => $tramite->getNombre(),
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
     * Creates a new tramiteSolicitud entity.
     *
     * @Route("/new", name="tramitesolicitud_new")
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

            $observacion = (isset($params->observacion)) ? $params->observacion : null;
            $documentacionCompleta = (isset($params->documentacionCompleta)) ? $params->documentacionCompleta : false;
            $fechaSolicitudDateTime = new \DateTime(date('Y-m-d h:i:s'));
            $datos = $params->datos->foraneas; 
            
            $em = $this->getDoctrine()->getManager();

            $tramiteSolicitud = new TramiteSolicitud();

            if ($params->vehiculoId) {
                $vehiculo = $em->getRepository('AppBundle:Vehiculo')->find($params->vehiculoId);
                $tramiteSolicitud->setVehiculo($vehiculo);
            }

            if ($params->solicitanteId) {
                $propietario = $em->getRepository('AppBundle:PropietarioVehiculo')->find($params->solicitanteId);
                $tramiteSolicitud->setSolicitante($propietario);
                $ciudadanoId = (isset($params->ciudadanoId)) ? $params->ciudadanoId : null;
                if ($ciudadanoId) {
                    $ciudadano = $em->getRepository('AppBundle:Ciudadano')->find($params->ciudadanoId);
                    $tramiteSolicitud->setCiudadano($ciudadano);
                }
            } else {
                $ciudadanoId = (isset($params->datos->ciudadanoId)) ? $params->datos->ciudadanoId : null;
                if ($ciudadanoId) {
                    $ciudadano = $em->getRepository('AppBundle:Ciudadano')->find($params->datos->ciudadanoId);
                    $tramiteSolicitud->setCiudadano($ciudadano);
                }
            }

            if ($params->vehiculoId) {
                $vehiculo = $em->getRepository('AppBundle:Vehiculo')->find($params->vehiculoId);
                $tramiteSolicitud->setVehiculo($vehiculo);
            }

            if ($datos->idFactura && $datos->tramiteFormulario) {
                $factura = $em->getRepository('AppBundle:Factura')->find(
                    $datos->idFactura
                );
                
                $tramite = $em->getRepository('AppBundle:Tramite')->findOneByFormulario(
                    $datos->tramiteFormulario
                );
                $tramiteFactura = $em->getRepository('AppBundle:TramiteFactura')->getByFacturaAndTramite($factura->getId(),$tramite->getId());
                $tramiteSolicitud->setTramiteFactura($tramiteFactura);
                $tramiteFactura->setRealizado(true);
                $em->flush();
            }
            $tramiteSolicitud->setObservacion($observacion);
            $tramiteSolicitud->setDocumentacion($documentacionCompleta);
            $tramiteSolicitud->setFecha($fechaSolicitudDateTime);
            $tramiteSolicitud->setEstado(true);
            $tramiteSolicitud->setDatos((array)$datos);
            $tramiteSolicitud->setResumen((array)$params->datos->resumen);

            $em->persist($tramiteSolicitud);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "Registro creado con exito",
                'idTramiteSolicitud' => $tramiteSolicitud->getId(),
                'tramiteSolitud' => $tramiteSolicitud
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing tramiteSolicitud entity.
     *
     * @Route("/{id}/edit", name="tramitesolicitud_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TramiteSolicitud $tramiteSolicitud)
    {
        $deleteForm = $this->createDeleteForm($tramiteSolicitud);
        $editForm = $this->createForm('AppBundle\Form\TramiteSolicitudType', $tramiteSolicitud);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tramitesolicitud_edit', array('id' => $tramiteSolicitud->getId()));
        }

        return $this->render('tramitesolicitud/edit.html.twig', array(
            'tramiteSolicitud' => $tramiteSolicitud,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a tramiteSolicitud entity.
     *
     * @Route("/{id}/delete", name="tramitesolicitud_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TramiteSolicitud $tramiteSolicitud)
    {
        $form = $this->createDeleteForm($tramiteSolicitud);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tramiteSolicitud);
            $em->flush();
        }

        return $this->redirectToRoute('tramitesolicitud_index');
    }

    /**
     * Creates a form to delete a tramiteSolicitud entity.
     *
     * @param TramiteSolicitud $tramiteSolicitud The tramiteSolicitud entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TramiteSolicitud $tramiteSolicitud)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tramitesolicitud_delete', array('id' => $tramiteSolicitud->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ======================================================== */

    /**
     * Obtiene tramiteSolicitud segun id_vehiculo entities.
     *
     * @Route("/vehiculo", name="tramitesolicitud_vehiculo")
     * @Method({"GET", "POST"})
     */
    public function getByVehiculoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $idVehiculo = $request->get("json", null);

            $tramitesSolicitud = $em->getRepository('AppBundle:TramiteSolicitud')->findByVehiculo(
                $idVehiculo
            );

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Lista de tramites",
                'data' => $tramitesSolicitud,
            );
        }else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida",
            );
        }
            
        return $helpers->json($response);
    }

    /**
     * Obtiene tramiteSolicitud segun id_vehiculo entities.
     *
     * @Route("/byvehiculoorder", name="tramitesolicitud_byvehiculoordertramite")
     * @Method({"GET", "POST"})
     */
    public function getTramiteByIdVehiculoAndTramite(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $idVehiculo = $request->get("json", null);
        $authCheck = $helpers->authCheck($hash);
        $tramitesSolicitud = $em->getRepository('AppBundle:TramiteSolicitud')->findByVehiculoOrderTramite($idVehiculo);

        foreach ($tramitesSolicitud as $key => $tramiteSolicitud) {
            $response[$key] = array(
                'value' => $tramiteSolicitud->getId(),
                'label' => $tramiteSolicitud->getNombre(),
            );
        }

        return $helpers->json($response);
    }

    /**
     * Obtiene tramiteSolicitud segun id_vehiculo and dates entities.
     *
     * @Route("/byvehiculoanddate", name="tramitesolicitud_byvehiculoanddate")
     * @Method({"GET", "POST"})
     */
    public function getTramiteByIdVehiculoAndDate(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $datos = $request->get("json", null);
        $params = json_decode($datos);
        $authCheck = $helpers->authCheck($hash);
        $tramitesSolicitud = $em->getRepository('AppBundle:TramiteSolicitud')->findByVehiculoAndDate($params);
        if ($tramitesSolicitud) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "Lista de tramites",
                'data' => $tramitesSolicitud,
            );} else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "No hay tramites entre esas fechas",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Lists all tramiteSolicitud entities.
     *
     * @Route("/report/index", name="tramitesolicitud_report_index")
     * @Method({"GET", "POST"})
     */
    public function reportIndexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $tramiteReportes = $em->getRepository('AppBundle:TramiteSolicitud')->getTramiteReportes();

        // foreach ($tramiteReportes as $key => $ts) {
        //   var_dump($ts['id']);
        //   die();
        // }

        $response = array(
            'status' => 'success',
            'code' => 200,
            'msj' => "Lista de tramites",
            'data' => $tramiteReportes,
        );
        return $helpers->json($response);
    }

    /**
     * Lists all tramiteSolicitud entities.
     *
     * @Route("/report/date", name="tramitesolicitud_report_date")
     * @Method({"GET", "POST"})
     */
    public function reportByDateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $datos = $request->get("json", null);
        $params = json_decode($datos);
        $authCheck = $helpers->authCheck($hash);
        $reporteFecha = $em->getRepository('AppBundle:TramiteSolicitud')->getReporteFecha($params);

        if ($reporteFecha) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "Lista de tramites",
                'data' => $reporteFecha,
            );} else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "No hay tramites entre esas fechas",
            );
        }
        return $helpers->json($response);
    }

}
