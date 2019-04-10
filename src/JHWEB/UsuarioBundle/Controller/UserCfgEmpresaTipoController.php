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

            $empresaTipo = $em->getRepository('JHWEBUsuarioBundle:UserCfgEmpresaTipo')->find($params->id);

            $em->persist($empresaTipo);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro encontrado con exito",
                'data' => $empresaTipo
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

    /* ======================================================= */

    /**
     * datos para select 2
     *
     * @Route("/select", name="usercfgempresaTipo_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();

    $empresaTipos = $em->getRepository('JHWEBUsuarioBundle:UserCfgEmpresaTipo')->findBy(
        array('activo' => true)
    );
      foreach ($empresaTipos as $key => $empresaTipo) {
        $response[$key] = array(
            'value' => $empresaTipo->getId(),
            'label' => $empresaTipo->getNombre(),
            );
      }
       return $helpers->json($response);
    }
}
