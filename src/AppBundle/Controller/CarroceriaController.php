<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Carroceria;
use AppBundle\Form\CarroceriaType;

/**
 * Carroceria controller.
 *
 * @Route("/carroceria")
 */
class CarroceriaController extends Controller
{
    /**
     * Lists all Carroceria entities.
     *
     * @Route("/", name="carroceria_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $carrocerias = $em->getRepository('AppBundle:Carroceria')->findAll();

        return $this->render('AppBundle:carroceria:index.html.twig', array(
            'carrocerias' => $carrocerias,
        ));
    }

    /**
     * Creates a new Carroceria entity.
     *
     * @Route("/new", name="carroceria_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $carrocerium = new Carroceria();
        $form = $this->createForm('AppBundle\Form\CarroceriaType', $carrocerium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($carrocerium);
            $em->flush();

            return $this->redirectToRoute('carroceria_show', array('id' => $carrocerium->getId()));
        }

        return $this->render('AppBundle:carroceria:new.html.twig', array(
            'carrocerium' => $carrocerium,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Carroceria entity.
     *
     * @Route("/{id}", name="carroceria_show")
     * @Method("GET")
     */
    public function showAction(Carroceria $carrocerium)
    {
        $deleteForm = $this->createDeleteForm($carrocerium);

        return $this->render('AppBundle:carroceria:show.html.twig', array(
            'carrocerium' => $carrocerium,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Carroceria entity.
     *
     * @Route("/{id}/edit", name="carroceria_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Carroceria $carrocerium)
    {
        $deleteForm = $this->createDeleteForm($carrocerium);
        $editForm = $this->createForm('AppBundle\Form\CarroceriaType', $carrocerium);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($carrocerium);
            $em->flush();

            return $this->redirectToRoute('carroceria_edit', array('id' => $carrocerium->getId()));
        }

        return $this->render('AppBundle:carroceria:edit.html.twig', array(
            'carrocerium' => $carrocerium,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Carroceria entity.
     *
     * @Route("/{id}", name="carroceria_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Carroceria $carrocerium)
    {
        $form = $this->createDeleteForm($carrocerium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($carrocerium);
            $em->flush();
        }

        return $this->redirectToRoute('carroceria_index');
    }

    /**
     * Creates a form to delete a Carroceria entity.
     *
     * @param Carroceria $carrocerium The Carroceria entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Carroceria $carrocerium)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('carroceria_delete', array('id' => $carrocerium->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
