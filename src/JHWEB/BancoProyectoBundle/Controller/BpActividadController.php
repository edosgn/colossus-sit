<?php

namespace JHWEB\BancoProyectoBundle\Controller;

use JHWEB\BancoProyectoBundle\Entity\BpActividad;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Bpactividad controller.
 *
 * @Route("bpactividad")
 */
class BpActividadController extends Controller
{
   /**
     * Lists all BpActividad entities.
     *
     * @Route("/", name="bpActividad_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $bpActividads = $em->getRepository('JHWEBBancoProyectoBundle:BpActividad')->findBy(
            array('estado' => 1)
        );
        $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado bpActividads", 
                    'data'=> $bpActividads,
            );
         
        return $helpers->json($response);
    }

    /**
     * Creates a new BpActividad entity.
     *
     * @Route("/new", name="bpActividad_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);
           
            $em = $this->getDoctrine()->getManager();

            $actividad = new BpCdp();


            $actividad->setNombre($params->nombre);
            $actividad->setUnidadMedida($params->unidadMedida);
            $actividad->setCantidad($params->cantidad);
            $actividad->setCostoUnitario($params->costoUnitario);
            $actividad->setCostoTotal($params->costoTotal);
            $actividad->setActivo(true);

            if ($params->idProyecto) {
                $proyecto = $em->getRepository('JHWEBBancoProyectoBundle:BpProyecto')->find($params->idProyecto);
                $actividad->setProyecto($proyecto);
            }

            $em->persist($actividad);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con exito",
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Finds and displays a BpActividad entity.
     *
     * @Route("/show/{id}", name="bpActividad_show")
     * @Method("POST")
     */
    public function showAction(Request  $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $bpActividad = $em->getRepository('JHWEBBancoProyectoBundle:BpActividad')->find($id);
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "bpActividad encontrado", 
                    'data'=> $bpActividad,
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
     * Displays a form to edit an existing BpActividad entity.
     *
     * @Route("/edit", name="bpActividad_edit")
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

            
            $bpActividad = $em->getRepository("JHWEBBancoProyectoBundle:BpActividad")->find($params->id);

            if ($bpActividad!=null) {
                $bpActividad->setNombre($params->nombre);
                $bpActividad->setUnidadMedida($params->unidadMedida);
                $bpActividad->setCantidad($params->cantidad);
                $bpActividad->setCostoUnitario($params->costoUnitario);
                $bpActividad->setCostoTotal($params->costoTotal);
                $em = $this->getDoctrine()->getManager();
                $bpProyecto = $em->getRepository('JHWEBBancoProyectoBundle:BpProyecto')->find($params->bpProyectoId);
                $bpActividad->setBpProyecto($bpProyecto);
                $bpActividad->setActivo(true);

                $em->persist($bpActividad);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "BpActividad editado con exito", 
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El bpActividad no se encuentra en la base de datos", 
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
     * Deletes a BpActividad entity.
     *
     * @Route("/{id}/delete", name="bpActividad_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $bpActividad = $em->getRepository('JHWEBBancoProyectoBundle:BpActividad')->find($id);

            $bpActividad->setActivo(false);
            $em = $this->getDoctrine()->getManager();
                $em->persist($bpActividad);
                $em->flush();
            $response = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "bpActividad eliminado con exito", 
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
     * Creates a form to delete a BpActividad entity.
     *
     * @param BpActividad $bpActividad The BpActividad entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BpActividad $bpActividad)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bpActividad_delete', array('id' => $bpActividad->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * busca los bpActividads de un tramite.
     *
     * @Route("/showBpActividads/{id}", name="bpActividad_tramites_show")
     * @Method("POST")
     */
    public function showBpActividadsAction(Request  $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $bpActividads = $em->getRepository('JHWEBBancoProyectoBundle:BpActividad')->findBy(
            array('estado' => 1,'tramite'=> $id)
            );

            if ($bpActividads==null) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "No hay bpActividads asigandos a este tramite", 
                );
            }
            else{
               $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "bpActividads encontrado", 
                    'data'=> $bpActividads,
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
