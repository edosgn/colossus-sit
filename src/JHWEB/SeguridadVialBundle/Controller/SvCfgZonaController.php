<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgZona;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgzona controller.
 *
 * @Route("svcfgzona")
 */
class SvCfgZonaController extends Controller
{
    /**
     * Lists all svCfgZona entities.
     *
     * @Route("/", name="svcfgzona_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $zonas = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgZona')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($zonas) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($zonas) . " registros encontrados",
                'data' => $zonas,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new svCfgZona entity.
     *
     * @Route("/new", name="svcfgzona_new")
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

            $zona = new SvCfgZona();

            $em = $this->getDoctrine()->getManager();

            $zona->setNombre(strtoupper($params->nombre));
            $zona->setActivo(true);
            $em->persist($zona);
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
     * Finds and displays a svCfgZona entity.
     *
     * @Route("/show", name="svcfgzona_show")
     * @Method("GET")
     */
    public function showAction(SvCfgZona $svCfgZona)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $zona = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgZona')->find(
                $params->id
            );

            $em->persist($zona);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro encontrado con exito",
                'data' => $zona,
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
     * Displays a form to edit an existing SvCfgZona entity.
     *
     * @Route("/edit", name="svcfgzona_edit")
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
            $zona = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgZona')->find($params->id);

            if ($zona != null) {
                $zona->setNombre(strtoupper($params->nombre));

                $em->persist($zona);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $zona,
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
     * Deletes a SvCfgZona entity.
     *
     * @Route("/delete", name="svcfgzona_delete")
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

            $zona = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgZona')->find($params->id);

            $zona->setActivo(false);

            $em->persist($zona);
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
     * Creates a form to delete a SvCfgZona entity.
     *
     * @param SvCfgZona $svCfgZona The SvCfgZona entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgZona $svCfgZona)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svcfgzona_delete', array('id' => $svCfgZona->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="zona_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $zonas = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgZona')->findBy(
            array('activo' => 1)
        );
        $response = null;

        foreach ($zonas as $key => $zona) {
            $response[$key] = array(
                'value' => $zona->getId(),
                'label' => $zona->getNombre(),
            );
        }
        return $helpers->json($response);
    }
}
