<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvIpatImpresoMunicipio;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Svipatimpresomunicipio controller.
 *
 * @Route("svipatimpresomunicipio")
 */
class SvIpatImpresoMunicipioController extends Controller
{
    /**
     * Lists all svIpatImpresoMunicipio entities.
     *
     * @Route("/", name="svipatimpresomunicipio_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $svIpatImpresoMunicipios = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatImpresoMunicipio')->findAll();

        return $this->render('svipatimpresomunicipio/index.html.twig', array(
            'svIpatImpresoMunicipios' => $svIpatImpresoMunicipios,
        ));
    }

    /**
     * Creates a new svIpatImpresoMunicipio entity.
     *
     * @Route("/new", name="svipatimpresomunicipio_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $svIpatImpresoMunicipio = new Svipatimpresomunicipio();
        $form = $this->createForm('JHWEB\SeguridadVialBundle\Form\SvIpatImpresoMunicipioType', $svIpatImpresoMunicipio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($svIpatImpresoMunicipio);
            $em->flush();

            return $this->redirectToRoute('svipatimpresomunicipio_show', array('id' => $svIpatImpresoMunicipio->getId()));
        }

        return $this->render('svipatimpresomunicipio/new.html.twig', array(
            'svIpatImpresoMunicipio' => $svIpatImpresoMunicipio,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a svIpatImpresoMunicipio entity.
     *
     * @Route("/{id}", name="svipatimpresomunicipio_show")
     * @Method("GET")
     */
    public function showAction(SvIpatImpresoMunicipio $svIpatImpresoMunicipio)
    {
        $deleteForm = $this->createDeleteForm($svIpatImpresoMunicipio);

        return $this->render('svipatimpresomunicipio/show.html.twig', array(
            'svIpatImpresoMunicipio' => $svIpatImpresoMunicipio,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing svIpatImpresoMunicipio entity.
     *
     * @Route("/{id}/edit", name="svipatimpresomunicipio_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SvIpatImpresoMunicipio $svIpatImpresoMunicipio)
    {
        $deleteForm = $this->createDeleteForm($svIpatImpresoMunicipio);
        $editForm = $this->createForm('JHWEB\SeguridadVialBundle\Form\SvIpatImpresoMunicipioType', $svIpatImpresoMunicipio);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('svipatimpresomunicipio_edit', array('id' => $svIpatImpresoMunicipio->getId()));
        }

        return $this->render('svipatimpresomunicipio/edit.html.twig', array(
            'svIpatImpresoMunicipio' => $svIpatImpresoMunicipio,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a svIpatImpresoMunicipio entity.
     *
     * @Route("/{id}", name="svipatimpresomunicipio_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SvIpatImpresoMunicipio $svIpatImpresoMunicipio)
    {
        $form = $this->createDeleteForm($svIpatImpresoMunicipio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($svIpatImpresoMunicipio);
            $em->flush();
        }

        return $this->redirectToRoute('svipatimpresomunicipio_index');
    }

    /**
     * Creates a form to delete a svIpatImpresoMunicipio entity.
     *
     * @param SvIpatImpresoMunicipio $svIpatImpresoMunicipio The svIpatImpresoMunicipio entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvIpatImpresoMunicipio $svIpatImpresoMunicipio)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svipatimpresomunicipio_delete', array('id' => $svIpatImpresoMunicipio->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
