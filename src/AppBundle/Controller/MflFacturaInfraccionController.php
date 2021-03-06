<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MflFacturaInfraccion;
use AppBundle\Entity\MflRetefuente;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * MflFacturaInfraccion controller.
 *
 * @Route("facturainfraccion")
 */
class MflFacturaInfraccionController extends Controller
{
    /**
     * Lists all factura entities.
     *
     * @Route("/", name="facturaInfraccion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $facturas = $em->getRepository('AppBundle:MflFacturaInfraccion')->findByEstado('Emitida');

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
     * @Route("/new", name="facturaInfraccion_new")
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
                $facturas = $em->getRepository('AppBundle:MflFacturaInfraccion')->findByEstado(true);
                $consecutivo = count($facturas)."-".date('y');

                $factura = new MflFacturaInfraccion();

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
                $sedeOperativa = $em->getRepository('AppBundle:SedeOperativa')->find(
                    $params->factura->sedeOperativaId
                );
                $factura->setSedeOperativa($sedeOperativa);
                $factura->setCiudadano($ciudadano);
                
                $em->persist($factura);
                $em->flush();

                foreach ($params->tramitesValor as $key => $tramiteValor) {
                    $tramiteMflFacturaInfraccion = new TramiteMflFacturaInfraccion();

                    $tramitePrecio = $em->getRepository('AppBundle:TramitePrecio')->find(
                        $tramiteValor->idTramitePrecio
                    );

                    if($tramitePrecio->getTramite()->getId() == 6){
                        foreach ($params->propietarios as $key => $propietarioRetefuenteId) {
                        
                            $mflRetefuente = new MflRetefuente();

                            $mflRetefuente->setVehiculo($vehiculo);
                            
                            $propietarioVehiculo = $em->getRepository('AppBundle:PropietarioVehiculo')->find(
                                $propietarioRetefuenteId
                            );
                            $mflRetefuente->setPropietarioVehiculo($propietarioVehiculo);

                            if (isset($params->valorVehiculoId)) {
                                $valorVehiculo = $em->getRepository('AppBundle:CfgValorVehiculo')->find(
                                    $params->valorVehiculoId
                                );
                                $mflRetefuente->setValorVehiculo($valorVehiculo);
                            }
                            $mflRetefuente->setMflFacturaInfraccion($factura);
                            $mflRetefuente->setFecha(new \DateTime($params->factura->fechaCreacion));
                            $mflRetefuente->setRetencion($params->retencion);
                            $mflRetefuente->setEstado(true);
                            $em->persist($mflRetefuente);
                            $em->flush();
                        }
                    }

                    $tramiteMflFacturaInfraccion->setMflFacturaInfraccion($factura);
                    $tramiteMflFacturaInfraccion->setTramitePrecio($tramitePrecio);
                    $tramiteMflFacturaInfraccion->setEstado(true);
                    $tramiteMflFacturaInfraccion->setRealizado(false);
                    $tramiteMflFacturaInfraccion->setCantidad(1);
                    $em->persist($tramiteMflFacturaInfraccion);
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
     * @Route("/{id}/show", name="facturaInfraccion_show")
     * @Method("GET")
     */
    public function showAction(MflFacturaInfraccion $factura, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $factura = $em->getRepository('AppBundle:MflFacturaInfraccion')->find($id);
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
     * @Route("/edit", name="facturaInfraccion_edit")
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
            $factura = $em->getRepository("AppBundle:MflFacturaInfraccion")->find($params->id);

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
     * @Route("/{id}/delete", name="facturaInfraccion_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, MflFacturaInfraccion $factura)
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
     * @param MflFacturaInfraccion $factura The factura entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MflFacturaInfraccion $factura)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('facturaInfraccion_delete', array('id' => $factura->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * busca vehiculos por id.
     *
     * @Route("/show/id", name="facturaInfraccion_id")
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
            $factura = $em->getRepository('AppBundle:MflFacturaInfraccion')->findOneBy(
                array('id' => $params->id)
            );

            if ($factura!=null) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "MflFacturaInfraccion", 
                    'data'=> $factura,
            );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "MflFacturaInfraccion no encontrada", 
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
     * @Route("/show/factura/vehiculo", name="facturaInfraccion_vehiculo")
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


            $facturas = $em->getRepository('AppBundle:MflFacturaInfraccion')->findBy(
                array('vehiculo' => $params->vehiculo, 'estado'=>'Emitida')
            );

            foreach ($facturas as $key => $factura) {
                $selectMflFacturaInfraccion[$key] = array(
                    'value' => $factura->getId(),
                    'label' => $factura->getNumero(),
                );
              }

            if ($facturas!=null) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "MflFacturaInfraccion", 
                    'data'=> $selectMflFacturaInfraccion,
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
     * @Route("/search/numero", name="facturaInfraccion_search_numero")
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
            $factura = $em->getRepository('AppBundle:MflFacturaInfraccion')->findOneBy(
                array('numero' => $params->numeroMflFacturaInfraccion)
            );

            if ($factura!=null) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "MflFacturaInfraccion encontrada", 
                    'data'=> $factura,
            );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "MflFacturaInfraccion no encontrada", 
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
     * Creates a new factura entity.
     *
     * @Route("/imprimir/factura", name="imprimir_facturaInfraccion_new")
     * @Method({"GET", "POST"})
     */
    public function ImprimirMflFacturaInfraccionAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash); 
        $mflRetefuenteArray=[];

