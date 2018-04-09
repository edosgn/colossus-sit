<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Carroceria;
use AppBundle\Form\CarroceriaType;

/**
 * Carroceria controller.
 *
 * @Route("/carroceria")
 */
class CarroceriaController extends Controller
{
    /**
     * Lists all Carroceria entities.
     *
     * @Route("/", name="carroceria_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $carrocerias = $em->getRepository('AppBundle:Carroceria')->findBy(
            array('estado' => 1)
        );
        $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado carrocerias", 
                    'data'=> $carrocerias,
            );
         
        return $helpers->json($response);
    }

    /**
     * Creates a new Carroceria entity.
     *
     * @Route("/new", name="carroceria_new")
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
            
            /*if (count($params)==0) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "los campos no pueden estar vacios", 
                );
            }else{*/
                $nombre = $params->nombre;
                $codigoMt = $params->codigoMt;
                $claseId = $params->claseId;
                $em = $this->getDoctrine()->getManager();
                $carrocerias = $em->getRepository('AppBundle:Carroceria')->findBy(
                    array('codigoMt' => $codigoMt)
                );
                if ($carrocerias==null) {
                    $em = $this->getDoctrine()->getManager();
                    $clase = $em->getRepository('AppBundle:Clase')->find($claseId);

                    if ($clase!=null) {
                        $carroceria = new Carroceria();
                        $carroceria->setNombre($nombre);
                        $carroceria->setCodigoMt($codigoMt);
                        $carroceria->setClase($clase);
                        $carroceria->setEstado(true);
                        $em->persist($carroceria);
                        $em->flush();

                        $response = array(
                            'status' => 'success',
                            'code' => 200,
                            'msj' => "Carroceria creado con exito", 
                        );
                    }else{
                        $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'msj' => "no se encuentra la clase", 
                        ); 
                    }
                        
                }else{
                    $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Codigo de ministerio de transporte debe ser unico", 
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
     * Finds and displays a Carroceria entity.
     *
     * @Route("/show/{id}", name="carroceria_show")
     * @Method("POST")
     */
    public function showAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $carroceria = $em->getRepository('AppBundle:Carroceria')->find($id);
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Carroceria con nombre"." ".$carroceria->getNombre(), 
                    'data'=> $carroceria,
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
     * Displays a form to edit an existing Carroceria entity.
     *
     * @Route("/edit", name="carroceria_edit")
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
            $codigoMt = $params->codigoMt;

            $claseId = $params->claseId;
            $em = $this->getDoctrine()->getManager();
            $carroceria = $em->getRepository("AppBundle:Carroceria")->find($params->id);
            $clase = $em->getRepository("AppBundle:Clase")->find($claseId);

            if ($carroceria!=null) {
                        
                $carroceria->setNombre($nombre);
                $carroceria->setCodigoMt($codigoMt);
                $carroceria->setClase($clase);
                $carroceria->setEstado(true);
                $em->persist($carroceria);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Carroceria editada con exito", 
                );
                        
                        
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "carroceria no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida", 
                );
        }

        return $helpers->json($response);;
    }

    /**
     * Deletes a Carroceria entity.
     *
     * @Route("/{id}/delete", name="carroceria_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $carroceria = $em->getRepository('AppBundle:Carroceria')->find($id);

            $carroceria->setEstado(0);
            $em = $this->getDoctrine()->getManager();
                $em->persist($carroceria);
                $em->flush();
            $response = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "Carroceria eliminada con exito", 
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
     * Creates a form to delete a Carroceria entity.
     *
     * @param Carroceria $carrocerium The Carroceria entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Carroceria $carrocerium)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('carroceria_delete', array('id' => $carrocerium->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * encuentra las carrocerias de una clase.
     *
     * @Route("/clase/{id}", name="carroceria_clase")
     * @Method("POST")
     */
    public function carroceriaClaseAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $carrocerias = $em->getRepository('AppBundle:Carroceria')->findBy(
                array(
                'estado' => 1,
                'clase' => $id
                )
            );

            if ($carrocerias != null) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Carroceria encontrada", 
                    'data'=> $carrocerias,
                 );
            }else{
                 $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "no existen carrocerias para esta clase", 
                );
            }
            
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
     * datos para select 2
     *
     * @Route("/select", name="carroceria_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $carrocerias = $em->getRepository('AppBundle:Carroceria')->findBy(
        array('estado' => 1)
    );
      foreach ($carrocerias as $key => $carroceria) {
        $response[$key] = array(
            'value' => $carroceria->getId(),
            'label' => $carroceria->getCodigoMt()."_".$carroceria->getNombre(),
            );
      }
       return $helpers->json($response);
    }
}
