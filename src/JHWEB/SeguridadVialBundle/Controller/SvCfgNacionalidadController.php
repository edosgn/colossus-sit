<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgNacionalidad;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgnacionalidad controller.
 *
 * @Route("svcfgnacionalidad")
 */
class SvCfgNacionalidadController extends Controller
{
    /**
     * Lists all svCfgNacionalidad entities.
     *
     * @Route("/", name="svcfgnacionalidad_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $nacionalidades = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgNacionalidad')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($nacionalidades) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($nacionalidades) . " registros encontrados",
                'data' => $nacionalidades,
            );
        }
        return $helpers->json($response);

    }

    /**
     * Creates a new SvCfgNacionalidad entity.
     *
     * @Route("/new", name="svcfgnacionalidad_new")
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

            $nacionalidad = new SvCfgNacionalidad();

            $em = $this->getDoctrine()->getManager();

            $nacionalidad->setNombre($params->nombre);
            $nacionalidad->setActivo(true);
            $em->persist($nacionalidad);
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
     * Finds and displays a svCfgNacionalidad entity.
     *
     * @Route("/{id}/show", name="svcfgnacionalidad_show")
     * @Method("GET")
     */
    public function showAction(SvCfgNacionalidad $svCfgNacionalidad)
    {
        $deleteForm = $this->createDeleteForm($svCfgNacionalidad);
        return $this->render('svCfgNacionalidad/show.html.twig', array(
            'svCfgNacionalidad' => $svCfgNacionalidad,
            'delete_form' => $deleteForm->createView(),
        ));

    }

    /**
     * Displays a form to edit an existing SvCfgNacionalidad entity.
     *
     * @Route("/edit", name="svcfgnacionalidad_edit")
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
            $nacionalidad = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgNacionalidad')->find($params->id);

            if ($nacionalidad != null) {
                $nacionalidad->setNombre($params->nombre);

                $em->persist($nacionalidad);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $nacionalidad,
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
     * Deletes a SvCfgNacionalidad entity.
     *
     * @Route("/delete", name="svcfgnacionalidad_delete")
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

            $nacionalidad = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgNacionalidad')->find($params->id);

            $nacionalidad->setActivo(false);

            $em->persist($nacionalidad);
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
     * Creates a form to delete a SvCfgNacionalidad entity.
     *
     * @param SvCfgNacionalidad $svCfgNacionalidad The SvCfgNacionalidad entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgNacionalidad $svCfgNacionalidad)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svCfgnacionalidad_delete', array('id' => $svCfgNacionalidad->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="nacionalidad_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $nacionalidades = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgNacionalidad')->findBy(
            array('activo' => 1)
        );
        $response = null;

        foreach ($nacionalidades as $key => $nacionalidad) {
            $response[$key] = array(
                'value' => $nacionalidad->getId(),
                'label' => $nacionalidad->getNombre(),
            );
        }
        return $helpers->json($response);
    }
}
