<?php

namespace JHWEB\PersonalBundle\Controller;

use JHWEB\PersonalBundle\Entity\PnalCfgCdoBodega;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Pnalcfgcdobodega controller.
 *
 * @Route("pnalcfgcdobodega")
 */
class PnalCfgCdoBodegaController extends Controller
{
    /**
     * Lists all pnalCfgCdoBodega entities.
     *
     * @Route("/", name="pnalcfgcdobodega_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $bodegas = $em->getRepository('JHWEBPersonalBundle:PnalCfgCdoBodega')->findBy(
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
     * Creates a new pnalCfgCdoBodega entity.
     *
     * @Route("/new", name="pnalcfgcdobodega_new")
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

            $bodega = new PnalCfgCdoBodega();

            $bodega->setFecha(
                new \Datetime($params->fecha)
            );
            
            $bodega->setCantidadRecibida($params->cantidad);
            $bodega->setCantidadDisponible($params->cantidad);
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
     * Finds and displays a pnalCfgCdoBodega entity.
     *
     * @Route("/{id}", name="pnalcfgcdobodega_show")
     * @Method("GET")
     */
    public function showAction(PnalCfgCdoBodega $pnalCfgCdoBodega)
    {
        $deleteForm = $this->createDeleteForm($pnalCfgCdoBodega);

        return $this->render('pnalcfgcdobodega/show.html.twig', array(
            'pnalCfgCdoBodega' => $pnalCfgCdoBodega,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing pnalCfgCdoBodega entity.
     *
     * @Route("/{id}/edit", name="pnalcfgcdobodega_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, PnalCfgCdoBodega $pnalCfgCdoBodega)
    {
        $deleteForm = $this->createDeleteForm($pnalCfgCdoBodega);
        $editForm = $this->createForm('JHWEB\PersonalBundle\Form\PnalCfgCdoBodegaType', $pnalCfgCdoBodega);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pnalcfgcdobodega_edit', array('id' => $pnalCfgCdoBodega->getId()));
        }

        return $this->render('pnalcfgcdobodega/edit.html.twig', array(
            'pnalCfgCdoBodega' => $pnalCfgCdoBodega,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a pnalCfgCdoBodega entity.
     *
     * @Route("/{id}", name="pnalcfgcdobodega_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, PnalCfgCdoBodega $pnalCfgCdoBodega)
    {
        $form = $this->createDeleteForm($pnalCfgCdoBodega);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pnalCfgCdoBodega);
            $em->flush();
        }

        return $this->redirectToRoute('pnalcfgcdobodega_index');
    }

    /**
     * Creates a form to delete a pnalCfgCdoBodega entity.
     *
     * @param PnalCfgCdoBodega $pnalCfgCdoBodega The pnalCfgCdoBodega entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PnalCfgCdoBodega $pnalCfgCdoBodega)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pnalcfgcdobodega_delete', array('id' => $pnalCfgCdoBodega->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
