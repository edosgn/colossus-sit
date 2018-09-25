<?php

namespace JHWEB\ConfigBundle\Controller;

use JHWEB\ConfigBundle\Entity\CfgSvSenialDestino;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cfgsvsenialdestino controller.
 *
 * @Route("cfgsvsenialdestino")
 */
class CfgSvSenialDestinoController extends Controller
{
    /**
     * Lists all cfgSvSenialDestino entities.
     *
     * @Route("/", name="cfgsvsenialdestino_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cfgSvSenialDestinos = $em->getRepository('JHWEBConfigBundle:CfgSvSenialDestino')->findAll();

        return $this->render('cfgsvsenialdestino/index.html.twig', array(
            'cfgSvSenialDestinos' => $cfgSvSenialDestinos,
        ));
    }

    /**
     * Creates a new cfgSvSenialDestino entity.
     *
     * @Route("/new", name="cfgsvsenialdestino_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $cfgSvSenialDestino = new Cfgsvsenialdestino();
        $form = $this->createForm('JHWEB\ConfigBundle\Form\CfgSvSenialDestinoType', $cfgSvSenialDestino);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cfgSvSenialDestino);
            $em->flush();

            return $this->redirectToRoute('cfgsvsenialdestino_show', array('id' => $cfgSvSenialDestino->getId()));
        }

        return $this->render('cfgsvsenialdestino/new.html.twig', array(
            'cfgSvSenialDestino' => $cfgSvSenialDestino,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a cfgSvSenialDestino entity.
     *
     * @Route("/{id}/show", name="cfgsvsenialdestino_show")
     * @Method("GET")
     */
    public function showAction(CfgSvSenialDestino $cfgSvSenialDestino)
    {
        $deleteForm = $this->createDeleteForm($cfgSvSenialDestino);

        return $this->render('cfgsvsenialdestino/show.html.twig', array(
            'cfgSvSenialDestino' => $cfgSvSenialDestino,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cfgSvSenialDestino entity.
     *
     * @Route("/{id}/edit", name="cfgsvsenialdestino_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CfgSvSenialDestino $cfgSvSenialDestino)
    {
        $deleteForm = $this->createDeleteForm($cfgSvSenialDestino);
        $editForm = $this->createForm('JHWEB\ConfigBundle\Form\CfgSvSenialDestinoType', $cfgSvSenialDestino);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cfgsvsenialdestino_edit', array('id' => $cfgSvSenialDestino->getId()));
        }

        return $this->render('cfgsvsenialdestino/edit.html.twig', array(
            'cfgSvSenialDestino' => $cfgSvSenialDestino,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cfgSvSenialDestino entity.
     *
     * @Route("/{id}/delete", name="cfgsvsenialdestino_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CfgSvSenialDestino $cfgSvSenialDestino)
    {
        $form = $this->createDeleteForm($cfgSvSenialDestino);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cfgSvSenialDestino);
            $em->flush();
        }

        return $this->redirectToRoute('cfgsvsenialdestino_index');
    }

    /**
     * Creates a form to delete a cfgSvSenialDestino entity.
     *
     * @param CfgSvSenialDestino $cfgSvSenialDestino The cfgSvSenialDestino entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgSvSenialDestino $cfgSvSenialDestino)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgsvsenialdestino_delete', array('id' => $cfgSvSenialDestino->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="cfgsvsenialdestino_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $destinos = $em->getRepository('JHWEBConfigBundle:CfgSvSenialDestino')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($destinos as $key => $destino) {
            $response[$key] = array(
                'value' => $destino->getId(),
                'label' => $destino->getNombre()
            );
        }
        return $helpers->json($response);
    }
}
