<?php

namespace JHWEB\ContravencionalBundle\Controller;

use JHWEB\ContravencionalBundle\Entity\CvCfgModulo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cvcfgmodulo controller.
 *
 * @Route("cvcfgmodulo")
 */
class CvCfgModuloController extends Controller
{
    /**
     * Lists all cvCfgModulo entities.
     *
     * @Route("/", name="cvcfgmodulo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cvCfgModulos = $em->getRepository('JHWEBContravencionalBundle:CvCfgModulo')->findAll();

        return $this->render('cvcfgmodulo/index.html.twig', array(
            'cvCfgModulos' => $cvCfgModulos,
        ));
    }

    /**
     * Creates a new cvCfgModulo entity.
     *
     * @Route("/new", name="cvcfgmodulo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $cvCfgModulo = new Cvcfgmodulo();
        $form = $this->createForm('JHWEB\ContravencionalBundle\Form\CvCfgModuloType', $cvCfgModulo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cvCfgModulo);
            $em->flush();

            return $this->redirectToRoute('cvcfgmodulo_show', array('id' => $cvCfgModulo->getId()));
        }

        return $this->render('cvcfgmodulo/new.html.twig', array(
            'cvCfgModulo' => $cvCfgModulo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a cvCfgModulo entity.
     *
     * @Route("/{id}", name="cvcfgmodulo_show")
     * @Method("GET")
     */
    public function showAction(CvCfgModulo $cvCfgModulo)
    {
        $deleteForm = $this->createDeleteForm($cvCfgModulo);

        return $this->render('cvcfgmodulo/show.html.twig', array(
            'cvCfgModulo' => $cvCfgModulo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cvCfgModulo entity.
     *
     * @Route("/{id}/edit", name="cvcfgmodulo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CvCfgModulo $cvCfgModulo)
    {
        $deleteForm = $this->createDeleteForm($cvCfgModulo);
        $editForm = $this->createForm('JHWEB\ContravencionalBundle\Form\CvCfgModuloType', $cvCfgModulo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cvcfgmodulo_edit', array('id' => $cvCfgModulo->getId()));
        }

        return $this->render('cvcfgmodulo/edit.html.twig', array(
            'cvCfgModulo' => $cvCfgModulo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cvCfgModulo entity.
     *
     * @Route("/{id}", name="cvcfgmodulo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CvCfgModulo $cvCfgModulo)
    {
        $form = $this->createDeleteForm($cvCfgModulo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cvCfgModulo);
            $em->flush();
        }

        return $this->redirectToRoute('cvcfgmodulo_index');
    }

    /**
     * Creates a form to delete a cvCfgModulo entity.
     *
     * @param CvCfgModulo $cvCfgModulo The cvCfgModulo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CvCfgModulo $cvCfgModulo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cvcfgmodulo_delete', array('id' => $cvCfgModulo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
