<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Color;
use AppBundle\Form\ColorType;

/**
 * Color controller.
 *
 * @Route("/color")
 */
class ColorController extends Controller
{
    /**
     * Lists all Color entities.
     *
     * @Route("/", name="color_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $colores = $em->getRepository('AppBundle:Color')->findBy(
            array('estado' => 1)
        );
        $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado colores", 
                    'data'=> $colores,
            );
         
        return $helpers->json($response);
    }

    /**
     * Creates a new Color entity.
     *
     * @Route("/new", name="color_new")
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

                $em = $this->getDoctrine()->getManager();
                $color = $em->getRepository('AppBundle:Color')->findOneByNombre($params->nombre);

                if ($color==null) {
                    $color = new Color();
    
                    $color->setNombre($nombre);
                    $color->setEstado(true);
    
                    $em->persist($color);
                    $em->flush();
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Color creado con exito", 
                    );
                }else{
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'msj' => "El nombre del color ya se encuentra registrado", 
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
     * Finds and displays a Color entity.
     *
     * @Route("/show/{id}", name="color_show")
     * @Method("POST")
     */
    public function showAction(Request $request,$id)
    {
       $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $color = $em->getRepository('AppBundle:Color')->find($id);
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "color encontrado", 
                    'data'=> $color,
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
     * Displays a form to edit an existing Color entity.
     *
     * @Route("/edit", name="color_edit")
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
            $color = $em->getRepository('AppBundle:Color')->find($params->id);
            if ($color!=null) {

                $color->setNombre($nombre);
                $color->setEstado(true);
               

                $em = $this->getDoctrine()->getManager();
                $em->persist($color);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "color editada con exito", 
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "La color no se encuentra en la base de datos", 
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
     * Deletes a Color entity.
     *
     * @Route("/{id}/delete", name="color_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();            
            $color = $em->getRepository('AppBundle:Color')->find($id);

            $color->setEstado(0);
            $em = $this->getDoctrine()->getManager();
                $em->persist($color);
                $em->flush();
            $response = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "color eliminado con exito", 
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
     * Creates a form to delete a Color entity.
     *
     * @param Color $color The Color entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Color $color)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('color_delete', array('id' => $color->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

     /**
     * datos para select 2
     *
     * @Route("/select", name="color_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $colors = $em->getRepository('AppBundle:Color')->findBy(
        array('estado' => 1)
    );
    
    foreach ($colors as $key => $color) {
        $response[$key] = array(
            'value' => $color->getId(),
            'label' => $color->getNombre(),
        );
      }
       return $helpers->json($response);
    }
}
