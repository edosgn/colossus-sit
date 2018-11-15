<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgUtilizacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * Svcfgutilizacion controller.
 *
 * @Route("svcfgutilizacion")
 */
class SvCfgUtilizacionController extends Controller
{
    /**
     * Lists all svCfgUtilizacion entities.
     *
     * @Route("/", name="svcfgutilizacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $utilizaciones = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgUtilizacion')->findBy(
            array(
                'activo' => true,
            )
        );

        $response['data'] = array();

        if ($utilizaciones) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($utilizaciones) . " registros encontrados",
                'data' => $utilizaciones,
            );
        }

        return $helpers->json($response);

    }

    /**
     * Creates a new svCfgUtilizacion entity.
     *
     * @Route("/new", name="svcfgutilizacion_new")
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
            
            $utilizacion = new SvCfgUtilizacion();

            $em = $this->getDoctrine()->getManager();

            $nombre = strtoupper($params->nombre);

            $utilizacion->setNombre($nombre);
            $utilizacion->setActivo(true);
            $em->persist($utilizacion);
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
     * Finds and displays a svCfgUtilizacion entity.
     *
     * @Route("/show", name="svcfgutilizacion_show")
     * @Method("GET")
     */
    public function showAction(SvCfgUtilizacion $svCfgUtilizacion)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $utilizacion = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgUtilizacion')->find(
                $params->id
            );

            $em->persist($utilizacion);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro encontrado con exito",
                'data' => $utilizacion,
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
     * Displays a form to edit an existing svCfgUtilizacion entity.
     *
     * @Route("/edit", name="svcfgutilizacion_edit")
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
            $utilizacion = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgUtilizacion')->find($params->id);

            if ($utilizacion != null) {
                $utilizacion->setNombre($params->nombre);

                $em->persist($utilizacion);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $utilizacion,
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
     * Deletes a svCfgUtilizacion entity.
     *
     * @Route("/delete", name="svcfgutilizacion_delete")
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

            $utilizacion = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgUtilizacion')->find($params->id);

            $utilizacion->setActivo(false);

            $em->persist($utilizacion);
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
     * Creates a form to delete a svCfgUtilizacion entity.
     *
     * @param SvCfgUtilizacion $svCfgUtilizacion The svCfgUtilizacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgUtilizacion $svCfgUtilizacion)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('svcfgaseguradora_delete', array('id' => $svCfgUtilizacion->getId())))
        ->setMethod('DELETE')
        ->getForm();
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="utilizacion_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $utilizaciones = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgUtilizacion')->findBy(
            array('activo' => 1)
        );
        $response = null;

        foreach ($utilizaciones as $key => $utilizacion) {
            $response[$key] = array(
                'value' => $utilizacion->getId(),
                'label' => $utilizacion->getNombre(),
            );
        }
        return $helpers->json($response);
    }
}
