<?php

namespace JHWEB\ContravencionalBundle\Controller;

use JHWEB\ContravencionalBundle\Entity\CvCdoTrazabilidad;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Cvcdotrazabilidad controller.
 *
 * @Route("cvcdotrazabilidad")
 */
class CvCdoTrazabilidadController extends Controller
{
    /**
     * Lists all cvCdoTrazabilidad entities.
     *
     * @Route("/", name="cvcdotrazabilidad_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cvCdoTrazabilidads = $em->getRepository('JHWEBContravencionalBundle:CvCdoTrazabilidad')->findAll();

        return $this->render('cvcdotrazabilidad/index.html.twig', array(
            'cvCdoTrazabilidads' => $cvCdoTrazabilidads,
        ));
    }

    /**
     * Creates a new cvCdoTrazabilidad entity.
     *
     * @Route("/new", name="cvcdotrazabilidad_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $cvCdoTrazabilidad = new Cvcdotrazabilidad();
        $form = $this->createForm('JHWEB\ContravencionalBundle\Form\CvCdoTrazabilidadType', $cvCdoTrazabilidad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cvCdoTrazabilidad);
            $em->flush();

            return $this->redirectToRoute('cvcdotrazabilidad_show', array('id' => $cvCdoTrazabilidad->getId()));
        }

        return $this->render('cvcdotrazabilidad/new.html.twig', array(
            'cvCdoTrazabilidad' => $cvCdoTrazabilidad,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a cvCdoTrazabilidad entity.
     *
     * @Route("/{id}", name="cvcdotrazabilidad_show")
     * @Method("GET")
     */
    public function showAction(CvCdoTrazabilidad $cvCdoTrazabilidad)
    {
        $deleteForm = $this->createDeleteForm($cvCdoTrazabilidad);

        return $this->render('cvcdotrazabilidad/show.html.twig', array(
            'cvCdoTrazabilidad' => $cvCdoTrazabilidad,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cvCdoTrazabilidad entity.
     *
     * @Route("/{id}/edit", name="cvcdotrazabilidad_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CvCdoTrazabilidad $cvCdoTrazabilidad)
    {
        $deleteForm = $this->createDeleteForm($cvCdoTrazabilidad);
        $editForm = $this->createForm('JHWEB\ContravencionalBundle\Form\CvCdoTrazabilidadType', $cvCdoTrazabilidad);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cvcdotrazabilidad_edit', array('id' => $cvCdoTrazabilidad->getId()));
        }

        return $this->render('cvcdotrazabilidad/edit.html.twig', array(
            'cvCdoTrazabilidad' => $cvCdoTrazabilidad,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cvCdoTrazabilidad entity.
     *
     * @Route("/{id}", name="cvcdotrazabilidad_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CvCdoTrazabilidad $cvCdoTrazabilidad)
    {
        $form = $this->createDeleteForm($cvCdoTrazabilidad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cvCdoTrazabilidad);
            $em->flush();
        }

        return $this->redirectToRoute('cvcdotrazabilidad_index');
    }

    /**
     * Creates a form to delete a cvCdoTrazabilidad entity.
     *
     * @param CvCdoTrazabilidad $cvCdoTrazabilidad The cvCdoTrazabilidad entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CvCdoTrazabilidad $cvCdoTrazabilidad)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cvcdotrazabilidad_delete', array('id' => $cvCdoTrazabilidad->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
