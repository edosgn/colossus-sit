<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgGravedadAccidente;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfggravedadaccidente controller.
 *
 * @Route("svcfggravedadaccidente")
 */
class SvCfgGravedadAccidenteController extends Controller
{
    /**
     * Lists all svCfgGravedadAccidente entities.
     *
     * @Route("/", name="svcfggravedadaccidente_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $cfgGravedades = $em->getRepository('JHWEBSefuridadVialBundle:SvCfgGravedadAccidente')->findBy(
            array('activo' => true)
        );
        $response = array(
            'status' => 'success',
            'code' => 200,
            'message' => "listado gravedad",
            'data' => $cfgGravedades,
        );

        return $helpers->json($response);
    }

    /**
     * Creates a new svCfgGravedadAccidente entity.
     *
     * @Route("/new", name="svcfggravedadaacidente_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $cfgGravedad = new SvCfgGravedadAccidente();

            $cfgGravedad->setNombre(strtoupper($params->nombre));
            $cfgGravedad->setActivo(true);

            $em->persist($cfgGravedad);
            $em->flush();
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "Gravedad creado con exito",
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida",
            );
        }
        return $helpers->json($response);

    }

    /**
     * Finds and displays a cfgGravedad entity.
     *
     * @Route("/show", name="svcfggravedadaccidente_show")
     * @Method("POST")
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        
        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();

            $cfgGravedad = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgGravedadAccidente')->find($params->id);
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Gravedad encontrado",
                'data' => $cfgGravedad,
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
     * Displays a form to edit an existing cfgGravedad entity.
     *
     * @Route("/edit", name="cfggravedad_edit")
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
            $cfgGravedad = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgGravedadAccidente')->find($params->id);

            if ($cfgGravedad != null) {

                $cfgGravedad->setNombre($params->nombre);
                $cfgGravedad->setActivo(true);

                $em->persist($cfgGravedad);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "gravedad editada con exito",
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "La gravedad no se encuentra en la base de datos",
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida para editar banco",
            );
        }

        return $helpers->json($response);

    }

    /**
     * Deletes a svCfgGravedadAccidente entity.
     *
     * @Route("/delete", name="svcfggravedadaccidente_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();

            $cfgGravedad = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgGravedadAccidente')->find($params->id);

            $cfgGravedad->setActivo(false);
            $em = $this->getDoctrine()->getManager();
            $em->persist($cfgGravedad);
            $em->flush();
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro eliminado con exito",
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
     * datos para select 2
     *
     * @Route("/select", name="svcfggravedadaccidente_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");

    $em = $this->getDoctrine()->getManager();
    $cfgGravedades = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgGravedadAccidente')->findBy(
        array('activo' => 1)
    );

    $response = null;
    
    foreach ($cfgGravedades as $key => $cfgGravedad) {
        $response[$key] = array(
            'value' => $cfgGravedad->getId(),
            'label' => $cfgGravedad->getNombre(),
        );
      }
       return $helpers->json($response);
    }
}
