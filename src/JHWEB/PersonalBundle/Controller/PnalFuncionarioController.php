<?php

namespace JHWEB\PersonalBundle\Controller;

use JHWEB\PersonalBundle\Entity\PnalFuncionario;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;use Symfony\Component\HttpFoundation\Request;

/**
 * Pnalfuncionario controller.
 *
 * @Route("pnalfuncionario")
 */
class PnalFuncionarioController extends Controller
{
    /**
     * Lists all pnalFuncionario entities.
     *
     * @Route("/", name="pnalfuncionario_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            $pnalFuncionarios = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->findBy(
                array(
                    'activo' => true,
                )
            );
            $response['data'] = array();

            if ($pnalFuncionarios) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($pnalFuncionarios) . " registros encontrados",
                    'data' => $pnalFuncionarios,
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a new pnalFuncionario entity.
     *
     * @Route("/new", name="pnalfuncionario_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            
            $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findOneBy(
                array('identificacion' => $params->identificacion)
            );

            if ($ciudadano) {
                $funcionario = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->findOneBy(
                    array(
                        'ciudadano' => $ciudadano->getId(),
                        'activo' => true,
                    )
                );

                if (!$funcionario) {
                    $organismoTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find(
                        $params->idOrganismoTransito
                    );
                    
                    $cargo = $em->getRepository('JHWEBPersonalBundle:PnalCfgCargo')->find(
                        $params->idCargo
                    );
                    
                    $tipoNombramiento = $em->getRepository('JHWEBPersonalBundle:PnalCfgTipoNombramiento')->find(
                        $params->idTipoNombramiento
                    );

                    $funcionario = new PnalFuncionario();
                    
                    $funcionario->setCiudadano($ciudadano);
                    $funcionario->setCargo($cargo);
                    $funcionario->setOrganismoTransito($organismoTransito);
                    $funcionario->setTipoNombramiento($tipoNombramiento);

                    if ($params->inhabilidad == 'true') {
                        $funcionario->setActivo(false);
                        $funcionario->setInhabilidad(true);
                    } else {
                        $funcionario->setActivo(true);
                        $funcionario->setInhabilidad(false);
                    }

                    if ($params->actaPosesion) {
                        $funcionario->setActaPosesion($params->actaPosesion);
                    }

                    if ($params->resolucion) {
                        $funcionario->setResolucion($params->resolucion);
                    }

                    if ($params->fechaInicio) {
                        $funcionario->setFechaInicial(new \Datetime($params->fechaInicio));
                    }

                    if ($params->fechaFin) {
                        $funcionario->setFechaFinal(new \Datetime($params->fechaFin));
                    }

                    if ($params->numeroContrato) {
                        $funcionario->setNumeroContrato($params->numeroContrato);
                    }
                    if ($params->objetoContrato) {
                        $funcionario->setObjetoContrato($params->objetoContrato);
                    }

                    if ($params->numeroPlaca) {
                        $funcionario->setNumeroPlaca($params->numeroPlaca);
                    }

                    if ($params->novedad) {
                        $funcionario->setNovedad($params->novedad);
                    }

                    $funcionario->setModificatorio(false);

                    $em->persist($funcionario);
                    $em->flush();

                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => "Registro creado con exito",
                        'data' => $funcionario,
                    );
                }else{
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "El funcionario ya tiene una vinculación activa.",
                    );
                }
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No existe el ciudadano en la base de datos.",
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Finds and displays a pnalFuncionario entity.
     *
     * @Route("/show", name="pnalfuncionario_show")
     * @Method("POST")
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $funcionario = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->find(
                $params->id
            );

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Registro encontrado con exito.',
                'data' => $funcionario
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida.', 
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing pnalFuncionario entity.
     *
     * @Route("/{id}/edit", name="pnalfuncionario_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, PnalFuncionario $pnalFuncionario)
    {
        $deleteForm = $this->createDeleteForm($pnalFuncionario);
        $editForm = $this->createForm('JHWEB\PersonalBundle\Form\PnalFuncionarioType', $pnalFuncionario);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pnalfuncionario_edit', array('id' => $pnalFuncionario->getId()));
        }

        return $this->render('pnalfuncionario/edit.html.twig', array(
            'pnalFuncionario' => $pnalFuncionario,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a pnalFuncionario entity.
     *
     * @Route("/{id}/delete", name="pnalfuncionario_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, PnalFuncionario $pnalFuncionario)
    {
        $form = $this->createDeleteForm($pnalFuncionario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pnalFuncionario);
            $em->flush();
        }

        return $this->redirectToRoute('pnalfuncionario_index');
    }

    /**
     * Creates a form to delete a pnalFuncionario entity.
     *
     * @param PnalFuncionario $pnalFuncionario The pnalFuncionario entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PnalFuncionario $pnalFuncionario)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pnalfuncionario_delete', array('id' => $pnalFuncionario->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ================================================ */

