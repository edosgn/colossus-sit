<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgRequiereEmpresa;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgrequiereempresa controller.
 *
 * @Route("svcfgrequiereempresa")
 */
class SvCfgRequiereEmpresaController extends Controller
{
    /**
     * Lists all svCfgRequiereEmpresa entities.
     *
     * @Route("/", name="svcfgrequiereempresa_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $requierenEmpresa = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgRequiereEmpresa')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($requierenEmpresa) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($requierenEmpresa) . " registros encontrados",
                'data' => $requierenEmpresa,
            );
        }
        return $helpers->json($response);

    }

    /**
     * Creates a new svCfgRequiereEmpresa entity.
     *
     * @Route("/new", name="svcfgrequiereempresa_new")
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

            $requiereEmpresa = new SvCfgRequiereEmpresa();

            $em = $this->getDoctrine()->getManager();

            if ($params->carroceria) {
                $carroceria = $em->getRepository('AppBundle:Carroceria')->find(
                    $params->carroceria
                );
                $requiereEmpresa->setCarroceria($carroceria);
            }

            $requiereEmpresa->setNombre($params->nombre);
            $requiereEmpresa->setActivo(true);
            $em->persist($requiereEmpresa);
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
     * Finds and displays a svCfgRequiereEmpresa entity.
     *
     * @Route("/show", name="svcfgrequiereempresa_show")
     * @Method("GET")
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $requiereEmpresa = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgRequiereEmpresa')->find(
                $params->id
            );

            $em->persist($requiereEmpresa);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro encontrado con exito",
                'data' => $requiereEmpresa,
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida",
            );
        }
        return $helpers->json($response);

    }

    /**
     * Displays a form to edit an existing svCfgRequiereEmpresa entity.
     *
     * @Route("/edit", name="svcfgrequiereempresa_edit")
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
            $requiereEmpresa = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgRequiereEmpresa')->find($params->id);
            $carroceria = $em->getRepository('AppBundle:Carroceria')->find($params->carroceria);
            

            if ($requiereEmpresa != null) {
                $requiereEmpresa->setNombre($params->nombre);
                $requiereEmpresa->setCarroceria($carroceria);

                $em->persist($requiereEmpresa);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $requiereEmpresa,
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
     * Deletes a svCfgRequiereEmpresa entity.
     *
     * @Route("/delete", name="svCfgrequiereempresa_delete")
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

            $requiereEmpresa = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgRequiereEmpresa')->find($params->id);

            $requiereEmpresa->setActivo(false);

            $em->persist($requiereEmpresa);
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
     * Creates a form to delete a svCfgRequiereEmpresa entity.
     *
     * @param SvCfgRequiereEmpresa $svCfgRequiereEmpresa The svCfgRequiereEmpresa entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgRequiereEmpresa $svCfgRequiereEmpresa)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svcfgrequiereempresa_delete', array('id' => $svCfgRequiereEmpresa->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="requiereempresa_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $requierenEmpresa = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgRequiereEmpresa')->findBy(
            array('activo' => 1)
        );
        foreach ($requierenEmpresa as $key => $requiereEmpresa) {
            $response[$key] = array(
                'value' => $requiereEmpresa->getId(),
                'label' => $requiereEmpresa->getNombre(),
            );
        }
        return $helpers->json($response);
    }
}
