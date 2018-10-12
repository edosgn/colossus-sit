<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgTipoVictima;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgtipovictima controller.
 *
 * @Route("svcfgtipovictima")
 */
class SvCfgTipoVictimaController extends Controller
{
    /**
     * Lists all svCfgTipoVictima entities.
     *
     * @Route("/", name="svcfgtipovictima_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $tiposVictima = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTipoVictima')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($tiposVictima) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($tiposVictima) . " registros encontrados",
                'data' => $tiposVictima,
            );
        }
        return $helpers->json($response);

    }

    /**
     * Creates a new svCfgTipoVictima entity.
     *
     * @Route("/new", name="svcfgtipovictima_new")
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

            $tipoVictima = new SvCfgTipoVictima();

            $em = $this->getDoctrine()->getManager();

            $tipoVictima->setNombre($params->nombre);
            $tipoVictima->setActivo(true);
            $em->persist($tipoVictima);
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
     * Finds and displays a svCfgTipoVictima entity.
     *
     * @Route("/show", name="svcfgtipovictima_show")
     * @Method("GET")
     */
    public function showAction(SvCfgTipoVictima $svCfgTipoVictima)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $tipoVictima = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTipoVictima')->find(
                $params->id
            );

            $em->persist($tipoVictima);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro encontrado con exito",
                'data' => $tipoVictima,
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
     * Displays a form to edit an existing svCfgTipoVictima entity.
     *
     * @Route("/edit", name="svcfgtipovictima_edit")
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
            $tipoVictima = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTipoVictima')->find($params->id);

            if ($tipoVictima != null) {
                $tipoVictima->setNombre($params->nombre);

                $em->persist($tipoVictima);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $tipoVictima,
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
     * Deletes a svCfgTipoVictima entity.
     *
     * @Route("/delete", name="svcfgtipovictima_delete")
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

            $tipoVictima = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTipoVictima')->find($params->id);

            $tipoVictima->setActivo(false);

            $em->persist($tipoVictima);
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
     * Creates a form to delete a SvCfgTipoVictima entity.
     *
     * @param SvCfgTipoVictima $svCfgTipoVictima The SvCfgTipoVictima entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgTipoVictima $svCfgTipoVictima)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('svcfgtipovictima_delete', array('id' => $svCfgTipoVictima->getId())))
        ->setMethod('DELETE')
        ->getForm();
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="tipovictima_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $tiposVictima = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTipoVictima')->findBy(
            array('activo' => 1)
        );
        foreach ($tiposVictima as $key => $tipoVictima) {
            $response[$key] = array(
                'value' => $tipoVictima->getId(),
                'label' => $tipoVictima->getNombre(),
            );
        }
        return $helpers->json($response);
    }
}
