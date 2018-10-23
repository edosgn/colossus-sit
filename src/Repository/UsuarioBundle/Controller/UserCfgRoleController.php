<?php

namespace Repository\UsuarioBundle\Controller;

use Repository\UsuarioBundle\Entity\UserCfgRole;
use Repository\UsuarioBundle\Entity\UserCfgRoleMenu;
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

        $roles = $em->getRepository('UsuarioBundle:UserCfgRole')->findBy(
            array(
                'activo'=>true
            )
        );

        $response['data'] = null;

        if (count($roles) > 0) {
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

            $role->setNombre(strtoupper($params->nombre));
            $role->setActivo(true);
            
            $em->persist($role);
            $em->flush();


            foreach ($params->menus as $key => $idMenu) {
                $menu = $em->getRepository('UsuarioBundle:UserCfgMenu')->find(
                    $idMenu
                );

                $this->createMenuAction($role, $menu);
            }

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
     * Finds and displays a userCfgRole entity.
     *
     * @Route("/show", name="usercfgrole_show")
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

            $role = $em->getRepository('UsuarioBundle:UserCfgRole')->find($params->id);

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
            $role = $em->getRepository("UsuarioBundle:UserCfgRole")->find($params->id);

            if ($role) {
                $role->setNombre(strtoupper($params->nombre));

                foreach ($params->menus as $key => $idMenu) {
                    $roleMenu = $em->getRepository('UsuarioBundle:UserCfgRoleMenu')->findBy(
                        array(
                            'menu' => $idMenu,
                            'role' => $role->getId()
                        )
                    );

                    if (!$roleMenu) {
                        $roleMenu = new UserCfgRoleMenu();

                        $menu = $em->getRepository('UsuarioBundle:UserCfgMenu')->find(
                            $idMenu
                        );
                        
                        $this->createMenuAction($role, $menu);
                    }
                }
                
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
            $role = $em->getRepository('UsuarioBundle:UserCfgRole')->find($params->id);
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
        
        $roles = $em->getRepository('UsuarioBundle:UserCfgRole')->findBy(
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

    /* ======================================================== */

    /**
     * datos para select 2
     *
     * @Route("/create/menu", name="usercfgrole_create_menu")
     * @Method({"GET", "POST"})
     */
    public function createMenuAction($role, $menu)
    {
        $em = $this->getDoctrine()->getManager();

        $roleMenu = new UserCfgRoleMenu();

        $roleMenu->setMenu($menu);
        $roleMenu->setRole($role);
        $roleMenu->setActivo(true);

        $em->persist($roleMenu);
        $em->flush();

        if ($menu->getParent()) {
            $this->createMenuAction($role, $menu->getParent());
        }
    }
}
