<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvIpatVictima;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svipatvictima controller.
 *
 * @Route("svipatvictima")
 */
class SvIpatVictimaController extends Controller
{
    /**
     * Lists all svIpatVictima entities.
     *
     * @Route("/", name="svipatvictima_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $svIpatVictimas = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatVictima')->findAll();

        return $this->render('svipatvictima/index.html.twig', array(
            'svIpatVictimas' => $svIpatVictimas,
        ));
    }


    
    /**
     * Creates a new svIpatVictima entity.
     *
     * @Route("/new", name="svipatvictima_new")
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
            
            $victima = new SvIpatVictima();
            
            //consecutivo del ipat
            $consecutivo = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatConsecutivo')->findOneBy(
                array(
                    'numero' => $params->consecutivo
                )
            );
            $victima->setConsecutivo($consecutivo);
            //=======================================

            $idTipoVictima = (isset($params->idTipoVictima)) ? $params->idTipoVictima : null;
            if ($idTipoVictima) {
                $tipoVictima = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTipoVictima')->findOneBy(
                    array(
                        'nombre' => $params->idTipoVictima
                    )
                );
                $victima->setTipoVictima($tipoVictima);
            }
         
            $idGravedadVictima = (isset($params->idGravedadVictima)) ? $params->idGravedadVictima : null;
            if ($idGravedadVictima) {
                $gravedadVictima = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgGravedadVictima')->find(
                    $params->idGravedadVictima
                );
                $victima->setGravedadVictima($gravedadVictima);
            }

            $idTipoIdentificacionVictima = (isset($params->tipoIdentificacionVictima)) ? $params->tipoIdentificacionVictima : null;
            if($idTipoIdentificacionVictima) {
                $tipoIdentificacionVictima = $em->getRepository('JHWEBUsuarioBundle:UserCfgTipoIdentificacion')->find($params->tipoIdentificacionVictima);
                $victima->setTipoIdentificacionVictima($tipoIdentificacionVictima->getNombre());
            }

            $identificacionVictima = (isset($params->identificacionVictima)) ? $params->identificacionVictima : null;
            $victima->setIdentificacionVictima($identificacionVictima);

            $victima->setNombresVictima($params->nombresVictima);
            $victima->setApellidosVictima($params->apellidosVictima);

            $idNacionalidadVictima = (isset($params->nacionalidadVictima)) ? $params->nacionalidadVictima : null;
            if($idNacionalidadVictima) {
                $nacionalidadVictima = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgNacionalidad')->find($params->nacionalidadVictima);
                $victima->setNacionalidadVictima($nacionalidadVictima->getNombre());
            }

            $victima->setFechaNacimientoVictima(new \Datetime($params->fechaNacimientoVictima));
            
            $edadVictima = $this->get("app.helpers")->calculateAge($params->fechaNacimientoVictima);
            $victima->setEdadVictima($edadVictima);

            $idSexoVictima = (isset($params->sexoVictima)) ? $params->sexoVictima : null;
            if($idSexoVictima){
                $sexoVictima = $em->getRepository('JHWEBUsuarioBundle:UserCfgGenero')->find($idSexoVictima);
                $victima->setSexoVictima($sexoVictima->getSigla());
            }
            
            $victima->setDireccionResidenciaVictima($params->direccionResidenciaVictima);

            $idCiudadResidenciaVictima = (isset($params->ciudadResidenciaVictima)) ? $params->ciudadResidenciaVictima : null;
            if($idCiudadResidenciaVictima) {
                $ciudadResidenciaVictima = $em->getRepository('JHWEBConfigBundle:CfgMunicipio')->find($params->ciudadResidenciaVictima);
                $victima->setCiudadResidenciaVictima($ciudadResidenciaVictima->getNombre());
            }

            $victima->setTelefonoVictima($params->telefonoVictima);

            $vehiculo = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatVehiculo')->find($params->placaVehiculoVictima);
            $victima->setPlacaVehiculoVictima($vehiculo->getPlaca());

            if ($params->idHospitalVictima) {
                $hospitalVictima = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgHospital')->find(
                    $params->idHospitalVictima
                );
                $victima->setHospitalVictima($hospitalVictima);
            }
            
            $victima->setPracticoExamenVictima($params->practicoExamenVictima);
            $victima->setAutorizoVictima($params->autorizoVictima);
            
            if ($params->idResultadoExamenVictima) {
                $resultadoExamenVictima = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgResultadoExamen')->find(
                    $params->idResultadoExamenVictima
                );
                $victima->setResultadoExamenVictima($resultadoExamenVictima);
            }
            
            if ($params->idGradoExamenVictima) {
                $gradoExamenVictima = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgGradoExamen')->find(
                    $params->idGradoExamenVictima
                );
                $victima->setGradoExamenVictima($gradoExamenVictima);
            }
            
            $victima->setSustanciasPsicoactivasVictima($params->sustanciasPsicoactivasVictima);
            $victima->setChalecoVictima($params->chalecoVictima);
            $victima->setCascoVictima($params->cascoVictima);
            $victima->setCinturonVictima($params->cinturonVictima);
            
            $victima->setDescripcionLesionVictima($params->descripcionLesionVictima);
            $victima->setActivo(true);
            $em->persist($victima);
            $em->flush();
            
            $response = array(
                'status' => 'success',
                'code' => 200,
                    'message' => "Los datos han sido registrados exitosamente.",
                );
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
         * Finds and displays a svIpatVictima entity.
         *
         * @Route("/{id}", name="svipatvictima_show")
     * @Method("GET")
     */
    public function showAction(SvIpatVictima $svIpatVictima)
    {

        return $this->render('svipatvictima/show.html.twig', array(
            'svIpatVictima' => $svIpatVictima,
        ));
    }
}
