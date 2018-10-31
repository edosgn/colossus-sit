<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgTemaCapacitacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgtemacapacitacion controller.
 *
 * @Route("svcfgtemacapacitacion")
 */
class SvCfgTemaCapacitacionController extends Controller
{
    /**
     * Lists all svCfgTemaCapacitacion entities.
     *
     * @Route("/", name="svcfgtemacapacitacion_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $temas = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTemaCapacitacion')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($temas) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($temas) . " registros encontrados",
                'data' => $temas,
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a new SvCfgTemaCapacitacion entity.
     *
     * @Route("/new", name="svcfgtemacapacitacion_new")
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
            
            $temaCapacitacion = new SvCfgTemaCapacitacion();

            $em = $this->getDoctrine()->getManager();

            $temaCapacitacion->setNombre($params->nombre);
            $temaCapacitacion->setActivo(true);

            $em->persist($temaCapacitacion);
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
     * Finds and displays a svCfgTemaCapacitacion entity.
     *
     * @Route("/{id}/show", name="svcfgtemacapacitacion_show")
     * @Method("GET")
     */
    public function showAction(SvCfgTemaCapacitacion $svCfgTemaCapacitacion)
    {
        $deleteForm = $this->createDeleteForm($svCfgTemaCapacitacion);
        return $this->render('svcfgtemacapacitacion/show.html.twig', array(
            'svCfgTemaCapacitacion' => $svCfgTemaCapacitacion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing svCfgTemaCapacitacion entity.
     *
     * @Route("/edit", name="svcfgtemacapacitacion_edit")
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
            $temaCapacitacion = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTemaCapacitacion')->find($params->id);

            if ($temaCapacitacion != null) {
                $temaCapacitacion->setNombre($params->nombre);

                $em->persist($temaCapacitacion);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $temaCapacitacion,
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
     * Deletes a SvCfgTemaCapacitacion entity.
     *
     * @Route("/delete", name="svCfgTemaCapacitacion_delete")
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

            $temaCapacitacion = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTemaCapacitacion')->find($params->id);

            $temaCapacitacion->setActivo(false);

            $em->persist($temaCapacitacion);
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
     * Creates a form to delete a SvCfgTemaCapacitacion entity.
     *
     * @param SvCfgTemaCapacitacion $svCfgTemaCapacitacion The SvCfgTemaCapacitacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgTemaCapacitacion $svCfgTemaCapacitacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svCfgTemaCapacitacion_delete', array('id' => $svCfgTemaCapacitacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="tema_capacitacion_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $temasCapacitaciones = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTemaCapacitacion')->findBy(array('activo' => true));
    $response = null;
  
    foreach ($temasCapacitaciones as $key => $temaCapacitacion) {
        $response[$key] = array(
            'value' => $temaCapacitacion->getId(),
            'label' => $temaCapacitacion->getNombre(),
            );
      }
       return $helpers->json($response);
    }
}
