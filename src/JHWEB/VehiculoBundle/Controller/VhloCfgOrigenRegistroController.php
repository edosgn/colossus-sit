<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloCfgOrigenRegistro;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlocfgorigenregistro controller.
 *
 * @Route("vhlocfgorigenregistro")
 */
class VhloCfgOrigenRegistroController extends Controller
{
    /**
     * Lists all vhloCfgOrigenRegistro entities.
     *
     * @Route("/", name="vhlocfgorigenregistro_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $origenesRegistro = $em->getRepository('JHWEBVehiculoBundle:VhloCfgOrigenRegistro')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($origenesRegistro) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($origenesRegistro)." registros encontrados", 
                'data'=> $origenesRegistro,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new vhloCfgOrigenRegistro entity.
     *
     * @Route("/new", name="vhlocfgorigenregistro_new")
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
           
            $origenRegistro = new VhloCfgOrigenRegistro();

            $origenRegistro->setNombre($params->nombre);
            $origenRegistro->setActivo(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($origenRegistro);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con exito",
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
     * Finds and displays a vhloCfgOrigenRegistro entity.
     *
     * @Route("/{id}/show", name="vhlocfgorigenregistro_show")
     * @Method("GET")
     */
    public function showAction(VhloCfgOrigenRegistro $vhloCfgOrigenRegistro)
    {
        $deleteForm = $this->createDeleteForm($vhloCfgOrigenRegistro);

        return $this->render('vhlocfgorigenregistro/show.html.twig', array(
            'vhloCfgOrigenRegistro' => $vhloCfgOrigenRegistro,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vhloCfgOrigenRegistro entity.
     *
     * @Route("/edit", name="vhlocfgorigenregistro_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            $origenRegistro = $em->getRepository("JHWEBVehiculoBundle:VhloCfgOrigenRegistro")->find($params->id);

            if ($origenRegistro) {
                $origenRegistro->setNombre($params->nombre);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $origenRegistro,
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
                    'message' => "Autorizacion no valida para editar", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a vhloCfgOrigenRegistro entity.
     *
     * @Route("/delete", name="vhlocfgorigenregistro_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            $origenRegistro = $em->getRepository("JHWEBVehiculoBundle:VhloCfgOrigenRegistro")->find($params->id);

            if ($origenRegistro) {
                $origenRegistro->setActivo(false);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro eliminado con exito", 
                    'data'=> $origenRegistro,
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
                    'message' => "Autorizacion no valida para editar", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a vhloCfgOrigenRegistro entity.
     *
     * @param VhloCfgOrigenRegistro $vhloCfgOrigenRegistro The vhloCfgOrigenRegistro entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloCfgOrigenRegistro $vhloCfgOrigenRegistro)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhlocfgorigenregistro_delete', array('id' => $vhloCfgOrigenRegistro->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="vhlocfgorigenregistro_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $origenesRegistro = $em->getRepository('JHWEBVehiculoBundle:VhloCfgOrigenRegistro')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($origenesRegistro as $key => $origenRegistro) {
            $response[$key] = array(
                'value' => $origenRegistro->getId(),
                'label' => $origenRegistro->getNombre()
            );
        }
        return $helpers->json($response);
    }
}
