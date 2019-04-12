<?php

namespace JHWEB\UsuarioBundle\Controller;

use JHWEB\UsuarioBundle\Entity\UserCfgMenu;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Usercfgmenu controller.
 *
 * @Route("usercfgmenu")
 */
class UserCfgMenuController extends Controller
{
    /**
     * Lists all userCfgMenu entities.
     *
     * @Route("/", name="usercfgmenu_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $menus = $em->getRepository('JHWEBUsuarioBundle:UserCfgMenu')->findBy(
            array(
                'activo'=>true
            )
        );

        $response['data'] = null;

        if ($menus) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($menus)." Registros encontrados", 
                'data'=> $menus,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new userCfgMenu entity.
     *
     * @Route("/new", name="usercfgmenu_new")
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

            $menu = new UserCfgMenu();

            $menu->setTitulo($params->titulo);
            $menu->setAbreviatura($params->abreviatura);
            $menu->setActivo(true);

            if ($params->path) {
                $menu->setPath($params->path);
            }

            if (isset($params->idParent) && $params->idParent) {
                $parentMenu = $em->getRepository('JHWEBUsuarioBundle:UserCfgMenu')->find(
                    $params->idParent
                );
                $menu->setParent($parentMenu);

                if ($parentMenu->getTipo() == 'PRIMER_NIVEL') {
                    $menu->setTipo('SEGUNDO_NIVEL');
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => "Registro creado con éxito",
                    );

                    $em->persist($menu);
                    $em->flush();
                }elseif ($parentMenu->getTipo() == 'SEGUNDO_NIVEL') {
                    $menu->setTipo('TERCER_NIVEL');
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => "Registro creado con éxito",
                    );

                    $em->persist($menu);
                    $em->flush();
                }elseif ($parentMenu->getTipo() == 'TERCER_NIVEL') {
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "Debe seleccionar maximo un padre de segundo nivel",
                    );
                }
            }else{
                $menu->setTipo('PRIMER_NIVEL');
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro creado con éxito",
                );

                $em->persist($menu);
                $em->flush();
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
     * Finds and displays a userCfgMenu entity.
     *
     * @Route("/show", name="usercfgmenu_show")
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

            $menu = $em->getRepository('JHWEBUsuarioBundle:UserCfgMenu')->find(
                $params->id
            );

            if ($menu) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado", 
                    'data'=> $menu,
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
     * Displays a form to edit an existing userCfgMenu entity.
     *
     * @Route("/edit", name="usercfgmenu_edit")
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
            $menu = $em->getRepository("JHWEBUsuarioBundle:UserCfgMenu")->find($params->id);

            if ($menu) {
                $menu->setTitulo($params->titulo);
                $menu->setAbreviatura($params->abreviatura);
                $menu->setActivo(true);
                $menu->setPath($params->path);

                if (isset($params->idParent) && $params->idParent) {
                $parentMenu = $em->getRepository('JHWEBUsuarioBundle:UserCfgMenu')->find(
                    $params->idParent
                );
                $menu->setParent($parentMenu);

                if ($params->idRole) {
                    $role = $em->getRepository('JHWEBUsuarioBundle:UserCfgRole')->find(
                        $params->idRole
                    );
                    $menu->setRole($role);
                }

                if ($parentMenu->getTipo() == 'PRIMER_NIVEL') {
                    $menu->setTipo('SEGUNDO_NIVEL');
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => "Registro creado con éxito",
                    );

                    $em->persist($menu);
                    $em->flush();
                }elseif ($parentMenu->getTipo() == 'SEGUNDO_NIVEL') {
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "Debe seleccionar maximo un padre de primer nivel",
                    );
                }
            }else{
                $menu->setTipo('PRIMER_NIVEL');
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro creado con éxito",
                );

                $em->persist($menu);
                $em->flush();
            }
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
     * Deletes a userCfgMenu entity.
     *
     * @Route("/{id}/delete", name="usercfgmenu_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, UserCfgMenu $userCfgMenu)
    {
        $form = $this->createDeleteForm($userCfgMenu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($userCfgMenu);
            $em->flush();
        }

        return $this->redirectToRoute('usercfgmenu_index');
    }

    /**
     * Creates a form to delete a userCfgMenu entity.
     *
     * @param UserCfgMenu $userCfgMenu The userCfgMenu entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(UserCfgMenu $userCfgMenu)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('usercfgmenu_delete', array('id' => $userCfgMenu->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ================================================= */

