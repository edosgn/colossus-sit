<?php

namespace JHWEB\ContravencionalBundle\Controller;

use JHWEB\ContravencionalBundle\Entity\CvRestriccion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cvlccfgrestriccion controller.
 *
 * @Route("cvrestriccion")
 */
class CvRestriccionController extends Controller
{
    /**
     * Lists all cvRestriccion entities.
     *
     * @Route("/", name="cvrestriccion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $restricciones = $em->getRepository('JHWEBContravencionalBundle:CvRestriccion')->findAll();

        $response['data'] = array();

        if ($restricciones) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($restricciones)." registros encontrados", 
                'data'=> $restricciones,
            );
        } 

        return $helpers->json($response);
    }

    /**
     * Creates a new cvRestriccion entity.
     *
     * @Route("/new", name="cvrestriccion_new")
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
           
            $restriccion = new CvRestriccion();

            $restriccion->setDescripcion($params->descripcion);
            $restriccion->setActivo(true);

            $em = $this->getDoctrine()->getManager();
            
            $em->persist($restriccion);
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
     * Finds and displays a cvRestriccion entity.
     *
     * @Route("/show", name="cvrestriccion_show")
     * @Method("GET")
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

            $restriccion = $em->getRepository('JHWEBContravencionalBundle:CvRestriccion')->find(
                $params->id
            );

            if ($restriccion) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado", 
                    'data'=> $restriccion,
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
     * Displays a form to edit an existing cvRestriccion entity.
     *
     * @Route("/edit", name="cvrestriccion_edit")
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

            $restriccion = $em->getRepository("JHWEBContravencionalBundle:CvRestriccion")->find(
                $params->id
            );

            if ($restriccion) {
                $restriccion->setDescripcion($params->descripcion);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $restriccion,
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
                    'message' => "Autorizacion no valida para editar", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a cvRestriccion entity.
     *
     * @Route("/delete", name="cvrestriccion_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if($authCheck == true){
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $restriccion = $em->getRepository('JHWEBContravencionalBundle:CvRestriccion')->find(
                $params->id
            );
            $restriccion->setActivo(false);

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
                'message' => "Autorización no valida", 
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a cvRestriccion entity.
     *
     * @param CvRestriccion $cvRestriccion The cvRestriccion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CvRestriccion $cvRestriccion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cvrestriccion_delete', array('id' => $cvRestriccion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ============================================== */

    /**
     * datos para select 2
     *
     * @Route("/select", name="cvrestriccion_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $json = $request->get("data",null);
        $params = json_decode($json);
        
        $restricciones = $em->getRepository('JHWEBContravencionalBundle:CvRestriccion')->findBy(
            array(
                'activo' => true
            )
        );

        $response = null;

        foreach ($restricciones as $key => $restriccion) {
            $response[$key] = array(
                'value' => $restriccion->getId(),
                'label' => $restriccion->getDescripcion()
            );
        }
        
        return $helpers->json($response);
    }
}
