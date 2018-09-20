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
     * @Method({"GET", "POST"})
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $ciudadanos = $em->getRepository('AppBundle:Ciudadano')->findBy(
            array('estado' => 1)
        );
        $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado ciudadanos", 
                    'data'=> $ciudadanos,
            );
         
        return $helpers->json($response);
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
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "los campos no pueden estar vacios", 
                );
            }else{*/
                $numeroIdentificacion = $params->numeroIdentificacionUsuario;
                $tipoIdentificacionUsuarioId = $params->tipoIdentificacionUsuarioId;
                $primerNombre = $params->primerNombreUsuario;
                $segundoNombre = $params->segundoNombreUsuario;
                $primerApellido = $params->primerApellidoUsuario;
                $segundoApellido = $params->segundoApellidoUsuario;
                $direccion = (isset($params->direccion)) ? $params->direccion : null;
                $telefonoUsuario = (isset($params->telefonoUsuario)) ? $params->telefonoUsuario : null;
                $correoUsuario = (isset($params->correoUsuario)) ? $params->correoUsuario : null;
                $fechaNacimiento = (isset($params->fechaNacimiento)) ? $params->fechaNacimiento : null;
                $fechaNacimientoDateTime = new \DateTime($fechaNacimiento);
                

                $fechaExpedicionDocumento = (isset($params->fechaExpedicionDocumento)) ? $params->fechaExpedicionDocumento : null;
                $fechaExpedicionDocumentoDateTime = new \DateTime($fechaExpedicionDocumento);
                
                $direccionTrabajo = (isset($params->direccionTrabajo)) ? $params->direccionTrabajo : null;
               
                $usuario = $em->getRepository('UsuarioBundle:Usuario')->findBy(
                    array('identificacion' => $numeroIdentificacion,'tipoIdentificacion'=>$tipoIdentificacionUsuarioId)
                ); 
 
                if (!$usuario) {
                    $generoId = (isset($params->generoId)) ? $params->generoId : null;
                    $grupoSanguineoId = (isset($params->grupoSanguineoId)) ? $params->grupoSanguineoId : null;
                    $municipioNacimientoId = (isset($params->municipioNacimientoId)) ? $params->municipioNacimientoId : null;
                    $municipioResidenciaId = (isset($params->municipioResidenciaId)) ? $params->municipioResidenciaId : null;

                    $tipoIdentificacion = $em->getRepository('AppBundle:TipoIdentificacion')->find($tipoIdentificacionUsuarioId);
                    
                    $genero = $em->getRepository('AppBundle:Genero')->find($generoId);
                    $grupoSanguineo = $em->getRepository('AppBundle:GrupoSanguineo')->find($grupoSanguineoId);
                    $municipioNacimiento = $em->getRepository('AppBundle:Municipio')->find($municipioNacimientoId);
                    $municipioResidencia = $em->getRepository('AppBundle:Municipio')->find($municipioResidenciaId);

                    $ciudadano = new Ciudadano();
                    $ciudadano->setMunicipioNacimiento($municipioNacimiento);
                    $ciudadano->setMunicipioResidencia($municipioResidencia);
                    $ciudadano->setDireccion($direccion);
                    $ciudadano->setFechaExpedicionDocumento($fechaExpedicionDocumentoDateTime);
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
                    $usuario->setFechaNacimiento($fechaNacimientoDateTime);
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
                    

                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "ciudadano creado con exito", 
                    );
                }else{
                   $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'msj' => "Identificacion ya esta registrada en la base de datos", 
                    ); 
                }
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
     * Finds and displays a Ciudadano entity.
     *
     * @Route("/show", name="ciudadano_show")
     * @Method("POST")
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $ciudadano = $em->getRepository('AppBundle:Ciudadano')->findOneByEstado(true);
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'data'=> $ciudadano,
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
            $direccionTrabajo = (isset($params->direccionTrabajo)) ? $params->direccionTrabajo : null;
            
            $ciudadano = $em->getRepository('AppBundle:Ciudadano')->find($params->id);
                
 
                if ($ciudadano) {

                    $tipoIdentificacionUsuarioId = $params->tipoIdentificacionUsuarioId;
                    $generoId = (isset($params->generoId)) ? $params->generoId : null;
                    $grupoSanguineoId = (isset($params->grupoSanguineoId)) ? $params->grupoSanguineoId : null;
                    $municipioNacimientoId = (isset($params->municipioNacimientoId)) ? $params->municipioNacimientoId : null;
                    $municipioResidenciaId = (isset($params->municipioResidenciaId)) ? $params->municipioResidenciaId : null;

                    $tipoIdentificacion = $em->getRepository('AppBundle:TipoIdentificacion')->find($tipoIdentificacionUsuarioId);
                    $genero = $em->getRepository('AppBundle:Genero')->find($generoId);
                    $grupoSanguineo = $em->getRepository('AppBundle:GrupoSanguineo')->find($grupoSanguineoId);
                    $municipioNacimiento = $em->getRepository('AppBundle:Municipio')->find($municipioNacimientoId);
                    $municipioResidencia = $em->getRepository('AppBundle:Municipio')->find($municipioResidenciaId);

                    

                    $ciudadano->setMunicipioNacimiento($municipioNacimiento);
                    $ciudadano->setMunicipioResidencia($municipioResidencia);
                    $ciudadano->setDireccion($direccion);
                    $ciudadano->setFechaExpedicionDocumento($fechaExpedicionDocumentoDateTime);
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

                 $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Registro actualizado con exito", 
                        'data'=> $ciudadano,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El registro no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar ciudadano", 
                );
        }

        return $helpers->json($response);
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
            $response = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "ciudadano eliminado con exito", 
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

    /* ========================================================== */

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
        $response[$key] = array(
            'value' => $ciudadano->getId(),
            'label' => $ciudadano->getUsuario()->getIdentificacion()."_".$ciudadano->getUsuario()->getPrimerNombre()." ".$ciudadano->getUsuario()->getPrimerApellido(),
            );
      }
       return $helpers->json($response);
    }

    /**
     * busca cuidadano por Identificacion.
     *
     * @Route("/search/identificacion", name="ciudadano_search_identificacion")
     * @Method({"GET", "POST"})
     */
    public function searchByIdentificacionAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            $usuario = $em->getRepository('UsuarioBundle:Usuario')->findOneBy(
                array('identificacion' => $params->numeroIdentificacion)
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
                    'msj' => "Identificacion no encontrada en la base de datos", 
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

    /**
     * Calcula edad según fecha de nacimiento.
     *
     * @Route("/calculate/age", name="ciudadano_calculate_age")
     * @Method({"GET", "POST"})
     */
    public function calculateAgeAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $edad = $this->get("app.helpers")->calculateAge($params->fechaNacimiento);

            if ($edad) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro encontrado", 
                    'data'=> $edad,
                );
            }else{
                 $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "No se pudo calcular la edad", 
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

    /**
     * busca cuidadano por Identificacion.
     *
     * @Route("/acreedor/id", name="acreedor_ciudadano_show_ide")
     * @Method("POST")
     */
    public function ciudadanoPorId(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            $usuario = $em->getRepository('UsuarioBundle:Usuario')->findOneBy(
                array('identificacion' => $params->cedula)
            );

            if ($usuario!=null) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado", 
                    'data'=> $usuario,
            );
            }else{
                 $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Identificación no encontrada en la base de datos", 
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

    /**
     * Deletes a Ciudadano entity.
     *
     * @Route("/isCiudadano/tipoIde/Ide", name="ciudadano_tipo_ide")
     * @Method("POST")
     */
    public function isCiudadanoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $json = $request->get("json",null);
            $params = json_decode($json);
            $numeroIdentificacion = $params->identificacion;
            $tipoIdentificacionUsuarioId = $params->tipoIdentificacion;
            $em = $this->getDoctrine()->getManager();
            // var_dump($numeroIdentificacion);
            // die();
            $usuario = $em->getRepository('UsuarioBundle:Usuario')->findOneBy(
                array('identificacion' => $numeroIdentificacion,'tipoIdentificacion'=>$tipoIdentificacionUsuarioId)
            ); 
            if ($usuario) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Identificacion ya esta registrada en la base de datos", 
                    'datos' => $usuario, 
                );
                return $helpers->json($response);
            }else{

                $response = array(
                        'status' => 'success',
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
