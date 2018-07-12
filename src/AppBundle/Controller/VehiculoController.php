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
        $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado vehiculo", 
                    'data'=> $vehiculo,
            );
         
        return $helpers->json($response);

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
            //     $response = array(
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
                        $cilindraje = $params->cilindraje;
                        $modelo = $params->modelo;
                        $motor = $params->motor;
                        $chasis = $params->chasis;
                        $serie = $params->serie;
                        // $tipoVehiculo = $params->tipoVehiculo;
                        $radioAccion = $params->radioAccion;
                        $modalidadTransporte = $params->modalidadTransporte;
                        $vin = $params->vin;
                        $numeroPasajeros = $params->numeroPasajeros;
                        $municipioId = $params->municipioId;
                        $lineaId = $params->lineaId;
                        $servicioId = $params->servicioId;
                        $colorId = $params->colorId;
                        $combustibleId = $params->combustibleId;
                        $carroceriaId = $params->carroceriaId;
                        $sedeOperativaId = $params->sedeOperativaId;
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
                        $sedeOperativa = $em->getRepository('AppBundle:SedeOperativa')->find($sedeOperativaId);
                        $clase = $em->getRepository('AppBundle:Clase')->find($claseId);
                        $vehiculo = new Vehiculo();
                        
                        $fechaFactura=new \DateTime($fechaFactura);

                        $CfgPlaca = $em->getRepository('AppBundle:CfgPlaca')->findOneByNumero($placa);
                     
                        $vehiculo->setCfgPlaca($CfgPlaca);
                        $vehiculo->setNumeroFactura($numeroFactura);
                        $vehiculo->setfechaFactura($fechaFactura);
                        $vehiculo->setValor($valor);
                        $vehiculo->setNumeroManifiesto($numeroManifiesto);
                        $vehiculo->setFechaManifiesto(new \DateTime( $params->fechaManifiesto));
                        $vehiculo->setCilindraje($cilindraje);
                        $vehiculo->setModelo($modelo);
                        $vehiculo->setMotor($motor);
                        $vehiculo->setChasis($chasis);
                        $vehiculo->setSerie($serie);
                        $vehiculo->setRadioAccion($radioAccion);
                        $vehiculo->setModalidadTransporte($modalidadTransporte);
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
                        $vehiculo->setSedeOperativa($sedeOperativa);
                        $vehiculo->setClase($clase);
                        $vehiculo->setPignorado($pignorado);
                        $vehiculo->setCancelado($cancelado);

                        $vehiculo->setEstado(true);
                        $em = $this->getDoctrine()->getManager();
                        $em->persist($vehiculo);
                        $em->flush();

                        $response = array(
                            'status' => 'success',
                            'code' => 200,
                            'msj' => "Vehiculo creado con exito", 
                        );
                       
                    // }
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
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "vehiculo", 
                    'data'=> $vehiculo,
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
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "vehiculo", 
                    'data'=> $vehiculo,
            );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Vehiculo no encotrado", 
                );
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
            $valor = $params->valor;
            $numeroManifiesto = $params->numeroManifiesto;
            $cilindraje = $params->cilindraje;
            $modelo = $params->modelo;
            $motor = $params->motor;
            $chasis = $params->chasis;
            $serie = $params->serie;
            // $tipoVehiculo = $params->tipoVehiculo;
            $radioAccion = $params->radioAccion;
            $modalidadTransporte = $params->modalidadTransporte;
            $vin = $params->vin;
            $numeroPasajeros = $params->numeroPasajeros;
            $municipioId = $params->municipioId;
            $lineaId = $params->lineaId;
            $servicioId = $params->servicioId;
            $colorId = $params->colorId;
            $combustibleId = $params->combustibleId;
            $carroceriaId = $params->carroceriaId;
            $sedeOperativaId = $params->sedeOperativaId;
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
            $sedeOperativa = $em->getRepository('AppBundle:SedeOperativa')->find($sedeOperativaId);
            $clase = $em->getRepository('AppBundle:Clase')->find($claseId);
            $em = $this->getDoctrine()->getManager();

            $vehiculo = $em->getRepository("AppBundle:Vehiculo")->find($params->id);


            $CfgPlaca = $em->getRepository('AppBundle:CfgPlaca')->findOneByNumero($placa);
            
            if ($vehiculo!=null) {
                $vehiculo->setCfgPlaca($CfgPlaca);
                $vehiculo->setNumeroFactura($numeroFactura);
                //$vehiculo->setFechaFactura(new \DateTime($params->fechaFactura));
                $vehiculo->setFechaFactura($params->fechaFactura);
                $vehiculo->setValor($valor);
                $vehiculo->setNumeroManifiesto($numeroManifiesto);
                //$vehiculo->setFechaManifiesto(new \DateTime( $params->fechaManifiesto));
                $vehiculo->setFechaManifiesto($params->fechaManifiesto);
                $vehiculo->setCilindraje($cilindraje);
                $vehiculo->setModelo($modelo);
                $vehiculo->setMotor($motor);
                $vehiculo->setChasis($chasis);
                $vehiculo->setSerie($serie);
                // $vehiculo->setTipoVehiculo($tipoVehiculo);
                $vehiculo->setRadioAccion($radioAccion);
                $vehiculo->setModalidadTRansporte($modalidadTransporte);
                $vehiculo->setNumeroPasajeros($numeroPasajeros);
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
                $vehiculo->setSedeOperativa($sedeOperativa);
                $vehiculo->setClase($clase);
                $vehiculo->setPignorado($pignorado);
                $vehiculo->setCancelado($cancelado);
                $vehiculo->setEstado(true);
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Vehiculo editado con exito", 
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El vehiculo no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar vehiculo", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing Vehiculo entity.
     *
     * @Route("/edit/color", name="vehiculo_edit")
     * @Method({"GET", "POST"})
     */
    public function editColorAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("json",null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            $color = $em->getRepository('AppBundle:Color')->find($params->colorId);
            $vehiculo = $em->getRepository("AppBundle:Vehiculo")->find($params->id);
            
            if ($vehiculo!=null) {                
                $vehiculo->setColor($color);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Vehiculo editado con éxito", 
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El vehiculo no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar vehiculo", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing Vehiculo entity.
     *
     * @Route("/edit/sedeOperativa", name="vehiculo_edit_sedeOperativa")
     * @Method({"GET", "POST"})
     */
    public function editSedeOperativaAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $vehiculo = $em->getRepository("AppBundle:Vehiculo")->find($params->id);
            $sedeOperativa = $em->getRepository("AppBundle:SedeOperativa")->find($params->sedeOperativaId);

            if ($vehiculo!=null) {
                $vehiculo->setSedeOperativa($sedeOperativa);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Vehiculo editado con exito", 
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El vehiculo no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar vehiculo", 
                );
        }

        return $helpers->json($response);
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
            $response = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "vehiculo eliminado con exito", 
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

    /**
     * datos para select 2
     *
     * @Route("/select", name="vehiculo_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $vehiculos = $em->getRepository('AppBundle:Vehiculo')->findBy(
        array('estado' => 1)
    );
      foreach ($vehiculos as $key => $vehiculo) {
        $response[$key] = array(
            'value' => $vehiculo->getId(),
            'label' => $vehiculo->getPlaca(),
            );
      }
       return $helpers->json($response);
    }



    /**
     * Filtra los vehiculos por los parametros estado clase y sede operativa.
     *
     * @Route("/fin/by/parameters", name="vehiculo_find_by_parameters")
     * @Method({"GET", "POST"})
     */
    public function findByParametersAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $json = $request->get("json",null);
            $params = json_decode($json);

            $estado = $params->estado;
            $claseId = (isset($params->claseId)) ? $params->claseId : 0;
            $sedeOperativaId = (isset($params->sedeOperativaId)) ? $params->sedeOperativaId : 0;
            $pignorado = 0;
            $cancelado = 0;

            if ($estado == 1) {
                $pignorado = 1;
            }elseif ($estado == 2) {
                $cancelado = 1;
            }

            if ($claseId == 0 and $sedeOperativaId == 0 ) {
                $vehiculos = $em->getRepository('AppBundle:Vehiculo')->findBy(
                    array(
                        'pignorado' => $pignorado,
                        'cancelado' => $cancelado,
                        'estado' => 1,
                    )
                );  
            }elseif ($claseId == 0 and $sedeOperativaId != 0 ) {
                $vehiculos = $em->getRepository('AppBundle:Vehiculo')->findBy(
                    array(
                        'pignorado' => $pignorado,
                        'cancelado' => $cancelado,
                        'sedeOperativa' => $sedeOperativaId,
                        'estado' => 1,
                    )
                ); 
            }elseif ($claseId != 0 and $sedeOperativaId == 0) {
                $vehiculos = $em->getRepository('AppBundle:Vehiculo')->findBy(
                    array(
                        'pignorado' => $pignorado,
                        'cancelado' => $cancelado,
                        'clase' => $claseId,
                        'estado' => 1,
                    )
                ); 
            }elseif ($claseId != 0 and $sedeOperativaId != 0) {
                $vehiculos = $em->getRepository('AppBundle:Vehiculo')->findBy(
                    array(
                        'pignorado' => $pignorado,
                        'cancelado' => $cancelado,
                        'clase' => $claseId,
                        'sedeOperativa' => $sedeOperativaId,
                        'estado' => 1,
                    )
                );
            }

            if (count($vehiculos) > 0) {
                $response = array(
                    'status' => 'success',
                    'code' => 500,
                    'data' => $vehiculos, 
                ); 
            }else{
                $response = array(
                    'status' => 'notFound',
                    'code' => 600,
                    'msj' => "No se encontraron registros con los parametros seleccionados", 
                );
            }

        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no validaaaaaaa", 
            );  
        }
        
        return $helpers->json($response);
    }


    /**
     * Displays a form to asignacionPlca an existing Vehiculo entity.
     *
     * @Route("/asignacionPlaca", name="vehiculo_asignacionPlaca")
     * @Method({"GET", "POST"})
     */

    public function asignacionPlaca(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $placa = $params->placa;
            $sedeOperativaId = $params->sedeOperativaId;
          

            $em = $this->getDoctrine()->getManager();            
            $sedeOperativa = $em->getRepository('AppBundle:SedeOperativa')->find($sedeOperativaId);
            //bucar en una tabla x
            $CfgPlaca = $em->getRepository('AppBundle:CfgPlaca')->findOneByNumero($placa);

            $em = $this->getDoctrine()->getManager();
            $vehiculo = $em->getRepository("AppBundle:Vehiculo")->find($params->id);
           
            if ($vehiculo!=null) {
                $vehiculo->setCfgPlaca($CfgPlaca);               
                $vehiculo->setSedeOperativa($sedeOperativa);
                $CfgPlaca->setEstado('asignado');
               
                $em = $this->getDoctrine()->getManager();
                $em->persist($vehiculo);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Vehiculo editado con exito", 
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El vehiculo no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar vehiculo", 
                );
        }

        return $helpers->json($response);
    }


}
