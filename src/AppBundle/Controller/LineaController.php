<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Linea;
use AppBundle\Form\LineaType;

/**
 * Linea controller.
 *
 * @Route("/linea")
 */
class LineaController extends Controller
{
    /**
     * Lists all Linea entities.
     *
     * @Route("/", name="linea_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $lineas = $em->getRepository('AppBundle:Linea')->findBy(
            array('estado' => 1)
        );
        $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado lineas", 
                    'data'=> $lineas,
            );
         
        return $helpers->json($responce);
    }

    /**
     * Creates a new Linea entity.
     *
     * @Route("/new", name="linea_new")
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
                $marcaId = $params->marcaId;
                $em = $this->getDoctrine()->getManager();
                $marca = $em->getRepository('AppBundle:Marca')->find($marcaId);
                $linea = $em->getRepository('AppBundle:Linea')->findBy(
                    array('codigoMt' => $codigoMt)
                );
                    if ($linea==null) {
                        $linea = new Linea();
                        $linea->setNombre($nombre);
                        $linea->setEstado(true);
                        $linea->setCodigoMt($codigoMt);
                        $linea->setMarca($marca);


                        $em = $this->getDoctrine()->getManager();
                        $em->persist($linea);
                        $em->flush();
                        $responce = array(
                            'status' => 'success',
                            'code' => 200,
                            'msj' => "linea creada con exito", 
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
     * Finds and displays a Linea entity.
     *
     * @Route("/show/{id}", name="linea_show")
     * @Method("POST")
     */
    public function showAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $linea = $em->getRepository('AppBundle:Linea')->find($id);
            $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "linea encontrada", 
                    'data'=> $linea,
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
     * Displays a form to edit an existing Linea entity.
     *
     * @Route("/edit", name="linea_edit")
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
            $marcaId = $params->marcaId;
            $em = $this->getDoctrine()->getManager();
            $marca = $em->getRepository('AppBundle:Marca')->find($marcaId);
            $nombre = $params->nombre;
            $codigoMt = $params->codigoMt;
            $em = $this->getDoctrine()->getManager();
            $linea = $em->getRepository('AppBundle:Linea')->find($params->id);
            if ($linea!=null) {

                $linea->setNombre($nombre);
                $linea->setEstado(true);
                $linea->setCodigoMt($codigoMt);
                $linea->setMarca($marca);

                $em = $this->getDoctrine()->getManager();
                $em->persist($linea);
                $em->flush();

                $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "linea editada con exito", 
                );
            }else{
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "La linea no se encuentra en la base de datos", 
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
     * Deletes a Linea entity.
     *
     * @Route("/{id}/delete", name="linea_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $linea = $em->getRepository('AppBundle:Linea')->find($id);

            $linea->setEstado(0);
            $em = $this->getDoctrine()->getManager();
                $em->persist($linea);
                $em->flush();
            $responce = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "linea eliminado con exito", 
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
     * Creates a form to delete a Linea entity.
     *
     * @param Linea $linea The Linea entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Linea $linea)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('linea_delete', array('id' => $linea->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
