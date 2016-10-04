<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Banco;
use AppBundle\Form\BancoType;

/**
 * Banco controller.
 *
 * @Route("/banco")
 */
class BancoController extends Controller
{ 
    /**
     * Lists all Banco entities.
     *
     * @Route("/", name="banco_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $bancos = $em->getRepository('AppBundle:Departamento')->findBy(
            array('estado' => 1)
        );

         $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado departamentos", 
                    'data'=> $departamentos,
            );
         
        return $helpers->json($responce);
    }

    /**
     * Creates a new Banco entity.
     *
     * @Route("/new", name="banco_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $banco = new Banco();
        $form = $this->createForm('AppBundle\Form\BancoType', $banco);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($banco);
            $em->flush();

            return $this->redirectToRoute('banco_show', array('id' => $banco->getId()));
        }

        return $this->render('AppBundle:banco:new.html.twig', array(
            'banco' => $banco,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Banco entity.
     *
     * @Route("/{id}", name="banco_show")
     * @Method("GET")
     */
    public function showAction(Banco $banco)
    {
        $deleteForm = $this->createDeleteForm($banco);

        return $this->render('AppBundle:banco:show.html.twig', array(
            'banco' => $banco,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Banco entity.
     *
     * @Route("/{id}/edit", name="banco_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Banco $banco)
    {
        $deleteForm = $this->createDeleteForm($banco);
        $editForm = $this->createForm('AppBundle\Form\BancoType', $banco);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($banco);
            $em->flush();

            return $this->redirectToRoute('banco_edit', array('id' => $banco->getId()));
        }

        return $this->render('AppBundle:banco:edit.html.twig', array(
            'banco' => $banco,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Banco entity.
     *
     * @Route("/{id}", name="banco_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Banco $banco)
    {
        $form = $this->createDeleteForm($banco);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($banco);
            $em->flush();
        }

        return $this->redirectToRoute('banco_index');
    }

    /**
     * Creates a form to delete a Banco entity.
     *
     * @param Banco $banco The Banco entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Banco $banco)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('banco_delete', array('id' => $banco->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
