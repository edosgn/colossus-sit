<?php

namespace JHWEB\ConfigBundle\Controller;

use JHWEB\ConfigBundle\Entity\CfgPais;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cfgpai controller.
 *
 * @Route("cfgpais")
 */
class CfgPaisController extends Controller
{
    /**
     * Lists all cfgPais entities.
     *
     * @Route("/", name="cfgpais_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cfgPais = $em->getRepository('JHWEBConfigBundle:CfgPais')->findAll();

        return $this->render('cfgpais/index.html.twig', array(
            'cfgPais' => $cfgPais,
        ));
    }

    /**
     * Creates a new cfgPais entity.
     *
     * @Route("/new", name="cfgpais_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $cfgPais = new Cfgpai();
        $form = $this->createForm('JHWEB\ConfigBundle\Form\CfgPaisType', $cfgPais);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cfgPais);
            $em->flush();

            return $this->redirectToRoute('cfgpais_show', array('id' => $cfgPais->getId()));
        }

        return $this->render('cfgpais/new.html.twig', array(
            'cfgPais' => $cfgPais,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a cfgPais entity.
     *
     * @Route("/{id}/show", name="cfgpais_show")
     * @Method("GET")
     */
    public function showAction(CfgPais $cfgPais)
    {
        $deleteForm = $this->createDeleteForm($cfgPais);

        return $this->render('cfgpais/show.html.twig', array(
            'cfgPais' => $cfgPais,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cfgPais entity.
     *
     * @Route("/{id}/edit", name="cfgpais_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CfgPais $cfgPais)
    {
        $deleteForm = $this->createDeleteForm($cfgPais);
        $editForm = $this->createForm('JHWEB\ConfigBundle\Form\CfgPaisType', $cfgPais);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cfgpais_edit', array('id' => $cfgPais->getId()));
        }

        return $this->render('cfgpais/edit.html.twig', array(
            'cfgPais' => $cfgPais,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cfgPais entity.
     *
     * @Route("/{id}/delete", name="cfgpais_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CfgPais $cfgPais)
    {
        $form = $this->createDeleteForm($cfgPais);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cfgPai);
            $em->flush();
        }

        return $this->redirectToRoute('cfgpais_index');
    }

    /**
     * Creates a form to delete a cfgPai entity.
     *
     * @param CfgPais $cfgPai The cfgPai entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgPais $cfgPai)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgpais_delete', array('id' => $cfgPai->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* =================================================== */

    /**
     * Listado de paises para seleccion con busqueda
     *
     * @Route("/select", name="cfgpais_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $paises = $em->getRepository('JHWEBConfigBundle:CfgPais')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($paises as $key => $pais) {
            $response[$key] = array(
                'value' => $pais->getId(),
                'label' => $pais->getNombre(),
            );
        }

        return $helpers->json($response);
    }
}
