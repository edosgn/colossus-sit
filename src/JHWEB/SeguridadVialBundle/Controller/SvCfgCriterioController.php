<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgCriterio;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgcriterio controller.
 *
 * @Route("svcfgcriterio")
 */
class SvCfgCriterioController extends Controller
{
    /**
     * Lists all svCfgCriterio entities.
     *
     * @Route("/", name="svcfgcriterio_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $criterios = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgCriterio')->findBy(
            array(
                'activo' => true
            )
        );

        $response['data'] = array();

        if ($criterios) {
            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => count($criterios) . " registros encontrados",
                'data' => $criterios,
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a new svCfgCriterio entity.
     *
     * @Route("/new", name="svcfgcriterio_new")
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
            
            $criterio = new SvCfgCriterio();

            if ($params->idVariable) {
                $variable = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgVariable')->find(
                    $params->idVariable
                );
                $criterio->setVariable($variable);
            }

            $criterio->setNombre(strtoupper($params->nombre));
            $criterio->setActivo(true);

            $em->persist($criterio);
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
     * Finds and displays a svCfgCriterio entity.
     *
     * @Route("/show", name="svcfgcriterio_show")
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

            $criterio = $em->getRepository('JHWEBSeguridadVialBundle:MsvCategoria')->find($params->id);
            $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Categoria con nombre"." ".$categoria->getNombre(), 
                    'data'=> $categoria,
            );
        }else{
            $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorización no valida", 
                );
        }
        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing sCfgvCriterio entity.
     *
     * @Route("/edit", name="svcfgcriterio_edit")
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
            
            $criterio = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgCriterio')->find($params->id);
            $variable = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgVariable')->find($params->idVariable);

            if ($criterio != null) {

                $criterio->setNombre(strtoupper($params->nombre));
                $criterio->setVariable($variable);

                $em->persist($criterio);
                $em->flush();
                
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $criterio,
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
     * Deletes a svCfgCriterio entity.
     *
     * @Route("/delete", name="svcfgcriterio_delete")
     * @Method({"GET","POST"})
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", true);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $json = $request->get("data", null);
            $params = json_decode($json);

            $criterio = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgCriterio')->find($params->id);

            $criterio->setActivo(false);

            $em->persist($criterio);
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
}
