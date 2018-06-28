<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\PropietarioVehiculo;
use AppBundle\Entity\TramiteGeneral;
use AppBundle\Entity\Caso;
use AppBundle\Entity\Variante;
use AppBundle\Entity\TramiteEspecifico;
use AppBundle\Form\CiudadanoVehiculoType;

/**
 * ProìetarioVehiculo controller.
 *
 * @Route("/propietariovehiculo")
 */
class PropietarioVehiculoController extends Controller
{
    /**
     * Lists all CiudadanoVehiculo entities.
     *
     * @Route("/", name="propietariovehiculo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $propietarioVehiculos = $em->getRepository('AppBundle:PropietarioVehiculo')->findBy(
            array('estado' => 1)
        );
        $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado propietarioVehiculos", 
                    'data'=> $propietarioVehiculos,
            );
         
        return $helpers->json($response);
    }

    /**
     * Creates a new CiudadanoVehiculo entity.
     *
     * @Route("/new/{tipoTraspaso}", name="propietariovehiculo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request,$tipoTraspaso)
    {
        
        
        
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
 
        // $varianteBd = $em->getRepository('AppBundle:Variante')->findOneBy(
        //     array('estado' => 1,'id' => $variante)
        // );

        $authCheck = $helpers->authCheck($hash);
        if ($authCheck == true) {
            $json = $request->get("json",null);
            $em = $this->getDoctrine()->getManager();    
            $params = json_decode($json);
            $params = (object)$params;
            // $datos = $params->datos;
            
            $vehiculo = $em->getRepository("AppBundle:Vehiculo")->findOneByPlaca($params->vehiculo);

            if ($tipoTraspaso == 1) {
                $vehiculo->setLeasing(true);
                $em->persist($vehiculo);
                $em->flush();
            }

            $propietariosVehiculo = $em->getRepository('AppBundle:PropietarioVehiculo')->findBy(
                array('vehiculo' => $vehiculo->getId(),
                        'estado' => 1,
                        'estadoPropiedad' => '1'
                    )
                );

            $fechaActual = new \DateTime(date('Y-m-d'));
            foreach ($propietariosVehiculo as $key => $propietarioActual) {

                $propietarioActual->setFechaPropiedadFinal($fechaActual);
                $propietarioActual->setEstadoPropiedad(false);
                $propietarioActual->setPermisoTramite(false);
                $em->persist($propietarioActual);
                $em->flush();

            }


            foreach ($params->propietariosEmpresas as $key => $empresa) {
                $empresaNueva = $em->getRepository('AppBundle:Empresa')->findOneBy(
                    array(
                            'estado' => 1,
                            'nit' => $empresa->nit
                        )
                    );
                    
                    $propietarioVehiculo = new PropietarioVehiculo();
                    $propietarioVehiculo->setLicenciaTransito($params->numeroLicencia);
                    $propietarioVehiculo->setFechaPropiedadInicial($fechaActual);
                    $propietarioVehiculo->setEstadoPropiedad(true);
                    $propietarioVehiculo->setPermisoTramite($empresa->permisoTramite);
                    $propietarioVehiculo->setEmpresa($empresaNueva);
                    $propietarioVehiculo->setVehiculo($vehiculo);
                    $propietarioVehiculo->setEstado(true);
                    $em->persist($propietarioVehiculo);
                    $em->flush();
            }

            foreach ($params->propietariosCiudadanos as $key => $ciudadano) {

                $usuario = $em->getRepository('UsuarioBundle:Usuario')->findOneBy(
                array(
                        'estado' => 'Activo',
                        'identificacion' => $ciudadano->identificacion
                    )
                );
                
                $propietarioVehiculo = new PropietarioVehiculo();
                $propietarioVehiculo->setLicenciaTransito($params->numeroLicencia);
                $propietarioVehiculo->setFechaPropiedadInicial($fechaActual);
                $propietarioVehiculo->setEstadoPropiedad(true);
                $propietarioVehiculo->setPermisoTramite($ciudadano->permisoTramite);
                $propietarioVehiculo->setCiudadano($usuario->getCiudadano());
                $propietarioVehiculo->setVehiculo($vehiculo);
                $propietarioVehiculo->setEstado(true);
                $em->persist($propietarioVehiculo);
                $em->flush();
            }
           

            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "Proìetario Vehiculo creado con exito", 
            );
                    
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida", 
            );
            } 
        return $helpers->json($response);
    }

    /**
     * Finds and displays a CiudadanoVehiculo entity.
     *
     * @Route("/show/{id}", name="proìetariovehiculo_show")
     * @Method("POST")
     */
    public function showAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $propietarioVehiculo = $em->getRepository('AppBundle:PropietarioVehiculo')->find($id);
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "propietarioVehiculo con nombre"." ".$propietarioVehiculo->getLicenciaTransito(), 
                    'data'=> $propietarioVehiculo,
            );
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing CiudadanoVehiculo entity.
     *
     * @Route("/edit", name="proìetariovehiculo_edit")
     * @Method({"POST", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            var_dump($params);
            // die();

            $licenciaTransito = $params->licenciaTransito;
            $fechaPropiedadInicial = $params->fechaPropiedadInicial;
            $fechaPropiedadFinal = $params->fechaPropiedadFinal;
            $estadoPropiedad = $params->estadoPropiedad;
            $ciudadanoId = (isset($params->ciudadanoId)) ? $params->ciudadanoId : null;
            $empresaId = (isset($params->empresaId)) ? $params->empresaId : null;
            $vehiculoId = $params->vehiculoId;
            $em = $this->getDoctrine()->getManager();
            $ciudadano = $em->getRepository('AppBundle:Ciudadano')->findOneBy(
                array('id' => $ciudadanoId)
            );

            $vehiculo = $em->getRepository('AppBundle:Vehiculo')->findOneBy(
                            array('placa' => $vehiculoId)
            );

            $empresa = $em->getRepository('AppBundle:Empresa')->findOneBy(
                array('nit' => $empresaId)
            );

            $em = $this->getDoctrine()->getManager();
            $propietarioVehiculo = $em->getRepository("AppBundle:PropietarioVehiculo")->find($params->id);

            if ($propietarioVehiculo!=null) {
                $propietarioVehiculo->setLicenciaTransito($licenciaTransito);
                $propietarioVehiculo->setFechaPropiedadInicial($fechaPropiedadInicial);
                $propietarioVehiculo->setFechaPropiedadFinal($fechaPropiedadFinal);
                $propietarioVehiculo->setEstadoPropiedad($estadoPropiedad);
                $propietarioVehiculo->setCiudadano($ciudadano);
                $propietarioVehiculo->setEmpresa($empresa); 
                $propietarioVehiculo->setVehiculo($vehiculo);

                $propietarioVehiculo->setEstado(true);
                $em = $this->getDoctrine()->getManager();
                $em->persist($propietarioVehiculo);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "CiudadanoVehiculo actualizado con exito", 
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El propietarioVehiculo no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar propietarioVehiculo", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a CiudadanoVehiculo entity.
     *
     * @Route("/{id}/delete", name="propietariovehiculo_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $propietarioVehiculo = $em->getRepository('AppBundle:PropietarioVehiculo')->find($id);

            $propietarioVehiculo->setEstado(0);
            $em = $this->getDoctrine()->getManager();
                $em->persist($propietarioVehiculo);
                $em->flush();
            $response = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "propietarioVehiculo eliminado con exito", 
                );
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a CiudadanoVehiculo entity.
     *
     * @param CiudadanoVehiculo $propietarioVehiculo The PropietarioVehiculo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CiudadanoVehiculo $ciudadanoVehiculo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ciudadanovehiculo_delete', array('id' => $ciudadanoVehiculo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * busca los ciudadanos por vehiculo.
     *
     * @Route("/ciudadano/vehiculo/{id}", name="proìetario_vehiculo_show")
     * @Method("POST")
     */
    public function ciudadanoVehiculoAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $vehiculo = $em->getRepository('AppBundle:Vehiculo')->getVehiculoCampo($id);

            if($vehiculo==null){
                $response = array(
                    'status' => 'error',
                    'code' => 401,
                    'msj' => "este vehículo no se encuentra registrado en el sistema", 
                );
            }else{
                $propietarioVehiculo = $em->getRepository('AppBundle:PropietarioVehiculo')->findBy(
                array('vehiculo' => $vehiculo->getId(),
                        'estado' => 1,
                        'estadoPropiedad' => '1',
                        'permisoTramite' => '1'
                    )
                );

                if ($propietarioVehiculo!=null) {
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "propietario para vehiculo", 
                        'data'=> $propietarioVehiculo,
                    );
                }else{
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'msj' => "este vehiculo no tiene propietarios asignados", 
                    );
                }
            }
            
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing CiudadanoVehiculo entity.
     *
     * @Route("/new/propietario/vehiculo", name="proìetariovehiculo_Propietario")
     * @Method("POST")
     */
    public function newPropietarioAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $licenciaTransito = $params->licenciaTransito;
            $fechaPropiedadInicial = $params->fechaPropiedadInicial;
            $fechaPropiedadFinal = $params->fechaPropiedadFinal;
            $estadoPropiedad = $params->estadoPropiedad;
            $ciudadanoId = (isset($params->ciudadanoId)) ? $params->ciudadanoId : null;
            $empresaId = (isset($params->empresaId)) ? $params->empresaId : null;
            $vehiculoId = $params->vehiculoId;
            $em = $this->getDoctrine()->getManager();
            $ciudadano = $em->getRepository('AppBundle:Ciudadano')->findOneBy(
                array('id' => $ciudadanoId)
            );
            $vehiculo = $em->getRepository('AppBundle:Vehiculo')->findOneBy(
                            array('placa' => $vehiculoId)
            );

            $empresa = $em->getRepository('AppBundle:Empresa')->findOneBy(
                array('nit' => $empresaId)
            );

            $em = $this->getDoctrine()->getManager();
            $propietarioVehiculo = new PropietarioVehiculo();
                $propietarioVehiculo->setLicenciaTransito($licenciaTransito);
                $propietarioVehiculo->setFechaPropiedadInicial($fechaPropiedadInicial);
                $propietarioVehiculo->setFechaPropiedadFinal($fechaPropiedadFinal);
                $propietarioVehiculo->setEstadoPropiedad($estadoPropiedad);
                $propietarioVehiculo->setCiudadano($ciudadano);
                $propietarioVehiculo->setEmpresa($empresa); 
                $propietarioVehiculo->setVehiculo($vehiculo);

                $propietarioVehiculo->setEstado(true);
                $em = $this->getDoctrine()->getManager();
                $em->persist($propietarioVehiculo);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "CiudadanoVehiculo creado con exito", 
                );
            
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar propietarioVehiculo", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Lists all CiudadanoVehiculo entities.
     *
     * @Route("/edit/propietario/licencia", name="edit_propietario_licencia")
     * @Method("POST")
     */
    public function editPropietarioLicenciaAction(Request $request)
    {


        $helpers = $this->get("app.helpers");
        $json = $request->get("json",null);
        $params = json_decode($json);

        $cedula=$params->cedula;
        $licenciaTransito=$params->licenciaTransito;
        $vehiculoId=$params->vehiculoId;

        $em = $this->getDoctrine()->getManager();
        $usuario = $em->getRepository('UsuarioBundle:Usuario')->findOneByIdentificacion($cedula);
        $propietarioVehiculo = $em->getRepository('AppBundle:PropietarioVehiculo')->findOneBy(
            array(
                'ciudadano' => $usuario->getCiudadano()->getId(),
                'vehiculo' => $vehiculoId,
            )
        );
        var_dump($vehiculoId);
        var_dump($licenciaTransito);
        $propietarioVehiculo->setLicenciaTransito($licenciaTransito);
        // die();
        $em = $this->getDoctrine()->getManager();
        $em->persist($propietarioVehiculo);
        $em->flush();

        $response = array(
                    'status' => 'success',
                    'code' => 400,
                    'msj' => "listado propietarioVehiculos", 
                    
            );
         
        return $helpers->json($response);
    }

   
}
