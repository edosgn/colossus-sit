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
                        $primerNombre = $params->primerNombre;
                        $segundoNombre = $params->segundoNombre;
                        $primerApellido = $params->primerApellido;
                        $segundoApellido = $params->segundoApellido;
                        $direccion = (isset($params->direccion)) ? $params->direccion : null;
                        $telefono = (isset($params->telefono)) ? $params->telefono : null;
                        $correo = (isset($params->correo)) ? $params->correo : null;

                        $fechaExpedicionDocumento = (isset($params->fechaExpedicionDocumento)) ? $params->fechaExpedicionDocumento : null;
                        $fechaExpedicionDocumentoDateTime = new \DateTime($fechaExpedicionDocumento);
                        $edad = (isset($params->edad)) ? $params->edad : null;
                        $genero = (isset($params->genero)) ? $params->genero : null;
                        $grupoSanguineo = (isset($params->grupoSanguineo)) ? $params->grupoSanguineo : null;
                        
                        $direccionTrabajo = (isset($params->direccionTrabajo)) ? $params->direccionTrabajo : null;
                        $em = $this->getDoctrine()->getManager();
                        $ciudadanos = $em->getRepository('AppBundle:Ciudadano')->findBy(
                            array('numeroIdentificacion' => $numeroIdentificacion)
                        ); 

                        if ($ciudadanos==null) {
                            $tipoIdentificacionId = $params->tipoIdentificacionId;
                            $municipioNacimientoId = $params->municipioNacimientoId;
                            $municipioResidenciaId = $params->municipioResidenciaId;
                            $em = $this->getDoctrine()->getManager();
                            $tipoIdentificacion = $em->getRepository('AppBundle:TipoIdentificacion')->find($tipoIdentificacionId);
                            $municipioNacimiento = $em->getRepository('AppBundle:Municipio')->find($municipioNacimientoId);
                            $municipioResidencia = $em->getRepository('AppBundle:Municipio')->find($municipioResidenciaId);

                            $ciudadano = new Ciudadano();
                            $ciudadano->setNumeroIdentificacion($numeroIdentificacion);
                            $ciudadano->setMunicipioNacimiento($municipioNacimiento);
                            $ciudadano->setMunicipioResidencia($municipioResidencia);
                            $ciudadano->setPrimerNombre($primerNombre);
                            $ciudadano->setSegundoNombre($segundoNombre);
                            $ciudadano->setPrimerApellido($primerApellido);
                            $ciudadano->setSegundoApellido($segundoApellido);
                            $ciudadano->setDireccion($direccion);
                            $ciudadano->setTelefono($telefono);
                            $ciudadano->setCorreo($correo);

                            $ciudadano->setFechaExpedicionDocumento($fechaExpedicionDocumentoDateTime);
                            $ciudadano->setEdad($edad);
                            $ciudadano->setGenero($genero);
                            $ciudadano->setGrupoSanguineo($grupoSanguineo);
                            $ciudadano->setDireccionTrabajo($direccionTrabajo);
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
                                'msj' => "Identificacion ya esta registrada en la base de datos", 
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

            if ($ciudadano!=null) {
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
                    'msj' => "Identificacion no encontrada en la base de datos", 
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
            $primerNombre = $params->primerNombre;
            $segundoNombre = $params->segundoNombre;
            $primerApellido = $params->primerApellido;
            $segundoApellido = $params->segundoApellido;
            $direccion = (isset($params->direccion)) ? $params->direccion : null;
            $telefono = (isset($params->telefono)) ? $params->telefono : null;
            $correo = (isset($params->correo)) ? $params->correo : null;

            $fechaExpedicionDocumento = (isset($params->fechaExpedicionDocumento)) ? $params->fechaExpedicionDocumento : null;
            $fechaExpedicionDocumentoDateTime = new \DateTime($fechaExpedicionDocumento);
            $edad = (isset($params->edad)) ? $params->edad : null;
            $genero = (isset($params->genero)) ? $params->genero : null;
            $grupoSanguineo = (isset($params->grupoSanguineo)) ? $params->grupoSanguineo : null;
            
            $direccionTrabajo = (isset($params->direccionTrabajo)) ? $params->direccionTrabajo : null;

            $tipoIdentificacionId = $params->tipoIdentificacionId;
            $municipioNacimientoId = $params->municipioNacimientoId;
            $municipioResidenciaId = $params->municipioResidenciaId;
            
            $em = $this->getDoctrine()->getManager();
            $tipoIdentificacion = $em->getRepository('AppBundle:TipoIdentificacion')->find($tipoIdentificacionId);
            $municipioNacimiento = $em->getRepository('AppBundle:Municipio')->find($municipioNacimientoId);
            $municipioResidencia = $em->getRepository('AppBundle:Municipio')->find($municipioResidenciaId);


            $ciudadano = $em->getRepository("AppBundle:Ciudadano")->find($params->id);

            if ($ciudadano!=null) {
                $ciudadano->setNumeroIdentificacion($numeroIdentificacion);
                $ciudadano->setMunicipioNacimiento($municipioNacimiento);
                $ciudadano->setMunicipioResidencia($municipioResidencia);
                $ciudadano->setPrimerNombre($primerNombre);
                $ciudadano->setSegundoNombre($segundoNombre);
                $ciudadano->setPrimerApellido($primerApellido);
                $ciudadano->setSegundoApellido($segundoApellido);
                $ciudadano->setDireccion($direccion);
                $ciudadano->setTelefono($telefono);
                $ciudadano->setCorreo($correo);

                $ciudadano->setFechaExpedicionDocumento($fechaExpedicionDocumentoDateTime);
                $ciudadano->setEdad($edad);
                $ciudadano->setGenero($genero);
                $ciudadano->setGrupoSanguineo($grupoSanguineo);
                $ciudadano->setDireccionTrabajo($direccionTrabajo);
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
