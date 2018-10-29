<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgArea;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgarea controller.
 *
 * @Route("svcfgarea")
 */
class SvCfgAreaController extends Controller
{
    /**
     * Lists all svCfgArea entities.
     *
     * @Route("/", name="svcfgarea_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $areas = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgArea')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($areas) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($areas) . " registros encontrados",
                'data' => $areas,
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a new svCfgArea entity.
     *
     * @Route("/new", name="svcfgarea_new")
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

            $area = new SvCfgArea();

            $em = $this->getDoctrine()->getManager();

            $area->setNombre($params->nombre);
            $area->setActivo(true);
            $em->persist($area);
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
     * Finds and displays a svCfgArea entity.
     *
     * @Route("/{id}/show", name="svcfgarea_show")
     * @Method("GET")
     */
    public function showAction(SvCfgArea $svCfgArea)
    {
        $deleteForm = $this->createDeleteForm($svCfgArea);
        return $this->render('svcfgarea/show.html.twig', array(
            'svCfgArea' => $svCfgArea,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing SvCfgArea entity.
     *
     * @Route("/edit", name="svcfgarea_edit")
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
            $area = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgArea')->find($params->id);

            if ($params->tipoArea) {
                $tipoArea = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTipoArea')->find($params->tipoArea);
                $area->setTipoArea($tipoArea);
            }
            if ($area != null) {
                $area->setNombre($params->nombre);
                $em->persist($area);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $area,
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
     * Deletes a svCfgArea entity.
     *
     * @Route("/delete", name="svcfgarea_delete")
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

            $area = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgArea')->find($params->id);

            $area->setActivo(false);

            $em->persist($area);
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
     * Creates a form to delete a SvCfgArea entity.
     *
     * @param SvCfgarea $svCfgArea The SvCfgArea entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgarea $svCfgArea)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svcfgarea_delete', array('id' => $svCfgArea->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/selectarea", name="area_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $areas = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgArea')->findBy(
            array('activo' => 1)
        );
        $response = null;
        foreach ($areas as $key => $area) {
            $response[$key] = array(
                'value' => $area->getId(),
                'label' => $area->getNombre(),
            );
        }
        return $helpers->json($response);
    }
}
