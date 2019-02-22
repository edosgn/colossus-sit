<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloCfgTipoVehiculo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlocfgtipovehiculo controller.
 *
 * @Route("vhlocfgtipovehiculo")
 */
class VhloCfgTipoVehiculoController extends Controller
{
    /**
     * Lists all vhloCfgTipoVehiculo entities.
     *
     * @Route("/", name="vhlocfgtipovehiculo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $vhloCfgTipoVehiculos = $em->getRepository('JHWEBVehiculoBundle:VhloCfgTipoVehiculo')->findAll();

        return $this->render('vhlocfgtipovehiculo/index.html.twig', array(
            'vhloCfgTipoVehiculos' => $vhloCfgTipoVehiculos,
        ));
    }

    /**
     * Creates a new vhloCfgTipoVehiculo entity.
     *
     * @Route("/new", name="vhlocfgtipovehiculo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $vhloCfgTipoVehiculo = new Vhlocfgtipovehiculo();
        $form = $this->createForm('JHWEB\VehiculoBundle\Form\VhloCfgTipoVehiculoType', $vhloCfgTipoVehiculo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($vhloCfgTipoVehiculo);
            $em->flush();

            return $this->redirectToRoute('vhlocfgtipovehiculo_show', array('id' => $vhloCfgTipoVehiculo->getId()));
        }

        return $this->render('vhlocfgtipovehiculo/new.html.twig', array(
            'vhloCfgTipoVehiculo' => $vhloCfgTipoVehiculo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a vhloCfgTipoVehiculo entity.
     *
     * @Route("/show", name="vhlocfgtipovehiculo_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $tipo = $em->getRepository('JHWEBVehiculoBundle:VhloCfgTipoVehiculo')->find(
                $params->id
            );

            if ($tipo) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado.", 
                    'data'=> $tipo
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos",
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
     * Displays a form to edit an existing vhloCfgTipoVehiculo entity.
     *
     * @Route("/{id}/edit", name="vhlocfgtipovehiculo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, VhloCfgTipoVehiculo $vhloCfgTipoVehiculo)
    {
        $deleteForm = $this->createDeleteForm($vhloCfgTipoVehiculo);
        $editForm = $this->createForm('JHWEB\VehiculoBundle\Form\VhloCfgTipoVehiculoType', $vhloCfgTipoVehiculo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vhlocfgtipovehiculo_edit', array('id' => $vhloCfgTipoVehiculo->getId()));
        }

        return $this->render('vhlocfgtipovehiculo/edit.html.twig', array(
            'vhloCfgTipoVehiculo' => $vhloCfgTipoVehiculo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a vhloCfgTipoVehiculo entity.
     *
     * @Route("/{id}/delete", name="vhlocfgtipovehiculo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, VhloCfgTipoVehiculo $vhloCfgTipoVehiculo)
    {
        $form = $this->createDeleteForm($vhloCfgTipoVehiculo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vhloCfgTipoVehiculo);
            $em->flush();
        }

        return $this->redirectToRoute('vhlocfgtipovehiculo_index');
    }

    /**
     * Creates a form to delete a vhloCfgTipoVehiculo entity.
     *
     * @param VhloCfgTipoVehiculo $vhloCfgTipoVehiculo The vhloCfgTipoVehiculo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloCfgTipoVehiculo $vhloCfgTipoVehiculo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhlocfgtipovehiculo_delete', array('id' => $vhloCfgTipoVehiculo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* =================================================== */

    /**
     * Listado de tipos de formato para seleccion con busqueda
     *
     * @Route("/select", name="cfgadminformatotipo_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $tipos = $em->getRepository('JHWEBVehiculoBundle:VhloCfgTipoVehiculo')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($tipos as $key => $tipo) {
            $response[$key] = array(
                'value' => $tipo->getId(),
                'label' => $tipo->getNombre(),
            );
        }

        return $helpers->json($response);
    }
}
