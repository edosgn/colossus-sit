<?php

namespace JHWEB\ContravencionalBundle\Controller;

use JHWEB\ContravencionalBundle\Entity\CvMedidaCautelar;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cvmedidacautelar controller.
 *
 * @Route("cvmedidacautelar")
 */
class CvMedidaCautelarController extends Controller
{
    /**
     * Lists all cvMedidaCautelar entities.
     *
     * @Route("/", name="cvmedidacautelar_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cvMedidaCautelars = $em->getRepository('JHWEBContravencionalBundle:CvMedidaCautelar')->findAll();

        return $this->render('cvmedidacautelar/index.html.twig', array(
            'cvMedidaCautelars' => $cvMedidaCautelars,
        ));
    }

    /**
     * Creates a new cvMedidaCautelar entity.
     *
     * @Route("/new", name="cvmedidacautelar_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $cvMedidaCautelar = new Cvmedidacautelar();
        $form = $this->createForm('JHWEB\ContravencionalBundle\Form\CvMedidaCautelarType', $cvMedidaCautelar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cvMedidaCautelar);
            $em->flush();

            return $this->redirectToRoute('cvmedidacautelar_show', array('id' => $cvMedidaCautelar->getId()));
        }

        return $this->render('cvmedidacautelar/new.html.twig', array(
            'cvMedidaCautelar' => $cvMedidaCautelar,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a cvMedidaCautelar entity.
     *
     * @Route("/{id}", name="cvmedidacautelar_show")
     * @Method("GET")
     */
    public function showAction(CvMedidaCautelar $cvMedidaCautelar)
    {
        $deleteForm = $this->createDeleteForm($cvMedidaCautelar);

        return $this->render('cvmedidacautelar/show.html.twig', array(
            'cvMedidaCautelar' => $cvMedidaCautelar,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cvMedidaCautelar entity.
     *
     * @Route("/{id}/edit", name="cvmedidacautelar_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CvMedidaCautelar $cvMedidaCautelar)
    {
        $deleteForm = $this->createDeleteForm($cvMedidaCautelar);
        $editForm = $this->createForm('JHWEB\ContravencionalBundle\Form\CvMedidaCautelarType', $cvMedidaCautelar);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cvmedidacautelar_edit', array('id' => $cvMedidaCautelar->getId()));
        }

        return $this->render('cvmedidacautelar/edit.html.twig', array(
            'cvMedidaCautelar' => $cvMedidaCautelar,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cvMedidaCautelar entity.
     *
     * @Route("/{id}", name="cvmedidacautelar_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CvMedidaCautelar $cvMedidaCautelar)
    {
        $form = $this->createDeleteForm($cvMedidaCautelar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cvMedidaCautelar);
            $em->flush();
        }

        return $this->redirectToRoute('cvmedidacautelar_index');
    }

    /**
     * Creates a form to delete a cvMedidaCautelar entity.
     *
     * @param CvMedidaCautelar $cvMedidaCautelar The cvMedidaCautelar entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CvMedidaCautelar $cvMedidaCautelar)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cvmedidacautelar_delete', array('id' => $cvMedidaCautelar->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
