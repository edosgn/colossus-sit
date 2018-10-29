<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgTipoControl;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * Svcfgtipocontrol controller.
 *
 * @Route("svcfgtipocontrol")
 */
class SvCfgTipoControlController extends Controller
{
    /**
     * Lists all svCfgTipoControl entities.
     *
     * @Route("/", name="svcfgtipocontrol_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $tiposControl = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTipoControl')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($tiposControl) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($tiposControl) . " registros encontrados",
                'data' => $tiposControl,
            );
        }
        return $helpers->json($response);

    }

    /**
     * Creates a new svCfgTipoControl entity.
     *
     * @Route("/new", name="svcfgtipocontrol_new")
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
            
            $tipoControl = new SvCfgTipoControl();

            $em = $this->getDoctrine()->getManager();

            $tipoControl->setNombre($params->nombre);
            $tipoControl->setActivo(true);
            $em->persist($tipoControl);
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
     * Finds and displays a svCfgTipoControl entity.
     *
     * @Route("/{id}/show", name="svcfgtipocontrol_show")
     * @Method("GET")
     */
    public function showAction(SvCfgTipoControl $svCfgTipoControl)
    {
        $deleteForm = $this->createDeleteForm($svCfgTipoControl);
        return $this->render('svCfgTipoControl/show.html.twig', array(
            'svCfgTipoControl' => $svCfgTipoControl,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing svCfgTipoControl entity.
     *
     * @Route("/edit", name="svcfgtipocontrol_edit")
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
            $tipoControl = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTipoControl')->find($params->id);

            if ($tipoControl != null) {
                $tipoControl->setNombre($params->nombre);

                $em->persist($tipoControl);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $tipoControl,
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
     * Deletes a SvCfgTipoControl entity.
     *
     * @Route("/delete", name="svcfgtipocontrol_delete")
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

            $tipoControl = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTipoControl')->find($params->id);

            $tipoControl->setActivo(false);

            $em->persist($tipoControl);
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
     * Creates a form to delete a SvCfgTipoControl entity.
     *
     * @param SvCfgTipoControl $svCfgTipoControl The SvCfgTipoControl entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgTipoControl $svCfgTipoControl)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svCfgTipoControl_delete', array('id' => $svCfgTipoControl->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="tipocontrol_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $tiposControl = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTipoControl')->findBy(
        array('activo' => 1)
    );
    $response = null;

      foreach ($tiposControl as $key => $tipoControl) {
        $response[$key] = array(
            'value' => $tipoControl->getId(),
            'label' => $tipoControl->getNombre(),
            );
      }
       return $helpers->json($response);
    }
}
