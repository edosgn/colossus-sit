<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloCfgColor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlocfgcolor controller.
 *
 * @Route("vhlocfgcolor")
 */
class VhloCfgColorController extends Controller
{
    /**
     * Lists all vhloCfgColor entities.
     *
     * @Route("/", name="vhlocfgcolor_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $colores = $em->getRepository('JHWEBVehiculoBundle:VhloCfgColor')->findBy(
            array('activo' => 1)
        );
        $response = array(
            'status' => 'success',
            'code' => 200,
            'message' => "listado colores",
            'data' => $colores,
        );

        return $helpers->json($response);
    }

    /**
     * @Route("/{page}/color/pagination/all", name="vhlocfgcolor_list_all")
     * @Method({"GET", "POST"})
     */

    public function listAction(Request $request, $page)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $dql   = "SELECT c FROM JHWEBVehiculoBundle:VhloCfgColor c WHERE c.activo = true";
            
            $query = $em->createQuery($dql);

            $paginator  = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $query, /* query NOT result */
                $request->query->getInt('page', $page), /*page number*/
                8 /*limit per page*/
            );

            // parameters to template
            $response = array(
                'status' => "success",
                'code' => 200,
                'data' => $pagination,
                'cant' => count($pagination)
                );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida.",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a new Color entity.
     *
     * @Route("/new", name="vhlocfgcolor_new")
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
            $color = $em->getRepository('JHWEBVehiculoBundle:VhloCfgColor')->findOneByNombre($params->nombre);

            if ($color == null) {
                $color = new VhloCfgColor();

                $color->setNombre(mb_strtoupper($params->nombre, 'utf-8'));
                $color->setActivo(true);

                $em->persist($color);
                $em->flush();
                
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro creado con éxito",
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El nombre del color ya se encuentra registrado",
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida.",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Finds and displays a vhloCfgColor entity.
     *
     * @Route("/show", name="vhlocfgcolor_show")
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

            $color = $em->getRepository('JHWEBVehiculoBundle:VhloCfgColor')->find(
                $params->id
            );

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Registro encontrado con exito.',
                'data' => $color
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
     * Displays a form to edit an existing Color entity.
     *
     * @Route("/edit", name="vhlocfgcolor_edit")
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
            $color = $em->getRepository('JHWEBVehiculoBundle:VhloCfgColor')->find($params->id);
            if ($color!=null) {

                $color->setNombre(mb_strtoupper($params->nombre, 'utf-8'));
               
                $em->persist($color);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro editado con éxito", 
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
                    'message' => "Autorización no válida.", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a Color entity.
     *
     * @Route("/delete", name="vhlocfgcolor_delete")
     * @Method({"GET", "POST"})
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
            
            $color = $em->getRepository('JHWEBVehiculoBundle:VhloCfgColor')->find($params->id);
            
            $color->setActivo(false);
            
            $em->persist($color);
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
     * Creates a form to delete a VhloCfgColor entity.
     *
     * @param VhloCfgColor $vhloCfgColor The VhloCfgColor entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloCfgColor $vhloCfgColor)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhlocfgcolor_delete', array('id' => $vhloCfgColor->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="vhlocfgcolor_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $colors = $em->getRepository('JHWEBVehiculoBundle:VhloCfgColor')->findBy(
        array('activo' => 1)
    );
    $response = null;

    foreach ($colors as $key => $color) {
        $response[$key] = array(
            'value' => $color->getId(),
            'label' => $color->getNombre(),
        );
      }
       return $helpers->json($response);
    }


    /**
     * Deletes a Color entity.
     *
     * @Route("/prueba", name="vhlocfgcolor_prueba")
     * @Method({"GET", "POST"})
     */
    public function pruebaAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();          
            
            var_dump($params);
            die();
            $color = $em->getRepository('JHWEBVehiculoBundle:VhloCfgColor')->find($params->id);
            
            $color->setActivo(false);
            
            $em->persist($color);
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
}
