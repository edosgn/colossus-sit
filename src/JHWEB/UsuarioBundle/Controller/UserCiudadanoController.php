<?php

namespace JHWEB\UsuarioBundle\Controller;

use JHWEB\UsuarioBundle\Entity\UserCiudadano;
use Repository\UsuarioBundle\Entity\Usuario;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Userciudadano controller.
 *
 * @Route("userciudadano")
 */
class UserCiudadanoController extends Controller
{
    /**
     * Lists all userCiudadano entities.
     *
     * @Route("/", name="userciudadano_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $ciudadanos = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findBy(
            array(
                'activo' => true
            )
        );

        $response['data'] = array();

        if ($ciudadanos) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($ciudadanos)." registros encontrados", 
                'data'=> $ciudadanos,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new userCiudadano entity.
     *
     * @Route("/new", name="userciudadano_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $ciudadanoOld = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findBy(
                array(
                    'identificacion' => $params->ciudadano->identificacion,
                    'tipoIdentificacion'=> $params->ciudadano->idTipoIdentificacion
                )
            );

            if (!$ciudadanoOld) {
                $ciudadano = new UserCiudadano();

                $primerNombre = mb_strtoupper(
                    $params->ciudadano->primerNombre, 'utf-8'
                );
                $ciudadano->setPrimerNombre($primerNombre);

                $ciudadano->setSegundoNombre(
                    mb_strtoupper(
                        $params->ciudadano->segundoNombre, 'utf-8'
                    )
                );

                $primerApellido = mb_strtoupper(
                    $params->ciudadano->primerApellido, 'utf-8'
                );
                $ciudadano->setPrimerApellido($primerApellido);

                $ciudadano->setSegundoApellido(
                    mb_strtoupper(
                        $params->ciudadano->segundoApellido, 'utf-8'
                    )
                );

                $ciudadano->setIdentificacion(
                    $params->ciudadano->identificacion
                );

                $ciudadano->setTelefono($params->ciudadano->telefono);

                if ($params->ciudadano->fechaNacimiento) {
                    $ciudadano->setFechaNacimiento(
                        new \DateTime($params->ciudadano->fechaNacimiento)
                    );
                }

                if ($params->ciudadano->fechaExpedicionDocumento) {
                    $ciudadano->setFechaExpedicionDocumento(
                        new \DateTime(
                            $params->ciudadano->fechaExpedicionDocumento
                        )
                    );
                }

                $ciudadano->setDireccionPersonal(
                    $params->ciudadano->direccionPersonal
                );

                if ($params->ciudadano->direccionTrabajo) {
                    $ciudadano->setDireccionTrabajo(
                        $params->ciudadano->direccionTrabajo
                    );
                }

                if($params->campo && $params->campo == 'importacion-temporal'){
                    $ciudadano->setEnrolado(false);
                }else {                       
                    $ciudadano->setEnrolado(true);
                }

                $ciudadano->setActivo(true);

                $tipoIdentificacion = $em->getRepository('JHWEBUsuarioBundle:UserCfgTipoIdentificacion')->find(
                    $params->ciudadano->idTipoIdentificacion
                );
                $ciudadano->setTipoIdentificacion($tipoIdentificacion);

                if ($params->ciudadano->idMunicipioNacimiento) {
                    $municipioNacimiento = $em->getRepository('JHWEBConfigBundle:CfgMunicipio')->find(
                        $params->ciudadano->idMunicipioNacimiento
                    );
                    $ciudadano->setMunicipioNacimiento($municipioNacimiento);
                }

                if ($params->ciudadano->idMunicipioResidencia) {
                    $municipioResidencia = $em->getRepository('JHWEBConfigBundle:CfgMunicipio')->find(
                        $params->ciudadano->idMunicipioResidencia
                    );
                    $ciudadano->setMunicipioResidencia($municipioResidencia);
                }

                if ($params->ciudadano->idGenero) {
                    $genero = $em->getRepository('JHWEBUsuarioBundle:UserCfgGenero')->find($params->ciudadano->idGenero);
                    $ciudadano->setGenero($genero);
                }

                if ($params->ciudadano->idGrupoSanguineo) {
                    $grupoSanguineo = $em->getRepository('JHWEBUsuarioBundle:UserCfgGrupoSanguineo')->find($params->ciudadano->idGrupoSanguineo);
                    $ciudadano->setGrupoSanguineo($grupoSanguineo);
                }

                $usuario = new Usuario();

                $usuario->setCorreo($params->ciudadano->correo);
                $usuario->setActivo(true);
                $usuario->setRole("ROLE_USER");

                $password = $primerNombre[0].$primerApellido[0].$params->ciudadano->identificacion;
                $password = hash('sha256', $password);
                $usuario->setPassword($password);

                $usuario->setCreatedAt();
                $usuario->setUpdatedAt();    

                $em->persist($usuario);
                $ciudadano->setUsuario($usuario);

                $em->persist($ciudadano);
                $usuario->setCiudadano($ciudadano);

                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro creado con exito.", 
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "La identificacion ya esta registrada en la base de datos.", 
                );
            }
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Finds and displays a userCiudadano entity.
     *
     * @Route("/show", name="userciudadano_show")
     * @Method("GET")
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->find($params->id);

            $em->persist($ciudadano);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro encontrado con exito",
                'data' => $ciudadano
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing userCiudadano entity.
     *
     * @Route("/edit", name="userciudadano_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->find($params->ciudadano->id);

            if ($ciudadano) {
                $primerNombre = mb_strtoupper(
                    $params->ciudadano->primerNombre, 'utf-8'
                );
                $ciudadano->setPrimerNombre($primerNombre);

                $ciudadano->setSegundoNombre(
                    mb_strtoupper(
                        $params->ciudadano->segundoNombre, 'utf-8'
                    )
                );

                $primerApellido = mb_strtoupper(
                    $params->ciudadano->primerApellido, 'utf-8'
                );
                $ciudadano->setPrimerApellido($primerApellido);

                $ciudadano->setSegundoApellido(
                    mb_strtoupper(
                        $params->ciudadano->segundoApellido, 'utf-8'
                    )
                );

                $ciudadano->setIdentificacion(
                    $params->ciudadano->identificacion
                );

                $ciudadano->setTelefono($params->ciudadano->telefono);

                if ($params->ciudadano->fechaNacimiento) {
                    $ciudadano->setFechaNacimiento(
                        new \DateTime($params->ciudadano->fechaNacimiento)
                    );
                }

                if ($params->ciudadano->fechaExpedicionDocumento) {
                    $ciudadano->setFechaExpedicionDocumento(
                        new \DateTime(
                            $params->ciudadano->fechaExpedicionDocumento
                        )
                    );
                }

                $ciudadano->setDireccionPersonal(
                    $params->ciudadano->direccionPersonal
                );

                if ($params->ciudadano->direccionTrabajo) {
                    $ciudadano->setDireccionTrabajo(
                        $params->ciudadano->direccionTrabajo
                    );
                }

                $tipoIdentificacion = $em->getRepository('JHWEBUsuarioBundle:UserCfgTipoIdentificacion')->find(
                    $params->ciudadano->idTipoIdentificacion
                );
                $ciudadano->setTipoIdentificacion($tipoIdentificacion);

                if ($params->ciudadano->idMunicipioNacimiento) {
                    $municipioNacimiento = $em->getRepository('JHWEBConfigBundle:CfgMunicipio')->find(
                        $params->ciudadano->idMunicipioNacimiento
                    );
                    $ciudadano->setMunicipioNacimiento($municipioNacimiento);
                }

                if ($params->ciudadano->idMunicipioResidencia) {
                    $municipioResidencia = $em->getRepository('JHWEBConfigBundle:CfgMunicipio')->find(
                        $params->ciudadano->idMunicipioResidencia
                    );
                    $ciudadano->setMunicipioResidencia($municipioResidencia);
                }

                if ($params->ciudadano->idGenero) {
                    $genero = $em->getRepository('JHWEBUsuarioBundle:UserCfgGenero')->find($params->ciudadano->idGenero);
                    $ciudadano->setGenero($genero);
                }

                if ($params->ciudadano->idGrupoSanguineo) {
                    $grupoSanguineo = $em->getRepository('JHWEBUsuarioBundle:UserCfgGrupoSanguineo')->find($params->ciudadano->idGrupoSanguineo);
                    $ciudadano->setGrupoSanguineo($grupoSanguineo);
                }

                $em->persist($ciudadano);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $ciudadano,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos",
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida para editar",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Deletes a userCiudadano entity.
     *
     * @Route("/delete", name="userciudadano_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", true);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $json = $request->get("data", null);
            $params = json_decode($json);

            $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->find($params->id);

            $ciudadano->setActivo(false);

            $em->persist($ciudadano);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro eliminado con éxito.",
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no válida",
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a userCiudadano entity.
     *
     * @param UserCiudadano $userCiudadano The userCiudadano entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(UserCiudadano $userCiudadano)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('userciudadano_delete', array('id' => $userCiudadano->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ========================================================== */

