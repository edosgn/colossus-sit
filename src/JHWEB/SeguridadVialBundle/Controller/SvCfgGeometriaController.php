<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgGeometria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfggeometria controller.
 *
 * @Route("svcfggeometria")
 */
class SvCfgGeometriaController extends Controller
{
    /**
     * Lists all svCfgGeometria entities.
     *
     * @Route("/", name="svcfggeometria_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $geometrias = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgGeometria')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($geometrias) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($geometrias) . " registros encontrados",
                'data' => $geometrias,
            );
        }
        return $helpers->json($response);

    }

    /**
     * Creates a new svCfgGometria entity.
     *
     * @Route("/new", name="svcfggeometria_new")
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
            
            $geometria = new SvCfgGeometria();

            $em = $this->getDoctrine()->getManager();
            if ($params->tipoGeometria) {
                $tipoGeometria = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTipoGeometria')->find(
                    $params->tipoGeometria
                );
                $geometria->setTipoGeometria($tipoGeometria);
            }

            $nombre = strtoupper($params->nombre);

            $geometria->setNombre($nombre);
            $geometria->setActivo(true);
            $em->persist($geometria);
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
     * Finds and displays a svCfgGeometria entity.
     *
     * @Route("/{id}/show", name="svcfggeometria_show")
     * @Method("GET")
     */
    public function showAction(SvCfgGeometria $svCfgGeometria)
    {
        $deleteForm = $this->createDeleteForm($svCfgGeometria);
        return $this->render('svCfgGeometria/show.html.twig', array(
            'svCfgGeometria' => $svCfgGeometria,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing SvCfgGeometria entity.
     *
     * @Route("/edit", name="svcfggeometria_edit")
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
            $geometria = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgGeometria')->find($params->id);

            $tipoGeometria = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTipoGeometria')->find($params->tipoGeometria);
            if ($geometria != null) {
                $nombre = strtoupper($params->nombre);

                $geometria->setNombre($nombre);
                $geometria->setTipoGeometria($tipoGeometria);

                $em->persist($geometria);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $geometria,
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
     * Deletes a svCfgGeometria entity.
     *
     * @Route("/delete", name="svcfggeometria_delete")
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

            $geometria = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgGeometria')->find($params->id);

            $geometria->setActivo(false);

            $em->persist($geometria);
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
     * Creates a form to delete a SvCfgGeometria entity.
     *
     * @param SvCfgGeometria $svCfgGeometria The svCfgGeometria entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgGeometria $svCfgGeometria)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svcfggeometria_delete', array('id' => $svCfgGeometria->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

     /**
     * datos para select 2
     *
     * @Route("/select", name="geometria_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $geometrias = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgGeometria')->findBy(
        array('activo' => 1)
    );
    $response = null;

      foreach ($geometrias as $key => $geometria) {
        $response[$key] = array(
            'value' => $geometria->getId(),
            'label' => $geometria->getNombre(),
            );
      }
       return $helpers->json($response);
    }
}
