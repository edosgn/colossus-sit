<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloCfgTipoRodaje;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlocfgtiporodaje controller.
 *
 * @Route("vhlocfgtiporodaje")
 */
class VhloCfgTipoRodajeController extends Controller
{
    /**
     * Lists all vhloCfgTipoRodaje entities.
     *
     * @Route("/", name="vhlocfgtiporodaje_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $tiposRodaje = $em->getRepository('JHWEBVehiculoBundle:VhloCfgTipoRodaje')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($tiposRodaje) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($tiposRodaje)." registros encontrados", 
                'data'=> $tiposRodaje,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new vhloCfgTipoRodaje entity.
     *
     * @Route("/new", name="vhlocfgtiporodaje_new")
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
           
            $tipoRodaje = new VhloCfgTipoRodaje();

            $tipoRodaje->setNombre($params->nombre);
            $tipoRodaje->setActivo(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($tipoRodaje);
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
     * Finds and displays a vhloCfgTipoRodaje entity.
     *
     * @Route("/{id}/show", name="vhlocfgtiporodaje_show")
     * @Method("GET")
     */
    public function showAction(VhloCfgTipoRodaje $vhloCfgTipoRodaje)
    {
        $deleteForm = $this->createDeleteForm($vhloCfgTipoRodaje);

        return $this->render('vhlocfgtiporodaje/show.html.twig', array(
            'vhloCfgTipoRodaje' => $vhloCfgTipoRodaje,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vhloCfgTipoRodaje entity.
     *
     * @Route("/edit", name="vhlocfgtiporodaje_edit")
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
            $tipoRodaje = $em->getRepository("JHWEBVehiculoBundle:VhloCfgTipoRodaje")->find($params->id);

            if ($tipoRodaje) {
                $tipoRodaje->setNombre($params->nombre);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $tipoRodaje,
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
     * Deletes a vhloCfgTipoRodaje entity.
     *
     * @Route("/delete", name="vhlocfgtiporodaje_delete")
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
            $tipoRodaje = $em->getRepository("JHWEBVehiculoBundle:VhloCfgTipoRodaje")->find($params->id);

            if ($tipoRodaje) {
                $tipoRodaje->setActivo(false);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro eliminado con exito", 
                    'data'=> $tipoRodaje,
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
     * Creates a form to delete a vhloCfgTipoRodaje entity.
     *
     * @param VhloCfgTipoRodaje $vhloCfgTipoRodaje The vhloCfgTipoRodaje entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloCfgTipoRodaje $vhloCfgTipoRodaje)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhlocfgtiporodaje_delete', array('id' => $vhloCfgTipoRodaje->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="vhlocfgtiporodaje_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $tiposRodaje = $em->getRepository('JHWEBVehiculoBundle:VhloCfgTipoRodaje')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($tiposRodaje as $key => $tipoRodaje) {
            $response[$key] = array(
                'value' => $tipoRodaje->getId(),
                'label' => $tipoRodaje->getNombre()
            );
        }
        
        return $helpers->json($response);
    }
}
