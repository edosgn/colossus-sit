<?php

namespace JHWEB\UsuarioBundle\Controller;

use JHWEB\UsuarioBundle\Entity\UserCfgTipoMedidaCautelar;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Usercfgtipomedidacautelar controller.
 *
 * @Route("usercfgtipomedidacautelar")
 */
class UserCfgTipoMedidaCautelarController extends Controller
{
    /**
     * Lists all userCfgTipoMedidaCautelar entities.
     *
     * @Route("/", name="usercfgtipomedidacautelar_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $tiposMedidaCautelar = $em->getRepository('JHWEBUsuarioBundle:UserCfgTipoMedidaCautelar')->findBy(
            array('activo'=>true)
        );

        $response['data'] = array();

        if ($tiposMedidaCautelar) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($tiposMedidaCautelar)." registros encontrados", 
                'data'=> $tiposMedidaCautelar,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new usercfgtipomedidacautelar_index entity.
     *
     * @Route("/new", name="usercfgtipomedidacautelar_new")
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

            $tipoMedidaCautelar = new UserCfgTipoMedidaCautelar();
           
            $tipoMedidaCautelar->setNombre($params->nombre);
            $tipoMedidaCautelar->setCodigo($params->codigo);
            $tipoMedidaCautelar->setActivo(true);
            
            $em->persist($tipoMedidaCautelar);
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
     * Finds and displays a usercfgtipomedidacautelar_index entity.
     *
     * @Route("/show", name="usercfgtipomedidacautelar_show")
     * @Method("GET")
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $tipoMedidaCautelar = $em->getRepository('JHWEBUsuarioBundle:UserCfgTipoMedidaCautelar')->find($params->idTipoMedidaCautelar);

            if ($tipoMedidaCautelar) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado", 
                    'data'=> $tipoMedidaCautelar,
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
                'message' => "Autorizacion no valida", 
            );
        }

        return $helpers->json($response);
    }

   /**
     * Displays a form to edit an existing usercfgtipomedidacautelar entity.
     *
     * @Route("/edit", name="usercfgtipomedidacautelar_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request){
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $tipoMedidaCautelar = $em->getRepository("JHWEBUsuarioBundle:UserCfgTipoMedidaCautelar")->find($params->id);

            if ($tipoMedidaCautelar) {
                $tipoMedidaCautelar->setNombre($params->nombre);
                $tipoMedidaCautelar->setCodigo($params->codigo);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $tipoMedidaCautelar,
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
                    'message' => "Autorización no válida.", 
                );
        }

        return $helpers->json($response);
    }


    /**
     * Deletes a cvcfgtipomedidacautelar_index entity.
     *
     * @Route("/delete", name="usercfgtipomedidacautelar_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if($authCheck == true){
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $tipoMedidaCautelar = $em->getRepository('JJHWEBUsuarioBundle:UserCfgTipoMedidaCautelar')->find($params->id);
            $tipoMedidaCautelar->setActivo(false);

            $em->flush();

            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro eliminado con éxito", 
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida", 
            );
        }
        return $helpers->json($response);
    }

    /* =================================================== */

    /**
     * Listado de tipos de medida cautelar para seleccion con busqueda
     *
     * @Route("/select", name="usercfgtipomedidacautelar_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $tiposMedidaCautelar = $em->getRepository('JHWEBUsuarioBundle:UserCfgTipoMedidaCautelar')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($tiposMedidaCautelar as $key => $tipoMedidaCautelar) {
            $response[$key] = array(
                'value' => $tipoMedidaCautelar->getId(),
                'label' => $tipoMedidaCautelar->getSigla(),
            );
        }

        return $helpers->json($response);
    }

}
