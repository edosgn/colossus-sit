<?php

namespace JHWEB\UsuarioBundle\Controller;

use JHWEB\UsuarioBundle\Entity\UserCfgEmpresaTipo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Usercfgempresatipo controller.
 *
 * @Route("usercfgempresatipo")
 */
class UserCfgEmpresaTipoController extends Controller
{
    /**
     * Lists all userCfgEmpresaTipo entities.
     *
     * @Route("/", name="usercfgempresatipo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $tipos = $em->getRepository('JHWBUsuarioBundle:UserCfgEmpresaTipo')->findBy(
            array('activo' => true)
        );

        $response = 
            array(
                'status' => 'success',
                'code' => 200,
                'message' => count($tipos)." registros encontrados.", 
                'data'=> $tipos,
            );  
        return $helpers->json($response);
    }

    /**
     * Creates a new userCfgMenu entity.
     *
     * @Route("/new", name="usercfgempresatipo_new")
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

            $tipo = new UserCfgEmpresaTipo();

            $tipo->setNombre(mb_strtoupper($params->nombre, 'utf-8'));
            $tipo->setActivo(true);

            $em->persist($tipo);
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
     * Finds and displays a userCfgEmpresaTipo entity.
     *
     * @Route("/show", name="usercfgempresatipo_show")
     * @Method("POST")
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();

            $tipo = $em->getRepository('JHWEBUsuarioBundle:UserCfgEmpresaTipo')->find($params->id);

            $em->persist($tipo);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro encontrado con exito",
                'data' => $tipo
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
     * Displays a form to edit an existing userCfgEmpresaTipo entity.
     *
     * @Route("/edit", name="cfgempresatipo_edit")
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

            $tipo = $em->getRepository("JHWEBUsuarioBundle:UserCfgEmpresaTipo")->find($params->id);

            if ($tipo) {
                $tipo->setNombre(mb_strtoupper($params->nombre, 'utf-8'));

                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $tipo,
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

    /* ======================================================= */

    /**
     * Listado con los tipos de empresa para selección con búsqueda
     *
     * @Route("/select", name="usercfgempresaTipo_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $tipos = $em->getRepository('JHWEBUsuarioBundle:UserCfgEmpresaTipo')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($tipos as $key => $tipo) {
            $response[$key] = array(
                'value' => $tipo->getId(),
                'label' => $tipo->getNombre(),
            );
        }
       return $helpers->json($response);
    }
}