    /**
     * Listado de ciudadanos para seleccion con búsqueda
     *
     * @Route("/select", name="userciudadano_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $ciudadanos = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findBy(
            array('activo' => true)
        );
        $response = null;

        foreach ($ciudadanos as $key => $ciudadano) {
            $response[$key] = array(
                'value' => $ciudadano->getId(),
                'label' => $ciudadano->getIdentificacion()."_".$ciudadano->getPrimerNombre()." ".$ciudadano->getPrimerApellido(),
            );
        }
       return $helpers->json($response);
    }

    /**
     * Busca cuidadano por Identificacion.
     *
     * @Route("/search/identificacion", name="userciudadano_search_identificacion")
     * @Method({"GET", "POST"})
     */
    public function searchByIdentificacionAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();   
            
            $ciudadano = null;
            $empresa = null;

            if($params->idTipoIdentificacion == 4) {
                $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->findOneBy(
                    array(
                        'nit' => $params->nit,
                        'activo' => true,
                    )
                );
            } elseif($params->idTipoIdentificacion != 4) {
                $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findOneBy(
                    array(
                        'identificacion' => $params->identificacion,
                        'activo' => true,
                    )
                );
            }

            if ($ciudadano || $empresa) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Registro encontrado.', 
                    'data'=> array(
                        'ciudadano' => $ciudadano,
                        'empresa' => $empresa,
                    )
                );
            }else{
                 $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'No se encontró ningun registro en la base de datos.', 
                );
            }
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida.', 
            );
        }

        return $helpers->json($response);
    }

    /**
     * Calcula edad según fecha de nacimiento.
     *
     * @Route("/calculate/age", name="userciudadano_calculate_age")
     * @Method({"GET", "POST"})
     */
    public function calculateAgeAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $edad = $this->get("app.helpers")->calculateAge(
                $params->fechaNacimiento
            );

            if ($edad) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado", 
                    'data'=> $edad,
                );
            }else{
                 $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No se pudo calcular la edad", 
                );
            }
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
            );
        }
        return $helpers->json($response);
    }

    /**
     * Busca ciudadanos por parametros (identificacion, nombres y/o apellidos).
     *
     * @Route("/search/filtros", name="userciudadano_search_filtros")
     * @Method({"GET","POST"})
     */
    public function searchByFiltros(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $ciudadanos = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->getByFilter(
                $params
            );

            if ($ciudadanos) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($ciudadanos)." ciudadanos encontrados", 
                    'data' => $ciudadanos,
            );
            }else{
                 $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'No existen ciudadanos para esos filtros de búsqueda, si desea registralo por favor presione el botón "NUEVO"', 
                );
            }

            
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
            );
        }
        return $helpers->json($response);
    }
}
