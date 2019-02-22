<?php

namespace JHWEB\UsuarioBundle\Controller;

use JHWEB\UsuarioBundle\Entity\UserEmpresa;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Userempresa controller.
 *
 * @Route("userempresa")
 */
class UserEmpresaController extends Controller
{
    /**
     * Lists all userEmpresa entities.
     *
     * @Route("/", name="userempresa_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $userEmpresas = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->findAll();

        return $this->render('userempresa/index.html.twig', array(
            'userEmpresas' => $userEmpresas,
        ));
    }

    /**
     * Creates a new userEmpresa entity.
     *
     * @Route("/new", name="userempresa_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $userEmpresa = new Userempresa();
        $form = $this->createForm('JHWEB\UsuarioBundle\Form\UserEmpresaType', $userEmpresa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($userEmpresa);
            $em->flush();

            return $this->redirectToRoute('userempresa_show', array('id' => $userEmpresa->getId()));
        }

        return $this->render('userempresa/new.html.twig', array(
            'userEmpresa' => $userEmpresa,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a userEmpresa entity.
     *
     * @Route("/{id}", name="userempresa_show")
     * @Method("GET")
     */
    public function showAction(UserEmpresa $userEmpresa)
    {
        $deleteForm = $this->createDeleteForm($userEmpresa);

        return $this->render('userempresa/show.html.twig', array(
            'userEmpresa' => $userEmpresa,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing userEmpresa entity.
     *
     * @Route("/{id}/edit", name="userempresa_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, UserEmpresa $userEmpresa)
    {
        $deleteForm = $this->createDeleteForm($userEmpresa);
        $editForm = $this->createForm('JHWEB\UsuarioBundle\Form\UserEmpresaType', $userEmpresa);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('userempresa_edit', array('id' => $userEmpresa->getId()));
        }

        return $this->render('userempresa/edit.html.twig', array(
            'userEmpresa' => $userEmpresa,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a userEmpresa entity.
     *
     * @Route("/{id}", name="userempresa_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, UserEmpresa $userEmpresa)
    {
        $form = $this->createDeleteForm($userEmpresa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($userEmpresa);
            $em->flush();
        }

        return $this->redirectToRoute('userempresa_index');
    }

    /**
     * Creates a form to delete a userEmpresa entity.
     *
     * @param UserEmpresa $userEmpresa The userEmpresa entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(UserEmpresa $userEmpresa)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('userempresa_delete', array('id' => $userEmpresa->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
