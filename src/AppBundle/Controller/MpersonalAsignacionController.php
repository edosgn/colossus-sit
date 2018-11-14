<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MpersonalAsignacion;
use AppBundle\Entity\MpersonalFuncionario;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Mpersonalasignacion controller.
 *
 * @Route("mpersonalasignacion")
 */
class MpersonalAsignacionController extends Controller
{
    /**
     * Lists all mpersonalAsignacion entities.
     *
     * @Route("/", name="mpersonalasignacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        $asignaciones = $em->getRepository('AppBundle:MpersonalAsignacion')->findBy(
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
     * Creates a new mpersonalAsignacion entity.
     *
     * @Route("/new", name="mpersonalasignacion_new")
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

            $asignacion = new MpersonalAsignacion();

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

            $divipo = $funcionario->getSedeOperativa()->getCodigoDivipo();

            for ($consecutivo=$asignacion->getDesde(); $consecutivo <= $asignacion->getHasta(); $consecutivo++) {
               
                $numeroComparendo = $divipo.$consecutivo;
                
                $comparendo = $em->getRepository('AppBundle:MpersonalComparendo')->findOneByConsecutivo(
                    $numeroComparendo
                );

                if ($comparendo) {
                    $comparendo->setFechaAsignacion($fechaAsignacion);
                    $comparendo->setFuncionario($funcionario);
                    $comparendo->setEstado('ASIGNADO');

                    $em->flush();
                }

            }

            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "Registro creado con exito",  
            );
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
     * Finds and displays a mpersonalAsignacion entity.
     *
     * @Route("/{id}", name="mpersonalasignacion_show")
     * @Method("GET")
     */
    public function showAction(MpersonalAsignacion $mpersonalAsignacion)
    {
        $deleteForm = $this->createDeleteForm($mpersonalAsignacion);

        return $this->render('mpersonalasignacion/show.html.twig', array(
            'mpersonalAsignacion' => $mpersonalAsignacion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing mpersonalAsignacion entity.
     *
     * @Route("/{id}/edit", name="mpersonalasignacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MpersonalAsignacion $mpersonalAsignacion)
    {
        $deleteForm = $this->createDeleteForm($mpersonalAsignacion);
        $editForm = $this->createForm('AppBundle\Form\MpersonalAsignacionType', $mpersonalAsignacion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mpersonalasignacion_edit', array('id' => $mpersonalAsignacion->getId()));
        }

        return $this->render('mpersonalasignacion/edit.html.twig', array(
            'mpersonalAsignacion' => $mpersonalAsignacion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a mpersonalAsignacion entity.
     *
     * @Route("/{id}", name="mpersonalasignacion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MpersonalAsignacion $mpersonalAsignacion)
    {
        $form = $this->createDeleteForm($mpersonalAsignacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mpersonalAsignacion);
            $em->flush();
        }

        return $this->redirectToRoute('mpersonalasignacion_index');
    }

    /**
     * Creates a form to delete a mpersonalAsignacion entity.
     *
     * @param MpersonalAsignacion $mpersonalAsignacion The mpersonalAsignacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MpersonalAsignacion $mpersonalAsignacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mpersonalasignacion_delete', array('id' => $mpersonalAsignacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Lists all mpersonalFuncionario entities.
     *
     * @Route("/search/funcionario/agente", name="mpersonalasignacion_search_funcionario_agente")
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

            $funcionarios = $em->getRepository('AppBundle:MpersonalAsignacion')->getFuncionariosByTipoContrato(
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
     * @Route("/record/funcionario", name="mpersonalasignacion_record_funcionario")
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

            $asignaciones = $em->getRepository('AppBundle:MpersonalAsignacion')->findByFuncionario(
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
     * @Route("/planilla/{id}/pdf", name="mpersonalasignacion_pdf")
     * @Method({"GET", "POST"})
     */
    public function pdfAction(Request $request, MpersonalFuncionario $mpersonalFuncionario)
    {
        setlocale(LC_ALL,"es_ES");
        $fechaActual = strftime("%d de %B del %Y");

        $em = $this->getDoctrine()->getManager();

        $asignaciones = $em->getRepository('AppBundle:MpersonalAsignacion')->findByFuncionario(
            $mpersonalFuncionario->getId()
        );

        $html = $this->renderView('@App/mpersonalasignacion/pdf.template.html.twig', array(
            'mpersonalFuncionario'=>$mpersonalFuncionario,
            'asignaciones' => $asignaciones,
            'fechaActual' => $fechaActual
        ));

        $pdf = $this->container->get("white_october.tcpdf")->create(
            'PORTRAIT',
            PDF_UNIT,
            PDF_PAGE_FORMAT,
            true,
            'UTF-8',
            false
        );
        $pdf->SetAuthor('qweqwe');
        $pdf->SetTitle('Planilla');
        $pdf->SetSubject('Your client');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        $pdf->setFontSubsetting(true);

        $pdf->SetFont('helvetica', '', 11, '', true);
        $pdf->SetMargins('25', '25', '25');
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
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
