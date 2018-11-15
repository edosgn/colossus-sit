<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgEstadoIluminacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgestadoiluminacion controller.
 *
 * @Route("svcfgestadoiluminacion")
 */
class SvCfgEstadoIluminacionController extends Controller
{
    /**
     * Lists all svCfgEstadoIluminacion entities.
     *
     * @Route("/", name="svcfgestadoiluminacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $estadosIluminacion = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgEstadoIluminacion')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($estadosIluminacion) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($estadosIluminacion) . " registros encontrados",
                'data' => $estadosIluminacion,
            );
        }
        return $helpers->json($response);

    }

    /**
     * Creates a new svCfgEstadoIluminacion entity.
     *
     * @Route("/new", name="svcfgestadoiluminacion_new")
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
            
            $estadoIluminacion = new SvCfgEstadoIluminacion();

            $em = $this->getDoctrine()->getManager();

            $nombre = strtoupper($params->nombre);

            $estadoIluminacion->setNombre($nombre);
            $estadoIluminacion->setActivo(true);
            $em->persist($estadoIluminacion);
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
     * Finds and displays a svCfgEstadoIluminacion entity.
     *
     * @Route("/{id}/show", name="svcfgestadoiluminacion_show")
     * @Method("GET")
     */
    public function showAction(SvCfgEstadoIluminacion $svCfgEstadoIluminacion)
    {
        $deleteForm = $this->createDeleteForm($svCfgEstadoIluminacion);
        return $this->render('svCfgEstadoIluminacion/show.html.twig', array(
            'svCfgEstadoIluminacion' => $svCfgEstadoIluminacion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing svCfgEstadoIluminacion entity.
     *
     * @Route("/edit", name="svcfgestadoiluminacion_edit")
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
            $estadoIluminacion = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgEstadoIluminacion')->find($params->id);

            if ($estadoIluminacion != null) {
                $nombre = strtoupper($params->nombre);

                $estadoIluminacion->setNombre($nombre);

                $em->persist($estadoIluminacion);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $estadoIluminacion,
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
     * Deletes a svCfgEstadoIluminacion entity.
     *
     * @Route("/delete", name="svcfgestadoiluminacion_delete")
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

            $estadoIluminacion = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgEstadoIluminacion')->find($params->id);

            $estadoIluminacion->setActivo(false);

            $em->persist($estadoIluminacion);
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
     * Creates a form to delete a SvCfgEstadoIluminacion entity.
     *
     * @param SvCfgEstadoIluminacion $svCfgEstadoIluminacion The SvCfgEstadoIluminacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgEstadoIluminacion $svCfgEstadoIluminacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svcfgestadoiluminacion_delete', array('id' => $svCfgEstadoIluminacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="svcfgestadoiluminacion_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $estadosIluminacion = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgEstadoIluminacion')->findBy(
        array('activo' => 1)
    );
    $response = null;

      foreach ($estadosIluminacion as $key => $estadoIluminacion) {
        $response[$key] = array(
            'value' => $estadoIluminacion->getId(),
            'label' => $estadoIluminacion->getNombre(),
            );
      }
       return $helpers->json($response);
    }
}
