<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CfgAsignacionPlacaSede;
use AppBundle\Entity\CfgPlaca;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Cfgasignacionplacasede controller.
 *
 * @Route("cfgasignacionplacasede")
 */
class CfgAsignacionPlacaSedeController extends Controller
{
    /**
     * Lists all cfgAsignacionPlacaSede entities.
     *
     * @Route("/", name="cfgasignacionplacasede_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $tipos = $em->getRepository('AppBundle:CfgAsignacionPlacaSede')->findBy(
            array('estado' => true)
        );

        $response['data'] = array();

        if ($tipos) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($tipos) . " registros encontrados",
                'data' => $tipos,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new cfgAsignacionPlacaSede entity.
     *
     * @Route("/new", name="cfgasignacionplacasede_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $sedeOperativa = $em->getRepository('AppBundle:SedeOperativa')->find($params->sedeOperativa);
            $modulo = $em->getRepository('AppBundle:Modulo')->find($params->moduloId);
            $tipoVehiculo = $em->getRepository('AppBundle:CfgTipoVehiculo')->find($params->cfgTipoVehiculo);

            $cfgAsignacionPlacaSedes = $em->getRepository('AppBundle:CfgAsignacionPlacaSede')->findAll();

            foreach ($cfgAsignacionPlacaSedes as $key => $cfgAsignacionPlacaSede) {
                if ($params->numeroFinal < $cfgAsignacionPlacaSede->getNumeroInicial() && $cfgAsignacionPlacaSede->getLetrasPlaca() == $params->letrasPlaca && $cfgAsignacionPlacaSede->getNumeroInicial() <= $params->numeroInicial && $cfgAsignacionPlacaSede->getNumeroFinal() >= $params->numeroInicial) {
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "El rango de placas ya se encuentra registrado",
                    );
                    return $helpers->json($response);
                }
                /*if ($params->numeroFinal < $cfgAsignacionPlacaSede->getNumeroInicial()) {
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "El rango de placas ya se encuentra registrado",
                    );
                    return $helpers->json($response);
                }*/

            }

            $automotor = $this->validarTipoVehiculo(
                $params->numeroInicial,
                $params->numeroFinal,
                $params->letrasPlaca,
                $tipoVehiculo->getNombre()
            );
            #preg_match('/^[a-zA-Z]+$/', 
            $contadorPlacas = 0;

            if ($automotor) {
                for ($i = $params->numeroInicial; $i <= $params->numeroFinal; $i++) {
                    $em = $this->getDoctrine()->getManager();
                    if ($tipoVehiculo->getNombre() == "MOTOCICLETA") {
                        $numero = $params->letrasPlaca . $i . $params->letraFinal;
                        $cfgPlaca = new CfgPlaca();
                        $cfgPlaca->setNumero($numero);
                        $cfgPlaca->setEstado('Fabricada');
                        $cfgPlaca->setTipoVehiculo($tipoVehiculo);
                        $cfgPlaca->setSedeOperativa($sedeOperativa);

                        $em->persist($cfgPlaca);
                        $em->flush();

                    } else {
                        $numero = $params->letrasPlaca . $i;
                        $cfgPlaca = new CfgPlaca();
                        $cfgPlaca->setNumero($numero);
                        $cfgPlaca->setEstado('Fabricada');
                        $cfgPlaca->setTipoVehiculo($tipoVehiculo);
                        $cfgPlaca->setSedeOperativa($sedeOperativa);

                        $em->persist($cfgPlaca);
                        $em->flush();

                        #$contadorPlacas += 1;
                    }
                    $contadorPlacas += 1;

                }

                $asignacion = new CfgAsignacionPlacaSede();

                $asignacion->setEstado(true);
                $asignacion->setSedeOperativa($sedeOperativa);
                $asignacion->setTipoVehiculo($tipoVehiculo);
                $asignacion->setModulo($modulo);
                $asignacion->setLetrasPlaca($params->letrasPlaca);
                $asignacion->setNumeroInicial($params->numeroInicial);
                $asignacion->setNumeroFinal($params->numeroFinal);

                $em->persist($asignacion);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Asignación realizada, " . $contadorPlacas . " creadas con éxito.",
                );

            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No se pudieron asignar las placas. Error en el formato de placas",
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida...",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Finds and displays a CfgAsignacionPlacaSede entity.
     *
     * @Route("/{id}", name="cfgasignacionplacasede_show")
     * @Method("GET")
     */
    public function showAction(CfgAsignacionPlacaSede $cfgAsignacionPlacaSede)
    {
        $deleteForm = $this->createDeleteForm($cfgAsignacionPlacaSede);
    }

    /**
     * Displays a form to edit an existing cfgAsignacionPlacaSede entity.
     *
     * @Route("/edit", name="cfgasignacionplacasede_edit")
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
            $asignacion = $em->getRepository("AppBundle:CfgAsignacionPlacaSede")->find($params->id);

            $sedeOperativa = $em->getRepository('AppBundle:SedeOperativa')->find($params->sedeOperativa);
            $modulo = $em->getRepository('AppBundle:Modulo')->find($params->modulo);
            $tipoVehiculo = $em->getRepository('AppBundle:CfgTipoVehiculo')->find($params->tipoVehiculo);

            if ($asignacion != null) {
                $asignacion->setEstado(true);
                $asignacion->setSedeOperativa($sedeOperativa);
                $asignacion->setTipoVehiculo($tipoVehiculo);
                $asignacion->setModulo($modulo);
                $asignacion->setLetrasPlaca($params->letrasPlaca);
                $asignacion->setNumeroInicial($params->numeroInicial);
                $asignacion->setNumeroFinal($params->numeroFinal);

                $em->persist($asignacion);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $asignacion,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos",
                );

            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida para editar",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Deletes a cfgAsignacionPlacaSede entity.
     *
     * @Route("/delete", name="cfgasignacionplacasede_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {

        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $json = $request->get("json", null);
            $params = json_decode($json);

            $asignacion = $em->getRepository('AppBundle:CfgAsignacionPlacaSede')->find($params->id);
            $asignacion->setEstado(false);
            $em->persist($asignacion);
            $em->flush();
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro eliminado con éxito",
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
     * Creates a form to delete a cfgAsignacionPlacaSede entity.
     *
     * @param CfgAsignacionPlacaSede $cfgAsignacionPlacaSede The cfgAsignacionPlacaSede entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgAsignacionPlacaSede $cfgAsignacionPlacaSede)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgasignacionplacasede_delete', array('id' => $cfgAsignacionPlacaSede->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="cfgasignacionplacasede_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $asignaciones = $em->getRepository('AppBundle:CfAsignacionPlacaSede')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($asignaciones as $key => $asignacion) {
            $response[$key] = array(
                'value' => $asignacion->getId(),
                'label' => $asignacion->getNombre(),
            );
        }
        return $helpers->json($response);
    }

    public function validarTipoVehiculo($numeroInicial, $numeroFinal, $letrasPlaca, $tipoVehiculo)
    {
        switch ($tipoVehiculo) {
            case 'AUTOMOTOR':
                $nomenclaturaValida = $this->validarNomenclatura($numeroInicial, $numeroFinal, $letrasPlaca, 3, 3);
                break;
            case 'MOTOCICLETA':
                $nomenclaturaValida = $this->validarNomenclatura($numeroInicial, $numeroFinal, $letrasPlaca, 3, 2);
                break;
            case 'MOTOCARRO':
                $nomenclaturaValida = $this->validarNomenclatura($numeroInicial, $numeroFinal, $letrasPlaca, 3, 3);
                break;
            case 'REMOLQUE Y SEMIREMOLQUE':
                $nomenclaturaValida = $this->validarNomenclatura($numeroInicial, $numeroFinal, $letrasPlaca, 1, 5);
                break;
            case 'MAQUINARIA AGRICOLA':
                $nomenclaturaValida = $this->validarNomenclatura($numeroInicial, $numeroFinal, $letrasPlaca, 3, 3);
                break;
        }

        return $nomenclaturaValida;
    }

    public function validarNomenclatura($numeroInicial, $numeroFinal, $letrasPlaca, $cantidadLetras, $cantidadNumeros)
    {
        if (preg_match('/^[a-zA-Z]+$/', $letrasPlaca) && strlen($numeroInicial) == $cantidadNumeros && strlen($numeroFinal) == $cantidadNumeros && intval($numeroInicial) < intval($numeroFinal)) {
            return true;
        } else {
            return false;
        }
    }
}
