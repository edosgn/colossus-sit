<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Modalidad;
use AppBundle\Form\ModalidadType;

/**
 * Modalidad controller.
 *
 * @Route("/modalidad")
 */
class ModalidadController extends Controller
{
    /**
     * Lists all Modalidad entities.
     *
     * @Route("/", name="modalidad_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $modalidad = $em->getRepository('AppBundle:Modalidad')->findBy(
            array('estado' => 1)
        );
        $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado modalidad", 
                    'data'=> $modalidad,
            );
         
        return $helpers->json($responce);
    }

    /**
     * Creates a new Modalidad entity.
     *
     * @Route("/new", name="modalidad_new")
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
                $codigoMt = $params->codigoMt;
                $em = $this->getDoctrine()->getManager();
                $modalidad = $em->getRepository('AppBundle:Modalidad')->findBy(
                    array('codigoMt' => $codigoMt)
                );
                    if ($modalidad == null) {
                        $modalidad = new Modalidad();
                        $modalidad->setNombre($nombre);
                        $modalidad->setEstado(true);
                        $modalidad->setCodigoMt($codigoMt);
                        $em = $this->getDoctrine()->getManager();
                        $em->persist($modalidad);
                        $em->flush();
                        $responce = array(
                            'status' => 'success',
                            'code' => 200,
                            'msj' => "modalidad creada con exito", 
                        );
                    }else{
                         $responce = array(
                            'status' => 'error',
                            'code' => 400,
                            'msj' => "Codigo de ministerio de transporte debe ser unico",
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
     * Finds and displays a Modalidad entity.
     *
     * @Route("/show/{id}", name="modalidad_show")
     * @Method("POST")
     */
    public function showAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $modalidad = $em->getRepository('AppBundle:Modalidad')->find($id);
            $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "modalidad encontrado", 
                    'data'=> $modalidad,
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
     * Displays a form to edit an existing Modalidad entity.
     *
     * @Route("/edit", name="modalidad_edit")
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
            $em = $this->getDoctrine()->getManager();
            $modalidad = $em->getRepository('AppBundle:Modalidad')->find($params->id);
            if ($modalidad!=null) {

                $modalidad->setNombre($nombre);
                $modalidad->setEstado(true);
                $modalidad->setCodigoMt($codigoMt);

                $em = $this->getDoctrine()->getManager();
                $em->persist($modalidad);
                $em->flush();

                $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "modalidad editada con exito", 
                );
            }else{
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "La modalidad no se encuentra en la base de datos", 
                );
            }
        }else{
            $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar banco", 
                );
        }

        return $helpers->json($responce);
    }

    /**
     * Deletes a Modalidad entity.
     *
     * @Route("/{id}/delete", name="modalidad_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $modalidad = $em->getRepository('AppBundle:Modalidad')->find($id);

            $modalidad->setEstado(0);
            $em = $this->getDoctrine()->getManager();
                $em->persist($modalidad);
                $em->flush();
            $responce = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "lase eliminado con exito", 
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
     * Creates a form to delete a Modalidad entity.
     *
     * @param Modalidad $modalidad The Modalidad entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Modalidad $modalidad)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('modalidad_delete', array('id' => $modalidad->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

     /**
     * datos para select 2
     *
     * @Route("/select", name="modalidad_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $modalidads = $em->getRepository('AppBundle:Modalidad')->findBy(
        array('estado' => 1)
    );
    if ($modalidads == null) {
       $responce = null;
    }
      foreach ($modalidads as $key => $modalidad) {
        $responce[$key] = array(
            'value' => $modalidad->getId(),
            'label' => $modalidad->getNombre(),
            );
      }
       return $helpers->json($responce);
    }
}
