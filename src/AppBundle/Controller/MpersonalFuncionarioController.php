<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MpersonalFuncionario;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Mpersonalfuncionario controller.
 *
 * @Route("mpersonalfuncionario")
 */
class MpersonalFuncionarioController extends Controller
{
    /**
     * Lists all mpersonalFuncionario entities.
     *
     * @Route("/", name="mpersonalfuncionario_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $mpersonalFuncionarios = $em->getRepository('AppBundle:MpersonalFuncionario')->findAll();

        return $this->render('mpersonalfuncionario/index.html.twig', array(
            'mpersonalFuncionarios' => $mpersonalFuncionarios,
        ));
    }

    /**
     * Creates a new mpersonalFuncionario entity.
     *
     * @Route("/new", name="mpersonalfuncionario_new")
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

            var_dump($params);
            die();

            /*if (count($params)==0) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "los campos no pueden estar vacios", 
                );
            }else{*/
                $funcionario = new MpersonalFuncionario();

                $em = $this->getDoctrine()->getManager();

                $usuario = $em->getRepository('UsuarioBundle:Usuario')->findOneByIdentificacion(
                    $params->identificacion
                );
                $ciudadano = $em->getRepository('AppBundle:Ciudadano')->findOneByUsuario(
                    $usuario->getId()
                );
                $funcionario->setCiudadano($ciudadano);

                $funcionario->setCargo($params->nombre);
                $sedeOperativa = $em->getRepository('AppBundle:SedeOperativa')->find(
                    $params->sedeOperativaId
                );
                $funcionario->setSedeOperativa($sedeOperativa);

                $tipoContrato = $em->getRepository('AppBundle:MpersonalTipoContrato')->find(
                    $params->tipoContratoId
                );
                $funcionario->setTipoContrato($tipoContrato);

                $ciudadano = $em->getRepository('AppBundle:Ciudadano')->find(
                    $params->ciudadanoId
                );
                $funcionario->setCiudadano($ciudadano);

                if ($params->inhabilidad == 'true') {
                    $funcionario->setActivo(false);
                    $funcionario->setInhabilidad($params->inhabilidad);
                }else{
                    $funcionario->setActivo(true);
                }

                if ($params->actaPosesion) {
                    $funcionario->setActaPosesion($params->actaPosesion);
                }

                if ($params->resolucion) {
                    $funcionario->setResolucion($params->resolucion);
                }

                if ($params->tipoNombramiento) {
                    $funcionario->setTipoNombramiento($params->tipoNombramiento);
                }

                if ($params->fechaInicio) {
                    $funcionario->setFechaInicio(new \Datetime($params->fechaInicio));
                }

                if ($params->fechaFin) {
                    $funcionario->setFechaFin(new \Datetime($params->fechaFin));
                }

                if ($params->numeroContrato) {
                    $funcionario->setNumeroContrato($params->numeroContrato);
                }

                if ($params->numeroPlaca) {
                    $funcionario->setNumeroPlaca($params->numeroPlaca);
                }

                $em->persist($funcionario);
                $em->flush();

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
     * Finds and displays a mpersonalFuncionario entity.
     *
     * @Route("/{id}/show", name="mpersonalfuncionario_show")
     * @Method("GET")
     */
    public function showAction(MpersonalFuncionario $mpersonalFuncionario)
    {
        $deleteForm = $this->createDeleteForm($mpersonalFuncionario);

        return $this->render('mpersonalfuncionario/show.html.twig', array(
            'mpersonalFuncionario' => $mpersonalFuncionario,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing mpersonalFuncionario entity.
     *
     * @Route("/{id}/edit", name="mpersonalfuncionario_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MpersonalFuncionario $mpersonalFuncionario)
    {
        $deleteForm = $this->createDeleteForm($mpersonalFuncionario);
        $editForm = $this->createForm('AppBundle\Form\MpersonalFuncionarioType', $mpersonalFuncionario);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mpersonalfuncionario_edit', array('id' => $mpersonalFuncionario->getId()));
        }

        return $this->render('mpersonalfuncionario/edit.html.twig', array(
            'mpersonalFuncionario' => $mpersonalFuncionario,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a mpersonalFuncionario entity.
     *
     * @Route("/{id}/delete", name="mpersonalfuncionario_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MpersonalFuncionario $mpersonalFuncionario)
    {
        $form = $this->createDeleteForm($mpersonalFuncionario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mpersonalFuncionario);
            $em->flush();
        }

        return $this->redirectToRoute('mpersonalfuncionario_index');
    }

    /**
     * Creates a form to delete a mpersonalFuncionario entity.
     *
     * @param MpersonalFuncionario $mpersonalFuncionario The mpersonalFuncionario entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MpersonalFuncionario $mpersonalFuncionario)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mpersonalfuncionario_delete', array('id' => $mpersonalFuncionario->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Lists all mpersonalFuncionario entities.
     *
     * @Route("/search", name="mpersonalfuncionario_search")
     * @Method({"GET", "POST"})
     */
    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $funcionarios['data'] = array();

        if ($authCheck == true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $funcionarios = $em->getRepository('AppBundle:MpersonalFuncionario')->getSearch($params);
                
            if ($funcionarios == null) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Registro no encontrado", 
                );
            }else{
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro encontrado", 
                    'data'=> $funcionarios,
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
     * Lists all mpersonalFuncionario entities.
     *
     * @Route("/search/ciudadano", name="mpersonalfuncionario_search_ciudadano")
     * @Method({"GET", "POST"})
     */
    public function searchCiudadanoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $ciudadano['data'] = array();

        if ($authCheck == true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $usuario = $em->getRepository('UsuarioBundle:Usuario')->findOneByIdentificacion(
                $params->identificacion
            );
            $ciudadano = $em->getRepository('AppBundle:Ciudadano')->findOneByUsuario(
                $usuario->getId()
            );
                
            if ($ciudadano == null) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Registro no encontrado", 
                );
            }else{
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro encontrado", 
                    'data'=> $ciudadano,
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
