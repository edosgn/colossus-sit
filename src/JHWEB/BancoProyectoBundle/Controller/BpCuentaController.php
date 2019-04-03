<?php

namespace JHWEB\BancoProyectoBundle\Controller;

use JHWEB\BancoProyectoBundle\Entity\BpCuenta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Bpcuentum controller.
 *
 * @Route("bpcuenta")
 */
class BpCuentaController extends Controller
{
    /**
     * Lists all bpCuentum entities.
     *
     * @Route("/", name="bpcuenta_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $cuentas = $em->getRepository('JHWEBBancoProyectoBundle:BpCuenta')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($cuentas) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($cuentas)." registros encontrados", 
                'data'=> $cuentas,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new bpCuentum entity.
     *
     * @Route("/new", name="bpcuenta_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $bpCuentum = new Bpcuentum();
        $form = $this->createForm('JHWEB\BancoProyectoBundle\Form\BpCuentaType', $bpCuentum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($bpCuentum);
            $em->flush();

            return $this->redirectToRoute('bpcuenta_show', array('id' => $bpCuentum->getId()));
        }

        return $this->render('bpcuenta/new.html.twig', array(
            'bpCuentum' => $bpCuentum,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a bpCuentum entity.
     *
     * @Route("/{id}/show", name="bpcuenta_show")
     * @Method("GET")
     */
    public function showAction(BpCuenta $bpCuentum)
    {
        $deleteForm = $this->createDeleteForm($bpCuentum);

        return $this->render('bpcuenta/show.html.twig', array(
            'bpCuentum' => $bpCuentum,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing bpCuentum entity.
     *
     * @Route("/{id}/edit", name="bpcuenta_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, BpCuenta $bpCuentum)
    {
        $deleteForm = $this->createDeleteForm($bpCuentum);
        $editForm = $this->createForm('JHWEB\BancoProyectoBundle\Form\BpCuentaType', $bpCuentum);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('bpcuenta_edit', array('id' => $bpCuentum->getId()));
        }

        return $this->render('bpcuenta/edit.html.twig', array(
            'bpCuentum' => $bpCuentum,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a bpCuentum entity.
     *
     * @Route("/{id}/delete", name="bpcuenta_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, BpCuenta $bpCuentum)
    {
        $form = $this->createDeleteForm($bpCuentum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($bpCuentum);
            $em->flush();
        }

        return $this->redirectToRoute('bpcuenta_index');
    }

    /**
     * Creates a form to delete a bpCuentum entity.
     *
     * @param BpCuenta $bpCuentum The bpCuentum entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BpCuenta $bpCuentum)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bpcuenta_delete', array('id' => $bpCuentum->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ====================================================== */

    /**
     * Busca las actividades asociadas a una cuenta.
     *
     * @Route("/search/actividades", name="bpProyecto_search_activiades")
     * @Method({"GET", "POST"})
     */
    public function searchActividadesAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $actividades = $em->getRepository('JHWEBBancoProyectoBundle:BpActividad')->findBy(
                array(
                    'cuenta' => $params->idCuenta,
                    'activo' => true
                )
            );

            if ($actividades) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($actividades)." registros encontrados.",
                    'data'=> $actividades,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Ninguna actividad registrada aún.",
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
