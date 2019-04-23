<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvIpatImpresoBodega;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Svipatimpresobodega controller.
 *
 * @Route("svipatimpresobodega")
 */
class SvIpatImpresoBodegaController extends Controller
{
    /**
     * Lists all svIpatImpresoBodega entities.
     *
     * @Route("/", name="svipatimpresobodega_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $bodegas = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatImpresoBodega')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($bodegas) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($bodegas) . " registros encontrados",
                'data' => $bodegas,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new svIpatImpresoBodega entity.
     *
     * @Route("/new", name="svipatimpresobodega_new")
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
            
            $em = $this->getDoctrine()->getManager();

            $bodega = new SvIpatImpresoBodega();

            $bodega->setFecha(
                new \Datetime($params->fecha)
            );
            
            $bodega->setCantidadDisponible($params->cantidad);
            $bodega->setCantidadRecibida($params->cantidad);
            $bodega->setEstado('DISPONIBLE');
            $bodega->setActivo(true);

            $em->persist($bodega);
            $em->flush();
        
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Registro creado con exito.', 
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
     * Finds and displays a svIpatImpresoBodega entity.
     *
     * @Route("/{id}/show", name="svipatimpresobodega_show")
     * @Method("GET")
     */
    public function showAction(SvIpatImpresoBodega $svIpatImpresoBodega)
    {
        $deleteForm = $this->createDeleteForm($svIpatImpresoBodega);

        return $this->render('svipatimpresobodega/show.html.twig', array(
            'svIpatImpresoBodega' => $svIpatImpresoBodega,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing svIpatImpresoBodega entity.
     *
     * @Route("/{id}/edit", name="svipatimpresobodega_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SvIpatImpresoBodega $svIpatImpresoBodega)
    {
        $deleteForm = $this->createDeleteForm($svIpatImpresoBodega);
        $editForm = $this->createForm('JHWEB\SeguridadVialBundle\Form\SvIpatImpresoBodegaType', $svIpatImpresoBodega);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('svipatimpresobodega_edit', array('id' => $svIpatImpresoBodega->getId()));
        }

        return $this->render('svipatimpresobodega/edit.html.twig', array(
            'svIpatImpresoBodega' => $svIpatImpresoBodega,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a svIpatImpresoBodega entity.
     *
     * @Route("/{id}/delete", name="svipatimpresobodega_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SvIpatImpresoBodega $svIpatImpresoBodega)
    {
        $form = $this->createDeleteForm($svIpatImpresoBodega);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($svIpatImpresoBodega);
            $em->flush();
        }

        return $this->redirectToRoute('svipatimpresobodega_index');
    }

    /**
     * Creates a form to delete a svIpatImpresoBodega entity.
     *
     * @param SvIpatImpresoBodega $svIpatImpresoBodega The svIpatImpresoBodega entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvIpatImpresoBodega $svIpatImpresoBodega)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svipatimpresobodega_delete', array('id' => $svIpatImpresoBodega->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* =============================================== */
    /**
     * Busca todos los regitros de bodega por fecha.
     *
     * @Route("/search/fecha", name="svipatimpresobodega_search_fecha")
     * @Method({"GET", "POST"})
     */
    public function searchByFechaAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $bodegas = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatImpresoBodega')->findBy(
                array(
                    'fecha' => new \Datetime($params->fecha)
                )
            );

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($bodegas).' registros encontrados con exito.',
                'data' => $bodegas,
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida.',
            );
        }

        return $helpers->json($response);
    }
}
