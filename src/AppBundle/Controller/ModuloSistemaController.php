<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\ModuloSistema;
use AppBundle\Form\ModuloSistemaType;

/**
 * ModuloSistema controller.
 *
 * @Route("/modulosistema")
 */
class ModuloSistemaController extends Controller
{
    /**
     * Lists all ModuloSistema entities.
     *
     * @Route("/", name="modulosistema_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $modulosSistema = $em->getRepository('AppBundle:ModuloSistema')->findAll();
            $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado modulosSistema", 
                    'data'=> $modulosSistema,
            );
         
        return $helpers->json($responce);
    }

    /**
     * Creates a new ModuloSistema entity.
     *
     * @Route("/new", name="modulosistema_new")
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
                $moduloSistema = new ModuloSistema();

                $moduloSistema->setNombre($nombre);

                $em = $this->getDoctrine()->getManager();
                $em->persist($moduloSistema);
                $em->flush();

                $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "ModuloSistema creado con exito", 
                );
                       
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
     * Finds and displays a ModuloSistema entity.
     *
     * @Route("/show/{id}", name="modulo_show")
     * @Method("POST")
     */
    public function showAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $moduloSistema = $em->getRepository('AppBundle:ModuloSistema')->find($id);
            $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "moduloSistema con nombre"." ".$moduloSistema->getNombre(), 
                    'data'=> $moduloSistema,
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
     * Displays a form to edit an existing ModuloSistema entity.
     *
     * @Route("/edit", name="modulo_edit")
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
            $moduloSistema = $em->getRepository("AppBundle:ModuloSistema")->find($params->id);

            if ($moduloSistema!=null) {
                $nombre = $params->nombre;

                $moduloSistema->setNombre($nombre);
                
                $em->persist($moduloSistema);
                $em->flush();
                $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "ModuloSistema editado con exito", 
                );
            }else{
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El moduloSistema no se encuentra en la base de datos", 
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
     * Deletes a ModuloSistema entity.
     *
     * @Route("/{id}", name="modulosistema_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ModuloSistema $moduloSistema)
    {
        $form = $this->createDeleteForm($moduloSistema);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($moduloSistema);
            $em->flush();
        }

        return $this->redirectToRoute('modulosistema_index');
    }

    /**
     * Creates a form to delete a ModuloSistema entity.
     *
     * @param ModuloSistema $moduloSistema The ModuloSistema entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ModuloSistema $moduloSistema)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('modulosistema_delete', array('id' => $moduloSistema->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


    /**
     * datos para select 2
     *
     * @Route("/select", name="moduloSistema_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $moduloSistemas = $em->getRepository('AppBundle:ModuloSistema')->findAll();
        
    if ($moduloSistemas == null) {
       $responce = null;
    }
      foreach ($moduloSistemas as $key => $moduloSistema) {
        $responce[$key] = array(
            'value' => $moduloSistema->getId(),
            'label' => $moduloSistema->getNombre(),
            );
      }
       return $helpers->json($responce);
    }
}
