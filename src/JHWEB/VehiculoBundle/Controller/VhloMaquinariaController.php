<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloMaquinaria;
use AppBundle\Entity\CfgPlaca;
use AppBundle\Entity\Vehiculo;
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
            
            $cfgPlaca = $em->getRepository('AppBundle:CfgPlaca')->findOneBy(array('numero' => $params->placa));

            $sedeOperativa = $em->getRepository('AppBundle:SedeOperativa')->find($params->idSedeOperativa);
            
            if (!$cfgPlaca) {
                
                $placa = new CfgPlaca();
                $placa->setNumero($params->placa);

                $cfgTipoVehiculo = $em->getRepository('AppBundle:CfgTipoVehiculo')->findOneByModulo(3);
                $placa->setTipoVehiculo($cfgTipoVehiculo);

                $placa->setSedeOperativa($sedeOperativa);
                $placa->setEstado('Asignada');
                $em->persist($placa);
                $em->flush();

                $vehiculo = new Vehiculo();

                $vehiculo->setPlaca($placa);
                $vehiculo->setSedeOperativa($sedeOperativa);

                $vehiculo->setSerie($params->serie);
                $vehiculo->setVin($params->vin);
                $vehiculo->setChasis($params->chasis);
                $vehiculo->setMotor($params->motor);
                $vehiculo->setModelo($params->modelo);
                
                $color = $em->getRepository('AppBundle:Color')->find(
                    $params->idColor
                );
                $vehiculo->setColor($color);

                $linea = $em->getRepository('AppBundle:Linea')->find(
                    $params->idLinea
                );
                $vehiculo->setLinea($linea);

                $carroceria = $em->getRepository('AppBundle:Carroceria')->find($params->idCarroceria);
                $vehiculo->setCarroceria($carroceria);

                $combustible = $em->getRepository('AppBundle:Combustible')->find($params->idCombustible);
                $vehiculo->setCombustible($combustible);

                $vehiculo->setEstado(true);

                $em->persist($vehiculo);
                $em->flush();

                $vehiculoMaquinaria = new VhloMaquinaria();

                $vehiculoMaquinaria->setFechaIngreso(
                    new \DateTime($params->fechaIngreso)
                );
                $vehiculoMaquinaria->setPeso($params->peso);
                $vehiculoMaquinaria->setCargarUtilMaxima(
                    $params->cargaUtilMaxima
                );
                $vehiculoMaquinaria->setNumeroEjes($params->numeroEjes);
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

                $claseMaquinaria = $em->getRepository('JHWEBVehiculoBundle:VhloCfgClaseMaquinaria')->find(
                    $params->idClaseMaquinaria
                );
                $vehiculoMaquinaria->setClaseMaquinaria($claseMaquinaria);
                
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
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro creado con exito",
                    'data' => $vehiculoMaquinaria
                );

            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El número de placa ya existe",
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
     * @Route("/{id}/edit", name="vhlomaquinaria_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, VhloMaquinaria $vhloMaquinaria)
    {
        $deleteForm = $this->createDeleteForm($vhloMaquinaria);
        $editForm = $this->createForm('JHWEB\VehiculoBundle\Form\VhloMaquinariaType', $vhloMaquinaria);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vhlomaquinaria_edit', array('id' => $vhloMaquinaria->getId()));
        }

        return $this->render('vhlomaquinaria/edit.html.twig', array(
            'vhloMaquinaria' => $vhloMaquinaria,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
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
}
