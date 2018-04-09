<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Vehiculo;
use AppBundle\Form\VehiculoType;

/**
 * Vehiculo controller.
 *
 * @Route("/vehiculo")
 */
class VehiculoController extends Controller
{
    /**
     * Lists all Vehiculo entities.
     *
     * @Route("/", name="vehiculo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $vehiculo = $em->getRepository('AppBundle:Vehiculo')->findBy(
            array('estado' => 1)
        );
        $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado vehiculo", 
                    'data'=> $vehiculo,
            );
         
        return $helpers->json($responce);

    }

    /**
     * Creates a new Vehiculo entity.
     *
     * @Route("/new", name="vehiculo_new")
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
                        $placa = $params->placa;
                        $numeroFactura = $params->numeroFactura;
                        $fechaFactura = $params->fechaFactura;
                        $valor = $params->valor;
                        $numeroManifiesto = $params->numeroManifiesto;
                        $fechaManifiesto = $params->fechaManifiesto;
                        $cilindraje = $params->cilindraje;
                        $modelo = $params->modelo;
                        $motor = $params->motor;
                        $chasis = $params->chasis;
                        $serie = $params->serie;
                        $tipoVehiculo = $params->tipoVehiculo;
                        $radioAccion = $params->radioAccion;
                        $modalidadTransporte = $params->modalidadTransporte;
                        $transportePasajeros = $params->transportePasajeros;
                        $vin = $params->vin;
                        $numeroPasajeros = $params->numeroPasajeros;
                        $municipioId = $params->municipioId;
                        $lineaId = $params->lineaId;
                        $servicioId = $params->servicioId;
                        $colorId = $params->colorId;
                        $combustibleId = $params->combustibleId;
                        $carroceriaId = $params->carroceriaId;
                        $organismoTransitoId = $params->organismoTransitoId;
                        $claseId = $params->claseId;
                        $pignorado = (isset($params->pignorado)) ? $params->pignorado : false;
                        $cancelado = (isset($params->cancelado)) ? $params->cancelado : false;
                        $em = $this->getDoctrine()->getManager();
                        $municipio = $em->getRepository('AppBundle:Municipio')->find($municipioId);
                        $linea = $em->getRepository('AppBundle:Linea')->find($lineaId);
                        $servicio = $em->getRepository('AppBundle:Servicio')->find($servicioId);
                        $color = $em->getRepository('AppBundle:Color')->find($colorId);
                        $combustible = $em->getRepository('AppBundle:Combustible')->find($combustibleId);
                        $carroceria = $em->getRepository('AppBundle:Carroceria')->find($carroceriaId);
                        $organismoTransito = $em->getRepository('AppBundle:OrganismoTransito')->find($organismoTransitoId);
                        $clase = $em->getRepository('AppBundle:Clase')->find($claseId);
                        $vehiculo = new Vehiculo();
                        $vehiculo->setPlaca($placa);
                        $vehiculo->setNumeroFactura($numeroFactura);
                        $vehiculo->setfechaFactura($fechaFactura);
                        $vehiculo->setValor($valor);
                        $vehiculo->setNumeroManifiesto($numeroManifiesto);
                        $vehiculo->setFechaManifiesto($fechaManifiesto);
                        $vehiculo->setCilindraje($cilindraje);
                        $vehiculo->setModelo($modelo);
                        $vehiculo->setMotor($motor);
                        $vehiculo->setChasis($chasis);
                        $vehiculo->setSerie($serie);
                        $vehiculo->setTipoVehiculo($tipoVehiculo);
                        $vehiculo->setRadioAccion($radioAccion);
                        $vehiculo->setModalidadTRansporte($modalidadTransporte);
                        $vehiculo->setTransportePasajeros($transportePasajeros);
                        $vehiculo->setSerie($serie);
                        $vehiculo->setSerie($serie);
                        $vehiculo->setVin($vin);
                        $vehiculo->setNumeroPasajeros($numeroPasajeros);
                        $vehiculo->setMunicipio($municipio);
                        $vehiculo->setLinea($linea);
                        $vehiculo->setServicio($servicio);
                        $vehiculo->setColor($color);
                        $vehiculo->setCombustible($combustible);
                        $vehiculo->setCarroceria($carroceria);
                        $vehiculo->setOrganismoTransito($organismoTransito);
                        $vehiculo->setClase($clase);
                        $vehiculo->setPignorado($pignorado);
                        $vehiculo->setCancelado($cancelado);

                        $vehiculo->setEstado(true);
                        $em = $this->getDoctrine()->getManager();
                        $em->persist($vehiculo);
                        $em->flush();

                        $responce = array(
                            'status' => 'success',
                            'code' => 200,
                            'msj' => "Vehiculo creado con exito", 
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
     * Finds and displays a Vehiculo entity.
     *
     * @Route("/show/{id}", name="vehiculo_show")
     * @Method("POST")
     */
    public function showAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $vehiculo = $em->getRepository('AppBundle:Vehiculo')->find($id);
            $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "vehiculo", 
                    'data'=> $vehiculo,
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
     * busca vehiculos por placa.
     *
     * @Route("/placa", name="vehiculo_show_ide")
     * @Method("POST")
     */
    public function vehiculoPorPlaca(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);


