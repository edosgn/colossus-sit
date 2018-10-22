<?php

namespace JHWEB\InsumoBundle\Controller;

use JHWEB\InsumoBundle\Entity\ImoTrazabilidad;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Imotrazabilidad controller.
 *
 * @Route("imotrazabilidad")
 */
class ImoTrazabilidadController extends Controller
{
    /**
     * Lists all imoTrazabilidad entities.
     *
     * @Route("/reasignacion", name="imotrazabilidad_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        
        $em = $this->getDoctrine()->getManager();

        $imoTrazabilidads = $em->getRepository('JHWEBInsumoBundle:ImoTrazabilidad')->findBy(
            array('estado' => 'REASIGNACION')
        );

        $response['data'] = array();

        if ($imoTrazabilidads) {
            $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => 'listado placas',
                        'data' => $imoTrazabilidads,
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a new imoTrazabilidad entity.
     *
     * @Route("/new", name="imotrazabilidad_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $imoTrazabilidad = new Imotrazabilidad();
        $form = $this->createForm('JHWEB\InsumoBundle\Form\ImoTrazabilidadType', $imoTrazabilidad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($imoTrazabilidad);
            $em->flush();

            return $this->redirectToRoute('imotrazabilidad_show', array('id' => $imoTrazabilidad->getId()));
        }

        return $this->render('imotrazabilidad/new.html.twig', array(
            'imoTrazabilidad' => $imoTrazabilidad,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a imoTrazabilidad entity.
     *
     * @Route("/{id}", name="imotrazabilidad_show")
     * @Method("GET")
     */
    public function showAction(ImoTrazabilidad $imoTrazabilidad)
    {
        $deleteForm = $this->createDeleteForm($imoTrazabilidad);

        return $this->render('imotrazabilidad/show.html.twig', array(
            'imoTrazabilidad' => $imoTrazabilidad,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing imoTrazabilidad entity.
     *
     * @Route("/{id}/edit", name="imotrazabilidad_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ImoTrazabilidad $imoTrazabilidad)
    {
        $deleteForm = $this->createDeleteForm($imoTrazabilidad);
        $editForm = $this->createForm('JHWEB\InsumoBundle\Form\ImoTrazabilidadType', $imoTrazabilidad);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('imotrazabilidad_edit', array('id' => $imoTrazabilidad->getId()));
        }

        return $this->render('imotrazabilidad/edit.html.twig', array(
            'imoTrazabilidad' => $imoTrazabilidad,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a imoTrazabilidad entity.
     *
     * @Route("/{id}", name="imotrazabilidad_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ImoTrazabilidad $imoTrazabilidad)
    {
        $form = $this->createDeleteForm($imoTrazabilidad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($imoTrazabilidad);
            $em->flush();
        }

        return $this->redirectToRoute('imotrazabilidad_index');
    }

    /**
     * Creates a form to delete a imoTrazabilidad entity.
     *
     * @param ImoTrazabilidad $imoTrazabilidad The imoTrazabilidad entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ImoTrazabilidad $imoTrazabilidad)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('imotrazabilidad_delete', array('id' => $imoTrazabilidad->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
