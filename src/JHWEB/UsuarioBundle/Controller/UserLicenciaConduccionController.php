<?php

namespace JHWEB\UsuarioBundle\Controller;

use JHWEB\UsuarioBundle\Entity\UserLicenciaConduccion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * Userlicenciaconduccion controller.
 *
 * @Route("userlicenciaconduccion")
 */
class UserLicenciaConduccionController extends Controller
{
    /**
     * Lists all userLicenciaConduccion entities.
     *
     * @Route("/", name="userlicenciaconduccion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $licencias = $em->getRepository('JHWEBUsuarioBundle:UserLicenciaConduccion')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($licencias) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($licencias)." Registros encontrados", 
                'data'=> $licencias,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new licenciaConduccion entity.
     *
     * @Route("/new", name="licenciaconduccion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization",null);
        $authCheck = $helpers->authCheck($hash);
        if($authCheck == true){
            $json = $request->get("json",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            
            
            $licenciaConduccion = new UserLicenciaConduccion();
            
            $fechaVencimiento = date('Y-m-d',strtotime('+1 years', $params->fechaExpedicion));
            
            if ($params->idOrganismoTransito) {
                $organismoTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find(
                    $params->idOrganismoTransito
                );
                $licenciaConduccion->setOrganismoTransito($organismoTransito);
            }

            if ($params->idCategoria) {
                $categoria = $em->getRepository('JHWEBUsuarioBundle:UserLcCfgCategoria')->find(
                    $params->idCategoria
                );
                $licenciaConduccion->setCategoria($categoria);
            }

            if ($params->idClase) {
                $clase = $em->getRepository('JHWEBVehiculoBundle:VhloCfgClase')->find(
                    $params->idClase
                );
                $licenciaConduccion->setClase($clase);
            }

            if ($params->idServicio) {
                $servicio = $em->getRepository('JHWEBVehiculoBundle:VhloCfgServicio')->find(
                    $params->idServicio
                );
                $licenciaConduccion->setServicio($servicio);
            }

            if (isset($params->idTramiteFactura)) {
                $tramiteFactura = $em->getRepository('JHWEBFinancieroBundle:FroFacTramite')->find(
                    $params->idTramiteFactura
                );
                $licenciaConduccion->setTramiteFactura($tramiteFactura);
            }

            if ($params->idCiudadano) {
                $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->find(
                    $params->idCiudadano
                );
                $licenciaConduccion->setCiudadano($ciudadano);

                $licenciasOld = $em->getRepository('JHWEBUsuarioBundle:UserLicenciaConduccion')->findBy(
                    array(
                        'ciudadano' => $ciudadano->getId(),
                        'activo' => true
                    )
                );

                foreach ($licenciasOld as $key => $licenciaOld) {
                    $licenciaOld->setActivo(false);
                    $em->flush();
                }
            }

            if (isset($params->idPais)) {
                $pais = $em->getRepository('JHWEBConfigBundle:CfgPais')->find(
                    $params->idPais
                );
                $licenciaConduccion->setPais($pais);
            }

            $licencia->setFechaExpedicion(new \Datetime($params->fechaExpedicion));
            $licencia->setNumero($params->numero);
            $licencia->setNumeroRunt($params->numeroRunt);
            $licenciaConduccion->setFechaVencimiento(new \Datetime($fechaVencimiento));
            $licencia->setEstado($params->estado);
            
            
            $licencia->setActivo(true);


        } else {
          $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no valida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Finds and displays a userLicenciaConduccion entity.
     *
     * @Route("/show", name="userlicenciaconduccion_show")
     * @Method("GET")
     */
    public function showAction(UserLicenciaConduccion $userLicenciaConduccion)
    {

        return $this->render('userlicenciaconduccion/show.html.twig', array(
            'userLicenciaConduccion' => $userLicenciaConduccion,
        ));
    }
}
