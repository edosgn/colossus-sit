<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Modulo;
use AppBundle\Form\ModuloType;

/**
 * Modulo controller.
 *
 * @Route("/modulo")
 */
class ModuloController extends Controller
{
    /**
     * Lists all Modulo entities.
     *
     * @Route("/", name="modulo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $modulo = $em->getRepository('AppBundle:Modulo')->findBy(
            array('estado' => 1)
        );
        $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado modulo", 
                    'data'=> $modulo,
            );
         
        return $helpers->json($responce);
    }

    /**
     * Creates a new Modulo entity.
     *
     * @Route("/new", name="modulo_new")
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
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "los campos no pueden estar vacios", 
                );
            }else{*/
                $nombre = $params->nombre;
                $abreviatura = $params->abreviatura;
                $descripcion = (isset($params->descripcion)) ? $params->descripcion : null;

                $modulo = new Modulo();

                $modulo->setNombre($nombre);
                $modulo->setAbreviatura($abreviatura);
                $modulo->setDescripcion($descripcion);
                $modulo->setEstado(true);

                $em = $this->getDoctrine()->getManager();
                $em->persist($modulo);
                $em->flush();

                $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Modulo creado con exito", 
                );
                       
            //}
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
     * Finds and displays a Modulo entity.
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
            $modulo = $em->getRepository('AppBundle:Modulo')->find($id);
            $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "modulo con nombre"." ".$modulo->getNombre(), 
                    'data'=> $modulo,
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
     * @Route("/edit", name="Modulo_edit")
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
            $em = $this->getDoctrine()->getManager();
            $modulo = $em->getRepository("AppBundle:Modulo")->find($params->id);

            if ($modulo!=null) {
                $nombre = $params->nombre;
                $abreviatura = $params->abreviatura;
                $descripcion = (isset($params->descripcion)) ? $params->descripcion : null;

                $modulo->setNombre($nombre);
                $modulo->setAbreviatura($abreviatura);
                $modulo->setDescripcion($descripcion);
                $modulo->setEstado(true);

                $em = $this->getDoctrine()->getManager();
                $em->persist($modulo);
                $em->flush();
                $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Modulo editado con exito", 
                );
            }else{
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El modulo no se encuentra en la base de datos", 
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
     * Deletes a Modulo entity.
     *
     * @Route("/{id}/delete", name="modulo_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $modulo = $em->getRepository('AppBundle:Modulo')->find($id);

            $modulo->setEstado(0);
            $em = $this->getDoctrine()->getManager();
                $em->persist($modulo);
                $em->flush();
            $responce = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "modulo eliminado con exito", 
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
     * Creates a form to delete a Modulo entity.
     *
     * @param Modulo $modulo The Modulo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Modulo $modulo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('modulo_delete', array('id' => $modulo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="modulo_select")
     * @Method({"GET", "POST"})
    */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $modulos = $em->getRepository('AppBundle:Modulo')->findBy(
        array('estado' => 1)
    );
    if ($modulos == null) {
       $responce = null;
    }
      foreach ($modulos as $key => $modulo) {
        $responce[$key] = array(
            'value' => $modulo->getId(),
            'label' => $modulo->getAbreviatura()."_".$modulo->getNombre(),
            );
      }
       return $helpers->json($responce);
    }
}
