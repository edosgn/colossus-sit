<?php

namespace JHWEB\PersonalBundle\Controller;

use JHWEB\PersonalBundle\Entity\PnalTalonario;
use JHWEB\PersonalBundle\Entity\PnalCfgCdoConsecutivo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Pnaltalonario controller.
 *
 * @Route("pnaltalonario")
 */
class PnalTalonarioController extends Controller
{
    /**
     * Lists all pnalTalonario entities.
     *
     * @Route("/", name="pnaltalonario_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $talonarios = $em->getRepository('JHWEBPersonalBundle:PnalTalonario')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($talonarios) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($talonarios).' Registros encontrados.', 
                'data'=> $talonarios,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new pnalTalonario entity.
     *
     * @Route("/new", name="pnaltalonario_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $organismoTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find(
                $params->idOrganismoTransito
            );

            $rangoDisponible = $em->getRepository('JHWEBPersonalBundle:PnalTalonario')->getLastByFechaAndOrganismoTransito(
                $params->idOrganismoTransito
            );

            if ($rangoDisponible) {
                $cantidadDisponible = $em->getRepository('JHWEBPersonalBundle:PnalTalonario')->getCantidadDisponibleByOrganismoTransito(
                    $params->idOrganismoTransito
                );

                $cantidadDisponible = (empty($cantidadDisponible['total']) ? 0 : $cantidadDisponible['total']);

                $cantidadValidar = ($rangoDisponible->getCantidadRecibida() * 80) / 100;
                $cantidadValidar = $rangoDisponible->getCantidadRecibida() - $cantidadValidar;

                if ($cantidadDisponible > $cantidadValidar) {
                    $registro = $this->register($params);

                    if($registro){
                        $response = array(
                            'status' => 'success',
                            'code' => 200,
                            'message' => "El registro se ha realizado con exito",
                        );
                    }else{
                        $response = array(
                            'status' => 'error',
                            'code' => 400,
                            'message' => "El rango ya se encuentra registrado para este organismo de tránsito.", 
                        );
                    }
                }else{
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => 'No se pueden asignar nuevos rangos porque aún tiene existencias vigentes.',
                    );
                }
            }else{
                $registro = $this->register($params);
                    
                if($registro){
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => "El registro se ha realizado con exito",
                    );
                }else{
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "El rango ya se encuentra registrado para este organismo de tránsito.", 
                    );
                }
            }            
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorización no valida',
            );
        }

        return $helpers->json($response);
    }

    /**
     * Finds and displays a pnalTalonario entity.
     *
     * @Route("/{id}", name="pnaltalonario_show")
     * @Method("GET")
     */
    public function showAction(PnalTalonario $pnalTalonario)
    {
        $deleteForm = $this->createDeleteForm($pnalTalonario);

        return $this->render('pnaltalonario/show.html.twig', array(
            'pnalTalonario' => $pnalTalonario,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing pnalTalonario entity.
     *
     * @Route("/edit", name="pnaltalonario_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $talonario = $em->getRepository("JHWEBPersonalBundle:PnalTalonario")->find(
                $params->id
            );

            if ($talonario) {
                $talonario->setDesde($params->desde);
                $talonario->setHasta($params->hasta);
                $talonario->setRangos($params->rangos);
                $talonario->setFechaAsignacion(new \Datetime($params->fechaAsignacion));
                $talonario->setNumeroResolucion($params->numeroResolucion);
                
                $organismoTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find(
                    $params->idOrganismoTransito
                );
                $talonario->setOrganismoTransito($organismoTransito);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Registro actualizado con exito.', 
                    'data'=> $talonario,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'El registro no se encuentra en la base de datos.', 
                );
            }
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida para editar.', 
            );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a pnalTalonario entity.
     *
     * @Route("/{id}", name="pnaltalonario_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, PnalTalonario $pnalTalonario)
    {
        $form = $this->createDeleteForm($pnalTalonario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pnalTalonario);
            $em->flush();
        }

        return $this->redirectToRoute('pnaltalonario_index');
    }

    /**
     * Creates a form to delete a pnalTalonario entity.
     *
     * @param PnalTalonario $pnalTalonario The pnalTalonario entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PnalTalonario $pnalTalonario)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pnaltalonario_delete', array('id' => $pnalTalonario->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ===============================================  */

    public function register($params){
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $ultimoRango = $em->getRepository('JHWEBPersonalBundle:PnalTalonario')->getMaximoByOrganismoTransito(
            $params->idOrganismoTransito
        );

        if ($ultimoRango) {
            if ($params->desde <= $ultimoRango['maximo']) {
                return false;
            }
        }

        $talonario = new PnalTalonario();
            
        $organismoTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find(
            $params->idOrganismoTransito
        );
        $talonario->setOrganismoTransito($organismoTransito);

        $talonario->setDesde($params->desde);
        $talonario->setHasta($params->hasta);
        $talonario->setCantidadDisponible($params->cantidadRecibida);
        $talonario->setCantidadRecibida($params->cantidadRecibida);
        $talonario->setFechaAsignacion(new \Datetime($params->fechaAsignacion));
        $talonario->setNumeroResolucion($params->numeroResolucion);
        $talonario->setActivo(true);
        
        $em->persist($talonario);
        $em->flush();

        $divipo = $organismoTransito->getDivipo();
        
        for ($numero = $talonario->getDesde(); $numero <= $talonario->getHasta(); $numero++) {
            $consecutivo = new PnalCfgCdoConsecutivo();

            if ($organismoTransito->getAsignacionRango()) {
                $consecutivo->setNumero($divipo.$numero);
            }else{
                $consecutivo->setNumero($numero);
            }
            
            $consecutivo->setOrganismoTransito($organismoTransito);
            $consecutivo->setEstado('DISPONIBLE');
            $consecutivo->setActivo(true);

            $em->persist($consecutivo);
            $em->flush();
        }

        return true;
    }
}
