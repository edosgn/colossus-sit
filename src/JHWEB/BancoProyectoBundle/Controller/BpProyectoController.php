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
        $bpProyectos = $em->getRepository('JHWEBBancoProyectoBundle:BpProyecto')->findBy(
            array('activo' => 1)
        );
        $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado bpProyectos", 
                    'data'=> $bpProyectos,
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
            $json = $request->get("json",null);
            $params = json_decode($json);

            /*if (count($params)==0) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "los campos no pueden estar vacios", 
                );
            }else{*/
             
            $bpProyecto = new BpProyecto();

            $bpProyecto->setNumero($params->numero);
            $bpProyecto->setNombre($params->nombre);
            $bpProyecto->setFecha(new \Datetime($params->fecha));
            $bpProyecto->setNumeroCuota($params->numeroCuota);
            $bpProyecto->setNombreCuota($params->nombreCuota);
            $bpProyecto->setCostoValor($params->costoValor);
            $bpProyecto->setActivo(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($bpProyecto);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "BpProyecto creado con exito", 
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
            $bpProyecto = $em->getRepository('JHWEBBancoProyectoBundle:BpProyecto')->find($id);
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "bpProyecto encontrado", 
                    'data'=> $bpProyecto,
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
            $bpProyecto = $em->getRepository("JHWEBBancoProyectoBundle:BpProyecto")->find($params->id);

            if ($bpProyecto!=null) {
                
                $bpProyecto->setNumero($params->numero);
                $bpProyecto->setNombre($params->nombre);
                $bpProyecto->setFecha(new \Datetime($params->fecha));
                $bpProyecto->setNumeroCuota($params->numeroCuota);
                $bpProyecto->setNombreCuota($params->nombreCuota);
                $bpProyecto->setCostoValor($params->costoValor);

                $em->persist($bpProyecto);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "BpProyecto editado con éxito", 
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El bpProyecto no se encuentra en la base de datos", 
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
            $bpProyecto = $em->getRepository('JHWEBBancoProyectoBundle:BpProyecto')->find($id);

            $bpProyecto->setActivo(false);
            $em = $this->getDoctrine()->getManager();
                $em->persist($bpProyecto);
                $em->flush();
            $response = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "bpProyecto eliminado con éxito", 
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
     * Creates a form to delete a BpProyecto entity.
     *
     * @param BpProyecto $bpProyecto The BpProyecto entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BpProyecto $bpProyecto)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bpProyecto_delete', array('id' => $bpProyecto->getId())))
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
            $bpProyectos = $em->getRepository('JHWEBBancoProyectoBundle:BpProyecto')->findBy(
            array('estado' => 1,'tramite'=> $id)
            );

            if ($bpProyectos==null) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "No hay bpProyectos asigandos a este tramite", 
                );
            }
            else{
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "bpProyectos encontrado", 
                    'data'=> $bpProyectos,
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
