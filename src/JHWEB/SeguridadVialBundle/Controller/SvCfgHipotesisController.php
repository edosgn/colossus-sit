<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgHipotesis;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfghipotesi controller.
 *
 * @Route("svcfghipotesis")
 */
class SvCfgHipotesisController extends Controller
{
    /**
     * Lists all svCfgHipotesis entities.
     *
     * @Route("/", name="svcfghipotesis_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $svCfgHipotesis = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgHipotesis')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($svCfgHipotesis) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($svCfgHipotesis) . " registros encontrados",
                'data' => $svCfgHipotesis,
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a new svCfgHipotesis entity.
     *
     * @Route("/new", name="svcfghipotesis_new")
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

            $hipotesis = new SvCfgHipotesis();

            $em = $this->getDoctrine()->getManager();

            $hipotesis->setNombre($params->nombre);
            $hipotesis->setActivo(true);
            $em->persist($hipotesis);
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
     * Finds and displays a svCfgHipotesis entity.
     *
     * @Route("/{id}/show", name="svcfghipotesis_show")
     * @Method("GET")
     */
    public function showAction(SvCfgHipotesis $svCfgHipotesis)
    {
        $deleteForm = $this->createDeleteForm($svCfgHipotesis);
        return $this->render('svCfgHipotesis/show.html.twig', array(
            'svCfgHipotesis' => $svCfgHipotesis,
            'delete_form' => $deleteForm->createView(),
        ));

    }
    /**
     * Displays a form to edit an existing svCfgHipotesis entity.
     *
     * @Route("/edit", name="svcfghipotesis_edit")
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
            $hipotesis = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgHipotesis')->find($params->id);

            if ($hipotesis != null) {
                $hipotesis->setNombre($params->nombre);

                $em->persist($hipotesis);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $hipotesis,
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
     * Deletes a svCfgHipotesis entity.
     *
     * @Route("/delete", name="svcfghipotesis_delete")
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

            $hipotesis = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgHipotesis')->find($params->id);

            $hipotesis->setActivo(false);

            $em->persist($hipotesis);
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
     * Creates a form to delete a svCfgHipotesis entity.
     *
     * @param SvCfgHipotesis $svCfgHipotesis The svCfgHipotesis entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgHipotesis $svCfgHipotesis)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svcfghipotesis_delete', array('id' => $svCfgHipotesis->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="hipotesis_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $svCfgHipotesis = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgHipotesis')->findBy(
            array('activo' => 1)
        );
        $response = null;

        foreach ($svCfgHipotesis as $key => $hipotesis) {
            $response[$key] = array(
                'value' => $hipotesis->getId(),
                'label' => $hipotesis->getNombre(),
            );
        }
        return $helpers->json($response);
    }
}
