<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\CiudadanoVehiculo;
use AppBundle\Form\CiudadanoVehiculoType;

/**
 * CiudadanoVehiculo controller.
 *
 * @Route("/ciudadanovehiculo")
 */
class CiudadanoVehiculoController extends Controller
{
    /**
     * Lists all CiudadanoVehiculo entities.
     *
     * @Route("/", name="ciudadanovehiculo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ciudadanoVehiculos = $em->getRepository('AppBundle:CiudadanoVehiculo')->findAll();

        return $this->render('AppBundle:ciudadanovehiculo:index.html.twig', array(
            'ciudadanoVehiculos' => $ciudadanoVehiculos,
        ));
    }

    /**
     * Creates a new CiudadanoVehiculo entity.
     *
     * @Route("/new", name="ciudadanovehiculo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $ciudadanoVehiculo = new CiudadanoVehiculo();
        $form = $this->createForm('AppBundle\Form\CiudadanoVehiculoType', $ciudadanoVehiculo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ciudadanoVehiculo);
            $em->flush();

            return $this->redirectToRoute('ciudadanovehiculo_show', array('id' => $ciudadanoVehiculo->getId()));
        }

        return $this->render('AppBundle:ciudadanovehiculo:new.html.twig', array(
            'ciudadanoVehiculo' => $ciudadanoVehiculo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a CiudadanoVehiculo entity.
     *
     * @Route("/{id}", name="ciudadanovehiculo_show")
     * @Method("GET")
     */
    public function showAction(CiudadanoVehiculo $ciudadanoVehiculo)
    {
        $deleteForm = $this->createDeleteForm($ciudadanoVehiculo);

        return $this->render('AppBundle:ciudadanovehiculo:show.html.twig', array(
            'ciudadanoVehiculo' => $ciudadanoVehiculo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing CiudadanoVehiculo entity.
     *
     * @Route("/{id}/edit", name="ciudadanovehiculo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CiudadanoVehiculo $ciudadanoVehiculo)
    {
        $deleteForm = $this->createDeleteForm($ciudadanoVehiculo);
        $editForm = $this->createForm('AppBundle\Form\CiudadanoVehiculoType', $ciudadanoVehiculo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ciudadanoVehiculo);
            $em->flush();

            return $this->redirectToRoute('ciudadanovehiculo_edit', array('id' => $ciudadanoVehiculo->getId()));
        }

        return $this->render('AppBundle:ciudadanovehiculo:edit.html.twig', array(
            'ciudadanoVehiculo' => $ciudadanoVehiculo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a CiudadanoVehiculo entity.
     *
     * @Route("/{id}", name="ciudadanovehiculo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CiudadanoVehiculo $ciudadanoVehiculo)
    {
        $form = $this->createDeleteForm($ciudadanoVehiculo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ciudadanoVehiculo);
            $em->flush();
        }

        return $this->redirectToRoute('ciudadanovehiculo_index');
    }

    /**
     * Creates a form to delete a CiudadanoVehiculo entity.
     *
     * @param CiudadanoVehiculo $ciudadanoVehiculo The CiudadanoVehiculo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CiudadanoVehiculo $ciudadanoVehiculo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ciudadanovehiculo_delete', array('id' => $ciudadanoVehiculo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
