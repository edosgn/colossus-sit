<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MsvCategoria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Msvcategoria controller.
 *
 * @Route("msvcategoria")
 */
class MsvCategoriaController extends Controller
{
    /**
     * Lists all msvCategoria entities.
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
                    'msj' => "listado categorias",
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
     * Creates a new msvCategoria entity.
     *
     * @Route("/new", name="msvcategoria_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $msvCategoria = new Msvcategoria();
        $form = $this->createForm('AppBundle\Form\MsvCategoriaType', $msvCategoria);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($msvCategoria);
            $em->flush();

            return $this->redirectToRoute('msvcategoria_show', array('id' => $msvCategoria->getId()));
        }

        return $this->render('msvcategoria/new.html.twig', array(
            'msvCategoria' => $msvCategoria,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a msvCategoria entity.
     *
     * @Route("/{id}", name="msvcategoria_show")
     * @Method("GET")
     */
    public function showAction(MsvCategoria $msvCategoria)
    {
        $deleteForm = $this->createDeleteForm($msvCategoria);

        return $this->render('msvcategoria/show.html.twig', array(
            'msvCategoria' => $msvCategoria,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing msvCategoria entity.
     *
     * @Route("/{id}/edit", name="msvcategoria_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MsvCategoria $msvCategoria)
    {
        $deleteForm = $this->createDeleteForm($msvCategoria);
        $editForm = $this->createForm('AppBundle\Form\MsvCategoriaType', $msvCategoria);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('msvcategoria_edit', array('id' => $msvCategoria->getId()));
        }

        return $this->render('msvcategoria/edit.html.twig', array(
            'msvCategoria' => $msvCategoria,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a msvCategoria entity.
     *
     * @Route("/{id}", name="msvcategoria_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MsvCategoria $msvCategoria)
    {
        $form = $this->createDeleteForm($msvCategoria);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($msvCategoria);
            $em->flush();
        }

        return $this->redirectToRoute('msvcategoria_index');
    }

    /**
     * Creates a form to delete a msvCategoria entity.
     *
     * @param MsvCategoria $msvCategoria The msvCategoria entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MsvCategoria $msvCategoria)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('msvcategoria_delete', array('id' => $msvCategoria->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    
    /**
     * datos para select 2
     *
     * @Route("/select/categoria", name="msvCategoria_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $categorias = $em->getRepository('AppBundle:MsvCategoria')->findBy(
            array('estado' => 1)
        );
        $response = null;

        foreach ($categorias as $key => $categoria) {
            $response[$key] = array(
                'value' => $categoria->getId(),
                'label' => $categoria->getNombre(),
            );
        }
        return $helpers->json($response);
    }
}