    /**
     * Listado de menus para selección con búsqueda
     *
     * @Route("/select", name="usercfgmenu_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        
        $em = $this->getDoctrine()->getManager();
        
        $menus = $em->getRepository('JHWEBUsuarioBundle:UserCfgMenu')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($menus as $key => $menu) {
            if ($menu->getParent()) {
                $titulo = $menu->getParent()->getTitulo().' > '.$menu->getTitulo();
            }else{
                $titulo = $menu->getTitulo();
            }

            if ($menu->getTipo() == 'PRIMER_NIVEL' || $menu->getTipo() == 'SEGUNDO_NIVEL') {
                $response[] = array(
                    'value' => $menu->getId(),
                    'label' => $titulo
                );
            }

        }
        
        return $helpers->json($response);
    }

    /**
     * Lists all userCfgMenu entities.
     *
     * @Route("/select/availables", name="usercfgmenu_select_availables")
     * @Method({"GET", "POST"})
     */
    public function selectAvailablesAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $menus = $em->getRepository('JHWEBUsuarioBundle:UserCfgMenu')->getAvailablesByUsuario(
                $params->idUsuario
            );

            $response = null;

            foreach ($menus as $key => $menu) {
                if ($menu->getParent()->getParent()) {
                    $titulo = $menu->getParent()->getParent()->getTitulo().' > '.$menu->getParent()->getTitulo().' > '.$menu->getTitulo();
                }elseif($menu->getParent()){
                    $titulo = $menu->getParent()->getTitulo().' > '.$menu->getTitulo();
                }else{
                    $titulo = $menu->getTitulo();
                }
                
                $response[] = array(
                    'value' => $menu->getId(),
                    'label' => $titulo
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
     * Lists all userCfgMenu entities.
     *
     * @Route("/select/role", name="usercfgmenu_select_role")
     * @Method({"GET", "POST"})
     */
    public function selectByRoleAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $menus = $em->getRepository('JHWEBUsuarioBundle:UserCfgMenu')->findBy(
                array(
                    'role' => $params->idRole,
                    'activo' => true
                )
            );

            $response = null;

            foreach ($menus as $key => $menu){
                if (!$menu->getParent()) {
                    $response[] = array(
                        'value' => $menu->getId(),
                        'label' => $menu->getTitulo()
                    );
                }
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
     * Lists all userCfgMenu entities by usuario.
     *
     * @Route("/generate/usuario", name="usercfgmenu_generate_usuario")
     * @Method({"GET", "POST"})
     */
    public function generateByUsuarioAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $menus = $this->multilevelMenuByUsuarioAction($params->idUsuario);

            $response = null;

            if ($menus) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($menus)." Registros encontrados", 
                    'data'=> $menus,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No existen registros para mostrar", 
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

    public function multilevelMenuByUsuarioAction($idUsuario, $idParent = NULL){
        $em = $this->getDoctrine()->getManager();

        $menus = $em->getRepository('JHWEBUsuarioBundle:UserCfgMenu')->findBy(
            array(
                'parent' => $idParent,
                'activo' => true
            )
        );

        $usuario = $em->getRepository('UsuarioBundle:Usuario')->find(
            $idUsuario
        );

        $tree = null;

        foreach ($menus as $key => $menu) {
            $roleMenu = $em->getRepository('JHWEBUsuarioBundle:UserUsuarioMenu')->findBy(
                array(
                    'menu' => $menu->getId(),
                    'usuario' => $usuario->getId()
                )
            );

            if ($roleMenu) {
                $tree[] = array(
                    'id' => $menu->getId(),
                    'title' => $menu->getTitulo(),
                    'tipo' => $menu->getTipo(),
                    'path' => $menu->getPath(),
                    'abbreviation' => $menu->getAbreviatura(),
                    'childrens' => $this->multilevelMenuByUsuarioAction(
                        $usuario->getId(), $menu->getId()
                    )
                );            
            }

        }

        return $tree;
    }
}
