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

                foreach ($params->dias as $key => $dias) {
                    foreach ($dias as $numero => $dia) {
                        $horario = new MpersonalHorario();
                        if ($params->manana) {
                            $horario->setHoraInicio(new \Datetime($params->horaInicioManana));
                            $horario->setHoraFin(new \Datetime($params->horaFinManana));
                            $horario->setDia($numero);
                            $horario->setJornada('Mañana');
                            $horario->setFuncionario($funcionario);
                            $em->persist($horario);
                            $em->flush();
                        }

                        if ($params->tarde) {
                            $horario->setHoraInicio(new \Datetime($params->horaInicioTarde));
                            $horario->setHoraFin(new \Datetime($params->horaFinTarde));
                            $horario->setDia($numero);
                            $horario->setJornada('Tarde');
                            $horario->setFuncionario($funcionario);
                            $em->persist($horario);
                            $em->flush();
                        }
                        
                        if ($params->noche) {
                            $horario->setHoraInicio(new \Datetime($params->horaInicioNoche));
                            $horario->setHoraFin(new \Datetime($params->horaFinNoche));
                            $horario->setDia($numero);
                            $horario->setJornada('Noche');
                            $horario->setFuncionario($funcionario);
                            $em->persist($horario);
                            $em->flush();
                        }
                    }
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
