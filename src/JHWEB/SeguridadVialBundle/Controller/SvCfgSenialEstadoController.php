<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgSenialEstado;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgsenialestado controller.
 *
 * @Route("svcfgsenialestado")
 */
class SvCfgSenialEstadoController extends Controller
{
    /**
     * Lists all svCfgSenialEstado entities.
     *
     * @Route("/", name="svcfgsenialestado_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $estados = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenialEstado')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($estados) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($estados)." registros encontrados", 
                'data'=> $estados,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new svCfgSenialEstado entity.
     *
     * @Route("/new", name="svcfgsenialestado_new")
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
           
            $estado = new SvCfgSenialEstado();

            $estado->setNombre(strtoupper($params->nombre));
            $estado->setActivo(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($estado);
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
     * Finds and displays a svCfgSenialEstado entity.
     *
     * @Route("/{id}/show", name="svcfgsenialestado_show")
     * @Method("GET")
     */
    public function showAction(SvCfgSenialEstado $svCfgSenialEstado)
    {
        $deleteForm = $this->createDeleteForm($svCfgSenialEstado);

        return $this->render('svcfgsenialestado/show.html.twig', array(
            'svCfgSenialEstado' => $svCfgSenialEstado,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing svCfgSenialEstado entity.
     *
     * @Route("/edit", name="svcfgsenialestado_edit")
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
            $estado = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenialEstado')->find($params->id);

            if ($estado) {
                $estado->setNombre(strtoupper($params->nombre));

                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $estado,
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
     * Deletes a svCfgSenialEstado entity.
     *
     * @Route("/{id}", name="svcfgsenialestado_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SvCfgSenialEstado $svCfgSenialEstado)
    {
        $form = $this->createDeleteForm($svCfgSenialEstado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($svCfgSenialEstado);
            $em->flush();
        }

        return $this->redirectToRoute('svcfgsenialestado_index');
    }

    /**
     * Creates a form to delete a svCfgSenialEstado entity.
     *
     * @param SvCfgSenialEstado $svCfgSenialEstado The svCfgSenialEstado entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgSenialEstado $svCfgSenialEstado)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svcfgsenialestado_delete', array('id' => $svCfgSenialEstado->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* =================================================== */

    /**
     * datos para select 2
     *
     * @Route("/select", name="svcfgsenialestado_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $estados = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenialEstado')->findBy(
            array('activo' => 1)
        );

        $response = null;

        foreach ($estados as $key => $estado) {
            $response[$key] = array(
                'value' => $estado->getId(),
                'label' => $estado->getNombre(),
            );
        }

        return $helpers->json($response);
    }
}
