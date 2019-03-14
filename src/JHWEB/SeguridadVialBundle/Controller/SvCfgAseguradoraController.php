<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgAseguradora;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgaseguradora controller.
 *
 * @Route("svcfgaseguradora")
 */
class SvCfgAseguradoraController extends Controller
{
    /**
     * Lists all svCfgAseguradora entities.
     *
     * @Route("/", name="svcfgaseguradora_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $aseguradoras = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgAseguradora')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($aseguradoras) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($aseguradoras) . " registros encontrados",
                'data' => $aseguradoras,
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a new svCfgAseguradora entity.
     *
     * @Route("/new", name="svcfgaseguradora_new")
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
            
            $aseguradora = new SvCfgAseguradora();

            $em = $this->getDoctrine()->getManager();
            $aseguradora->setNombre(strtoupper($params->nombre));
            $aseguradora->setActivo(true);
            $em->persist($aseguradora);
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
     * Finds and displays a svCfgAseguradora entity.
     *
     * @Route("/{id}/show", name="svcfgaseguradora_show")
     * @Method("GET")
     */
    public function showAction(SvCfgAseguradora $svCfgAseguradora)
    {
        $deleteForm = $this->createDeleteForm($svCfgAseguradora);
        return $this->render('svCfgAseguradora/show.html.twig', array(
            'svCfgAseguradora' => $svCfgAseguradora,
            'delete_form' => $deleteForm->createView(),
        ));

    }

    /**
     * Displays a form to edit an existing SvCfgAseguradora entity.
     *
     * @Route("/edit", name="svcfgaseguradora_edit")
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
            $aseguradora = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgAseguradora')->find($params->id);

            if ($aseguradora != null) {
                $aseguradora->setNombre(strtoupper($params->nombre));

                $em->persist($aseguradora);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $aseguradora,
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
     * Deletes a SvCfgAseguradora entity.
     *
     * @Route("/delete", name="svcfgaseguradora_delete")
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

            $aseguradora = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgAseguradora')->find($params->id);

            $aseguradora->setActivo(false);

            $em->persist($aseguradora);
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
     * Creates a form to delete a SvCfgAseguradora entity.
     *
     * @param SvCfgAseguradora $svCfgAseguradora The SvCfgAseguradora entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgAseguradora $svCfgAseguradora)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('svCfgAseguradora_delete', array('id' => $svCfgAseguradora->getId())))
        ->setMethod('DELETE')
        ->getForm();
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="aseguradora_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $aseguradoras = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgAseguradora')->findBy(
            array('activo' => 1)
        );
        $response = null;
        foreach ($aseguradoras as $key => $aseguradora) {
            $response[$key] = array(
                'value' => $aseguradora->getId(),
                'label' => $aseguradora->getNombre(),
            );
        }
        return $helpers->json($response);
    }
}
