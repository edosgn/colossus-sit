<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgSenialColor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgsenialcolor controller.
 *
 * @Route("svcfgsenialcolor")
 */
class SvCfgSenialColorController extends Controller
{
    /**
     * Lists all svCfgSenialColor entities.
     *
     * @Route("/", name="svcfgsenialcolor_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $colores = $em->getRepository('JHWEBSeguridadVialBundle:CfgSvSenialColor')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($colores) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($colores)." registros encontrados", 
                'data'=> $colores,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new svCfgSenialColor entity.
     *
     * @Route("/new", name="svcfgsenialcolor_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);
           
            $color = new SvCfgSenialColor();

            $color->setNombre($params->nombre);
            $color->setActivo(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($color);
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
     * Finds and displays a svCfgSenialColor entity.
     *
     * @Route("/{id}", name="svcfgsenialcolor_show")
     * @Method("GET")
     */
    public function showAction(SvCfgSenialColor $svCfgSenialColor)
    {
        $deleteForm = $this->createDeleteForm($svCfgSenialColor);

        return $this->render('svcfgsenialcolor/show.html.twig', array(
            'svCfgSenialColor' => $svCfgSenialColor,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing svCfgSenialColor entity.
     *
     * @Route("/{id}/edit", name="svcfgsenialcolor_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SvCfgSenialColor $svCfgSenialColor)
    {
        $deleteForm = $this->createDeleteForm($svCfgSenialColor);
        $editForm = $this->createForm('JHWEB\SeguridadVialBundle\Form\SvCfgSenialColorType', $svCfgSenialColor);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('svcfgsenialcolor_edit', array('id' => $svCfgSenialColor->getId()));
        }

        return $this->render('svcfgsenialcolor/edit.html.twig', array(
            'svCfgSenialColor' => $svCfgSenialColor,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a svCfgSenialColor entity.
     *
     * @Route("/{id}", name="svcfgsenialcolor_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SvCfgSenialColor $svCfgSenialColor)
    {
        $form = $this->createDeleteForm($svCfgSenialColor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($svCfgSenialColor);
            $em->flush();
        }

        return $this->redirectToRoute('svcfgsenialcolor_index');
    }

    /**
     * Creates a form to delete a svCfgSenialColor entity.
     *
     * @param SvCfgSenialColor $svCfgSenialColor The svCfgSenialColor entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgSenialColor $svCfgSenialColor)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svcfgsenialcolor_delete', array('id' => $svCfgSenialColor->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}