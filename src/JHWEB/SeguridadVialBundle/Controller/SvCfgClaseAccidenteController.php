<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgClaseAccidente;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgclaseaccidente controller.
 *
 * @Route("svcfgclaseaccidente")
 */
class SvCfgClaseAccidenteController extends Controller
{
    /**
     * Lists all svCfgClaseAccidente entities.
     *
     * @Route("/", name="svcfgclaseaccidente_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $clasesAccidente = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgClaseAccidente')->findBy(
            array('activo' => true)
        );

        $response = array(
            'status' => 'success',
            'code' => 200,
            'message' => count($clasesAccidente) . " registros encontrados",
            'data' => $clasesAccidente,
        );

        return $helpers->json($response);
    }

    /**
     * Creates a new svCfgClaseAccidente entity.
     *
     * @Route("/new", name="svcfgclaseaccidente_new")
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

            $svCfgClaseAccidente = new SvCfgClaseAccidente();

            $svCfgClaseAccidente->setNombre(mb_strtoupper($params->nombre, 'utf-8'));
            $svCfgClaseAccidente->setActivo(true);

            $em->persist($svCfgClaseAccidente);
            $em->flush();
            
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Nuevo registro creado con éxito",
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
     * Finds and displays a svCfgClaseAccidente entity.
     *
     * @Route("/show", name="svcfgclaseaccidente_show")
     * @Method("POST")
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $svCfgClaseAccidente = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgClaseAccidente')->find(
                $params->id
            );

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Registro encontrado con exito.',
                'data' => $svCfgClaseAccidente
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida.', 
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing svCfgClaseAccidente entity.
     *
     * @Route("/{id}/edit", name="svcfgclaseaccidente_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            $svCfgClaseAccidente = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgClaseAccidente')->find($params->id);

            if ($svCfgClaseAccidente!=null) {
                $svCfgClaseAccidente->setNombre($params->nombre);
                $svCfgClaseAccidente->setActivo(true);
                $em->persist($svCfgClaseAccidente);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito.", 
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
                    'msj' => "Autorizacion no valida para editar.", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a svCfgClaseAccidente entity.
     *
     * @Route("/delete", name="svcfgclaseaccidente_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            $svCfgClaseAccidente = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgClaseAccidente')->find($params->id);

            $svCfgClaseAccidente->setActivo(0);
            $em->persist($svCfgClaseAccidente);
            $em->flush();
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro eliminado con éxito", 
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida", 
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a svCfgClaseAccidente entity.
     *
     * @param SvCfgClaseAccidente $svCfgClaseAccidente The svCfgClaseAccidente entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgClaseAccidente $svCfgClaseAccidente)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svcfgclaseaccidente_delete', array('id' => $svCfgClaseAccidente->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="svcfgclaseaccidente_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $svCfgClaseAccidente = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgClaseAccidente')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($svCfgClaseAccidente as $key => $svCfgClaseAccidente) {
            $response[$key] = array(
                'value' => $svCfgClaseAccidente->getId(),
                'label' => $svCfgClaseAccidente->getNombre(),
            );
        }
        return $helpers->json($response);
    }
}