        if ($authCheck == true) {
            $json = $request->get("json",null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            $vehiculo = $em->getRepository('AppBundle:Vehiculo')->findOneBy(
            array('placa' => $params->placa)
            );

            if ($vehiculo!=null) {
                $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "vehiculo", 
                    'data'=> $vehiculo,
            );
            }else{
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Vehiculo no encotrado", 
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
     * Displays a form to edit an existing Vehiculo entity.
     *
     * @Route("/edit", name="vehiculo_edit")
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

            $placa = $params->placa;
            $numeroFactura = $params->numeroFactura;
            $fechaFactura = $params->fechaFactura;
            $valor = $params->valor;
            $numeroManifiesto = $params->numeroManifiesto;
            $fechaManifiesto = $params->fechaManifiesto;
            $cilindraje = $params->cilindraje;
            $modelo = $params->modelo;
            $motor = $params->motor;
            $chasis = $params->chasis;
            $serie = $params->serie;
            $tipoVehiculo = $params->tipoVehiculo;
            $radioAccion = $params->radioAccion;
            $modalidadTransporte = $params->modalidadTransporte;
            $transportePasajeros = $params->transportePasajeros;
            $vin = $params->vin;
            $numeroPasajeros = $params->numeroPasajeros;
            $municipioId = $params->municipioId;
            $lineaId = $params->lineaId;
            $servicioId = $params->servicioId;
            $colorId = $params->colorId;
            $combustibleId = $params->combustibleId;
            $carroceriaId = $params->carroceriaId;
            $organismoTransitoId = $params->organismoTransitoId;
            $claseId = $params->claseId;
            $pignorado = (isset($params->pignorado)) ? $params->pignorado : false;
            $cancelado = (isset($params->cancelado)) ? $params->cancelado : false;
            $em = $this->getDoctrine()->getManager();
            $municipio = $em->getRepository('AppBundle:Municipio')->find($municipioId);
            $linea = $em->getRepository('AppBundle:Linea')->find($lineaId);
            $servicio = $em->getRepository('AppBundle:Servicio')->find($servicioId);
            $color = $em->getRepository('AppBundle:Color')->find($colorId);
            $combustible = $em->getRepository('AppBundle:Combustible')->find($combustibleId);
            $carroceria = $em->getRepository('AppBundle:Carroceria')->find($carroceriaId);
            $organismoTransito = $em->getRepository('AppBundle:OrganismoTransito')->find($organismoTransitoId);
            $clase = $em->getRepository('AppBundle:Clase')->find($claseId);
            $em = $this->getDoctrine()->getManager();
            $vehiculo = $em->getRepository("AppBundle:Vehiculo")->find($params->id);
            if ($vehiculo!=null) {
                $vehiculo->setPlaca($placa);
                $vehiculo->setNumeroFactura($numeroFactura);
                $vehiculo->setfechaFactura($fechaFactura);
                $vehiculo->setValor($valor);
                $vehiculo->setNumeroManifiesto($numeroManifiesto);
                $vehiculo->setFechaManifiesto($fechaManifiesto);
                $vehiculo->setCilindraje($cilindraje);
                $vehiculo->setModelo($modelo);
                $vehiculo->setMotor($motor);
                $vehiculo->setChasis($chasis);
                $vehiculo->setSerie($serie);
                $vehiculo->setTipoVehiculo($tipoVehiculo);
                $vehiculo->setRadioAccion($radioAccion);
                $vehiculo->setModalidadTRansporte($modalidadTransporte);
                $vehiculo->setTransportePasajeros($transportePasajeros);
                $vehiculo->setSerie($serie);
                $vehiculo->setSerie($serie);
                $vehiculo->setVin($vin);
                $vehiculo->setNumeroPasajeros($numeroPasajeros);
                $vehiculo->setMunicipio($municipio);
                $vehiculo->setLinea($linea);
                $vehiculo->setServicio($servicio);
                $vehiculo->setColor($color);
                $vehiculo->setCombustible($combustible);
                $vehiculo->setCarroceria($carroceria);
                $vehiculo->setOrganismoTransito($organismoTransito);
                $vehiculo->setClase($clase);
                $vehiculo->setPignorado($pignorado);
                $vehiculo->setCancelado($cancelado);
                $vehiculo->setEstado(true);
                $em = $this->getDoctrine()->getManager();
                $em->persist($vehiculo);
                $em->flush();
                $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Vehiculo editado con exito", 
                );
            }else{
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El vehiculo no se encuentra en la base de datos", 
                );
            }
        }else{
            $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar vehiculo", 
                );
        }

        return $helpers->json($responce);
    }

    /**
     * Deletes a Vehiculo entity.
     *
     * @Route("/{id}/delete", name="vehiculo_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $vehiculo = $em->getRepository('AppBundle:Vehiculo')->find($id);

            $vehiculo->setEstado(0);
            $em = $this->getDoctrine()->getManager();
                $em->persist($vehiculo);
                $em->flush();
            $responce = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "vehiculo eliminado con exito", 
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
     * Creates a form to delete a Vehiculo entity.
     *
     * @param Vehiculo $vehiculo The Vehiculo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Vehiculo $vehiculo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vehiculo_delete', array('id' => $vehiculo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
