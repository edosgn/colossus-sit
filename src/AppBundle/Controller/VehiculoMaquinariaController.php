<?php

namespace AppBundle\Controller;

use AppBundle\Entity\VehiculoMaquinaria;
use AppBundle\Entity\CfgPlaca;
use AppBundle\Entity\Vehiculo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Vehiculomaquinaria controller.
 *
 * @Route("vehiculomaquinaria")
 */
class VehiculoMaquinariaController extends Controller
{
    /**
     * Lists all vehiculoMaquinaria entities.
     *
     * @Route("/", name="vehiculomaquinaria_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $vehiculos = $em->getRepository('AppBundle:VehiculoMaquinaria')->findAll();
        $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado vehiculos", 
                    'data'=> $vehiculos,
            );
         
        return $helpers->json($response);
    }

    /**
     * Creates a new vehiculoMaquinaria entity.
     *
     * @Route("/new", name="vehiculomaquinaria_new")
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
            $chasis = $params->vehiculoChasis;
            $motor = $params->vehiculoMotor;
            $condicion = $params->condicionSelected;                
            $color = $params->vehiculoColorId;
            $tipoVehiculo = $params->tipoVehiculoId;
            $clase = $params->vehiculoClaseId;
            $marca = $params->vehiculoMarcasId; 
            $linea = $params->vehiculoLineaId; 
            $modelo = $params->vehiculoModelo;
            $carroceria = $params->vehiculoCarroceriaId;
            $pesoBruto = $params->pesoBruto;
            $cargaUtilMaxima = $params->cargaUtilMaxima;
            $rodaje = $params->rodajeSelected;
            $numeroEjes = $params->numeroEjes;
            $numeroLlantas = $params->numeroLlantas;
            $tipoCabina = $params->tipoCabinaSelected;
            $altoTotal = $params->altoTotal;
            $largoTotal = $params->largoTotal;
            $anchoTotal = $params->anchoTotal;
            $combustible = $params->vehiculoCombustibleId;
            $origenVehiculo = $params->cfgOrigenVehiculoId;
            $subpartidaArancelaria = $params->subpartidaArancelaria;
            
            $fechaIngreso = (isset($params->fechaIngreso)) ? $params->fechaIngreso : null;
            $fechaIngreso = new \DateTime($fechaIngreso);
            
            // var_dump($params);
            // die();
            
            
            $cfgPlaca = $em->getRepository('AppBundle:CfgPlaca')->findBy(array('numero' => $placa)); 
            if (!$cfgPlaca) {
                
                $placaNew = new CfgPlaca();
                $placaNew->setNumero($placa);
                $placaNew->setEstado(true);
                $em->persist($placaNew);
                $em->flush();
                
                $colorNew = $em->getRepository('AppBundle:Color')->find($color);                    
                $tipoVehiculoNew = $em->getRepository('AppBundle:TipoVehiculo')->find($tipoVehiculo);
                $claseNew = $em->getRepository('AppBundle:Clase')->find($clase);
                $marcaNew = $em->getRepository('AppBundle:Marca')->find($marca);
                $lineaNew = $em->getRepository('AppBundle:Linea')->find($linea);
                $carroceriaNew = $em->getRepository('AppBundle:Carroceria')->find($carroceria);
                $combustibleNew = $em->getRepository('AppBundle:Combustible')->find($combustible);
                $origenVehiculoNew = $em->getRepository('AppBundle:CfgOrigenRegistro')->find($origenVehiculo);
                
                $vehiculo = new Vehiculo();
                $vehiculo->setPlaca($placaNew);
                $vehiculo->setSerie($serie);
                $vehiculo->setChasis($chasis);
                $vehiculo->setMotor($motor);
                $vehiculo->setColor($colorNew);
                $vehiculo->setClase($claseNew);
                $vehiculo->setLinea($lineaNew);
                $vehiculo->setModelo($modelo);
                $vehiculo->setCarroceria($carroceriaNew);
                $vehiculo->setCombustible($combustibleNew);
                $vehiculo->setEstado("Activo");
                $em->persist($vehiculo);
                $em->flush();
                $VehiculoMaquinaria = new VehiculoMaquinaria();
                $VehiculoMaquinaria->setPesoBrutoVehicular($pesoBruto);
                $VehiculoMaquinaria->setCargarUtilMaxima($cargaUtilMaxima);
                $VehiculoMaquinaria->setRodaje($rodaje);
                $VehiculoMaquinaria->setNumeroEjes($numeroEjes);
                $VehiculoMaquinaria->setNumeroLlantas($numeroLlantas);
                $VehiculoMaquinaria->setTipoCabina($tipoCabina);
                $VehiculoMaquinaria->setAltoTotal($altoTotal);
                $VehiculoMaquinaria->setAnchoTotal($anchoTotal);
                $VehiculoMaquinaria->setLargoTotal($largoTotal);
                $VehiculoMaquinaria->setSubpartidaArancelaria($subpartidaArancelaria);
                $VehiculoMaquinaria->setTipoVehiculo($tipoVehiculoNew);
                $VehiculoMaquinaria->setCfgOrigenRegistro($origenVehiculoNew);
                $VehiculoMaquinaria->setCondicionIngreso($condicion);
                $VehiculoMaquinaria->setFechaIngreso($fechaIngreso);
                $VehiculoMaquinaria->setVehiculo($vehiculo);
                $em->persist($VehiculoMaquinaria);
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
     * Finds and displays a vehiculoMaquinaria entity.
     *
     * @Route("/{id}", name="vehiculomaquinaria_show")
     * @Method("GET")
     */
    public function showAction(VehiculoMaquinaria $vehiculoMaquinaria)
    {
        $deleteForm = $this->createDeleteForm($vehiculoMaquinaria);

        return $this->render('vehiculomaquinaria/show.html.twig', array(
            'vehiculoMaquinaria' => $vehiculoMaquinaria,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vehiculoMaquinaria entity.
     *
     * @Route("/{id}/edit", name="vehiculomaquinaria_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, VehiculoMaquinaria $vehiculoMaquinaria)
    {
        $deleteForm = $this->createDeleteForm($vehiculoMaquinaria);
        $editForm = $this->createForm('AppBundle\Form\VehiculoMaquinariaType', $vehiculoMaquinaria);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vehiculomaquinaria_edit', array('id' => $vehiculoMaquinaria->getId()));
        }

        return $this->render('vehiculomaquinaria/edit.html.twig', array(
            'vehiculoMaquinaria' => $vehiculoMaquinaria,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a vehiculoMaquinaria entity.
     *
     * @Route("/{id}", name="vehiculomaquinaria_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, VehiculoMaquinaria $vehiculoMaquinaria)
    {
        $form = $this->createDeleteForm($vehiculoMaquinaria);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vehiculoMaquinaria);
            $em->flush();
        }

        return $this->redirectToRoute('vehiculomaquinaria_index');
    }

    /**
     * Creates a form to delete a vehiculoMaquinaria entity.
     *
     * @param VehiculoMaquinaria $vehiculoMaquinaria The vehiculoMaquinaria entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VehiculoMaquinaria $vehiculoMaquinaria)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vehiculomaquinaria_delete', array('id' => $vehiculoMaquinaria->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
