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
            $json = $request->get("json", null);
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
            $json = $request->get("json", null);
            $params = json_decode($json);
            
            $soat = new VhloSoat();

            $em = $this->getDoctrine()->getManager();
            if ($params->idMunicipio) {
                $municipio = $em->getRepository('AppBundle:Municipio')->find(
                    $params->idMunicipio
                );
                $soat->setMunicipio($municipio);
            }

            if ($params->idVehiculo) {
                $vehiculo = $em->getRepository('AppBundle:Vehiculo')->find(
                    $params->idVehiculo
                );
                $soat->setVehiculo($vehiculo);
            }

            $soat->setFechaExpedicion(new \Datetime($params->fechaExpedicion));
            $soat->setFechaVigencia(new \Datetime($params->fechaVigencia));
            $soat->setFechaVencimiento(new \Datetime($params->fechaVencimiento));
            $soat->setNumeroPoliza($params->numeroPoliza);
            $soat->setNombreEmpresa($params->nombreEmpresa);
            $soat->setActivo(true);
            $soat->setEstado("Disponible");
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
     * @Route("/{id}/edit", name="vhlosoat_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, VhloSoat $vhloSoat)
    {
        $deleteForm = $this->createDeleteForm($vhlosoat);
        $editForm = $this->createForm('JHWEB\VehiculoBundle\Form\vhloSoatType', $vhloSoat);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vhlosoat_edit', array('id' => $vhloSoat->getId()));
        }

        return $this->render('vhlosoat/edit.html.twig', array(
            'vhlosoat' => $vhloSoat,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a VhloSoat entity.
     *
     * @Route("/{id}", name="vhlosoat_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, VhloSoat $vhloSoat)
    {
        $form = $this->createDeleteForm($vhloSoat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vhloSoat);
            $em->flush();
        }

        return $this->redirectToRoute('vhlosoat_index');
    }

    /**
     * Creates a form to delete a vhloSoat entity.
     *
     * @param VhloSoat $vhloSoat The vhloSoat entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloSoat $vhloSoat)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhlosoat_delete', array('id' => $vhloSoat->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
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
            $json = $request->get("json",null);
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
