<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comparendo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Comparendo controller.
 *
 * @Route("comparendo")
 */
class ComparendoController extends Controller
{
    /**
     * Lists all comparendo entities.
     *
     * @Route("/", name="comparendo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $comparendos = $em->getRepository('AppBundle:Comparendo')->findBy(
            array('estado' => 1)
        );

        $response = array(
            'status' => 'success',
            'code' => 200,
            'msj' => "lista de comparendos",
            'data' => $comparendos, 
        );
        return $helpers->json($response);
    }

    /**
     * Creates a new comparendo entity.
     *
     * @Route("/new", name="comparendo_new")
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
            if (count($params)==0) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Los campos no pueden estar vacios", 
                );
            }else{
                $numeroOrden = $params->numeroOrden;
                $fechaDiligenciamiento = (isset($params->fechaDiligenciamiento)) ? $params->fechaNacimiento : null;
                $fechaDiligenciamientoDateTime = new \DateTime($fechaDiligenciamiento);
                $lugarInfraccion = $params->lugarInfraccion;
                $barrioInfraccion = $params->barrioInfraccion;
                $observacionesAgente = $params->observacionesAgente;
                $tipoInfractor = $params->tipoInfractor;
                $tarjetaOperacionInfractor = $params->tarjetaOperacionInfractor;
                $fuga = $params->fuga;
                $accidente = $params->accidente;
                $polca = $params->polca;
                $fechaNotificacion = (isset($params->fechaNotificacion)) ? $params->fechaNacimiento : null;
                $fechaNotificacionDateTime = new \DateTime($fechaNotificacion);
                $gradoAlchoholemia = $params->gradoAlchoholemia;

                $tipoIdentificacionId = $params->tipoIdentificacionId;
                $municipioNacimientoId = $params->municipioNacimientoId;
                $municipioResidenciaId = $params->municipioResidenciaId;
                
                $em = $this->getDoctrine()->getManager();

                $municipio = $em->getRepository('AppBundle:Municipio')->find($municipioId);
                $vehiculo = $em->getRepository('AppBundle:Vehiculo')->find($vehiculoId);
                $ciudadano = $em->getRepository('AppBundle:Ciudadano')->find($ciudadanoId);
                $agenteTransito = $em->getRepository('AppBundle:AgenteTransito')->find($agenteTransitoId);
                $seguimientoEntrega = $em->getRepository('AppBundle:SeguimientoEntrega')->find($seguimientoEntregaId);


                $comparendo = new Comparendo();
                $comparendo->setNumeroOrden($numeroOrden);
                $comparendo->setFechaDiligenciamiento($fechaDiligenciamientoDateTime);
                $comparendo->setLugarInfraccion($lugarInfraccion);
                $comparendo->setBarrioInfraccion($barrioInfraccion);
                $comparendo->setObservacionesAgente($observacionesAgente);
                $comparendo->setTarjetaOperacionInfractor($tarjetaOperacionInfractor);
                $comparendo->setFuga($fuga);
                $comparendo->setAccidente($accidente);
                $comparendo->setPolca($polca);
                $comparendo->setFechaNotificacion($fechaNotificacionDateTime);
                $comparendo->setGradoAlchoholemia($gradoAlchoholemia);
                $comparendo->setEstado(true);
                //Relación llaves foraneas
                $comparendo->setMunicipio($municipio);
                $comparendo->setVehiculo($vehiculo);
                $comparendo->setCiudadano($ciudadano);
                $comparendo->setAgenteTransito($agenteTransito);
                $comparendo->setSeguimientoEntrega($seguimientoEntrega);

                $em->persist($comparendo);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro creado con exito", 
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
     * Finds and displays a comparendo entity.
     *
     * @Route("/{id}/show", name="comparendo_show")
     * @Method("GET")
     */
    public function showAction(Request $request, Comparendo $comparendo)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro encontrado", 
                    'data'=> $comparendo,
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
     * Displays a form to edit an existing comparendo entity.
     *
     * @Route("/{id}/edit", name="comparendo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Comparendo $comparendo)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $numeroOrden = $params->numeroOrden;
            $fechaDiligenciamiento = (isset($params->fechaDiligenciamiento)) ? $params->fechaNacimiento : null;
            $fechaDiligenciamientoDateTime = new \DateTime($fechaDiligenciamiento);
            $lugarInfraccion = $params->lugarInfraccion;
            $barrioInfraccion = $params->barrioInfraccion;
            $observacionesAgente = $params->observacionesAgente;
            $tipoInfractor = $params->tipoInfractor;
            $tarjetaOperacionInfractor = $params->tarjetaOperacionInfractor;
            $fuga = $params->fuga;
            $accidente = $params->accidente;
            $polca = $params->polca;
            $fechaNotificacion = (isset($params->fechaNotificacion)) ? $params->fechaNacimiento : null;
            $fechaNotificacionDateTime = new \DateTime($fechaNotificacion);
            $gradoAlchoholemia = $params->gradoAlchoholemia;

            $em = $this->getDoctrine()->getManager();

            $municipio = $em->getRepository('AppBundle:Municipio')->find($municipioId);
            $vehiculo = $em->getRepository('AppBundle:Vehiculo')->find($vehiculoId);
            $ciudadano = $em->getRepository('AppBundle:Ciudadano')->find($ciudadanoId);
            $agenteTransito = $em->getRepository('AppBundle:AgenteTransito')->find($agenteTransitoId);
            $seguimientoEntrega = $em->getRepository('AppBundle:SeguimientoEntrega')->find($seguimientoEntregaId);
            

            if ($comparendo != null) {
                $comparendo->setNumeroOrden($numeroOrden);
                $comparendo->setFechaDiligenciamiento($fechaDiligenciamientoDateTime);
                $comparendo->setLugarInfraccion($lugarInfraccion);
                $comparendo->setBarrioInfraccion($barrioInfraccion);
                $comparendo->setObservacionesAgente($observacionesAgente);
                $comparendo->setTarjetaOperacionInfractor($tarjetaOperacionInfractor);
                $comparendo->setFuga($fuga);
                $comparendo->setAccidente($accidente);
                $comparendo->setPolca($polca);
                $comparendo->setFechaNotificacion($fechaNotificacionDateTime);
                $comparendo->setGradoAlchoholemia($gradoAlchoholemia);
                //Relación llaves foraneas
                $comparendo->setMunicipio($municipio);
                $comparendo->setVehiculo($vehiculo);
                $comparendo->setCiudadano($ciudadano);
                $comparendo->setAgenteTransito($agenteTransito);
                $comparendo->setSeguimientoEntrega($seguimientoEntrega);

                $em->persist($comparendo);
                $em->flush();

                 $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Registro actualizado con exito", 
                        'data'=> $comparendo,
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
                    'msj' => "Autorizacion no valida para editar banco", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a comparendo entity.
     *
     * @Route("/{id}/delete", name="comparendo_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, Comparendo $comparendo)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();

            $comparendo->setEstado(false);
            $em = $this->getDoctrine()->getManager();
                $em->persist($comparendo);
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
     * Creates a form to delete a comparendo entity.
     *
     * @param Comparendo $comparendo The comparendo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Comparendo $comparendo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('comparendo_delete', array('id' => $comparendo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}