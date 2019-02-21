<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloPlacaSede;
use JHWEB\VehiculoBundle\Entity\VhloCfgPlaca;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Vhloplacasede controller.
 *
 * @Route("vhloplacasede")
 */
class VhloPlacaSedeController extends Controller
{
    /**
     * Lists all vhloPlacaSede entities.
     *
     * @Route("/", name="vhloplacasede_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $asignaciones = $em->getRepository('JHWEBVehiculoBundle:VhloPlacaSede')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($asignaciones) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($asignaciones).' registros encontrados.',
                'data' => $asignaciones,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new vhloPlacaSede entity.
     *
     * @Route("/new", name="vhloplacasede_new")
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

            $organismoTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find(
                $params->idOrganismoTransito
            );

            $tipoVehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloCfgTipoVehiculo')->find(
                $params->idTipoVehiculo
            );

            $letrasPlaca = mb_strtoupper($params->letrasPlaca, 'utf-8');
            
            $asignaciones = $em->getRepository('JHWEBVehiculoBundle:VhloPlacaSede')->findAll();

            foreach ($asignaciones as $key => $asignacion) {
                if ($params->numeroFinal < $asignacion->getNumeroInicial() && $asignacion->getLetrasPlaca() == $letrasPlaca && $asignacion->getNumeroInicial() <= $params->numeroInicial && $asignacion->getNumeroFinal() >= $params->numeroInicial) {
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "El rango de placas ya se encuentra registrado",
                    );

                    return $helpers->json($response);
                }
            }

            $automotor = $this->validateTipoVehiculo(
                $params->numeroInicial,
                $params->numeroFinal,
                $letrasPlaca,
                $tipoVehiculo->getNombre()
            );

            $contadorPlacas = 0;

            if ($automotor) {
                for ($i = $params->numeroInicial; $i <= $params->numeroFinal; $i++) {
                    $em = $this->getDoctrine()->getManager();

                    //Genera el nuevo numero de placa según el tipo de vehiculo
                    $numero = $this->generateNumberPlaca(
                        $letrasPlaca, 
                        $params->letraFinal, 
                        $tipoVehiculo->getNombre(),
                        $contadorPlacas,
                        $i
                    );

                    if ($numero['status'] == 'success') {
                        $numero = $numero['data'];
                    }elseif ($numero['status'] == 'error') {
                        return $numero;
                    }

                    //Inserta la nueva placa
                    $this->newPlacaAction(
                        $numero, 
                        $tipoVehiculo, 
                        $organismoTransito
                    );

                    $contadorPlacas += 1;

                }

                $asignacion = new VhloPlacaSede();

                $asignacion->setOrganismoTransito($organismoTransito);
                $asignacion->setTipoVehiculo($tipoVehiculo);
                $asignacion->setLetrasPlaca($letrasPlaca);
                $asignacion->setNumeroInicial($params->numeroInicial);
                $asignacion->setNumeroFinal($params->numeroFinal);
                $asignacion->setActivo(true);

                $em->persist($asignacion);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Asignación realizada, ".$contadorPlacas." placas creadas con éxito.",
                );

            }else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No se pudieron asignar las placas. Error en el formato de placas",
                );
            }
        }else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida.",
            );
        }

        return $helpers->json($response);
    }

    /**
     * Finds and displays a vhloPlacaSede entity.
     *
     * @Route("/{id}/show", name="vhloplacasede_show")
     * @Method("GET")
     */
    public function showAction(VhloPlacaSede $vhloPlacaSede)
    {
        $deleteForm = $this->createDeleteForm($vhloPlacaSede);

        return $this->render('vhloplacasede/show.html.twig', array(
            'vhloPlacaSede' => $vhloPlacaSede,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vhloPlacaSede entity.
     *
     * @Route("/{id}/edit", name="vhloplacasede_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, VhloPlacaSede $vhloPlacaSede)
    {
        $deleteForm = $this->createDeleteForm($vhloPlacaSede);
        $editForm = $this->createForm('JHWEB\VehiculoBundle\Form\VhloPlacaSedeType', $vhloPlacaSede);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vhloplacasede_edit', array('id' => $vhloPlacaSede->getId()));
        }

        return $this->render('vhloplacasede/edit.html.twig', array(
            'vhloPlacaSede' => $vhloPlacaSede,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a vhloPlacaSede entity.
     *
     * @Route("/{id}/delete", name="vhloplacasede_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, VhloPlacaSede $vhloPlacaSede)
    {
        $form = $this->createDeleteForm($vhloPlacaSede);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vhloPlacaSede);
            $em->flush();
        }

        return $this->redirectToRoute('vhloplacasede_index');
    }

    /**
     * Creates a form to delete a vhloPlacaSede entity.
     *
     * @param VhloPlacaSede $vhloPlacaSede The vhloPlacaSede entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloPlacaSede $vhloPlacaSede)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhloplacasede_delete', array('id' => $vhloPlacaSede->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ========================================================= */

    /**
     * Creates a new vhloCfgPlaca entity.
     *
     */
    public function newPlacaAction($numero, $tipoVehiculo, $organismoTransito)
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $placa = $em->getRepository('JHWEBVehiculoBundle:VhloCfgPlaca')->findOneByNumero(
            $numero
        );

        if (!$placa) {
            $placa = new VhloCfgPlaca();

            $placa->setNumero(mb_strtoupper($numero, 'utf-8'));
            $placa->setEstado('FABRICADA');
            $placa->setTipoVehiculo($tipoVehiculo);
            $placa->setOrganismoTransito($organismoTransito);

            $em->persist($placa);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con exito",
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'La placa ya existe', 
            );
        }
        
        
        return $helpers->json($response);
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="vhlocfgplacasede_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $asignaciones = $em->getRepository('JHWEBVehiculoBundle:VhloPlacaSede')->findBy(
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

    public function generateNumberPlaca($letrasPlaca, $letraFinal, $tipoVehiculo, $contadorPlacas, $i){
        $helpers = $this->get("app.helpers");

        switch ($tipoVehiculo) {
            case 'MOTOCICLETA':
                $numero = $letrasPlaca.$i.strtoupper($letraFinal);
                if ($i >= 0 && $i < 10 && $contadorPlacas != 0) {
                    $cadena = "0" . $i;
                    $numero = $letrasPlaca.$cadena.strtoupper($letraFinal);
                }

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Número generado.',
                    'data' => $numero
                );

                break;
            case 'MOTOCARRO':
                $numero = $i. $letrasPlaca;

                if ($i >= 0 && $i < 10 && $contadorPlacas != 0) {
                    $cadena = "00" . $i;
                    $numero = $cadena.$letrasPlaca;
                }elseif ($i >= 10 && $i < 100 && $contadorPlacas != 0) {
                    $cadena = "0" . $i;
                    $numero = $cadena.$letrasPlaca;
                }

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Número generado.',
                    'data' => $numero
                );
                break;
            case 'REMOLQUE Y SEMIREMOLQUE':
                $numero = $letrasPlaca . $i;

                if ($letrasPlaca == 'R' || $letrasPlaca == 'S') {
                    if ($i >= 0 && $i < 10 && $contadorPlacas != 0) {
                        $cadena = "0000" . $i;
                        $numero = $letrasPlaca . $cadena;
                    } elseif ($i >= 10 && $i < 100 && $contadorPlacas != 0) {
                        $cadena = "000" . $i;
                        $numero = $letrasPlaca . $cadena;
                    } elseif ($i >= 100 && $i < 999 && $contadorPlacas != 0) {
                        $cadena = "00" . $i;
                        $numero = $letrasPlaca . $cadena;
                    } elseif ($i >= 1000 && $i < 10000 && $contadorPlacas != 0) {
                        $cadena = "0" . $i;
                        $numero = $letrasPlaca . $cadena;
                    }

                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => 'Número generado.',
                        'data' => $numero
                    );
                }else{
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "Error en el formato de placas para REMOLQUE Y SEMIREMOLQUE",
                    );
                }
                break;
            default:
                $numero = $letrasPlaca . $i;

                if ($i >= 0 && $i < 10 && $contadorPlacas != 0) {
                    $cadena = "00" . $i;
                    $numero = $letrasPlaca . $cadena;
                }elseif ($i >= 10 && $i < 100 && $contadorPlacas != 0) {
                    $cadena = "0" . $i;
                    $numero = $letrasPlaca . $cadena;
                }

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Número generado.',
                    'data' => $numero
                );

                break;
        }

