<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Factura;
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
        $facturas = $em->getRepository('AppBundle:Factura')->findByEstado(true);

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
                $numero = $params->numero;
                $observacion = (isset($params->observacion)) ? $params->observacion : null;
                $fechaCreacionDateTime = new \DateTime(date('Y-m-d'));
                //Captura llaves foraneas
                $solicitanteId = $params->solicitanteId;
                $apoderadoId = $params->apoderadoId;
                $vehiculoId = $params->vehiculoId;

                $em = $this->getDoctrine()->getManager();
                $solicitante = $em->getRepository('AppBundle:Ciudadano')->find($solicitanteId);
                $apoderado = $em->getRepository('AppBundle:Apoderado')->find($apoderadoId);
                $vehiculo = $em->getRepository('AppBundle:Vehiculo')->find($vehiculoId);

                $factura = new Factura();

                $factura->setNumero($numero);
                $factura->setObservacion($descripcion);
                $factura->setFechaCreacion($fechaCreacionDateTime);
                $factura->setEstado(false);
                //Inserta llaves foraneas
                $factura->setSolicitante($solicitante);
                $factura->setApoderado($apoderado);
                $factura->setVehiculo($vehiculo);

                $em = $this->getDoctrine()->getManager();
                $em->persist($factura);
                $em->flush();

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
            $observacion = (isset($params->observacion)) ? $params->observacion : null;
            $fechaCreacionDateTime = new \DateTime(date('Y-m-d'));
            //Captura llaves foraneas
            $solicitanteId = $params->solicitanteId;
            $apoderadoId = $params->apoderadoId;
            $vehiculoId = $params->vehiculoId;

            $em = $this->getDoctrine()->getManager();
            $solicitante = $em->getRepository('AppBundle:Ciudadano')->find($solicitanteId);
            $apoderado = $em->getRepository('AppBundle:Apoderado')->find($apoderadoId);
            $vehiculo = $em->getRepository('AppBundle:Vehiculo')->find($vehiculoId);

            if ($factura!=null) {
                $factura->setNumero($numero);
                $factura->setObservacion($descripcion);
                $factura->setFechaCreacion($fechaCreacionDateTime);
                $factura->setEstado(false);
                //Inserta llaves foraneas
                $factura->setSolicitante($solicitante);
                $factura->setApoderado($apoderado);
                $factura->setVehiculo($vehiculo);

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
}
