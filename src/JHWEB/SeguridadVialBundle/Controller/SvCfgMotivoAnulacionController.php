<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgMotivoAnulacion;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgmotivoanulacion controller.
 *
 * @Route("svcfgmotivoanulacion")
 */
class SvCfgMotivoAnulacionController extends Controller
{
    /**
     * Lists all svCfgMotivoAnulacion entities.
     *
     * @Route("/", name="svcfgmotivoanulacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $motivosAnulacion = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgMotivoAnulacion')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($motivosAnulacion) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($motivosAnulacion) . " registros encontrados",
                'data' => $motivosAnulacion,
            );
        }
        return $helpers->json($response);

    }

    /**
     * Creates a new svCfgMotivoAnulacion entity.
     *
     * @Route("/new", name="svcfgmotivoanulacion_new")
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

            $motivoAnulacion = new SvCfgMotivoAnulacion();

            $em = $this->getDoctrine()->getManager();

            $nombre = strtoupper($params->nombre);

            $motivoAnulacion->setNombre($nombre);
            $motivoAnulacion->setActivo(true);
            $em->persist($motivoAnulacion);
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
     * Finds and displays a svCfgMotivoAnulacion entity.
     *
     * @Route("/{id}/show", name="svcfgmotivoanulacion_show")
     * @Method("GET")
     */
    public function showAction(SvCfgMotivoAnulacion $svCfgMotivoAnulacion)
    {
        $deleteForm = $this->createDeleteForm($svCfgMotivoAnulacion);
        return $this->render('svCfgMotivoAnulacion/show.html.twig', array(
            'svCfgMotivoAnulacion' => $svCfgMotivoAnulacion,
            'delete_form' => $deleteForm->createView(),
        ));

    }
    /**
     * Displays a form to edit an existing SvCfgMotivoAnulacion entity.
     *
     * @Route("/edit", name="svcfgmotivoAnulacion_edit")
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
            $motivoAnulacion = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgMotivoAnulacion')->find($params->id);

            if ($motivoAnulacion != null) {
                $motivoAnulacion->setNombre($params->nombre);

                $em->persist($motivoAnulacion);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $motivoAnulacion,
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
     * Deletes a SvCfgmotivoAnulacion entity.
     *
     * @Route("/delete", name="svcfgmotivoanulacion_delete")
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

            $motivoAnulacion = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgMotivoAnulacion')->find($params->id);

            $motivoAnulacion->setActivo(false);

            $em->persist($motivoAnulacion);
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
     * Creates a form to delete a SvCfgMotivoAnulacion entity.
     *
     * @param SvCfgMotivoAnulacion $svCfgMotivoAnulacion The SvCfgmotivoAnulacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgMotivoAnulacion $svCfgMotivoAnulacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svCfgmotivoanulacion_delete', array('id' => $svCfgMotivoAnulacion->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="motivoanulacion_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $motivosAnulacion = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgMotivoAnulacion')->findBy(
            array('activo' => 1)
        );
        $response = null;

        foreach ($motivosAnulacion as $key => $motivoAnulacion) {
            $response[$key] = array(
                'value' => $motivoAnulacion->getId(),
                'label' => $motivoAnulacion->getNombre(),
            );
        }
        return $helpers->json($response);
    }
}
