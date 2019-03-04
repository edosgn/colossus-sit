<?php

namespace JHWEB\ConfigBundle\Controller;

use JHWEB\ConfigBundle\Entity\CfgMunicipio;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cfgmunicipio controller.
 *
 * @Route("cfgmunicipio")
 */
class CfgMunicipioController extends Controller
{
    /**
     * Lists all cfgMunicipio entities.
     *
     * @Route("/", name="cfgmunicipio_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cfgMunicipios = $em->getRepository('JHWEBConfigBundle:CfgMunicipio')->findAll();

        return $this->render('cfgmunicipio/index.html.twig', array(
            'cfgMunicipios' => $cfgMunicipios,
        ));
    }

    /**
     * Creates a new cfgMunicipio entity.
     *
     * @Route("/new", name="cfgmunicipio_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $cfgMunicipio = new Cfgmunicipio();
        $form = $this->createForm('JHWEB\ConfigBundle\Form\CfgMunicipioType', $cfgMunicipio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cfgMunicipio);
            $em->flush();

            return $this->redirectToRoute('cfgmunicipio_show', array('id' => $cfgMunicipio->getId()));
        }

        return $this->render('cfgmunicipio/new.html.twig', array(
            'cfgMunicipio' => $cfgMunicipio,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a cfgMunicipio entity.
     *
     * @Route("/{id}/show", name="cfgmunicipio_show")
     * @Method("GET")
     */
    public function showAction(CfgMunicipio $cfgMunicipio)
    {
        $deleteForm = $this->createDeleteForm($cfgMunicipio);

        return $this->render('cfgmunicipio/show.html.twig', array(
            'cfgMunicipio' => $cfgMunicipio,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cfgMunicipio entity.
     *
     * @Route("/{id}/edit", name="cfgmunicipio_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CfgMunicipio $cfgMunicipio)
    {
        $deleteForm = $this->createDeleteForm($cfgMunicipio);
        $editForm = $this->createForm('JHWEB\ConfigBundle\Form\CfgMunicipioType', $cfgMunicipio);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cfgmunicipio_edit', array('id' => $cfgMunicipio->getId()));
        }

        return $this->render('cfgmunicipio/edit.html.twig', array(
            'cfgMunicipio' => $cfgMunicipio,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cfgMunicipio entity.
     *
     * @Route("/{id}/delete", name="cfgmunicipio_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CfgMunicipio $cfgMunicipio)
    {
        $form = $this->createDeleteForm($cfgMunicipio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cfgMunicipio);
            $em->flush();
        }

        return $this->redirectToRoute('cfgmunicipio_index');
    }

    /**
     * Creates a form to delete a cfgMunicipio entity.
     *
     * @param CfgMunicipio $cfgMunicipio The cfgMunicipio entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgMunicipio $cfgMunicipio)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgmunicipio_delete', array('id' => $cfgMunicipio->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* =================================================== */

    /**
     * Listado de municipios para seleccion con busqueda
     *
     * @Route("/select", name="cfgmunicipio_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $municipios = $em->getRepository('JHWEBConfigBundle:CfgMunicipio')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($municipios as $key => $municipio) {
            $response[$key] = array(
                'value' => $municipio->getId(),
                'label' => $municipio->getCodigoDane()."_".$municipio->getNombre()."-".$municipio->getDepartamento()->getNombre(),
            );
        }

        return $helpers->json($response);
    }

    /**
     * Listado de municipios por departamento para seleccion con busqueda
     *
     * @Route("/select/departamento", name="cfgmunicipio_select_departamento")
     * @Method({"GET", "POST"})
     */
    public function selectByDepartamentoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $municipios = $em->getRepository('JHWEBConfigBundle:CfgMunicipio')->findBy(
                array(
                    'departamento' => $params->idDepartamento,
                    'activo' => true
                )
            );

            $response = null;

            foreach ($municipios as $key => $municipio) {
                $response[$key] = array(
                    'value' => $municipio->getId(),
                    'label' => $municipio->getCodigoDane()."_".$municipio->getNombre(),
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
