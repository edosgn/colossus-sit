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
        $tramitesFactura = $em->getRepository('AppBundle:TramiteFactura')->findBy(
            array('factura'=>$idFactura,
                  'estado'=> 1)
        );

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
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck== true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $factura = $em->getRepository('AppBundle:Factura')->find($params->factura);
            $valorBruto = 0;
            foreach ($params->tramites as $key => $tramiteId) {
                $tramiteFactura = new TramiteFactura();
                $tramiteFactura->setEstado(true);
                $tramiteFactura->setRealizado(false);
                $tramiteFactura->setFactura($factura);
                $tramite = $em->getRepository('AppBundle:Tramite')->find($tramiteId);
                $valorBruto = $valorBruto + $tramite->getValor();
                $tramiteFactura->setTramite($tramite);
                $em->persist($tramiteFactura);
                $em->flush();
            }
            $factura->setValorBruto($valorBruto);
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
     * Finds and displays a infraccion entity.
     *
     * @Route("/{id}/show", name="tramitefactura_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        
        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $tramiteFactura = $em->getRepository('AppBundle:TramiteFactura')->find($id);
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro encontrado", 
                    'data'=> $tramiteFactura->getTramite(),
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
     * @Route("/{idFactura}/select", name="tramitefactura_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction($idFactura)
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $factura = $em->getRepository('AppBundle:Factura')->findOneByNumero($idFactura);
        $response = [];
        $tramitesFactura = $em->getRepository('AppBundle:TramiteFactura')->findBy(
            array('realizado' => false, 'factura' => $factura->getId())
        );
        foreach ($tramitesFactura as $key => $tramiteFactura) {
            $response[$key] = array(
                'value' => $tramiteFactura->getId(),
                'label' => $tramiteFactura->getTramite()->getNombre(),
            );
        }
       
        return $helpers->json($response);
    }
}
