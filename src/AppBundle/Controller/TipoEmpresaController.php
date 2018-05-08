<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\TipoEmpresa;
use AppBundle\Form\TipoEmpresaType;

/**
 * TipoEmpresa controller.
 *
 * @Route("/tipoempresa")
 */
class TipoEmpresaController extends Controller
{
    /**
     * Lists all TipoEmpresa entities.
     *
     * @Route("/", name="tipoempresa_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $tipoEmpresa = $em->getRepository('AppBundle:TipoEmpresa')->findBy(
            array('estado' => 1)
        );
        $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado tipoEmpresa", 
                    'data'=> $tipoEmpresa,
            );
         
        return $helpers->json($responce);
    }

    /**
     * Creates a new TipoEmpresa entity.
     *
     * @Route("/new", name="tipoempresa_new")
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
            // if (count($params)==0) {
            //     $responce = array(
            //         'status' => 'error',
            //         'code' => 400,
            //         'msj' => "los campos no pueden estar vacios", 
            //     );
            // }else{
                        $nombre = $params->nombre;
                        $tipoEmpresa = new TipoEmpresa();

                        $tipoEmpresa->setNombre($nombre);
                        $tipoEmpresa->setEstado(true);

                        $em = $this->getDoctrine()->getManager();
                        $em->persist($tipoEmpresa);
                        $em->flush();

                        $responce = array(
                            'status' => 'success',
                            'code' => 200,
                            'msj' => "tipoEmpresa creado con exito", 
                        );
                       
                    // }
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
     * Finds and displays a TipoEmpresa entity.
     *
     * @Route("/show/{id}", name="tipoempresa_show")
     * @Method("POST")
     */
    public function showAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $tipoEmpresa = $em->getRepository('AppBundle:TipoEmpresa')->find($id);
            $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "tipoEmpresa con nombre"." ".$tipoEmpresa->getNombre(), 
                    'data'=> $tipoEmpresa,
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
     * Displays a form to edit an existing TipoEmpresa entity.
     *
     * @Route("/edit", name="tipoempresa_edit")
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
            $tipoEmpresa = $em->getRepository("AppBundle:TipoEmpresa")->find($params->id);

            if ($tipoEmpresa!=null) {
                $tipoEmpresa->setNombre($nombre);
                $em = $this->getDoctrine()->getManager();
                $em->persist($tipoEmpresa);
                $em->flush();

                 $responce = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "tipoEmpresa actualizado con exito", 
                        'data'=> $tipoEmpresa,
                );
            }else{
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El tipoEmpresa no se encuentra en la base de datos", 
                );
            }
        }else{
            $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar tipoEmpresa", 
                );
        }

        return $helpers->json($responce);
    }

    /**
     * Deletes a TipoEmpresa entity.
     *
     * @Route("/{id}/delete", name="tipoempresa_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $tipoEmpresa = $em->getRepository('AppBundle:TipoEmpresa')->find($id);

            $tipoEmpresa->setEstado(0);
            $em = $this->getDoctrine()->getManager();
                $em->persist($tipoEmpresa);
                $em->flush();
            $responce = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "tipoEmpresa eliminado con exito", 
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
     * Creates a form to delete a TipoEmpresa entity.
     *
     * @param TipoEmpresa $tipoEmpresa The TipoEmpresa entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TipoEmpresa $tipoEmpresa)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tipoempresa_delete', array('id' => $tipoEmpresa->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="tipoEmpresa_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();

    $tipoEmpresas = $em->getRepository('AppBundle:TipoEmpresa')->findBy(
        array('estado' => 1)
    );
      foreach ($tipoEmpresas as $key => $tipoEmpresa) {
        $responce[$key] = array(
            'value' => $tipoEmpresa->getId(),
            'label' => $tipoEmpresa->getNombre(),
            );
      }
       return $helpers->json($responce);
    }
}
