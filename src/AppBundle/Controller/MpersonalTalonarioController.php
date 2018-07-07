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

            /*if (count($params)==0) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "los campos no pueden estar vacios", 
                );
            }else{*/
                $talonario = new MpersonalTalonario();

                $em = $this->getDoctrine()->getManager();

                $talonario->setDesde($params->desde);
                $talonario->setHasta($params->hasta);
                $talonario->setRangos(($params->hasta + 1) - $params->desde);
                $talonario->setFechaAsignacion(new \Datetime($params->fechaAsignacion));
                $talonario->setNumeroResolucion($params->numeroResolucion);
                
                $sedeOperativa = $em->getRepository('AppBundle:SedeOperativa')->find(
                    $params->sedeOperativaId
                );
                $talonario->setSedeOperativa($sedeOperativa);

                $em->persist($talonario);
                $em->flush();

                $divipo = $sedeOperativa->getCodigoDivipo();
                for ($consecutivo=$talonario->getDesde(); $consecutivo <= $talonario->getHasta(); $consecutivo++) {
                    $longitud = (20 - (strlen($divipo)+strlen($consecutivo)));
                    if ($longitud < 20) {
                        $numeroComparendo = $divipo.str_pad($consecutivo, $longitud, '0', STR_PAD_LEFT);
                    }else{
                        $numeroComparendo = $divipo.$consecutivo;
                    }

                    $comparendo = new MpersonalComparendo();

                    $comparendo->setTalonario($talonario);
                    $comparendo->setConsecutivo($numeroComparendo);
                    $comparendo->setSedeOperativa($sedeOperativa);
                    $comparendo->setEstado('Disponible');

                    $em->persist($comparendo);
                    $em->flush();
                }

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
     * @Route("/{id}/edit", name="mpersonaltalonario_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MpersonalTalonario $mpersonalTalonario)
    {
        $deleteForm = $this->createDeleteForm($mpersonalTalonario);
        $editForm = $this->createForm('AppBundle\Form\MpersonalTalonarioType', $mpersonalTalonario);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mpersonaltalonario_edit', array('id' => $mpersonalTalonario->getId()));
        }

        return $this->render('mpersonaltalonario/edit.html.twig', array(
            'mpersonalTalonario' => $mpersonalTalonario,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
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
