<?php

namespace AppBundle\Controller;

use AppBundle\Entity\VehiculoLimitacion;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;use Symfony\Component\HttpFoundation\Request;

/**
 * Vehiculolimitacion controller.
 *
 * @Route("vehiculoLimitacion")
 */
class VehiculoLimitacionController extends Controller
{
    /**
     * Lists all vehiculoLimitacion entities.
     *
     * @Route("/", name="vehiculoLimitacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $vehiculosLimitaciones = $em->getRepository('AppBundle:VehiculoLimitacion')->findAll();
        $response = array(
            'status' => 'success',
            'code' => 200,
            'msj' => "Lista de vehiculos con limitaciones",
            'data' => $vehiculosLimitaciones,
        );
        return $helpers->json($response);
    }

    /**
     * Creates a new vehiculoLimitacion entity.
     *
     * @Route("/new", name="vehiculoLimitacion_new")
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

            $limitacionDatosId = $params->limitacionDatosId;
            $vehiculoId = $params->vehiculoId;
            $em = $this->getDoctrine()->getManager();
            $limitacionDatos = $em->getRepository('AppBundle:LimitacionDatos')->find($limitacionDatosId);
            $vehiculo = $em->getRepository('AppBundle:Vehiculo')->find($vehiculoId);

            $vehiculoLimitacion = new LimitacionDatos();

            $vehiculoLimitacion->setLimitacionDatos($limitacionDatos);
            $vehiculoLimitacion->setVehiculo($vehiculo);
            $vehiculoLimitacion->setEstado(true);

            $em->persist($vehiculoLimitacion);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "Registro creado con exito",
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "El registro ya se encuentra registrado",
            );
        }
        // }

        return $helpers->json($response);
    }

    /**
     * Finds and displays a vehiculoLimitacion entity.
     *
     * @Route("/{id}", name="vehiculoLimitacion_show")
     * @Method("GET")
     */
    public function showAction(VehiculoLimitacion $vehiculoLimitacion)
    {
        $deleteForm = $this->createDeleteForm($vehiculoLimitacion);

        return $this->render('vehiculoLimitacion/show.html.twig', array(
            'vehiculoLimitacion' => $vehiculoLimitacion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vehiculoLimitacion entity.
     *
     * @Route("/{id}/edit", name="vehiculoLimitacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, VehiculoLimitacion $vehiculoLimitacion)
    {
        $deleteForm = $this->createDeleteForm($vehiculoLimitacion);
        $editForm = $this->createForm('AppBundle\Form\VehiculoLimitacionType', $vehiculoLimitacion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vehiculoLimitacion_edit', array('id' => $vehiculoLimitacion->getId()));
        }

        return $this->render('vehiculoLimitacion/edit.html.twig', array(
            'vehiculoLimitacion' => $vehiculoLimitacion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a vehiculoLimitacion entity.
     *
     * @Route("/{id}", name="vehiculoLimitacion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, VehiculoLimitacion $vehiculoLimitacion)
    {
        $form = $this->createDeleteForm($vehiculoLimitacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vehiculoLimitacion);
            $em->flush();
        }

        return $this->redirectToRoute('vehiculoLimitacion_index');
    }

    /**
     * Creates a form to delete a vehiculoLimitacion entity.
     *
     * @param VehiculoLimitacion $vehiculoLimitacion The vehiculoLimitacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VehiculoLimitacion $vehiculoLimitacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vehiculoLimitacion_delete', array('id' => $vehiculoLimitacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
