<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Dependencia;
use AppBundle\Form\DependenciaType;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Dependencia controller.
 *
 * @Route("/dependencia")
 */
class DependenciaController extends Controller
{
    /**
     * Lists all Dependencia entities.
     *
     * @Route("/", name="dependencia_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $dependencias = $em->getRepository('AppBundle:Dependencia')->findByEstado(1);

         $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado dependencias", 
                    'data'=> $dependencias,
            );
         
        return $helpers->json($responce);
    }

    /**
     * Creates a new Dependencia entity.
     *
     * @Route("/new", name="dependencia_new")
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

            if (count($params)==0) {
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "los campos no pueden estar vacios", 
                );
            }else{
                $nombre = $params->nombre;
               
                $em = $this->getDoctrine()->getManager();
                $dependencias = $em->getRepository('AppBundle:Dependencia')->findByNombre($nombre);
                   
                    if ($dependencias==null) {
                        $dependencia = new Dependencia();

                        $dependencia->setNombre($nombre);
                        $dependencia->setEstado(1);

                        $em = $this->getDoctrine()->getManager();
                        $em->persist($dependencia);
                        $em->flush();

                        $responce = array(
                            'status' => 'success',
                            'code' => 200,
                            'msj' => "Dependencia creada con exito", 
                        );
                        }else{

                            $responce = array(
                            'status' => 'error',
                            'code' => 400,
                            'msj' => "La dependencia ya se encuentra registrada en la base de datos", 
                        );
                    }
                }

        }else{
            $responce = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida", 
            );
            } 
        return $helpers->json($responce);
    }

    /**
     * Finds and displays a Dependencia entity.
     *
     * @Route("/show/{id}", name="dependencia_show")
     * @Method("POST")
     */
    public function showAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $dependencia = $em->getRepository('AppBundle:Dependencia')->find($id);

            $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Dependencia con nombre"." ".$dependencia->getNombre(), 
                    'data'=> $dependencia,
            );
        }else{
            $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($responce);
    }

    /**
     * Displays a form to edit an existing Dependencia entity.
     *
     * @Route("/edit", name="dependencia_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $em = $this->getDoctrine()->getManager();

        if ($authCheck==true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $nombre = $params->nombre;

            $dependencia = $em->getRepository("AppBundle:Dependencia")->find($params->id);

            if ($dependencia!=null) {
                $dependencia->setNombre($nombre);

                $em->flush();

                 $responce = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Dependencia actualizado con exito", 
                        'data'=> $dependencia,
                );
            }else{
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El dependencia no se encuentra en la base de datos", 
                );
            }
        }else{
            $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar dependencia", 
                );  
        }

        return $helpers->json($responce);
    }

    /**
     * Deletes a Dependencia entity.
     *
     * @Route("/{id}/delete", name="dependencia_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

    
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $departamento = $em->getRepository('AppBundle:Dependencia')->find($id);

            $departamento->setEstado(0);
            $em->flush();

            $responce = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "Dependencia Eliminada con Exito"
                        
            );

        }else{
        $responce = array(
            'status' => 'error',
            'code' => 400,
            'msj' => "Autorizacion no valida", 
        ); 
        }
       

        return $helpers->json($responce);
    }

    /**
     * Creates a form to delete a Dependencia entity.
     *
     * @param Dependencia $dependencium The Dependencia entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Dependencia $dependencium)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dependencia_delete', array('id' => $dependencium->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="dependencia_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $dependencias = $em->getRepository('AppBundle:Dependencia')->findBy(
        array('estado' => 1)
    );
      foreach ($dependencias as $key => $dependencia) {
        $responce[$key] = array(
            'value' => $dependencia->getId(),
            'label' => $dependencia->getNombre(),
            );
      }
       return $helpers->json($responce);
    }
}
