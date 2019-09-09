<?php

namespace JHWEB\UsuarioBundle\Controller;

use JHWEB\UsuarioBundle\Entity\UserLcCfgRestriccion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Userlccfgrestriccion controller.
 *
 * @Route("userlccfgrestriccion")
 */
class UserLcCfgRestriccionController extends Controller
{
    /**
     * Lists all userLcCfgRestriccion entities.
     *
     * @Route("/", name="userlccfgrestriccion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $userLcCfgRestriccions = $em->getRepository('JHWEBUsuarioBundle:UserLcCfgRestriccion')->findAll();

        return $this->render('userlccfgrestriccion/index.html.twig', array(
            'userLcCfgRestriccions' => $userLcCfgRestriccions,
        ));
    }

    /**
     * Creates a new userLcCfgRestriccion entity.
     *
     * @Route("/new", name="userlccfgrestriccion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $userLcCfgRestriccion = new Userlccfgrestriccion();
        $form = $this->createForm('JHWEB\UsuarioBundle\Form\UserLcCfgRestriccionType', $userLcCfgRestriccion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($userLcCfgRestriccion);
            $em->flush();

            return $this->redirectToRoute('userlccfgrestriccion_show', array('id' => $userLcCfgRestriccion->getId()));
        }

        return $this->render('userlccfgrestriccion/new.html.twig', array(
            'userLcCfgRestriccion' => $userLcCfgRestriccion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a userLcCfgRestriccion entity.
     *
     * @Route("/{id}", name="userlccfgrestriccion_show")
     * @Method("GET")
     */
    public function showAction(UserLcCfgRestriccion $userLcCfgRestriccion)
    {
        $deleteForm = $this->createDeleteForm($userLcCfgRestriccion);

        return $this->render('userlccfgrestriccion/show.html.twig', array(
            'userLcCfgRestriccion' => $userLcCfgRestriccion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing userLcCfgRestriccion entity.
     *
     * @Route("/{id}/edit", name="userlccfgrestriccion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, UserLcCfgRestriccion $userLcCfgRestriccion)
    {
        $deleteForm = $this->createDeleteForm($userLcCfgRestriccion);
        $editForm = $this->createForm('JHWEB\UsuarioBundle\Form\UserLcCfgRestriccionType', $userLcCfgRestriccion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('userlccfgrestriccion_edit', array('id' => $userLcCfgRestriccion->getId()));
        }

        return $this->render('userlccfgrestriccion/edit.html.twig', array(
            'userLcCfgRestriccion' => $userLcCfgRestriccion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a userLcCfgRestriccion entity.
     *
     * @Route("/{id}", name="userlccfgrestriccion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, UserLcCfgRestriccion $userLcCfgRestriccion)
    {
        $form = $this->createDeleteForm($userLcCfgRestriccion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($userLcCfgRestriccion);
            $em->flush();
        }

        return $this->redirectToRoute('userlccfgrestriccion_index');
    }

    /**
     * Creates a form to delete a userLcCfgRestriccion entity.
     *
     * @param UserLcCfgRestriccion $userLcCfgRestriccion The userLcCfgRestriccion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(UserLcCfgRestriccion $userLcCfgRestriccion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('userlccfgrestriccion_delete', array('id' => $userLcCfgRestriccion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
