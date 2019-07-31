<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloTpRango;
use JHWEB\VehiculoBundle\Entity\VhloTpCupo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlotprango controller.
 *
 * @Route("vhlotprango")
 */
class VhloTpRangoController extends Controller
{
    /**
     * Lists all vhloTpRango entities.
     *
     * @Route("/", name="vhlotprango_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $vhloTpRangos = $em->getRepository('JHWEBVehiculoBundle:VhloTpRango')->findAll();

        return $this->render('vhlotprango/index.html.twig', array(
            'vhloTpRangos' => $vhloTpRangos,
        ));
    }

    /**
     * Registra rangos de cupos para una empresa de transporte público.
     *
     * @Route("/new", name="vhlotprango_new")
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
            
            $empresaTransporte = $em->getRepository('JHWEBUsuarioBundle:UserEmpresaTransporte')->findOneBy(
                array(
                    'id' => $params->idEmpresaTransporte,
                    'activo' => true
                )
            );

            $rango = new VhloTpRango();
            
            $rango->setHabilitacion($empresaTransporte);
            $rango->setRangoInicio($params->rangoInicio);
            $rango->setRangoFin($params->rangoFin);
            $rango->setNumeroResolucionCupo($params->numeroResolucion);
            $rango->setFechaResolucionCupo(new \Datetime($params->fechaResolucion));
            $rango->setObservaciones($params->observaciones);
            $rango->setActivo(true);

            $em->persist($rango);
            $em->flush();

            for ($i=$params->rangoInicio; $i <= $params->rangoFin ; $i++) { 
                $cupo = new VhloTpCupo();
                
                $cupo->setEmpresaTransporte($empresaTransporte);
                $cupo->setNumero($i);
                $cupo->setEstado('DISPONIBLE');
                $cupo->setActivo(true);

                $em->persist($cupo);
                $em->flush();
            }

            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Cupos creados con éxito",
            );
        } else {
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
     * Finds and displays a vhloTpRango entity.
     *
     * @Route("/{id}", name="vhlotprango_show")
     * @Method("GET")
     */
    public function showAction(VhloTpRango $vhloTpRango)
    {

        return $this->render('vhlotprango/show.html.twig', array(
            'vhloTpRango' => $vhloTpRango,
        ));
    }

    /**
     * Delete a VhloTpRango entity.
     *
     * @Route("/delete", name="vhlotprango_delete")
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

            $rango = $em->getRepository('JHWEBVehiculoBundle:VhloTpRango')->find($params->id);

            $rango->setActivo(false);

            $em->persist($rango);
            $em->flush();

            $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro eliminado con éxito",
                );
        } else{
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
     * Busca empresas de transporte habilitadas por NIT.
     *
     * @Route("/search/empresaTransporte", name="vhlotprango_search_nit")
     * @Method({"GET", "POST"})
     */
    public function searchEmpresaTransporteByNitAction(Request $request)
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
                $empresaHabilitada = $em->getRepository('JHWEBUsuarioBundle:UserEmpresaTransporte')->findOneBy(
                    array(
                        'empresa' => $empresa,
                        'activo' => true
                    )
                );

                if($empresaHabilitada) {
                    $response = array(
                        'title' => 'Perfecto!',
                        'status' => 'success',
                        'code' => 200,
                        'message' => "Empresa encontrada",
                        'data' => $empresaHabilitada,
                    );

                } else {
                    $response = array(
                        'title' => 'Error!',
                        'status' => 'error',
                        'code' => 400,
                        'message' => "No se ha habilitado la empresa para asignar rangos.",
                    );
                }
            } else {
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Empresa no encontrada",
                );
            }
        } else {
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
     * Busca rangos de una empresa de transporte.
     *
     * @Route("/search/rangos", name="vhlotprango_search_rangos")
     * @Method({"GET", "POST"})
     */
    public function searchRangosByEmpresaAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        
        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            
            $em = $this->getDoctrine()->getManager();

            $rangos = $em->getRepository('JHWEBVehiculoBundle:VhloTpRango')->findBy(
                array(
                    'habilitacion' => $params->idEmpresa,
                    'activo' => true
                )
            ); 

            if ($rangos) {
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($rangos) . " rangos encontradas",
                    'data' => $rangos,
                );
            } else {
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No se encontraron rangos asignados para la empresa",
                );
            }
        } else {
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida",
            );
        }
        return $helpers->json($response);
    }
}
