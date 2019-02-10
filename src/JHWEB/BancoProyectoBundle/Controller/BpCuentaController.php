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
        $em = $this->getDoctrine()->getManager();

        $bpCuentas = $em->getRepository('JHWEBBancoProyectoBundle:BpCuenta')->findAll();

        return $this->render('bpcuenta/index.html.twig', array(
            'bpCuentas' => $bpCuentas,
        ));
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
     * @Route("/{id}", name="bpcuenta_show")
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
     * @Route("/{id}", name="bpcuenta_delete")
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
}
