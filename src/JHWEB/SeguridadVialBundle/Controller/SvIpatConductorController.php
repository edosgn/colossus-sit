<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvIpatConductor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svipatconductor controller.
 *
 * @Route("svipatconductor")
 */
class SvIpatConductorController extends Controller
{
    /**
     * Lists all svIpatConductor entities.
     *
     * @Route("/", name="svipatconductor_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $svIpatConductors = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatConductor')->findAll();

        return $this->render('svipatconductor/index.html.twig', array(
            'svIpatConductors' => $svIpatConductors,
        ));
    }

    /**
     * Creates a new svIpatConductor entity.
     *
     * @Route("/new", name="svipatonductor_new")
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
                
                $conductor = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatConductor')->findOneBy(
                    array(
                    'identificacion' => $params->identificacion,
                    'consecutivo' => $consecutivo,
                    'activo' => true,
                )
            );
            
            if($conductor) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El conductor ya se encuentra registrado para este IPAT",
                    );
                return $helpers->json($response);
            } else {
                $conductor = new SvIpatConductor();

                //consecutivo del ipat
                $consecutivo = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatConsecutivo')->findOneBy(
                    array(
                        'numero' => $params->consecutivo
                    )
                );
                $conductor->setConsecutivo($consecutivo);
                //=======================================
                
                $conductor->setNombres($params->nombres);
                $conductor->setApellidos($params->apellidos);
                
                $idSexo = (isset($params->sexo)) ? $params->sexo : null;
                if ($idSexo) {
                    $sexo = $em->getRepository('JHWEBUsuarioBundle:UserCfgGenero')->find($params->sexo);
                    $conductor->setSexo($sexo->getSigla());
                }
                //$idTipoIdentificacionTestigo = (isset($params->tipoIdentificacionConductor)) ? $params->tipoIdentificacionConductor : null;
                $identificacion = (isset($params->identificacion)) ? $params->identificacion : null;
                $conductor->setIdentificacion($identificacion);

                $idTipoIdentificacion = (isset($params->tipoIdentificacion)) ? $params->tipoIdentificacion : null;
                if($idTipoIdentificacion) {
                    $tipoIdentificacion = $em->getRepository('JHWEBUsuarioBundle:UserCfgTipoIdentificacion')->find($params->tipoIdentificacion);
                    $conductor->setTipoIdentificacion($tipoIdentificacion->getNombre());
                }
                
                $idNacionalidad = (isset($params->nacionalidad)) ? $params->nacionalidad : null;
                if($idNacionalidad) {
                    $nacionalidad = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgNacionalidad')->find($params->nacionalidad);
                    $conductor->setNacionalidad($nacionalidad->getNombre());
                }
                
                var_dump($params->fechaNacimiento);

                $conductor->setFechaNacimiento(new \Datetime($params->fechaNacimiento));
                
                $edad = $this->get("app.helpers")->calculateAge($params->fechaNacimiento);
                $conductor->setEdad($edad);

                
                $idSexo = (isset($params->sexo)) ? $params->sexo : null;
                if ($idSexo) {
                    $sexo = $em->getRepository('JHWEBUsuarioBundle:UserCfgGenero')->find($params->sexo);
                    $conductor->setSexo($sexo->getSigla());
                }

                
                $idGravedad = (isset($params->idGravedad)) ? $params->idGravedad : null;
                if ($idGravedad) {
                    $gravedad = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgGravedadVictima')->find(
                        $params->idGravedad
                    );
                    $conductor->setGravedad($gravedad);
                }            

                $conductor->setDireccionResidencia($params->direccionResidencia);

                $idCiudadResidencia = (isset($params->ciudadResidencia)) ? $params->ciudadResidencia : null;
                
                if($idCiudadResidencia) {
                    $ciudadResidencia = $em->getRepository('JHWEBConfigBundle:CfgMunicipio')->find($idCiudadResidencia);
                    $conductor->setCiudadResidencia($ciudadResidencia->getNombre());
                }

                $conductor->setTelefono($params->telefono);

                $placaVehiculo = (isset($params->placaVehiculo)) ? $params->placaVehiculo : null;
                if($placaVehiculo){
                    $vehiculo = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatVehiculo')->find($placaVehiculo);
                    $conductor->setPlacaVehiculo($vehiculo->getPlaca());
                }

                $conductor->setPracticoExamen($params->practicoExamen);
                $conductor->setAutorizo($params->autorizo);

                if ($params->idResultadoExamen) {
                    $resultadoExamen = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgResultadoExamen')->find(
                        $params->idResultadoExamen
                    );
                    $conductor->setResultadoExamen($resultadoExamen);
                }

                if ($params->idGradoExamen) {
                    $gradoExamen = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgGradoExamen')->find(
                        $params->idGradoExamen
                    );
                    $conductor->setGradoExamen($gradoExamen);
                }

                $conductor->setSustanciasPsicoactivas($params->sustanciasPsicoactivas);
                $conductor->setPortaLicencia($params->portaLicencia);
                $conductor->setNumeroLicenciaConduccion($params->numeroLicenciaConduccion);

                $categoriaLc = (isset($params->categoriaLicenciaConduccion)) ? $params->categoriaLicenciaConduccion : null;
                
                if($categoriaLc){
                    $categoriaLicenciaConduccion = $em->getRepository('JHWEBUsuarioBundle:UserLcCfgCategoria')->find($categoriaLc);
                    $conductor->setCategoriaLicenciaConduccion($categoriaLicenciaConduccion->getNombre());
                }

                
                $conductor->setRestriccionLicencia($params->restriccion);
                $conductor->setFechaExpedicionLicenciaConduccion(new \Datetime($params->fechaExpedicionLicenciaConduccion));
                $conductor->setFechaVencimientoLicenciaConduccion(new \Datetime($params->fechaVencimientoLicenciaConduccion));
                $conductor->setOrganismoTransito($params->organismoTransito);
                $conductor->setChaleco($params->chaleco);
                $conductor->setCasco($params->casco);
                $conductor->setCinturon($params->cinturon);

                $hospital = (isset($params->idHospital)) ? $params->idHospital : null;
                if ($hospital) {
                    $hospital = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgHospital')->find(
                        $params->idHospital
                    );
                    $conductor->setHospital($hospital);
                }

                $conductor->setDescripcionLesion($params->descripcionLesion);

                $conductor->setActivo(true);
                $em->persist($conductor);
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
     * Finds and displays a svIpatConductor entity.
     *
     * @Route("/{id}", name="svipatconductor_show")
     * @Method("GET")
     */
    public function showAction(SvIpatConductor $svIpatConductor)
    {

        return $this->render('svipatconductor/show.html.twig', array(
            'svIpatConductor' => $svIpatConductor,
        ));
    }
}
