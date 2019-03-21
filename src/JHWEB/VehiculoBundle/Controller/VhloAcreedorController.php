<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloAcreedor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Vhloacreedor controller.
 *
 * @Route("vhloacreedor")
 */
class VhloAcreedorController extends Controller
{
    /**
     * Lists all vhloAcreedor entities.
     *
     * @Route("/", name="vhloacreedor_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $vhloAcreedors = $em->getRepository('JHWEBVehiculoBundle:VhloAcreedor')->findAll();

        return $this->render('vhloacreedor/index.html.twig', array(
            'vhloAcreedors' => $vhloAcreedors,
        ));
    }

    /**
     * Creates a new vhloAcreedor entity.
     *
     * @Route("/new", name="vhloacreedor_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $vhloAcreedor = new Vhloacreedor();
        $form = $this->createForm('JHWEB\VehiculoBundle\Form\VhloAcreedorType', $vhloAcreedor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($vhloAcreedor);
            $em->flush();

            return $this->redirectToRoute('vhloacreedor_show', array('id' => $vhloAcreedor->getId()));
        }

        return $this->render('vhloacreedor/new.html.twig', array(
            'vhloAcreedor' => $vhloAcreedor,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a vhloAcreedor entity.
     *
     * @Route("/{id}", name="vhloacreedor_show")
     * @Method("GET")
     */
    public function showAction(VhloAcreedor $vhloAcreedor)
    {
        $deleteForm = $this->createDeleteForm($vhloAcreedor);

        return $this->render('vhloacreedor/show.html.twig', array(
            'vhloAcreedor' => $vhloAcreedor,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vhloAcreedor entity.
     *
     * @Route("/{id}/edit", name="vhloacreedor_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, VhloAcreedor $vhloAcreedor)
    {
        $deleteForm = $this->createDeleteForm($vhloAcreedor);
        $editForm = $this->createForm('JHWEB\VehiculoBundle\Form\VhloAcreedorType', $vhloAcreedor);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vhloacreedor_edit', array('id' => $vhloAcreedor->getId()));
        }

        return $this->render('vhloacreedor/edit.html.twig', array(
            'vhloAcreedor' => $vhloAcreedor,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a vhloAcreedor entity.
     *
     * @Route("/{id}", name="vhloacreedor_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, VhloAcreedor $vhloAcreedor)
    {
        $form = $this->createDeleteForm($vhloAcreedor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vhloAcreedor);
            $em->flush();
        }

        return $this->redirectToRoute('vhloacreedor_index');
    }

    /**
     * Creates a form to delete a vhloAcreedor entity.
     *
     * @param VhloAcreedor $vhloAcreedor The vhloAcreedor entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloAcreedor $vhloAcreedor)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhloacreedor_delete', array('id' => $vhloAcreedor->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ============================================= */
    /**
     * Busca cuidadano o empresa por Identificacion.
     *
     * @Route("/search/ciudadano/empresa", name="vhloacreedor_search_ciudadano_empresa")
     * @Method({"GET", "POST"})
     */
    public function searchByCiudadanoOrEmpresaAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            if ($params->tipo == 'CIUDADANO') {
                $acreedor = $em->getRepository('JHWEBVehiculoBundle:VhloAcreedor')->findOneBy(
                    array(
                        'ciudadano' => $params->idCiudadano,
                        'activo' => true,
                    )
                );
            } elseif($params->tipo == 'EMPRESA') {
                $acreedor = $em->getRepository('JHWEBVehiculoBundle:VhloAcreedor')->findOneBy(
                    array(
                        'empresa' => $params->idEmpresa,
                        'activo' => true,
                    )
                );
            }

            if ($acreedor) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Registro encontrado.', 
                    'data'=> $acreedor
                );
            }else{
                 $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'El ciudadano o empresa no es acreedor del vehiculo.', 
                );
            }
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida.', 
            );
        }

        return $helpers->json($response);
    }
}
