<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgTipoGeometria;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgtipogeometria controller.
 *
 * @Route("svcfgtipogeometria")
 */
class SvCfgTipoGeometriaController extends Controller
{
    /**
     * Lists all svCfgTipoGeometria entities.
     *
     * @Route("/", name="svcfgtipogeometria_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $tiposGeometria = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTipoGeometria')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($tiposGeometria) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($tiposGeometria) . " registros encontrados",
                'data' => $tiposGeometria,
            );
        }
        return $helpers->json($response);

    }

    /**
     * Creates a new svCfgTipoGeometria entity.
     *
     * @Route("/new", name="svcfgtipogeometria_new")
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

            $tipoGeometria = new SvCfgTipoGeometria();

            $em = $this->getDoctrine()->getManager();

            $nombre = strtoupper($params->nombre);

            $tipoGeometria->setNombre($nombre);
            $tipoGeometria->setActivo(true);
            $em->persist($tipoGeometria);
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
     * Finds and displays a svCfgTipoGeometria entity.
     *
     * @Route("/{id}/show", name="svcfgtipogeometria_show")
     * @Method("GET")
     */
    public function showAction(SvCfgTipoGeometria $svCfgTipoGeometria)
    {
        $deleteForm = $this->createDeleteForm($svCfgTipoGeometria);
        return $this->render('svCfgTipoGeometria/show.html.twig', array(
            'svCfgTipoGeometria' => $svCfgTipoGeometria,
            'delete_form' => $deleteForm->createView(),
        ));

    }

    /**
     * Displays a form to edit an existing svCfgTipoGeometria entity.
     *
     * @Route("/edit", name="svcfgtipogeometria_edit")
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
            $tipoGeometria = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTipoGeometria')->find($params->id);

            if ($tipoGeometria != null) {
                $nombre = strtoupper($params->nombre);

                $tipoGeometria->setNombre($nombre);

                $em->persist($tipoGeometria);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $tipoGeometria,
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
     * Deletes a SvCfgTipoGeometria entity.
     *
     * @Route("/delete", name="svcfgtipogeometria_delete")
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

            $tipoGeometria = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTipoGeometria')->find($params->id);

            $tipoGeometria->setActivo(false);

            $em->persist($tipoGeometria);
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
     * Creates a form to delete a SvCfgTipoGeometria entity.
     *
     * @param SvCfgTipoGeometria $svCfgTipoGeometria The SvCfgTipoGeometria entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgTipoGeometria $svCfgTipoGeometria)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svCfgTipoGeometria_delete', array('id' => $svCfgTipoGeometria->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="tipogeometria_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $tiposGeometria = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTipoGeometria')->findBy(
            array('activo' => 1)
        );
        $response = null;

        foreach ($tiposGeometria as $key => $tipoGeometria) {
            $response[$key] = array(
                'value' => $tipoGeometria->getId(),
                'label' => $tipoGeometria->getNombre(),
            );
        }
        return $helpers->json($response);
    }
}
