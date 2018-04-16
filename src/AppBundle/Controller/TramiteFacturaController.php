<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TramiteFactura;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Tramitefactura controller.
 *
 * @Route("tramitefactura")
 */
class TramiteFacturaController extends Controller
{
    /**
     * Lists all tramiteFactura entities.
     *
     * @Route("/{idFactura}/index", name="tramitefactura_index")
     * @Method("GET")
     */
    public function indexAction($idFactura)
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $factura = $em->getRepository('AppBundle:Factura')->find($idFactura);
        $tramitesFactura = $em->getRepository('AppBundle:TramiteFactura')->findByFactura($factura->getId());

        $response = array(
            'status' => 'success',
            'code' => 200,
            'msj' => "Lista de tramites por factura",
            'data' => $tramitesFactura, 
        );
        return $helpers->json($response);
    }

    /**
     * Creates a new infraccion entity.
     *
     * @Route("/new", name="tramitefactura_new")
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
                $codigo = $params->codigo;
                $descripcion = $params->descripcion;
                $valor = $params->valor;
                $inmovilizacion = (isset($params->inmovilizacion)) ? $params->inmovilizacion : 0;
                $suspensionLicencia = (isset($params->suspensionLicencia)) ? $params->suspensionLicencia : 0;

                $infraccion = new TramiteFactura();

                $infraccion->setCodigo($codigo);
                $infraccion->setDescripcion($descripcion);
                $infraccion->setValor($valor);
                $infraccion->setEstado(true);
                $infraccion->setInmovilizacion($inmovilizacion);
                $infraccion->setSuspensionLicencia($suspensionLicencia);

                $em = $this->getDoctrine()->getManager();
                $em->persist($infraccion);
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
     * Finds and displays a infraccion entity.
     *
     * @Route("/{id}/show", name="tramitefactura_show")
     * @Method("GET")
     */
    public function showAction(TramiteFactura $infraccion)
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
                    'data'=> $infraccion,
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
     * Displays a form to edit an existing infraccion entity.
     *
     * @Route("/edit", name="tramitefactura_edit")
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

            $em = $this->getDoctrine()->getManager();
            $infraccion = $em->getRepository("AppBundle:TramiteFactura")->find($params->id);

            $codigo = $params->codigo;
            $descripcion = $params->descripcion;
            $valor = $params->valor;
            $inmovilizacion = (isset($params->inmovilizacion)) ? $params->inmovilizacion : 0;
            $suspensionLicencia = (isset($params->suspensionLicencia)) ? $params->suspensionLicencia : 0;

            if ($infraccion) {
                $infraccion->setCodigo($codigo);
                $infraccion->setDescripcion($descripcion);
                $infraccion->setValor($valor);
                $infraccion->setInmovilizacion($inmovilizacion);
                $infraccion->setSuspensionLicencia($suspensionLicencia);

                $em = $this->getDoctrine()->getManager();
                
                $em->persist($infraccion);
                $em->flush();

                 $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Registro actualizado con exito", 
                        'data'=> $infraccion,
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
     * Deletes a infraccion entity.
     *
     * @Route("/{id}/delete", name="tramitefactura_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, TramiteFactura $infraccion)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();

            $infraccion->setEstado(false);
            
            $em = $this->getDoctrine()->getManager();
                $em->persist($infraccion);
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
     * Creates a form to delete a infraccion entity.
     *
     * @param TramiteFactura $infraccion The infraccion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TramiteFactura $infraccion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tramitefactura_delete', array('id' => $infraccion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="tramitefactura_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $tramitesFactura = $em->getRepository('AppBundle:TramiteFactura')->findAll();
        foreach ($tramitesFactura as $key => $tramiteFactura) {
            $response[$key] = array(
                'value' => $tramiteFactura->getId(),
                'label' => $tramiteFactura->getTramite()->getNombre(),
            );
        }
       
        return $helpers->json($response);
    }
}
