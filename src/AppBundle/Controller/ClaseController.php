<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Clase;
use AppBundle\Form\ClaseType;

/**
 * Clase controller.
 *
 * @Route("/clase")
 */
class ClaseController extends Controller
{
    /**
     * Lists all Clase entities.
     *
     * @Route("/", name="clase_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $clase = $em->getRepository('AppBundle:Clase')->findBy(
            array('estado' => 1)
        );
        $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado clase", 
                    'data'=> $clase,
            );
         
        return $helpers->json($responce);
    }

    /**
     * Creates a new Clase entity.
     *
     * @Route("/new", name="clase_new")
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
                $clase = $em->getRepository('AppBundle:Clase')->findBy(
                    array('codigoMt' => $codigoMt)
                );
                    if ($clase==null) {
                        $clase = new Clase();
                        $clase->setNombre($nombre);
                        $clase->setEstado(true);
                        $clase->setCodigoMt($codigoMt);
                        $em = $this->getDoctrine()->getManager();
                        $em->persist($clase);
                        $em->flush();
                        $responce = array(
                            'status' => 'success',
                            'code' => 200,
                            'msj' => "Clase creada con exito", 
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
     * Finds and displays a Clase entity.
     *
     * @Route("/show/{id}", name="clase_show")
     * @Method("POST")
     */
    public function showAction(Request  $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $clase = $em->getRepository('AppBundle:Clase')->find($id);
            $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "clase encontrado", 
                    'data'=> $clase,
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
     * Displays a form to edit an existing Clase entity.
     *
     * @Route("/edit", name="clase_edit")
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
            $clase = $em->getRepository('AppBundle:Clase')->find($params->id);
            if ($clase!=null) {

                $clase->setNombre($nombre);
                $clase->setEstado(true);
                $clase->setCodigoMt($codigoMt);

                $em = $this->getDoctrine()->getManager();
                $em->persist($clase);
                $em->flush();

                $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Clase editada con exito", 
                );
            }else{
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "La clase no se encuentra en la base de datos", 
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
     * Deletes a Clase entity.
     *
     * @Route("/{id}/delete", name="clase_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $clase = $em->getRepository('AppBundle:Clase')->find($id);

            $clase->setEstado(0);
            $em = $this->getDoctrine()->getManager();
                $em->persist($clase);
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
     * Creates a form to delete a Clase entity.
     *
     * @param Clase $clase The Clase entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Clase $clase)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('clase_delete', array('id' => $clase->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
