<?php

namespace JHWEB\ConfigBundle\Controller;

use JHWEB\ConfigBundle\Entity\CfgOrganismoTransito;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cfgorganismotransito controller.
 *
 * @Route("cfgorganismotransito")
 */
class CfgOrganismoTransitoController extends Controller
{
    /**
     * Lists all cfgOrganismoTransito entities.
     *
     * @Route("/", name="cfgorganismotransito_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $organismos = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($organismos) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($organismos)." registros encontrados", 
                'data'=> $organismos,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new cfgOrganismoTransito entity.
     *
     * @Route("/new", name="cfgorganismotransito_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $cfgOrganismoTransito = new Cfgorganismotransito();
        $form = $this->createForm('JHWEB\ConfigBundle\Form\CfgOrganismoTransitoType', $cfgOrganismoTransito);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cfgOrganismoTransito);
            $em->flush();

            return $this->redirectToRoute('cfgorganismotransito_show', array('id' => $cfgOrganismoTransito->getId()));
        }

        return $this->render('cfgorganismotransito/new.html.twig', array(
            'cfgOrganismoTransito' => $cfgOrganismoTransito,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a cfgOrganismoTransito entity.
     *
     * @Route("/show", name="cfgorganismotransito_show")
     * @Method({"GET", "POST" })
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $organismoTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find(
                $params->id
            );

            if ($organismoTransito) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado.", 
                    'data'=> $organismoTransito
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos",
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

    /**
     * Displays a form to edit an existing cfgOrganismoTransito entity.
     *
     * @Route("/{id}/edit", name="cfgorganismotransito_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CfgOrganismoTransito $cfgOrganismoTransito)
    {
        $deleteForm = $this->createDeleteForm($cfgOrganismoTransito);
        $editForm = $this->createForm('JHWEB\ConfigBundle\Form\CfgOrganismoTransitoType', $cfgOrganismoTransito);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cfgorganismotransito_edit', array('id' => $cfgOrganismoTransito->getId()));
        }

        return $this->render('cfgorganismotransito/edit.html.twig', array(
            'cfgOrganismoTransito' => $cfgOrganismoTransito,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cfgOrganismoTransito entity.
     *
     * @Route("/{id}/delete", name="cfgorganismotransito_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CfgOrganismoTransito $cfgOrganismoTransito)
    {
        $form = $this->createDeleteForm($cfgOrganismoTransito);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cfgOrganismoTransito);
            $em->flush();
        }

        return $this->redirectToRoute('cfgorganismotransito_index');
    }

    /**
     * Creates a form to delete a cfgOrganismoTransito entity.
     *
     * @param CfgOrganismoTransito $cfgOrganismoTransito The cfgOrganismoTransito entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgOrganismoTransito $cfgOrganismoTransito)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgorganismotransito_delete', array('id' => $cfgOrganismoTransito->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* =================================================== */

    /**
     * datos para select 2
     *
     * @Route("/select", name="cfgorganismotransito_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $organismos = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($organismos as $key => $organismo) {
            $consecutive = substr($organismo->getCodigoDivipo(), 0, 12);
            $response[$key] = array(
                'value' => $organismo->getId(),
                'label' => $organismo->getNombre().' ('.$organismo->getDepartamento().')',
                'consecutive' => $consecutive
            );
        }

        return $helpers->json($response);
    }

    /**
     * Lista con organismos de transito que estan registrados como sede operativa 
     *
     * @Route("/select/sedes", name="cfgorganismotransito_select_sedes")
     * @Method({"GET", "POST"})
     */
    public function selectSedesAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $organismos = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->findBy(
            array(
                'sede' => true,
                'activo' => true
            )
        );

        $response = null;

        foreach ($organismos as $key => $organismo) {
            $response[$key] = array(
                'value' => $organismo->getId(),
                'label' => $organismo->getNombre().' ('.$organismo->getDepartamento().')',
            );
        }

        return $helpers->json($response);
    }
}
