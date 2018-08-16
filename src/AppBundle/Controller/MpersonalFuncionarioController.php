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

            /*if (count($params)==0) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "los campos no pueden estar vacios", 
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

                $sedeOperativa = $em->getRepository('AppBundle:SedeOperativa')->find(
                    $params->sedeOperativaId
                );
                $funcionario->setSedeOperativa($sedeOperativa);

                $tipoContrato = $em->getRepository('AppBundle:MpersonalTipoContrato')->find(
                    $params->tipoContratoId
                );
                $funcionario->setTipoContrato($tipoContrato);

                $cargo = $em->getRepository('AppBundle:CfgCargo')->find(
                    $params->cargoId
                );
                $funcionario->setCargo($cargo);

                $usuario = $em->getRepository('UsuarioBundle:Usuario')->findOneByIdentificacion(
                    $params->identificacion
                );

                if ($usuario) {
                    $ciudadano = $em->getRepository('AppBundle:Ciudadano')->findOneByUsuario(
                        $usuario->getId()
                    );
                }
                $funcionario->setCiudadano($ciudadano); 

                if ($params->inhabilidad == 'true') {
                    $funcionario->setActivo(false);
                    $funcionario->setInhabilidad(true);
                }else{
                    $funcionario->setActivo(true);
                    $funcionario->setInhabilidad(false);
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

                if ($params->novedad) {
                    $funcionario->setNovedad($params->novedad);
                }

                $em->persist($funcionario);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro creado con exito", 
                    'data' => $funcionario
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
     * Finds and displays a mpersonalFuncionario entity.
     *
     * @Route("/{id}/show", name="mpersonalfuncionario_show")
     * @Method({"GET", "POST"})
     */
    public function showAction($id)
    {
        $helpers = $this->get("app.helpers");
        
        $em = $this->getDoctrine()->getManager();
        $mpersonalFuncionario = $em->getRepository('AppBundle:MpersonalFuncionario')->find($id);

        if ($mpersonalFuncionario) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro encontrado", 
                'data' => $mpersonalFuncionario
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Registro no encontrado", 
            );
        }

        return $helpers->json($response);
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
     * datos para select 2
     *
     * @Route("/select", name="mpersonalfuncionario_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck== true) {
            $em = $this->getDoctrine()->getManager();
            
            $funcionarios = $em->getRepository('AppBundle:MpersonalFuncionario')->findBy(
                array('activo' => true)
            );

            foreach ($funcionarios as $key => $funcionario) {
                $response[$key] = array(
                    'value' => $funcionario->getId(),
                    'label' => $funcionario->getCiudadano()->getUsuario()->getPrimerNombre()." ".$funcionario->getCiudadano()->getUsuario()->getSegundoNombre()
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

    /**
     * datos para select 2
     *
     * @Route("/select/agentes", name="mpersonalfuncionario_select_agentes")
     * @Method({"GET", "POST"})
     */
    public function selectAgentesAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $response = null;
        
        $funcionarios = $em->getRepository('AppBundle:MpersonalFuncionario')->findBy(
            array(
                'activo' => true,
                'tipoContrato' => 3,
            )
        );

        foreach ($funcionarios as $key => $funcionario) {
            $response[$key] = array(
                'value' => $funcionario->getId(),
                'label' => $funcionario->getNumeroPlaca()."_".$funcionario->getCiudadano()->getUsuario()->getPrimerNombre()." ".$funcionario->getCiudadano()->getUsuario()->getSegundoNombre()
            );
        }
        return $helpers->json($response);
    }

    /**
     * datos para select 2
     *
     * @Route("/select/contratistas", name="mpersonalfuncionario_select_contratistas")
     * @Method({"GET", "POST"})
     */
    public function selectContratistasAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $response = null;
        
        $funcionarios = $em->getRepository('AppBundle:MpersonalFuncionario')->findBy(
            array(
                'activo' => true,
                'tipoContrato' => 2,
            )
        );

        foreach ($funcionarios as $key => $funcionario) {
            $response[$key] = array(
                'value' => $funcionario->getId(),
                'label' => $funcionario->getCiudadano()->getUsuario()->getPrimerNombre()." ".$funcionario->getCiudadano()->getUsuario()->getSegundoNombre()
            );
        }
        return $helpers->json($response);
    }

    /**
     * Lists all mpersonalFuncionario entities.
     *
     * @Route("/search/parametros", name="mpersonalfuncionario_search_parametros")
     * @Method({"GET", "POST"})
     */
    public function searchByParametrosAction(Request $request)
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
                    'message' => "Registro no encontrado",  
                );
            }else{
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado", 
                    'data'=> $funcionarios,
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

        if ($authCheck == true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $usuario = $em->getRepository('UsuarioBundle:Usuario')->findOneByIdentificacion(
                $params->identificacion
            );

            if ($usuario) {
                $ciudadano = $em->getRepository('AppBundle:Ciudadano')->findOneByUsuario(
                    $usuario->getId()
                );
                    
                if ($ciudadano == null) {
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "Registro no encontrado", 
                    );
                }else{
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => "Registro encontrado", 
                        'data'=> $ciudadano,
                    );
                }
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Registro no encontrado", 
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

    /**
     * Lists all mpersonalFuncionario entities.
     *
     * @Route("/search/login", name="mpersonalfuncionario_search_login")
     * @Method({"GET", "POST"})
     */
    public function searchLoginAction(Request $request)
    {
        
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

       // if ($authCheck == true) {
            $json = $request->get("json",null);
            $params = json_decode($json);
            
            
            $usuario = $em->getRepository('UsuarioBundle:Usuario')->findOneByIdentificacion(
                $params->identificacion
            );
            
            if ($usuario) {
                if ($usuario->getCiudadano()) {
                    $funcionario = $em->getRepository('AppBundle:MpersonalFuncionario')->findOneBy(
                        array(
                            'ciudadano' => $usuario->getCiudadano()->getId(),
                            'activo' => true
                        )
                    );
                    if ($funcionario) {
                        $response = array(
                            'status' => 'success',
                            'code' => 200,
                            'message' => "Registro encontrado", 
                            'data'=> $funcionario,
                        );
                    }else{
                        $response = array(
                            'status' => 'error',
                            'code' => 400,
                            'message' => "El ciudadano no tiene registros de nombramientos vigentes", 
                        );
                    }
                }else{
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "EL usuario fue encontrado pero no tiene datos asociados como ciudadano", 
                    );
                }

            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No se encuentra ningún usuario registrado con la identificación: ".$params->identificación, 
                );
            }


            
        /*}else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorizacion no valida", 
                );
        }*/
        return $helpers->json($response);
    }

    /**
     * Lists all mpersonalFuncionario entities.
     *
     * @Route("/record/times", name="mpersonalfuncionario_record_times")
     * @Method({"GET", "POST"})
     */
    public function recordTimesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $horarios['data'] = array();

        if ($authCheck == true) {
            $json = $request->get("json",null);
            $params = json_decode($json);
           
            $horarios = $em->getRepository('AppBundle:MpersonalHorario')->findBy(
                array(
                    'funcionario' => $params->id
                )
            );
                
            if ($horarios) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registros encontrados", 
                    'data'=> $horarios,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Registro no encontrado",  
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
