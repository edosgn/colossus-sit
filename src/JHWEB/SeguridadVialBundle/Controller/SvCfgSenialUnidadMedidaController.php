<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgSenialUnidadMedida;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgsenialunidadmedida controller.
 *
 * @Route("svcfgsenialunidadmedida")
 */
class SvCfgSenialUnidadMedidaController extends Controller
{
    /**
     * Lists all svCfgSenialUnidadMedida entities.
     *
     * @Route("/", name="svcfgsenialunidadmedida_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $unidadesMedida = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenialUnidadMedida')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($unidadesMedida) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($unidadesMedida)." registros encontrados", 
                'data'=> $unidadesMedida,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new svCfgSenialUnidadMedida entity.
     *
     * @Route("/new", name="svcfgsenialunidadmedida_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);
           
            $unidadMedida = new SvCfgSenialUnidadMedida();

            $unidadMedida->setNombre(mb_strtoupper($params->nombre, 'utf-8'));
            $unidadMedida->setActivo(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($unidadMedida);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con exito",
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Finds and displays a svCfgSenialUnidadMedida entity.
     *
     * @Route("/show", name="svcfgsenialunidadmedida_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $unidadMedida = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenialUnidadMedida')->find(
                $params->id
            );

            if ($unidadMedida) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado", 
                    'data'=> $unidadMedida,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos",
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorizacion no valida", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing svCfgSenialUnidadMedida entity.
     *
     * @Route("/edit", name="svcfgsenialunidadmedida_edit")
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

            $unidadMedida = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenialUnidadMedida')->find($params->id);

            if ($unidadMedida) {
                $unidadMedida->setNombre(mb_strtoupper($params->nombre, 'utf-8'));

                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $unidadMedida,
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
     * Deletes a svCfgSenialUnidadMedida entity.
     *
     * @Route("/delete", name="svcfgsenialunidadmedida_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $unidadMedida = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenialUnidadMedida')->find(
                $params->id
            );

            if ($unidadMedida) {
                $unidadMedida->setActivo(false);

                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro eliminado con exito"
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos",
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorizacion no valida", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a svCfgSenialUnidadMedida entity.
     *
     * @param SvCfgSenialUnidadMedida $svCfgSenialUnidadMedida The svCfgSenialUnidadMedida entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgSenialUnidadMedida $svCfgSenialUnidadMedida)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svcfgsenialunidadmedida_delete', array('id' => $svCfgSenialUnidadMedida->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* =================================================== */

    /**
     * datos para select 2
     *
     * @Route("/select", name="svcfgsenialunidadmedida_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $unidadesMedida = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenialUnidadMedida')->findBy(
            array('activo' => 1)
        );

        $response = null;

        foreach ($unidadesMedida as $key => $unidadMedida) {
            $response[$key] = array(
                'value' => $unidadMedida->getId(),
                'label' => $unidadMedida->getNombre(),
            );
        }

        return $helpers->json($response);
    }
}
