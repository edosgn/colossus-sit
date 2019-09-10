<?php

namespace JHWEB\UsuarioBundle\Controller;

use JHWEB\UsuarioBundle\Entity\UserUsuarioMenu;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Userusuariomenu controller.
 *
 * @Route("userusuariomenu")
 */
class UserUsuarioMenuController extends Controller
{
    /**
     * Lists all userUsuarioMenu entities.
     *
     * @Route("/", name="userusuariomenu_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $userUsuarioMenus = $em->getRepository('JHWEBUsuarioBundle:UserUsuarioMenu')->findAll();

        return $this->render('userusuariomenu/index.html.twig', array(
            'userUsuarioMenus' => $userUsuarioMenus,
        ));
    }

    /**
     * Creates a new userUsuarioMenu entity.
     *
     * @Route("/new", name="userusuariomenu_new")
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

            $usuario = $em->getRepository('UsuarioBundle:Usuario')->find(
                $params->idUsuario
            );

            foreach ($params->menus as $key => $idMenu) {
                $menu = $em->getRepository('JHWEBUsuarioBundle:UserCfgMenu')->find(
                    $idMenu
                );
                
                $this->createMenuAction($usuario, $menu);
            }

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con exito."
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
     * Finds and displays a userUsuarioMenu entity.
     *
     * @Route("/{id}/show", name="userusuariomenu_show")
     * @Method("GET")
     */
    public function showAction(UserUsuarioMenu $userUsuarioMenu)
    {
        $deleteForm = $this->createDeleteForm($userUsuarioMenu);

        return $this->render('userusuariomenu/show.html.twig', array(
            'userUsuarioMenu' => $userUsuarioMenu,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing userUsuarioMenu entity.
     *
     * @Route("/{id}/edit", name="userusuariomenu_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, UserUsuarioMenu $userUsuarioMenu)
    {
        $deleteForm = $this->createDeleteForm($userUsuarioMenu);
        $editForm = $this->createForm('JHWEB\UsuarioBundle\Form\UserUsuarioMenuType', $userUsuarioMenu);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('userusuariomenu_edit', array('id' => $userUsuarioMenu->getId()));
        }

        return $this->render('userusuariomenu/edit.html.twig', array(
            'userUsuarioMenu' => $userUsuarioMenu,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a userUsuarioMenu entity.
     *
     * @Route("/delete", name="userusuariomenu_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization",null);
        $authCheck = $helpers->authCheck($hash);

        if($authCheck == true){
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $usuario = $em->getRepository('UsuarioBundle:Usuario')->find(
                $params->idUsuario
            );

            foreach ($params->menus as $key => $idMenu) {
                $usuarioMenu = $em->getRepository('JHWEBUsuarioBundle:UserUsuarioMenu')->findOneBy(
                    array(
                        'usuario' => $usuario->getId(),
                        'menu' => $idMenu,
                        'activo' => $idMenu,
                    )
                );
                
                $usuarioMenu->setActivo(false);

                $em->flush();
            }

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registros eliminados con exito."
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
     * Deletes a userUsuarioMenu entity.
     *
     * @Route("/delete/all", name="userusuariomenu_delete_all")
     * @Method("POST")
     */
    public function deleteAllAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization",null);
        $authCheck = $helpers->authCheck($hash);

        

        if($authCheck == true){
            $json = $request->get("data",null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            
            $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findOneBy(
                array(
                    'identificacion' => $params->identificacion
                )
            );

            if ($ciudadano) {
                $usuario = $ciudadano->getUsuario();

                if ($usuario) {
                    $menus = $em->getRepository('JHWEBUsuarioBundle:UserUsuarioMenu')->getAssignedByUsuario($usuario->getId());
                }
            }

            if($menus){
                foreach ($menus as $key => $usuarioMenu) {
                    
                    $usuarioMenu->setActivo(false);
    
                    $em->flush();
                }
            }

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registros eliminados con exito."
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
     * Deletes a userUsuarioMenu entity.
     *
     * @Route("/delete/usuario/inhabilitar", name="userusuariomenu_delete_all_usuario_inhabilitar")
     * @Method("POST")
     */
    public function deleteUsuarioInhabilitarAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization",null);
        $authCheck = $helpers->authCheck($hash);

        if($authCheck == true)
        {
            $json = $request->get("data",null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findOneBy(
                array(
                    'identificacion' => $params->identificacion
                )
            );
            if ($ciudadano) {
                $funcionario = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->findOneByCiudadano($ciudadano->getId());
                if($funcionario){
                    if($funcionario->getActivo()){
                        $funcionario->setActivo(0);
                        $response = array(
                            'status' => 'success',
                            'code' => 200,
                            'message' => "Registro Inhabilitado con exito."
                        );
                    }else{
                        $funcionario->setActivo(1);
                        $response = array(
                            'status' => 'success',
                            'code' => 200,
                            'message' => "Registro Habilitado con exito."
                        );
                    }
                    $em->flush();
                }else{
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "No se encontró funcionario."
                    );
                }
            }

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
     * Creates a form to delete a userUsuarioMenu entity.
     *
     * @param UserUsuarioMenu $userUsuarioMenu The userUsuarioMenu entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(UserUsuarioMenu $userUsuarioMenu)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('userusuariomenu_delete', array('id' => $userUsuarioMenu->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ===================================================== */

    /**
     * Lists all menus by usuarios.
     *
     * @Route("/search/menus", name="userusuariomenu_search_menus")
     * @Method({"GET", "POST"})
     */
    public function searchMenusAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization",null);
        $authCheck = $helpers->authCheck($hash);

        if($authCheck == true){
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findOneBy(
                array(
                    'identificacion' => $params->identificacion
                )
            );

            if ($ciudadano) {
                $usuario = $ciudadano->getUsuario();
                $funcionario = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->findOneByCiudadano($ciudadano->getId());
                if ($usuario) {
                    $menus = $em->getRepository('JHWEBUsuarioBundle:UserUsuarioMenu')->getAssignedByUsuario($usuario->getId());
                    // var_dump($funcionario->getId());
                    // die(); 
                    if ($menus) {
                        $response = array(
                            'status' => 'success',
                            'code' => 200,
                            'message' => count($menus)." Registros encontrados", 
                            'data'=> array(
                                'usuarioMenus' => $menus,
                                'usuario' => $usuario,
                                'activo' => $funcionario->getActivo(),
                            )
                        );
                    }else{
                        $response = array(
                            'status' => 'error',
                            'code' => 400,
                            'message' => "No existen menus registrados para este usuario.",
                            'data'=> array(
                                'usuario' => $usuario,
                                'activo' => $funcionario->getActivo(),
                            )
                        );
                    }
                }else{
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "El usuario vinculado a un ciudadano no existe.",
                    );
                }
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Los datos de ciudadano no existen con el número de indentificación digitada.",
                );
            }
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
     * Crear menus
     *
     * @Route("/create/menu", name="usercfgmenu_create_menu")
     * @Method({"GET", "POST"})
     */
    public function createMenuAction($usuario, $menu)
    {
        $em = $this->getDoctrine()->getManager();

        $usuarioMenu = $em->getRepository('JHWEBUsuarioBundle:UserUsuarioMenu')->findOneBy(
            array(
                'menu' => $menu->getId(),
                'usuario' => $usuario->getId()
            )
        );

        if (!$usuarioMenu) {
            $usuarioMenu = new UserUsuarioMenu();

            $usuarioMenu->setMenu($menu);
            $usuarioMenu->setUsuario($usuario);
            $usuarioMenu->setActivo(true);

            $em->persist($usuarioMenu);
            $em->flush();
        }else{
            $usuarioMenu->setActivo(true);

            $em->flush();
        }

        if ($menu->getParent()) {
            $this->createMenuAction($usuario, $menu->getParent());
        }
    }
}
