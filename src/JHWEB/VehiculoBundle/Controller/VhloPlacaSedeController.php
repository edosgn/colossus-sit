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

            $rangoInicial = mb_strtoupper($params->rangoInicial, 'utf-8');
            $rangoFinal = mb_strtoupper($params->rangoFinal, 'utf-8');
            
            //$asignaciones = $em->getRepository('JHWEBVehiculoBundle:VhloPlacaSede')->findAll();

            $validaAsignacion = true;

            /*foreach ($asignaciones as $key => $asignacion) {
                if ($asignacion->getLetrasPlaca() == $letrasInicio && ((intval($params->numeroInicial) >= intval($asignacion->getNumeroInicial()) && intval($params->numeroInicial) <= intval($asignacion->getNumeroFinal())) || (intval($params->numeroFinal) >= intval($asignacion->getNumeroInicial()) && intval($params->numeroFinal) <= intval($asignacion->getNumeroFinal())))) {
                    $validaAsignacion = false;
                }
            }*/

            if(!$validaAsignacion){
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El rango de placas ya se encuentra registrado",
                );
                
                return $helpers->json($response);
            }else{
                $validate = $this->validateByTipoVehiculo(
                    $rangoInicial,
                    $rangoFinal,
                    $tipoVehiculo->getNombre()
                );
    
                $contadorPlacas = 0;
    
                if ($validate) {
                    if ($rangoInicial > $rangoFinal) {
                        $response = array(
                            'title' => 'Error!',
                            'status' => 'error',
                            'code' => 400,
                            'message' => "El rango incial no puede ser mayor al rango final.",
                        );
                    }else{
                        $numeroPlacas = $this->generatePlacas(
                            $rangoInicial, 
                            $rangoFinal, 
                            $tipoVehiculo, 
                            $organismoTransito
                        );

                        $asignacion = new VhloPlacaSede();
        
                        $asignacion->setOrganismoTransito($organismoTransito);
                        $asignacion->setTipoVehiculo($tipoVehiculo);
                        $asignacion->setRangoInicial($rangoInicial);
                        $asignacion->setRangoFinal($rangoFinal);
                        $asignacion->setActivo(true);
        
                        $em->persist($asignacion);
                        $em->flush();

                        $response = array(
                            'title' => 'Perfecto!',
                            'status' => 'success',
                            'code' => 200,
                            'message' => "Asignación de ".$numeroPlacas." placas realizada con éxito.",
                        );
                    }    
                }else {
                    $response = array(
                        'title' => 'Error!',
                        'status' => 'error',
                        'code' => 400,
                        'message' => "No se pudieron asignar las placas. Error en el formato de placas",
                    );
                }
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
     * @Route("/delete", name="vhloplacasede_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $asignacion = $em->getRepository('JHWEBVehiculoBundle:VhloPlacaSede')->find(
                $params->id
            );

            $asignacion->setActivo(false);

            $em->flush();

            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Registro eliminado con exito"
            );
        }else{
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

    public function generatePlacas($rangoInicial, $rangoFinal, $tipoVehiculo, $organismoTransito){
        $helpers = $this->get("app.helpers");

        $longitud = strlen($rangoInicial);
        $contador = 0;

        switch ($tipoVehiculo->getNombre()) {
            case 'MOTOCICLETA':
                $ceros = 2;
                $limite = 99;
                $letraInicial = substr($rangoInicial, 0, 3);
                $letraFinal = substr($rangoFinal, 0, 3);
                $numeroInicial = substr($rangoInicial, 3, 2);
                $numeroFinal = substr($rangoFinal, 3, 2);

                if ($longitud == 6) {
                    $ultimaLetraInicial = substr($rangoInicial, 5,1);
                    $ultimaLetraFinal = substr($rangoFinal, 5,1);
                }
                break;
            case 'MOTOCARRO':
                $ceros = 3;
                $limite = 999;
                $letraInicial = substr($rangoInicial, 0, 3);
                $letraFinal = substr($rangoFinal, 0, 3);
                $numeroInicial = substr($rangoInicial, 3, 3);
                $numeroFinal = substr($rangoFinal, 3, 3);
                break;
            case 'REMOLQUE Y SEMIREMOLQUE':
                $ceros = 5;
                $limite = 99999;
                $letraInicial = substr($rangoInicial, 5, 1);
                $letraFinal = substr($rangoFinal, 5, 1);
                $numeroInicial = substr($rangoInicial, 0, 4);
                $numeroFinal = substr($rangoFinal, 0, 4);
                break;
            default:
                $ceros = 3;
                $limite = 999;
                $letraInicial = substr($rangoInicial, 0, 3);
                $letraFinal = substr($rangoFinal, 0, 3);
                $numeroInicial = substr($rangoInicial, 3, 3);
                $numeroFinal = substr($rangoFinal, 3, 3);
                break;
        }

        while ($rangoInicial <= $rangoFinal) {
            if($letraInicial < $letraFinal){
                for ($i=$numeroInicial; $i <= $limite; $i++) {
                    $i = str_pad($i, $ceros, '0', STR_PAD_LEFT);
                    $next = $i;
                    $contador++;
                    
                    $this->newPlacaAction(
                        $rangoInicial, 
                        $tipoVehiculo, 
                        $organismoTransito
                    );

                    $rangoInicial = $letraInicial.$next;
                }
                
                if ($next == $limite) {
                    $numeroInicial = 0;
                    $this->newPlacaAction(
                        $rangoInicial, 
                        $tipoVehiculo, 
                        $organismoTransito
                    );
                    $letraInicial = $helpers->nextLetter($letraInicial);
                    $numeroInicial = str_pad($numeroInicial, $ceros, '0', STR_PAD_LEFT);
                    $rangoInicial = $letraInicial.$numeroInicial;
                }
            }elseif($letraInicial == $letraFinal){
                for ($i=$numeroInicial; $i <= $numeroFinal; $i++) {
                    $i = str_pad($i, $ceros, '0', STR_PAD_LEFT);
                    $next = $i;
                    $contador++;

                    $this->newPlacaAction(
                        $rangoInicial, 
                        $tipoVehiculo, 
                        $organismoTransito
                    );

                    $rangoInicial = $letraInicial.$next;
                }
            }

            if ($rangoInicial == $rangoFinal) {
                $this->newPlacaAction(
                    $rangoInicial, 
                    $tipoVehiculo, 
                    $organismoTransito
                );

                break;
            }
        }

        return $contador;
    }

    public function validateByTipoVehiculo($rangoInicial, $rangoFinal, $tipoVehiculo)
    {
        $longitudRangoInicial = strlen($rangoInicial);
        $longitudRangoFinal = strlen($rangoFinal);

        switch ($tipoVehiculo) {
            case 'AUTOMOTOR':
                if ($longitudRangoInicial == 6 && $longitudRangoFinal == 6) {
                    $letrasRangoInicial = substr($rangoInicial, 0, 3);
                    $letrasRangoFinal = substr($rangoFinal, 0, 3);
                    $numerosRangoInicial = substr($rangoInicial, 3, 3);
                    $numerosRangoFinal = substr($rangoFinal, 3, 3);

                    if (is_string($letrasRangoInicial) && is_string($letrasRangoFinal) && is_numeric($numerosRangoInicial) && is_numeric($numerosRangoFinal)) {
                        $nomenclaturaValida = true;
                    } else {
                        $nomenclaturaValida = false;
                    };                    
                }else{
                    $nomenclaturaValida = false;
                }

                break;
            case 'MOTOCICLETA':
                if (($longitudRangoInicial == 6 && $longitudRangoFinal == 6) || ($longitudRangoInicial == 5 && $longitudRangoFinal == 5)) {
                    $letrasRangoInicial = substr($rangoInicial, 0, 3);
                    $letrasRangoFinal = substr($rangoFinal, 0, 3);
                    $numerosRangoInicial = substr($rangoInicial, 3, 2);
                    $numerosRangoFinal = substr($rangoFinal, 3, 2);

                    if ($longitudRangoInicial == 5 && $longitudRangoFinal == 5) {
                        if (is_string($letrasRangoInicial) && is_string($letrasRangoFinal) && is_numeric($numerosRangoInicial) && is_numeric($numerosRangoFinal)) {
                            $nomenclaturaValida = true;
                        } else {
                            $nomenclaturaValida = false;
                        };
                    }else{
                        $letraRangoInicial = substr($rangoInicial, 5, 1);
                        $letraRangoFinal = substr($rangoFinal, 5, 1);

                        if (is_string($letrasRangoInicial) && is_string($letrasRangoFinal) && is_numeric($numerosRangoInicial) && is_numeric($numerosRangoFinal) && is_string($letraRangoInicial) && is_string($letraRangoFinal)) {
                            $nomenclaturaValida = true;
                        } else {
                            $nomenclaturaValida = false;
                        };
                    }
                }else{
                    $nomenclaturaValida = false;
                }

                break;
            case 'MOTOCARRO':
                if ($longitudRangoInicial == 6 && $longitudRangoFinal == 6) {
                    //$nomenclaturaValida = $this->validateNomenclatura($numeroInicial, $numeroFinal, $letrasInicio, 3, 3);
                    
                    $letrasRangoInicial = substr($rangoInicial, 0, 3);
                    $letrasRangoFinal = substr($rangoFinal, 0, 3);
                    $numerosRangoInicial = substr($rangoInicial, 3, 3);
                    $numerosRangoFinal = substr($rangoFinal, 3, 3);

                    if (is_string($letrasRangoInicial) && is_string($letrasRangoFinal) && is_numeric($numerosRangoInicial) && is_numeric($numerosRangoFinal)) {
                        $nomenclaturaValida = true;
                    } else {
                        $nomenclaturaValida = false;
                    };                    
                }else{
                    $nomenclaturaValida = false;
                }

                break;
            case 'REMOLQUE Y SEMIREMOLQUE':
                if ($longitudRangoInicial == 6 && $longitudRangoFinal == 6) {
                    //$nomenclaturaValida = $this->validateNomenclatura($numeroInicial, $numeroFinal, $letrasInicio, 1, 5);

                    $letrasRangoInicial = substr($rangoInicial, 0, 1);
                    $letrasRangoFinal = substr($rangoFinal, 0, 1);
                    $numerosRangoInicial = substr($rangoInicial, 1, 5);
                    $numerosRangoFinal = substr($rangoFinal, 1, 5);

                    if (is_string($letrasRangoInicial) && is_string($letrasRangoFinal) && is_numeric($numerosRangoInicial) && is_numeric($numerosRangoFinal)) {
                        $nomenclaturaValida = true;
                    } else {
                        $nomenclaturaValida = false;
                    };
                }else{
                    $nomenclaturaValida = false;
                }
                
                break;
            case 'MAQUINARIA AGRICOLA':
                if ($longitudRangoInicial == 6 && $longitudRangoFinal == 6) {
                    //$nomenclaturaValida = $this->validateNomenclatura($numeroInicial, $numeroFinal, $letrasInicio, 3, 3);

                    $letrasRangoInicial = substr($rangoInicial, 0, 3);
                    $letrasRangoFinal = substr($rangoFinal, 0, 3);
                    $numerosRangoInicial = substr($rangoInicial, 3, 3);
                    $numerosRangoFinal = substr($rangoFinal, 3, 3);

                    if (is_string($letrasRangoInicial) && is_string($letrasRangoFinal) && is_numeric($numerosRangoInicial) && is_numeric($numerosRangoFinal)) {
                        $nomenclaturaValida = true;
                    } else {
                        $nomenclaturaValida = false;
                    };                    
                }else{
                    $nomenclaturaValida = false;
                }

                break;
        }

        return $nomenclaturaValida;
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
                    'message' => "Autorizacion no valida", 
                );
        }

        return $helpers->json($response);
    }
}
