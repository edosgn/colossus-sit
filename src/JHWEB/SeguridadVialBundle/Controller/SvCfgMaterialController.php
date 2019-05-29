<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgMaterial;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgmaterial controller.
 *
 * @Route("svcfgmaterial")
 */
class SvCfgMaterialController extends Controller
{
    /**
     * Lists all svCfgMaterial entities.
     *
     * @Route("/", name="svcfgmaterial_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $materiales = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgMaterial')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($materiales) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($materiales) . " registros encontrados",
                'data' => $materiales,
            );
        }
        return $helpers->json($response);

    }

    /**
     * Creates a new svCfgMaterial entity.
     *
     * @Route("/new", name="svcfgmaterial_new")
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

            $material = new SvCfgMaterial();

            $em = $this->getDoctrine()->getManager();

            $material->setNombre(strtoupper($params->nombre));
            $material->setActivo(true);
            $em->persist($material);
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
     * Finds and displays a svCfgMaterial entity.
     *
     * @Route("/{id}/show", name="svcfgmaterial_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(SvCfgMaterial $svCfgMaterial)
    {
        $deleteForm = $this->createDeleteForm($svCfgMaterial);
        return $this->render('svCfgMaterial/show.html.twig', array(
            'svCfgMaterial' => $svCfgMaterial,
            'delete_form' => $deleteForm->createView(),
        ));

    }

    /**
     * Displays a form to edit an existing svCfgMaterial entity.
     *
     * @Route("/edit", name="svcfgmaterial_edit")
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
            $material = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgMaterial')->find($params->id);

            if ($material != null) {

                $material->setNombre(strtoupper($params->nombre));

                $em->persist($material);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $material,
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
     * Deletes a svCfgMaterial entity.
     *
     * @Route("/delete", name="svcfgmaterial_delete")
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

            $material = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgMaterial')->find($params->id);

            $material->setActivo(false);

            $em->persist($material);
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
     * Creates a form to delete a svCfgMaterial entity.
     *
     * @param SvCfgMaterial $svCfgMaterial The svCfgMaterial entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgMaterial $svCfgMaterial)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svcfgmaterial_delete', array('id' => $svCfgMaterial->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="material_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $materiales = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgMaterial')->findBy(
            array('activo' => 1)
        );
        $response = null;

        foreach ($materiales as $key => $material) {
            $response[$key] = array(
                'value' => $material->getId(),
                'label' => $material->getNombre(),
            );
        }
        return $helpers->json($response);
    }
}
