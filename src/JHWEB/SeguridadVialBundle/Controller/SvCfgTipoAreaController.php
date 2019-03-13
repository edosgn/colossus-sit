<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgTipoArea;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * Svcfgtipoarea controller.
 *
 * @Route("svcfgtipoarea")
 */
class SvCfgTipoAreaController extends Controller
{
    /**
     * Lists all svCfgTipoArea entities.
     *
     * @Route("/", name="svcfgtipoarea_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $tiposAreas = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTipoArea')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($tiposAreas) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($tiposAreas) . " registros encontrados",
                'data' => $tiposAreas,
            );
        }
        return $helpers->json($response);

    }

    /**
     * Finds and displays a svCfgTipoArea entity.
     *
     * @Route("/{id}/show", name="svcfgtipoarea_show")
     * @Method("GET")
     */
    public function showAction(SvCfgTipoArea $svCfgTipoArea)
    {
        $deleteForm = $this->createDeleteForm($svCfgTipoArea);
        return $this->render('svCfgTipoArea/show.html.twig', array(
            'svCfgTipoArea' => $svCfgTipoArea,
            'delete_form' => $deleteForm->createView(),
        ));

    }

    /**
     * Creates a new svCfgTipoArea entity.
     *
     * @Route("/new", name="svcfgtipoarea_new")
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
            
            $tipoArea = new SvCfgTipoArea();

            $em = $this->getDoctrine()->getManager();

            $tipoArea->setNombre(strtoupper($params->nombre));
            $tipoArea->setActivo(true);
            $em->persist($tipoArea);
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
     * Displays a form to edit an existing svCfgTipoArea entity.
     *
     * @Route("/edit", name="svcfgtipoarea_edit")
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
            $tipoArea = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTipoArea')->find($params->id);

            if ($tipoArea != null) {
                
                $tipoArea->setNombre(strtoupper($params->nombre));

                $em->persist($tipoArea);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $tipoArea,
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
     * Deletes a svCfgTipoArea entity. 
     * @Route("/delete", name="svcfgtipoarea_delete")
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

            $tipoArea = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTipoArea')->find($params->id);

            $tipoArea->setActivo(false);

            $em->persist($tipoArea);
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
     * Creates a form to delete a svCfgTipoArea entity. 
     * @param SvCfgTipoArea $svCfgTipoArea The svcfgtipoarea entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgTipoArea $svCfgTipoArea)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svcfgtipoarea_delete', array('id' => $svCfgTipoArea->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="svcfgtipoarea_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $tiposAreas = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTipoArea')->findBy(
            array('activo' => 1)
        );
        $response = null;

        foreach ($tiposAreas as $key => $tipoArea) {
            $response[$key] = array(
                'value' => $tipoArea->getId(),
                'label' => $tipoArea->getNombre(),
                );
        }
        return $helpers->json($response);
    }
}
