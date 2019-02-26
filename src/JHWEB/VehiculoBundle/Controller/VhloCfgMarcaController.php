<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloCfgMarca;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlocfgmarca controller.
 *
 * @Route("vhlocfgmarca")
 */
class VhloCfgMarcaController extends Controller
{
    /**
     * Lists all vhloCfgMarca entities.
     *
     * @Route("/", name="vhlocfgmarca_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $marcas = $em->getRepository('JHWEBVehiculoBundle:VhloCfgMarca')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($marcas) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($marcas)." registros encontrados", 
                'data'=> $marcas,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new vhloCfgMarca entity.
     *
     * @Route("/new", name="vhlocfgmarca_new")
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
           
            $marca = new VhloCfgMarca();

            $marca->setNombre($params->nombre);
            $marca->setCodigo($params->codigo);
            $marca->setActivo(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($marca);
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
     * Finds and displays a vhloCfgMarca entity.
     *
     * @Route("/show/", name="vhlocfgmarca_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            $marca = $em->getRepository("JHWEBVehiculoBundle:VhloCfgMarca")->find($params->id);

            if ($marca) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado con exito", 
                    'data'=> $marca,
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
     * Displays a form to edit an existing vhloCfgMarca entity.
     *
     * @Route("/edit", name="vhlocfgmarca_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            $marca = $em->getRepository("JHWEBVehiculoBundle:VhloCfgMarca")->find($params->id);

            if ($marca) {
                $marca->setNombre($params->nombre);
                $marca->setCodigo($params->codigo);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $marca,
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
     * Deletes a vhloCfgMarca entity.
     *
     * @Route("/{id}/delete", name="vhlocfgmarca_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            $marca = $em->getRepository("JHWEBVehiculoBundle:VhloCfgMarca")->find($id);

            if ($marca) {
                $marca->setActivo(false);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro eliminado con exito", 
                    'data'=> $marca,
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
     * Creates a form to delete a vhloCfgMarca entity.
     *
     * @param VhloCfgMarca $vhloCfgMarca The vhloCfgMarca entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloCfgMarca $vhloCfgMarca)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhlocfgmarca_delete', array('id' => $vhloCfgMarca->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="vhlocfgmarca_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $marcas = $em->getRepository('JHWEBVehiculoBundle:VhloCfgMarca')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($marcas as $key => $marca) {
            $response[$key] = array(
                'value' => $marca->getId(),
                'label' => $marca->getNombre()
            );
        }
        
        return $helpers->json($response);
    }
}
