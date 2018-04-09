<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\TramiteGeneral;
use AppBundle\Form\TramiteGeneralType;

/**
 * TramiteGeneral controller.
 *
 * @Route("/tramitegeneral")
 */
class TramiteGeneralController extends Controller
{
    /**
     * Lists all TramiteGeneral entities.
     *
     * @Route("/", name="tramitegeneral_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $tramiteGeneral = $em->getRepository('AppBundle:TramiteGeneral')->findBy(
            array('estado' => 1)
        );
        $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado tramiteGeneral", 
                    'data'=> $tramiteGeneral,
            );
         
        return $helpers->json($responce);
    }

    /**
     * Creates a new TramiteGeneral entity.
     *
     * @Route("/new", name="tramitegeneral_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck== true) {
            $json = $request->get("json",null);
            $params = json_decode($json);
            // if (count($params)==0) {
            //     $responce = array(
            //         'status' => 'error',
            //         'code' => 400,
            //         'msj' => "los campos no pueden estar vacios", 
            //     );
            // }else{
                        $numeroQpl = (isset($params->numeroQpl)) ? $params->numeroQpl : 0; 
                        $fechaInicial = $params->fechaFinal;
                        $fechaFinal = $params->fechaFinal;
                        $valor = (isset($params->valor)) ? $params->valor : 0; 
                        $numeroLicencia = $params->numeroLicencia;
                        $numeroSustrato = (isset($params->numeroSustrato)) ? $params->numeroSustrato : false;
                        $vehiculoId = $params->vehiculoId;
                        $apoderado = (isset($params->apoderado)) ? $params->apoderado : false;
                        $ciudadanoId = (isset($params->ciudadanoId)) ? $params->ciudadanoId : null;
                        $empresaId = (isset($params->empresaId)) ? $params->empresaId : null;
                        $em = $this->getDoctrine()->getManager();
                        $vehiculo = $em->getRepository('AppBundle:Vehiculo')->find($vehiculoId);
                        $ciudadano = $em->getRepository('AppBundle:Ciudadano')->findOneBy(
                            array(
                            'estado' => 1,
                            'id' => $ciudadanoId,
                            ));
                        $empresa = $em->getRepository('AppBundle:Empresa')->findOneBy(
                            array(
                            'estado' => 1,
                            'id' => $empresaId,
                            ));
                        $tramiteGeneral = new TramiteGeneral();
                        $tramiteGeneral->setNumeroQpl($numeroQpl);
                        $tramiteGeneral->setFechaInicial($fechaInicial);
                        $tramiteGeneral->setFechaFinal($fechaFinal);
                        $tramiteGeneral->setValor($valor);
                        $tramiteGeneral->setNumeroLicencia($numeroLicencia);
                        $tramiteGeneral->setNumeroSustrato($numeroSustrato);
                        $tramiteGeneral->setVehiculo($vehiculo);
                        $tramiteGeneral->setEstado(true);
                        $tramiteGeneral->setApoderado($apoderado);
                        $tramiteGeneral->setCiudadano($ciudadano);
                        $tramiteGeneral->setEmpresa($empresa);
                        $tramiteGeneral->setEstadoTramite(2);
                        $em = $this->getDoctrine()->getManager();
                        $em->persist($tramiteGeneral);
                        $em->flush();
                        $responce = array(
                            'status' => 'success',
                            'code' => 200,
                            'msj' => "tramiteGeneral creado con exito", 
                        );
                    // }
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
     * Finds and displays a TramiteGeneral entity.
     *
     * @Route("/show/{id}", name="tramitegeneral_show")
     * @Method("POST")
     */
    public function showAction(Request $request , $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $tramiteGeneral = $em->getRepository('AppBundle:TramiteGeneral')->find($id);
            $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "tramiteGeneral", 
                    'data'=> $tramiteGeneral,
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
     * Displays a form to edit an existing TramiteGeneral entity.
     *
     * @Route("/edit", name="tramitegeneral_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("json",null);
            $params = json_decode($json);
            $numeroQpl = $params->numeroQpl;
            $fechaInicial = $params->fechaInicial;
            $fechaFinal = $params->fechaFinal;
            $valor = $params->valor;
            $numeroLicencia = $params->numeroLicencia;
            $numeroSustrato = $params->numeroSustrato;
            $vehiculoId = $params->vehiculoId;
            $apoderado = (isset($params->apoderado)) ? $params->ciudadanoId : false;
            $ciudadanoId = (isset($params->ciudadanoId)) ? $params->ciudadanoId : null;
            $empresaId = (isset($params->empresaId)) ? $params->empresaId : null;

            $em = $this->getDoctrine()->getManager();
            $vehiculo = $em->getRepository('AppBundle:Vehiculo')->find($vehiculoId);
            $ciudadano = $em->getRepository('AppBundle:Ciudadano')->findOneBy(
                array(
                'estado' => 1,
                'numeroIdentificacion' => $ciudadanoId,
                ));
            $empresa = $em->getRepository('AppBundle:Empresa')->findOneBy(
                array(
                'estado' => 1,
                'nit' => $empresaId,
                ));
            $tramiteGeneral = $em->getRepository("AppBundle:TramiteGeneral")->find($params->id);

            if ($tramiteGeneral!=null) {
                $tramiteGeneral->setNumeroQpl($numeroQpl);
                $tramiteGeneral->setFechaInicial($fechaInicial);
                $tramiteGeneral->setFechaFinal($fechaFinal);
                $tramiteGeneral->setValor($valor);
                $tramiteGeneral->setNumeroLicencia($numeroLicencia);
                $tramiteGeneral->setNumeroSustrato($numeroSustrato);
                $tramiteGeneral->setVehiculo($vehiculo);
                $tramiteGeneral->setEstado(true);
                $tramiteGeneral->setApoderado($apoderado);
                $tramiteGeneral->setCiudadano($ciudadano);
                $tramitegeneral->setEmpresa($empresa);
                $tramiteGeneral->setEstadoTramite(2);
                $em = $this->getDoctrine()->getManager();
                $em->persist($tramiteGeneral);
                $em->flush();
                $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "tramiteGeneral editado con exito", 
                );
            }else{
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El banco no se encuentra en la base de datos", 
                );
            }
        }else{
            $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar banco", 
                );
        }

        return $helpers->json($responce);
    }

    /**
     * Deletes a TramiteGeneral entity.
     *
     * @Route("/{id}/delete", name="tramitegeneral_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $tramiteGeneral = $em->getRepository('AppBundle:TramiteGeneral')->find($id);

            $tramiteGeneral->setEstado(0);
            $em = $this->getDoctrine()->getManager();
                $em->persist($tramiteGeneral);
                $em->flush();
            $responce = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "tramiteGeneral eliminado con exito", 
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
     * Creates a form to delete a TramiteGeneral entity.
     *
     * @param TramiteGeneral $tramiteGeneral The TramiteGeneral entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TramiteGeneral $tramiteGeneral)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tramitegeneral_delete', array('id' => $tramiteGeneral->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * busca los tramites generales de un vehiculo por placa.
     *
     * @Route("/tramitesG/placa", name="tramitegeneral_show_placa")
     * @Method("POST") 
     */
    public function showTramiteGAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $json = $request->get("json",null);
        $params = json_decode($json);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $tramitesGenerales = $em->getRepository('AppBundle:TramiteGeneral')->findBy(
            array('estado' => 1,'vehiculo' => $params->vehiculoId)
            );

            if ($tramitesGenerales!=null) {
               $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "tramiteGeneral", 
                    'data'=> $tramitesGenerales,
            ); 
            }else{
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "No existen tramites generales asociados", 
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
