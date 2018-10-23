<?php

namespace Repository\UsuarioBundle\Controller;

use Repository\UsuarioBundle\Entity\UserCfgRoleMenu;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Usercfgrolemenu controller.
 *
 * @Route("usercfgrolemenu")
 */
class UserCfgRoleMenuController extends Controller
{
    /**
     * Lists all userCfgRoleMenu entities.
     *
     * @Route("/", name="usercfgrolemenu_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $userCfgRoleMenus = $em->getRepository('UsuarioBundle:UserCfgRoleMenu')->findAll();

        return $this->render('usercfgrolemenu/index.html.twig', array(
            'userCfgRoleMenus' => $userCfgRoleMenus,
        ));
    }

    /**
     * Creates a new userCfgRoleMenu entity.
     *
     * @Route("/new", name="usercfgrolemenu_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $userCfgRoleMenu = new Usercfgrolemenu();
        $form = $this->createForm('Repository\UsuarioBundle\Form\UserCfgRoleMenuType', $userCfgRoleMenu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($userCfgRoleMenu);
            $em->flush();

            return $this->redirectToRoute('usercfgrolemenu_show', array('id' => $userCfgRoleMenu->getId()));
        }

        return $this->render('usercfgrolemenu/new.html.twig', array(
            'userCfgRoleMenu' => $userCfgRoleMenu,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a userCfgRoleMenu entity.
     *
     * @Route("/{id}", name="usercfgrolemenu_show")
     * @Method("GET")
     */
    public function showAction(UserCfgRoleMenu $userCfgRoleMenu)
    {
        $deleteForm = $this->createDeleteForm($userCfgRoleMenu);

        return $this->render('usercfgrolemenu/show.html.twig', array(
            'userCfgRoleMenu' => $userCfgRoleMenu,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing userCfgRoleMenu entity.
     *
     * @Route("/{id}/edit", name="usercfgrolemenu_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, UserCfgRoleMenu $userCfgRoleMenu)
    {
        $deleteForm = $this->createDeleteForm($userCfgRoleMenu);
        $editForm = $this->createForm('Repository\UsuarioBundle\Form\UserCfgRoleMenuType', $userCfgRoleMenu);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('usercfgrolemenu_edit', array('id' => $userCfgRoleMenu->getId()));
        }

        return $this->render('usercfgrolemenu/edit.html.twig', array(
            'userCfgRoleMenu' => $userCfgRoleMenu,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a userCfgRoleMenu entity.
     *
     * @Route("/{id}", name="usercfgrolemenu_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, UserCfgRoleMenu $userCfgRoleMenu)
    {
        $form = $this->createDeleteForm($userCfgRoleMenu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($userCfgRoleMenu);
            $em->flush();
        }

        return $this->redirectToRoute('usercfgrolemenu_index');
    }

    /**
     * Creates a form to delete a userCfgRoleMenu entity.
     *
     * @param UserCfgRoleMenu $userCfgRoleMenu The userCfgRoleMenu entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(UserCfgRoleMenu $userCfgRoleMenu)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('usercfgrolemenu_delete', array('id' => $userCfgRoleMenu->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
