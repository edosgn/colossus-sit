<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CfgValorVehiculo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Cfgvalorvehiculo controller.
 *
 * @Route("cfgValorVehiculo")
 */
class CfgValorVehiculoController extends Controller
{
     /**
     * Lists all cfgValorVehiculo entities.
     *
     * @Route("/", name="cfgvalorvehiculo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $valorVehiculo = $em->getRepository('AppBundle:CfgValorVehiculo')->findBy(
            array('estado' => 1)
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
     * Creates a new cfgValorVehiculo entity.
     *
     * @Route("/new", name="cfgvalorvehiculo_new")
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
                $clase = $em->getRepository('AppBundle:Clase')->find($params->claseId);
                $linea = $em->getRepository('AppBundle:Linea')->find($params->lineaId);

                $valorVehiculo = new CfgValorVehiculo();

                $valorVehiculo->setClase($clase);
                $valorVehiculo->setLinea($linea);
                $valorVehiculo->setCilindraje($params->cilindraje);
                $valorVehiculo->setValor($params->valor);
                $valorVehiculo->setAnio($params->anio);
                $valorVehiculo->setEstado(true);

                $em->persist($valorVehiculo);
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
     * Finds and displays a cfgValorVehiculo entity.
     *
     * @Route("/show/{id}", name="cfgvalorvehiculo_show")
     * @Method("POST")
     */
    public function showAction(CfgValorVehiculo $cfgValorVehiculo)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $cfgValorVehiculo = $em->getRepository('AppBundle:CfgValorVehiculo')->find($id);
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
     * Displays a form to edit an existing cfgValorVehiculo entity.
     *
     * @Route("/edit", name="cfgvalorvehiculo_edit")
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
            $clase = $em->getRepository('AppBundle:Clase')->find($params->claseId);
            $linea = $em->getRepository('AppBundle:Linea')->find($params->lineaId);
            $cfgValorVehiculo = $em->getRepository('AppBundle:CfgValorVehiculo')->find($params->id);
            if ($cfgValorVehiculo!=null) {

                $cfgValorVehiculo->setClase($clase);
                $cfgValorVehiculo->setLinea($linea);
                $cfgValorVehiculo->setCilindraje($params->cilindraje);
                $cfgValorVehiculo->setValor($params->valor);
                $cfgValorVehiculo->setAnio($params->anio);
                $cfgValorVehiculo->setEstado(true);
               
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
     * Deletes a cfgValorVehiculo entity.
     *
     * @Route("/{id}/delete", name="cfgvalorvehiculo_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();            
            $valorVehiculo = $em->getRepository('AppBundle:CfgValorVehiculo')->find($id);

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
     * Creates a form to delete a cfgValorVehiculo entity.
     *
     * @param CfgValorVehiculo $cfgValorVehiculo The cfgValorVehiculo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgValorVehiculo $cfgValorVehiculo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgvalorvehiculo_delete', array('id' => $cfgValorVehiculo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

        /**
     * datos para select 
     *
     * @Route("/select", name="tipoProducto_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $valorVehiculos = $em->getRepository('AppBundle:CfgValorVehiculo')->findBy(
        array('estado' => 1)
    );
      foreach ($valorVehiculos as $key => $valorVehiculo) {
        $response[$key] = array(
            'value' => $valorVehiculo->getId(),
            'label' => $valorVehiculo->getNombre(),
            );
      }
       return $helpers->json($response);
    }

    /**
     * datos para select1 
     *
     * @Route("/show/vehiculo/", name="valor_vehiculo_vehiculo")
     * @Method({"GET", "POST"})
     */
    public function showVehiculoAction(Request $request)
    {
    $helpers = $this->get("app.helpers");
    $hash = $request->get("authorization", null);
    $authCheck = $helpers->authCheck($hash);
    if ($authCheck== true) {
        $json = $request->get("json",null);
        $params = json_decode($json);
        $em = $this->getDoctrine()->getManager();
        $valorVehiculo = $em->getRepository('AppBundle:CfgValorVehiculo')->findOneBy(
            array(
                'linea' => $params->linea,
                'clase' => $params->clase,
                'anio' => $params->modelo,
            )
        );
        $response = array(
            'status' => 'success',
            'code' => 200,
            'msj' => "valor Vehiculo", 
            'datos' => $valorVehiculo, 
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
    
}
