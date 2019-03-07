<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloPropietario;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlopropietario controller.
 *
 * @Route("vhlopropietario")
 */
class VhloPropietarioController extends Controller
{
    /**
     * Lists all vhloPropietario entities.
     *
     * @Route("/", name="vhlopropietario_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $vhloPropietarios = $em->getRepository('JHWEBVehiculoBundle:VhloPropietario')->findAll();

        return $this->render('vhlopropietario/index.html.twig', array(
            'vhloPropietarios' => $vhloPropietarios,
        ));
    }

    /**
     * Creates a new vhloPropietario entity.
     *
     * @Route("/new", name="vhlopropietario_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $vhloPropietario = new Vhlopropietario();
        $form = $this->createForm('JHWEB\VehiculoBundle\Form\VhloPropietarioType', $vhloPropietario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($vhloPropietario);
            $em->flush();

            return $this->redirectToRoute('vhlopropietario_show', array('id' => $vhloPropietario->getId()));
        }

        return $this->render('vhlopropietario/new.html.twig', array(
            'vhloPropietario' => $vhloPropietario,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a vhloPropietario entity.
     *
     * @Route("/{id}/show", name="vhlopropietario_show")
     * @Method("GET")
     */
    public function showAction(VhloPropietario $vhloPropietario)
    {
        $deleteForm = $this->createDeleteForm($vhloPropietario);

        return $this->render('vhlopropietario/show.html.twig', array(
            'vhloPropietario' => $vhloPropietario,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vhloPropietario entity.
     *
     * @Route("/{id}/edit", name="vhlopropietario_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, VhloPropietario $vhloPropietario)
    {
        $deleteForm = $this->createDeleteForm($vhloPropietario);
        $editForm = $this->createForm('JHWEB\VehiculoBundle\Form\VhloPropietarioType', $vhloPropietario);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vhlopropietario_edit', array('id' => $vhloPropietario->getId()));
        }

        return $this->render('vhlopropietario/edit.html.twig', array(
            'vhloPropietario' => $vhloPropietario,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a vhloPropietario entity.
     *
     * @Route("/{id}/delete", name="vhlopropietario_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, VhloPropietario $vhloPropietario)
    {
        $form = $this->createDeleteForm($vhloPropietario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vhloPropietario);
            $em->flush();
        }

        return $this->redirectToRoute('vhlopropietario_index');
    }

    /**
     * Creates a form to delete a vhloPropietario entity.
     *
     * @param VhloPropietario $vhloPropietario The vhloPropietario entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloPropietario $vhloPropietario)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhlopropietario_delete', array('id' => $vhloPropietario->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ============================================== */

    /**
     * Lists all userCfgMenu entities.
     *
     * @Route("/search/filter", name="vhlopropietario_search_filter")
     * @Method({"GET", "POST"})
     */
    public function searchByFilterAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->getByFilter($params->filtro);

            if ($vehiculo) {
                $propietarios = $em->getRepository('JHWEBVehiculBundle:VhloPropietario')->findBy(
                    array(
                        'vehiculo' => $vehiculo->getId(),
                        'permiso' => true,
                        'estado' => true,
                        'activo' => true,
                    )
                );

                if ($propietarios) {
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => count($propietarios).' propietarios encontrados.', 
                        'data'=> array(
                            'vehiculo' => $vehiculo,
                            'propietarios' => $propietarios,
                        )
                    );
                }else{ 
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => 'Este vehiculo no tiene propietarios registrados.', 
                        'data' => array(
                            'vehiculo' => $vehiculo,
                            'propietarios' => null,
                        ) 
                    );
                } 
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Registro no encontrado en base de datos.', 
                );
            }            
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida para editar', 
            );
        }


        return $helpers->json($response);
    }
}
