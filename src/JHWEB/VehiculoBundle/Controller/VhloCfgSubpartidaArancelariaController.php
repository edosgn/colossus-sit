<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloCfgSubpartidaArancelaria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlocfgsubpartidaarancelarium controller.
 *
 * @Route("vhlocfgsubpartidaarancelaria")
 */
class VhloCfgSubpartidaArancelariaController extends Controller
{
    /**
     * Lists all vhloCfgSubpartidaArancelarium entities.
     *
     * @Route("/", name="vhlocfgsubpartidaarancelaria_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $subpartidas = $em->getRepository('JHWEBVehiculoBundle:VhloCfgSubpartidaArancelaria')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($subpartidas) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($subpartidas)." registros encontrados", 
                'data'=> $subpartidas,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new vhloCfgSubpartidaArancelarium entity.
     *
     * @Route("/new", name="vhlocfgsubpartidaarancelaria_new")
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
           
            $subpartida = new VhloCfgSubpartidaArancelaria();

            $subpartida->setCodigo($params->codigo);
            $subpartida->setActivo(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($subpartida);
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
     * Finds and displays a vhloCfgSubpartidaArancelarium entity.
     *
     * @Route("/{id}/show", name="vhlocfgsubpartidaarancelaria_show")
     * @Method("GET")
     */
    public function showAction(VhloCfgSubpartidaArancelaria $vhloCfgSubpartidaArancelarium)
    {
        $deleteForm = $this->createDeleteForm($vhloCfgSubpartidaArancelarium);

        return $this->render('vhlocfgsubpartidaarancelaria/show.html.twig', array(
            'vhloCfgSubpartidaArancelarium' => $vhloCfgSubpartidaArancelarium,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vhloCfgSubpartidaArancelarium entity.
     *
     * @Route("/edit", name="vhlocfgsubpartidaarancelaria_edit")
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
            $subpartida = $em->getRepository("JHWEBVehiculoBundle:VhloCfgSubpartidaArancelaria")->find($params->id);

            if ($subpartida) {
                $subpartida->setCodigo($params->codigo);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $subpartida,
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
     * Deletes a vhloCfgSubpartidaArancelarium entity.
     *
     * @Route("/delete", name="vhlocfgsubpartidaarancelaria_delete")
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
            $subpartida = $em->getRepository("JHWEBVehiculoBundle:VhloCfgSubpartidaArancelaria")->find($params->id);

            if ($subpartida) {
                $subpartida->setActivo(false);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro eliminado con exito", 
                    'data'=> $subpartida,
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
     * Creates a form to delete a vhloCfgSubpartidaArancelarium entity.
     *
     * @param VhloCfgSubpartidaArancelaria $vhloCfgSubpartidaArancelarium The vhloCfgSubpartidaArancelarium entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloCfgSubpartidaArancelaria $vhloCfgSubpartidaArancelarium)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhlocfgsubpartidaarancelaria_delete', array('id' => $vhloCfgSubpartidaArancelarium->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* =================================================== */

    /**
     * datos para select 2
     *
     * @Route("/select", name="vhlocfgsubpartidaarancelaria_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $subpartidas = $em->getRepository('JHWEBVehiculoBundle:VhloCfgSubpartidaArancelaria')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($subpartidas as $key => $subpartida) {
            $response[$key] = array(
                'value' => $subpartida->getId(),
                'label' => $subpartida->getCodigo()
            );
        }
        
        return $helpers->json($response);
    }
}
