<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Bodega;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request; use Symfony\Component\HttpFoundation\Response;

/**
 * Bodega controller.
 *
 * @Route("bodega")
 */
class BodegaController extends Controller
{
    /**
     * Lists all bodega entities.
     *
     * @Route("/", name="bodega_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $bodegas = $em->getRepository('AppBundle:Bodega')->findAll();

        return $this->render('bodega/index.html.twig', array(
            'bodegas' => $bodegas,
        ));
    }

    /**
     * Creates a new bodega entity.
     *
     * @Route("/new", name="bodega_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $bodega = new Bodega();
        $form = $this->createForm('AppBundle\Form\BodegaType', $bodega);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($bodega);
            $em->flush();

            return $this->redirectToRoute('bodega_show', array('id' => $bodega->getId()));
        }

        return $this->render('bodega/new.html.twig', array(
            'bodega' => $bodega,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a bodega entity.
     *
     * Route("/{id}", name="bodega_show")
     * Method("GET")
     */
    public function showAction(Bodega $bodega)
    {
        $deleteForm = $this->createDeleteForm($bodega);

        return $this->render('bodega/show.html.twig', array(
            'bodega' => $bodega,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing bodega entity.
     *
     * @Route("/{id}/edit", name="bodega_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Bodega $bodega)
    {
        $deleteForm = $this->createDeleteForm($bodega);
        $editForm = $this->createForm('AppBundle\Form\BodegaType', $bodega);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('bodega_edit', array('id' => $bodega->getId()));
        }

        return $this->render('bodega/edit.html.twig', array(
            'bodega' => $bodega,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a bodega entity.
     *
     * @Route("/{id}", name="bodega_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Bodega $bodega)
    {
        $form = $this->createDeleteForm($bodega);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($bodega);
            $em->flush();
        }

        return $this->redirectToRoute('bodega_index');
    }

    /**
     * Creates a form to delete a bodega entity.
     *
     * @param Bodega $bodega The bodega entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Bodega $bodega)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bodega_delete', array('id' => $bodega->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="bodega_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $bodegas = $em->getRepository('AppBundle:Bodega')->findBy(
            array('estado' => 1)
        );
        foreach ($bodegas as $key => $bodega) {
            $response[$key] = array(
                'value' => $bodega->getId(),
                'label' => $bodega->getNombre(),
            );
        }
        return $helpers->json($response);
    }

}
