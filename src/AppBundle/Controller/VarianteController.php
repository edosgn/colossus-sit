<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Variante;
use AppBundle\Form\VarianteType;

/**
 * Variante controller.
 *
 * @Route("/variante")
 */
class VarianteController extends Controller
{
    /**
     * Lists all Variante entities.
     *
     * @Route("/", name="variante_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $variantes = $em->getRepository('AppBundle:Variante')->findBy(
            array('estado' => 1)
        );
        $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado variantes", 
                    'data'=> $variantes,
            );
         
        return $helpers->json($responce);
    }

    /**
     * Creates a new Variante entity.
     *
     * @Route("/new", name="variante_new")
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
                        $tramiteId = $params->tramiteId;
                        $em = $this->getDoctrine()->getManager();
                        $tramite = $em->getRepository('AppBundle:Tramite')->find($tramiteId);
                        $variante = new Variante();
                        $variante->setNombre($nombre);
                        $variante->setTramite($tramite);
                        $variante->setEstado(true);
                        $em = $this->getDoctrine()->getManager();
                        $em->persist($variante);
                        $em->flush();

                        $responce = array(
                            'status' => 'success',
                            'code' => 200,
                            'msj' => "variante creado con exito", 
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
     * Finds and displays a Variante entity.
     *
     * @Route("/show/{id}", name="variante_show")
     * @Method("POST")
     */
    public function showAction(Request $request,$id)
    {
       $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $variante = $em->getRepository('AppBundle:Variante')->find($id);
            $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "variante con nombre"." ".$variante->getNombre(), 
                    'data'=> $variante,
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
     * Displays a form to edit an existing Variante entity.
     *
     * @Route("/edit", name="variante_edit")
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
            $tramiteId = $params->tramiteId;
            $em = $this->getDoctrine()->getManager();
            $tramite = $em->getRepository("AppBundle:Tramite")->find($tramiteId);
            $variante = $em->getRepository("AppBundle:Variante")->find($params->id);

            if ($variante!=null) {
                $variante->setNombre($nombre);
                $variante->setTramite($tramite);
                $variante->setEstado(true);
                $em = $this->getDoctrine()->getManager();
                $em->persist($variante);
                $em->flush();

                $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "variante editada con exito", 
                );
            }else{
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El variante no se encuentra en la base de datos", 
                );
            }
        }else{
            $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar variante", 
                );
        }

        return $helpers->json($responce);
    }
    /**
     * Deletes a Variante entity.
     *
     * @Route("/{id}/delete", name="variante_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $variante = $em->getRepository('AppBundle:Variante')->find($id);

            $variante->setEstado(0);
            $em = $this->getDoctrine()->getManager();
                $em->persist($variante);
                $em->flush();
            $responce = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "variante eliminado con exito", 
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
     * Creates a form to delete a Variante entity.
     *
     * @param Variante $variante The Variante entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Variante $variante)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('variante_delete', array('id' => $variante->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * busca las variantes de un tramite.
     *
     * @Route("/showVariantes/{id}", name="variante_tramites_show")
     * @Method("POST")
     */
    public function showVariantesAction(Request  $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $variantes = $em->getRepository('AppBundle:Variante')->findBy(
            array('estado' => 1,'tramite'=> $id)
            );

            if ($variantes==null) {
               $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "no hay variantes no valida", 
                ); 
            }else{
                $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "variantes encontrado", 
                    'data'=> $variantes,
            );
            }
            
        }else{
            
        }
        return $helpers->json($responce);
    }
}
