<?php

namespace JHWEB\UsuarioBundle\Controller;

use JHWEB\UsuarioBundle\Entity\UserCfgTipoIdentificacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Usercfgtipoidentificacion controller.
 *
 * @Route("usercfgtipoidentificacion")
 */
class UserCfgTipoIdentificacionController extends Controller
{
    /**
     * Lists all userCfgTipoIdentificacion entities.
     *
     * @Route("/", name="usercfgtipoidentificacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $tiposIdentificacion = $em->getRepository('JHWEBUsuarioBundle:UserCfgTipoIdentificacion')->findBy(
            array(
                'activo' => true
            )
        );

        $response['data'] = array();

        if ($tiposIdentificacion) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($tiposIdentificacion)." registros encontrados", 
                'data'=> $tiposIdentificacion,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new userCfgTipoIdentificacion entity.
     *
     * @Route("/new", name="usercfgtipoidentificacion_new")
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

            $tipoIdentificacion = new UserCfgTipoIdentificacion();

            $tipoIdentificacion->setNombre(
                mb_strtoupper($params->nombre,'utf-8')
            );
            $tipoIdentificacion->setSigla(
                mb_strtoupper($params->sigla,'utf-8')
            );
            $tipoIdentificacion->setActivo(true);

            $em->persist($tipoIdentificacion);
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
     * Finds and displays a userCfgTipoIdentificacion entity.
     *
     * @Route("/show", name="usercfgtipoidentificacion_show")
     * @Method({"GET", "POST"})
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

            $tipoIdentificacion = $em->getRepository('JHWEBUsuarioBundle:UserCfgTipoIdentificacion')->find(
                $params->id
            );

            $em->persist($tipoIdentificacion);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro encontrado con exito",
                'data' => $tipoIdentificacion
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
     * Displays a form to edit an existing userCfgTipoIdentificacion entity.
     *
     * @Route("/edit", name="usercfgtipoidentificacion_edit")
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

            $tipoIdentificacion = $em->getRepository("JHWEBUsuarioBundle:UserCfgTipoIdentificacion")->find(
                $params->id
            );

            if ($tipoIdentificacion) {
                $tipoIdentificacion->setNombre(
                    mb_strtoupper($params->nombre,'utf-8')
                );
                $tipoIdentificacion->setSigla(
                    mb_strtoupper($params->sigla,'utf-8')
                );
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $tipoIdentificacion,
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
     * Deletes a userCfgTipoIdentificacion entity.
     *
     * @Route("/delete", name="usercfgtipoidentificacion_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $tipoIdentificacion = $em->getRepository('JHWEBUsuarioBundle:UserCfgTipoIdentificacion')->find(
                $params->id
            );

            $tipoIdentificacion->setActivo(false);

            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro eliminado con exito"
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
     * Creates a form to delete a userCfgTipoIdentificacion entity.
     *
     * @param UserCfgTipoIdentificacion $userCfgTipoIdentificacion The userCfgTipoIdentificacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(UserCfgTipoIdentificacion $userCfgTipoIdentificacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('usercfgtipoidentificacion_delete', array('id' => $userCfgTipoIdentificacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* =================================================== */

    /**
     * Listado de tipos de identificacion para seleccion con busqueda
     *
     * @Route("/select", name="usercfgtipoidentificacion_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $tiposIdentificacion = $em->getRepository('JHWEBUsuarioBundle:UserCfgTipoIdentificacion')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($tiposIdentificacion as $key => $tipoIdentificacion) {
            $response[$key] = array(
                'value' => $tipoIdentificacion->getId(),
                'label' => $tipoIdentificacion->getNombre(),
            );
        }

        return $helpers->json($response);
    }
}
