<?php

namespace JHWEB\ContravencionalBundle\Controller;

use JHWEB\ContravencionalBundle\Entity\CvCdoTrazabilidad;
use JHWEB\ConfigBundle\Entity\CfgAdmActoAdministrativo;
use JHWEB\ContravencionalBundle\Entity\CvAudiencia;
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

            $trazabilidadNew = $em->getRepository('JHWEBContravencionalBundle:CvCdoTrazabilidad')->findByEstado(
                    $params->idComparendoEstado
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
                    $comparendo = $em->getRepository('AppBundle:Comparendo')->find(
                        $params->idComparendo
                    );
                }

                //Busca el estado que se solicita insertar
                if ($params->idComparendoEstado) {
                    $estado = $em->getRepository('AppBundle:CfgComparendoEstado')->find(
                        $params->idComparendoEstado
                    );
                }

                //Valida si el estado a registrar es SANCIONADO
                if ($estado->getId() == 2) {
                    //Valida que tenga auto de no comparecencia
                    $trazabilidadOld = $em->getRepository('JHWEBContravencionalBundle:CvCdoTrazabilidad')->find(
                        array(
                            'comparendo' => $params->idComparendo,
                            'estado' => 14
                        )
                    );

                    //Si no lo tiene lo genera automaticamente
                    if (!$trazabilidadOld) {
                        $estadoNew = $em->getRepository('AppBundle:CfgComparendoEstado')->find(14);

                        $audiencia = new CvAudiencia();

                        $audiencia->setFecha(new \Datetime(date('Y-m-d')));
                        $audiencia->setHora(new \Datetime(date('h:i:s A')));
                        $audiencia->setTipo('AUTOMATICA');
                        $audiencia->setActivo(true);
                        $audiencia->setComparendo($comparendo);

                        $em->persist($audiencia);
                        $em->flush();

                        $this->generateTrazabilidad($comparendo, $estadoNew);
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
                        $estadoNew = $em->getRepository('AppBundle:CfgComparendoEstado')->find(
                            15
                        );
                        $this->generateTrazabilidad($comparendo, $estadoNew);
                    }
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
                            $estadoNew = $em->getRepository('AppBundle:CfgComparendoEstado')->find(
                                16
                            );

                            $this->generateTrazabilidad($comparendo, $estadoNew);
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
                            $estadoNew = $em->getRepository('AppBundle:CfgComparendoEstado')->find(
                                18
                            );
                            $this->generateTrazabilidad($comparendo, $estadoNew);
                        }
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

                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "No puede registrar un acuerdo de pago sin estar sancionado el comparendo.",
                    );

                    return $helpers->json($response);
                }elseif($estado->getId() == 15){
                    //No genera documento solo un pdf general de todas las notificaciones para el día siguiente al auto de no comparecencia
                }

                $trazabilidad = new CvCdoTrazabilidad();

                $trazabilidad->setFecha(new \Datetime($params->fecha));
                $trazabilidad->setHora(new \Datetime($params->hora));
                if ($params->observaciones) {
                    $trazabilidad->setObservaciones($params->observaciones);
                }
                $trazabilidad->setActivo(true);
                $trazabilidad->setComparendo($comparendo);
                $comparendo->setEstado($estado);
                $trazabilidad->setEstado($estado);

                $em->persist($trazabilidad);
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
                $comparendo->getEstado()->getSigla().'-'.$comparendo->getConsecutivo()->getConsecutivo()
            );
            $documento->setFecha(new \Datetime(date('Y-m-d')));
            $documento->setActivo(true);

            $documento->setFormato(
                $comparendo->getEstado()->getFormato()
            );

            $template = $this->generateTemplate($comparendo);
            $documento->setCuerpo($template);

            $em->persist($documento);
            $em->flush();

            $trazabilidad->setActoAdministrativo($documento);
        }

        $em->persist($trazabilidad);
        $em->flush();
    }
    
    //Migrar a servicio
    public function generateTemplate($comparendo){
        $helpers = $this->get("app.helpers");

        setlocale(LC_ALL,"es_ES");
        $fechaActual = strftime("%d de %B del %Y");

        
        $replaces[] = (object)array('id' => 'NOM', 'value' => $comparendo->getInfractorNombres().' '.$comparendo->getInfractorApellidos()); 
        $replaces[] = (object)array('id' => 'ID', 'value' => $comparendo->getInfractorIdentificacion());
        $replaces[] = (object)array('id' => 'NOC', 'value' => $comparendo->getConsecutivo()->getConsecutivo()); 
        $replaces[] = (object)array('id' => 'FC1', 'value' => $fechaActual);

        if ($comparendo->getInfraccion()) {
            $replaces[] = (object)array('id' => 'DCI', 'value' => $comparendo->getInfraccion()->getDescripcion());
            $replaces[] = (object)array('id' => 'CIC', 'value' => $comparendo->getInfraccion()->getCodigo());
        }

        if ($comparendo->getPlaca()) {
            $replaces[] = (object)array('id' => 'PLACA', 'value' => $comparendo->getPlaca());
        }


        $template = $helpers->createTemplate(
          $comparendo->getEstado()->getFormato()->getCuerpo(),
          $replaces
        );

        $template = str_replace("<br>", "<br/>", $template);

        return $template;
    }
}
