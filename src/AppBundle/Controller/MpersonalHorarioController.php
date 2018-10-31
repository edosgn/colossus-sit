<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MpersonalHorario;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Mpersonalhorario controller.
 *
 * @Route("mpersonalhorario")
 */
class MpersonalHorarioController extends Controller
{
    /**
     * Lists all mpersonalHorario entities.
     *
     * @Route("/", name="mpersonalhorario_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $mpersonalHorarios = $em->getRepository('AppBundle:MpersonalHorario')->findAll();

        return $this->render('mpersonalhorario/index.html.twig', array(
            'mpersonalHorarios' => $mpersonalHorarios,
        ));
    }

    /**
     * Creates a new mpersonalHorario entity.
     *
     * @Route("/new", name="mpersonalhorario_new")
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
                $em = $this->getDoctrine()->getManager();

                $funcionario = $em->getRepository('AppBundle:MpersonalFuncionario')->find(
                    $params->funcionarioId
                );

                

               
                        
                if ($params->manana) {
                    $horarioMañana = new MpersonalHorario();
                    $horarioMañana->setHoraInicio(new \Datetime($params->horaInicioManana));
                    $horarioMañana->setHoraFin(new \Datetime($params->horaFinManana));
                    $horarioMañana->setFecha(new \Datetime($params->fecha));
                    $horarioMañana->setJornada('Mañana');
                    $horarioMañana->setFuncionario($funcionario);
                    $horarioMañana->setLugar($params->lugarManana);
                    $em->persist($horarioMañana);
                    $em->flush();
                }

                if ($params->tarde) {
                    $horarioTarde = new MpersonalHorario();
                    $horarioTarde->setHoraInicio(new \Datetime($params->horaInicioTarde));
                    $horarioTarde->setHoraFin(new \Datetime($params->horaFinTarde));
                    $horarioTarde->setFecha(new \Datetime($params->fecha));
                    $horarioTarde->setJornada('Tarde');
                    $horarioTarde->setFuncionario($funcionario);
                    $horarioTarde->setLugar($params->lugarTarde);
                    $em->persist($horarioTarde);
                    $em->flush();
                }
                
                if ($params->noche) {
                    $horarioNoche = new MpersonalHorario();
                    $horarioNoche->setHoraInicio(new \Datetime($params->horaInicioNoche));
                    $horarioNoche->setHoraFin(new \Datetime($params->horaFinNoche));
                    $horarioNoche->setFecha(new \Datetime($params->fecha));
                    $horarioNoche->setJornada('Noche');
                    $horarioNoche->setFuncionario($funcionario);
                    $horarioNoche->setLugar($params->lugarNoche);
                    $em->persist($horarioNoche);
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
     * Finds and displays a mpersonalHorario entity.
     *
     * @Route("/{id}", name="mpersonalhorario_show")
     * @Method("GET")
     */
    public function showAction(MpersonalHorario $mpersonalHorario)
    {
        $deleteForm = $this->createDeleteForm($mpersonalHorario);

        return $this->render('mpersonalhorario/show.html.twig', array(
            'mpersonalHorario' => $mpersonalHorario,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing mpersonalHorario entity.
     *
     * @Route("/{id}/edit", name="mpersonalhorario_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MpersonalHorario $mpersonalHorario)
    {
        $deleteForm = $this->createDeleteForm($mpersonalHorario);
        $editForm = $this->createForm('AppBundle\Form\MpersonalHorarioType', $mpersonalHorario);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mpersonalhorario_edit', array('id' => $mpersonalHorario->getId()));
        }

        return $this->render('mpersonalhorario/edit.html.twig', array(
            'mpersonalHorario' => $mpersonalHorario,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a mpersonalHorario entity.
     *
     * @Route("/{id}", name="mpersonalhorario_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MpersonalHorario $mpersonalHorario)
    {
        $form = $this->createDeleteForm($mpersonalHorario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mpersonalHorario);
            $em->flush();
        }

        return $this->redirectToRoute('mpersonalhorario_index');
    }

    /**
     * Creates a form to delete a mpersonalHorario entity.
     *
     * @param MpersonalHorario $mpersonalHorario The mpersonalHorario entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MpersonalHorario $mpersonalHorario)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mpersonalhorario_delete', array('id' => $mpersonalHorario->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
