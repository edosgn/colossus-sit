<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TramiteSolicitud;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
     * @Route("/", name="tramitesolicitud_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $tramitesSolicitud = $em->getRepository('AppBundle:TramiteSolicitud')->findAll();

        $response = array(
            'status' => 'success',
            'code' => 200,
            'msj' => "Lista de tramites",
            'data' => $tramitesSolicitud, 
        );
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

        if ($authCheck== true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            /*if (count($params)==0) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Los campos no pueden estar vacios", 
                );
            }else{*/
                $observacion = (isset($params->observacion)) ? $params->observacion : null;
                $documentacionCompleta = (isset($params->documentacionCompleta)) ? $params->documentacionCompleta : false;
                $fechaSolicitudDateTime = new \DateTime(date('Y-m-d h:i:s'));
                $datos = $params->datos;
                //Captura llaves foraneas
                $tramiteFacturaId = $params->tramiteFacturaId;

                $em = $this->getDoctrine()->getManager();
                $tramiteFactura = $em->getRepository('AppBundle:TramiteFactura')->find($tramiteFacturaId);

                $tramiteSolicitud = new TramiteSolicitud();

                $tramiteSolicitud->setObservacion($observacion);
                $tramiteSolicitud->setDocumentacion($documentacionCompleta);
                $tramiteSolicitud->setFecha($fechaSolicitudDateTime);
                $tramiteSolicitud->setEstado(true);
                $tramiteSolicitud->setDatos($datos);
                //Inserta llaves foraneas
                $tramiteSolicitud->setTramiteFactura($tramiteFactura);

                $em = $this->getDoctrine()->getManager();
                $em->persist($tramiteSolicitud);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro creado con exito", 
                );
            //}
        }else{
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
     * @Route("/{id}", name="tramitesolicitud_delete")
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
}
