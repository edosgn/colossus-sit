<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloCfgValor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlocfgvalor controller.
 *
 * @Route("vhlocfgvalor")
 */
class VhloCfgValorController extends Controller
{
    /**
     * Lists all vhloCfgValor entities.
     *
     * @Route("/", name="vhlocfgvalor_index")
     * @Method("GET")
     */
    public function indexAction() 
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $valorVehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloCfgValor')->findBy(
            array('activo' => 1)
        );

        $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado tipos de proceso", 
                    'data'=> $valorVehiculo,
            );
         
        return $helpers->json($response);
    }

    /**
     * Creates a new vhloCfgValor entity.
     *
     * @Route("/new", name="vhlocfgvalor_new")
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

                $em = $this->getDoctrine()->getManager();
                $clase = $em->getRepository('JHWEBVehiculoBundle:VhloCfgClase')->find($params->claseId);
                $linea = $em->getRepository('JHWEBVehiculoBundle:VhloCfgLinea')->find($params->lineaId);

                $vhloCfgValor = new VhloCfgValor();

                $vhloCfgValor->setClase($clase);
                $vhloCfgValor->setLinea($linea);
                $vhloCfgValor->setCilindraje($params->cilindraje);
                $vhloCfgValor->setValor($params->valor);
                $vhloCfgValor->setAnio($params->anio);
                $vhloCfgValor->setActivo(true);
 
                $em->persist($vhloCfgValor);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Tipo Producto creado con exito", 
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
     * Finds and displays a vhloCfgValor entity.
     *
     * @Route("/show/{id}", name="vhlocfgvalor_show")
     * @Method("GET")
     */
    public function showAction(VhloCfgValor $vhloCfgValor)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $cfgValorVehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloCfgValor')->find($id);
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "cfgValorVehiculo encontrado", 
                    'data'=> $cfgValorVehiculo,
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
     * Displays a form to edit an existing vhloCfgValor entity.
     *
     * @Route("/edit", name="vhlocfgvalor_edit")
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
            $clase = $em->getRepository('JHWEBVehiculoBundle:VhloCfgClase')->find($params->claseId);
            $linea = $em->getRepository('JHWEBVehiculoBundle:VhloCfgLinea')->find($params->lineaId);
            $cfgValorVehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloCfgValor')->find($params->id);
            if ($cfgValorVehiculo!=null) {

                $cfgValorVehiculo->setClase($clase);
                $cfgValorVehiculo->setLinea($linea);
                $cfgValorVehiculo->setCilindraje($params->cilindraje);
                $cfgValorVehiculo->setValor($params->valor);
                $cfgValorVehiculo->setAnio($params->anio);
               
                $em->persist($cfgValorVehiculo);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Limitación editada con exito", 
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "La limitación no se encuentra en la base de datos", 
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
     * Deletes a vhloCfgValor entity. 
     *
     * @Route("/{id}/delete", name="vhlocfgvalor_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, VhloCfgValor $vhloCfgValor)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();            
            $valorVehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloCfgValor')->find($id);

            $valorVehiculo->setEstado(0);
            $em = $this->getDoctrine()->getManager();
                $em->persist($valorVehiculo);
                $em->flush();
            $response = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "Tipo proceso eliminada con exito", 
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
     * Creates a form to delete a vhloCfgValor entity.
     *
     * @param VhloCfgValor $vhloCfgValor The vhloCfgValor entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloCfgValor $vhloCfgValor)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhlocfgvalor_delete', array('id' => $vhloCfgValor->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}