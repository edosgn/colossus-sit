<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CfgLimitacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * CfgLimitacion controller.
 *
 * @Route("limitacion")
 */
class CfgLimitacionController extends Controller
{
    /**
     * Lists all limitacion entities.
     *
     * @Route("/", name="limitacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $limitacion = $em->getRepository('AppBundle:CfgLimitacion')->findBy(
            array('estado' => 1)
        );

        $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado limitaciones", 
                    'data'=> $limitacion,
            );
         
        return $helpers->json($response);
    }

    /**
     * Creates a new limitacion entity.
     *
     * @Route("/new", name="limitacion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck== true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

                $nombre = $params->nombre;

                $em = $this->getDoctrine()->getManager();
                $limitacion = $em->getRepository('AppBundle:CfgLimitacion')->findOneByNombre($params->nombre);

                if ($limitacion==null) {
                    $limitacion = new CfgLimitacion();
    
                    $limitacion->setNombre(strtoupper($nombre));
                    $limitacion->setEstado(true);
    
                    $em->persist($limitacion);
                    $em->flush();
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Limitacion creado con exito", 
                    );
                }else{
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'msj' => "El nombre del limitacion ya se encuentra registrado", 
                    );
                }

            //}
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida", 
            );
            } 
        return $helpers->json($response);
    }

    /**
     * Finds and displays a limitacion entity.
     *
     * @Route("/show/{id}", name="limitacion_show")
     * @Method("POST")
     */
    public function showAction(CfgLimitacion $limitacion)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $limitacion = $em->getRepository('AppBundle:CfgLimitacion')->find($id);
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "limitacion encontrado", 
                    'data'=> $limitacion,
            );
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing limitacion entity.
     *
     * @Route("/edit", name="limitacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $nombre = $params->nombre;
            $em = $this->getDoctrine()->getManager();
            $limitacion = $em->getRepository('AppBundle:CfgLimitacion')->find($params->id);
            if ($limitacion!=null) {

                $limitacion->setNombre($nombre);
                $limitacion->setEstado(true);
               
                $em->persist($limitacion);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Limitación editada con exito", 
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "La limitación no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar banco", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a limitacion entity.
     *
     * @Route("/{id}/delete", name="limitacion_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();            
            $limitacion = $em->getRepository('AppBundle:CfgLimitacion')->find($id);

            $limitacion->setEstado(0);
            $em = $this->getDoctrine()->getManager();
                $em->persist($limitacion);
                $em->flush();
            $response = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "Limitación eliminada con exito", 
                );
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a limitacion entity.
     *
     * @param CfgLimitacion $limitacion The limitacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgLimitacion $limitacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('limitacion_delete', array('id' => $limitacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 
     *
     * @Route("/select", name="limitacion_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $limitaciones = $em->getRepository('AppBundle:CfgLimitacion')->findBy(
        array('estado' => 1)
    );
      foreach ($limitaciones as $key => $limitacion) {
        $response[$key] = array(
            'value' => $limitacion->getId(),
            'label' => $limitacion->getNombre(),
            );
      }
       return $helpers->json($response);
    }
}
