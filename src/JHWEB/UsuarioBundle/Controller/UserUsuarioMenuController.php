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
     * @Route("/{id}/delete", name="userusuariomenu_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, UserUsuarioMenu $userUsuarioMenu)
    {
        $form = $this->createDeleteForm($userUsuarioMenu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($userUsuarioMenu);
            $em->flush();
        }

        return $this->redirectToRoute('userusuariomenu_index');
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
     * @Route("/search/menus/usuario", name="userusuariomenu_search_menus_usuario")
     * @Method({"GET", "POST"})
     */
    public function searchMenusByUsuarioAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization",null);
        $authCheck = $helpers->authCheck($hash);

        if($authCheck == true){
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $usuario = $em->getRepository('UsuarioBundle:Usuario')->findOneBy(
                array(
                    'identificacion' => $params->numeroIdentificacion
                )
            );

            if ($usuario) {
                $menus = $em->getRepository('JHWEBUsuarioBundle:UserUsuarioMenu')->findByUsuario(
                    array(
                        'usuario' => $usuario->getId()
                    )
                );

                if ($menus) {
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => count($menus)." Registros encontrados", 
                        'data'=> array(
                            'usuarioMenus' => $menus,
                            'usuario' => $usuario,
                        )
                    );
                }else{
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "No existen menus registrados para este usuario.",
                        'data'=> array(
                            'usuario' => $usuario,
                        )
                    );
                }
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El usuario con el número de indentificación digitada no existe.",
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

        $usuarioMenu = $em->getRepository('JHWEBUsuarioBundle:UserUsuarioMenu')->findBy(
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
        }

        if ($menu->getParent()) {
            $this->createMenuAction($usuario, $menu->getParent());
        }
    }
}
