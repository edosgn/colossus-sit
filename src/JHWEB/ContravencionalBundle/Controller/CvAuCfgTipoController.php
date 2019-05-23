<?php

namespace JHWEB\ContravencionalBundle\Controller;

use JHWEB\ContravencionalBundle\Entity\CvAuCfgTipo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cvaucfgtipo controller.
 *
 * @Route("cvaucfgtipo")
 */
class CvAuCfgTipoController extends Controller
{
    /**
     * Lists all cvAuCfgTipo entities.
     *
     * @Route("/", name="cvaucfgtipo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $tipos = $em->getRepository('JHWEBContravencionalBundle:CvAuCfgTipo')->findBy(
            array(
                'activo' => true
            )
        );

        $response['data'] = array();

        if ($tipos) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($tipos)." registros encontrados", 
                'data'=> $tipos,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new cvAuCfgTipo entity.
     *
     * @Route("/new", name="cvaucfgtipo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $cvAuCfgTipo = new Cvaucfgtipo();
        $form = $this->createForm('JHWEB\ContravencionalBundle\Form\CvAuCfgTipoType', $cvAuCfgTipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cvAuCfgTipo);
            $em->flush();

            return $this->redirectToRoute('cvaucfgtipo_show', array('id' => $cvAuCfgTipo->getId()));
        }

        return $this->render('cvaucfgtipo/new.html.twig', array(
            'cvAuCfgTipo' => $cvAuCfgTipo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a cvAuCfgTipo entity.
     *
     * @Route("/{id}", name="cvaucfgtipo_show")
     * @Method("GET")
     */
    public function showAction(CvAuCfgTipo $cvAuCfgTipo)
    {
        $deleteForm = $this->createDeleteForm($cvAuCfgTipo);

        return $this->render('cvaucfgtipo/show.html.twig', array(
            'cvAuCfgTipo' => $cvAuCfgTipo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cvAuCfgTipo entity.
     *
     * @Route("/{id}/edit", name="cvaucfgtipo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CvAuCfgTipo $cvAuCfgTipo)
    {
        $deleteForm = $this->createDeleteForm($cvAuCfgTipo);
        $editForm = $this->createForm('JHWEB\ContravencionalBundle\Form\CvAuCfgTipoType', $cvAuCfgTipo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cvaucfgtipo_edit', array('id' => $cvAuCfgTipo->getId()));
        }

        return $this->render('cvaucfgtipo/edit.html.twig', array(
            'cvAuCfgTipo' => $cvAuCfgTipo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cvAuCfgTipo entity.
     *
     * @Route("/{id}", name="cvaucfgtipo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CvAuCfgTipo $cvAuCfgTipo)
    {
        $form = $this->createDeleteForm($cvAuCfgTipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cvAuCfgTipo);
            $em->flush();
        }

        return $this->redirectToRoute('cvaucfgtipo_index');
    }

    /**
     * Creates a form to delete a cvAuCfgTipo entity.
     *
     * @param CvAuCfgTipo $cvAuCfgTipo The cvAuCfgTipo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CvAuCfgTipo $cvAuCfgTipo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cvaucfgtipo_delete', array('id' => $cvAuCfgTipo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