        return $response;
    }

    public function validateTipoVehiculo($numeroInicial, $numeroFinal, $letrasPlaca, $tipoVehiculo)
    {
        switch ($tipoVehiculo) {
            case 'AUTOMOTOR':
                $nomenclaturaValida = $this->validateNomenclatura($numeroInicial, $numeroFinal, $letrasPlaca, 3, 3);
                break;
            case 'MOTOCICLETA':
                $nomenclaturaValida = $this->validateNomenclatura($numeroInicial, $numeroFinal, $letrasPlaca, 3, 2);
                break;
            case 'MOTOCARRO':
                $nomenclaturaValida = $this->validateNomenclatura($numeroInicial, $numeroFinal, $letrasPlaca, 3, 3);
                break;
            case 'REMOLQUE Y SEMIREMOLQUE':
                $nomenclaturaValida = $this->validateNomenclatura($numeroInicial, $numeroFinal, $letrasPlaca, 1, 5);
                break;
            case 'MAQUINARIA AGRICOLA':
                $nomenclaturaValida = $this->validateNomenclatura($numeroInicial, $numeroFinal, $letrasPlaca, 3, 3);
                break;
        }

        return $nomenclaturaValida;
    }

    public function validateNomenclatura($numeroInicial, $numeroFinal, $letrasPlaca, $cantidadLetras, $cantidadNumeros)
    {
        if (preg_match('/^[a-zA-Z]+$/', $letrasPlaca) && strlen($numeroInicial) == $cantidadNumeros && strlen($numeroFinal) == $cantidadNumeros && intval($numeroInicial) < intval($numeroFinal)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Busca asignaciones por parametros (identificacion, No. comparendo o fecha).
     *
     * @Route("/search/organismotransito", name="vhloplacasede_search_organismotransito")
     * @Method({"GET","POST"})
     */
    public function searchByOrganismoTransito(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $asignaciones = $em->getRepository('JHWEBVehiculoBundle:VhloPlacaSede')->findBy(
                array(
                    'organismoTransito' => $params->idOrganismoTransito,
                    'activo' => true
                )
            );

            if ($asignaciones) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($asignaciones)." registros encontrados", 
                    'data' => $asignaciones,
            );
            }else{
                 $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No existen registros para esos filtros de búsqueda", 
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
