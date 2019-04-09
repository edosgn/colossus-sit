<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloCfgLinea;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlocfglinea controller.
 *
 * @Route("vhlocfglinea")
 */
class VhloCfgLineaController extends Controller
{
    /**
     * Lists all vhloCfgLinea entities.
     *
     * @Route("/", name="vhlocfglinea_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $lineas = $em->getRepository('JHWEBVehiculoBundle:VhloCfgLinea')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($lineas) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($lineas)." registros encontrados", 
                'data'=> $lineas,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new vhloCfgLinea entity.
     *
     * @Route("/new", name="vhlocfglinea_new")
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
           
            $linea = new VhloCfgLinea();

            $linea->setNombre($params->nombre);
            $linea->setCodigo($params->codigo);
            $linea->setActivo(true);

            $em = $this->getDoctrine()->getManager();

            if ($params->idMarca) {
                $marca = $em->getRepository('JHWEBVehiculoBundle:VhloCfgMarca')->find(
                    $params->idMarca
                );
                $linea->setMarca($marca);
            }

            $em->persist($linea);
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
     * Finds and displays a vhloCfgLinea entity.
     *
     * @Route("/show", name="vhlocfglinea_show")
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
            $linea = $em->getRepository("JHWEBVehiculoBundle:VhloCfgLinea")->find($params->id);

            if ($linea) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado con exito", 
                    'data'=> $linea,
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
     * Displays a form to edit an existing vhloCfgLinea entity.
     *
     * @Route("/edit", name="vhlocfglinea_edit")
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
            $linea = $em->getRepository("JHWEBVehiculoBundle:VhloCfgLinea")->find($params->id);

            $marca = $em->getRepository("JHWEBVehiculoBundle:VhloCfgMarca")->find($params->idMarca);
            if ($linea) {
                $linea->setNombre($params->nombre);
                $linea->setCodigo($params->codigo);
                $linea->setMarca($marca);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $linea,
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
     * Deletes a vhloCfgLinea entity.
     *
     * @Route("/{id}/delete", name="vhlocfglinea_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);

            $em = $this->getDoctrine()->getManager();
            $linea = $em->getRepository("JHWEBVehiculoBundle:VhloCfgLinea")->find($id);

            if ($linea) {
                $linea->setActivo(false);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro eliminado con exito", 
                    'data'=> $linea,
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
     * Creates a form to delete a vhloCfgLinea entity.
     *
     * @param VhloCfgLinea $vhloCfgLinea The vhloCfgLinea entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloCfgLinea $vhloCfgLinea)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhlocfglinea_delete', array('id' => $vhloCfgLinea->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="vhlocfglinea_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $lineas = $em->getRepository('JHWEBVehiculoBundle:VhloCfgLinea')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($lineas as $key => $linea) {
            $response[$key] = array(
                'value' => $linea->getId(),
                'label' => $linea->getNombre()
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Busca lineas por Marca.
     *
     * @Route("/search/marca/select", name="vhlocfglinea_search_marca_select")
     * @Method({"GET", "POST"})
     */
    public function searchByMarcaSelectAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            // var_dump($params->idMarca);
            // die();

            if ($params->idMarca) {
                $lineas = $em->getRepository('JHWEBVehiculoBundle:VhloCfgLinea')->findBy(
                    array('marca' => $params->idMarca)
                );

                if ($lineas) {
                    $response = null;
                    foreach ($lineas as $key => $linea) {
                        $response[$key] = array(
                            'value' => $linea->getId(),
                            'label' => $linea->getNombre()
                        );
                    }
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
                    'message' => "Ninguna marca seleccionada", 
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
}
