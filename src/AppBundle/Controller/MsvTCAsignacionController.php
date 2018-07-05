<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MsvTCAsignacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Msvtcasignacion controller.
 *
 * @Route("msvtcasignacion")
 */
class MsvTCAsignacionController extends Controller
{
    /**
     * Lists all msvTCAsignacion entities.
     *
     * @Route("/", name="msvtcasignacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        $asignaciones = $em->getRepository('AppBundle:MsvTCAsignacion')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($asignaciones) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => count($asignaciones)." Registros encontrados", 
                'data'=> $asignaciones,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new msvTCAsignacion entity.
     *
     * @Route("/new", name="msvtcasignacion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck== true) {
            $json = $request->get("json",null);
            $params = json_decode($json);


                $asignacion = new MsvTCAsignacion();

                $em = $this->getDoctrine()->getManager();

                $fechaAsignacion = new \Datetime($params->fechaAsignacion);

                $asignacion->setDesde($params->desde);
                $asignacion->setHasta($params->hasta);
                $asignacion->setRangos(($params->hasta + 1) - $params->desde);
                $asignacion->setFechaAsignacion($fechaAsignacion);

                $funcionario = $em->getRepository('AppBundle:MpersonalFuncionario')->find(
                    $params->funcionarioId
                );
                $asignacion->setFuncionario($funcionario);

                $em->persist($asignacion);
                $em->flush();

                // $divipo = $funcionario->getSedeOperativa()->getCodigoDivipo();
                for ($consecutivo=$asignacion->getDesde(); $consecutivo <= $asignacion->getHasta(); $consecutivo++) {

                    // $longitud = (20 - (strlen($divipo)+strlen($consecutivo)));
                    // if ($longitud < 20) {
                    //     $numeroComparendo = $divipo.str_pad($consecutivo, $longitud, '0', STR_PAD_LEFT);
                    // }else{
                    //     $numeroComparendo = $divipo.$consecutivo;
                    // }
                    $numeroComparendo = $consecutivo;
                    
                    $msvTConsecutivo = $em->getRepository('AppBundle:MsvTConsecutivo')->findOneByConsecutivo(
                        $numeroComparendo
                    );

                    if ($msvTConsecutivo) {
                        $msvTConsecutivo->setFechaAsignacion($fechaAsignacion);
                        $msvTConsecutivo->setFuncionario($funcionario);
                        $msvTConsecutivo->setEstado('Asignado');

                        $em->flush();
                    }

                }

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro creado con exito",  
                );
            //}
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida", 
            );
        } 
        return $helpers->json($response);
    }

    /**
     * Finds and displays a msvTCAsignacion entity.
     *
     * @Route("/{id}", name="msvtcasignacion_show")
     * @Method("GET")
     */
    public function showAction(MsvTCAsignacion $msvTCAsignacion)
    {
        $deleteForm = $this->createDeleteForm($msvTCAsignacion);

        return $this->render('msvtcasignacion/show.html.twig', array(
            'msvTCAsignacion' => $msvTCAsignacion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing msvTCAsignacion entity.
     *
     * @Route("/{id}/edit", name="msvtcasignacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MsvTCAsignacion $msvTCAsignacion)
    {
        $deleteForm = $this->createDeleteForm($msvTCAsignacion);
        $editForm = $this->createForm('AppBundle\Form\MsvTCAsignacionType', $msvTCAsignacion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('msvtcasignacion_edit', array('id' => $msvTCAsignacion->getId()));
        }

        return $this->render('msvtcasignacion/edit.html.twig', array(
            'msvTCAsignacion' => $msvTCAsignacion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a msvTCAsignacion entity.
     *
     * @Route("/{id}", name="msvtcasignacion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MsvTCAsignacion $msvTCAsignacion)
    {
        $form = $this->createDeleteForm($msvTCAsignacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($msvTCAsignacion);
            $em->flush();
        }

        return $this->redirectToRoute('msvtcasignacion_index');
    }

    /**
     * Creates a form to delete a msvTCAsignacion entity.
     *
     * @param MsvTCAsignacion $msvTCAsignacion The msvTCAsignacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MsvTCAsignacion $msvTCAsignacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('msvtcasignacion_delete', array('id' => $msvTCAsignacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

        /**
     * Lists all msvTCAsignacion entities.
     *
     * @Route("/search/funcionario/agente", name="msvtcasignacion_search_funcionario_agente")
     * @Method({"GET", "POST"})
     */
    public function searchFuncionarioAgenteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $funcionarios['data'] = array();

        if ($authCheck == true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $funcionarios = $em->getRepository('AppBundle:MsvTCAsignacion')->getFuncionariosByTipoContrato(
                $params, 3
            );
                
            if ($funcionarios == null) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Ningún registro encontrado",
                );
            }else{
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro encontrado", 
                    'data'=> $funcionarios,
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

    /**
     * Lists all mpersonalFuncionario entities.
     *
     * @Route("/record/funcionario", name="msvtcasignacion_record_funcionario")
     * @Method({"GET", "POST"})
     */
    public function recordFuncionarioAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $asignaciones['data'] = array();

        if ($authCheck == true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $asignaciones = $em->getRepository('AppBundle:MsvTVAsignacion')->findByFuncionario(
                $params->id
            );
                
            if ($asignaciones) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => count($asignaciones)." Registros encontrados",  
                    'data'=> $asignaciones,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Ningún registro encontrado",
                    'data' => $response['data'] = array(),
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

    /**
     * Busca peticionario por cedula o por nombre entidad y numero de oficio.
     *
     * @Route("/planilla/{id}/pdf", name="msvtasignacion_pdf")
     * @Method({"GET", "POST"})
     */
    public function pdfAction(Request $request, MpersonalFuncionario $mpersonalFuncionario)
    {
        setlocale(LC_ALL,"es_ES");
        $fechaActual = strftime("%d de %B del %Y");

        $html = $this->renderView('@App/msvTCAsignacion/pdf.template.html.twig', array(
            'mpersonalFuncionario'=>$mpersonalFuncionario,
            'fechaActual' => $fechaActual
        ));

        $pdf = $this->container->get("white_october.tcpdf")->create(
            'LANDSCAPE',
            PDF_UNIT,
            PDF_PAGE_FORMAT,
            true,
            'UTF-8',
            false
        );
        $pdf->SetAuthor('qweqwe');
        $pdf->SetTitle('Prueba TCPDF');
        $pdf->SetSubject('Your client');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        $pdf->setFontSubsetting(true);

        $pdf->SetFont('helvetica', '', 11, '', true);
        $pdf->AddPage();

        $pdf->writeHTMLCell(
            $w = 0,
            $h = 0,
            $x = '',
            $y = '',
            $html,
            $border = 0,
            $ln = 1,
            $fill = 0,
            $reseth = true,
            $align = '',
            $autopadding = true
        );

        $pdf->Output("example.pdf", 'I');
        die();
    }
}
