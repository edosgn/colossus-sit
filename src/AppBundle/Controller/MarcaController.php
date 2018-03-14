<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Marca;
use AppBundle\Form\MarcaType;

/**
 * Marca controller.
 *
 * @Route("/marca")
 */
class MarcaController extends Controller
{ 
    /**
     * Lists all Marca entities. 
     *
     * @Route("/", name="marca_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $marcas = $em->getRepository('AppBundle:Marca')->findBy(
            array('estado' => 1)
        );
        $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado marcas", 
                    'data'=> $marcas,
            );
         
        return $helpers->json($responce);
    }

    /**
     * Creates a new Marca entity.
     *
     * @Route("/new", name="marca_new")
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
                $marca = $em->getRepository('AppBundle:Marca')->findBy(
                    array('codigoMt' => $codigoMt)
                );
                    if ($marca==null) {
                        $marca = new Marca();
                        $marca->setNombre($nombre);
                        $marca->setEstado(true);
                        $marca->setCodigoMt($codigoMt);
                        $em = $this->getDoctrine()->getManager();
                        $em->persist($marca);
                        $em->flush();
                        $responce = array(
                            'status' => 'success',
                            'code' => 200,
                            'msj' => "marca creada con exito", 
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
     * Finds and displays a Marca entity.
     *
     * @Route("/show/{id}", name="marca_show")
     * @Method("POST")
     */
    public function showAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $marca = $em->getRepository('AppBundle:Marca')->find($id);
            $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "marca encontrado", 
                    'data'=> $marca,
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
     * Displays a form to edit an existing Marca entity.
     *
     * @Route("/edit", name="marca_edit")
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
            $marca = $em->getRepository('AppBundle:Marca')->find($params->id);
            if ($marca!=null) {

                $marca->setNombre($nombre);
                $marca->setEstado(true);
                $marca->setCodigoMt($codigoMt);

                $em = $this->getDoctrine()->getManager();
                $em->persist($marca);
                $em->flush();

                $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "marca editada con exito", 
                );
            }else{
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "La marca no se encuentra en la base de datos", 
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
     * Deletes a Marca entity.
     *
     * @Route("/{id}/delete", name="marca_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $marca = $em->getRepository('AppBundle:Marca')->find($id);

            $marca->setEstado(0);
            $em = $this->getDoctrine()->getManager();
                $em->persist($marca);
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
     * Creates a form to delete a Marca entity.
     *
     * @param Marca $marca The Marca entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Marca $marca)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('marca_delete', array('id' => $marca->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

     /**
     * datos para select 2
     *
     * @Route("/select", name="marca_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $marcas = $em->getRepository('AppBundle:Marca')->findBy(
        array('estado' => 1)
    );
     
      foreach ($marcas as $key => $marca) {
        $responce[$key] = array(
            'value' => $marca->getId(),
            'label' => $marca->getNombre(),
            );
      }
       return $helpers->json($responce);
    }
}
