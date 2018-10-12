<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgResultadoExamen;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgresultadoexamen controller.
 *
 * @Route("svcfgresultadoexamen")
 */
class SvCfgResultadoExamenController extends Controller
{
    /**
     * Lists all svCfgResultadoExamen entities.
     *
     * @Route("/", name="svcfgresultadoexamen_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $resultadosExamen = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgResultadoExamen')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($resultadosExamen) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($resultadosExamen) . " registros encontrados",
                'data' => $resultadosExamen,
            );
        }
        return $helpers->json($response);

    }

    /**
     * Creates a new svCfgResultadoExamen entity.
     *
     * @Route("/new", name="svcfgresultadoexamen_new")
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

            $resultadoExamen = new SvCfgResultadoExamen();

            $em = $this->getDoctrine()->getManager();

            $resultadoExamen->setNombre($params->nombre);
            $resultadoExamen->setActivo(true);
            $em->persist($resultadoExamen);
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
     * Finds and displays a svCfgResultadoExamen entity.
     *
     * @Route("/{id}/show", name="svcfgresultadoexamen_show")
     * @Method("GET")
     */
    public function showAction(SvCfgResultadoExamen $svCfgResultadoExamen)
    {
        $deleteForm = $this->createDeleteForm($svCfgResultadoExamen);
        return $this->render('svCfgResultadoExamen/show.html.twig', array(
            'svCfgResultadoExamen' => $svCfgResultadoExamen,
            'delete_form' => $deleteForm->createView(),
        ));

    }

    /**
     * Displays a form to edit an existing svCfgResultadoExamen entity.
     *
     * @Route("/edit", name="svcfgresultadoexamen_edit")
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
            $resultadoExamen = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgResultadoExamen')->find($params->id);

            if ($resultadoExamen != null) {
                $resultadoExamen->setNombre($params->nombre);

                $em->persist($resultadoExamen);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $resultadoExamen,
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
     * Deletes a svCfgResultadoExamen entity.
     *
     * @Route("/delete", name="svcfgresultadoexamen_delete")
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

            $resultadoExamen = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgResultadoExamen')->find($params->id);

            $resultadoExamen->setActivo(false);

            $em->persist($resultadoExamen);
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
     * Creates a form to delete a SvCfgResultadoExamen entity.
     *
     * @param SvCfgResultadoExamen $svCfgResultadoExamen The SvCfgResultadoExamen entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgResultadoExamen $svCfgResultadoExamen)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svcfgresultadoexamen_delete', array('id' => $svCfgResultadoExamen->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="resultadoexamen_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $resultadosExamen = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgResultadoExamen')->findBy(
            array('activo' => 1)
        );
        foreach ($resultadosExamen as $key => $resultadoExamen) {
            $response[$key] = array(
                'value' => $resultadoExamen->getId(),
                'label' => $resultadoExamen->getNombre(),
            );
        }
        return $helpers->json($response);
    }
}
