<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvSenialInventarioBodega;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Svsenialinventariobodega controller.
 *
 * @Route("svsenialinventariobodega")
 */
class SvSenialInventarioBodegaController extends Controller
{
    /**
     * Lists all svSenialInventarioBodega entities.
     *
     * @Route("/", name="svsenialinventariobodega_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $svSenialInventarioBodegas = $em->getRepository('JHWEBSeguridadVialBundle:SvSenialInventarioBodega')->findAll();

        return $this->render('svsenialinventariobodega/index.html.twig', array(
            'svSenialInventarioBodegas' => $svSenialInventarioBodegas,
        ));
    }

    /**
     * Creates a new svSenialInventarioBodega entity.
     *
     * @Route("/new", name="svsenialinventariobodega_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $svSenialInventarioBodega = new Svsenialinventariobodega();
        $form = $this->createForm('JHWEB\SeguridadVialBundle\Form\SvSenialInventarioBodegaType', $svSenialInventarioBodega);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($svSenialInventarioBodega);
            $em->flush();

            return $this->redirectToRoute('svsenialinventariobodega_show', array('id' => $svSenialInventarioBodega->getId()));
        }

        return $this->render('svsenialinventariobodega/new.html.twig', array(
            'svSenialInventarioBodega' => $svSenialInventarioBodega,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a svSenialInventarioBodega entity.
     *
     * @Route("/{id}", name="svsenialinventariobodega_show")
     * @Method("GET")
     */
    public function showAction(SvSenialInventarioBodega $svSenialInventarioBodega)
    {
        $deleteForm = $this->createDeleteForm($svSenialInventarioBodega);

        return $this->render('svsenialinventariobodega/show.html.twig', array(
            'svSenialInventarioBodega' => $svSenialInventarioBodega,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing svSenialInventarioBodega entity.
     *
     * @Route("/{id}/edit", name="svsenialinventariobodega_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SvSenialInventarioBodega $svSenialInventarioBodega)
    {
        $deleteForm = $this->createDeleteForm($svSenialInventarioBodega);
        $editForm = $this->createForm('JHWEB\SeguridadVialBundle\Form\SvSenialInventarioBodegaType', $svSenialInventarioBodega);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('svsenialinventariobodega_edit', array('id' => $svSenialInventarioBodega->getId()));
        }

        return $this->render('svsenialinventariobodega/edit.html.twig', array(
            'svSenialInventarioBodega' => $svSenialInventarioBodega,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a svSenialInventarioBodega entity.
     *
     * @Route("/{id}", name="svsenialinventariobodega_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SvSenialInventarioBodega $svSenialInventarioBodega)
    {
        $form = $this->createDeleteForm($svSenialInventarioBodega);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($svSenialInventarioBodega);
            $em->flush();
        }

        return $this->redirectToRoute('svsenialinventariobodega_index');
    }

    /**
     * Creates a form to delete a svSenialInventarioBodega entity.
     *
     * @param SvSenialInventarioBodega $svSenialInventarioBodega The svSenialInventarioBodega entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvSenialInventarioBodega $svSenialInventarioBodega)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svsenialinventariobodega_delete', array('id' => $svSenialInventarioBodega->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Lists all mpersonalFuncionario entities.
     *
     * @Route("/search/tiposenial", name="svsenialinventariobodega_search_tiposenial")
     * @Method({"GET", "POST"})
     */
    public function searchByTipoSenialAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $seniales = $em->getRepository('JHWEBSeguridadVialBundle:SvSenialInventarioBodega')->findByTipoSenial($params->idTipoSenial);

            if ($seniales) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($seniales)." inventario(s) encontrado(s)",
                    'data'=> $seniales
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Ningún registro no encontrado"
                );
            }
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida",
            );
        }
        return $helpers->json($response);
    }
}
