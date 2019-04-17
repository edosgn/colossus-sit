<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgObjetoFijo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgobjetofijo controller.
 *
 * @Route("svcfgobjetofijo")
 */
class SvCfgObjetoFijoController extends Controller
{
    /**
     * Lists all svCfgObjetoFijo entities.
     *
     * @Route("/", name="svcfgobjetofijo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $objetosFijos = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgObjetoFijo')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($objetosFijos) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($objetosFijos) . " registros encontrados",
                'data' => $objetosFijos,
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a new svCfgObjetoFijo entity.
     *
     * @Route("/new", name="svcfgobjetofijo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $objetoFijo = new SvCfgObjetoFijo();
            $objetoFijo->setNombre(strtoupper($params->nombre));

            if ($params->idClaseChoque) {
                $claseChoque = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgClaseChoque')->find(
                    $params->idClaseChoque
                );
                $objetoFijo->setClaseChoque($claseChoque);
            }
            $objetoFijo->setActivo(true);
            $em->persist($objetoFijo);
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
     * Finds and displays a svCfgObjetoFijo entity.
     *
     * @Route("/show", name="svcfgobjetofijo_show")
     * @Method("GET")
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $json = $request->get("data", null);
        $params = json_decode($json);

        $objetoFijo = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgObjetoFijo')->find($params->id);

        if ($objetoFijo) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro encontrado",
                'data' => $objetoFijo,
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Registro no encontrado",
            );
        }

        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing svCfgObjetoFijo entity.
     *
     * @Route("/edit", name="svcfgobjetofijo_edit")
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

            $objetoFijo = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgObjetoFijo')->find(
                $params->id
            );

            if ($params->idClaseChoque) {
                $claseChoque = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgClaseChoque')->find($params->idClaseChoque);
                $objetoFIjo->setClaseChoque($claseChoque);
            }
            if ($objetoFijo != null) {
                $objetoFijo->setNombre(strtoupper($params->nombre));

                $em->persist($objetoFijo);
                $em->flush();
                
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito",
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
                'message' => "Autorización no valida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Deletes a svCfgObjetoFijo entity.
     *
     * @Route("/delete", name="svcfgobjetofijo_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", true);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $objetoFijo = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgObjetoFijo')->find($params->id);
            $objetoFijo->setActivo(false);

            $em->persist($objetoFijo);
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
     * datos para select 2
     *
     * @Route("/select", name="objeto_fijo_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $objetosFijos = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgObjetoFijo')->findBy(
            array('activo' => true)
        );
        $response = null;

        foreach ($objetosFijos as $key => $objetoFijo) {
            $response[$key] = array(
                'value' => $objetoFijo->getId(),
                'label' => $objetoFijo->getNombre(),
            );
        }
        return $helpers->json($response);
    }
}