        $json = $request->get("json",null);
        $params = json_decode($json);
        $em = $this->getDoctrine()->getManager();
        $facturas = $em->getRepository('AppBundle:MflFacturaInfraccion')->findByEstado(true);
        $consecutivo = count($facturas)."-".date('y');

        $sedeOperativa = $em->getRepository('AppBundle:SedeOperativa')->find(
            $params->factura->sedeOperativaId
        );
        $factura = new MflFacturaInfraccion();
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
        $tramitesMflFacturaInfraccionArray = false;

      
        
        foreach ($params->tramitesValor as $key => $tramiteValor) {
            $tramiteMflFacturaInfraccion = new TramiteMflFacturaInfraccion();

            $tramitePrecio = $em->getRepository('AppBundle:TramitePrecio')->find(
                $tramiteValor->idTramitePrecio
            );

            if($tramitePrecio->getTramite()->getId() == 6){
                foreach ($params->propietarios as $key => $propietarioRetefuenteId) {
                
                    $mflRetefuente = new MflRetefuente();

                    $mflRetefuente->setVehiculo($vehiculo);
                    
                    $propietarioVehiculo = $em->getRepository('AppBundle:PropietarioVehiculo')->find(
                        $propietarioRetefuenteId
                    );
                    $mflRetefuente->setPropietarioVehiculo($propietarioVehiculo);

                    if (isset($params->valorVehiculoId)) {
                        $valorVehiculo = $em->getRepository('AppBundle:CfgValorVehiculo')->find(
                            $params->valorVehiculoId
                        );
                        $mflRetefuente->setValorVehiculo($valorVehiculo);
                    }
                    $mflRetefuente->setMflFacturaInfraccion($factura);
                    $mflRetefuente->setFecha(new \DateTime($params->factura->fechaCreacion));
                    $mflRetefuente->setRetencion($params->retencion);
                    $mflRetefuente->setEstado(true);
                 
                    $mflRetefuenteArray[$key] = array(
                        'vendedorCedula' => $mflRetefuente->getPropietarioVehiculo()->getCiudadano()->getUsuario()->getIdentificacion(),
                        'valor' => $params->retencion, 
                    );
                }
            }

            $tramiteMflFacturaInfraccion->setMflFacturaInfraccion($factura);
            $tramiteMflFacturaInfraccion->setTramitePrecio($tramitePrecio);
            $tramiteMflFacturaInfraccion->setEstado(true);
            $tramiteMflFacturaInfraccion->setRealizado(false);
            $tramiteMflFacturaInfraccion->setCantidad(1);

            $tramitesMflFacturaInfraccionArray[]= array(
                $tramiteMflFacturaInfraccion
            );
        }
        
     
        $html = $this->renderView('@App/factura/pdfMflFacturaInfraccion.html.twig', array(
            'factura'=>$factura,
            'tramitesMflFacturaInfraccionArray'=>$tramitesMflFacturaInfraccionArray,
            'mflRetefuenteArray'=>$mflRetefuenteArray,
        ));

        $nombrePdf = ($this->get('app.pdf.factura')->templateSummary($html,$factura));
        return $helpers->json($nombrePdf);
    }
}
