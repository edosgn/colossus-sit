<?php

namespace JHWEB\ContravencionalBundle\Controller;

use JHWEB\ContravencionalBundle\Entity\CvCdoTrazabilidad;
use JHWEB\ContravencionalBundle\Entity\CvInventarioDocumental;
use JHWEB\ConfigBundle\Entity\CfgAdmActoAdministrativo;
use JHWEB\ContravencionalBundle\Entity\CvAudiencia;
use JHWEB\ContravencionalBundle\Entity\CvInvestigacionBien;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Cvcdotrazabilidad controller.
 *
 * @Route("cvcdotrazabilidad")
 */
class CvCdoTrazabilidadController extends Controller
{
    /**
     * Lists all cvCdoTrazabilidad entities.
     *
     * @Route("/", name="cvcdotrazabilidad_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cvCdoTrazabilidads = $em->getRepository('JHWEBContravencionalBundle:CvCdoTrazabilidad')->findAll();

        return $this->render('cvcdotrazabilidad/index.html.twig', array(
            'cvCdoTrazabilidads' => $cvCdoTrazabilidads,
        ));
    }

    /**
     * Creates a new cvCdoTrazabilidad entity.
     *
     * @Route("/new", name="cvcdotrazabilidad_new")
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

            $trazabilidadNew = $em->getRepository('JHWEBContravencionalBundle:CvCdoTrazabilidad')->findBy(
                array(
                    'estado' => $params->idComparendoEstado,
                    'comparendo' => $params->idComparendo
                )
            );

            if (!$trazabilidadNew) {
                $trazabilidadesOld = $em->getRepository('JHWEBContravencionalBundle:CvCdoTrazabilidad')->findBy(
                    array(
                        'comparendo' => $params->idComparendo,
                        'activo' => true
                    )
                );

                //Inactiva trazabilidades anteriores
                if ($trazabilidadesOld) {
                    foreach ($trazabilidadesOld as $key => $trazabilidadOld) {
                        $trazabilidadOld->setActivo(false);
                        $em->flush();
                    }
                }

                if ($params->idComparendo) {
                    $comparendo = $em->getRepository('JHWEBContravencionalBundle:CvCdoComparendo')->find(
                        $params->idComparendo
                    );
                }

                //Busca el estado que se solicita insertar
                if ($params->idComparendoEstado) {
                    $estado = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->find(
                        $params->idComparendoEstado
                    );
                }

                //Valida si el estado a registrar es SANCIONADO
                if ($estado->getId() == 2) {
                    //Valida que tenga auto de no comparecencia
                    $trazabilidadOld = $em->getRepository('JHWEBContravencionalBundle:CvCdoTrazabilidad')->findBy(
                        array(
                            'comparendo' => $params->idComparendo,
                            'estado' => 14
                        )
                    );

                    //Si no lo tiene lo genera automaticamente
                    if (!$trazabilidadOld) {
                        $estadoNew = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->find(14);

                        $audiencia = new CvAudiencia();

                        $audiencia->setFecha(new \Datetime(date('Y-m-d')));
                        $audiencia->setHora(new \Datetime(date('h:i:s A')));
                        $audiencia->setEstado('AUTOMATICA');
                        $audiencia->setActivo(true);
                        $audiencia->setComparendo($comparendo);

                        $tipo = $em->getRepository('JHWEBContravencionalBundle:CvAuCfgTipo')->find(
                            1
                        );
                        $audiencia->setTipo($tipo);

                        $em->persist($audiencia);
                        $em->flush();

                        $helpers->generateTrazabilidad($comparendo, $estadoNew);
                    }

                    //Valida que tenga notificacion
                    $trazabilidadOld = $em->getRepository('JHWEBContravencionalBundle:CvCdoTrazabilidad')->findBy(
                        array(
                            'comparendo' => $params->idComparendo,
                            'estado' => 15
                        )
                    );

                    //Si no lo tiene lo genera automaticamente
                    if (!$trazabilidadOld) {
                        $estadoNew = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->find(
                            15
                        );
                        $helpers->generateTrazabilidad($comparendo, $estadoNew);
                    }

                    $estadoNew = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->find(
                        2
                    );
                    $helpers->generateTrazabilidad($comparendo, $estadoNew);

                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => "Registro creado con exito",
                    );

                    return $helpers->json($response);
                }elseif($estado->getId() == 3){
                    //Valida que tenga el estado de SANCIONADO
                    $trazabilidadOld = $em->getRepository('JHWEBContravencionalBundle:CvCdoTrazabilidad')->findBy(
                        array(
                            'comparendo' => $params->idComparendo,
                            'estado' => 2
                        )
                    );

                    if ($trazabilidadOld) {
                        //Valida que tenga auto de avoco
                        $trazabilidadOld = $em->getRepository('JHWEBContravencionalBundle:CvCdoTrazabilidad')->findBy(
                            array(
                                'comparendo' => $params->idComparendo,
                                'estado' => 16
                            )
                        );

                        //Si no lo tiene lo genera automaticamente
                        if (!$trazabilidadOld) {
                            $estadoNew = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->find(
                                16
                            );

                            $helpers->generateTrazabilidad($comparendo, $estadoNew);
                        }

                        //Valida que tenga mandamiento de pago
                        $trazabilidadOld = $em->getRepository('JHWEBContravencionalBundle:CvCdoTrazabilidad')->findBy(
                            array(
                                'comparendo' => $params->idComparendo,
                                'estado' => 18
                            )
                        );

                        //Si no lo tiene lo genera automaticamente
                        if (!$trazabilidadOld) {
                            $estadoNew = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->find(
                                18
                            );
                            $helpers->generateTrazabilidad($comparendo, $estadoNew);
                        }

                        //Inserta el estado de cobro coactivo
                        $estadoNew = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->find(
                            3
                        );
                        $helpers->generateTrazabilidad($comparendo, $estadoNew);

                        $response = array(
                            'status' => 'success',
                            'code' => 200,
                            'message' => "Registro creado con exito",
                        );
    
                        return $helpers->json($response);
                    }else{
                        $response = array(
                            'status' => 'error',
                            'code' => 400,
                            'message' => "No puede registrar un cobro coactivo sin estar sancionado el comparendo.",
                        );

                        return $helpers->json($response);
                    }
                }elseif($estado->getId() == 4){
                    //Valida que tenga minimo el estado de SANCIONADO
                    $trazabilidadOld = $em->getRepository('JHWEBContravencionalBundle:CvCdoTrazabilidad')->findBy(
                        array(
                            'comparendo' => $params->idComparendo,
                            'estado' => 2
                        )
                    );

                    if ($trazabilidadOld) {
                        $estadoNew = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->find(
                            4
                        );
                        $helpers->generateTrazabilidad($comparendo, $estadoNew);

                        $response = array(
                            'status' => 'success',
                            'code' => 200,
                            'message' => "Registro creado con exito",
                        );
                    }else{
                        $response = array(
                            'status' => 'error',
                            'code' => 400,
                            'message' => "No puede registrar un acuerdo de pago sin estar sancionado el comparendo.",
                        );
                    }

                    return $helpers->json($response);
                }elseif($estado->getId() == 15){
                    //No genera documento solo un pdf general de todas las notificaciones para el día siguiente al auto de no comparecencia
                    $estadoNew = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->find(
                        15
                    );
                    $helpers->generateTrazabilidad($comparendo, $estadoNew);
                    
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => "Registro creado con exito",
                    );

                    return $helpers->json($response);
                }else{
                    $helpers->generateTrazabilidad($comparendo, $estado);
                    
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => "Registro creado con exito",
                    );

                    return $helpers->json($response);
                }
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No se premite registrar mas de una trazabilidad con el mismo estado.",
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
     * Finds and displays a cvCdoTrazabilidad entity.
     *
     * @Route("/{id}/show", name="cvcdotrazabilidad_show")
     * @Method("GET")
     */
    public function showAction(CvCdoTrazabilidad $cvCdoTrazabilidad)
    {
        $deleteForm = $this->createDeleteForm($cvCdoTrazabilidad);

        return $this->render('cvcdotrazabilidad/show.html.twig', array(
            'cvCdoTrazabilidad' => $cvCdoTrazabilidad,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cvCdoTrazabilidad entity.
     *
     * @Route("/{id}/edit", name="cvcdotrazabilidad_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CvCdoTrazabilidad $cvCdoTrazabilidad)
    {
        $deleteForm = $this->createDeleteForm($cvCdoTrazabilidad);
        $editForm = $this->createForm('JHWEB\ContravencionalBundle\Form\CvCdoTrazabilidadType', $cvCdoTrazabilidad);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cvcdotrazabilidad_edit', array('id' => $cvCdoTrazabilidad->getId()));
        }

        return $this->render('cvcdotrazabilidad/edit.html.twig', array(
            'cvCdoTrazabilidad' => $cvCdoTrazabilidad,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cvCdoTrazabilidad entity.
     *
     * @Route("/{id}/delete", name="cvcdotrazabilidad_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CvCdoTrazabilidad $cvCdoTrazabilidad)
    {
        $form = $this->createDeleteForm($cvCdoTrazabilidad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cvCdoTrazabilidad);
            $em->flush();
        }

        return $this->redirectToRoute('cvcdotrazabilidad_index');
    }

    /**
     * Creates a form to delete a cvCdoTrazabilidad entity.
     *
     * @param CvCdoTrazabilidad $cvCdoTrazabilidad The cvCdoTrazabilidad entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CvCdoTrazabilidad $cvCdoTrazabilidad)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cvcdotrazabilidad_delete', array('id' => $cvCdoTrazabilidad->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Displays a form to update/documento an existing cvCdoTrazabilidad entity.
     *
     * @Route("/update/documento", name="cvcdotrazabilidad_update_document")
     * @Method({"GET", "POST"})
     */
    public function updateDocumentoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            
            $trazabilidad = $em->getRepository("JHWEBContravencionalBundle:CvCdoTrazabilidad")->find(
                $params->id
            );

            if ($trazabilidad) {
                $actoAdministrativo = new CfgAdmActoAdministrativo();

                $actoAdministrativo->setNumero($params->numero);
                $actoAdministrativo->setFecha(new \Datetime(date('Y-m-d')));
                $actoAdministrativo->setCuerpo($params->cuerpo);
                $actoAdministrativo->setActivo(true);

                if ($params->idFormato) {
                    $formato = $em->getRepository('JHWEBConfigBundle:CfgAdmFormato')->find(
                        $params->idFormato
                    );
                    $actoAdministrativo->setFormato($formato);
                }
                $em->persist($actoAdministrativo);
                $em->flush();

                $trazabilidad->setActoAdministrativo($actoAdministrativo);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $trazabilidad,
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
     * Notificaciones por pagina web.
     *
     * @Route("/notification/web", name="cvcdotrazabilidad_notification_web")
     * @Method({"GET", "POST"})
     */
    public function notificationWebAction(Request $request)
    {
        if ($request->getMethod() == 'POST') {
            $em = $this->getDoctrine()->getManager();
    
            /*$notificaciones = $em->getRepository('JHWEBContravencionalBundle:CvCdoTrazabilidad')->getNotificationWeb(
                'identificacion', 
                $request->request->get('inputIdentificacion')
            );*/

            $notificaciones = null;

            $trazabilidades = $em->getRepository('JHWEBContravencionalBundle:CvCdoTrazabilidad')->findByEstado(
                22
            );

            if ($trazabilidades) {
                foreach ($trazabilidades as $key => $trazabilidad) {
                    $mandamientoPago = $em->getRepository('JHWEBContravencionalBundle:CvCdoTrazabilidad')->findOneBy(
                        array(
                            'estado' => 18,
                            'comparendo' => $trazabilidad->getComparendo()->getId()
                        )
                    );

                    $notificaciones[] = array(
                        'infractor' => $trazabilidad->getComparendo()->getInfractorNombres().' '.$trazabilidad->getComparendo()->getInfractorApellidos(),
                        'identificacion' => $trazabilidad->getComparendo()->getInfractorIdentificacion(),
                        'infraccion' => $trazabilidad->getComparendo()->getInfraccion()->getCodigo(),
                        'idMandamientoPago' => $mandamientoPago->getId(),
                    );
                }
            }

            return $this->render('@JHWEBContravencional/Default/notification.web.html.twig', array(
                'notificaciones' => $notificaciones,
            ));
        }
          
        return $this->render('@JHWEBContravencional/Default/notification.web.html.twig');
    }

    /**
     * Busca todos los bienes registrados y asociados a una trazabilidad.
     *
     * @Route("/search/bienes", name="cvcdotrazabilidad_search_bienes")
     * @Method({"GET", "POST"})
     */
    public function searchBienesAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            
            $bienes = $em->getRepository("JHWEBContravencionalBundle:CvInvestigacionBien")->findBy(
                array(
                    'trazabilidad' => $params->idTrazabilidad,
                )                
            );

            if ($bienes) {
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($bienes)." registros encontrados.", 
                    'data'=> $bienes,
                );
            }else{
                $response = array(
                    'title' => 'Atención!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => "Ningún bien resgistrado aún.", 
                );
            }
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida para editar", 
            );
        }

        return $helpers->json($response);
    }

    /**
     * Registra un bien y los asocia a una trazabilidad.
     *
     * @Route("/new/bien", name="cvcdotrazabilidad_new_bien")
     * @Method({"GET", "POST"})
     */
    public function newBienAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            
            $bien = new CvInvestigacionBien();

            $bien->setNombre(mb_strtoupper($params->nombre, 'utf-8'));
            $bien->setTipo($params->tipo);
            $bien->setEmbargable($params->embargable);
            $bien->setAvaluo($params->avaluo);

            if($params->observaciones){
                $bien->setObservaciones($params->observaciones);
            }

            if($params->idTrazabilidad){
                $trazabilidad = $em->getRepository("JHWEBContravencionalBundle:CvCdoTrazabilidad")->find(
                    $params->idTrazabilidad
                );
                $bien->setTrazabilidad($trazabilidad);
            }

            $em->persist($bien);
            $em->flush();

            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Bien registrado con éxito.", 
                'data'=> $bien,
            );
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida para editar", 
            );
        }

