<?php

namespace JHWEB\ContravencionalBundle\Controller;

use JHWEB\ContravencionalBundle\Entity\CvCdoNotificacion;
use JHWEB\ContravencionalBundle\Entity\CvCdoTrazabilidad;
use JHWEB\ConfigBundle\Entity\CfgAdmActoAdministrativo;
use JHWEB\ContravencionalBundle\Entity\CvAudiencia;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Cvcdonotificacion controller.
 *
 * @Route("cvcdonotificacion")
 */
class CvCdoNotificacionController extends Controller
{
    /**
     * Lists all cvCdoNotificacion entities.
     *
     * @Route("/", name="cvcdonotificacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $notificaciones = $em->getRepository('JHWEBContravencionalBundle:CvCdoNotificacion')->findBy(
            array(
                'activo' => true
            )
        );

        $response['data'] = array();

        if ($notificaciones) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($notificaciones)." registros encontrados", 
                'data'=> $notificaciones,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new cvCdoNotificacion entity.
     *
     * @Route("/new", name="cvcdonotificacion_new")
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

            if ($params->notificacion->idComparendoEstado) {
                $estado = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->find(
                    $params->notificacion->idComparendoEstado
                );
            }

            foreach ($params->arrayCargos as $key => $idCargo) {
                $notificacion = new CvCdoNotificacion();

                $notificacion->setDia($params->notificacion->dia);
                $notificacion->setHora(new \Datetime($params->notificacion->hora));
                $notificacion->setActivo(true);
                $notificacion->setEstado($estado);
                
                $cargo = $em->getRepository('AppBundle:CfgCargo')->find(
                    $idCargo
                );
                $notificacion->setCargo($cargo);

                $em->persist($notificacion);
            }

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
                'message' => "Autorizacion no valida", 
            );
        }

        return $helpers->json($response);
    }

    /**
     * Finds and displays a cvCdoNotificacion entity.
     *
     * @Route("/{id}/show", name="cvcdonotificacion_show")
     * @Method("GET")
     */
    public function showAction(CvCdoNotificacion $cvCdoNotificacion)
    {
        $deleteForm = $this->createDeleteForm($cvCdoNotificacion);

        return $this->render('cvcdonotificacion/show.html.twig', array(
            'cvCdoNotificacion' => $cvCdoNotificacion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cvCdoNotificacion entity.
     *
     * @Route("/edit", name="cvcdonotificacion_edit")
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
            
            $notificacion = $em->getRepository("JHWEBContravencionalBundle:CvCdoNotificacion")->find($params->id);

            if ($notificacion) {
                $notificacion->setDia($params->notificacion->dia);
                $notificacion->setHora(new \Datetime($params->notificacion->hora));

                if ($params->notificacion->idComparendoEstado) {
                    $estado = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->find(
                        $params->notificacion->idComparendoEstado
                    );
                    $notificacion->setEstado($estado);
                }
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $notificacion,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorizacion no valida para editar", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a cvCdoNotificacion entity.
     *
     * @Route("/delete", name="cvcdonotificacion_delete")
     * @Method({"GET", "POST"})
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

            $notificacion = $em->getRepository('JHWEBContravencionalBundle:CvCdoNotificacion')->find(
                $params->id
            );

            $notificacion->setActivo(false);

            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro eliminado con exito"
            );
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
     * Creates a form to delete a cvCdoNotificacion entity.
     *
     * @param CvCdoNotificacion $cvCdoNotificacion The cvCdoNotificacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CvCdoNotificacion $cvCdoNotificacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cvcdonotificacion_delete', array('id' => $cvCdoNotificacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* =================================== */
    /**
     * Lists all cvCdoNotificacion entities.
     *
     * @Route("/state", name="cvcdonotificacion_state")
     * @Method("GET")
     */
    public function stateAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $comparendos = $em->getRepository('JHWEBContravencionalBundle:CvCdoComparendo')->getForProcessing();

        if ($comparendos) {
            foreach ($comparendos as $key => $comparendo) {
                $diasHabiles = $helpers->getDiasHabiles($comparendo->getFecha());
                $diasCalendario = $helpers->getDiasCalendario($comparendo->getFecha());

                //Valida que el comparendo este Pendiente
                if ($comparendo->getEstado()->getId() == 1) {
                    if (!$comparendo->getAudiencia()) {
                        //Busca si ya se creo un auto de no comparecencia
                        $auto = $em->getRepository('JHWEBContravencionalBundle:CvCdoTrazabilidad')->findBy(
                            array(
                                'comparendo' => $comparendo->getId(),
                                'estado' => 14
                            )
                        );

                        if ($auto) {
                            //Busca si ya se creo la notificación por estado
                            $notificacion = $em->getRepository('JHWEBContravencionalBundle:CvCdoTrazabilidad')->findBy(
                                array(
                                    'comparendo' => $comparendo->getId(),
                                    'estado' => 15
                                )
                            );

                            if (!$notificacion) {
                                //Registra trazabilidad de notificacion por estado
                                $estado = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->find(15);

                                $helpers->generateTrazabilidad($comparendo, $estado);
                            }else{
                                //Busca si ya se creo una sancion
                                $sancion = $em->getRepository('JHWEBContravencionalBundle:CvCdoTrazabilidad')->findBy(
                                    array(
                                        'comparendo' => $comparendo->getId(),
                                        'estado' => 2
                                    )
                                );

                                if (!$sancion) {
                                    if ($diasCalendario > 30 && $diasCalendario <= 912) {
                                        //Cambia a estado sansonatorio
                                        $estado = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->find(2);

                                        $helpers->generateTrazabilidad($comparendo, $estado);
                                    }elseif($diasCalendario > 912){
                                        $caduco = $helpers->checkRangeDates($comparendo->getFecha());

                                        if ($caduco) {
                                            //Caducidad
                                            $estado = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->find(
                                                7
                                            );

                                            $helpers->generateTrazabilidad($comparendo, $estado);
                                        }
                                    }
                                }
                            }
                        }else{
                            //Valida si han pasado mas de 5 días
                            if ($diasHabiles > 5) {
                                //Registra trazabilidad de auto de comparecencia
                                $estado = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->find(14);
                                $helpers->generateTrazabilidad($comparendo, $estado);
                                
                                //Crea una audiencia automatica
                                $audiencia = new CvAudiencia();

                                $fecha = new \Datetime(date('Y-m-d'));
                                $hora = new \Datetime(date('h:i:s'));

                                /*$validarAudiencia = $helpers->getDateAudienciaAutomatica(
                                    $fecha, 
                                    $hora
                                );
                                $audiencia->setFecha($validarAudiencia['fecha']);
                                $audiencia->setHora($validarAudiencia['hora']);*/
                                $audiencia->setFecha($fecha);
                                $audiencia->setHora($hora);
                                $audiencia->setEstado('AUTOMATICA');
                                $audiencia->setActivo(true);

                                $audiencia->setComparendo($comparendo);
                                $tipo = $em->getRepository('JHWEBContravencionalBundle:CvAuCfgTipo')->find(
                                    1
                                );
                                $audiencia->setTipo($tipo);
        
                                $em->persist($audiencia);
                                $em->flush();
                            }
                        }
                    }
                }elseif($comparendo->getEstado()->getId() == 2){ //Sancionado
                    if (!$comparendo->getAudiencia()) {
                        //Valida si han pasado mas de 912 días (2 años 6 meses)
                        if ($diasCalendario > 912) {
                            //Auto de Avoco
                            $estado = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->find(
                                16
                            );

                            $helpers->generateTrazabilidad($comparendo, $estado);

                            //Mandamiento de pago
                            $estado = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->find(
                                18
                            );

                            $helpers->generateTrazabilidad($comparendo, $estado);

                            //Busca si ya se creo un cobro coactivo
                            $cobroCoactivo = $em->getRepository('JHWEBContravencionalBundle:CvCdoTrazabilidad')->findBy(
                                array(
                                    'comparendo' => $comparendo->getId(),
                                    'estado' => 3
                                )
                            );

                            if (!$cobroCoactivo) {
                                //Cambia a estado a cobro coactivo
                                $estado = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->find(3);

                                $helpers->generateTrazabilidad($comparendo, $estado);
                            }
                        }
                    }
                }elseif($comparendo->getEstado()->getId() == 3){//Cobro coactivo
                    //Busca la trazabilidad de cobro coactivo
                    $cobroCoactivo = $em->getRepository('JHWEBContravencionalBundle:CvCdoTrazabilidad')->findOneBy(
                        array(
                            'comparendo' => $comparendo->getId(),
                            'estado' => 3
                        )
                    );

                    $diasHabiles = $helpers->getDiasHabiles(
                        $cobroCoactivo->getFecha()
                    );

                    //Busca si ya se creo una notificacion personal
                    $notificacionPersonal = $em->getRepository('JHWEBContravencionalBundle:CvCdoTrazabilidad')->findOneBy(
                        array(
                            'comparendo' => $comparendo->getId(),
                            'estado' => 20
                        )
                    );

                    if (!$notificacionPersonal && $diasHabiles > 20) {
                        //Crea la trazabilidad de notificacion personal
                        $estado = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->find(20);

                        $helpers->generateTrazabilidad($comparendo, $estado);
                    }else{
                        $diasCalendario = $helpers->getDiasCalendario(
                            $notificacionPersonal->getFecha()
                        );

                        //Busca si ya se creo una notificacion por aviso
                        $notificacionAviso = $em->getRepository('JHWEBContravencionalBundle:CvCdoTrazabilidad')->findOneBy(
                            array(
                                'comparendo' => $comparendo->getId(),
                                'estado' => 21
                            )
                        );

                        if (!$notificacionAviso && $diasCalendario > 40) {
                            //Crea la trazabilidad de notificacion por aviso
                            $estado = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->find(21);

                            $helpers->generateTrazabilidad($comparendo, $estado);
                        }else{
                            $diasCalendario = $helpers->getDiasCalendario(
                                $notificacionAviso->getFecha()
                            );

                            //Busca si ya se creo una notificacion por pagina web
                            $notificacionWeb = $em->getRepository('JHWEBContravencionalBundle:CvCdoTrazabilidad')->findOneBy(
                                array(
                                    'comparendo' => $comparendo->getId(),
                                    'estado' => 22
                                )
                            );

                            if (!$notificacionWeb && $diasCalendario > 20) {
                                //Crea la trazabilidad de notificacion por pagina web
                                $estado = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->find(22);

                                $helpers->generateTrazabilidad($comparendo, $estado);
                            }else{
                                $diasHabiles = $helpers->getDiasHabiles(
                                    $notificacionWeb->getFecha()
                                );

                                //Busca si ya se creo una notificacion por pagina web
                                $autoSeguirAdelante = $em->getRepository('JHWEBContravencionalBundle:CvCdoTrazabilidad')->findOneBy(
                                    array(
                                        'comparendo' => $comparendo->getId(),
                                        'estado' => 23
                                    )
                                );

                                if (!$autoSeguirAdelante && $diasHabiles > 1) {
                                    //Genera la trazabilidad de auto de seguir adelante
                                    $estado = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->find(23);

                                    $helpers->generateTrazabilidad($comparendo, $estado);
                                }

                            }
                        }
                    }
                }elseif($comparendo->getEstado()->getId() == 4){//Acuerdo de pago
                    $acuerdoPago = $comparendo->getAcuerdoPago();

                    $amortizaciones = $em->getRepository('JHWEBFinancieroBundle:FroAmortizacion')->findBy(
                        array(
                            'acuerdoPago' => $acuerdoPago->getId()
                        )
                    );


                    $fechaActual = new \Datetime(date('Y-m-d'));
                    $noPagadas = 0;
                    foreach ($amortizaciones as $key => $amortizacion) {
                        $fechaLimite = $amortizacion->getFechaLimite();
                        if (!$amortizacion->getPagada() &&  $fechaLimite < $fechaActual) {
                            $noPagadas += 1;
                        }
                    }

                    if ($noPagadas >= 2) {
                        //Cambia a estado acuerdo de pago incumplido
                        $estado = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->find(5);

                        $helpers->generateTrazabilidad($comparendo, $estado);
                    }
                }else{
                    //Busca si existe la trazabilidad de pendiente
                    $pendiente = $em->getRepository('JHWEBContravencionalBundle:CvCdoTrazabilidad')->findBy(
                        array(
                            'comparendo' => $comparendo->getId(),
                            'estado' => 1
                        )
                    );

                    if (!$pendiente) {
                        //Cambia a estado pendiente
                        $estado = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->find(1);

                        $helpers->generateTrazabilidad($comparendo, $estado);
                    }
                }
            }

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($comparendos)." registros automatizados",
            );
        }

        return $helpers->json($response);
    }

    //Migrar a servicio
    public function generateTrazabilidad($comparendo, $estado){
        $em = $this->getDoctrine()->getManager();

        if ($estado->getActualiza()) {
            $comparendo->setEstado($estado);
            $em->flush();
        }

        $trazabilidadesOld = $em->getRepository('JHWEBContravencionalBundle:CvCdoTrazabilidad')->findBy(
            array(
                'comparendo' => $comparendo->getId(),
                'activo' => true
            )
        );

        if ($trazabilidadesOld) {
            foreach ($trazabilidadesOld as $key => $trazabilidadOld) {
                $trazabilidadOld->setActivo(false);
                $em->flush();
            }
        }

        $trazabilidad = new CvCdoTrazabilidad();
        
        $trazabilidad->setFecha(
            new \Datetime(date('Y-m-d'))
        );
        $trazabilidad->setHora(
            new \Datetime(date('h:i:s A'))
        );

        $trazabilidad->setActivo(true);
        $trazabilidad->setComparendo($comparendo);
        $trazabilidad->setEstado($estado);

        if ($estado->getFormato()) {
            $documento = new CfgAdmActoAdministrativo();

            $documento->setNumero(
                $comparendo->getEstado()->getSigla().'-'.$comparendo->getConsecutivo()->getNumero()
            );

            if ($estado->getId() == 15) {
                $fecha = new \Datetime(date('Y-m-d'));
                $documento->setFecha($fecha->modify('+1 days'));
            }else{
                $documento->setFecha(new \Datetime(date('Y-m-d')));
            }
            $documento->setActivo(true);

            $documento->setFormato(
                $comparendo->getEstado()->getFormato()
            );

            $template = $this->generateTemplate(
                $comparendo,
                $comparendo->getEstado()->getFormato()->getCuerpo()
            );
            $documento->setCuerpo($template);

            $em->persist($documento);
            $em->flush();

            $trazabilidad->setActoAdministrativo($documento);
        }

        $em->persist($trazabilidad);
        $em->flush();
    }
    
    //Migrar a servicio
    public function generateTemplate($comparendo, $cuerpo){
        $helpers = $this->get("app.helpers");

        setlocale(LC_ALL,"es_ES");
        $fechaActual = strftime("%d de %B del %Y");

        
        $replaces[] = (object)array('id' => 'NOM', 'value' => $comparendo->getInfractorNombres().' '.$comparendo->getInfractorApellidos()); 
        $replaces[] = (object)array('id' => 'ID', 'value' => $comparendo->getInfractorIdentificacion());
        $replaces[] = (object)array('id' => 'NOC', 'value' => $comparendo->getConsecutivo()->getNumero()); 
        $replaces[] = (object)array('id' => 'FC1', 'value' => $fechaActual);

        if ($comparendo->getInfraccion()) {
            $replaces[] = (object)array('id' => 'DCI', 'value' => $comparendo->getInfraccion()->getDescripcion());
            $replaces[] = (object)array('id' => 'CIC', 'value' => $comparendo->getInfraccion()->getCodigo());
        }

        if ($comparendo->getPlaca()) {
            $replaces[] = (object)array('id' => 'PLACA', 'value' => $comparendo->getPlaca());
        }

        $template = $helpers->createTemplate(
          $cuerpo,
          $replaces
        );

        $template = str_replace("<br>", "<br/>", $template);

        return $template;
    }
}
