<?php

namespace JHWEB\BancoProyectoBundle\Controller;

use JHWEB\BancoProyectoBundle\Entity\BpRecurso;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Bprecurso controller.
 *
 * @Route("bprecurso")
 */
class BpRecursoController extends Controller
{
   /**
     * Lists all BpRecurso entities.
     *
     * @Route("/", name="bpRecurso_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $bpRecursos = $em->getRepository('JHWEBBancoProyectoBundle:BpRecurso')->findBy(
            array('estado' => 1)
        );
        $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado bpRecursos", 
                    'data'=> $bpRecursos,
            );
         
        return $helpers->json($response);
    }

    /**
     * Creates a new BpRecurso entity.
     *
     * @Route("/new", name="bpRecurso_new")
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
                if ($tramite==null) {
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'msj' => "no existe el tramite", 
                    );
                }else{
                    $bpRecurso = new BpRecurso();

                    $bpRecurso->setNombre($params->nombre);
                    $bpRecurso->setCantidadMedida($params->cantidadMedida);
                    $bpRecurso->setCantidad($params->cantidad);
                    $bpRecurso->setValorUnitario($params->valorUnitario);
                    $bpRecurso->setValorTotal($params->valorTotal);
                    $bpRecurso->setTipo($params->tipo);

                    $em = $this->getDoctrine()->getManager();
                    $bpActividad = $em->getRepository('JHWEBBancoProyectoBundle:BpActividad')->find($params->bpActividadId);
                    $bpRecurso->setBpActividad($bpActividad);
                    $bpRecurso->setActivo(true);

                    $em->persist($bpRecurso);
                    $em->flush();

                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "BpRecurso creado con exito", 
                    );
                }
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
     * Finds and displays a BpRecurso entity.
     *
     * @Route("/show/{id}", name="bpRecurso_show")
     * @Method("POST")
     */
    public function showAction(Request  $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $bpRecurso = $em->getRepository('JHWEBBancoProyectoBundle:BpRecurso')->find($id);
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "bpRecurso encontrado", 
                    'data'=> $bpRecurso,
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
     * Displays a form to edit an existing BpRecurso entity.
     *
     * @Route("/edit", name="bpRecurso_edit")
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

            
            $bpRecurso = $em->getRepository("JHWEBBancoProyectoBundle:BpRecurso")->find($params->id);

            if ($bpRecurso!=null) {
                $bpRecurso->setNombre($params->nombre);
                $bpRecurso->setCantidadMedida($params->cantidadMedida);
                $bpRecurso->setCantidad($params->cantidad);
                $bpRecurso->setValorUnitario($params->valorUnitario);
                $bpRecurso->setValorTotal($params->valorTotal);
                $bpRecurso->setTipo($params->tipo);

                $em = $this->getDoctrine()->getManager();
                $bpActividad = $em->getRepository('JHWEBBancoProyectoBundle:BpActividad')->find($params->bpActividadId);
                $bpRecurso->setBpActividad($bpActividad);
                $bpRecurso->setActivo(true);
                
                $em->persist($bpRecurso);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "BpRecurso editado con exito", 
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El bpRecurso no se encuentra en la base de datos", 
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
     * Deletes a BpRecurso entity.
     *
     * @Route("/{id}/delete", name="bpRecurso_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $bpRecurso = $em->getRepository('JHWEBBancoProyectoBundle:BpRecurso')->find($id);
            $bpRecurso->setActivo(false);
            $em = $this->getDoctrine()->getManager();
            $em->persist($bpRecurso);
            $em->flush();
            $response = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "bpRecurso eliminado con exito", 
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
     * Creates a form to delete a BpRecurso entity.
     *
     * @param BpRecurso $bpRecurso The BpRecurso entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BpRecurso $bpRecurso)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bpRecurso_delete', array('id' => $bpRecurso->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * busca los bpRecursos de un tramite.
     *
     * @Route("/showBpRecursos/{id}", name="bpRecurso_tramites_show")
     * @Method("POST")
     */
    public function showBpRecursosAction(Request  $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $bpRecursos = $em->getRepository('JHWEBBancoProyectoBundle:BpRecurso')->findBy(
            array('estado' => 1,'tramite'=> $id)
            );

            if ($bpRecursos==null) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "No hay bpRecursos asigandos a este tramite", 
                );
            }
            else{
               $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "bpRecursos encontrado", 
                    'data'=> $bpRecursos,
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
