<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloCfgTipoMaquinaria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlocfgtipomaquinarium controller.
 *
 * @Route("vhlocfgtipomaquinaria")
 */
class VhloCfgTipoMaquinariaController extends Controller
{
    /**
     * Lists all vhloCfgTipoMaquinarium entities.
     *
     * @Route("/", name="vhlocfgtipomaquinaria_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $tiposMaquinaria = $em->getRepository('JHWEBVehiculoBundle:VhloCfgTipoMaquinaria')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($tiposMaquinaria) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($tiposMaquinaria)." registros encontrados", 
                'data'=> $tiposMaquinaria,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new vhloCfgTipoMaquinarium entity.
     *
     * @Route("/new", name="vhlocfgtipomaquinaria_new")
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
           
            $tipoMaquinaria = new VhloCfgTipoMaquinaria();

            $tipoMaquinaria->setNombre($params->nombre);
            $tipoMaquinaria->setCodigo($params->codigo);
            $tipoMaquinaria->setActivo(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($tipoMaquinaria);
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
     * Finds and displays a vhloCfgTipoMaquinarium entity.
     *
     * @Route("/{id}/show", name="vhlocfgtipomaquinaria_show")
     * @Method("GET")
     */
    public function showAction(VhloCfgTipoMaquinaria $vhloCfgTipoMaquinarium)
    {
        $deleteForm = $this->createDeleteForm($vhloCfgTipoMaquinarium);

        return $this->render('vhlocfgtipomaquinaria/show.html.twig', array(
            'vhloCfgTipoMaquinarium' => $vhloCfgTipoMaquinarium,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vhloCfgTipoMaquinarium entity.
     *
     * @Route("/edit", name="vhlocfgtipomaquinaria_edit")
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
            $tipoMaquinaria = $em->getRepository("JHWEBVehiculoBundle:VhloCfgTipoMaquinaria")->find($params->id);

            if ($tipoMaquinaria) {
                $tipoMaquinaria->setNombre($params->nombre);
                $tipoMaquinaria->setCodigo($params->codigo);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $tipoMaquinaria,
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
     * Deletes a vhloCfgTipoMaquinarium entity.
     *
     * @Route("/delete", name="vhlocfgtipomaquinaria_delete")
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
            $tipoMaquinaria = $em->getRepository("JHWEBVehiculoBundle:VhloCfgTipoMaquinaria")->find($params->id);

            if ($tipoMaquinaria) {
                $tipoMaquinaria->setActivo(false);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro eliminado con exito", 
                    'data'=> $tipoMaquinaria,
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
     * Creates a form to delete a vhloCfgTipoMaquinarium entity.
     *
     * @param VhloCfgTipoMaquinaria $vhloCfgTipoMaquinarium The vhloCfgTipoMaquinarium entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloCfgTipoMaquinaria $vhloCfgTipoMaquinarium)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhlocfgtipomaquinaria_delete', array('id' => $vhloCfgTipoMaquinarium->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="vhlocfgtipomaquinaria_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $tiposMaquinaria = $em->getRepository('JHWEBVehiculoBundle:VhloCfgTipoMaquinaria')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($tiposMaquinaria as $key => $tipoMaquinaria) {
            $response[$key] = array(
                'value' => $tipoMaquinaria->getId(),
                'label' => $tipoMaquinaria->getNombre()
            );
        }
        
        return $helpers->json($response);
    }
}
