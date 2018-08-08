<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TipoVehiculo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Tipovehiculo controller.
 *
 * @Route("tipovehiculo")
 */
class TipoVehiculoController extends Controller
{
    
    /**
     * Lists all tipoVehiculo entities.
     *
     * @Route("/", name="tipovehiculo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $tiposVehiculo = $em->getRepository('AppBundle:TipoVehiculo')->findBy(
            array('estado' => true)
        );

        $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Lista de tipos de vehiculo", 
                    'data'=> $tiposVehiculo,
            );
         
        return $helpers->json($response);
    }

    /**
     * Creates a new tipoVehiculo entity.
     *
     * @Route("/new", name="tipovehiculo_new")
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
                $tipoVehiculo = new TipoVehiculo();

                $tipoVehiculo->setNombre($params->nombre);
                $tipoVehiculo->setEstado(true);

                $em = $this->getDoctrine()->getManager();
                $em->persist($tipoVehiculo);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro creado con exito",  
                );
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
     * Finds and displays a tipoVehiculo entity.
     *
     * @Route("/{id}/show", name="tipovehiculo_show")
     * @Method("POST")
     */
    public function showAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $tipoVehiculo = $em->getRepository('AppBundle:TipoVehiculo')->find($id);
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro encontrado: ".$tipoVehiculo->getNombre(), 
                    'data'=> $tipoVehiculo,
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
     * Displays a form to edit an existing tipoVehiculo entity.
     *
     * @Route("/edit", name="tipovehiculo_edit")
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
            $tipoVehiculo = $em->getRepository("AppBundle:TipoVehiculo")->find($params->id);

            if ($tipoVehiculo!=null) {
                $tipoVehiculo->setNombre($nombre);
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($tipoVehiculo);
                $em->flush();

                 $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Registro actualizado con exito", 
                        'data'=> $tipoVehiculo,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El registro no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a tipoVehiculo entity.
     *
     * @Route("/{id}/delete", name="tipovehiculo_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $tipoVehiculo = $em->getRepository('AppBundle:TipoVehiculo')->find($id);

            $tipoVehiculo->setEstado(false);
            $em->persist($tipoVehiculo);
            $em->flush();
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "Registro eliminado con exito", 
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
     * Creates a form to delete a tipoVehiculo entity.
     *
     * @param TipoVehiculo $tipoVehiculo The tipoVehiculo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TipoVehiculo $tipoVehiculo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tipovehiculo_delete', array('id' => $tipoVehiculo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="tipovehiculo_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $tiposVehiculo = $em->getRepository('AppBundle:TipoVehiculo')->findBy(
        array('estado' => 1)
    );
      foreach ($tiposVehiculo as $key => $tipoVehiculo) {
        $response[$key] = array(
            'value' => $tipoVehiculo->getId(),
            'label' => $tipoVehiculo->getNombre(),
            );
      }
       return $helpers->json($response);
    }
}
