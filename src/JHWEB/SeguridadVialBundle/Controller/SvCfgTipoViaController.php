<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgTipoVia;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgtipovia controller.
 *
 * @Route("svcfgtipovia")
 */
class SvCfgTipoViaController extends Controller
{
    /**
     * Lists all svCfgTipoVia entities.
     *
     * @Route("/", name="svcfgtipovia_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $tiposVia = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTipoVia')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($tiposVia) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($tiposVia) . " registros encontrados",
                'data' => $tiposVia,
            );
        }
        return $helpers->json($response);

    }

    /**
     * Creates a new svCfgTipoVia entity.
     *
     * @Route("/new", name="svcfgtipovia_new")
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

            $tipoVia = new SvCfgTipoVia();

            $em = $this->getDoctrine()->getManager();

            if ($params->tipoArea) {
                $tipoArea = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTipoArea')->find(
                    $params->tipoArea
                );
                $tipoVia->setTipoArea($tipoArea);
            }

            $nombre = strtoupper($params->nombre);

            $tipoVia->setNombre($nombre);
            $tipoVia->setActivo(true);
            $em->persist($tipoVia);
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
     * Finds and displays a svCfgTipoVia entity.
     *
     * @Route("/{id}/show", name="svcfgtipovia_show")
     * @Method("GET")
     */
    public function showAction(SvCfgTipoVia $svCfgTipoVia)
    {
        $deleteForm = $this->createDeleteForm($svCfgTipoVia);
        return $this->render('svCfgTipoVia/show.html.twig', array(
            'svCfgTipoVia' => $svCfgTipoVia,
            'delete_form' => $deleteForm->createView(),
        ));

    }

    /**
     * Displays a form to edit an existing SvCfgtipoVia entity.
     *
     * @Route("/edit", name="svcfgtipovia_edit")
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
            $tipoVia = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTipoVia')->find($params->id);
            $tipoArea = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTipoArea')->find($params->tipoArea);

            if ($tipoVia != null) {
                $nombre = strtoupper($params->nombre);

                $tipoVia->setNombre($nombre);
                $tipoVia->setTipoArea($params->tipoArea);

                $em->persist($tipoVia);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $tipoVia,
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
     * Deletes a SvCfgtipoVia entity.
     *
     * @Route("/delete", name="svcfgtipovia_delete")
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

            $tipoVia = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTipoVia')->find($params->id);

            $tipoVia->setActivo(false);

            $em->persist($tipoVia);
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
     * Creates a form to delete a svCfgTipoVia entity.
     *
     * @param SvCfgTipoVia $svCfgTipoVia The svCfgTipoVia entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgTipoVia $svCfgTipoVia)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svcfgtipovia_delete', array('id' => $svCfgTipoVia->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="tipovia_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $tiposVia = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTipoVia')->findBy(
            array('activo' => 1)
        );
        $response = null;

        foreach ($tiposVia as $key => $tipoVia) {
            $response[$key] = array(
                'value' => $tipoVia->getId(),
                'label' => $tipoVia->getNombre(),
            );
        }
        return $helpers->json($response);
    }
}
