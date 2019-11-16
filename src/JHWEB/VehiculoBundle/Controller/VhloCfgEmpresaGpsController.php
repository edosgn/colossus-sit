<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloCfgEmpresaGps;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlocfgempresagp controller.
 *
 * @Route("vhlocfgempresagps")
 */
class VhloCfgEmpresaGpsController extends Controller
{
    /**
     * Lists all vhloCfgEmpresaGp entities.
     *
     * @Route("/", name="vhlocfgempresagps_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $empresas = $em->getRepository('JHWEBVehiculoBundle:VhloCfgEmpresaGps')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($empresas) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($empresas)." registros encontrados", 
                'data'=> $empresas,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new vhloCfgEmpresaGp entity.
     *
     * @Route("/new", name="vhlocfgempresagps_new")
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

            $em = $this->getDoctrine()->getManager();
           
            $empresaExistente = $em->getRepository('JHWEBVehiculoBundle:VhloCfgEmpresaGps')->findOneBy(
                array(
                    'nit' => $params->nit,
                    'activo' => true
                )
            );

            if(!$empresaExistente) {
                $empresaGps = new VhloCfgEmpresaGps();
    
                $empresaGps->setNit($params->nombre);
                $empresaGps->setCodigo($params->codigo);
                $empresaGps->setNombre($params->nombre);
                $empresaGps->setActivo(true);
    
                $em->persist($empresaGps);
                $em->flush();
    
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro creado con exito",
                );
            } else {
                $response = array(
                    'title' => 'Error!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => "El nit que intenta registra ya esta asignado una empresa", 
                );
            }
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Finds and displays a vhloCfgEmpresaGp entity.
     *
     * @Route("/{id}/show", name="vhlocfgempresagps_show")
     * @Method("GET")
     */
    public function showAction(VhloCfgEmpresaGps $vhloCfgEmpresaGp)
    {
        $deleteForm = $this->createDeleteForm($vhloCfgEmpresaGp);

        return $this->render('vhlocfgempresagps/show.html.twig', array(
            'vhloCfgEmpresaGp' => $vhloCfgEmpresaGp,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vhloCfgEmpresaGp entity.
     *
     * @Route("/edit", name="vhlocfgempresagps_edit")
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
            $empresa = $em->getRepository("JHWEBVehiculoBundle:VhloCfgEmpresaGps")->find($params->id);

            if ($empresa) {
                $empresa->setNombre($params->nit);
                $empresa->setNombre($params->codigo);
                $empresa->setNombre($params->nombre);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $empresa,
                );
            }else{
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida para editar", 
            );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a vhloCfgEmpresaGp entity.
     *
     * @Route("/delete", name="vhlocfgempresagps_delete")
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
            $empresa = $em->getRepository("JHWEBVehiculoBundle:VhloCfgEmpresaGps")->find($params->id);

            if ($empresa) {
                $empresa->setActivo(false);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro eliminado con exito", 
                    'data'=> $empresa,
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
     * Creates a form to delete a vhloCfgEmpresaGp entity.
     *
     * @param VhloCfgEmpresaGps $vhloCfgEmpresaGp The vhloCfgEmpresaGp entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloCfgEmpresaGps $vhloCfgEmpresaGp)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhlocfgempresagps_delete', array('id' => $vhloCfgEmpresaGp->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="vhlocfgempresagps_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $empresas = $em->getRepository('JHWEBVehiculoBundle:VhloCfgEmpresaGps')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($empresas as $key => $empresa) {
            $response[$key] = array(
                'value' => $empresa->getId(),
                'label' => $empresa->getNombre()
            );
        }
        
        return $helpers->json($response);
    }
}
