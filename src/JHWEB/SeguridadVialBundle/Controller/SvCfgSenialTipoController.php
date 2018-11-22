<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgSenialTipo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgsenialtipo controller.
 *
 * @Route("svcfgsenialtipo")
 */
class SvCfgSenialTipoController extends Controller
{
    /**
     * Lists all svCfgSenialTipo entities.
     *
     * @Route("/", name="svcfgsenialtipo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $tipos = $em->getRepository('JHWEBSeguridadVialBundle:CfgSvSenialTipo')->findBy(
            array('activo' => true)
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
     * Creates a new svCfgSenialTipo entity.
     *
     * @Route("/new", name="svcfgsenialtipo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("json",null);
            $params = json_decode($json);
           
            $tipo = new SvCfgSenialTipo();

            $tipo->setNombre($params->nombre);
            $tipo->setActivo(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($tipo);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con exito",
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Finds and displays a svCfgSenialTipo entity.
     *
     * @Route("/{id}", name="svcfgsenialtipo_show")
     * @Method("GET")
     */
    public function showAction(SvCfgSenialTipo $svCfgSenialTipo)
    {
        $deleteForm = $this->createDeleteForm($svCfgSenialTipo);

        return $this->render('svcfgsenialtipo/show.html.twig', array(
            'svCfgSenialTipo' => $svCfgSenialTipo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing svCfgSenialTipo entity.
     *
     * @Route("/{id}/edit", name="svcfgsenialtipo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SvCfgSenialTipo $svCfgSenialTipo)
    {
        $deleteForm = $this->createDeleteForm($svCfgSenialTipo);
        $editForm = $this->createForm('JHWEB\SeguridadVialBundle\Form\SvCfgSenialTipoType', $svCfgSenialTipo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('svcfgsenialtipo_edit', array('id' => $svCfgSenialTipo->getId()));
        }

        return $this->render('svcfgsenialtipo/edit.html.twig', array(
            'svCfgSenialTipo' => $svCfgSenialTipo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a svCfgSenialTipo entity.
     *
     * @Route("/{id}", name="svcfgsenialtipo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SvCfgSenialTipo $svCfgSenialTipo)
    {
        $form = $this->createDeleteForm($svCfgSenialTipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($svCfgSenialTipo);
            $em->flush();
        }

        return $this->redirectToRoute('svcfgsenialtipo_index');
    }

    /**
     * Creates a form to delete a svCfgSenialTipo entity.
     *
     * @param SvCfgSenialTipo $svCfgSenialTipo The svCfgSenialTipo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgSenialTipo $svCfgSenialTipo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svcfgsenialtipo_delete', array('id' => $svCfgSenialTipo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
