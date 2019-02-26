<?php

namespace JHWEB\ConfigBundle\Controller;

use JHWEB\ConfigBundle\Entity\CfgDepartamento;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cfgdepartamento controller.
 *
 * @Route("cfgdepartamento")
 */
class CfgDepartamentoController extends Controller
{
    /**
     * Lists all cfgDepartamento entities.
     *
     * @Route("/", name="cfgdepartamento_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cfgDepartamentos = $em->getRepository('JHWEBConfigBundle:CfgDepartamento')->findAll();

        return $this->render('cfgdepartamento/index.html.twig', array(
            'cfgDepartamentos' => $cfgDepartamentos,
        ));
    }

    /**
     * Creates a new cfgDepartamento entity.
     *
     * @Route("/new", name="cfgdepartamento_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $cfgDepartamento = new Cfgdepartamento();
        $form = $this->createForm('JHWEB\ConfigBundle\Form\CfgDepartamentoType', $cfgDepartamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cfgDepartamento);
            $em->flush();

            return $this->redirectToRoute('cfgdepartamento_show', array('id' => $cfgDepartamento->getId()));
        }

        return $this->render('cfgdepartamento/new.html.twig', array(
            'cfgDepartamento' => $cfgDepartamento,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a cfgDepartamento entity.
     *
     * @Route("/{id}/show", name="cfgdepartamento_show")
     * @Method("GET")
     */
    public function showAction(CfgDepartamento $cfgDepartamento)
    {
        $deleteForm = $this->createDeleteForm($cfgDepartamento);

        return $this->render('cfgdepartamento/show.html.twig', array(
            'cfgDepartamento' => $cfgDepartamento,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cfgDepartamento entity.
     *
     * @Route("/{id}/edit", name="cfgdepartamento_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CfgDepartamento $cfgDepartamento)
    {
        $deleteForm = $this->createDeleteForm($cfgDepartamento);
        $editForm = $this->createForm('JHWEB\ConfigBundle\Form\CfgDepartamentoType', $cfgDepartamento);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cfgdepartamento_edit', array('id' => $cfgDepartamento->getId()));
        }

        return $this->render('cfgdepartamento/edit.html.twig', array(
            'cfgDepartamento' => $cfgDepartamento,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cfgDepartamento entity.
     *
     * @Route("/{id}/delete", name="cfgdepartamento_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CfgDepartamento $cfgDepartamento)
    {
        $form = $this->createDeleteForm($cfgDepartamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cfgDepartamento);
            $em->flush();
        }

        return $this->redirectToRoute('cfgdepartamento_index');
    }

    /**
     * Creates a form to delete a cfgDepartamento entity.
     *
     * @param CfgDepartamento $cfgDepartamento The cfgDepartamento entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgDepartamento $cfgDepartamento)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgdepartamento_delete', array('id' => $cfgDepartamento->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* =================================================== */

    /**
     * Listado de departamentos para seleccion con busqueda
     *
     * @Route("/select", name="cfgdepartamento_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $departamentos = $em->getRepository('JHWEBConfigBundle:CfgPais')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($departamentos as $key => $departamento) {
            $response[$key] = array(
                'value' => $departamento->getId(),
                'label' => $departamento->getCodigoDane()."_".$departamento->getNombre(),
            );
        }

        return $helpers->json($response);
    }

    /**
     * Listado de departamentos por pais para seleccion con busqueda
     *
     * @Route("/select/pais", name="cfgdepartamento_select_pais")
     * @Method({"GET", "POST"})
     */
    public function selectByPaisAction($id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $departamentos = $em->getRepository('JHWEBConfigBundle:CfgDepartamento')->findBy(
                array(
                    'pais' => $params->idPais,
                    'activo' => true
                )
            );

            $response = null;

            foreach ($departamentos as $key => $departamento) {
                $response[$key] = array(
                    'value' => $departamento->getId(),
                    'label' => $departamento->getCodigoDane()."_".$departamento->getNombre(),
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
