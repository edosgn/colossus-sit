<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MsvCategoria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Msvcategorium controller.
 *
 * @Route("msvcategoria")
 */
class MsvCategoriaController extends Controller
{
    /**
     * Lists all msvCategorium entities.
     *
     * @Route("/", name="msvcategoria_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $msvCategoria = $em->getRepository('AppBundle:MsvCategoria')->findBy( array('estado' => 1));

        $response = array(
                    'status' => 'succes',
                    'code' => 200,
                    'msj' => "listado festivos",
                    'data' => $msvCategoria,
        );

        return $helpers ->json($response);
    }

    /**
     * Categoria por id.
     *
     * @Route("/getById", name="msvcategoria_id")
     * @Method({"GET", "POST"})
     */
    public function getCategoriaById(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $hash = $request->get("authorization", null);
        $categoriaId = $request->get("json", null);
        $authCheck = $helpers->authCheck($hash);
        $msvCategoria = $em->getRepository('AppBundle:MsvCategoria')->findById($categoriaId);

        $response = array(
                    'status' => 'succes',
                    'code' => 200,
                    'msj' => "Categoria encontrada",
                    'data' => $msvCategoria,
        );

        return $helpers ->json($response);
    }

    /**
     * Creates a new msvCategorium entity.
     *
     * @Route("/new", name="msvcategoria_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $msvCategorium = new Msvcategorium();
        $form = $this->createForm('AppBundle\Form\MsvCategoriaType', $msvCategorium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($msvCategorium);
            $em->flush();

            return $this->redirectToRoute('msvcategoria_show', array('id' => $msvCategorium->getId()));
        }

        return $this->render('msvcategoria/new.html.twig', array(
            'msvCategorium' => $msvCategorium,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a msvCategorium entity.
     *
     * @Route("/{id}", name="msvcategoria_show")
     * @Method("GET")
     */
    public function showAction(MsvCategoria $msvCategorium)
    {
        $deleteForm = $this->createDeleteForm($msvCategorium);

        return $this->render('msvcategoria/show.html.twig', array(
            'msvCategorium' => $msvCategorium,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing msvCategorium entity.
     *
     * @Route("/{id}/edit", name="msvcategoria_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MsvCategoria $msvCategorium)
    {
        $deleteForm = $this->createDeleteForm($msvCategorium);
        $editForm = $this->createForm('AppBundle\Form\MsvCategoriaType', $msvCategorium);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('msvcategoria_edit', array('id' => $msvCategorium->getId()));
        }

        return $this->render('msvcategoria/edit.html.twig', array(
            'msvCategorium' => $msvCategorium,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a msvCategorium entity.
     *
     * @Route("/{id}", name="msvcategoria_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MsvCategoria $msvCategorium)
    {
        $form = $this->createDeleteForm($msvCategorium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($msvCategorium);
            $em->flush();
        }

        return $this->redirectToRoute('msvcategoria_index');
    }

    /**
     * Creates a form to delete a msvCategorium entity.
     *
     * @param MsvCategoria $msvCategorium The msvCategorium entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MsvCategoria $msvCategorium)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('msvcategoria_delete', array('id' => $msvCategorium->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
