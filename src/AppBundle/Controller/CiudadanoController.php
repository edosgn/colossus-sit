<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Ciudadano;
use AppBundle\Form\CiudadanoType;
 
/**
 * Ciudadano controller.
 *
 * @Route("/ciudadano")
 */
class CiudadanoController extends Controller
{
    /**
     * Lists all Ciudadano entities.
     *
     * @Route("/", name="ciudadano_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $ciudadanos = $em->getRepository('AppBundle:Ciudadano')->findBy(
            array('estado' => 1)
        );
        $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado ciudadanos", 
                    'data'=> $ciudadanos,
            );
         
        return $helpers->json($responce);
    }

    /**
     * Creates a new Ciudadano entity.
     *
     * @Route("/new", name="ciudadano_new")
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
                        $numeroIdentificacion = $params->numeroIdentificacion;
                        $nombres = $params->nombres;
                        $apellidos = $params->apellidos;
                        $direccion = $params->direccion;
                        $telefono = $params->telefono;
                        $correo = $params->correo;
                        $em = $this->getDoctrine()->getManager();
                        $ciudadanos = $em->getRepository('AppBundle:Ciudadano')->findBy(
                            array('correo' => $correo)
                        );

                        if ($ciudadanos==null) {
                            $tipoIdentificacionId = $params->tipoIdentificacionId;
                            $em = $this->getDoctrine()->getManager();
                            $tipoIdentificacion = $em->getRepository('AppBundle:TipoIdentificacion')->find($tipoIdentificacionId);
                            $ciudadano = new Ciudadano();
                            $ciudadano->setNumeroIdentificacion($numeroIdentificacion);
                            $ciudadano->setNombres($nombres);
                            $ciudadano->setApellidos($apellidos);
                            $ciudadano->setDireccion($direccion);
                            $ciudadano->setTelefono($telefono);
                            $ciudadano->setCorreo($correo);
                            $ciudadano->setTipoIdentificacion($tipoIdentificacion);

                            $ciudadano->setEstado(true);

                            $em = $this->getDoctrine()->getManager();
                            $em->persist($ciudadano);
                            $em->flush();

                            $responce = array(
                                'status' => 'success',
                                'code' => 200,
                                'msj' => "ciudadano creado con exito", 
                            );
                        }else{
                           $responce = array(
                                'status' => 'error',
                                'code' => 400,
                                'msj' => "Este correo ya esta registrado en la base de datos", 
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
     * Finds and displays a Ciudadano entity.
     *
     * @Route("/show/{id}", name="ciudadano_show")
     * @Method("POST")
     */
    public function showAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $ciudadano = $em->getRepository('AppBundle:Ciudadano')->find($id);
            $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "ciudadano con nombre"." ".$ciudadano->getNombres(), 
                    'data'=> $ciudadano,
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
     * busca cuidadano por Identificacion.
     *
     * @Route("/cedula", name="ciudadano_show_ide")
     * @Method("POST")
     */
    public function ciudadanoPorIdentificacion(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);


        if ($authCheck == true) {
            $json = $request->get("json",null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            $ciudadano = $em->getRepository('AppBundle:Ciudadano')->findOneBy(
            array('numeroIdentificacion' => $params->numeroIdentificacion)
            );

            $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "cuidadano", 
                    'data'=> $ciudadano,
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
     * Displays a form to edit an existing Ciudadano entity.
     *
     * @Route("/edit", name="ciudadano_edit")
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

            $numeroIdentificacion = $params->numeroIdentificacion;
            $nombres = $params->nombres;
            $apellidos = $params->apellidos;
            $direccion = $params->direccion;
            $telefono = $params->telefono;
            $correo = $params->correo;
            $tipoIdentificacionId = $params->tipoIdentificacionId;
            $em = $this->getDoctrine()->getManager();
            $tipoIdentificacion = $em->getRepository('AppBundle:TipoIdentificacion')->find($tipoIdentificacionId);
            $ciudadano = $em->getRepository("AppBundle:Ciudadano")->find($params->id);

            if ($ciudadano!=null) {
                $ciudadano->setNumeroIdentificacion($numeroIdentificacion);
                $ciudadano->setNombres($nombres);
                $ciudadano->setApellidos($apellidos);
                $ciudadano->setDireccion($direccion);
                $ciudadano->setTelefono($telefono);
                $ciudadano->setCorreo($correo);
                $ciudadano->setTipoIdentificacion($tipoIdentificacion);
                $ciudadano->setEstado(true);

                $em = $this->getDoctrine()->getManager();
                $em->persist($ciudadano);
                $em->flush();

                 $responce = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Ciudadano actualizado con exito", 
                        'data'=> $ciudadano,
                );
            }else{
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El Ciudadano no se encuentra en la base de datos", 
                );
            }
        }else{
            $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar ciudadano", 
                );
        }

        return $helpers->json($responce);
    }

    /**
     * Deletes a Ciudadano entity.
     *
     * @Route("/{id}/delete", name="ciudadano_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $ciudadano = $em->getRepository('AppBundle:Ciudadano')->find($id);

            $ciudadano->setEstado(0);
            $em = $this->getDoctrine()->getManager();
                $em->persist($ciudadano);
                $em->flush();
            $responce = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "ciudadano eliminado con exito", 
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
     * Creates a form to delete a Ciudadano entity.
     *
     * @param Ciudadano $ciudadano The Ciudadano entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Ciudadano $ciudadano)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ciudadano_delete', array('id' => $ciudadano->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
