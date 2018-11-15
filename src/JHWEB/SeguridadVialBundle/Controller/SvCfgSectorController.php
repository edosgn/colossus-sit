<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgSector;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgsector controller.
 *
 * @Route("svcfgsector")
 */
class SvCfgSectorController extends Controller
{
    /**
     * Lists all svCfgSector entities.
     *
     * @Route("/", name="svcfgsector_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $sectores = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSector')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($sectores) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($sectores) . " registros encontrados",
                'data' => $sectores,
            );
        }
        return $helpers->json($response);

    }

    /**
     * Creates a new svCfgSector entity.
     *
     * @Route("/new", name="svcfgsector_new")
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

            $sector = new SvCfgSector();

            $em = $this->getDoctrine()->getManager();

            $nombre = strtoupper($params->nombre);

            $sector->setNombre($nombre);
            $sector->setActivo(true);
            $em->persist($sector);
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
     * Finds and displays a svCfgSector entity.
     *
     * @Route("/{id}/show", name="svcfgsector_show")
     * @Method("GET")
     */
    public function showAction(SvCfgSector $svCfgSector)
    {
        $deleteForm = $this->createDeleteForm($svCfgSector);
        return $this->render('svCfgSector/show.html.twig', array(
            'svCfgSector' => $svCfgSector,
            'delete_form' => $deleteForm->createView(),
        ));

    }

    /**
     * Displays a form to edit an existing svCfgSector entity.
     *
     * @Route("/edit", name="svcfgsector_edit")
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
            $sector = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSector')->find($params->id);

            if ($sector != null) {
                $nombre = strtoupper($params->nombre);

                $sector->setNombre($nombre);

                $em->persist($sector);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $sector,
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
     * Deletes a SvCfgSector entity.
     *
     * @Route("/delete", name="svcfgsector_delete")
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

            $sector = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSector')->find($params->id);

            $sector->setActivo(false);

            $em->persist($sector);
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
     * Creates a form to delete a SvCfgSector entity.
     *
     * @param SvCfgSector $svCfgsector The SvCfgSector entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgSector $svCfgSector)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svCfgsector_delete', array('id' => $svCfgSector->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="sector_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $sectores = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSector')->findBy(
            array('activo' => 1)
        );
        $response = null;

        foreach ($sectores as $key => $sector) {
            $response[$key] = array(
                'value' => $sector->getId(),
                'label' => $sector->getNombre(),
            );
        }
        return $helpers->json($response);
    }
}
