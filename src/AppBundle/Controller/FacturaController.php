<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Factura;
use AppBundle\Entity\MflRetefuente;
use AppBundle\Entity\TramiteFactura;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Factura controller.
 *
 * @Route("factura")
 */
class FacturaController extends Controller
{
    /**
     * Lists all factura entities.
     *
     * @Route("/", name="factura_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $facturas = $em->getRepository('AppBundle:Factura')->findByEstado('Emitida');

        $response = array(
            'status' => 'success',
            'code' => 200,
            'msj' => "Lista de facturas",
            'data' => $facturas, 
        );
        return $helpers->json($response);
    }

    /**
     * Creates a new factura entity.
     *
     * @Route("/new", name="factura_new")
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
            /*if (count($params)==0) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Los campos no pueden estar vacios", 
                );
            }else{*/
                $em = $this->getDoctrine()->getManager();
                $facturas = $em->getRepository('AppBundle:Factura')->findByEstado(true);
                $consecutivo = count($facturas)."-".date('y');

                $sedeOperativa = $em->getRepository('AppBundle:SedeOperativa')->find(
                    $params->factura->sedeOperativaId
                );
                $factura = new Factura();

                if ($params->factura->vehiculoId) {
                    $vehiculo = $em->getRepository('AppBundle:Vehiculo')->find(
                        $params->factura->vehiculoId
                    );
                    $factura->setVehiculo($vehiculo);
                }
                
                $ciudadano = $em->getRepository('AppBundle:Ciudadano')->find(
                    $params->factura->ciudadanoId
                );

                $factura->setNumero($params->factura->numero);
                $factura->setConsecutivo(0);
                $factura->setEstado('Emitida');
                $factura->setFechaCreacion(new \DateTime($params->factura->fechaCreacion));
                $factura->setFechaVencimiento(new \DateTime($params->factura->fechaCreacion));
                if ($params->factura->valorBruto) {
                    $factura->setValorBruto($params->factura->valorBruto);
                }
                
                //Inserta llaves foraneas
                $factura->setSedeOperativa($sedeOperativa);
                $factura->setCiudadano($ciudadano);
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($factura);
                $em->flush();

                foreach ($params->tramitesValor as $key => $tramiteValor) {
                    $tramiteFactura = new TramiteFactura();

                    $tramitePrecio = $em->getRepository('AppBundle:TramitePrecio')->findOneBy(
                        array('nombre' => $tramiteValor->nombre, 'estado'=>1, 'activo'=>1)
                    );
                    if($tramitePrecio->getTramite()->getId() == 2){ 
                        $valorVehiculo = $em->getRepository('AppBundle:CfgValorVehiculo')->find(
                            $params->valorVehiculoId
                        );
                        foreach ($params->propietarios as $key => $propietarioRetefuenteId) {
                            $propietarioVehiculo = $em->getRepository('AppBundle:PropietarioVehiculo')->find(
                                $propietarioRetefuenteId
                            );
                            $mflRetefunte = new MflRetefuente();
                            $mflRetefunte->setVehiculo($vehiculo);
                            $mflRetefunte->setPropietarioVehiculo($propietarioVehiculo);
                            $mflRetefunte->setValorVehiculo($valorVehiculo);
                            $mflRetefunte->setFactura($factura);
                            $mflRetefunte->setFecha(new \DateTime($params->factura->fechaCreacion));
                            $mflRetefunte->setRetencion($params->retencion);
                            $mflRetefunte->setEstado(true);
                            $em->persist($mflRetefunte);
                            $em->flush();
                        }
                    }

                    $tramiteFactura->setFactura($factura);
                    $tramiteFactura->setTramitePrecio($tramitePrecio);
                    $tramiteFactura->setEstado(true);
                    $tramiteFactura->setRealizado(false);
                    $tramiteFactura->setCantidad(1);
                    $em->persist($tramiteFactura);
                    $em->flush();
                }

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro creado con exito", 
                );
            //}
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
     * Finds and displays a factura entity.
     *
     * @Route("/{id}/show", name="factura_show")
     * @Method("GET")
     */
    public function showAction(Factura $factura, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $factura = $em->getRepository('AppBundle:Factura')->find($id);
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "factura con numero"." ".$factura->getNumero(), 
                    'data'=> $factura,
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
     * Displays a form to edit an existing factura entity.
     *
     * @Route("/edit", name="factura_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            $factura = $em->getRepository("AppBundle:Factura")->find($params->id);

            $numero = $params->numero;
            $estado = $params->estado;
            $observacion = (isset($params->observacion)) ? $params->observacion : null;
            $fechaCreacionDateTime = new \DateTime(date('Y-m-d'));
            $sedeOperativaId = $params->sedeOperativaId;
            $sedeOperativa = $em->getRepository('AppBundle:SedeOperativa')->find($sedeOperativaId);

            $em = $this->getDoctrine()->getManager();
        

            if ($factura!=null) {
                $factura->setNumero($numero);
                $factura->setFechaCreacion($fechaCreacionDateTime);
                $factura->setEstado($estado);
                $factura->setSedeOperativa($sedeOperativa);
                

                $em = $this->getDoctrine()->getManager();
                $em->persist($factura);
                $em->flush();

                 $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Registro actualizado con exito", 
                        'data'=> $factura,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El registro no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a factura entity.
     *
     * @Route("/{id}/delete", name="factura_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, Factura $factura)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();

            $factura->setEstado(false);
            $em = $this->getDoctrine()->getManager();
                $em->persist($factura);
                $em->flush();
                $response = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "Registro eliminado con exito", 
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
     * Creates a form to delete a factura entity.
     *
     * @param Factura $factura The factura entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Factura $factura)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('factura_delete', array('id' => $factura->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * busca vehiculos por id.
     *
     * @Route("/show/id", name="factura_id")
     * @Method("POST")
     */
    public function showById(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);


        if ($authCheck == true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            $factura = $em->getRepository('AppBundle:Factura')->findOneBy(
                array('id' => $params->id)
            );

            if ($factura!=null) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Factura", 
                    'data'=> $factura,
            );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Factura no encontrada", 
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
     * busca factura por nvehiculoumero.
     *
     * @Route("/show/factura/vehiculo", name="factura_vehiculo")
     * @Method("POST")
     */
    public function showByVehiculo(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);


        if ($authCheck == true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();


            $facturas = $em->getRepository('AppBundle:Factura')->findBy(
                array('vehiculo' => $params->vehiculo, 'estado'=>'Emitida')
            );

            foreach ($facturas as $key => $factura) {
                $selectFactura[$key] = array(
                    'value' => $factura->getId(),
                    'label' => $factura->getNumero(),
                );
              }

            if ($facturas!=null) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Factura", 
                    'data'=> $selectFactura,
            );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "no hay facturas para el vehiculo", 
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
     * busca vehiculos por id.
     *
     * @Route("/search/numero", name="factura_search_numero")
     * @Method({"GET", "POST"})
     */
    public function searchByNumero(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);


        if ($authCheck == true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            $factura = $em->getRepository('AppBundle:Factura')->findOneBy(
                array('numero' => $params->numeroFactura)
            );

            if ($factura!=null) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Factura encontrada", 
                    'data'=> $factura,
            );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Factura no encontrada", 
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
}
