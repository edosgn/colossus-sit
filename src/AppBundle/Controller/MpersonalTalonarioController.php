<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MpersonalTalonario;
use AppBundle\Entity\MpersonalComparendo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Mpersonaltalonario controller.
 *
 * @Route("mpersonaltalonario")
 */
class MpersonalTalonarioController extends Controller
{
    /**
     * Lists all mpersonalTalonario entities.
     *
     * @Route("/", name="mpersonaltalonario_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $talonarios = $em->getRepository('AppBundle:MpersonalTalonario')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($talonarios) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => count($talonarios)." Registros encontrados", 
                'data'=> $talonarios,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new mpersonalTalonario entity.
     *
     * @Route("/new", name="mpersonaltalonario_new")
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

            $talonario = new MpersonalTalonario();

            $em = $this->getDoctrine()->getManager();

            $sedeOperativa = $em->getRepository('AppBundle:SedeOperativa')->find(
                $params->sedeOperativaId
            );
            $talonario->setSedeOperativa($sedeOperativa);

            if ($sedeOperativa->getAsignacionRango()) {
                $talonario->setDesde($sedeOperativa->getCodigoDivipo().$params->desde);
                $talonario->setHasta($sedeOperativa->getCodigoDivipo().$params->hasta);
            }else {
                $talonario->setDesde($params->desde);
                $talonario->setHasta($params->hasta);
            }
            
            $talonario->setRangos($params->rangos);
            $talonario->setFechaAsignacion(new \Datetime($params->fechaAsignacion));
            $talonario->setNumeroResolucion($params->numeroResolucion);
            
            $em->persist($talonario);
            $em->flush();

            $divipo = $sedeOperativa->getCodigoDivipo();
            
            for ($consecutivo = $talonario->getDesde(); $consecutivo <= $talonario->getHasta(); $consecutivo++) {
                
                $comparendo = new MpersonalComparendo();

                $comparendo->setTalonario($talonario);
                $comparendo->setConsecutivo($divipo.$consecutivo);
                $comparendo->setSedeOperativa($sedeOperativa);
                $comparendo->setEstado('DISPONIBLE');
                $comparendo->setActivo(true);

                $em->persist($comparendo);
                $em->flush();
            }

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "El registro se ha realizado con exito",
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no valida",
            );
        } 
        return $helpers->json($response);
    }

    /**
     * Finds and displays a mpersonalTalonario entity.
     *
     * @Route("/{id}", name="mpersonaltalonario_show")
     * @Method("GET")
     */
    public function showAction(MpersonalTalonario $mpersonalTalonario)
    {
        $deleteForm = $this->createDeleteForm($mpersonalTalonario);

        return $this->render('mpersonaltalonario/show.html.twig', array(
            'mpersonalTalonario' => $mpersonalTalonario,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing mpersonalTalonario entity.
     *
     * @Route("/edit", name="mpersonaltalonario_edit")
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

            $talonario = $em->getRepository("AppBundle:MpersonalTalonario")->find(
                $params->id
            );

            if ($talonario!=null) {
                $talonario->setDesde($params->desde);
                $talonario->setHasta($params->hasta);
                $talonario->setRangos($params->rangos);
                $talonario->setFechaAsignacion(new \Datetime($params->fechaAsignacion));
                $talonario->setNumeroResolucion($params->numeroResolucion);
                
                $sedeOperativa = $em->getRepository('AppBundle:SedeOperativa')->find(
                    $params->sedeOperativaId
                );
                $talonario->setSedeOperativa($sedeOperativa);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro actualizado con exito", 
                    'data'=> $talonario,
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
                'msj' => "Autorizacion no valida para editar", 
            );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a mpersonalTalonario entity.
     *
     * @Route("/{id}", name="mpersonaltalonario_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MpersonalTalonario $mpersonalTalonario)
    {
        $form = $this->createDeleteForm($mpersonalTalonario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mpersonalTalonario);
            $em->flush();
        }

        return $this->redirectToRoute('mpersonaltalonario_index');
    }

    /**
     * Creates a form to delete a mpersonalTalonario entity.
     *
     * @param MpersonalTalonario $mpersonalTalonario The mpersonalTalonario entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MpersonalTalonario $mpersonalTalonario)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mpersonaltalonario_delete', array('id' => $mpersonalTalonario->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
