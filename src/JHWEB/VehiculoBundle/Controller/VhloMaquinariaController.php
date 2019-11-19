<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloMaquinaria;
use JHWEB\VehiculoBundle\Entity\VhloCfgPlaca;
use JHWEB\VehiculoBundle\Entity\VhloVehiculo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlomaquinarium controller.
 *
 * @Route("vhlomaquinaria")
 */
class VhloMaquinariaController extends Controller
{
    /**
     * Lists all vhloMaquinaria entities.
     *
     * @Route("/", name="vhlomaquinaria_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $maquinarias = $em->getRepository('JHWEBVehiculoBundle:VhloMaquinaria')->findAll();

        $response['data'] = array();

        if ($maquinarias) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($maquinarias)." registros encontrados", 
                'data'=> $maquinarias,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new vhloMaquinaria entity.
     *
     * @Route("/new", name="vhlomaquinaria_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $cfgPlaca = $em->getRepository('JHWEBVehiculoBundle:VhloCfgPlaca')->findOneBy(array('numero' => $params->placa));

            $organismoTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find($params->idOrganismoTransito);
            
            if (!$cfgPlaca) {
                if (isset($params->placa) && $params->placa) {
                    $placa = new VhloCfgPlaca();
                    $placa->setNumero($params->placa);

                    $cfgTipoVehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloCfgTipoVehiculo')->findOneByModulo(3);
                    $placa->setTipoVehiculo($cfgTipoVehiculo);

                    $placa->setOrganismoTransito($organismoTransito);
                    $placa->setEstado('ASIGNADA');
                    $em->persist($placa);
                    
                    $vehiculo->setPlaca($placa);
                }
                
                $vehiculo = new VhloVehiculo();

                $vehiculo->setOrganismoTransito($organismoTransito);
                
                $vehiculo->setNumeroFactura($params->numeroFactura);
                $vehiculo->setFechaFactura(new \DateTime($params->fechaFactura));
                
                if($params->valor) {
                    $vehiculo->setValor($params->valor);
                }

                $vehiculo->setSerie($params->serie);
                $vehiculo->setVin($params->vin);
                $vehiculo->setChasis($params->chasis);
                $vehiculo->setMotor($params->motor);
                $vehiculo->setModelo($params->modelo);
                $vehiculo->setModelo($params->numeroEjes);
                
                $color = $em->getRepository('JHWEBVehiculoBundle:VhloCfgColor')->find(
                    $params->idColor
                );
                $vehiculo->setColor($color);

                 if($params->idClaseMaquinaria) {
                    $claseMaquinaria = $em->getRepository('JHWEBVehiculoBundle:VhloCfgClase')->find(
                        $params->idClaseMaquinaria
                    );
                    $vehiculo->setClase($claseMaquinaria);
                }

                if ($params->idLinea) {
                    $linea = $em->getRepository('JHWEBVehiculoBundle:VhloCfgLinea')->find(
                        $params->idLinea
                    );
                    $vehiculo->setLinea($linea);
                }

                $carroceria = $em->getRepository('JHWEBVehiculoBundle:VhloCfgCarroceria')->find($params->idCarroceria);
                $vehiculo->setCarroceria($carroceria);

                $combustible = $em->getRepository('JHWEBVehiculoBundle:VhloCfgCombustible')->find($params->idCombustible);
                $vehiculo->setCombustible($combustible);

                $vehiculo->setTipoMatricula($params->tipoMatricula);

                $vehiculo->setActivo(true);

                $em->persist($vehiculo);
                $em->flush();

                $vehiculoMaquinaria = new VhloMaquinaria();

                $vehiculoMaquinaria->setFechaIngreso(
                    new \DateTime($params->fechaIngreso)
                );
                $vehiculoMaquinaria->setPeso($params->peso);
                $vehiculoMaquinaria->setCargaUtilMaxima(
                    $params->cargaUtilMaxima
                );
                
                $vehiculoMaquinaria->setNumeroLlantas(
                    $params->numeroLlantas
                );
                $vehiculoMaquinaria->setAlto($params->alto);
                $vehiculoMaquinaria->setAncho($params->ancho);
                $vehiculoMaquinaria->setLargo($params->largo);
                $vehiculoMaquinaria->setNumeroActivacionGps(
                    $params->numeroActivacionGps
                );
                $vehiculoMaquinaria->setTipoDispositivo(
                    $params->tipoDispositivo
                );
                $vehiculoMaquinaria->setNumeroImportacion(
                    $params->numeroImportacion
                );

                if($params->idTipoMaquinaria) {
                    $tipoMaquinaria = $em->getRepository('JHWEBVehiculoBundle:VhloCfgTipoMaquinaria')->find(
                    $params->idTipoMaquinaria);

                    $vehiculoMaquinaria->setTipoMaquinaria($tipoMaquinaria);
                }
                
                $origenRegistro = $em->getRepository('JHWEBVehiculoBundle:VhloCfgOrigenRegistro')->find($params->idOrigenRegistro);
                $vehiculoMaquinaria->setOrigenRegistro($origenRegistro);

                $empresaGps = $em->getRepository('JHWEBVehiculoBundle:VhloCfgEmpresaGps')->find($params->idEmpresaGps);
                $vehiculoMaquinaria->setEmpresaGps($empresaGps);

                $tipoRodaje = $em->getRepository('JHWEBVehiculoBundle:VhloCfgTipoRodaje')->find($params->idTipoRodaje);
                $vehiculoMaquinaria->setTipoRodaje($tipoRodaje);
                          
                $tipoCabina = $em->getRepository('JHWEBVehiculoBundle:VhloCfgTipoCabina')->find($params->idTipoCabina);
                $vehiculoMaquinaria->setTipoCabina($tipoCabina);

                $subpartidaArancelaria = $em->getRepository('JHWEBVehiculoBundle:VhloCfgSubpartidaArancelaria')->find($params->idSubpartidaArancelaria);
                $vehiculoMaquinaria->setSubpartidaArancelaria($subpartidaArancelaria);

                $condicionIngreso = $em->getRepository('JHWEBVehiculoBundle:VhloCfgCondicionIngreso')->find($params->idCondicionIngreso);
                $vehiculoMaquinaria->setCondicionIngreso($condicionIngreso);

                $vehiculoMaquinaria->setVehiculo($vehiculo);

                $em->persist($vehiculoMaquinaria);
                $em->flush();
                
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro creado con exito",
                    'data' => $vehiculoMaquinaria
                );
                
            } else {
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El número de placa ya existe",
                );
            }
        } else {
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida",
            );
        }

        return $helpers->json($response);
    }

    /**
     * Finds and displays a vhloMaquinaria entity.
     *
     * @Route("/{id}", name="vhlomaquinaria_show")
     * @Method("GET")
     */
    public function showAction(VhloMaquinaria $vhloMaquinaria)
    {
        $deleteForm = $this->createDeleteForm($vhloMaquinaria);

        return $this->render('vhlomaquinaria/show.html.twig', array(
            'vhloMaquinaria' => $vhloMaquinaria,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vhloMaquinaria entity.
     *
     * @Route("/edit", name="vhlomaquinaria_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            
            $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->find($params->vehiculo->id);
            $vehiculoMaquinaria = $em->getRepository('JHWEBVehiculoBundle:VhloMaquinaria')->find($params->id);
            
            $vehiculo->setNumeroFactura($params->vehiculo->numeroFactura);
            $vehiculo->setValor($params->vehiculo->valor);
            $vehiculo->setSerie($params->vehiculo->serie);
            $vehiculo->setVin($params->vehiculo->vin);
            $vehiculo->setChasis($params->vehiculo->chasis);
            $vehiculo->setMotor($params->vehiculo->motor);
            
            if($params->idCondicionIngreso) {
                $condicionIngreso = $em->getRepository('JHWEBVehiculoBundle:VhloCfgCondicionIngreso')->find($params->idCondicionIngreso);
                $vehiculoMaquinaria->setCondicionIngreso($condicionIngreso);
            }
            
            $vehiculoMaquinaria->setFechaIngreso(new \Datetime($params->fechaIngreso));
            

            if($params->idColor) {
                $color = $em->getRepository('JHWEBVehiculoBundle:VhloCfgColor')->find($params->idColor);
                $vehiculo->setColor($color);
            }
            
            if($params->idTipoMaquinaria) {
                $tipoMaquinaria = $em->getRepository('JHWEBVehiculoBundle:VhloCfgTipoMaquinaria')->find($params->idTipoMaquinaria);
                $vehiculoMaquinaria->setTipoMaquinaria($tipoMaquinaria);
            }
            
            if($params->idClaseMaquinaria) {
                $clase = $em->getRepository('JHWEBVehiculoBundle:VhloCfgClase')->find($params->idClaseMaquinaria);
                $vehiculo->setClase($clase);
            }
            
            if($params->idLinea) {
                $linea = $em->getRepository('JHWEBVehiculoBundle:VhloCfgLinea')->findOneBy(
                    array(
                        'marca' => $params->idMarca,
                        'activo' => true
                    )
                );

                $vehiculo->setLinea($linea);
            }

            $vehiculo->setModelo($params->vehiculo->modelo);

            if($params->idCarroceria) {
                $carroceria = $em->getRepository('JHWEBVehiculoBundle:VhloCfgCarroceria')->find($params->idCarroceria[0]);
                $vehiculo->setCarroceria($carroceria);
            }
            
            $vehiculoMaquinaria->setPeso($params->peso);
            $vehiculoMaquinaria->setCargaUtilMaxima($params->cargaUtilMaxima);
            
            if($params->idTipoRodaje) {
                $tipoRodaje = $em->getRepository('JHWEBVehiculoBundle:VhloCfgTipoRodaje')->find($params->idTipoRodaje);
                $vehiculoMaquinaria->setTipoRodaje($tipoRodaje);
            }
            
            $vehiculo->setNumeroEjes($params->vehiculo->numeroEjes);
            
            $vehiculoMaquinaria->setNumeroLlantas($params->numeroLlantas);
            
            if($params->idTipoCabina) {
                $tipoCabina = $em->getRepository('JHWEBVehiculoBundle:VhloCfgTipoCabina')->find($params->idTipoCabina);
                $vehiculoMaquinaria->setTipoCabina($tipoCabina);
            }
            
            $vehiculoMaquinaria->setAlto($params->alto);
            $vehiculoMaquinaria->setLargo($params->largo);
            $vehiculoMaquinaria->setAncho($params->ancho);
            
            if($params->idCombustible) {
                $combustible = $em->getRepository('JHWEBVehiculoBundle:VhloCfgCombustible')->find($params->idCombustible);
                $vehiculo->setCombustible($combustible);
            }
            
            if($params->idOrigenRegistro) {
                $origenRegistro = $em->getRepository('JHWEBVehiculoBundle:VhloCfgOrigenRegistro')->find($params->idOrigenRegistro);
                $vehiculoMaquinaria->setOrigenRegistro($origenRegistro);
            }
            
            if($params->idSubpartidaArancelaria) {
                $subpartidaArancelaria = $em->getRepository('JHWEBVehiculoBundle:VhloCfgSubpartidaArancelaria')->find($params->idSubpartidaArancelaria);
                $vehiculoMaquinaria->setSubpartidaArancelaria($subpartidaArancelaria);
            }
            
            if($params->idEmpresaGps) {
                $empresaGps = $em->getRepository('JHWEBVehiculoBundle:VhloCfgEmpresaGps')->find($params->idEmpresaGps);
                $vehiculoMaquinaria->setEmpresaGps($empresaGps);
            }

            $vehiculoMaquinaria->setNumeroActivacionGps($params->numeroActivacionGps);
            $vehiculoMaquinaria->setTipoDispositivo($params->tipoDispositivo);
            $vehiculoMaquinaria->setNumeroImportacion($params->numeroImportacion);


            $em->persist($vehiculo);
            $em->persist($vehiculoMaquinaria);

            $em->flush();

            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Registro actualizado con éxito",
            );

        } else {
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida",
            );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a vhloMaquinaria entity.
     *
     * @Route("/{id}", name="vhlomaquinaria_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, VhloMaquinaria $vhloMaquinaria)
    {
        $form = $this->createDeleteForm($vhloMaquinaria);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vhloMaquinaria);
            $em->flush();
        }

        return $this->redirectToRoute('vhlomaquinaria_index');
    }

    /**
     * Creates a form to delete a vhloMaquinaria entity.
     *
     * @param VhloMaquinaria $vhloMaquinaria The vhloMaquinaria entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloMaquinaria $vhloMaquinaria)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhlomaquinaria_delete', array('id' => $vhloMaquinaria->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Busca un vehiculos segun los filtros .
     *
     * @Route("/search/filter", name="vhlomaquinaria_search_filter")
     * @Method({"GET", "POST"})
     */
    public function searchByFilterAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloMaquinaria')->getByFilter($params->filtro);

            if ($vehiculo) {
                $maquinaria = $em->getRepository('JHWEBVehiculoBundle:VhloMaquinaria')->findOneBy(
                    array(
                        'vehiculo' => $vehiculo->getId(),
                    )
                );

                if($maquinaria) {
                    $response = array(
                        'title' => 'Perfecto!',
                        'status' => 'success',
                        'code' => 200,
                        'message' => 'Registro encontrado.', 
                        'data'=> $maquinaria
                    );
                }
            }else{
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Registro no encontrado en base de datos.', 
                );
            }            
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorización no válida', 
            );
        }

        return $helpers->json($response);
    }
}
