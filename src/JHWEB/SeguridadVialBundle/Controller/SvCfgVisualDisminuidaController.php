<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgVisualDisminuida;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgvisualdisminuida controller.
 *
 * @Route("svcfgvisualdisminuida")
 */
class SvCfgVisualDisminuidaController extends Controller
{
    /**
     * Lists all svCfgVisualDisminuida entities.
     *
     * @Route("/", name="svcfgvisualdisminuida_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $visualesDisminuidas = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgVisualDisminuida')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($visualesDisminuidas) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($visualesDisminuidas) . " registros encontrados",
                'data' => $visualesDisminuidas,
            );
        }
        return $helpers->json($response);

    }

    /**
     * Creates a new svCfgVisualDisminuida entity.
     *
     * @Route("/new", name="svcfgvisualdisminuida_new")
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

            $visualDisminuida = new SvCfgVisualDisminuida();

            $em = $this->getDoctrine()->getManager();

            $nombre = strtoupper($params->nombre);

            $visualDisminuida->setNombre($nombre);
            $visualDisminuida->setActivo(true);
            $em->persist($visualDisminuida);
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
     * Finds and displays a svCfgVisualDisminuida entity.
     *
     * @Route("/{id}/show", name="svcfgvisualdisminuida_show")
     * @Method({"GET", "POST"})
     */
    /*public function showAction(SvCfgVisualDisminuida $svCfgVisualDisminuida)
    {
        $deleteForm = $this->createDeleteForm($svCfgVisualDisminuida);
    }*/
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        
        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            $visualDisminuida = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgVisualDisminuida')->find(
                $params->id
            );

            $em->persist($visualDisminuida);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro encontrado con exito",
                'data' => $visualDisminuida,
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
     * Displays a form to edit an existing svCfgVisualDisminuida entity.
     *
     * @Route("/edit", name="svcfgvisualdisminuida_edit")
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
            $visualDisminuida = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgVisualDisminuida')->find($params->id);

            if ($visualDisminuida != null) {
                $nombre = strtoupper($params->nombre);

                $visualDisminuida->setNombre($nombre);

                $em->persist($visualDisminuida);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $visualDisminuida,
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
     * Deletes a svCfgVisualDisminuida entity.
     *
     * @Route("/delete", name="svcfgvisualdisminuida_delete")
     * @Method("POST")
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

            $visualDisminuida = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgVisualDisminuida')->find($params->id);

            $visualDisminuida->setActivo(false);

            $em->persist($visualDisminuida);
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
     * Creates a form to delete a svCfgVisualDisminuida entity.
     *
     * @param SvCfgVisualDisminuida $svCfgVisualDisminuida The svCfgVisualDisminuida entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgVisualDisminuida $svCfgVisualDisminuida)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svcfgvisualdisminuida_delete', array('id' => $svCfgVisualDisminuida->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="visualdisminuida_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $visualesDisminuidas = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgVisualDisminuida')->findBy(
            array('activo' => 1)
        );
        $response = null;

        foreach ($visualesDisminuidas as $key => $visualDisminuida) {
            $response[$key] = array(
                'value' => $visualDisminuida->getNombre(),
                'label' => $visualDisminuida->getNombre(),
            );
        }
        return $helpers->json($response);
    }
}
