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

            $consecutivo = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatConsecutivo')->findOneBy(
                    array(
                        'numero' => $params->consecutivo
                    )
                );
            //===========================================0 
            $victima = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatVictima')->findOneBy(
                array(
                    'identificacion' => $params->identificacion,
                    'consecutivo' => $consecutivo,
                    'activo' => true,
                )
            );
            
            if ($victima) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "La victima ya se encuentra registrado para este IPAT",
                    );
                return $helpers->json($response);
            } else {
                $victima = new SvIpatVictima();
                
                //consecutivo del ipat
                /* $consecutivo = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatConsecutivo')->findOneBy(
                    array(
                        'numero' => $params->consecutivo
                    )
                ); */
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
            
                $idGravedad = (isset($params->idGravedad)) ? $params->idGravedad : null;
                if ($idGravedad) {
                    $gravedad = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgGravedadVictima')->find(
                        $params->idGravedad
                    );
                    $victima->setGravedad($gravedad);
                }

                $idTipoIdentificacion = (isset($params->tipoIdentificacion)) ? $params->tipoIdentificacion : null;
                if($idTipoIdentificacion) {
                    $tipoIdentificacion = $em->getRepository('JHWEBUsuarioBundle:UserCfgTipoIdentificacion')->find($params->tipoIdentificacion);
                    $victima->setTipoIdentificacion($tipoIdentificacion->getNombre());
                }

                $identificacion = (isset($params->identificacion)) ? $params->identificacion : null;
                $victima->setIdentificacion($identificacion);

                $victima->setNombres($params->nombres);
                $victima->setApellidos($params->apellidos);

                $idNacionalidad = (isset($params->nacionalidad)) ? $params->nacionalidad : null;
                if($idNacionalidad) {
                    $nacionalidad = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgNacionalidad')->find($params->nacionalidad);
                    $victima->setNacionalidad($nacionalidad->getNombre());
                }

                $victima->setFechaNacimiento(new \Datetime($params->fechaNacimiento));
                
                $edad = $this->get("app.helpers")->calculateAge($params->fechaNacimiento);
                $victima->setEdad($edad);

                $idSexo = (isset($params->sexo)) ? $params->sexo : null;
                if($idSexo){
                    $sexo = $em->getRepository('JHWEBUsuarioBundle:UserCfgGenero')->find($idSexo);
                    $victima->setSexo($sexo->getSigla());
                }
                
                $victima->setDireccionResidencia($params->direccionResidencia);

                $idCiudadResidencia = (isset($params->ciudadResidencia)) ? $params->ciudadResidencia : null;
                if($idCiudadResidencia) {
                    $ciudadResidencia = $em->getRepository('JHWEBConfigBundle:CfgMunicipio')->find($params->ciudadResidencia);
                    $victima->setCiudadResidencia($ciudadResidencia->getNombre());
                }

                $victima->setTelefono($params->telefono);

                $placaVehiculo = (isset($params->placaVehiculo)) ? $params->placaVehiculo : null;
                if($placaVehiculo){
                    $vehiculo = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatVehiculo')->find($placaVehiculo);
                    $victima->setPlacaVehiculo($vehiculo->getPlaca());
                }

                if ($params->idHospital) {
                    $hospital = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgHospital')->find(
                        $params->idHospital
                    );
                    $victima->setHospital($hospital);
                }
                
                $victima->setPracticoExamen($params->practicoExamen);
                $victima->setAutorizo($params->autorizo);
                
                if ($params->idResultadoExamen) {
                    $resultadoExamen = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgResultadoExamen')->find(
                        $params->idResultadoExamen
                    );
                    $victima->setResultadoExamen($resultadoExamen);
                }
                
                if ($params->idGradoExamen) {
                    $gradoExamen = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgGradoExamen')->find(
                        $params->idGradoExamen
                    );
                    $victima->setGradoExamen($gradoExamen);
                }
                
                $victima->setSustanciasPsicoactivas($params->sustanciasPsicoactivas);
                $victima->setChaleco($params->chaleco);
                $victima->setCasco($params->casco);
                $victima->setCinturon($params->cinturon);
                
                $victima->setDescripcionLesion($params->descripcionLesion);
                $victima->setActivo(true);
                $em->persist($victima);
                $em->flush();
                
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Los datos han sido registrados exitosamente.",
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