    /**
     * Busca el funcionario logueado por identificación.
     *
     * @Route("/search/login", name="pnalfuncionario_search_login")
     * @Method({"GET", "POST"})
     */
    public function searchLoginAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);

            $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findOneByIdentificacion(
                $params->identificacion
            );

            if ($ciudadano) {
                $funcionario = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->findOneBy(
                    array(
                        'ciudadano' => $ciudadano->getId(),
                        'activo' => true,
                    )
                );

                if ($funcionario) {
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => 'Registro encontrado.',
                        'data' => $funcionario,
                    );
                } else {
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => 'El ciudadano no tiene registros de nombramientos vigentes.',
                    );
                }
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'EL registro no existe en la base de datos.',
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida.',
            );
        }

        return $helpers->json($response);
    }

    /**
     * datos para select 2
     *
     * @Route("/select/contratistas", name="pnalfuncionario_select_contratistas")
     * @Method({"GET", "POST"})
     */
    public function selectContratistasAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $response = null;

        $funcionarios = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->findBy(
            array(
                'activo' => true,
                'tipoNombramiento' => array(1,3),
            )
        );

        foreach ($funcionarios as $key => $funcionario) {
            $response[$key] = array(
                'value' => $funcionario->getId(),
                'label' => $funcionario->getCiudadano()->getPrimerNombre() . " " . $funcionario->getCiudadano()->getPrimerApellido(),
            );
        }
        return $helpers->json($response);
    }

    /**
     * Listado de todos los funcionarios para selección con búsqueda
     *
     * @Route("/select", name="pnalfuncionario_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $funcionarios = $em->getRepository('JHWEBConfigBundle:PnalFuncionario')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($funcionarios as $key => $funcionario) {
            $response[$key] = array(
                'value' => $funcionario->getId(),
                'label' => $funcionario->getCiudadano()->getPrimerNombre() . " " . $funcionario->getCiudadano()->getPrimerApellido(),
            );
        }

        return $helpers->json($response);
    }

    /**
     * datos para select 2
     *
     * @Route("/select/agentes", name="pnalfuncionario_select_agentes")
     * @Method({"GET", "POST"})
     */
    public function selectAgentesAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $response = null;

        $funcionarios = $em->getRepository('JHWEBConfigBundle:PnalFuncionario')->findBy(
            array(
                'activo' => true,
                'tipoContrato' => 3,
            )
        );

        foreach ($funcionarios as $key => $funcionario) {
            $response[$key] = array(
                'value' => $funcionario->getId(),
                'label' => $funcionario->getNumeroPlaca() . "_" . $funcionario->getCiudadano()->getPrimerNombre() . " " . $funcionario->getCiudadano()->getPrimerApellido(),
            );
        }
        return $helpers->json($response);
    }

    /**
     * Lists all pnalFuncionario entities.
     *
     * @Route("/search/parametros", name="pnalfuncionario_search_parametros")
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
            $json = $request->get("json", null);
            $params = json_decode($json);

            $funcionarios = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->getSearch($params);

            if ($funcionarios) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($funcionarios) . " registros encontrados",
                    'data' => $funcionarios,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No existen funcionarios",
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Lists all pnalFuncionario entities.
     *
     * @Route("/search/ciudadano", name="pnalfuncionario_search_ciudadano")
     * @Method({"GET", "POST"})
     */
    public function searchCiudadanoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();

            $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findOneBy(
                array(
                    'identificacion' => $params->identificacion
                ));

            if ($ciudadano) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "ciudadano encontrado",
                    'data' => $ciudadano,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El ciudadano no se encuentra en la Base de Datos",
                );
                return $helpers->json($response);
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Lists all pnalFuncionario entities.
     *
     * @Route("/search/empresa", name="pnalfuncionario_search_empresa")
     * @Method({"GET", "POST"})
     */
    public function searchEmpresaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);

            $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findOneBy(array(
                'identificacion' => $params->identificacion,
                'activo' => true,
            ));

            if ($ciudadano) {
                $representante = $em->getRepository('JHWEBUsuarioBundle:UserEmpresaRepresentante')->findOneBy(array(
                    array(
                        'ciudadano' => $ciudadano->getId()
                    )
                ));
                $representante = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->findOneBy(
                    array(
                        'empresaRepresentante' => $representante->getId(),
                        'activo' => true,
                        'empresaServicio' => 1,
                    )
                );
                if ($representante) {
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => "Registro encontrado",
                        'data' => $representante,
                    );
                } else {
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "El ciudadano no tiene concesionarios",
                    );
                }
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida",
            );
        }

        return $helpers->json($response);
    }

    /**
     * Lists all pnalFuncionario entities.
     *
     * @Route("/record/times", name="pnalfuncionario_record_times")
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
            $json = $request->get("json", null);
            $params = json_decode($json);

            $horarios = $em->getRepository('JHWEBPersonalBundle:PnalHorario')->findBy(
                array(
                    'funcionario' => $params->id,
                )
            );

            if ($horarios) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registros encontrados",
                    'data' => $horarios,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Registro no encontrado",
                );
            }
        } else {
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
     * @Route("/record/prorrogas", name="pnalfuncionario_record_prorrogas")
     * @Method({"GET", "POST"})
     */
    public function recordProrrogaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $horarios['data'] = array();

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);

            $pnalProrogas = $em->getRepository('JHWEBPersonalBundle:PnalProroga')->findBy(
                array(
                    'funcionario' => $params->id,
                )
            );

            if ($pnalProrogas) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registros encontrados",
                    'data' => $pnalProrogas,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Registro no encontrado",
                );
            }
        } else {
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
     * @Route("/record/suspensiones", name="pnalfuncionario_record_suspensiones")
     * @Method({"GET", "POST"})
     */
    public function recordSuspensionAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $horarios['data'] = array();

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);

            $pnalSuspensiones = $em->getRepository('JHWEBPersonalBundle:PnalSuspension')->findBy(
                array(
                    'funcionario' => $params->id,
                )
            );

            if ($pnalSuspensiones) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registros encontrados",
                    'data' => $pnalSuspensiones,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Registro no encontrado",
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida",
            );
        }
        return $helpers->json($response);
    }

}
