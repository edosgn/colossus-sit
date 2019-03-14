<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgLugarImpacto;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfglugarimpacto controller.
 *
 * @Route("svcfglugarimpacto")
 */
class SvCfgLugarImpactoController extends Controller
{
    /**
     * Lists all svCfgLugarImpacto entities.
     *
     * @Route("/", name="svcfglugarimpacto_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $lugaresImpacto = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgLugarImpacto')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($lugaresImpacto) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($lugaresImpacto) . " registros encontrados",
                'data' => $lugaresImpacto,
            );
        }
        return $helpers->json($response);

    }

    /**
     * Creates a new svCfgLugarImpacto entity.
     *
     * @Route("/new", name="svcfglugarimpacto_new")
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

            $lugarImpacto = new SvCfgLugarImpacto();

            $em = $this->getDoctrine()->getManager();

            $lugarImpacto->setNombre(strtoupper($params->nombre));
            $lugarImpacto->setActivo(true);
            $em->persist($lugarImpacto);
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
     * Finds and displays a svCfgLugarImpacto entity.
     *
     * @Route("/{id}/show", name="svcfglugarimpacto_show")
     * @Method("GET")
     */
    public function showAction(SvCfgLugarImpacto $svCfgLugarImpacto)
    {
        $deleteForm = $this->createDeleteForm($svCfgLugarImpacto);
        return $this->render('svCfgLugarImpacto/show.html.twig', array(
            'svCfgLugarImpacto' => $svCfgLugarImpacto,
            'delete_form' => $deleteForm->createView(),
        ));

    }

    /**
     * Displays a form to edit an existing svCfgLugarImpacto entity.
     *
     * @Route("/edit", name="svcfglugarimpacto_edit")
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
            $lugarImpacto = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgLugarImpacto')->find($params->id);

            if ($lugarImpacto != null) {

                $lugarImpacto->setNombre(strtoupper($params->nombre));

                $em->persist($lugarImpacto);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $lugarImpacto,
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
     * Deletes a svCfgLugarImpacto entity.
     *
     * @Route("/delete", name="svcfglugarimpacto_delete")
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

            $lugarImpacto = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgLugarImpacto')->find($params->id);

            $lugarImpacto->setActivo(false);

            $em->persist($lugarImpacto);
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
     * Creates a form to delete a svCfgLugarImpacto entity.
     *
     * @param SvCfgLugarImpacto $svCfgLugarImpacto The svCfgLugarImpacto entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgLugarImpacto $svCfgLugarImpacto)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svcfglugarimpacto_delete', array('id' => $svCfgLugarImpacto->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="impacto_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $lugaresImpacto = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgLugarImpacto')->findBy(
            array('activo' => 1)
        );
        $response = null;

        foreach ($lugaresImpacto as $key => $lugarImpacto) {
            $response[$key] = array(
                'value' => $lugarImpacto->getId(),
                'label' => $lugarImpacto->getNombre(),
                );
        }
        return $helpers->json($response);
        }
}
