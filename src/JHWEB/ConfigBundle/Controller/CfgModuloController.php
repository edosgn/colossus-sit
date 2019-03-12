<?php

namespace JHWEB\ConfigBundle\Controller;

use JHWEB\ConfigBundle\Entity\CfgModulo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cfgmodulo controller.
 *
 * @Route("cfgmodulo")
 */
class CfgModuloController extends Controller
{
    /**
     * Lists all cfgModulo entities.
     *
     * @Route("/", name="cfgmodulo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cfgModulos = $em->getRepository('JHWEBConfigBundle:CfgModulo')->findAll();

        return $this->render('cfgmodulo/index.html.twig', array(
            'cfgModulos' => $cfgModulos,
        ));
    }

    /**
     * Creates a new cfgModulo entity.
     *
     * @Route("/new", name="cfgmodulo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $cfgModulo = new Cfgmodulo();
        $form = $this->createForm('JHWEB\ConfigBundle\Form\CfgModuloType', $cfgModulo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cfgModulo);
            $em->flush();

            return $this->redirectToRoute('cfgmodulo_show', array('id' => $cfgModulo->getId()));
        }

        return $this->render('cfgmodulo/new.html.twig', array(
            'cfgModulo' => $cfgModulo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a cfgModulo entity.
     *
     * @Route("/show", name="cfgmodulo_show")
     * @Method("POST")
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $modulo = $em->getRepository('JHWEBConfigBundle:CfgModulo')->find(
                $params->id
            );

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Registro encontrado con exito.',
                'data' => $modulo
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida.', 
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing cfgModulo entity.
     *
     * @Route("/{id}/edit", name="cfgmodulo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CfgModulo $cfgModulo)
    {
        $deleteForm = $this->createDeleteForm($cfgModulo);
        $editForm = $this->createForm('JHWEB\ConfigBundle\Form\CfgModuloType', $cfgModulo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cfgmodulo_edit', array('id' => $cfgModulo->getId()));
        }

        return $this->render('cfgmodulo/edit.html.twig', array(
            'cfgModulo' => $cfgModulo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cfgModulo entity.
     *
     * @Route("/{id}/delete", name="cfgmodulo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CfgModulo $cfgModulo)
    {
        $form = $this->createDeleteForm($cfgModulo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cfgModulo);
            $em->flush();
        }

        return $this->redirectToRoute('cfgmodulo_index');
    }

    /**
     * Creates a form to delete a cfgModulo entity.
     *
     * @param CfgModulo $cfgModulo The cfgModulo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgModulo $cfgModulo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgmodulo_delete', array('id' => $cfgModulo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* =================================================== */

    /**
     * Listado de modulos para seleccion con filtro
     *
     * @Route("/select", name="cfgmodulo_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $modulos = $em->getRepository('JHWEBConfigBundle:CfgModulo')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($modulos as $key => $modulo) {
            $response[$key] = array(
                'value' => $modulo->getId(),
                'label' => $modulo->getNombre(),
            );
        }

        return $helpers->json($response);
    }
}
