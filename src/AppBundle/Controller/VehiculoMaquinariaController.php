<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CfgPlaca;
use AppBundle\Entity\Vehiculo;
use AppBundle\Entity\VehiculoMaquinaria;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;use Symfony\Component\HttpFoundation\Request;

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

        $vehiculos = $em->getRepository('AppBundle:VehiculoMaquinaria')->getVehiculoCampo();
        $response = array(
            'status' => 'success',
            'code' => 200,
            'msj' => "listado vehiculos",
            'data' => $vehiculos,
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
        if ($authCheck == true) {
            $json = $request->get("json", null);
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
            $marca = $params->vehiculoMarcaId;
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
                $vehiculo->setVin($vin);
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

            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "la placa ya existe",
                );
            }
        } else {
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
     * @Route("/edit", name="vehiculomaquinaria_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);

            $serieEdit = $params->vehiculo->serie;
            $vinEdit = $params->vehiculo->vin;
            $chasisEdit = $params->vehiculo->chasis;
            $motorEdit = $params->vehiculo->motor;
            $condicionEdit = $params->condicionIngreso;
            $colorEdit = $params->vehiculoColorId;
            $tipoVehiculoEdit = $params->tipoVehiculoId;
            $claseEdit = $params->vehiculoClaseId;
            $marcaEdit = $params->vehiculoMarcaId;
            $lineaEdit = $params->vehiculoLineaId;
            $modeloEdit = $params->vehiculo->modelo;
            $carroceriaEdit = $params->vehiculoCarroceriaId;
            $pesoBrutoEdit = $params->pesoBrutoVehicular;
            $cargaUtilMaximaEdit = $params->cargarUtilMaxima;
            $rodajeEdit = $params->rodaje;
            $numeroEjesEdit = $params->numeroEjes;
            $numeroLlantasEdit = $params->numeroLlantas;
            $tipoCabinaEdit = $params->tipoCabina;
            $altoTotalEdit = $params->altoTotal;
            $largoTotalEdit = $params->largoTotal;
            $anchoTotalEdit = $params->anchoTotal;
            $combustibleEdit = $params->vehiculoCombustibleId;
            $origenVehiculoEdit = $params->cfgOrigenVehiculoId;
            $subpartidaArancelariaEdit = $params->subpartidaArancelaria;
            $vehiculoId = $params->vehiculo->id;

            $registroMaquinaria = $em->getRepository("AppBundle:VehiculoMaquinaria")->find($params->id);

            if ($registroMaquinaria) {

                $fechaIngreso = (isset($params->fechaIngreso)) ? $params->fechaIngreso : null;
                $fechaIngresoEdit = new \DateTime($fechaIngreso);

                $colorNew = $em->getRepository('AppBundle:Color')->find($colorEdit);

                $tipoVehiculoNew = $em->getRepository('AppBundle:TipoVehiculo')->find($tipoVehiculoEdit);
                $claseNew = $em->getRepository('AppBundle:Clase')->find($claseEdit);
                $vehiculoNew = $em->getRepository('AppBundle:Vehiculo')->find($vehiculoId);
                $marcaNew = $em->getRepository('AppBundle:Marca')->find($marcaEdit);
                $lineaNew = $em->getRepository('AppBundle:Linea')->find($lineaEdit);
                $carroceriaNew = $em->getRepository('AppBundle:Carroceria')->find($carroceriaEdit);
                $combustibleNew = $em->getRepository('AppBundle:Combustible')->find($combustibleEdit);
                $origenVehiculoNew = $em->getRepository('AppBundle:CfgOrigenRegistro')->find($origenVehiculoEdit);

                $registroMaquinaria->setPesoBrutoVehicular($pesoBrutoEdit);
                $registroMaquinaria->setCargarUtilMaxima($cargaUtilMaximaEdit);
                $registroMaquinaria->setRodaje($rodajeEdit);
                $registroMaquinaria->setNumeroEjes($numeroEjesEdit);
                $registroMaquinaria->setNumeroLlantas($numeroLlantasEdit);
                $registroMaquinaria->setTipoCabina($tipoCabinaEdit);
                $registroMaquinaria->setAltoTotal($altoTotalEdit);
                $registroMaquinaria->setAnchoTotal($anchoTotalEdit);
                $registroMaquinaria->setLargoTotal($largoTotalEdit);
                $registroMaquinaria->setSubpartidaArancelaria($subpartidaArancelariaEdit);
                $registroMaquinaria->setTipoVehiculo($tipoVehiculoNew);
                $registroMaquinaria->setCfgOrigenRegistro($origenVehiculoNew);
                $registroMaquinaria->setCondicionIngreso($condicionEdit);
                $registroMaquinaria->setFechaIngreso($fechaIngresoEdit);
                $registroMaquinaria->setVehiculo($vehiculoNew);
                $em->flush();
    
                    $vehiculoNew = $registroMaquinaria->getVehiculo();
                    $vehiculoNew->setSerie($serieEdit);
                    $vehiculoNew->setVin($vinEdit);
                    $vehiculoNew->setChasis($chasisEdit);
                    $vehiculoNew->setMotor($motorEdit);
                    $vehiculoNew->setColor($colorNew);
                    $vehiculoNew->setClase($claseNew);
                    $vehiculoNew->setLinea($lineaNew);
                    $vehiculoNew->setModelo($modeloEdit);
                    $vehiculoNew->setCarroceria($carroceriaNew);
                    $vehiculoNew->setCombustible($combustibleNew);
                    $vehiculoNew->setEstado("Activo");
                    $em->flush();
                
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Maquinaria editada con exito",
                );

            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "La maquina no se encuentra en la base de datos",
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida para editar banco",
            );
        }

        return $helpers->json($response);

    }

    /**
     * Deletes a vehiculoMaquinaria entity.
     *
     * @Route("/{id}/delete", name="vehiculomaquinaria_delete")
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
            

            $registroMaquinaria = $em->getRepository('AppBundle:VehiculoMaquinaria')->find($params);
            $vehiculoId = $registroMaquinaria->getVehiculo();
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
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida",
            );
        }
        return $helpers->json($response);
    
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
