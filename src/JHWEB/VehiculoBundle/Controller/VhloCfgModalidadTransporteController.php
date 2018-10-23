<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloCfgModalidadTransporte;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlocfgmodalidadtransporte controller.
 *
 * @Route("vhlocfgmodalidadtransporte")
 */
class VhloCfgModalidadTransporteController extends Controller
{
    /**
     * Lists all vhloCfgModalidadTransporte entities.
     *
     * @Route("/", name="vhlocfgmodalidadtransporte_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $modalidadesTransporte = $em->getRepository('JHWEBVehiculoBundle:VhloCfgModalidadTransporte')->findBy(
            array('activo'=>true)
        );

        $response['data'] = array();

        if ($modalidadesTransporte) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($modalidadesTransporte)." Registros encontrados", 
                'data'=> $modalidadesTransporte,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new vhloCfgModalidadTransporte entity.
     *
     * @Route("/new", name="vhlocfgmodalidadtransporte_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization",null);
        $authCheck = $helpers->authCheck($hash);

        if($authCheck == true){
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $modalidadTransporte = new VhloCfgModalidadTransporte();

            $modalidadTransporte->setNombre(strtoupper($params->nombre));
            $modalidadTransporte->setGestionable($params->gestionable);
            $modalidadTransporte->setActivo(true);
            
            $em->persist($modalidadTransporte);
            $em->flush();
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con éxito",
            );
        
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no valida",
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Finds and displays a vhloCfgModalidadTransporte entity.
     *
     * @Route("/show", name="vhlocfgmodalidadtransporte_show")
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

            $modalidadTransporte = $em->getRepository('JHWEBVehiculoBundle:VhloCfgModalidadTransporte')->find($params->id);

            if ($modalidadTransporte) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado", 
                    'data'=> $modalidadTransporte,
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
     * Displays a form to edit an existing vhloCfgModalidadTransporte entity.
     *
     * @Route("/edit", name="vhlocfgmodalidadtransporte_edit")
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
            $modalidadTransporte = $em->getRepository("JHWEBVehiculoBundle:VhloCfgModalidadTransporte")->find($params->id);

            if ($modalidadTransporte) {
                $modalidadTransporte->setNombre(strtoupper($params->nombre));
                $modalidadTransporte->setGestionable($params->gestionable);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $modalidadTransporte,
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
     * Deletes a vhloCfgModalidadTransporte entity.
     *
     * @Route("/delete", name="vhlocfgmodalidadtransporte_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if($authCheck == true){
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            $modalidadTransporte = $em->getRepository('JHWEBVehiculoBundle:VhloCfgModalidadTransporte')->find($params->id);
            $modalidadTransporte->setActivo(false);

            $em->flush();

            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro eliminado con éxito", 
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no valida", 
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a vhloCfgModalidadTransporte entity.
     *
     * @param VhloCfgModalidadTransporte $vhloCfgModalidadTransporte The vhloCfgModalidadTransporte entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloCfgModalidadTransporte $vhloCfgModalidadTransporte)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhlocfgmodalidadtransporte_delete', array('id' => $vhloCfgModalidadTransporte->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="vhlocfgmodalidadtransporte_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $modalidadesTransporte = $em->getRepository('JHWEBVehiculoBundle:VhloCfgModalidadTransporte')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($modalidadesTransporte as $key => $modalidadTransporte) {
            $response[$key] = array(
                'value' => $modalidadTransporte->getId(),
                'label' => $modalidadTransporte->getNombre()
            );
        }
        
        return $helpers->json($response);
    }
}
