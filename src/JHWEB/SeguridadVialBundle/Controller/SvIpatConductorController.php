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
            
            $conductor = new SvIpatConductor();

            //consecutivo del ipat
            $consecutivo = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatConsecutivo')->findOneBy(
                array(
                    'numero' => $params->consecutivo
                )
            );
            $conductor->setConsecutivo($consecutivo);
            //=======================================
            
            $conductor->setNombresConductor($params->nombresConductor);
            $conductor->setApellidosConductor($params->apellidosConductor);
            
            $idSexoConductor = (isset($params->sexoConductor)) ? $params->sexoConductor : null;
            if ($idSexoConductor) {
                $sexoConductor = $em->getRepository('JHWEBUsuarioBundle:UserCfgGenero')->find($params->sexoConductor);
                $conductor->setSexoConductor($sexoConductor->getSigla());
            }
            //$idTipoIdentificacionTestigo = (isset($params->tipoIdentificacionConductor)) ? $params->tipoIdentificacionConductor : null;
            $identificacionConductor = (isset($params->identificacionConductor)) ? $params->identificacionConductor : null;
            $conductor->setIdentificacionConductor($identificacionConductor);

            $idTipoIdentificacionConductor = (isset($params->tipoIdentificacionConductor)) ? $params->tipoIdentificacionConductor : null;
            if($idTipoIdentificacionConductor) {
                $tipoIdentificacionConductor = $em->getRepository('JHWEBUsuarioBundle:UserCfgTipoIdentificacion')->find($params->tipoIdentificacionConductor);
                $conductor->setTipoIdentificacionConductor($tipoIdentificacionConductor->getNombre());
            }
            
            $idNacionalidadConductor = (isset($params->nacionalidadConductor)) ? $params->nacionalidadConductor : null;
            if($idNacionalidadConductor) {
                $nacionalidadConductor = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgNacionalidad')->find($params->nacionalidadConductor);
                $conductor->setNacionalidadConductor($nacionalidadConductor->getNombre());
            }
            
            $conductor->setFechaNacimientoConductor(new \Datetime($params->fechaNacimientoConductor));
            
            $edadConductor = $this->get("app.helpers")->calculateAge($params->fechaNacimientoConductor);
            $conductor->setEdadConductor($edadConductor);

            
            $idSexoConductor = (isset($params->sexoConductor)) ? $params->sexoConductor : null;
            if ($idSexoConductor) {
                $sexoConductor = $em->getRepository('JHWEBUsuarioBundle:UserCfgGenero')->find($params->sexoConductor);
                $conductor->setSexoConductor($sexoConductor->getSigla());
            }

            
            $idGravedadConductor = (isset($params->idGravedadConductor)) ? $params->idGravedadConductor : null;
            if ($idGravedadConductor) {
                $gravedadConductor = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgGravedadVictima')->find(
                    $params->idGravedadConductor
                );
                $conductor->setGravedadConductor($gravedadConductor);
            }            

            $conductor->setDireccionResidenciaConductor($params->direccionResidenciaConductor);

            $idCiudadResidenciaConductor = (isset($params->ciudadResidenciaConductor)) ? $params->ciudadResidenciaConductor : null;
            if($idCiudadResidenciaConductor) {
                $ciudadResidenciaConductor = $em->getRepository('JHWEBConfigBundle:CfgMunicipio')->find($params->ciudadResidenciaConductor);
                $conductor->setCiudadResidenciaConductor($ciudadResidenciaConductor->getNombre());
            }

            $conductor->setTelefonoConductor($params->telefonoConductor);

            $vehiculo = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatVehiculo')->find($params->placaVehiculoConductor);
            $conductor->setPlacaVehiculoConductor($vehiculo->getPlaca());

            $conductor->setPracticoExamenConductor($params->practicoExamenConductor);
            $conductor->setAutorizoConductor($params->autorizoConductor);

            if ($params->idResultadoExamenConductor) {
                $resultadoExamenConductor = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgResultadoExamen')->find(
                    $params->idResultadoExamenConductor
                );
                $conductor->setResultadoExamenConductor($resultadoExamenConductor);
            }

            if ($params->idGradoExamenConductor) {
                $gradoExamenConductor = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgGradoExamen')->find(
                    $params->idGradoExamenConductor
                );
                $conductor->setGradoExamenConductor($gradoExamenConductor);
            }

            $conductor->setSustanciasPsicoactivasConductor($params->sustanciasPsicoactivasConductor);
            $conductor->setPortaLicencia($params->portaLicencia);
            $conductor->setNumeroLicenciaConduccion($params->numeroLicenciaConduccion);
            $conductor->setCategoriaLicenciaConduccion($params->categoriaLicenciaConduccion);
            $conductor->setRestriccionConductor($params->restriccionConductor);
            $conductor->setFechaExpedicionLicenciaConduccion(new \Datetime($params->fechaExpedicionLicenciaConduccion));
            $conductor->setFechaVencimientoLicenciaConduccion(new \Datetime($params->fechaVencimientoLicenciaConduccion));
            $conductor->setOrganismoTransito($params->organismoTransito);
            $conductor->setChalecoConductor($params->chalecoConductor);
            $conductor->setCascoConductor($params->cascoConductor);
            $conductor->setCinturonConductor($params->cinturonConductor);

            $hospitalConductor = (isset($params->idHospitalConductor)) ? $params->idHospitalConductor : null;
            if ($hospitalConductor) {
                $hospitalConductor = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgHospital')->find(
                    $params->idHospitalConductor
                );
                $conductor->setHospitalConductor($hospitalConductor);
            }

            $conductor->setDescripcionLesionConductor($params->descripcionLesionConductor);

            $conductor->setActivo(true);
            $em->persist($conductor);
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
