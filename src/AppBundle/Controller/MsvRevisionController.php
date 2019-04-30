<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MsvRevision;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;use Symfony\Component\HttpFoundation\Request;

/**
 * Msvrevision controller.
 *
 * @Route("msvrevision")
 */
class MsvRevisionController extends Controller
{
    /**
     * Lists all msvRevision entities.
     *
     * @Route("/", name="msvrevision_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $msvRevisiones = $em->getRepository('AppBundle:MsvRevision')->findBy(array('estado' => 1));

        $response = array(
            'status' => 'succes',
            'code' => 200,
            'msj' => "Listado revisiones",
            'data' => $msvRevisiones,
        );
        return $helpers->json($response);
    }

    /**
     * Creates a new msvRevision entity.
     *
     * @Route("/new", name="msvrevision_new")
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

            $funcionario = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->find($params->funcionarioId);
            
            $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->find($params->empresaId);

            $revision = new MsvRevision();
            $revision->setNumeroRadicado(strval($params->numeroRadicado));

            //para generar consecutivo automático
            $fechaRegistro = new \Datetime(date('Y-m-d h:i:s'));
            $revision->setFechaRegistro($fechaRegistro);

            $consecutivo = $em->getRepository('AppBundle:MsvRevision')->getMaximo($fechaRegistro->format('Y'));
            $consecutivo = (empty($consecutivo['maximo']) ? 1 : $consecutivo['maximo']+=1);
            $revision->setConsecutivo($consecutivo);

            $fechaDevolucionDatetime = new \DateTime($params->fechaDevolucion);
            $revision->setFechaDevolucion($fechaDevolucionDatetime);

            $fechaRevisionDatetime = new \DateTime($params->fechaRevision);
            $fechaRecepcionDatetime = new \DateTime($params->fechaRecepcion);
            
            if($fechaRevisionDatetime > $fechaDevolucionDatetime){
                $response = array(
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
            $revision->setEstado(true);
            
            $em->persist($revision);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Revisión creada con éxito",
            );
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
     * Finds and displays a msvRevision entity.
     *
     * @Route("/show", name="msvrevision_show")
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

            $revision = $em->getRepository('AppBundle:MsvRevision')->find($params->id);

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "revision con nombre" . " " . $revision->getNombre(),
                'data' => $revision,
            );
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
     * Displays a form to edit an existing msvRevision entity.
     *
     * @Route("/edit", name="msvrevision_edit")
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

            $revision = $em->getRepository('AppBundle:MsvRevision')->find($params->id);
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
            $revision->setEstado(true);
            $em->persist($revision);
            $em->flush();
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Revisión creada con éxito",
            );
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
     * Deletes a msvRevision entity.
     *
     * @Route("/{id}", name="msvrevision_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MsvRevision $msvRevision)
    {
        $form = $this->createDeleteForm($msvRevision);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($msvRevision);
            $em->flush();
        }

        return $this->redirectToRoute('msvrevision_index');
    }

    /**
     * Finds and displays a msvRevision entity.
     *
     * @Route("/show/revision/empresa", name="msvrevision_showByEmpresa")
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

            $revisiones = $em->getRepository('AppBundle:MsvRevision')->findBy(
                array(
                    'empresa' => $params->id
                )
            );

            $response['data'] = array();

            if ($revisiones) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Revisiones encontradas para la empresa con NIT: " . $empresa->getId(),
                    'data' => $revisiones,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No encontraron revisiones para la empresa con NIT: " . $empresa->getNit(),
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
     * Creates a form to delete a msvRevision entity.
     *
     * @param MsvRevision $msvRevision The msvRevision entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MsvRevision $msvRevision)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('msvrevision_delete', array('id' => $msvRevision->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Creates a new VhloSoat entity.
     *
     * @Route("/get/fecha/devolucion", name="revision_fecha_devolucion")
     * @Method({"GET", "POST"})
     */
    public function getFechaDevolucionAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);

            $fechaDevolucion = new \Datetime(date('Y-m-d', strtotime('+2 month', strtotime($params->fechaRecepcion))));

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Fecha de devolución de la revisión calculada con éxito",
                'fechaDevolucion' => $fechaDevolucion->format('Y-m-d'),
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no válida",
            );
        }
        return $helpers->json($response);
    }
}
