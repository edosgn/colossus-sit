<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgSenialProveedor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgsenialproveedor controller.
 *
 * @Route("svcfgsenialproveedor")
 */
class SvCfgSenialProveedorController extends Controller
{
    /**
     * Lists all svCfgSenialProveedor entities.
     *
     * @Route("/", name="svcfgsenialproveedor_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $proveedores = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenialProveedor')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($proveedores) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($proveedores)." registros encontrados", 
                'data'=> $proveedores,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new svCfgSenialProveedor entity.
     *
     * @Route("/new", name="svcfgsenialproveedor_new")
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
           
            $proveedor = new SvCfgSenialProveedor();

            $proveedor->setNombre(strtoupper($params->nombre));
            $proveedor->setNit($params->nit);
            $proveedor->setActivo(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($proveedor);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con exito",
            );
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
     * Finds and displays a svCfgSenialProveedor entity.
     *
     * @Route("/show", name="svcfgsenialproveedor_show")
     * @Method("GET")
     */
    public function showAction(Request $request)
    {
        $deleteForm = $this->createDeleteForm($svCfgSenialProveedor);

        return $this->render('svcfgsenialproveedor/show.html.twig', array(
            'svCfgSenialProveedor' => $svCfgSenialProveedor,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing svCfgSenialProveedor entity.
     *
     * @Route("/edit", name="svcfgsenialproveedor_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            $proveedor = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenialProveedor')->find($params->id);

            if ($proveedor) {
                $proveedor->setNombre(strtoupper($params->nombre));
                $proveedor->setNit($params->nit);

                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $proveedor,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos",
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida para editar",
            );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a svCfgSenialProveedor entity.
     *
     * @Route("/{id}/delete", name="svcfgsenialproveedor_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SvCfgSenialProveedor $svCfgSenialProveedor)
    {
        $form = $this->createDeleteForm($svCfgSenialProveedor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($svCfgSenialProveedor);
            $em->flush();
        }

        return $this->redirectToRoute('svcfgsenialproveedor_index');
    }

    /**
     * Creates a form to delete a svCfgSenialProveedor entity.
     *
     * @param SvCfgSenialProveedor $svCfgSenialProveedor The svCfgSenialProveedor entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgSenialProveedor $svCfgSenialProveedor)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svcfgsenialproveedor_delete', array('id' => $svCfgSenialProveedor->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* =================================================== */

    /**
     * datos para select 2
     *
     * @Route("/select", name="svcfgsenialproveedor_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $proveedores = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenialProveedor')->findBy(
            array('activo' => 1)
        );

        $response = null;

        foreach ($proveedores as $key => $proveedor) {
            $response[$key] = array(
                'value' => $proveedor->getId(),
                'label' => $proveedor->getNombre(),
            );
        }

        return $helpers->json($response);
    }
}
