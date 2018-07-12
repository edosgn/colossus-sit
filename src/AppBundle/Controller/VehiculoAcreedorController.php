<?php

namespace AppBundle\Controller;

use AppBundle\Entity\VehiculoAcreedor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Vehiculoacreedor controller.
 *
 * @Route("vehiculoacreedor")
 */
class VehiculoAcreedorController extends Controller
{
    /**
     * Lists all vehiculoAcreedor entities.
     *
     * @Route("/", name="vehiculocreedor_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $vehiculoAcreedor = $em->getRepository('AppBundle:VehiculoAcreedor')->findBy(
            array('estado' => 1)
        );
        $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado acreedores", 
                    'data'=> $vehiculoAcreedor,
            );
         
        return $helpers->json($response);
    }

    /**
     * Creates a new vehiculoAcreedor entity.
     *
     * @Route("/new", name="vehiculoacreedor_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        // var_dump($authCheck);
        // die();
        if ($authCheck== true) {
            $json = $request->get("json",null);
            $params = json_decode($json);
            $vehiculoId = $params->vehiculoId;
            $bancoId = $params->bancoId;
            $em = $this->getDoctrine()->getManager();
            $vehiculo = $em->getRepository('AppBundle:Vehiculo')->find($vehiculoId);
            $banco = $em->getRepository('AppBundle:Banco')->findOneByNombre($bancoId);

            $vehiculoAcreedor = new VehiculoAcreedor();

            $vehiculoAcreedor->setVehiculo($vehiculo);
            $vehiculoAcreedor->setBanco($banco);
            
            $em->persist($vehiculoAcreedor);
            $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro creado con exito", 
                );
            // }
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
     * Finds and displays a vehiculoAcreedor entity.
     *
     * @Route("/{id}", name="vehiculoacreedor_show")
     * @Method("GET")
     */
    public function showAction(VehiculoAcreedor $vehiculoAcreedor)
    {
        $deleteForm = $this->createDeleteForm($vehiculoAcreedor);

        return $this->render('vehiculoacreedor/show.html.twig', array(
            'vehiculoAcreedor' => $vehiculoAcreedor,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vehiculoAcreedor entity.
     *
     * @Route("/{id}/edit", name="vehiculoacreedor_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, VehiculoAcreedor $vehiculoAcreedor)
    {
        $deleteForm = $this->createDeleteForm($vehiculoAcreedor);
        $editForm = $this->createForm('AppBundle\Form\VehiculoAcreedorType', $vehiculoAcreedor);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vehiculoacreedor_edit', array('id' => $vehiculoAcreedor->getId()));
        }

        return $this->render('vehiculoacreedor/edit.html.twig', array(
            'vehiculoAcreedor' => $vehiculoAcreedor,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a vehiculoAcreedor entity.
     *
     * @Route("/{id}", name="vehiculoacreedor_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, VehiculoAcreedor $vehiculoAcreedor)
    {
        $form = $this->createDeleteForm($vehiculoAcreedor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vehiculoAcreedor);
            $em->flush();
        }

        return $this->redirectToRoute('vehiculoacreedor_index');
    }

    /**
     * Creates a form to delete a vehiculoAcreedor entity.
     *
     * @param VehiculoAcreedor $vehiculoAcreedor The vehiculoAcreedor entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VehiculoAcreedor $vehiculoAcreedor)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vehiculoacreedor_delete', array('id' => $vehiculoAcreedor->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
