<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgIluminacion;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgiluminacion controller.
 *
 * @Route("svcfgiluminacion")
 */
class SvCfgIluminacionController extends Controller
{
    /**
     * Lists all svCfgIluminacion entities.
     *
     * @Route("/", name="svcfgiluminacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $iluminaciones = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgIluminacion')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($iluminaciones) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($iluminaciones) . " registros encontrados",
                'data' => $iluminaciones,
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a new svCfgIluminacion entity.
     *
     * @Route("/new", name="svcfgiluminacion_new")
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

            $iluminacion = new SvCfgIluminacion();

            $em = $this->getDoctrine()->getManager();

            $nombre = strtoupper($params->nombre);
            $iluminacion->setNombre($nombre);
            $iluminacion->setActivo(true);
            $em->persist($iluminacion);
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
     * Finds and displays a svCfgIluminacion entity.
     *
     * @Route("/{id}/show", name="svcfgiluminacion_show")
     * @Method("GET")
     */
    public function showAction(SvCfgIluminacion $svCfgIluminacion)
    {
        $deleteForm = $this->createDeleteForm($svCfgIluminacion);
        return $this->render('svCfgIluminacion/show.html.twig', array(
            'svCfgIluminacion' => $svCfgIluminacion,
            'delete_form' => $deleteForm->createView(),
        ));

    }

    /**
     * Displays a form to edit an existing svCfgIluminacion entity.
     *
     * @Route("/edit", name="svcfgiluminacion_edit")
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
            $iluminacion = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgIluminacion')->find($params->id);

            if ($iluminacion != null) {
                $iluminacion->setNombre($params->nombre);

                $em->persist($iluminacion);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $iluminacion,
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
     * Deletes a svCfgIluminacion entity. 
     * @Route("/delete", name="svcfgiluminacion_delete")
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

            $iluminacion = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgIluminacion')->find($params->id);

            $iluminacion->setActivo(false);

            $em->persist($iluminacion);
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
     * Creates a form to delete a svCfgIluminacion entity.
     *
     * @param SvCfgIluminacion $svCfgIluminacion The svCfgIluminacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgIluminacion $svCfgIluminacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svcfgiluminacion_delete', array('id' => $svCfgIluminacion->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="iluminacion_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $iluminaciones = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgIluminacion')->findBy(
            array('activo' => 1)
        );
        $response = null;

        foreach ($iluminaciones as $key => $iluminacion) {
            $response[$key] = array(
                'value' => $iluminacion->getId(),
                'label' => $iluminacion->getNombre(),
            );
        }
        return $helpers->json($response);
    }
}
