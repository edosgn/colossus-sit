<?php

namespace JHWEB\ContravencionalBundle\Controller;

use JHWEB\ContravencionalBundle\Entity\CvAudiencia;
use JHWEB\ContravencionalBundle\Entity\CvCdoTrazabilidad;
use JHWEB\ConfigBundle\Entity\CfgAdmActoAdministrativo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Cvaudiencium controller.
 *
 * @Route("cvaudiencia")
 */
class CvAudienciaController extends Controller
{
    /**
     * Lists all cvAudiencium entities.
     *
     * @Route("/", name="cvaudiencia_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $audiencias = $em->getRepository('JHWEBContravencionalBundle:CvAudiencia')->findBy(
            array(
                'activo' => true
            )
        );

        $response['data'] = array();

        if ($audiencias) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($audiencias)." registros encontrados", 
                'data'=> $audiencias,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new cvAudiencium entity.
     *
     * @Route("/new", name="cvaudiencia_new")
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

            $audiencia = new CvAudiencia();

            $helpers = $this->get("app.helpers");

            $fecha = new \Datetime($params->fecha);
            $hora = new \Datetime($params->hora);

            $validarAudiencia = $helpers->getDateAudiencia($fecha, $hora);
            $audiencia->setFecha($validarAudiencia['fecha']);
            $audiencia->setHora($validarAudiencia['hora']);

            if ($params->idComparendo) {
                $comparendo = $em->getRepository('AppBundle:Comparendo')->find(
                    $params->idComparendo
                );
                $audiencia->setComparendo($comparendo);
                $comparendo->setAudiencia(true);
            }

            if ($comparendo) {
                //Busca si existe una audiencia previa programada para este comprendo
                $audienciaOld = $em->getRepository('JHWEBContravencionalBundle:CvAudiencia')->findOneBy(
                    array(
                        'comparendo' => $comparendo->getId(),
                        'activo' => true,
                    )
                );

                if ($audienciaOld) {
                    $audienciaOld->setActivo(false);
                    $em->flush();

                    $audiencia->setTipo('REPROGRAMADA');
                }else{
                    $audiencia->setTipo('MANUAL');
                }
            }

            $audiencia->setActivo(true);

            /*if ($params->objetivo) {
                $audiencia->setObjetivo($params->objetivo);
            }*/

            //Registra trazabilidad de notificación
            $estado = $em->getRepository('AppBundle:CfgComparendoEstado')->find(19);

            $this->generateTrazabilidad($comparendo, $estado);
            
            $em->persist($audiencia);
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
     * Finds and displays a cvAudiencium entity.
     *
     * @Route("/{id}/show", name="cvaudiencia_show")
     * @Method("GET")
     */
    public function showAction(CvAudiencia $cvAudiencium)
    {
        $deleteForm = $this->createDeleteForm($cvAudiencium);

        return $this->render('cvaudiencia/show.html.twig', array(
            'cvAudiencium' => $cvAudiencium,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cvAudiencium entity.
     *
     * @Route("/{id}/edit", name="cvaudiencia_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CvAudiencia $cvAudiencium)
    {
        $deleteForm = $this->createDeleteForm($cvAudiencium);
        $editForm = $this->createForm('JHWEB\ContravencionalBundle\Form\CvAudienciaType', $cvAudiencium);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cvaudiencia_edit', array('id' => $cvAudiencium->getId()));
        }

        return $this->render('cvaudiencia/edit.html.twig', array(
            'cvAudiencium' => $cvAudiencium,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cvAudiencium entity.
     *
     * @Route("/{id}/delete", name="cvaudiencia_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CvAudiencia $cvAudiencium)
    {
        $form = $this->createDeleteForm($cvAudiencium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cvAudiencium);
            $em->flush();
        }

        return $this->redirectToRoute('cvaudiencia_index');
    }

    /**
     * Creates a form to delete a cvAudiencium entity.
     *
     * @param CvAudiencia $cvAudiencium The cvAudiencium entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CvAudiencia $cvAudiencium)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cvaudiencia_delete', array('id' => $cvAudiencium->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ====================== */

    /**
     * Creates a new cvAudiencium entity.
     *
     * @Route("/new/automatic", name="cvaudiencia_new_automatic")
     * @Method({"GET", "POST"})
     */
    public function newAutomaticAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $audiencia = new CvAudiencia();

            /*$audienciaLast = $em->getRepository('JHWEBContravencionalBundle:CvAudiencia')->findOneBy(
                array(
                    'activo' => true
                ),
                array(
                    'fecha' => 'ASC'
                )
            );

            if ($audienciaLast) {
                $nuevaHora = strtotime('+5 minute', strtotime($audienciaLast->getFecha()->format('Y-m-d ').' '.$audienciaLast->getHora()->format('h:m:s')));

                //$validaHora = $this->hourIsBetween($nuevaHora);

                //if ($validaHora) {
                    $audiencia->setFecha(new \Datetime($params->fecha));
                    $audiencia->setHora(new \Datetime(date('h:i:s', $nuevaHora)));
                    $audiencia->setActivo(true);

                    if ($params->idComparendo) {
                        $comparendo = $em->getRepository('AppBundle:Comparendo')->find(
                            $params->idComparendo
                        );
                        $audiencia->setComparendo($comparendo);
                    }
                    
                    $em->persist($audiencia);
                    $em->flush();
                //}

                
            }else{

            }     */ 

            $nuevaHora = strtotime('+5 minute', strtotime($audienciaLast->getFecha()->format('Y-m-d ').' '.$audienciaLast->getHora()->format('h:m:s')));

            $audiencia->setFecha(new \Datetime($params->fecha));
            $audiencia->setHora(new \Datetime(date('h:i:s', $nuevaHora)));
            $audiencia->setActivo(true);

            if ($params->idComparendo) {
                $comparendo = $em->getRepository('AppBundle:Comparendo')->find(
                    $params->idComparendo
                );
                $audiencia->setComparendo($comparendo);
            }
            
            $em->persist($audiencia);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro de audiencia automatica creada con exito",
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

    /*public function hourIsBetween($hora) {
        $horaAmInicial = DateTime::createFromFormat('!H:i', '08:00');
        $horaAmFinal = DateTime::createFromFormat('!H:i', '11:50');
        $horaPmInicial = DateTime::createFromFormat('!H:i', '14:00');
        $horaPmFinal = DateTime::createFromFormat('!H:i', '17:50');

        if (($hora > $horaAmInicial && $hora < $horaAmFinal) || ($hora > $horaPmInicial && $hora < $horaPmFinal)) {
            
        }else{
            $this->hourIsBetween();
        }

       return false;
    }*/

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
