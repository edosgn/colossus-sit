<?php

namespace JHWEB\PersonalBundle\Controller;

use JHWEB\PersonalBundle\Entity\PnalHorario;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * Pnalhorario controller.
 *
 * @Route("pnalhorario")
 */
class PnalHorarioController extends Controller
{
    /**
     * Lists all pnalHorario entities.
     *
     * @Route("/", name="pnalhorario_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $pnalHorarios = $em->getRepository('JHWEBPersonalBundle:PnalHorario')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($pnalHorarios) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($pnalHorarios) . " registros encontrados",
                'data' => $pnalHorarios,
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a new pnalHorario entity.
     *
     * @Route("/new", name="pnalhorario_new")
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

            $funcionario = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->find(
                $params->idFuncionario
            );

            if ($params->manana) {
                $horarioMañana = new PnalHorario();
                $horarioMañana->setHoraInicial(new \Datetime($params->horaInicioManana));
                $horarioMañana->setHoraFinal(new \Datetime($params->horaFinManana));
                $horarioMañana->setFecha(new \Datetime($params->fecha));
                $horarioMañana->setJornada('Mañana');
                $horarioMañana->setFuncionario($funcionario);
                $horarioMañana->setLugar($params->lugarManana);
                $horarioMañana->setActivo(true);

                $em->persist($horarioMañana);
                $em->flush();
            }

            if ($params->tarde) {
                $horarioTarde = new PnalHorario();
                $horarioTarde->setHoraInicial(new \Datetime($params->horaInicioTarde));
                $horarioTarde->setHoraFinal(new \Datetime($params->horaFinTarde));
                $horarioTarde->setFecha(new \Datetime($params->fecha));
                $horarioTarde->setJornada('Tarde');
                $horarioTarde->setFuncionario($funcionario);
                $horarioTarde->setLugar($params->lugarTarde);
                $horarioTarde->setActivo(true);

                $em->persist($horarioTarde);
                $em->flush();
            }

            if ($params->noche) {
                $horarioNoche = new PnalHorario();
                $horarioNoche->setHoraInicial(new \Datetime($params->horaInicioNoche));
                $horarioNoche->setHoraFinal(new \Datetime($params->horaFinNoche));
                $horarioNoche->setFecha(new \Datetime($params->fecha));
                $horarioNoche->setJornada('Noche');
                $horarioNoche->setFuncionario($funcionario);
                $horarioNoche->setLugar($params->lugarNoche);
                $horarioNoche->setActivo(true);

                $em->persist($horarioNoche);
                $em->flush();
            }

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con exito",
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
     * Finds and displays a pnalHorario entity.
     *
     * @Route("/show", name="pnalhorario_show")
     * @Method("GET")
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $json = $request->get("data", null);
        $params = json_decode($json);

        $pnalHorario = $em->getRepository('JHWEBConfigBundle:PnalHorario')->find($params->id);

        if ($pnalHorario) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro encontrado",
                'data' => $pnalHorario,
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Registro no encontrado",
            );
        }

        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing pnalHorario entity.
     *
     * @Route("/edit", name="pnalhorario_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $funcionario = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->find(
                $params->idFuncionario
            );

            if ($params->manana) {
                $horarioMañana = $em->getRepository('JHWEBPersonalBundle:PnalHorario')->find($params->id);
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
                $horarioTarde = $em->getRepository('JHWEBPersonalBundle:PnalHorario')->find($params->id);
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
                $horarioNoche = $em->getRepository('JHWEBPersonalBundle:PnalHorario')->find($params->id);
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
                'message' => "Registro actualizado con exito",
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
     * Deletes a mpersonalHorario entity.
     *
     * @Route("/delete", name="mpersonalhorario_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", true);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $json = $request->get("json", null);
            $params = json_decode($json);

            $horario = $em->getRepository('JHWEBPersonalBundle:PnalHorario')->find($params->id);
            $horario->setActivo(false);

            $em->persist($horario);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro eliminado con éxito.",
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
