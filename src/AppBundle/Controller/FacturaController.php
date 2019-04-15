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
        $facturas = $em->getRepository('AppBundle:Factura')->findByEstado('EMITIDA');

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

            $em = $this->getDoctrine()->getManager();

            $factura = new Factura();

            if ($params->factura->vehiculoId) {
                $vehiculo = $em->getRepository('AppBundle:Vehiculo')->find(
                    $params->factura->vehiculoId
                );
                $factura->setVehiculo($vehiculo);
            }

            if ($params->factura->idModulo) {
                $modulo = $em->getRepository('AppBundle:Modulo')->find(
                    $params->factura->idModulo
                );
                $factura->setModulo($modulo);
            }
            
            $ciudadano = $em->getRepository('AppBundle:Ciudadano')->find(
                $params->factura->ciudadanoId
            );

            $fechaCreacion = new \DateTime($params->factura->fechaCreacion); 

            $consecutivo = $em->getRepository('AppBundle:Factura')->getMaximo();
           
            $consecutivo = (empty($consecutivo['maximo']) ? 1 : $consecutivo['maximo']+=1);
            $factura->setConsecutivo($consecutivo);
            
            $factura->setNumero(
                '770'.str_pad($consecutivo, 3, '0', STR_PAD_LEFT).$fechaCreacion->format('Y')
            ); 

            $factura->setEstado('EMITIDA');
            $factura->setFechaCreacion(
                $fechaCreacion
            );
            $factura->setFechaVencimiento(
                new \DateTime($params->factura->fechaCreacion)
            );
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
                
                $tramiteFactura = new TramiteFactura();

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
                        $mflRetefuente->setFactura($factura);
                        $mflRetefuente->setFecha(new \DateTime($params->factura->fechaCreacion));
                        $mflRetefuente->setRetencion($params->retencion);
                        $mflRetefuente->setEstado(true);
                        $em->persist($mflRetefuente);
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
                'message' => "Factura No. ".$factura->getNumero()." creada con exito", 
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
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
            $idApoderado = (isset($params->idApoderado)) ? $params->idApoderado : null;
            $fechaCreacionDateTime = new \DateTime(date('Y-m-d'));
            $sedeOperativaId = $params->sedeOperativaId;
            $sedeOperativa = $em->getRepository('AppBundle:SedeOperativa')->find($sedeOperativaId);

            if ($idApoderado) {
                $apoderado = $em->getRepository('UsuarioBundle:Usuario')->find($params->idApoderado);
                $factura->setApoderado($apoderado->getCiudadano());
            }

            $solicitante = $em->getRepository('AppBundle:Ciudadano')->find($params->idSolicitante);
            $factura->setSolicitante($solicitante);

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
                array('vehiculo' => $params->vehiculo, 'estado'=>'EMITIDA')
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

    /**
     * Creates a new factura entity.
     *
     * @Route("/imprimir/factura", name="imprimir_factura_new")
     * @Method({"GET", "POST"})
     */
    public function ImprimirFacturaAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        $json = $request->get("json",null);
        $params = json_decode($json);

        $em = $this->getDoctrine()->getManager();

        $facturas = $em->getRepository('AppBundle:Factura')->findByEstado(true);
        $consecutivo = count($facturas)."-".date('Y');

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
        $factura->setEstado('EMITIDA');

        $factura->setFechaCreacion(new \DateTime(
            $params->factura->fechaCreacion
        ));

        $factura->setFechaVencimiento(new \DateTime(
            $params->factura->fechaCreacion
        ));

        if ($params->factura->valorBruto) {
            $factura->setValorBruto($params->factura->valorBruto);
        }
        
        //Inserta llaves foraneas
        $factura->setSedeOperativa($sedeOperativa);
        $factura->setCiudadano($ciudadano);
        $tramitesFacturaArray = false;

        $mflRetefuenteArray=[];
        $conceptosArray=[];
        $conceptosTotal=0;
        $tramiteTotal=0;

       
        
        foreach ($params->tramitesValor as $key => $tramiteValor) {
            $tramiteFactura = new TramiteFactura();

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
                    $mflRetefuente->setFactura($factura);
                    $mflRetefuente->setFecha(new \DateTime($params->factura->fechaCreacion));
                    $mflRetefuente->setRetencion($params->retencion);
                    $mflRetefuente->setEstado(true);
                 
                    $mflRetefuenteArray[$key] = array(
                        'vendedorCedula' => $mflRetefuente->getPropietarioVehiculo()->getCiudadano()->getUsuario()->getIdentificacion(),
                        'valor' => $params->retencion, 
                    );
                }
            }

            $conceptosParametroTramite = $em->getRepository('AppBundle:ConceptoParametroTramite')->findBy(
                array('tramitePrecio' => $tramitePrecio->getId(), 'estado'=>true)
            );

            foreach ($conceptosParametroTramite as $key => $conceptoParametroTramite) {
                $conceptosArray[$key]= array(
                    'valor' => $conceptoParametroTramite->getConceptoParametro()->getValor(),
                    'nombre' => $conceptoParametroTramite->getConceptoParametro()->getNombre()
                );
                $conceptosTotal = $conceptosTotal + $conceptoParametroTramite->getConceptoParametro()->getValor();
            }
            
            
            $tramiteFactura->setFactura($factura);
            $tramiteFactura->setTramitePrecio($tramitePrecio);
            $tramiteFactura->setEstado(true);
            $tramiteFactura->setRealizado(false);
            $tramiteFactura->setCantidad(1);
            
            $tramiteTotal = $tramiteTotal + $tramiteFactura->getTramitePrecio()->getValor();
            $tramitesFacturaArray[$key]= array(
                'valor' => $tramiteFactura->getTramitePrecio()->getValor(),
                'nombre' => $tramiteFactura->getTramitePrecio()->getNombre()
            );
        }
        // var_dump($conceptosArray);
        //     die();
       
     
        $html = $this->renderView('@App/factura/pdfFactura.html.twig', array(
            'factura'=>$factura,
            'tramitesFacturaArray'=>$tramitesFacturaArray,
            'mflRetefuenteArray'=>$mflRetefuenteArray,
            'conceptosArray'=>$conceptosArray,
            'conceptosTotal'=>$conceptosTotal,
            'tramiteTotal'=>$tramiteTotal,
        ));

        $nombrePdf = ($this->get('app.pdf.factura')->templateSummary($html,$factura));
        return $helpers->json($nombrePdf);
    }
}
