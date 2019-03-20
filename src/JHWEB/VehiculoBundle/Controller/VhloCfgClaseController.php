<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloCfgClase;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlocfgclase controller.
 *
 * @Route("vhlocfgclase")
 */
class VhloCfgClaseController extends Controller
{
    /**
     * Lists all vhloCfgClase entities.
     *
     * @Route("/", name="vhlocfgclase_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $clases = $em->getRepository('JHWEBVehiculoBundle:VhloCfgClase')->findBy(
            array('activo' => 1)
        );
        $response = array(
            'status' => 'success',
            'code' => 200,
            'message' => "listado clases",
            'data' => $clases,
        );

        return $helpers->json($response);
    }

    /**
     * Creates a new Clase entity.
     *
     * @Route("/new", name="vhlocfgclase_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();

            $tipoVehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloCfgTipoVehiculo')->find($params->idTipoVehiculo);
            
            $clase = new VhloCfgClase();
            $clase->setNombre($params->nombre);
            $clase->setCodigo($params->codigo);
            $clase->setTipoVehiculo($tipoVehiculo);
            $clase->setActivo(true);

            $em->persist($clase);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con éxito",
            );

        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Finds and displays a vhloCfgClase entity.
     *
     * @Route("/show/{id}", name="vhlocfgclase_show")
     * @Method("GET")
     */
    public function showAction(Request  $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $clase = $em->getRepository('JHWEBVehiculoBundle:VhloCfgTipoVehiculo')->find($id);
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Clase encontrada", 
                    'data'=> $clase,
            );
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorización no válida", 
                );
        }
        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing Clase entity.
     *
     * @Route("/edit", name="vhlocfgclase_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            $clase = $em->getRepository('JHWEBVehiculoBundle:VhloCfgClase')->find($params->id);
            
            $tipoVehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloCfgTipoVehiculo')->find($params->idTipoVehiculo);

            if ($clase!=null) {
                $clase->setNombre($params->nombre);
                $clase->setCodigo($params->codigo);
                $clase->setTipoVehiculo($tipoVehiculo);
                $clase->setActivo(true);

                $em = $this->getDoctrine()->getManager();
                $em->persist($clase);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Clase editada con éxito", 
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "La clase no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorización no válida", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a Clase entity.
     *
     * @Route("/{id}/delete", name="vhlocfgclase_delete")
     * @Method({"GET","POST"})
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $clase = $em->getRepository('JHWEBVehiculoBundle:VhloCfgClase')->find($id);

            $clase->setActivo(false);
            $em = $this->getDoctrine()->getManager();
            $em->persist($clase);
            $em->flush();
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro eliminado con éxito", 
                );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida", 
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a VhloCfgClase entity.
     *
     * @param VhloCfgClase $vhloCfgclase The VhloCfgClase entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloCfgClase $vhloCfgclase)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhlocfgclase_delete', array('id' => $vhloCfgclase->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="vhlocfgclase_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $clases = $em->getRepository('JHWEBVehiculoBundle:VhloCfgClase')->findBy(
        array('activo' => 1)
    );
    $response= null;
      foreach ($clases as $key => $clase) {
        $response[$key] = array(
            'value' => $clase->getId(),
            'label' => $clase->getCodigo()."_".$clase->getNombre(),
            );
      }
       return $helpers->json($response);
    }

    /**
     * datos para select 2 por modulo
     *
     * @Route("/select/modulo", name="vhlocfgclase_select_modulo")
     * @Method({"GET", "POST"})
     */
    public function selectByModuloAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        $em = $this->getDoctrine()->getManager();

        $json = $request->get("data",null);
        $params = json_decode($json);

        $clases = $em->getRepository('JHWEBVehiculoBundle:VhloCfgClase')->getByModulo($params->idModulo);
        
        $response = null;

        foreach ($clases as $key => $clase) {
            $response[$key] = array(
                'value' => $clase->getId(),
                'label' => $clase->getNombre(),
            );
        }
        
        return $helpers->json($response);
    }

    
    /**
     * datos para select 2
     *
     * @Route("/maquinaria/select", name="vhlocfgclase_maquinaria_select")
     * @Method({"GET", "POST"})
     */
    public function maquinariaSelectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $clases = $em->getRepository('JHWEBVehiculoBundle:VhloCfgClase')->findBy(
            array(
                'estado' => 1,
                'modulo'=> 3
            )
        );

        $response = null;
        foreach ($clases as $key => $clase) {
            $response[$key] = array(
                'value' => $clase->getId(),
                'label' => $clase->getCodigoMt()."_".$clase->getNombre(),
            );
        }

        return $helpers->json($response);
    }
}
