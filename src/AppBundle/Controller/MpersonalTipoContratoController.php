<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MpersonalTipoContrato;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Mpersonaltipocontrato controller.
 *
 * @Route("mpersonaltipocontrato")
 */
class MpersonalTipoContratoController extends Controller
{
    /**
     * Lists all mpersonalTipoContrato entities.
     *
     * @Route("/", name="mpersonaltipocontrato_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $tiposContrato = $em->getRepository('AppBundle:MpersonalTipoContrato')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($tiposContrato) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => count($tiposContrato)." Registros encontrados", 
                'data'=> $tiposContrato,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new mpersonalTipoContrato entity.
     *
     * @Route("/new", name="mpersonaltipocontrato_new")
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
                    'message' => "los campos no pueden estar vacios", 
                );
            }else{*/
                $tipoContrato = new MpersonalTipoContrato();

                $tipoContrato->setNombre($params->nombre);
                $tipoContrato->setHorarios($params->horarios);
                $tipoContrato->setActivo(true);

                $em = $this->getDoctrine()->getManager();
                $em->persist($tipoContrato);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro creado con exito",
                );
            //}
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
     * Finds and displays a mpersonalTipoContrato entity.
     *
     * @Route("/{id}/show", name="mpersonaltipocontrato_show")
     * @Method("GET")
     */
    public function showAction(MpersonalTipoContrato $mpersonalTipoContrato)
    {
        $deleteForm = $this->createDeleteForm($mpersonalTipoContrato);

        return $this->render('mpersonaltipocontrato/show.html.twig', array(
            'mpersonalTipoContrato' => $mpersonalTipoContrato,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing mpersonalTipoContrato entity.
     *
     * @Route("/edit", name="mpersonaltipocontrato_edit")
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
            $tipoContrato = $em->getRepository("AppBundle:MpersonalTipoContrato")->find($params->id);

            if ($tipoContrato!=null) {
                $tipoContrato->setNombre($params->nombre);
                $tipoContrato->setHorarios($params->horarios);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $tipoContrato,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorizacion no valida para editar", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a mpersonalTipoContrato entity.
     *
     * @Route("/{id}/delete", name="mpersonaltipocontrato_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MpersonalTipoContrato $mpersonalTipoContrato)
    {
        $form = $this->createDeleteForm($mpersonalTipoContrato);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mpersonalTipoContrato);
            $em->flush();
        }

        return $this->redirectToRoute('mpersonaltipocontrato_index');
    }

    /**
     * Creates a form to delete a mpersonalTipoContrato entity.
     *
     * @param MpersonalTipoContrato $mpersonalTipoContrato The mpersonalTipoContrato entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MpersonalTipoContrato $mpersonalTipoContrato)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mpersonaltipocontrato_delete', array('id' => $mpersonalTipoContrato->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="mpersonaltipocontrato_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $tiposContrato = $em->getRepository('AppBundle:MpersonalTipoContrato')->findBy(
            array('activo' => true)
        );
        $response= null;
        foreach ($tiposContrato as $key => $tipoContrato) {
            $response[$key] = array(
                'value' => $tipoContrato->getId(),
                'label' => $tipoContrato->getNombre()
            );
        }
        return $helpers->json($response);
    }
}
