<?php

namespace JHWEB\UsuarioBundle\Controller;

use JHWEB\UsuarioBundle\Entity\UserCfgRole;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Usercfgrole controller.
 *
 * @Route("usercfgrole")
 */
class UserCfgRoleController extends Controller
{
    /**
     * Lists all userCfgRole entities.
     *
     * @Route("/", name="usercfgrole_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $roles = $em->getRepository('JHWEBUsuarioBundle:UserCfgRole')->findBy(
            array(
                'activo'=>true
            )
        );

        $response['data'] = null;

        if ($roles) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($roles)." Registros encontrados", 
                'data'=> $roles,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new userCfgRole entity.
     *
     * @Route("/new", name="usercfgrole_new")
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
            
            $role = new UserCfgRole();

            $role->setNombre(mb_strtoupper($params->nombre, 'utf-8'));
            $role->setActivo(true);
            
            $em->persist($role);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro actualizado con exito", 
                'data'=> $role,
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
     * Finds and displays a userCfgRole entity.
     *
     * @Route("/show", name="usercfgrole_show")
     * @Method({"GET", "POST"})
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

            $role = $em->getRepository('JHWEBUsuarioBundle:UserCfgRole')->find(
                $params->id
            );

            if ($role) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado", 
                    'data'=> $role,
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
     * Displays a form to edit an existing userCfgRole entity.
     *
     * @Route("/edit", name="usercfgrole_edit")
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

            $role = $em->getRepository("JHWEBUsuarioBundle:UserCfgRole")->find(
                $params->id
            );

            if ($role) {
                $role->setNombre(mb_strtoupper($params->nombre, 'utf-8'));
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $role,
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
     * Deletes a userCfgRole entity.
     *
     * @Route("/delete", name="usercfgrole_delete")
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

            $role = $em->getRepository('JHWEBUsuarioBundle:UserCfgRole')->find(
                $params->id
            );
            $role->setActivo(false);

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
                'message' => "Autorización no valida", 
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a userCfgRole entity.
     *
     * @param UserCfgRole $userCfgRole The userCfgRole entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(UserCfgRole $userCfgRole)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('usercfgrole_delete', array('id' => $userCfgRole->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ======================================================== */

    /**
     * datos para select 2
     *
     * @Route("/select", name="usercfgrole_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $roles = $em->getRepository('JHWEBUsuarioBundle:UserCfgRole')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($roles as $key => $role) {
            $response[$key] = array(
                'value' => $role->getId(),
                'label' => $role->getNombre()
            );
        }
        
        return $helpers->json($response);
    }
}
