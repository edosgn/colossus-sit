<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvRevision;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svrevision controller.
 *
 * @Route("svrevision")
 */
class SvRevisionController extends Controller
{
    /**
     * Lists all svRevision entities.
     *
     * @Route("/", name="svrevision_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $revisiones = $em->getRepository('JHWEBSeguridadVialBundle:SvRevision')->findBy(
            array(
                'activo' => true
            )
        );

        $response = array(
            'title' => 'Perfecto!',
            'status' => 'success',
            'code' => 200,
            'message' => "Listado revisiones",
            'data' => $revisiones,
        );
        return $helpers->json($response);
    }

    /**
     * Creates a new svRevision entity.
     *
     * @Route("/new", name="svrevision_new")
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


            $funcionario = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->find($params->idFuncionario);
            $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->find($params->idEmpresa);
            

            $revision = new SvRevision();
            
            $revision->setNumeroRadicado(strval($params->numeroRadicado));

            //para generar consecutivo automático
            $fechaRegistro = new \Datetime(date('Y-m-d h:i:s'));
            $revision->setFechaRegistro($fechaRegistro);

            $consecutivo = $em->getRepository('JHWEBSeguridadVialBundle:SvRevision')->getMaximo($fechaRegistro->format('Y'));
            $consecutivo = (empty($consecutivo['maximo']) ? 1 : $consecutivo['maximo']+=1);
            $revision->setConsecutivo($consecutivo);

            $fechaDevolucionDatetime = new \DateTime($params->fechaDevolucion);
            $revision->setFechaDevolucion($fechaDevolucionDatetime);

            $fechaRevisionDatetime = new \DateTime($params->fechaRevision);
            $fechaRecepcionDatetime = new \DateTime($params->fechaRecepcion);
            
            if($fechaRevisionDatetime > $fechaDevolucionDatetime){
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "La fecha de revisión debe ser menor o igual a la fecha de devolución.",
                );
                return $helpers->json($response);
            }
            if ($fechaRecepcionDatetime < $fechaRevisionDatetime) {
                $revision->setFechaRecepcion($fechaRecepcionDatetime);
                $revision->setFechaRevision($fechaRevisionDatetime);
            } 
            else {
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "La fecha de recepción debe ser menor a la fecha de revisión.",
                );
                return $helpers->json($response);
            }

            $revision->setFuncionario($funcionario);
            $revision->setPersonaContacto($params->personaContacto);
            $revision->setCargo($params->cargo);
            $revision->setCorreo($params->correo);
            $revision->setEmpresa($empresa);
            $revision->setActivo(true);
            
            $em->persist($revision);
            $em->flush();

            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Revisión creada con éxito",
            );
        } else {
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Finds and displays a svRevision entity.
     *
     * @Route("/show", name="svrevision_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();

            $revision = $em->getRepository('JHWEBSeguridadVialBundle:SvRevision')->find($params->id);

            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "revision con nombre" . " " . $revision->getNombre(),
                'data' => $revision,
            );
        } else {
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing svRevision entity.
     *
     * @Route("/edit", name="svrevision_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();

            $funcionario = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->find($params->funcionarioId);
            $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->find($params->empresaId);

            $revision = $em->getRepository('JHWEBSeguridadVialBundle:SvRevision')->find($params->id);
            $revision->setFechaDevolucion(new \DateTime($params->fechaDevolucion));

            $fechaOtorgamientoDatetime = new \DateTime($params->fechaOtorgamiento);
            $revision->setFechaOtorgamiento($fechaOtorgamientoDatetime);

            $fechaRevisionDatetime = new \DateTime($params->fechaRevision);
            $fechaRecepcionDatetime = new \DateTime($params->fechaRecepcion);
            if ($fechaRecepcionDatetime < $fechaRevisionDatetime) {
                $revision->setFechaRecepcion($fechaRecepcionDatetime);
                $revision->setFechaRevision($fechaRevisionDatetime);
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "La fecha de recepción debe ser menor a la fecha de revisión.",
                );
                return $helpers->json($response);
            }

            if ($params->fechaOtorgamiento) {
                $fechaVisitaControlDatetime1 = new \Datetime(($params->fechaOtorgamiento));
                $fechaVisitaControlDatetime2 = new \Datetime(($params->fechaOtorgamiento));
                if ($fechaOtorgamientoDatetime > $fechaVisitaControlDatetime1) {
                    $response = array(
                        'title' => 'Error!',
                        'status' => 'error',
                        'code' => 400,
                        'message' => "La fecha de la primera visita de control debe ser mayor a un año de la fecha de otorgamiento del aval",
                    );
                    return $helpers->json($response);
                } else {
                    $revision->setFechaVisitaControl1(new \DateTime($params->fechaVisitaControl1));
                    $revision->setObservacionVisita1($params->observacionVisita1);
                    
                }if ($fechaOtorgamientoDatetime > $fechaVisitaControlDatetime2 && $fechaVisitaControlDatetime1 < $fechaVisitaControlDatetime2) {
                    $response = array(
                        'title' => 'Error!',
                        'status' => 'error',
                        'code' => 400,
                        'message' => "La fecha de la segunda visita de control debe ser mayor a dos años de la fecha de otorgamiento del aval",
                    );
                    return $helpers->json($response);
                } else {
                    $revision->setFechaVisitaControl2(new \DateTime($params->fechaVisitaControl2));
                    $revision->setObservacionVisita2($params->observacionVisita2);
                }
            }

            $revision->setFuncionario($funcionario);
            $revision->setPersonaContacto($params->personaContacto);
            $revision->setCargo($params->cargo);
            $revision->setCorreo($params->correo);
            $revision->setEmpresa($empresa);
            $revision->setActivo(true);
            $em->persist($revision);
            $em->flush();
            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Revisión creada con éxito",
            );
        } else {
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Deletes a svRevision entity.
     *
     * @Route("/delete", name="svrevision_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", true);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();

            $revision = $em->getRepository('JHWEBSeguridadVialBundle:SvRevision')->find($params->id);

            $revision->setActivo(false);

            $em->persist($revision);
            $em->flush();

            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Registro eliminado con éxito.",
            );
        } else {
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no válida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Finds and displays a svRevision entity.
     *
     * @Route("/show/revision/empresa", name="svrevision_show_by_empresa")
     * @Method({"GET", "POST"})
     */
    public function showRevisionByEmpresa(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        $em = $this->getDoctrine()->getManager();

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();

            $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->find($params->id);

            $revisiones = $em->getRepository('JHWEBSeguridadVialBundle:SvRevision')->findBy(
                array(
                    'empresa' => $params->id
                )
            );

            $response['data'] = array();

            if ($revisiones) {
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Revisiones encontradas para la empresa con NIT: " . $empresa->getId(),
                    'data' => $revisiones,
                );
            } else {
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No encontraron revisiones para la empresa con NIT: " . $empresa->getNit(),
                );
            }
        } else {
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida",
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Calcula la fecha de devolucion
     *
     * @Route("/get/fecha/devolucion", name="svrevision_fecha_devolucion")
     * @Method({"GET", "POST"})
     */
    public function getFechaDevolucionAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $fechaDevolucion = new \Datetime(date('Y-m-d', strtotime('+2 month', strtotime($params->fechaRecepcion))));

            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Fecha de devolución de la revisión calculada con éxito",
                'fechaDevolucion' => $fechaDevolucion->format('Y-m-d'),
            );
        } else {
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no válida",
            );
        }
        return $helpers->json($response);
    }

}
