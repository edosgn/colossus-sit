<?php

namespace JHWEB\FinancieroBundle\Controller;

use JHWEB\FinancieroBundle\Entity\FroTrteSolicitud;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Frotrtesolicitud controller.
 *
 * @Route("frotrtesolicitud")
 */
class FroTrteSolicitudController extends Controller
{
    /**
     * Lists all froTrteSolicitud entities.
     *
     * @Route("/", name="frotrtesolicitud_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $tramitesSolicitud = $em->getRepository('JHWEBFinancieroBundle:FroTrteSolicitud')->findBy(
            array(
                'activo' => true
            )
        );

        $response['data'] = array();

        if ($tramitesSolicitud) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($tramitesSolicitud)." registros encontrados", 
                'data'=> $tramitesSolicitud,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new froTrteSolicitud entity.
     *
     * @Route("/new", name="frotrtesolicitud_new")
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

            $tramiteSolicitud = new FroTrteSolicitud();

            $tramiteSolicitud->setFecha(new \DateTime(date('Y-m-d')));
            $tramiteSolicitud->setHora(new \DateTime(date('h:i:s')));
            if ($params->observacion) {
                $tramiteSolicitud->setObservacion($observacion);
            }
            $tramiteSolicitud->setDocumentacion($params->documentacion);
            $tramiteSolicitud->setEstado(true);
            $tramiteSolicitud->setDatos((array)$params->datos->foraneas);
            $tramiteSolicitud->setResumen($params->datos->resumen);
        

            if ($params->idVehiculo) {
                $vehiculo = $em->getRepository('JWEBVehiculoBundle:VhloVehiculo')->find($params->idVehiculo);
                $tramiteSolicitud->setVehiculo($vehiculo);
            }

            if ($params->idSolicitante) {
                $propietario = $em->getRepository('JHWEBVehiculoBundle:VhloPropietario')->find(
                    $params->idSolicitante
                );
                $tramiteSolicitud->setSolicitante($propietario);
            }

            if ($params->idCiudadano) {
                $ciudadano = $em->getRepository('JHWEBUserBundle:UserCiudadano')->find(
                    $params->idCiudadano
                );
                $tramiteSolicitud->setApoderado($ciudadano);
            }

            if ($datos->idFactura && $datos->idTramite) {
                $factura = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->find(
                    $datos->idFactura
                );
                
                $tramite = $em->getRepository('JHWEBFinancieroBundle:FroTramite')->find(
                    $datos->idTramite
                );
                
                $tramiteFactura = $em->getRepository('JHWEBFinancieroBundle:FroFacTramite')->getByFacturaAndTramite($factura->getId(), $tramite->getId()
                );

                $tramiteSolicitud->setTramiteFactura($tramiteFactura);
                $tramiteFactura->setRealizado(true);

                $em->flush();
            }

            $em->persist($tramiteSolicitud);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Registro creado con exito.',
                'data' => $tramiteSolicitud
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
     * Finds and displays a froTrteSolicitud entity.
     *
     * @Route("/{id}", name="frotrtesolicitud_show")
     * @Method("GET")
     */
    public function showAction(FroTrteSolicitud $froTrteSolicitud)
    {
        $deleteForm = $this->createDeleteForm($froTrteSolicitud);

        return $this->render('frotrtesolicitud/show.html.twig', array(
            'froTrteSolicitud' => $froTrteSolicitud,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing froTrteSolicitud entity.
     *
     * @Route("/{id}/edit", name="frotrtesolicitud_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FroTrteSolicitud $froTrteSolicitud)
    {
        $deleteForm = $this->createDeleteForm($froTrteSolicitud);
        $editForm = $this->createForm('JHWEB\FinancieroBundle\Form\FroTrteSolicitudType', $froTrteSolicitud);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('frotrtesolicitud_edit', array('id' => $froTrteSolicitud->getId()));
        }

        return $this->render('frotrtesolicitud/edit.html.twig', array(
            'froTrteSolicitud' => $froTrteSolicitud,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a froTrteSolicitud entity.
     *
     * @Route("/{id}", name="frotrtesolicitud_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FroTrteSolicitud $froTrteSolicitud)
    {
        $form = $this->createDeleteForm($froTrteSolicitud);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($froTrteSolicitud);
            $em->flush();
        }

        return $this->redirectToRoute('frotrtesolicitud_index');
    }

    /**
     * Creates a form to delete a froTrteSolicitud entity.
     *
     * @param FroTrteSolicitud $froTrteSolicitud The froTrteSolicitud entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FroTrteSolicitud $froTrteSolicitud)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('frotrtesolicitud_delete', array('id' => $froTrteSolicitud->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ================================================ */

    /**
     * Busca trámites por módulo y parametros (No. placa, No. factura y fecha).
     *
     * @Route("/search/modulo/filter", name="frotrtesolicitud_search_modulo_filter")
     * @Method({"GET", "POST"})
     */
    public function searchByModuloAndFilterAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $tramites = $em->getRepository('AppBundle:TramiteSolicitud')->getByModuloAndFilter(
                $params
            );

            if ($tramites) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($tramites)." trámites encontrados", 
                    'data' => $tramites,
            );
            }else{
                 $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'No existen trámites para esos filtros de búsqueda, si desea registralo por favor presione el botón "NUEVO"', 
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
}
