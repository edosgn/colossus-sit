<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Banco;
use AppBundle\Form\BancoType;

/**
 * Banco controller. 
 *
 * @Route("/banco")
 */
class BancoController extends Controller
{ 
    /**
     * Lists all Banco entities.
     *
     * @Route("/", name="banco_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $bancos = $em->getRepository('AppBundle:Banco')->findBy(
            array('estado' => 1)
        );
        $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado bancos", 
                    'data'=> $bancos,
            );
         
        return $helpers->json($response);
    }
    

    /**
     * Creates a new Banco entity.
     *
     * @Route("/new", name="banco_new")
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
                $nombre = $params->nombre;
                $banco = new Banco();

                $banco->setNombre($nombre);
                $banco->setEstado(true);

                $em = $this->getDoctrine()->getManager();
                $em->persist($banco);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Banco creado con exito", 
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
     * Finds and displays a Banco entity.
     *
     * @Route("/show/{id}", name="banco_show")
     * @Method("POST")
     */
    public function showAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $banco = $em->getRepository('AppBundle:Banco')->find($id);
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Banco con nombre"." ".$banco->getNombre(), 
                    'data'=> $banco,
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
     * Displays a form to edit an existing Banco entity.
     *
     * @Route("/edit", name="banco_edit")
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

            $bancoId = $params->id;
            $nombre = $params->nombre;

            $em = $this->getDoctrine()->getManager();
            $banco = $em->getRepository("AppBundle:Banco")->find($bancoId);

            if ($banco!=null) {
                $banco->setNombre($nombre);
                $em = $this->getDoctrine()->getManager();
                $em->persist($banco);
                $em->flush();

                 $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Banco actualizado con exito", 
                        'data'=> $banco,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El banco no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar banco", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a Banco entity.
     *
     * @Route("/{id}/delete", name="banco_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $banco = $em->getRepository('AppBundle:Banco')->find($id);

            $banco->setEstado(0);
            $em = $this->getDoctrine()->getManager();
                $em->persist($banco);
                $em->flush();
            $response = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "Banco eliminado con exito", 
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
     * Creates a form to delete a Banco entity.
     *
     * @param Banco $banco The Banco entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Banco $banco)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('banco_delete', array('id' => $banco->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

     /**
     * datos para select 2
     *
     * @Route("/select", name="banco_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $bancos = $em->getRepository('AppBundle:Banco')->findBy(
        array('estado' => 1)
    );
      foreach ($bancos as $key => $banco) {
        $response[$key] = array(
            'value' => $banco->getId(),
            'label' => $banco->getNombre(),
            );
      }
       return $helpers->json($response);
    }



     /**
     * busca acreedor por nombre.
     *
     * @Route("/nombre", name="acreedor_show_ide")
     * @Method("POST")
     */
    public function acreedorPorNombre(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);


        if ($authCheck == true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            $usuario = $em->getRepository('AppBundle:Banco')->findOneBy(
                array('nombre' => $params->nombreAcreedor)
            );

            if ($usuario!=null) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro encontrado", 
                    'data'=> $usuario,
            );
            }else{
                 $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Nombre no encontrado en la base de datos", 
                );
            }

            
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($response);
    }
}
