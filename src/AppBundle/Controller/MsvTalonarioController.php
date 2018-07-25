<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MsvTalonario;
use AppBundle\Entity\MsvTConsecutivo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Msvtalonario controller.
 *
 * @Route("msvtalonario")
 */
class MsvTalonarioController extends Controller
{
    /**
     * Lists all msvTalonario entities.
     *
     * @Route("/", name="msvtalonario_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $msvTalonarios = $em->getRepository('AppBundle:MsvTalonario')->findBy(
            array('estado' => true)
        );
        
        $response['data'] = array();

        if ($msvTalonarios) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => 'listado talonarios',
                'data' => $msvTalonarios,
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a new msvTalonario entity.
     *
     * @Route("/new", name="msvtalonario_new")
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
            $sedeOperativaId = $params->sedeOperativaId;
            $sedeOperativa = $em->getRepository('AppBundle:SedeOperativa')->find($sedeOperativaId);
           
            $msvTalonario = new MsvTalonario();
            

            $talonario = $em->getRepository('AppBundle:MsvTalonario')->findOneBySedeOperativa(
                $sedeOperativaId
            );

            if ($talonario) {
                $talonario->setSedeOperativa($sedeOperativa);
                $talonario->setrangoini($params->rangoini);
                $talonario->setrangofin($params->rangofin);
                $talonario->setTotal($params->total);
                $talonario->setFechaAsignacion(new \Datetime($params->fechaAsignacion));
                $talonario->setNResolucion($params->nResolucion);
                $talonario->setEstado(true);
                

                $em = $this->getDoctrine()->getManager();
                $em->flush();

                $divipo = $sedeOperativa->getCodigoDivipo();

                for ($consecutivo = $talonario->getRangoini(); $consecutivo <= $talonario->getRangoFin(); $consecutivo++) { 

                    $longitud = (20 - (strlen($divipo)+strlen($consecutivo)));
                    if ($longitud < 20) {
                        $nuevoConsecutivo = $divipo.str_pad($consecutivo, $longitud, '0', STR_PAD_LEFT);
                    }else{
                        $nuevoConsecutivo = $divipo.$consecutivo;
                    }
                
                    $msvTConsecutivo = new MsvTConsecutivo();

                    $msvTConsecutivo->setMsvTalonario($talonario);
                    $msvTConsecutivo->setConsecutivo($nuevoConsecutivo);
                    $msvTConsecutivo->setSedeOperativa($sedeOperativa);
                    $msvTConsecutivo->setActivo(true);
                    $msvTConsecutivo->setEstado(true);

                    $em->persist($msvTConsecutivo);
                    $em->flush();
                }
            }else{
                $msvTalonario->setSedeOperativa($sedeOperativa);
                $msvTalonario->setrangoini($params->rangoini);
                $msvTalonario->setrangofin($params->rangofin);
                $msvTalonario->setTotal($params->total);
                $msvTalonario->setFechaAsignacion(new \Datetime($params->fechaAsignacion));
                $msvTalonario->setNResolucion($params->nResolucion);
                $msvTalonario->setEstado(true);
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($msvTalonario);
                $em->flush();              
            }
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro creado con exito", 
                );
            // }
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
     * Finds and displays a msvTalonario entity.
     *
     * @Route("/{id}", name="msvtalonario_show")
     * @Method("POST")
     */
    public function showAction(Request $request, MsvTalonario $msvTalonario)
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
                    'data'=> $msvTalonario,
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
     * Buscar talonarios pro sede operativa .
     *
     * @Route("/find/talonarios/sedeOperativa/{id}", name="msvtalonario_find_talonarios_sedeOperativa")
     * @Method("POST")
     */
    public function findTalonariosSedeAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $em = $this->getDoctrine()->getManager();

        if ($authCheck == true) {
            $talonario = $em->getRepository('AppBundle:MsvTalonario')->findOneBySedeOperativa($id);
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro encontrado", 
                    'data'=> $talonario,
            );
            if ($talonario == null) {
                $response = array(
                    'status' => 'vacio',
                    'code' => 300,
                    'msj' => "Registro no encontrado", 
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

    /**
     * Displays a form to edit an existing msvTalonario entity.
     *
     * @Route("/edit", name="msvtalonario_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MsvTalonario $msvTalonario)
    {
        $deleteForm = $this->createDeleteForm($msvTalonario);
        $editForm = $this->createForm('AppBundle\Form\MsvTalonarioType', $msvTalonario);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('msvtalonario_edit', array('id' => $msvTalonario->getId()));
        }

        return $this->render('msvtalonario/edit.html.twig', array(
            'msvTalonario' => $msvTalonario,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a msvTalonario entity.
     *
     * @Route("/{id}/delete", name="msvtalonario_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, MsvTalonario $msvTalonario)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $msvTalonario = $em->getRepository('AppBundle:MsvTalonario')->find($msvTalonario);
            $msvTalonario->setEstado(0);

            $em = $this->getDoctrine()->getManager();
                $em->persist($msvTalonario);
                $em->flush();
            $response = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "lase eliminado con exito", 
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
     * Creates a form to delete a msvTalonario entity.
     *
     * @param MsvTalonario $msvTalonario The msvTalonario entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MsvTalonario $msvTalonario)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('msvtalonario_delete', array('id' => $msvTalonario->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