        return $helpers->json($response);
    }

    /**
     * Actualiza el valor a embargar de los bienes seleccionados.
     *
     * @Route("/update/bienes", name="cvcdotrazabilidad_update_bienes")
     * @Method({"GET", "POST"})
     */
    public function updateBienesAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            foreach ($params as $key => $bien) {
                $bienOld = $em->getRepository("JHWEBContravencionalBundle:CvInvestigacionBien")->find(
                    $bien->id
                );

                if ($key == 0) {
                    $comparendo = $bienOld->getTrazabilidad()->getComparendo();
                }

                $bienOld->setValor($bien->valor);

                $em->flush();
            }

            $estadoNew = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->find(26);

            $helpers->generateTrazabilidad($comparendo, $estadoNew);

            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Bien registrado con éxito.", 
                'data'=> $bien,
            );
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida.", 
            );
        }

        return $helpers->json($response);
    }

    /**
     * Actualiza el numero de folios de una trazabilidad especifica.
     *
     * @Route("/update/folios", name="cvcdotrazabilidad_update_folios")
     * @Method({"GET", "POST"})
     */
    public function updateFoliosAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $trazabilidad = $em->getRepository("JHWEBContravencionalBundle:CvCdoTrazabilidad")->find(
                $params->idTrazabilidad
            );
            $trazabilidad->setFolios($params->numero);
            $em->flush();

            $comparendo = $trazabilidad->getComparendo();
            
            if ($comparendo->getInventarioDocumental()) {
                $folios = $em->getRepository("JHWEBContravencionalBundle:CvCdoTrazabilidad")->getTotalFoliosByComparendo(
                    $comparendo->getId()
                );

                $folios = $folios['total'];

                $inventarioDocumental = $comparendo->getInventarioDocumental();
                $inventarioDocumental->setFolios($folios);
            }

            $em->flush();

            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "El número de folios fue registrado con éxito.", 
            );
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida.", 
            );
        }

        return $helpers->json($response);
    }

    /**
     * Crea un inventario documental para un comparendo
     *
     * @Route("/update/inventario/documental", name="cvcdotrazabilidad_update_inventario_documental")
     * @Method({"GET", "POST"})
     */
    public function updateInventarioDocumentalAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $inventarioDocumental = new CvInventarioDocumental();
            
            $inventarioDocumental->setNumeroOrden($params->numeroOrden);
            $inventarioDocumental->setCodigo($params->codigo);
            $inventarioDocumental->setTipo("ORDEN DE COMPARENDO");
            $inventarioDocumental->setFechaInicial(new \Datetime());
            $inventarioDocumental->setFechaFinal(new \Datetime());
            $inventarioDocumental->setCaja($params->caja);
            $inventarioDocumental->setCarpeta($params->carpeta);
            $inventarioDocumental->setActivo(true);

            $em->persist($inventarioDocumental);
            $em->flush();

            if($inventarioDocumental) {
                $comparendo = $em->getRepository("JHWEBContravencionalBundle:CvCdoComparendo")->find($params->idComparendo);
                $comparendo->setInventarioDocumental($inventarioDocumental);
    
                $em->persist($comparendo);
                $em->flush();

                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "El inventario documental fue registrado con éxito.", 
                );
            }
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida.", 
            );
        }

        return $helpers->json($response);
    }
}
