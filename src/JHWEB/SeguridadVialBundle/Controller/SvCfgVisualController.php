<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgVisual;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgvisual controller.
 *
 * @Route("svcfgvisual")
 */
class SvCfgVisualController extends Controller
{
    /**
     * Lists all svCfgVisual entities.
     *
     * @Route("/", name="svcfgvisual_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $visuales = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgVisual')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($visuales) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($visuales) . " registros encontrados",
                'data' => $visuales,
            );
        }
        return $helpers->json($response);

    }

    /**
     * Creates a new svCfgVisual entity.
     *
     * @Route("/new", name="svcfgvisual_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);

            $visual = new SvCfgVisual();

            $em = $this->getDoctrine()->getManager();

            $visual->setNombre($params->nombre);
            $visual->setActivo(true);
            $em->persist($visual);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Los datos han sido registrados exitosamente.",
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Finds and displays a svCfgVisual entity.
     *
     * @Route("/{id}/show", name="svcfgvisual_show")
     * @Method("GET")
     */
    public function showAction(SvCfgVisual $svCfgVisual)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $visual = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgVisual')->find(
                $params->id
            );

            $em->persist($visual);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro encontrado con exito",
                'data' => $visual,
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida",
            );
        }
        return $helpers->json($response);

    }

    /**
     * Displays a form to edit an existing SvCfgvisual entity.
     *
     * @Route("/edit", name="svcfgvisual_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            $visual = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgVisual')->find($params->id);

            if ($visual != null) {
                $visual->setNombre($params->nombre);

                $em->persist($visual);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $visual,
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
     * Deletes a SvCfgvisual entity.
     *
     * @Route("/delete", name="svcfgvisual_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", true);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $json = $request->get("json", null);
            $params = json_decode($json);

            $visual = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgVisual')->find($params->id);

            $visual->setActivo(false);

            $em->persist($visual);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro eliminado con éxito.",
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no válida",
            );
        }
        return $helpers->json($response);

    }

    /**
     * Creates a form to delete a SvCfgVisual entity.
     *
     * @param SvCfgVisual $svCfgVisual The SvCfgVisual entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgVisual $svCfgVisual)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('svcfgvisual_delete', array('id' => $svCfgVisual->getId())))
        ->setMethod('DELETE')
        ->getForm();
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="visual_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $visuales = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgVisual')->findBy(
            array('activo' => 1)
        );
        $response = null;

        foreach ($visuales as $key => $visual) {
            $response[$key] = array(
                'value' => $visual->getNombre(),
                'label' => $visual->getNombre(),
            );
        }
        return $helpers->json($response);
    }
}
