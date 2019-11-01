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

            /*$validarAudiencia = $helpers->getDateAudienciaManual($fecha, $hora);
            $audiencia->setFecha($validarAudiencia['fecha']);
            $audiencia->setHora($validarAudiencia['hora']);*/

            $audiencia->setFecha($fecha);
            $audiencia->setHora($hora);

            if ($params->idComparendo) {
                $comparendo = $em->getRepository('JHWEBContravencionalBundle:CvCdoComparendo')->find(
                    $params->idComparendo
                );
                $audiencia->setComparendo($comparendo);
                $comparendo->setAudiencia(true);
            }

            if ($params->idTipo) {
                $tipo = $em->getRepository('JHWEBContravencionalBundle:CvAuCfgTipo')->find(
                    $params->idTipo
                );
                $audiencia->setTipo($tipo);
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

                    $audiencia->setEstado('REPROGRAMADA');
                }else{
                    $audiencia->setEstado('MANUAL');
                }
            }

            $audiencia->setActivo(true);

            //Registra trazabilidad de audiencia
            $trazabilidad = $em->getRepository('JHWEBContravencionalBundle:CvCdoTrazabilidad')->findBy(
                array(
                    'comparendo' => $comparendo->getId(),
                    'estado' => 19,
                    'activo' => true,
                )
            );

            if (!$trazabilidad) {
                $estado = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->find(19);
                $helpers->generateTrazabilidad($comparendo, $estado);
            }
            
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
     * @Route("/edit", name="cvaudiencia_edit")
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

            $audiencia = $em->getRepository("JHWEBContravencionalBundle:CvAudiencia")->find(
                $params->id
            );

            if ($audiencia) {
                $audiencia->setPorcentaje($params->porcentaje);
                $audiencia->setFechaInicial(
                    new \Datetime($params->fechaInicial)
                );
                $audiencia->setFechaFinal(
                    new \Datetime($params->fechaFinal)
                );

                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $audiencia,
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
                        $comparendo = $em->getRepository('JHWEBContravencionalBundle:CvCdoComparendo')->find(
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
                $comparendo = $em->getRepository('JHWEBContravencionalBundle:CvCdoComparendo')->find(
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
                $comparendo->getEstado()->getSigla().'-'.$comparendo->getConsecutivo()->getNumero()
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

    /**
     * Busca audiencias por id de Comparendo.
     *
     * @Route("/search/comparendo", name="cvaudiencia_search_comparendo")
     * @Method({"GET","POST"})
     */
    public function searchByComparendo(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $comparendo = $em->getRepository('JHWEBContravencionalBundle:CvCdoComparendo')->find(
                $params->idComparendo
            );

            if ($comprendo) {
                $audiencias = $em->getRepository('JHWEBContravencionalBundle:CvAudiencia')->findBy(
                    array(
                        'comparendo' => $comparendo->getId()
                    )
                );
    
                if ($audiencias) {
                    $response = array(
                        'title' => 'Perfecto!',
                        'status' => 'success',
                        'code' => 200,
                        'message' => count($audiencias)." audiencias encontradas", 
                        'data' => $audiencias,
                    );
                }else{
                    $response = array(
                        'title' => 'Atención!',
                        'status' => 'error',
                        'code' => 400,
                        'message' => "No existen audiencias para el comparendo seleccionado.", 
                    );
                }
            } else {
                $response = array(
                    'title' => 'Atención!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Comparendo no encontrado.", 
                );
            }
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
     * Busca audiencias por parametros (identificacion, No. comparendo o fecha).
     *
     * @Route("/search/filtros", name="cvaudiencia_search_filtros")
     * @Method({"GET","POST"})
     */
    public function searchByFiltros(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $audiencias = $em->getRepository('JHWEBContravencionalBundle:CvAudiencia')->getByFilter(
                $params
            );

            if ($audiencias) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($audiencias)." audiencias encontrados", 
                    'data' => $audiencias,
            );
            }else{
                 $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No existen audiencias para esos filtros de búsqueda", 
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
     * Busca ultima audiencia programada.
     *
     * @Route("/search/last", name="cvaudiencia_search_last")
     * @Method({"GET","POST"})
     */
    public function searchLast(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();

            $audienciaLast = $em->getRepository('JHWEBContravencionalBundle:CvAudiencia')->getLast();
 
            if ($audienciaLast['id']) {
                $audiencia = $em->getRepository('JHWEBContravencionalBundle:CvAudiencia')->find(
                    $audienciaLast['id']
                );

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Ultima audiencia programada para el ".$audiencia->getFecha()->format('d/m/Y')." ".$audiencia->getHora()->format('h:i:s A'), 
                    'data' => $audiencia,
                );
            }else{
                 $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No existen audiencias programadas.", 
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
     * Displays a form to edit an existing cvAudiencium entity.
     *
     * @Route("/update/cuerpo", name="cvaudiencia_update_cuerpo")
     * @Method({"GET", "POST"})
     */
    public function updateCuerpoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $audiencia = $em->getRepository("JHWEBContravencionalBundle:CvAudiencia")->find(
                $params->id
            );

            if ($audiencia) {
                $audiencia->setCuerpo($params->cuerpo);

                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $audiencia,
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
     * Crea PDF con el cuerpo de audiencia.
     *
     * @Route("/{id}/pdf", name="cvaudiencia_pdf")
     * @Method({"GET", "POST"})
     */
    public function pdfAction(Request $request, $id)
    {
        setlocale(LC_ALL,"es_ES");
        $fechaActual = strftime("%d de %B del %Y");

        $em = $this->getDoctrine()->getManager();

        $audiencia = $em->getRepository('JHWEBContravencionalBundle:CvAudiencia')->find(
            $id
        );

        $html = $this->renderView('@JHWEBContravencional/Default/pdf.html.twig', array(
            'fechaActual' => $fechaActual,
            'audiencia'=>$audiencia,
        ));

        $this->get('app.pdf')->templatePreview($html, 'AUDIENCIA '.$audiencia->getTipo()->getNombre());
    }
}
