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
        $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado propietarioVehiculos", 
                    'data'=> $propietarioVehiculos,
            );
         
        return $helpers->json($responce);
    }

    /**
     * Creates a new CiudadanoVehiculo entity.
     *
     * @Route("/new/{idTramite}", name="propietariovehiculo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request,$idTramite)
    {
        
        $helpers = $this->get("app.helpers"); 
        $hash = $request->get("authorization", null);
        $data = $request->get("datos",null);
        $data = json_decode($data);
        $casosVariantes = $request->get("casosVariantes",null);
        $entradas = json_decode($casosVariantes);

        $caso = (isset($entradas->caso)) ? $entradas->caso : null;
        $variante = (isset($entradas->variante)) ? $entradas->variante : null;
        $em = $this->getDoctrine()->getManager();


        $casoBd = $em->getRepository('AppBundle:Caso')->findOneBy(
            array('estado' => 1,'id' => $caso)
        );

        $varianteBd = $em->getRepository('AppBundle:Variante')->findOneBy(
            array('estado' => 1,'id' => $variante)
        );

       
        $datos = array('datosGenerales' =>$data->datosGenerales);
        


        $authCheck = $helpers->authCheck($hash);
        if ($authCheck == true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

           if (count($params)==0) {
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "los campos no pueden estar vacios", 
                );
            }else{
                        $licenciaTransito = (isset($params->licenciaTransito)) ? $params->licenciaTransito : null;
                        $fechaPropiedadInicial = $params->fechaPropiedadInicial; 
                        $fechaPropiedadFinal = $params->fechaPropiedadFinal;
                        $estadoPropiedad = $params->estadoPropiedad;
                        $ciudadanoId = (isset($params->ciudadanoId)) ? $params->ciudadanoId : null;
                        $vehiculoId = $params->vehiculoId;
                        $empresaId = (isset($params->empresaId)) ? $params->empresaId : null;
                        $em = $this->getDoctrine()->getManager();
                        $ciudadano = $em->getRepository('AppBundle:Ciudadano')->findOneBy(
                            array('numeroIdentificacion' => $ciudadanoId)
                        );
                        $vehiculo = $em->getRepository('AppBundle:Vehiculo')->findOneBy(
                            array('placa' => $vehiculoId)
                        );

                        $empresa = $em->getRepository('AppBundle:Empresa')->findOneBy(
                            array('nit' => $empresaId)
                        );

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
                        
                        $tramiteGeneral = $em->getRepository('AppBundle:TramiteGeneral')->findOneBy(
                            array('estado' => 1,'numeroLicencia' => $licenciaTransito)
                        );

                        if( $tramiteGeneral == null){
                            $tramiteGeneral = new TramiteGeneral();
                            $tramiteGeneral->setVehiculo($vehiculo);
                            $tramiteGeneral->setValor(0);
                            $tramiteGeneral->setNumeroQpl(0);
                            $tramiteGeneral->setFechaInicial($fechaPropiedadInicial);
                            $tramiteGeneral->setFechaFinal($fechaPropiedadFinal);
                            $tramiteGeneral->setNumeroLicencia($licenciaTransito);
                            $tramiteGeneral->setNumeroSustrato(0);
                            $tramiteGeneral->setEstadoTramite(2);
                            $tramiteGeneral->setCiudadano($ciudadano);
                            $tramiteGeneral->setEmpresa($empresa);
                            $tramiteGeneral->setApoderado(false);
                            $tramiteGeneral->setEstado(1);
                            $em->persist($tramiteGeneral);
                            $em->flush();
                            
                            $tramiteEspecifico = new TramiteEspecifico();

                            $tramite = $em->getRepository('AppBundle:Tramite')->findOneBy(
                                array('estado' => 1,'id' => $idTramite)
                            );

                            $tramiteGeneral = $em->getRepository('AppBundle:TramiteGeneral')->findOneBy(
                                array('estado' => 1,'vehiculo' => $vehiculo->getId())
                            );

                            $tramiteEspecifico->setDatos($datos);
                            $tramiteEspecifico->setTramite($tramite);
                            $tramiteEspecifico->setTramiteGeneral($tramiteGeneral);
                            $tramiteEspecifico->setCaso($casoBd);
                            $tramiteEspecifico->setVariante($varianteBd);
                            $tramiteEspecifico->setValor(0);
                            $tramiteEspecifico->setEstado(1);

                            $em->persist($tramiteEspecifico);
                        }

                        
                        $em->flush();


                        $responce = array(
                            'status' => 'success',
                            'code' => 200,
                            'msj' => "Proìetario Vehiculo creado con exito", 
                        );
                       
                    }
        }else{
            $responce = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida", 
            );
            } 
        return $helpers->json($responce);
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
            $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "propietarioVehiculo con nombre"." ".$propietarioVehiculo->getLicenciaTransito(), 
                    'data'=> $propietarioVehiculo,
            );
        }else{
            $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($responce);
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
                $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "CiudadanoVehiculo actualizado con exito", 
                );
            }else{
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El propietarioVehiculo no se encuentra en la base de datos", 
                );
            }
        }else{
            $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar propietarioVehiculo", 
                );
        }

        return $helpers->json($responce);
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
            $responce = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "propietarioVehiculo eliminado con exito", 
                );
        }else{
            $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($responce);
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
            $propietarioVehiculo = $em->getRepository('AppBundle:PropietarioVehiculo')->findBy(
            array('vehiculo' => $id,
                    'estado' => 1
                )
            );

            if ($propietarioVehiculo!=null) {
                $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "propietario para vehiculo", 
                    'data'=> $propietarioVehiculo,
                );
            }else{
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "este vehiculo no tiene propietarios asignados", 
                );
            }
            
        }else{
            $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($responce);
    }

   
}
