<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Limitacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Limitacion controller.
 *
 * @Route("limitacion")
 */
class LimitacionController extends Controller
{
    /**
     * Lists all limitacion entities.
     *
     * @Route("/", name="limitacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $limitacions = $em->getRepository('AppBundle:Limitacion')->findAll();

        return $this->render('limitacion/index.html.twig', array(
            'limitacions' => $limitacions,
        ));
    }

    /**
     * Creates a new limitacion entity.
     *
     * @Route("/new", name="limitacion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $limitacion = new Limitacion();
        $form = $this->createForm('AppBundle\Form\LimitacionType', $limitacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($limitacion);
            $em->flush();

            return $this->redirectToRoute('limitacion_show', array('id' => $limitacion->getId()));
        }

        return $this->render('limitacion/new.html.twig', array(
            'limitacion' => $limitacion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a limitacion entity.
     *
     * @Route("/{id}", name="limitacion_show")
     * @Method("GET")
     */
    public function showAction(Limitacion $limitacion)
    {
        $deleteForm = $this->createDeleteForm($limitacion);

        return $this->render('limitacion/show.html.twig', array(
            'limitacion' => $limitacion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing limitacion entity.
     *
     * @Route("/{id}/edit", name="limitacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Limitacion $limitacion)
    {
        $deleteForm = $this->createDeleteForm($limitacion);
        $editForm = $this->createForm('AppBundle\Form\LimitacionType', $limitacion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('limitacion_edit', array('id' => $limitacion->getId()));
        }

        return $this->render('limitacion/edit.html.twig', array(
            'limitacion' => $limitacion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a limitacion entity.
     *
     * @Route("/{id}", name="limitacion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Limitacion $limitacion)
    {
        $form = $this->createDeleteForm($limitacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($limitacion);
            $em->flush();
        }

        return $this->redirectToRoute('limitacion_index');
    }

    /**
     * Creates a form to delete a limitacion entity.
     *
     * @param Limitacion $limitacion The limitacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Limitacion $limitacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('limitacion_delete', array('id' => $limitacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 
     *
     * @Route("/select", name="limitacion_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $limitaciones = $em->getRepository('AppBundle:Limitacion')->findBy(
        array('estado' => 1)
    );
      foreach ($limitaciones as $key => $limitacion) {
        $response[$key] = array(
            'value' => $limitacion->getId(),
            'label' => $limitacion->getCodigoMt()."_".$limitacion->getNombre(),
            );
      }
       return $helpers->json($response);
    }
}
