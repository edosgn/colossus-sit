<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgEstadoTiempo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgestadotiempo controller.
 *
 * @Route("svcfgestadotiempo")
 */
class SvCfgEstadoTiempoController extends Controller
{
    /**
     * Lists all svCfgEstadoTiempo entities.
     *
     * @Route("/", name="svcfgestadotiempo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $estadosTiempo = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgEstadoTiempo')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($estadosTiempo) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($estadosTiempo) . " registros encontrados",
                'data' => $estadosTiempo,
            );
        }
        return $helpers->json($response);

    }

    /**
     * Creates a new svCfgEstadoTiempo entity.
     *
     * @Route("/new", name="svcfgestadotiempo_new")
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
            
            $estadoTiempo = new SvCfgEstadoTiempo();

            $em = $this->getDoctrine()->getManager();

            $nombre = strtoupper($params->nombre);

            $estadoTiempo->setNombre($nombre);
            $estadoTiempo->setActivo(true);
            $em->persist($estadoTiempo);
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
     * Finds and displays a svCfgEstadoTiempo entity.
     *
     * @Route("/{id}/show", name="svcfgestadotiempo_show")
     * @Method("GET")
     */
    public function showAction(SvCfgEstadoTiempo $svCfgEstadoTiempo)
    {
        $deleteForm = $this->createDeleteForm($svCfgEstadoTiempo);
        return $this->render('svCfgEstadoTiempo/show.html.twig', array(
            'svCfgEstadoTiempo' => $svCfgEstadoTiempo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing svCfgEstadoTiempo entity.
     *
     * @Route("/edit", name="svcfgestadotiempo_edit")
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
            $estadoTiempo = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgEstadoTiempo')->find($params->id);

            if ($estadoTiempo != null) {
                $nombre = strtoupper($params->nombre);

                $estadoTiempo->setNombre($nombre);

                $em->persist($estadoTiempo);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $estadoTiempo,
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
     * Deletes a svCfgEstadoTiempo entity.
     *
     * @Route("/delete", name="svcfgestadotiempo_delete")
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

            $estadoTiempo = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgEstadoTiempo')->find($params->id);

            $estadoTiempo->setActivo(false);

            $em->persist($estadoTiempo);
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
     * Creates a form to delete a svCfgEstadoTiempo entity.
     *
     * @param SvCfgEstadoTiempo $svCfgEstadoTiempo The svCfgEstadoTiempo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgEstadoTiempo $svCfgEstadoTiempo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svcfgestadotiempo_delete', array('id' => $svCfgEstadoTiempo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="svcfgestadotiempo_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $estadosTiempo = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgEstadoTiempo')->findBy(
            array('activo' => 1)
        );
        $response = null;

        foreach ($estadosTiempo as $key => $estadoTiempo) {
            $response[$key] = array(
                'value' => $estadoTiempo->getId(),
                'label' => $estadoTiempo->getNombre(),
                );
        }
        return $helpers->json($response);
        }
}
