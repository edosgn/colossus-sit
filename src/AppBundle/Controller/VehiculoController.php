<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Vehiculo;
use AppBundle\Form\VehiculoType;

/**
 * Vehiculo controller.
 *
 * @Route("/vehiculo")
 */
class VehiculoController extends Controller
{
    /**
     * Lists all Vehiculo entities.
     *
     * @Route("/", name="vehiculo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $vehiculos = $em->getRepository('AppBundle:Vehiculo')->findAll();
        $respuesta = array(
                'status' => 'sucsses',
                'vehiculos' => $vehiculos,
                'msj'=> 'conecxion correcta'
            );
        return $helpers->json($respuesta);

    }

    /**
     * Creates a new Vehiculo entity.
     *
     * @Route("/new", name="vehiculo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $vehiculo = new Vehiculo();
        $form = $this->createForm('AppBundle\Form\VehiculoType', $vehiculo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($vehiculo);
            $em->flush();

            return $this->redirectToRoute('vehiculo_show', array('id' => $vehiculo->getId()));
        }

        return $this->render('AppBundle:Vehiculo:new.html.twig', array(
            'vehiculo' => $vehiculo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Vehiculo entity.
     *
     * @Route("/{id}", name="vehiculo_show")
     * @Method("GET")
     */
    public function showAction(Vehiculo $vehiculo)
    {
        $deleteForm = $this->createDeleteForm($vehiculo);

        return $this->render('AppBundle:Vehiculo:show.html.twig', array(
            'vehiculo' => $vehiculo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Vehiculo entity.
     *
     * @Route("/{id}/edit", name="vehiculo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Vehiculo $vehiculo)
    {
        $deleteForm = $this->createDeleteForm($vehiculo);
        $editForm = $this->createForm('AppBundle\Form\VehiculoType', $vehiculo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($vehiculo);
            $em->flush();

            return $this->redirectToRoute('vehiculo_edit', array('id' => $vehiculo->getId()));
        }

        return $this->render('AppBundle:Vehiculo:edit.html.twig', array(
            'vehiculo' => $vehiculo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Vehiculo entity.
     *
     * @Route("/{id}", name="vehiculo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Vehiculo $vehiculo)
    {
        $form = $this->createDeleteForm($vehiculo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vehiculo);
            $em->flush();
        }

        return $this->redirectToRoute('vehiculo_index');
    }

    /**
     * Creates a form to delete a Vehiculo entity.
     *
     * @param Vehiculo $vehiculo The Vehiculo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Vehiculo $vehiculo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vehiculo_delete', array('id' => $vehiculo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
