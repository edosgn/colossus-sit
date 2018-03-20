<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Departamento; 
use AppBundle\Form\DepartamentoType;

/** 
 * Departamento controller.
 *
 * @Route("/departamento")
 */
class DepartamentoController extends Controller
{
    
    /**
     * Lists all Departamento entities.
     *
     * @Route("/", name="departamento_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $departamentos = $em->getRepository('AppBundle:Departamento')->findBy(
            array('estado' => 1)
        );

         $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado departamentos", 
                    'data'=> $departamentos,
            );
         
        return $helpers->json($responce);
    }

    /**
     * Creates a new Departamento entity.
     *
     * @Route("/new", name="departamento_new")
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
                $codigoDian = $params->codigoDian;
                $em = $this->getDoctrine()->getManager();
                $departamentos = $em->getRepository('AppBundle:Departamento')->findBy(
                    array('codigoDian' => $codigoDian)
                );

                    if ($departamentos==null) {
                        $departamento = new Departamento();

                        $departamento->setNombre($nombre);
                        $departamento->setCodigoDian($codigoDian);
                        $departamento->setEstado(true);

                        $em = $this->getDoctrine()->getManager();
                        $em->persist($departamento);
                        $em->flush();

                        $responce = array(
                            'status' => 'success',
                            'code' => 200,
                            'msj' => "Departamento creado con exito", 
                        );
                        }else{

                            $responce = array(
                            'status' => 'error',
                            'code' => 400,
                            'msj' => "El codigo Dian ya esta registrado", 
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
     * Finds and displays a Departamento entity.
     *
     * @Route("/show/{id}", name="departamento_show")
     * @Method("POST")
     */
    public function showAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $departamento = $em->getRepository('AppBundle:Departamento')->find($id);

            $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Departamento con nombre"." ".$departamento->getNombre(), 
                    'data'=> $departamento,
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
     * Displays a form to edit an existing Departamento entity.
     *
     * @Route("/edit", name="departamento_edit")
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
            $codigoDian = $params->codigoDian;

            $em = $this->getDoctrine()->getManager();
            $departamento = $em->getRepository("AppBundle:Departamento")->findOneBy(array(
                    "id" => $params->id
            ));

            if ($departamento!=null) {
                $departamento->setNombre($nombre);
                $departamento->setCodigoDian($codigoDian);

                $em = $this->getDoctrine()->getManager();
                $em->persist($departamento);
                $em->flush();

                 $responce = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Departamento actualizado con exito", 
                        'data'=> $departamento,
                );
            }else{
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El departamento no se encuentra en la base de datos", 
                );
            }
        }else{
            $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar departamento", 
                );  
        }

        return $helpers->json($responce);

        
    }

    /**
     * Deletes a Departamento entity.
     *
     * @Route("/{id}/delete", name="departamento_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {

            $em = $this->getDoctrine()->getManager();
            $departamento = $em->getRepository('AppBundle:Departamento')->find($id);

            if ($departamento) {
               if ($departamento!=null) {

                $departamento->setEstado(0);
                $em->persist($departamento);
                $em->flush();

                $responce = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Departamento eliminado con exito",
                        'warning'=>"el departamento contiene municipios", 
                );
            }else{
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El departamento no se encuentra en la base de datos", 
                );
            }
            }else{
                if ($departamento!=null) {

                $departamento->setEstado(0);
                $em->persist($departamento);
                $em->flush();

                $responce = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Departamento eliminado con exito",
                );
            }else{
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El departamento no se encuentra en la base de datos", 
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
     * Creates a form to delete a Departamento entity.
     *
     * @param Departamento $departamento The Departamento entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Departamento $departamento)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('departamento_delete', array('id' => $departamento->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


    /**
     * datos para select 2
     *
     * @Route("/select", name="departamento_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $departamentos = $em->getRepository('AppBundle:Departamento')->findBy(
        array('estado' => 1)
    );
      foreach ($departamentos as $key => $departamento) {
        $responce[$key] = array(
            'value' => $departamento->getId(),
            'label' => $departamento->getCodigoDian()."_".$departamento->getNombre(),
            );
      }
       return $helpers->json($responce);
    }
}
