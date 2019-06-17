<?php

namespace JHWEB\UsuarioBundle\Controller;

use JHWEB\UsuarioBundle\Entity\UserEmpresaTransporte;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Userempresatransporte controller.
 *
 * @Route("userempresatransporte")
 */
class UserEmpresaTransporteController extends Controller
{
    /**
     * Lists all userEmpresaTransporte entities.
     *
     * @Route("/", name="userempresatransporte_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $empresas = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->findBy(
            array(
                'tipoEmpresa' => 2,
                'activo' => true
            )
        ); 

        if ($empresas) {
            $response = array(
                'tittle' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => count($empresas) . "empresas encontradas",
                'data' => $empresas,
            );
        } else {
            $response = array(
                'tittle' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "No se encontraron registros",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Create a userEmpresaTransporte entity.
     *
     * @Route("/new", name="userempresatransporte_new")
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

            $empresa  = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->find($params->idEmpresa);
            $radioAccion = $em->getRepository('JHWEBVehiculoBundle:VhloCfgRadioAccion')->find($params->idRadioAccion);
            $modalidadTransporte = $em->getRepository('JHWEBVehiculoBundle:VhloCfgModalidadTransporte')->find($params->idModalidadTransporte);
            $clase = $em->getRepository('JHWEBVehiculoBundle:VhloCfgClase')->find($params->idClase);
            $servicio = $em->getRepository('JHWEBVehiculoBundle:VhloCfgServicio')->find($params->idServicio);
            
            if($params->idCarroceria){
                $carroceria = $em->getRepository('JHWEBVehiculoBundle:VhloCfgCarroceria')->find($params->idCarroceria);
                $empresaTransporte->setCarroceria($carroceria);
            }

            $empresaTransporte  = new UserEmpresaTransporte();

            $empresaTransporte->setEmpresa($empresa);
            $empresaTransporte->setRadioAccion($radioAccion);
            $empresaTransporte->setModalidadTransporte($modalidadTransporte);
            $empresaTransporte->setServicio($servicio);
            $empresaTransporte->setClase($clase);
            $empresaTransporte->setNumeroActo($params->numeroActo);
            $empresaTransporte->setFechaExpedicionActo(new \Datetime($params->fechaExpedicionActo));
            $empresaTransporte->setFechaEjecutoriaActo(new \Datetime($params->fechaEjecutoriaActo));
            $empresaTransporte->setNumeroEjecutoriaActo($params->numeroEjecutoriaActo);
            $empresaTransporte->setColores(implode(',', $params->arrayColores));
            $empresaTransporte->setMunicipios(implode(',', $params->arrayMunicipios));
            $empresaTransporte->setCapacidad($params->capacidad);
            $empresaTransporte->setCapacidadMinima($params->capacidadMinima);
            $empresaTransporte->setCapacidadMaxima($params->capacidadMaxima);
            $empresaTransporte->setActivo(true);
            
            $em->persist($empresaTransporte);
            $em->flush();

            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con éxito",
            );
        
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
     * Finds and displays a userEmpresaTransporte entity.
     *
     * @Route("/{id}", name="userempresatransporte_show")
     * @Method("GET")
     */
    public function showAction(UserEmpresaTransporte $userEmpresaTransporte)
    {

        return $this->render('userempresatransporte/show.html.twig', array(
            'userEmpresaTransporte' => $userEmpresaTransporte,
        ));
    }

    /**
     * Busca empresas por NIT.
     *
     * @Route("/search/nit", name="userempresa_transporte_search_nit")
     * @Method({"GET", "POST"})
     */
    public function searchByNitAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        
        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            
            $em = $this->getDoctrine()->getManager();
            
            $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->findOneBy(
                array(
                    'nit' => $params,
                    'tipoEmpresa' => 2,
                    'activo' => true
                )
            ); 

            if ($empresa) {
                $response = array(
                    'tittle' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Empresa encontrada",
                    'data' => $empresa,
                );
            } else {
                $response = array(
                    'tittle' => 'Error!',
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
}
