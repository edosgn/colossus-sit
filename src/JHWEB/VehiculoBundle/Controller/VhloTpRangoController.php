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
                
            $convenio = $em->getRepository('JHWEBVehiculoBundle:VhloTpConvenio')->findOneBy(
                array(
                    'numeroConvenio' => $params->numeroConvenio,
                    'activo' => true
                )
            );
                    
            if($empresaTransporte){
                if($params->rangoInicio <= $params->rangoFin){
                    $rango = new VhloTpRango();
                    
                    $rango->setHabilitacion($empresaTransporte);
                    $rango->setRangoInicio($params->rangoInicio);
                    $rango->setRangoFin($params->rangoFin);
                    $rango->setNumeroResolucionCupo($params->numeroResolucion);
                    $rango->setFechaResolucionCupo(new \Datetime($params->fechaResolucion));
                    $rango->setObservaciones($params->observaciones);
                    $rango->setActivo(true);

                    $em->persist($rango);
                    
                    for ($i=$params->rangoInicio; $i <= $params->rangoFin ; $i++) { 
                        
                        $cupo = new VhloTpCupo();
                        
                        $cupo->setEmpresaTransporte($empresaTransporte);
                        $cupo->setNumero($i);
                        $cupo->setEstado('DISPONIBLE');
                        $cupo->setActivo(true);
                        
                        $em->persist($cupo);
                    }
                    
                    if($convenio->getCuposUtilizados() == 0) {
                        $cantidad = ($params->rangoFin - $params->rangoInicio) + 1;

                        if($convenio->getCuposDisponibles() < $cantidad) {
                            $response = array(
                                'title' => 'Error!',
                                'status' => 'error',
                                'code' => 400,
                                'message' => 'El rango que se intenta crear excede el número de cupos disponibles del convenio.',
                            );
                        } else {
                            $convenio->setCuposUtilizados($cantidad);
                            $convenio->setCuposDisponibles($convenio->getCuposDisponibles() - $cantidad);
                            $em->persist($convenio);

                            $response = array(
                                'title' => 'Perfecto!',
                                'status' => 'success',
                                'code' => 200,
                                'message' => "Cupos creados con éxito",
                            );
        
                            $em->flush();
                        }
                    } else {
                        $cantidad = ($params->rangoFin - $params->rangoInicio) + 1;

                        if($convenio->getCuposDisponibles() < $cantidad) {
                            $response = array(
                                'title' => 'Error!',
                                'status' => 'error',
                                'code' => 400,
                                'message' => 'El rango que se intenta crear excede el número de cupos disponibles del convenio.',
                            );
                        } else {
                            $convenio->setCuposUtilizados($convenio->getCuposUtilizados() + $cantidad);
                            $convenio->setCuposDisponibles($convenio->getCuposDisponibles() - $cantidad);
                            $em->persist($convenio);
                   
                            $response = array(
                                'title' => 'Perfecto!',
                                'status' => 'success',
                                'code' => 200,
                                'message' => "Cupos creados con éxito",
                            );
        
                            $em->flush();
                        }
                    }

                } else {
                    $response = array(
                        'title' => 'Error!',
                        'status' => 'error',
                        'code' => 400,
                        'message' => 'El rango de inicio debe ser menor al rango de fin.',
                    );
                }
            } else {
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'La empresa de transporte no existe.',
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
                    'message' => count($rangos) . " rango(s) encontrado(s).",
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
