<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Combustible;
use AppBundle\Form\CombustibleType;

/**
 * Combustible controller. 
 *
 * @Route("/combustible")
 */
class CombustibleController extends Controller
{
    /**
     * Lists all Combustible entities.
     *
     * @Route("/", name="combustible_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $combustibles = $em->getRepository('AppBundle:Combustible')->findBy(
            array('estado' => 1)
        );
        $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado combustibles", 
                    'data'=> $combustibles,
            );
         
        return $helpers->json($responce);
    }

    /**
     * Creates a new Combustible entity.
     *
     * @Route("/new", name="combustible_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $combustible = new Combustible();
        $form = $this->createForm('AppBundle\Form\CombustibleType', $combustible);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($combustible);
            $em->flush();

            return $this->redirectToRoute('combustible_show', array('id' => $combustible->getId()));
        }

        return $this->render('AppBundle:combustible:new.html.twig', array(
            'combustible' => $combustible,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Combustible entity.
     *
     * @Route("/{id}", name="combustible_show")
     * @Method("GET")
     */
    public function showAction(Combustible $combustible)
    {
        $deleteForm = $this->createDeleteForm($combustible);

        return $this->render('AppBundle:combustible:show.html.twig', array(
            'combustible' => $combustible,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Combustible entity.
     *
     * @Route("/{id}/edit", name="combustible_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Combustible $combustible)
    {
        $deleteForm = $this->createDeleteForm($combustible);
        $editForm = $this->createForm('AppBundle\Form\CombustibleType', $combustible);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($combustible);
            $em->flush();

            return $this->redirectToRoute('combustible_edit', array('id' => $combustible->getId()));
        }

        return $this->render('AppBundle:combustible:edit.html.twig', array(
            'combustible' => $combustible,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Combustible entity.
     *
     * @Route("/{id}", name="combustible_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Combustible $combustible)
    {
        $form = $this->createDeleteForm($combustible);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($combustible);
            $em->flush();
        }

        return $this->redirectToRoute('combustible_index');
    }

    /**
     * Creates a form to delete a Combustible entity.
     *
     * @param Combustible $combustible The Combustible entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Combustible $combustible)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('combustible_delete', array('id' => $combustible->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
