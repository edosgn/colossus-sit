<?php

namespace JHWEB\FinancieroBundle\Controller;

use JHWEB\FinancieroBundle\Entity\FroFacRetefuente;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Frofacretefuente controller.
 *
 * @Route("frofacretefuente")
 */
class FroFacRetefuenteController extends Controller
{
    /**
     * Lists all froFacRetefuente entities.
     *
     * @Route("/", name="frofacretefuente_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $froFacRetefuentes = $em->getRepository('JHWEBFinancieroBundle:FroFacRetefuente')->findAll();

        return $this->render('frofacretefuente/index.html.twig', array(
            'froFacRetefuentes' => $froFacRetefuentes,
        ));
    }

    /**
     * Creates a new froFacRetefuente entity.
     *
     * @Route("/new", name="frofacretefuente_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $froFacRetefuente = new Frofacretefuente();
        $form = $this->createForm('JHWEB\FinancieroBundle\Form\FroFacRetefuenteType', $froFacRetefuente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($froFacRetefuente);
            $em->flush();

            return $this->redirectToRoute('frofacretefuente_show', array('id' => $froFacRetefuente->getId()));
        }

        return $this->render('frofacretefuente/new.html.twig', array(
            'froFacRetefuente' => $froFacRetefuente,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a froFacRetefuente entity.
     *
     * @Route("/{id}/show", name="frofacretefuente_show")
     * @Method("GET")
     */
    public function showAction(FroFacRetefuente $froFacRetefuente)
    {
        $deleteForm = $this->createDeleteForm($froFacRetefuente);

        return $this->render('frofacretefuente/show.html.twig', array(
            'froFacRetefuente' => $froFacRetefuente,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing froFacRetefuente entity.
     *
     * @Route("/{id}/edit", name="frofacretefuente_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FroFacRetefuente $froFacRetefuente)
    {
        $deleteForm = $this->createDeleteForm($froFacRetefuente);
        $editForm = $this->createForm('JHWEB\FinancieroBundle\Form\FroFacRetefuenteType', $froFacRetefuente);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('frofacretefuente_edit', array('id' => $froFacRetefuente->getId()));
        }

        return $this->render('frofacretefuente/edit.html.twig', array(
            'froFacRetefuente' => $froFacRetefuente,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a froFacRetefuente entity.
     *
     * @Route("/{id}/delete", name="frofacretefuente_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FroFacRetefuente $froFacRetefuente)
    {
        $form = $this->createDeleteForm($froFacRetefuente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($froFacRetefuente);
            $em->flush();
        }

        return $this->redirectToRoute('frofacretefuente_index');
    }

    /**
     * Creates a form to delete a froFacRetefuente entity.
     *
     * @param FroFacRetefuente $froFacRetefuente The froFacRetefuente entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FroFacRetefuente $froFacRetefuente)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('frofacretefuente_delete', array('id' => $froFacRetefuente->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* =================================== */

    /**
     * Busca retenciones por ID de factura.
     *
     * @Route("/search/factura", name="frofactura_search_factura")
     * @Method({"GET", "POST"})
     */
    public function searchByFactura(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $retenciones = $em->getRepository('JHWEBFinancieroBundle:FroFacRetefuente')->findBy(
                array(
                    'factura' => $params->idFactura,
                    'activo' => true,
                )
            );

            if ($retenciones) {
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($retenciones).' registros encontrados.' ,
                    'data' => $retenciones
                );
            }else{
                $response = array(
                    'title' => 'Atención!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => 'La factura no presenta retenciones.' 
                );
            }
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
            );
        } 
        return $helpers->json($response);
    }
}
