<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgTipoControlesTransito;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgtipocontrolestransito controller.
 *
 * @Route("svcfgtipocontrolestransito")
 */
class SvCfgTipoControlesTransitoController extends Controller
{
    /**
     * Lists all svCfgTipoControlesTransito entities.
     *
     * @Route("/", name="svcfgtipocontrolestransito_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $tiposControlTransito = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTipoControlesTransito')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($tiposControlTransito) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($tiposControlTransito) . " registros encontrados",
                'data' => $tiposControlTransito,
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a new svCfgTipoControlesTransito entity.
     *
     * @Route("/new", name="svcfgtipocontrolestransito_new")
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

            $tipoControlTransito = new SvCfgTipoControlesTransito();

            $em = $this->getDoctrine()->getManager();

            $tipoControlTransito->setNombre($params->nombre);
            $tipoControlTransito->setActivo(true);
            $em->persist($tipoControlTransito);
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
     * Finds and displays a svCfgTipoControlesTransito entity.
     *
     * @Route("/{id}/show", name="svcfgtipocontrolestransito_show")
     * @Method("GET")
     */
    public function showAction(SvCfgTipoControlesTransito $svCfgTipoControlesTransito)
    {
        $deleteForm = $this->createDeleteForm($svCfgTipoControlesTransito);
        return $this->render('svCfgTipoControlesTransito/show.html.twig', array(
            'svCfgTipoControlesTransito' => $svCfgTipoControlesTransito,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing svCfgTipoControlesTransito entity.
     *
     * @Route("/edit", name="svcfgtipocontrolestransito_edit")
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
            $tipoControlTransito = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTipoControlesTransito')->find($params->id);

            if ($tipoControlTransito != null) {
                $tipoControlTransito->setNombre($params->nombre);

                $em->persist($tipoControlTransito);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $tipoControlTransito,
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
     * Deletes a svCfgTipoControlesTransito entity.
     *
     * @Route("/delete", name="svcfgtipocontrolestransito_delete")
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

            $tipoControlTransito = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTipoControlesTransito')->find($params->id);

            $tipoControlTransito->setActivo(false);

            $em->persist($tipoControlTransito);
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
     * Creates a form to delete a svCfgTipoControlesTransito entity.
     *
     * @param SvCfgTipoControlesTransito $svCfgTipoControlesTransito The svCfgTipoControlesTransito entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgTipoControlesTransito $svCfgTipoControlesTransito)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svcfgtipocontrolestransito_delete', array('id' => $svCfgTipoControlesTransito->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="svcfgtipocontrolestransito_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $tiposControlTransito = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTipoControlesTransito')->findBy(
            array('activo' => 1)
        );
        foreach ($tiposControlTransito as $key => $tipoControlTransito) {
            $response[$key] = array(
                'value' => $tipoControlTransito->getId(),
                'label' => $tipoControlTransito->getNombre(),
            );
        }
        return $helpers->json($response);
    }

}
