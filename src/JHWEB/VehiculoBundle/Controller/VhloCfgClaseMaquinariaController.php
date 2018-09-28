<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloCfgClaseMaquinaria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlocfgclasemaquinarium controller.
 *
 * @Route("vhlocfgclasemaquinaria")
 */
class VhloCfgClaseMaquinariaController extends Controller
{
    /**
     * Lists all vhloCfgClaseMaquinarium entities.
     *
     * @Route("/", name="vhlocfgclasemaquinaria_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $clasesMaquinaria = $em->getRepository('JHWEBVehiculoBundle:VhloCfgClaseMaquinaria')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($clasesMaquinaria) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($clasesMaquinaria)." registros encontrados", 
                'data'=> $clasesMaquinaria,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new vhloCfgClaseMaquinarium entity.
     *
     * @Route("/new", name="vhlocfgclasemaquinaria_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("json",null);
            $params = json_decode($json);
           
            $claseMaquinaria = new VhloCfgClaseMaquinaria();

            $claseMaquinaria->setNombre($params->nombre);
            $claseMaquinaria->setCodigo($params->codigo);
            $claseMaquinaria->setActivo(true);

            if ($params->idTipoMaquinaria) {
                $tipoMaquinaria = $em->getRepository('JHWEBVehiculoBundle:VhloCfgTipoMaquinaria')->find(
                    $params->idTipoMaquinaria
                );
                $claseMaquinaria->setTipoMaquinaria($tipoMaquinaria);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($claseMaquinaria);
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
     * Finds and displays a vhloCfgClaseMaquinarium entity.
     *
     * @Route("/{id}/show", name="vhlocfgclasemaquinaria_show")
     * @Method("GET")
     */
    public function showAction(VhloCfgClaseMaquinaria $vhloCfgClaseMaquinarium)
    {
        $deleteForm = $this->createDeleteForm($vhloCfgClaseMaquinarium);

        return $this->render('vhlocfgclasemaquinaria/show.html.twig', array(
            'vhloCfgClaseMaquinarium' => $vhloCfgClaseMaquinarium,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vhloCfgClaseMaquinarium entity.
     *
     * @Route("/edit", name="vhlocfgclasemaquinaria_edit")
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
            $claseMaquinaria = $em->getRepository("JHWEBVehiculoBundle:VhloCfgClaseMaquinaria")->find($params->id);

            if ($claseMaquinaria) {
                $claseMaquinaria->setNombre($params->nombre);
                $claseMaquinaria->setCodigo($params->codigo);

                if ($params->idTipoMaquinaria) {
                    $tipoMaquinaria = $em->getRepository('JHWEBVehiculoBundle:VhloCfgTipoMaquinaria')->find(
                        $params->idTipoMaquinaria
                    );
                    $claseMaquinaria->setTipoMaquinaria($tipoMaquinaria);
                }
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $claseMaquinaria,
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
     * Deletes a vhloCfgClaseMaquinarium entity.
     *
     * @Route("/delete", name="vhlocfgclasemaquinaria_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            $claseMaquinaria = $em->getRepository("JHWEBVehiculoBundle:VhloCfgClaseMaquinaria")->find($params->id);

            if ($claseMaquinaria) {
                $claseMaquinaria->setActivo(false);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro eliminado con exito", 
                    'data'=> $claseMaquinaria,
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
     * Creates a form to delete a vhloCfgClaseMaquinarium entity.
     *
     * @param VhloCfgClaseMaquinaria $vhloCfgClaseMaquinarium The vhloCfgClaseMaquinarium entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloCfgClaseMaquinaria $vhloCfgClaseMaquinarium)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhlocfgclasemaquinaria_delete', array('id' => $vhloCfgClaseMaquinarium->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="vhlocfgclasemaquinaria_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $clasesMaquinaria = $em->getRepository('JHWEBVehiculoBundle:VhloCfgClaseMaquinaria')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($clasesMaquinaria as $key => $claseMaquinaria) {
            $response[$key] = array(
                'value' => $claseMaquinaria->getId(),
                'label' => $claseMaquinaria->getNombre()
            );
        }
        
        return $helpers->json($response);
    }
}
