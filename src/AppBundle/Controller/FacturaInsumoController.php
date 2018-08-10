<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\FacturaInsumo;
use AppBundle\Form\FacturaInsumoType;

/**
 * FacturaInsumo controller.
 *
 * @Route("/facturaInsumo")
 */
class FacturaInsumoController extends Controller
{
    /**
     * Lists all FacturaInsumo entities.
     *
     * @Route("/", name="facturaInsumo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $facturaInsumos = $em->getRepository('AppBundle:FacturaInsumo')->findBy(
            array('estado' => 1)
        );
        $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado facturaInsumos", 
                    'data'=> $facturaInsumos,
            );
         
        return $helpers->json($response);
    }

    /**
     * Creates a new FacturaInsumo entity.
     *
     * @Route("/new", name="facturaInsumo_new")
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
          
            $descripcion = (isset($params->descripcion)) ? $params->descripcion : null;
            $entregado = (isset($params->entregado)) ? $params->entregado : null;

            $insumoId = (isset($params->insumoId)) ? $params->insumoId : null;
            $ciudadanoId = (isset($params->ciudadanoId)) ? $params->ciudadanoId : null;
            $facturaId = (isset($params->facturaId)) ? $params->facturaId : null;

            $em = $this->getDoctrine()->getManager();
            $insumo = $em->getRepository("AppBundle:Insumo")->find($insumoId);
            $usuario = $em->getRepository('UsuarioBundle:Usuario')->findOneByIdentificacion($ciudadanoId);
            $factura = $em->getRepository('AppBundle:Factura')->find($facturaId);

            $insumo->setEstado('usado');
            $em->persist($insumo);
            $em->flush();
            $facturaInsumo = new FacturaInsumo();

            $facturaInsumo->setDescripcion($descripcion);
            $facturaInsumo->setEntregado($entregado);
            $facturaInsumo->setCiudadano($usuario->getCiudadano());
            $facturaInsumo->setInsumo($insumo);
            $facturaInsumo->setFactura($factura);
            $fecha = new \DateTime();
            $facturaInsumo->setFecha($fecha);

            $em = $this->getDoctrine()->getManager();
            $em->persist($facturaInsumo);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "FacturaInsumo creado con exito", 
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Finds and displays a FacturaInsumo entity.
     *
     * @Route("/show/{id}", name="facturaInsumo_show")
     * @Method("POST")
     */
    public function showAction(Request  $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $facturaInsumo = $em->getRepository('AppBundle:FacturaInsumo')->find($id);
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "facturaInsumo encontrado", 
                    'data'=> $facturaInsumo,
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
     * Displays a form to edit an existing FacturaInsumo entity.
     *
     * @Route("/edit", name="facturaInsumo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $nombre = $params->nombre;
            $tramiteId = $params->tramiteId;
            $em = $this->getDoctrine()->getManager();
            $tramite = $em->getRepository('AppBundle:Tramite')->find($tramiteId);
            $facturaInsumo = $em->getRepository("AppBundle:FacturaInsumo")->find($params->id);

            if ($facturaInsumo!=null) {
                $facturaInsumo->setNombre($nombre);
                $facturaInsumo->setEstado(true);
                $facturaInsumo->setTramite($tramite);

                $em = $this->getDoctrine()->getManager();
                $em->persist($facturaInsumo);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "FacturaInsumo editado con exito", 
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El facturaInsumo no se encuentra en la base de datos", 
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
     * Deletes a FacturaInsumo entity.
     *
     * @Route("/{id}/delete", name="facturaInsumo_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $facturaInsumo = $em->getRepository('AppBundle:FacturaInsumo')->find($id);

            $facturaInsumo->setEstado(0);
            $em = $this->getDoctrine()->getManager();
                $em->persist($facturaInsumo);
                $em->flush();
            $response = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "facturaInsumo eliminado con exito", 
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
     * Creates a form to delete a FacturaInsumo entity.
     *
     * @param FacturaInsumo $facturaInsumo The FacturaInsumo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FacturaInsumo $facturaInsumo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('facturaInsumo_delete', array('id' => $facturaInsumo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * busca los facturaInsumos de un tramite.
     *
     * @Route("/showFacturaInsumos/{id}", name="facturaInsumo_tramites_show")
     * @Method("POST")
     */
    public function showFacturaInsumosAction(Request  $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $facturaInsumos = $em->getRepository('AppBundle:FacturaInsumo')->findBy(
            array('estado' => 1,'tramite'=> $id)
            );

            if ($facturaInsumos==null) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "No hay facturaInsumos asigandos a este tramite", 
                );
            }
            else{
               $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "facturaInsumos encontrado", 
                    'data'=> $facturaInsumos,
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
}
