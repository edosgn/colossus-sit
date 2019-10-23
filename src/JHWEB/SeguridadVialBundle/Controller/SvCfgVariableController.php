<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgVariable;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgvariable controller.
 *
 * @Route("svcfgvariable")
 */
class SvCfgVariableController extends Controller
{
    /**
     * Lists all svCfgVariable entities.
     *
     * @Route("/", name="svcfgvariable_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $variables = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgVariable')->findBy(
            array(
                'activo' => 1
            )
        );

        $response = array(
            'title' => 'Perfecto!',
            'status' => 'success',
            'code' => 200,
            'message' => "listado variables",
            'data' => $variables,
        );

        return $helpers ->json($response);
    }

    /**
     * Creates a new svCfgVariable entity.
     *
     * @Route("/new", name="svcfgvariable_new")
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
            
            $parametro = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgParametro')->find($params->idParametro);

            $variable = new SvCfgVariable();
            $variable->setNombre(strtoupper($params->nombre));
            $variable->setParametro($parametro);
            $variable->setActivo(true);

            $em->persist($variable);
            $em->flush();

            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Los datos han sido registrados exitosamente.",
            );
        } else {
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Finds and displays a svCfgVariable entity.
     *
     * @Route("/show", name="svcfgvariable_show")
     * @Method("GET")
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

            $variable = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgVariable')->find($params->id);

            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Variable con nombre"." ".$variable->getNombre(), 
                'data'=> $variable,
            );
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
            );
        }
        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing svCfgVariable entity.
     *
     * @Route("/edit", name="svcfgvariable_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            
            $variable = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgVariable')->find($params->id);

            if ($variable != null) {
                $parametro = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgParametro')->find($params->idParametro);

                $variable->setNombre(strtoupper($params->nombre));
                $variable->setParametro($parametro);

                $em->persist($variable);
                $em->flush();

                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $variable,
                );
            } else {
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos",
                );
            }
        } else {
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida para editar",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Deletes a svCfgVariable entity.
     *
     * @Route("/delete", name="svcfgvariable_delete")
     * @Method({"GET","POST"})
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", true);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();

            $variable = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgVariable')->find($params->id);

            $variable->setActivo(false);

            $em->persist($variable);
            $em->flush();

            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Registro eliminado con éxito.",
            );
        } else {
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no válida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="svcfgvariable_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $variables = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgVariable')->findBy(
            array(
                'activo' => true
            )
        );
        $response = null;

        foreach ($variables as $key => $variable) {
            $response[$key] = array(
                'value' => $variable->getId(),
                'label' => $variable->getNombre(),
                );
        }
        return $helpers->json($response);
    }
}
