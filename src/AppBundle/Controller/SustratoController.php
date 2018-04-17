<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Sustrato;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
/**
 * Sustrato controller.
 *
 * @Route("sustrato")
 */
class SustratoController extends Controller
{
    /**
     * Lists all sustrato entities.
     *
     * @Route("/", name="sustrato_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $sustratos = $em->getRepository('AppBundle:Sustrato')->findAll();

        $response = array(
            'status' => 'success',
            'code' => 200,
            'msj' => "Lista de sustratos",
            'data' => $sustratos, 
        );
        return $helpers->json($response);
    }

    /**
     * Creates a new sustrato entity.
     *
     * @Route("/new", name="sustrato_new")
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
                $estado = $params->estado;
                $desde = $params->desde;
                $hasta = $params->hasta;
                //Captura llaves foraneas
                $sedeOperativaId = $params->sedeOperativaId;
                $moduloId = $params->moduloId;

                $em = $this->getDoctrine()->getManager();
                $sedeOperativa = $em->getRepository('AppBundle:SedeOperativa')->find($sedeOperativaId);
                $modulo = $em->getRepository('AppBundle:Modulo')->find($moduloId);

                while ($desde <= $hasta) {
                    $sustrato = new Sustrato();

                    $sustrato->setEstado($estado);
                    $sustrato->setConsecutivo($desde);
                    //Inserta llaves foraneas
                    $sustrato->setSedeOperativa($sedeOperativa);
                    $sustrato->setModulo($modulo);

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($sustrato);
                    $em->flush();
                    $desde++;
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
     * Finds and displays a sustrato entity.
     *
     * @Route("/{id}/show", name="sustrato_show")
     * @Method("GET")
     */
    public function showAction($id)
    {
        helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $sustrato = $em->getRepository('AppBundle:Sustrato')->find($id);
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "sustrato con numero"." ".$sustrato->getNumero(), 
                    'data'=> $sustrato,
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
     * Displays a form to edit an existing sustrato entity.
     *
     * @Route("/{id}/edit", name="sustrato_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Sustrato $sustrato)
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
            $apoderado = $em->getRepository('AppBundle:Ciudadano')->find($apoderadoId);
            $vehiculo = $em->getRepository('AppBundle:Vehiculo')->find($vehiculoId);

            if ($factura!=null) {
                $factura->setNumero($numero);
                $factura->setObservacion($observacion);
                $factura->setFechaCreacion($fechaCreacionDateTime);
                $factura->setEstado(true);
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
     * Deletes a sustrato entity.
     *
     * @Route("/{id}", name="sustrato_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Sustrato $sustrato)
    {
        $form = $this->createDeleteForm($sustrato);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($sustrato);
            $em->flush();
        }

        return $this->redirectToRoute('sustrato_index');
    }

    /**
     * Creates a form to delete a sustrato entity.
     *
     * @param Sustrato $sustrato The sustrato entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Sustrato $sustrato)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('sustrato_delete', array('id' => $sustrato->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
