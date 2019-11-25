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
     * Creates a new userLicenciaConduccion entity.
     *
     * @Route("/new", name="userlicenciaconduccion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization",null);
        $authCheck = $helpers->authCheck($hash);
        if($authCheck == true){
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
    
            $licenciaConduccion = new UserLicenciaConduccion();
            
            $fechaExpedicion = strtotime($params->fechaExpedicion);
            $fechaVencimiento = date('Y-m-d',strtotime('+10 years', $fechaExpedicion));
            
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

            if (isset($params->idCiudadano) || isset($params->idSolicitante)) {
                if (isset($params->idCiudadano)) {
                    $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->find(
                        $params->idCiudadano
                    );
                }elseif (isset($params->idSolicitante)) {
                    $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->find(
                        $params->idSolicitante
                    );
                }
                $licenciaConduccion->setCiudadano($ciudadano);

                $licenciasOld = $em->getRepository('JHWEBUsuarioBundle:UserLicenciaConduccion')->findBy(
                    array(
                        'ciudadano' => $ciudadano->getId(),
                        'activo' => true
                    )
                );

                foreach ($licenciasOld as $key => $licenciaOld) {
                    $licenciaOld->setActivo(false);
                    $licenciaOld->setEstado('INACTIVO');
                    $em->flush();
                }
            }

            if (isset($params->idPais)) {
                $pais = $em->getRepository('JHWEBConfigBundle:CfgPais')->find(
                    $params->idPais
                );
                $licenciaConduccion->setPais($pais);
            }

            $licenciaConduccion->setFechaExpedicion(new \Datetime($params->fechaExpedicion));
            $licenciaConduccion->setFechaVencimiento(new \Datetime($fechaVencimiento));
            $licenciaConduccion->setNumero($params->numero);
            $licenciaConduccion->setEstado($params->estado);
            $licenciaConduccion->setRestriccion($params->restriccion);
            
            $licenciaConduccion->setActivo(true);
            $em->persist($licenciaConduccion);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con éxito.", 
            );


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

    /**
     * Displays a form to edit an existing licenciaConduccion entity.
     *
     * @Route("/edit", name="userlicenciaconduccion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization",null);
        $authCheck = $helpers->authCheck($hash);
        if($authCheck == true){
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
    
            $licenciaConduccion = $em->getRepository('JHWEBUsuarioBundle:UserLicenciaConduccion')->find($params->id);
            
            $fechaExpedicion = strtotime($params->fechaExpedicion);
            $fechaVencimiento = date('Y-m-d',strtotime('+1 years', $fechaExpedicion));
            
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

            if ($params->idCiudadano) {
                $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->find(
                    $params->idCiudadano
                );
                $licenciaConduccion->setCiudadano($ciudadano);

                /* $licenciasOld = $em->getRepository('JHWEBUsuarioBundle:UserLicenciaConduccion')->findBy(
                    array(
                        'ciudadano' => $ciudadano->getId(),
                        'activo' => true
                    )
                );

                foreach ($licenciasOld as $key => $licenciaOld) {
                    $licenciaOld->setActivo(false);
                    $em->flush();
                } */
            }

            if (isset($params->idPais)) {
                $pais = $em->getRepository('JHWEBConfigBundle:CfgPais')->find(
                    $params->idPais
                );
                $licenciaConduccion->setPais($pais);
            }

            $licenciaConduccion->setFechaExpedicion(new \Datetime($params->fechaExpedicion));
            $licenciaConduccion->setFechaVencimiento(new \Datetime($fechaVencimiento));
            $licenciaConduccion->setNumero($params->numero);
            $licenciaConduccion->setEstado($params->estado);
            $licenciaConduccion->setRestriccion($params->restriccion);
            
            $licenciaConduccion->setActivo(true);
            $em->persist($licenciaConduccion);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro editado con éxito.", 
            );


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
     * Deletes a userLicenciaConduccion entity.
     *
     * @Route("/delete", name="userlicenciaconduccion_delete")
     * @Method({"GET", "POST"})
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
            

            $licenciaConduccion = $em->getRepository('JHWEBUsuarioBundle:UserLicenciaConduccion')->find($params->id);

            $licenciaConduccion->setActivo(false);

            $em->persist($licenciaConduccion);
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
     * Search a userLicenciaConduccion by Ciudadano entity.
     *
     * @Route("/search/ciudadano/id", name="search_userlicenciaconduccion_ciudadano")
     * @Method({"GET", "POST"})
     */
    public function searchByCiudadanoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", true);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $json = $request->get("data", null);
            $params = json_decode($json);


            $usuario = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->find($params->idCiudadano);
            if(!$usuario){
                $response = array(
                    'status' => 'error',
                    'code' => 401,
                    'message' => "No se encontraro al ciudadano",
                );
                return $helpers->json($response);
            }

            $comparendos = $em->getRepository('JHWEBContravencionalBundle:CvCdoComparendo')->findBy(
                array(
                    'infractorIdentificacion' => $usuario->getIdentificacion()
                )
            );

            $licenciasConduccion = $em->getRepository('JHWEBUsuarioBundle:UserLicenciaConduccion')->findBy(
                array(
                    'ciudadano' => $params->idCiudadano,
                )
            );

            if($licenciasConduccion) { 
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($licenciasConduccion)." registros encontrados",
                    'data'=>array(
                        'licenciasConduccion' => $licenciasConduccion,
                        'comparendos' => $comparendos
                    )
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No se encontraron licencias para el ciudadano",
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no válida",
            );
        }
        return $helpers->json($response);
    }
}
 