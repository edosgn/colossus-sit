<?php

namespace JHWEB\UsuarioBundle\Controller;

use JHWEB\UsuarioBundle\Entity\UserEmpresa;
use JHWEB\UsuarioBundle\Entity\UserEmpresaRepresentante;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Userempresa controller.
 *
 * @Route("userempresa")
 */
class UserEmpresaController extends Controller
{
    /**
     * Lists all userEmpresa entities.
     *
     * @Route("/", name="userempresaA_index")
     * @Method("GET") 
     */ 
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $empresas = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($empresas) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($empresas) . " registros encontrados",
                'data' => $empresas,
            );
        }
        return $helpers->json($response);
    }

    /**
     * Lists all Empresa entities.
     *
     * @Route("/index/empresaAlcaldia", name="user_empresaAlcaldia_index")
     * @Method("GET")
     */
    public function indexEmpresaAlcaldiaAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $empresas = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->findBy(
            array('activo' => 1,'tipoEmpresa'=>1)
        );

        $response['data'] = array();

        $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado empresas", 
                    'data'=> $empresas,
            );
         
        return $helpers->json($response);
    }

    /**
     * Creates a new userEmpresa entity.
     *
     * @Route("/new", name="userempresa_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $empresaExistente =$em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->findOneBy(
                array(
                    'nit' => $params->empresa->nit,
                    'activo' => true
                )
            );

            if($empresaExistente){
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El nit que intenta registrar ya existe en la base de datos.",
                );
            }
            else {
                $tipoSociedad = $em->getRepository('JHWEBUsuarioBundle:UserCfgEmpresaTipoSociedad')->find($params->empresa->idTipoSociedad);
                $tipoEmpresa = $em->getRepository('JHWEBUsuarioBundle:UserCfgEmpresaTipo')->find($params->empresa->idTipoEmpresa);
                $tipoIdentificacion = $em->getRepository('JHWEBUsuarioBundle:UserCfgTipoIdentificacion')->find($params->empresa->idTipoIdentificacion);
                $municipio = $em->getRepository('JHWEBConfigBundle:CfgMunicipio')->find($params->empresa->idMunicipio);
                $empresaServicio = $em->getRepository('JHWEBUsuarioBundle:UserCfgEmpresaServicio')->find($params->empresa->idEmpresaServicio);
                
                
                $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->find($params->empresa->idCiudadano);
                
                $empresa = new UserEmpresa();
                
                $empresa->setNombre($params->empresa->nombre);
                $empresa->setSigla($params->empresa->sigla);
                $empresa->setNit($params->empresa->nit);
                $empresa->setDv($params->empresa->dv);
                $empresa->setCapitalPagado($params->empresa->capitalPagado);
                $empresa->setCapitalLiquido($params->empresa->capitalPagado);
                $empresa->setEmpresaPrestadora($params->empresa->empresaPrestadora);
                $empresa->setCertificadoExistencial($params->empresa->certificadoExistencial);
                $empresa->setTipoSociedad($tipoSociedad);
                $empresa->setTipoIdentificacion($tipoIdentificacion);
                $empresa->setTipoEntidad($params->empresa->tipoEntidad);
                $empresa->setTipoEmpresa($tipoEmpresa);
                $empresa->setMunicipio($municipio);
                $empresa->setNroRegistroMercantil($params->empresa->nroRegistroMercantil);
                $empresa->setFechaVencimientoRegistroMercantil(new \Datetime($params->empresa->fechaVencimientoRegistroMercantil));
                $empresa->setTelefono($params->empresa->telefono);
                $empresa->setDireccion($params->empresa->direccion);
                $empresa->setCelular($params->empresa->celular);
                $empresa->setCorreo($params->empresa->correo);
                $empresa->setFax($params->empresa->fax);
                $empresa->setCiudadano($ciudadano);
                $empresa->setEmpresaServicio($empresaServicio);
                $empresa->setActivo(true);
                
                $empresaRepresentante = new UserEmpresaRepresentante();
                
                $empresaRepresentante->setEmpresa($empresa);
                $empresaRepresentante->setCiudadano($ciudadano);
                $empresaRepresentante->setFechaInicial(new \Datetime($params->empresa->fechaInicial));
                $empresaRepresentante->setActivo(true);
                
                $empresa->setEmpresaRepresentante($empresaRepresentante);
                
                $em->persist($empresa);
                $em->persist($empresaRepresentante);
                $em->flush();


                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Empresa creado con éxito",
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Finds and displays a userEmpresa entity.
     *
     * @Route("/show", name="userempresa_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->find(
                $params->id
            );

            $em->persist($empresa);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro encontrado con exito",
                'data' => $empresa,
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing userEmpresa entity.
     *
     * @Route("/edit", name="userempresa_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $empresaRepresentanteActual = $em->getRepository('JHWEBUsuarioBundle:UserEmpresaRepresentante')->findOneBy(
                array(
                    'id' => $params->idRepresentante,
                    'activo' => true
                )
            );

            if($empresaRepresentanteActual) {
                $empresaRepresentanteActual->setActivo(false);
                $em->persist($empresaRepresentanteActual);
            }

            $empresa = $em->getRepository("JHWEBUsuarioBundle:UserEmpresa")->find($params->empresa->id);

            if ($empresa) {
                if($params->nuevaFechaInicial) {
                    $empresa->setFechaVencimientoRegistroMercantil(new \Datetime($params->nuevaFechaInicial));
                }   

                $tipoSociedad = $em->getRepository('JHWEBUsuarioBundle:UserCfgEmpresaTipoSociedad')->find($params->empresa->idTipoSociedad);
                $empresa->setTipoSociedad($tipoSociedad);

                $tipoEmpresa = $em->getRepository('JHWEBUsuarioBundle:UserCfgEmpresaTipo')->find($params->empresa->idTipoEmpresa[0]);
                $empresa->setTipoEmpresa($tipoEmpresa);

                $tipoIdentificacion = $em->getRepository('JHWEBUsuarioBundle:UserCfgTipoIdentificacion')->find($params->empresa->idTipoIdentificacion);
                $empresa->setTipoIdentificacion($tipoIdentificacion);

                $municipio = $em->getRepository('JHWEBConfigBundle:CfgMunicipio')->find($params->empresa->idMunicipio);
                $empresa->setMunicipio($municipio);

                $empresaServicio = $em->getRepository('JHWEBUsuarioBundle:UserCfgEmpresaServicio')->find($params->empresa->idEmpresaServicio);
                $empresa->setEmpresaServicio($empresaServicio);
                
                
                $empresa->setNombre($params->empresa->nombre);
                $empresa->setSigla($params->empresa->sigla);
                $empresa->setNit($params->empresa->nit);
                $empresa->setDv($params->empresa->dv);
                $empresa->setCapitalPagado($params->empresa->capitalPagado);
                $empresa->setCapitalLiquido($params->empresa->capitalPagado);
                $empresa->setEmpresaPrestadora($params->empresa->empresaPrestadora);
                $empresa->setCertificadoExistencial($params->empresa->certificadoExistencial);
                $empresa->setTipoEntidad($params->empresa->tipoEntidad);
                $empresa->setNroRegistroMercantil($params->empresa->nroRegistroMercantil);
                $empresa->setTelefono($params->empresa->telefono);
                $empresa->setDireccion($params->empresa->direccion);
                $empresa->setCelular($params->empresa->celular);
                $empresa->setCorreo($params->empresa->correo);
                $empresa->setFax($params->empresa->fax);

                $em->persist($empresa);
                
                //creación de nuevo representante
                $empresaRepresentante = new UserEmpresaRepresentante();
                
                $empresaRepresentante->setEmpresa($empresa);

                $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->find(
                    $params->idCiudadano
                );
                $empresaRepresentante->setCiudadano($ciudadano);

                $empresaRepresentante->setFechaInicial(new \Datetime($params->nuevaFechaInicial));
                $empresaRepresentante->setActivo(true);
                
                $em->persist($empresaRepresentante);
                $em->flush();

                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Empresa editada con exito", 
                );

            }else{
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "La empresa no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida", 
            );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a userEmpresa entity.
     *
     * @Route("/delete", name="userempresa_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->find(
                $params->id
            );

            if ($empresa) {
                $empresa->setActivo(false);
    
                $em->persist($empresa);
                $em->flush();
    
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro eliminado con éxito.",
                    'data' => $empresa,
                );
            }else{
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos.",
                );
            }

        } else {
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no valida.",
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a userEmpresa entity.
     *
     * @param UserEmpresa $userEmpresa The userEmpresa entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(UserEmpresa $userEmpresa)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('userempresa_delete', array('id' => $userEmpresa->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ============================================================*/

    /**
     * Activa el registro seleccionado.
     *
     * @Route("/active", name="userempresa_active")
     * @Method("POST")
     */
    public function activeAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", true);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $json = $request->get("data", null);
            $params = json_decode($json);

            $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->find(
                $params->id
            );

            $empresa->setActivo(true);

            $em->persist($empresa);
            $em->flush();

            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Registro activado con éxito.",
            );
        } else {
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no válida",
            );
        }

        return $helpers->json($response);
    }

    /**
     * Busca empresas por NIT o Nombre.
     *
     * @Route("/show/nit/nombre", name="userempresa_show_nit_nombre")
     * @Method({"GET", "POST"})
     */
    public function showNitOrNombreAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $json = $request->get("data", null);
        $params = json_decode($json);

        $em = $this->getDoctrine()->getManager();
        if ($authCheck == true) {
            $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->getByNitOrNombre($params);

            if ($empresa) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Empresa encontrada",
                    'data' => $empresa,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Empresa no encontrada",
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Listado de empresas
     *
     * @Route("/select", name="userempresa_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $empresas = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($empresas as $key => $empresa) {
            $response[$key] = array(
                'value' => $empresa->getId(),
                'label' => $empresa->getNombre(),
            );
        }

        return $helpers->json($response);
    }

    /**
     * Search usuario entity.
     *
     * @Route("/buscar/ciudadano", name="datos_ciudadano")
     * @Method({"GET", "POST"})
     */
    public function buscarCiudadanoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();

            $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findOneBy(
                array(
                    'identificacion' => $params->identificacion
                ));

            if ($ciudadano) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "ciudadano encontrado",
                    'data' => $ciudadano,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El ciudadano no se encuentra en la Base de Datos",
                );
                return $helpers->json($response);
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida",
            );
        }
        return $helpers->json($response);
    } 

    /**
     * datos para select 2
     *
     * @Route("/select/trasporte/publico", name="user_empresa_transporte_publico_select")
     * @Method({"GET", "POST"})
     */
    public function selectTrasportePublicoAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $empresas = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->findBy(
        array('activo' => 1,'tipoEmpresa'=>2) 
    );
    if ($empresas == null) {
       $response = null;
    }
      foreach ($empresas as $key => $empresa) {
        $response[$key] = array(
            'value' => $empresa->getId(),
            'label' => $empresa->getNit()."_".$empresa->getNombre(),
            );
      }
       return $helpers->json($response);
    }

    /**
     * Listado de empresas aseguradoras
     *
     * @Route("/select/empresas/aseguradoras", name="userempresasaseguradoras_select")
     * @Method({"GET", "POST"})
     */
    public function selectAseguradorasAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $empresas = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->findBy(
            array(
                'tipoEmpresa' => 4,
                'activo' => true
                )
        );

        $response = null;

        foreach ($empresas as $key => $empresa) {
            $response[$key] = array(
                'value' => $empresa->getId(),
                'label' => $empresa->getNombre(),
            );
        }

        return $helpers->json($response);
    }

    /**
     * Listado de empresas capacitadoras
     *
     * @Route("/select/empresas/capacitadoras", name="userempresascapacitadoras_select")
     * @Method({"GET", "POST"})
     */
    public function selectCapacitadorasAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $empresas = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->findBy(
            array(
                'tipoEmpresa' => 5,
                'activo' => true
                )
        );

        $response = null;

        foreach ($empresas as $key => $empresa) {
            $response[$key] = array(
                'value' => $empresa->getId(),
                'label' => $empresa->getNombre(),
            );
        }

        return $helpers->json($response);
    }

    /**
     * Busca empresas por parametros (nit y nombre).
     *
     * @Route("/search/filtros", name="userempresa_search_filtros")
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

            $empresas = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->getByFilter(
                $params
            );

            if ($empresas) {
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($empresas)." empresas encontradas", 
                    'data' => $empresas,
            );
            }else{
                 $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'No existen empresas para esos filtros de búsqueda, si desea registralo por favor presione el botón "NUEVO"', 
                );
            }

            
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
            );
        }
        return $helpers->json($response);
    }
}
 