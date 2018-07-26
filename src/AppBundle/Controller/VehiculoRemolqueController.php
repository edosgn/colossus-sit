<?php

namespace AppBundle\Controller;

use AppBundle\Entity\VehiculoRemolque;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Vehiculoremolque controller.
 *
 * @Route("vehiculoremolque")
 */
class VehiculoRemolqueController extends Controller
{
    /**
     * Lists all vehiculoRemolque entities.
     *
     * @Route("/", name="vehiculoremolque_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $vehiculoRemolques = $em->getRepository('AppBundle:VehiculoRemolque')->findAll();

        return $this->render('vehiculoremolque/index.html.twig', array(
            'vehiculoRemolques' => $vehiculoRemolques,
        ));
    }

    /**
     * Creates a new vehiculoRemolque entity.
     *
     * @Route("/new", name="vehiculoremolque_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $vehiculoRemolque = new Vehiculoremolque();
        $form = $this->createForm('AppBundle\Form\VehiculoRemolqueType', $vehiculoRemolque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($vehiculoRemolque);
            $em->flush();

            return $this->redirectToRoute('vehiculoremolque_show', array('id' => $vehiculoRemolque->getId()));
        }

        return $this->render('vehiculoremolque/new.html.twig', array(
            'vehiculoRemolque' => $vehiculoRemolque,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a vehiculoRemolque entity.
     *
     * @Route("/{id}", name="vehiculoremolque_show")
     * @Method("GET")
     */
    public function showAction(VehiculoRemolque $vehiculoRemolque)
    {
        $deleteForm = $this->createDeleteForm($vehiculoRemolque);

        return $this->render('vehiculoremolque/show.html.twig', array(
            'vehiculoRemolque' => $vehiculoRemolque,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vehiculoRemolque entity.
     *
     * @Route("/{id}/edit", name="vehiculoremolque_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, VehiculoRemolque $vehiculoRemolque)
    {
        $deleteForm = $this->createDeleteForm($vehiculoRemolque);
        $editForm = $this->createForm('AppBundle\Form\VehiculoRemolqueType', $vehiculoRemolque);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vehiculoremolque_edit', array('id' => $vehiculoRemolque->getId()));
        }

        return $this->render('vehiculoremolque/edit.html.twig', array(
            'vehiculoRemolque' => $vehiculoRemolque,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a vehiculoRemolque entity.
     *
     * @Route("/{id}", name="vehiculoremolque_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, VehiculoRemolque $vehiculoRemolque)
    {
        $form = $this->createDeleteForm($vehiculoRemolque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vehiculoRemolque);
            $em->flush();
        }

        return $this->redirectToRoute('vehiculoremolque_index');
    }

    /**
     * Displays a form to edit an existing VehiculoRemolque entity.
     *
     * @Route("/transformacion", name="vehiculo_transformacion")
     * @Method({"GET", "POST"})
     */
    public function transformacionVehiculoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("json",null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            $vehiculo = $em->getRepository('AppBundle:Vehiculo')->find($params->idVehiculo);
            $vehiculoRemolque = $em->getRepository("AppBundle:VehiculoRemolque")->findOneByVehiculo($vehiculo->getId());
            $usuario = $em->getRepository("AppBundle:Ciudadano")->find($vehiculoRemolque->getCiudadano()->getId());
            $clase = $em->getRepository("AppBundle:Clase")->find($vehiculoRemolque->getClase()->getId());
            
            if ($vehiculoRemolque!=null) {                
                $vehiculoRemolque->setVehiculo($vehiculo);
                $vehiculoRemolque->setUsuario($usuario);
                $vehiculoRemolque->setClase($clase);
                $vehiculoRemolque->setNumeroEjes($params->nuevoNumeroEjes);
                $vehiculoRemolque->setFichaTecnica($params->numeroFTH);
                $vehiculoRemolque->setPesoVacio($params->pesoVacio);
                $vehiculoRemolque->setCargaUtil($params->cargaUtil);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Vehiculo editado con éxito", 
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El vehiculo no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar vehiculo", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a vehiculoRemolque entity.
     *
     * @param VehiculoRemolque $vehiculoRemolque The vehiculoRemolque entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VehiculoRemolque $vehiculoRemolque)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vehiculoremolque_delete', array('id' => $vehiculoRemolque->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
