<?php

namespace AppBundle\Controller;

use AppBundle\Entity\VehiculoRemolque;
use AppBundle\Entity\CfgPlaca;
use AppBundle\Entity\Vehiculo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Vehiculoremolque controller.
 *
 * @Route("vehiculoremolque")
 */
class VehiculoRemolqueController extends Controller
{
    /**
     * Lists all vehiculoRemolque entities.
     *
     * @Route("/", name="vehiculoremolque_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $remolques = $em->getRepository('AppBundle:VehiculoRemolque')->findAll();
        
        $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "listado vehiculos", 
                'data'=> $remolques,
            );
        return $helpers->json($response);
        // return $this->render('vehiculoremolque/index.html.twig', array(
        //     'vehiculoRemolques' => $vehiculoRemolques,
        // ));
    }

    /**
     * Creates a new vehiculoRemolque entity.
     *
     * @Route("/new", name="vehiculoremolque_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("json",null);
            $params = json_decode($json);
            
            $placa = $params->vehiculoPlaca;
            $serie = $params->vehiculoSerie;
            $vin = $params->vehiculoVin;
            $carroceria = $params->vehiculoCarroceriaId;
            $marca = $params->vehiculoMarcaId; 
            $alto = $params->alto;
            $largo = $params->largo;
            $ancho = $params->ancho;
            $numeroEjes = $params->numeroEjes;
            $origenRegistro = $params->origenRegistroId;
            $cargaUtil = $params->cargaUtil;
            $pesoVacio = $params->pesoVacio;
            $referencia = $params->referencia;
            $modelo = $params->vehiculoModelo;
            $numeroFth = $params->numeroFth;
            $rut = $params->rut;
            $condicionIngreso = $params->condicionIngresoId;                
            $clase = $params->vehiculoClaseId;
            
            $cfgPlaca = $em->getRepository('AppBundle:CfgPlaca')->findBy(array('numero' => $placa)); 
            if (!$cfgPlaca) {
                
                $placaNew = new CfgPlaca();
                $placaNew->setNumero($placa);
                $placaNew->setEstado(true);
                $em->persist($placaNew);
                $em->flush();
                
                $carroceriaNew = $em->getRepository('AppBundle:Carroceria')->find($carroceria);
                $marcaNew = $em->getRepository('AppBundle:Marca')->find($marca);
                $origenRegistroNew = $em->getRepository('JHWEBVehiculoBundle:VhloCfgOrigenRegistro')->find($origenRegistro);
                $condicionIngresoNew = $em->getRepository('JHWEBVehiculoBundle:VhloCfgCondicionIngreso')->find($condicionIngreso);
                $claseNew = $em->getRepository('AppBundle:Clase')->find($clase);
                $lineaNew = $em->getRepository('AppBundle:Linea')->findOneByMarca($marca);
                
                $vehiculo = new Vehiculo();
                $vehiculo->setPlaca($placaNew);
                $vehiculo->setSerie($serie);
                $vehiculo->setVin($vin);
                $vehiculo->setCarroceria($carroceriaNew);
                $vehiculo->setLinea($lineaNew);
                $vehiculo->setModelo($modelo);
                $vehiculo->setClase($claseNew);
                $vehiculo->setEstado("Activo");
                $em->persist($vehiculo);
                $em->flush();

                $vehiculoRemolques = new VehiculoRemolque();
                $vehiculoRemolques->setAlto($alto);
                $vehiculoRemolques->setAncho($ancho);
                $vehiculoRemolques->setLargo($largo);
                $vehiculoRemolques->setNumeroEjes($numeroEjes);
                $vehiculoRemolques->setOrigenRegistro($origenRegistroNew);
                $vehiculoRemolques->setCargaUtil($cargaUtil);
                $vehiculoRemolques->setPesoVacio($pesoVacio);
                $vehiculoRemolques->setReferencia($referencia);
                $vehiculoRemolques->setNumeroFth($numeroFth);
                $vehiculoRemolques->setRut($rut);
                $vehiculoRemolques->setCondicionIngreso($condicionIngresoNew);
                $vehiculoRemolques->setVehiculo($vehiculo);
                $em->persist($vehiculoRemolques);
                $em->flush();
                
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                            'msj' => "vehiculo maquinaria creado con exito", 
                        );
                  
                }else{
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'msj' => "la placa ya existe", 
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
     * Finds and displays a vehiculoRemolque entity.
     *
     * @Route("/{id}", name="vehiculoremolque_show")
     * @Method("GET")
     */
    public function showAction(VehiculoRemolque $vehiculoRemolque)
    {
        $deleteForm = $this->createDeleteForm($vehiculoRemolque);

        return $this->render('vehiculoremolque/show.html.twig', array(
            'vehiculoRemolque' => $vehiculoRemolque,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vehiculoRemolque entity.
     *
     * @Route("/edit", name="vehiculoremolque_edit")
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
            
            $serie = $params->vehiculo->serie;
            $vin = $params->vehiculo->vin;
            $carroceria = $params->vehiculoCarroceriaId;
            $marca = $params->vehiculoMarcaId; 
            $alto = $params->alto;
            $largo = $params->largo;
            $ancho = $params->ancho;
            $numeroEjes = $params->numeroEjes;
            $origenRegistro = $params->origenRegistroId;
            $cargaUtil = $params->cargaUtil;
            $pesoVacio = $params->pesoVacio;
            $referencia = $params->referencia;
            $modelo = $params->vehiculo->modelo;
            $numeroFth = $params->numeroFth;
            $rut = $params->rut;
            $condicionIngreso = $params->condicionIngresoId;                
            $clase = $params->vehiculoClaseId;
            $vehiculo = $params->vehiculo->id;
            
            $vehiculoRemolques = $em->getRepository("AppBundle:VehiculoRemolque")->find($params->id);
           
            if ($vehiculoRemolques) {
                
                $carroceriaNew = $em->getRepository('AppBundle:Carroceria')->find($carroceria);
                $marcaNew = $em->getRepository('AppBundle:Marca')->find($marca);
                $origenRegistroNew = $em->getRepository('AppBundle:CfgOrigenRegistro')->find($origenRegistro);
                $condicionIngresoNew = $em->getRepository('AppBundle:CondicionIngreso')->find($condicionIngreso);
                $claseNew = $em->getRepository('AppBundle:Clase')->find($clase);
                $lineaNew = $em->getRepository('AppBundle:Linea')->findOneByMarca($marca);
                $vehiculoNew = $em->getRepository('AppBundle:Vehiculo')->find($vehiculo);
                
                $vehiculoRemolques->setAlto($alto);
                $vehiculoRemolques->setAncho($ancho);
                $vehiculoRemolques->setLargo($largo);
                $vehiculoRemolques->setNumeroEjes($numeroEjes);
                $vehiculoRemolques->setOrigenRegistro($origenRegistroNew);
                $vehiculoRemolques->setCargaUtil($cargaUtil);
                $vehiculoRemolques->setPesoVacio($pesoVacio);
                $vehiculoRemolques->setReferencia($referencia);
                $vehiculoRemolques->setNumeroFth($numeroFth);
                $vehiculoRemolques->setRut($rut);
                $vehiculoRemolques->setCondicionIngreso($condicionIngresoNew);
                $vehiculoRemolques->setVehiculo($vehiculoNew);
                    $em->flush();
                    
                    $vehiculoNew = $vehiculoRemolques->getVehiculo();
                    $vehiculoNew->setVin($vin);
                    $vehiculoNew->setCarroceria($carroceriaNew);
                    $vehiculoNew->setLinea($lineaNew);
                    $vehiculoNew->setModelo($modelo);
                    $vehiculoNew->setClase($claseNew);
                    $vehiculoNew->setEstado("Activo");
                    $em->flush();
                    
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Maquinaria editada con exito", 
                    );
    
                }else{
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'msj' => "La maquina no se encuentra en la base de datos", 
                    );
                }
            }else{
                $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'msj' => "Autorizacion no valida para editar banco", 
                    );
            }
    
            return $helpers->json($response);
    
    }

    /**
     * Deletes a vehiculoRemolque entity.
     *
     * @Route("/{id}/delete", name="vehiculoremolque_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        
        if ($authCheck==true) {

            $em = $this->getDoctrine()->getManager();
            $json = $request->get("json",null);
            $params = json_decode($json);
            

            $registroRemolque = $em->getRepository('AppBundle:VehiculoRemolque')->find($params);
            $vehiculoId = $registroRemolque->getVehiculo();
            $vehiculo = $em->getRepository('AppBundle:Vehiculo')->find($vehiculoId);

                $vehiculo->setEstado(0);
                $em = $this->getDoctrine()->getManager();
                $em->persist($vehiculo);
                $em->flush();
            $response = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "empresa eliminado con exito", 
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
     * Displays a form to edit an existing VehiculoRemolque entity.
     *
     * @Route("/transformacion", name="vehiculo_transformacion")
     * @Method({"GET", "POST"})
     */
    public function transformacionVehiculoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("json",null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();

            $vehiculo = $em->getRepository('AppBundle:Vehiculo')->find($params->idVehiculo);

            $vehiculoRemolque = $em->getRepository("AppBundle:VehiculoRemolque")->findOneByVehiculo(
                $vehiculo->getId()
            );
            
            if ($vehiculoRemolque) {
                $numeroEjes = $vehiculoRemolque->getNumeroEjes();
                if($numeroEjes == $params->nuevoNumeroEjes){
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'msj' => "El vehiculo tiene el mismo número de ejes", 
                    );
                }else{
                    $vehiculoRemolque->setVehiculo($vehiculo);

                    $condicionIngreso = $em->getRepository("AppBundle:CondicionIngreso")->find(
                        $vehiculoRemolque->getCondicionIngreso()->getId()
                    );
                    $vehiculoRemolque->setCondicionIngreso($condicionIngreso);

                    $origenRegistro = $em->getRepository("AppBundle:CfgOrigenRegistro")->find(
                        $vehiculoRemolque->getOrigenRegistro()->getId()
                    );
                    $vehiculoRemolque->setOrigenRegistro($origenRegistro);
                    $vehiculoRemolque->setNumeroEjes($params->nuevoNumeroEjes);
                    $vehiculoRemolque->setNumeroFth($params->numeroFTH);
                    $vehiculoRemolque->setPesoVacio($params->pesoVacio);
                    $vehiculoRemolque->setCargaUtil($params->cargaUtil);
                    $vehiculoRemolque->setReferencia($vehiculoRemolque->getReferencia());
                    $vehiculoRemolque->setNumeroFth($vehiculoRemolque->getNumeroFth());
                    $vehiculoRemolque->setRut($vehiculoRemolque->getRut());
                    $vehiculoRemolque->setAlto($vehiculoRemolque->getAlto());
                    $vehiculoRemolque->setLargo($vehiculoRemolque->getLargo());
                    $vehiculoRemolque->setAncho($vehiculoRemolque->getAncho());
                    $em->flush();
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => "Registro realizado con exito", 
                    );
                }

            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El vehiculo no es un remolque o semiremolque", 
                );
            }
        
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorizacion no valida para editar vehiculo", 
                );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a vehiculoRemolque entity.
     *
     * @param VehiculoRemolque $vehiculoRemolque The vehiculoRemolque entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VehiculoRemolque $vehiculoRemolque)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vehiculoremolque_delete', array('id' => $vehiculoRemolque->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
