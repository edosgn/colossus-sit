<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloRemolque;
use AppBundle\Entity\CfgPlaca;
use AppBundle\Entity\Vehiculo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Vhloremolque controller.
 *
 * @Route("vhloremolque")
 */
class VhloRemolqueController extends Controller
{
    /**
     * Lists all vhloRemolque entities.
     *
     * @Route("/", name="vhloremolque_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $remolques = $em->getRepository('JHWEBVehiculoBundle:VhloRemolque')->findAll();

        $response['data'] = array();

        if ($remolques) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($remolques)." registros encontrados", 
                'data'=> $remolques,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new vhloRemolque entity.
     *
     * @Route("/new", name="vhloremolque_new")
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
            
            $cfgPlaca = $em->getRepository('AppBundle:CfgPlaca')->findOneBy(array('numero' => $params->placa));

            $sedeOperativa = $em->getRepository('AppBundle:SedeOperativa')->find(1);
            
            if (!$cfgPlaca) {
                $placa = new CfgPlaca();
                $placa->setNumero($params->placa);

                $numeroFactura = $params->numeroFactura;
                $valor = $params->valor;
                $fechaFactura = $params->fechaFactura;
                $fechaFactura = new \DateTime($fechaFactura);

                $cfgTipoVehiculo = $em->getRepository('AppBundle:CfgTipoVehiculo')->findOneByModulo(4);
                $placa->setTipoVehiculo($cfgTipoVehiculo);

                $placa->setSedeOperativa($sedeOperativa);
                $placa->setEstado('Asignada');
                $em->persist($placa);
                $em->flush();

                $vehiculo = new Vehiculo();
                
                $vehiculo->setNumeroFactura($numeroFactura);
                $vehiculo->setfechaFactura($fechaFactura);
                $vehiculo->setValor($valor);


                $vehiculo->setPlaca($placa);
                $vehiculo->setSedeOperativa($sedeOperativa);

                $vehiculo->setSerie($params->serie);
                $vehiculo->setVin($params->vin);
                $vehiculo->setModelo($params->modelo);

                if (isset($params->idClase)) {
                    $clase = $em->getRepository('AppBundle:Clase')->find(
                        $params->idClase
                    );
                    $vehiculo->setClase($clase);
                }
                
                if (isset($params->idColor)) {
                    $color = $em->getRepository('AppBundle:Color')->find(
                        $params->idColor
                    );
                    $vehiculo->setColor($color);
                }

                if (isset($params->idLinea)) {
                    $linea = $em->getRepository('AppBundle:Linea')->find(
                        $params->idLinea
                    );
                    $vehiculo->setLinea($linea);
                }

                if (isset($params->idCarroceria)) {
                    $carroceria = $em->getRepository('AppBundle:Carroceria')->find($params->idCarroceria);
                    $vehiculo->setCarroceria($carroceria);
                }

                if (isset($params->idCombustible)) {
                    $combustible = $em->getRepository('AppBundle:Combustible')->find($params->idCombustible);
                    $vehiculo->setCombustible($combustible);
                }

                if (isset($params->idCombustible)) {
                    $combustible = $em->getRepository('AppBundle:Combustible')->find($params->idCombustible);
                    $vehiculo->setCombustible($combustible);
                }
                 
                if (isset($params->idSedeOperativa)) {
                    $sedeOperativa = $em->getRepository('AppBundle:SedeOperativa')->find($params->idSedeOperativa);
                    $vehiculo->setSedeOperativa($sedeOperativa);
                }

                $vehiculo->setEstado(true);

                $em->persist($vehiculo);
                $em->flush();

                $vehiculoRemolque = new VhloRemolque();

                $vehiculoRemolque->setFechaIngreso(
                    new \DateTime(date('Y-m-d'))
                );
                $vehiculoRemolque->setPeso($params->pesoVacio);
                $vehiculoRemolque->setCargarUtilMaxima(
                    $params->cargaUtil
                );
                $vehiculoRemolque->setNumeroEjes($params->numeroEjes);
                $vehiculoRemolque->setAlto($params->alto);
                $vehiculoRemolque->setAncho($params->ancho);
                $vehiculoRemolque->setLargo($params->largo);
                $vehiculoRemolque->setReferencia($params->referencia);
                $vehiculoRemolque->setNumeroFth($params->numeroFth);
                $vehiculoRemolque->setNumeroRunt($params->numeroRunt);
                
                $origenRegistro = $em->getRepository('JHWEBVehiculoBundle:VhloCfgOrigenRegistro')->find($params->idOrigenRegistro);
                $vehiculoRemolque->setOrigenRegistro($origenRegistro);

                $condicionIngreso = $em->getRepository('JHWEBVehiculoBundle:VhloCfgCondicionIngreso')->find($params->idCondicionIngreso);
                $vehiculoRemolque->setCondicionIngreso($condicionIngreso);

                $vehiculoRemolque->setVehiculo($vehiculo);

                $em->persist($vehiculoRemolque);
                $em->flush();
                
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro creado con exito",
                    'data' => $vehiculoRemolque
                );

            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El número de placa ya existe y se encuentra registrado con otro vehiculo.",
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida",
            );
        }

        return $helpers->json($response);
    }

    /**
     * Finds and displays a vhloRemolque entity.
     *
     * @Route("/{id}/show", name="vhloremolque_show")
     * @Method("GET")
     */
    public function showAction(VhloRemolque $vhloRemolque)
    {
        $deleteForm = $this->createDeleteForm($vhloRemolque);

        return $this->render('vhloremolque/show.html.twig', array(
            'vhloRemolque' => $vhloRemolque,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vhloRemolque entity.
     *
     * @Route("/{id}/edit", name="vhloremolque_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, VhloRemolque $vhloRemolque)
    {
        $deleteForm = $this->createDeleteForm($vhloRemolque);
        $editForm = $this->createForm('JHWEB\VehiculoBundle\Form\VhloRemolqueType', $vhloRemolque);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vhloremolque_edit', array('id' => $vhloRemolque->getId()));
        }

        return $this->render('vhloremolque/edit.html.twig', array(
            'vhloRemolque' => $vhloRemolque,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing VehiculoRemolque entity.
     *
     * @Route("/transformacion", name="vhloremolque_transformacion")
     * @Method({"GET", "POST"})
     */
    public function transformacionVehiculoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();

            $vehiculo = $em->getRepository('AppBundle:Vehiculo')->find($params->idVehiculo);

            $vehiculoRemolque = $em->getRepository("JHWEBVehiculoBundle:VhloRemolque")->findOneByVehiculo(
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

                    $condicionIngreso = $em->getRepository("JHWEBVehiculoBundle:VhloCfgCondicionIngreso")->find(
                        $vehiculoRemolque->getCondicionIngreso()->getId()
                    );
                    $vehiculoRemolque->setCondicionIngreso($condicionIngreso);

                    $origenRegistro = $em->getRepository("JHWEBVehiculoBundle:VhloCfgOrigenRegistro")->find(
                        $vehiculoRemolque->getOrigenRegistro()->getId()
                    );
                    $vehiculoRemolque->setOrigenRegistro($origenRegistro);
                    $vehiculoRemolque->setNumeroEjes($params->nuevoNumeroEjes);
                    $vehiculoRemolque->setNumeroFth($params->numeroFTH);
                    $vehiculoRemolque->setPeso($params->pesoVacio);
                    $vehiculoRemolque->setCargarUtilMaxima($params->cargaUtil);
                    $vehiculoRemolque->setReferencia($vehiculoRemolque->getReferencia());
                    $vehiculoRemolque->setNumeroFth($vehiculoRemolque->getNumeroFth());
                    $vehiculoRemolque->setNumeroRunt($vehiculoRemolque->getNumeroRunt());
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
     * Deletes a vhloRemolque entity.
     *
     * @Route("/{id}/delete", name="vhloremolque_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, VhloRemolque $vhloRemolque)
    {
        $form = $this->createDeleteForm($vhloRemolque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vhloRemolque);
            $em->flush();
        }

        return $this->redirectToRoute('vhloremolque_index');
    }

    /**
     * Creates a form to delete a vhloRemolque entity.
     *
     * @param VhloRemolque $vhloRemolque The vhloRemolque entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloRemolque $vhloRemolque)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhloremolque_delete', array('id' => $vhloRemolque->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
