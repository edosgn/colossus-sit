<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Ciudadano;
use Repository\UsuarioBundle\Entity\Usuario;
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
        $em = $this->getDoctrine()->getManager();
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
                $numeroIdentificacion = $params->numeroIdentificacionUsuario;
                $primerNombre = $params->primerNombreUsuario;
                $segundoNombre = $params->segundoNombreUsuario;
                $primerApellido = $params->primerApellidoUsuario;
                $segundoApellido = $params->segundoApellidoUsuario;
                $direccion = (isset($params->direccion)) ? $params->direccion : null;
                $telefonoUsuario = (isset($params->telefonoUsuario)) ? $params->telefonoUsuario : null;
                $correoUsuario = (isset($params->correoUsuario)) ? $params->correoUsuario : null;

                $fechaExpedicionDocumento = (isset($params->fechaExpedicionDocumento)) ? $params->fechaExpedicionDocumento : null;
                $fechaExpedicionDocumentoDateTime = new \DateTime($fechaExpedicionDocumento);
                $edad = (isset($params->edad)) ? $params->edad : null;
                
                $direccionTrabajo = (isset($params->direccionTrabajo)) ? $params->direccionTrabajo : null;
               
                $usuario = $em->getRepository('UsuarioBundle:Usuario')->findBy(
                    array('identificacion' => $numeroIdentificacion)
                ); 
 
                if (!$usuario) {
                    $tipoIdentificacionUsuarioId = $params->tipoIdentificacionUsuarioId;
                    $generoId = (isset($params->generoId)) ? $params->generoId : null;
                    $grupoSanguineoId = (isset($params->grupoSanguineoId)) ? $params->grupoSanguineoId : null;
                    $municipioNacimientoId = (isset($params->municipioNacimientoId)) ? $params->municipioNacimientoId : null;
                    $municipioResidenciaId = (isset($params->municipioResidenciaId)) ? $params->municipioResidenciaId : null;

                    $tipoIdentificacion = $em->getRepository('AppBundle:TipoIdentificacion')->find(
                        $tipoIdentificacionUsuarioId
                    );
                    $genero = $em->getRepository('AppBundle:Genero')->find($generoId);
                    $grupoSanguineo = $em->getRepository('AppBundle:GrupoSanguineo')->find($grupoSanguineoId);
                    $municipioNacimiento = $em->getRepository('AppBundle:Municipio')->find($municipioNacimientoId);
                    $municipioResidencia = $em->getRepository('AppBundle:Municipio')->find($municipioResidenciaId);

                    $ciudadano = new Ciudadano();
                    $ciudadano->setMunicipioNacimiento($municipioNacimiento);
                    $ciudadano->setMunicipioResidencia($municipioResidencia);
                    $ciudadano->setDireccion($direccion);
                    $ciudadano->setFechaExpedicionDocumento($fechaExpedicionDocumentoDateTime);
                    $ciudadano->setEdad($edad);
                    $ciudadano->setGenero($genero);
                    $ciudadano->setGrupoSanguineo($grupoSanguineo);
                    $ciudadano->setDireccionTrabajo($direccionTrabajo);
                    $ciudadano->setEstado(true);
                    $em->persist($ciudadano);
                    $em->flush();


                    $usuario = new Usuario();
                    $usuario->setPrimerNombre($primerNombre);
                    $usuario->setSegundoNombre($segundoNombre);
                    $usuario->setPrimerApellido($primerApellido);
                    $usuario->setSegundoApellido($segundoApellido);
                    $usuario->setTipoIdentificacion($tipoIdentificacion);
                    $usuario->setIdentificacion($numeroIdentificacion);
                    $usuario->setTelefono($telefonoUsuario);
                    $usuario->setCorreo($correoUsuario);
                    $usuario->setEstado("Activo");
                    $usuario->setRole("ROLE_USER");
                    $usuario->setCreatedAt();
                    $usuario->setUpdatedAt();

                    $pwd = hash('sha256', $numeroIdentificacion);
                    $usuario->setPassword($pwd);

                    $em->persist($usuario);
                    $em->flush();
                    
                    $usuario->setCiudadano($ciudadano);
                    $ciudadano->setUsuario($usuario);
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
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $numeroIdentificacion = $params->numeroIdentificacionUsuario;
                $primerNombre = $params->primerNombreUsuario;
                $segundoNombre = $params->segundoNombreUsuario;
                $primerApellido = $params->primerApellidoUsuario;
                $segundoApellido = $params->segundoApellidoUsuario;
                $direccion = (isset($params->direccion)) ? $params->direccion : null;
                $telefonoUsuario = (isset($params->telefonoUsuario)) ? $params->telefonoUsuario : null;
                $correoUsuario = (isset($params->correoUsuario)) ? $params->correoUsuario : null;

                $fechaExpedicionDocumento = (isset($params->fechaExpedicionDocumento)) ? $params->fechaExpedicionDocumento : null;
                $fechaExpedicionDocumentoDateTime = new \DateTime($fechaExpedicionDocumento);
                $edad = (isset($params->edad)) ? $params->edad : null;
                
                $direccionTrabajo = (isset($params->direccionTrabajo)) ? $params->direccionTrabajo : null;
               
                $ciudadano = $em->getRepository('AppBundle:Ciudadano')->find($params->id);
                
 
                if ($ciudadano) {

                    $tipoIdentificacionUsuarioId = $params->tipoIdentificacionUsuarioId;
                    $generoId = (isset($params->generoId)) ? $params->generoId : null;
                    $grupoSanguineoId = (isset($params->grupoSanguineoId)) ? $params->grupoSanguineoId : null;
                    $municipioNacimientoId = (isset($params->municipioNacimientoId)) ? $params->municipioNacimientoId : null;
                    $municipioResidenciaId = (isset($params->municipioResidenciaId)) ? $params->municipioResidenciaId : null;

                    $tipoIdentificacion = $em->getRepository('AppBundle:TipoIdentificacion')->find(
                        $tipoIdentificacionUsuarioId
                    );
                    $genero = $em->getRepository('AppBundle:Genero')->find($generoId);
                    $grupoSanguineo = $em->getRepository('AppBundle:GrupoSanguineo')->find($grupoSanguineoId);
                    $municipioNacimiento = $em->getRepository('AppBundle:Municipio')->find($municipioNacimientoId);
                    $municipioResidencia = $em->getRepository('AppBundle:Municipio')->find($municipioResidenciaId);

                    

                    $ciudadano->setMunicipioNacimiento($municipioNacimiento);
                    $ciudadano->setMunicipioResidencia($municipioResidencia);
                    $ciudadano->setDireccion($direccion);
                    $ciudadano->setFechaExpedicionDocumento($fechaExpedicionDocumentoDateTime);
                    $ciudadano->setEdad($edad);
                    $ciudadano->setGenero($genero);
                    $ciudadano->setGrupoSanguineo($grupoSanguineo);
                    $ciudadano->setDireccionTrabajo($direccionTrabajo);
                    $ciudadano->setEstado(true);
                    $em->flush();

                    $usuario = $ciudadano->getUsuario();

                    $usuario->setPrimerNombre($primerNombre);
                    $usuario->setSegundoNombre($segundoNombre);
                    $usuario->setPrimerApellido($primerApellido);
                    $usuario->setSegundoApellido($segundoApellido);
                    $usuario->setTipoIdentificacion($tipoIdentificacion);
                    $usuario->setIdentificacion($numeroIdentificacion);
                    $usuario->setTelefono($telefonoUsuario);
                    $usuario->setCorreo($correoUsuario);
                    $usuario->setEstado("Activo");
                    $usuario->setRole("ROLE_USER");
                    $usuario->setUpdatedAt();

                    $pwd = hash('sha256', $numeroIdentificacion);
                    $usuario->setPassword($pwd);

                    $em->flush();
                    
                    $usuario->setCiudadano($ciudadano);
                    $ciudadano->setUsuario($usuario);
                    $em->flush();

                 $responce = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Registro actualizado con exito", 
                        'data'=> $ciudadano,
                );
            }else{
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El registro no se encuentra en la base de datos", 
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

    /**
     * datos para select 2
     *
     * @Route("/select", name="ciudadano_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $ciudadanos = $em->getRepository('AppBundle:Ciudadano')->findBy(
        array('estado' => 1)
    );
      foreach ($ciudadanos as $key => $ciudadano) {
        $responce[$key] = array(
            'value' => $ciudadano->getId(),
            'label' => $ciudadano->getNumeroIdentificacion()."_".$ciudadano->getPrimerNombre()." ".$ciudadano->getPrimerApellido(),
            );
      }
       return $helpers->json($responce);
    }

}
