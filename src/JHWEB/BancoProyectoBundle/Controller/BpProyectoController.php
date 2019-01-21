<?php

namespace JHWEB\BancoProyectoBundle\Controller;

use JHWEB\BancoProyectoBundle\Entity\BpProyecto;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Bpproyecto controller.
 *
 * @Route("bpproyecto")
 */
class BpProyectoController extends Controller
{
    /**
     * Lists all BpProyecto entities.
     *
     * @Route("/", name="bpProyecto_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $proyectos = $em->getRepository('JHWEBBancoProyectoBundle:BpProyecto')->findBy(
            array('activo' => 1)
        );

        $response['data'] = array();

        $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "listado proyectos", 
                    'data'=> $proyectos,
            );
         
        return $helpers->json($response);
    }

    /**
     * Creates a new BpProyecto entity.
     *
     * @Route("/new", name="bpProyecto_new")
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

            $proyecto = new BpProyecto();

            $proyecto->setNumero($params->numero);
            $proyecto->setNombre($params->nombre);
            $proyecto->setFecha(new \Datetime($params->fecha));
            $proyecto->setNumeroCuota($params->numeroCuota);
            $proyecto->setNombreCuota($params->nombreCuota);
            $proyecto->setCostoValor($params->costoValor);
            $proyecto->setActivo(true);

            $em->persist($proyecto);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "BpProyecto creado con exito", 
                'data' => $proyecto
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
     * Finds and displays a BpProyecto entity.
     *
     * @Route("/show/{id}", name="bpProyecto_show")
     * @Method("POST")
     */
    public function showAction(Request  $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $proyecto = $em->getRepository('JHWEBBancoProyectoBundle:BpProyecto')->find($id);
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "bpProyecto encontrado", 
                    'data'=> $proyecto,
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
     * Displays a form to edit an existing BpProyecto entity.
     *
     * @Route("/edit", name="bpProyecto_edit")
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
            $proyecto = $em->getRepository("JHWEBBancoProyectoBundle:BpProyecto")->find($params->id);

            if ($proyecto!=null) {
                
                $proyecto->setNumero($params->numero);
                $proyecto->setNombre($params->nombre);
                $proyecto->setFecha(new \Datetime($params->fecha));
                $proyecto->setNumeroCuota($params->numeroCuota);
                $proyecto->setNombreCuota($params->nombreCuota);
                $proyecto->setCostoValor($params->costoValor);

                $em->persist($proyecto);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "BpProyecto editado con éxito", 
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El bpProyecto no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorizacion no valida para editar banco", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a BpProyecto entity.
     *
     * @Route("/{id}/delete", name="bpProyecto_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $proyecto = $em->getRepository('JHWEBBancoProyectoBundle:BpProyecto')->find($id);

            $proyecto->setActivo(false);
            $em = $this->getDoctrine()->getManager();
                $em->persist($proyecto);
                $em->flush();
            $response = array(
                    'status' => 'success',
                        'code' => 200,
                        'message' => "bpProyecto eliminado con éxito", 
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
     * Creates a form to delete a BpProyecto entity.
     *
     * @param BpProyecto $proyecto The BpProyecto entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BpProyecto $proyecto)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bpProyecto_delete', array('id' => $proyecto->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * busca los bpProyectos de un tramite.
     *
     * @Route("/showBpProyectos/{id}", name="bpProyecto_tramites_show")
     * @Method("POST")
     */
    public function showBpProyectosAction(Request  $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $proyectos = $em->getRepository('JHWEBBancoProyectoBundle:BpProyecto')->findBy(
            array('estado' => 1,'tramite'=> $id)
            );

            if ($proyectos) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "bpProyectos encontrado", 
                    'data'=> $proyectos,
                ); 
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No hay bpProyectos asigandos a este tramite", 
                );
            }
            
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
            );
        }
        return $helpers->json($response);
    }
}
