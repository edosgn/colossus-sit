<?php

namespace JHWEB\UsuarioBundle\Controller;

use JHWEB\UsuarioBundle\Entity\UserCfgEmpresaServicio;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * Usercfgempresaservicio controller.
 *
 * @Route("usercfgempresaservicio")
 */
class UserCfgEmpresaServicioController extends Controller
{
    /**
     * Lists all userCfgEmpresaServicio entities.
     *
     * @Route("/", name="usercfgempresaservicio_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $empresaServicio = $em->getRepository('JHWEBUsuarioBundle:UserCfgEmpresaServicio')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($empresaServicio) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($empresaServicio)." registros encontrados", 
                'data'=> $empresaServicio,
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a new userCfgEmpresaServicio entity.
     *
     * @Route("/new", name="usercfgempresaservicio_new")
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
           
            $empresaServicio = new UserCfgEmpresaServicio();

            $empresaServicio->setNombre($params->nombre);
            $empresaServicio->setActivo(true);
            $empresaServicio->setGestionable($params->gestionable);

            $em = $this->getDoctrine()->getManager();
            $em->persist($empresaServicio);
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
     * Finds and displays a userCfgEmpresaServicio entity.
     *
     * @Route("/show", name="usercfgempresaservicio_show")
     * @Method("GET")
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $json = $request->get("data", null);
        $params = json_decode($json);

        $empresaServicio = $em->getRepository('JHWEBUsuarioBundle:UserCfgEmpresaServicio')->find($params->id);

        if ($empresaServicio) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro encontrado",
                'data' => $empresaServicio,
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Registro no encontrado",
            );
        }

        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing userCfgEmpresaServicio entity.
     *
     * @Route("/edit", name="usercfgempresaservicio_edit")
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
            $empresaServicio = $em->getRepository("JHWEBUsuarioBundle:UserCfgEmpresaServicio")->find($params->id);

            if ($empresaServicio!=null) {
                $empresaServicio->setNombre($params->nombre);
                $empresaServicio->setGestionable($params->gestionable);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $empresaServicio,
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
     * Deletes a svCfgArea entity.
     *
     * @Route("/delete", name="usercfgempresaservicio_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", true);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $json = $request->get("json", null);
            $params = json_decode($json);

            $empresaServicio = $em->getRepository('JHWEBUsuarioBundle:UserCfgEmpresaServicio')->find($params->id);

            $empresaServicio->setActivo(false);

            $em->persist($empresaServicio);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro eliminado con éxito.",
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no válida",
            );
        }
        return $helpers->json($response);

    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="usercfgempresaservicio_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $empresaServicios = $em->getRepository('JHWEBUsuarioBundle:UserCfgEmpresaServicio')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($empresaServicios as $key => $empresaServicio) {
            $response[$key] = array( 
                'value' => $empresaServicio->getId(),
                'label' => $empresaServicio->getNombre(),
                );
        }
        return $helpers->json($response);
    }
}
