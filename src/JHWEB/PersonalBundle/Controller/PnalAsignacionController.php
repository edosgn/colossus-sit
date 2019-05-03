<?php

namespace JHWEB\PersonalBundle\Controller;

use JHWEB\PersonalBundle\Entity\PnalAsignacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Pnalasignacion controller.
 *
 * @Route("pnalasignacion")
 */
class PnalAsignacionController extends Controller
{
    /**
     * Lists all pnalAsignacion entities.
     *
     * @Route("/", name="pnalasignacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        $asignaciones = $em->getRepository('JHWEBPersonalBundle:PnalAsignacion')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($asignaciones) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($asignaciones).' registros encontrados.', 
                'data'=> $asignaciones,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new pnalAsignacion entity.
     *
     * @Route("/new", name="pnalasignacion_new")
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

            $asignacion = new PnalAsignacion();

            $em = $this->getDoctrine()->getManager();

            $fechaAsignacion = new \Datetime($params->fechaAsignacion);

            $asignacion->setDesde($params->desde);
            $asignacion->setHasta($params->hasta);
            $asignacion->setRangos(($params->hasta + 1) - $params->desde);
            $asignacion->setFecha($fechaAsignacion);
            $asignacion->setActivo(true);

            $funcionario = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->find(
                $params->idFuncionario
            );
            $asignacion->setFuncionario($funcionario);

            $em->persist($asignacion);
            $em->flush();

            $divipo = $funcionario->getOrganismoTransito()->getDivipo();

            for ($numero=$asignacion->getDesde(); $numero <= $asignacion->getHasta(); $numero++) {
                if ($funcionario->getOrganismoTransito()->getAsignacionRango()) {
                    $numeroComparendo = $divipo.$numero;
                }else{
                    $numeroComparendo = $numero;
                }
                
                $consecutivo = $em->getRepository('JHWEBPersonalBundle:PnalCfgCdoConsecutivo')->findOneByNumero(
                    $numeroComparendo
                );

                if ($consecutivo) {
                    $consecutivo->setFechaAsignacion($fechaAsignacion);
                    $consecutivo->setFuncionario($funcionario);
                    $consecutivo->setEstado('ASIGNADO');

                    $em->flush();
                }
            }

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Registro creado con exito.',  
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida.', 
            );
        }

        return $helpers->json($response);
    }

    /**
     * Finds and displays a pnalAsignacion entity.
     *
     * @Route("/{id}", name="pnalasignacion_show")
     * @Method("GET")
     */
    public function showAction(PnalAsignacion $pnalAsignacion)
    {
        $deleteForm = $this->createDeleteForm($pnalAsignacion);

        return $this->render('pnalasignacion/show.html.twig', array(
            'pnalAsignacion' => $pnalAsignacion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing pnalAsignacion entity.
     *
     * @Route("/{id}/edit", name="pnalasignacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, PnalAsignacion $pnalAsignacion)
    {
        $deleteForm = $this->createDeleteForm($pnalAsignacion);
        $editForm = $this->createForm('JHWEB\PersonalBundle\Form\PnalAsignacionType', $pnalAsignacion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pnalasignacion_edit', array('id' => $pnalAsignacion->getId()));
        }

        return $this->render('pnalasignacion/edit.html.twig', array(
            'pnalAsignacion' => $pnalAsignacion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a pnalAsignacion entity.
     *
     * @Route("/{id}", name="pnalasignacion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, PnalAsignacion $pnalAsignacion)
    {
        $form = $this->createDeleteForm($pnalAsignacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pnalAsignacion);
            $em->flush();
        }

        return $this->redirectToRoute('pnalasignacion_index');
    }

    /**
     * Creates a form to delete a pnalAsignacion entity.
     *
     * @param PnalAsignacion $pnalAsignacion The pnalAsignacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PnalAsignacion $pnalAsignacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pnalasignacion_delete', array('id' => $pnalAsignacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ================================================== */

    /**
     * Lists all mpersonalFuncionario entities.
     *
     * @Route("/search/funcionario/agente", name="pnalasignacion_search_funcionario_agente")
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
            $json = $request->get("data",null);
            $params = json_decode($json);

            $funcionarios = $em->getRepository('JHWEBPersonalBundle:PnalAsignacion')->getFuncionariosByCargo(
                $params, 1
            );
                
            if ($funcionarios) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Registro encontrado.', 
                    'data'=> $funcionarios,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Ningún registro encontrado.',
                );
            }            
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Autorizacion no valida.', 
                );
        }
        return $helpers->json($response);
    }

    /**
     * Lists all mpersonalFuncionario entities.
     *
     * @Route("/record/funcionario", name="pnalasignacion_record_funcionario")
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

            $asignaciones = $em->getRepository('JHWEBPersonalBundle:PnalAsignacion')->findByFuncionario(
                $params->id
            );
                
            if ($asignaciones) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($asignaciones)." registros encontrados",  
                    'data'=> $asignaciones,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Ningún registro encontrado",
                    'data' => $response['data'] = array(),
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
     * Busca peticionario por cedula o por nombre entidad y numero de oficio.
     *
     * @Route("/planilla/{id}/pdf", name="pnalasignacion_pdf")
     * @Method({"GET", "POST"})
     */
    public function pdfAction(Request $request, $id)
    {
        setlocale(LC_ALL,"es_ES");
        $fechaActual = strftime("%d de %B del %Y");

        $em = $this->getDoctrine()->getManager();

        $funcionario = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->find(
            $id
        );

        $asignaciones = $em->getRepository('JHWEBPersonalBundle:PnalAsignacion')->findByFuncionario(
            $funcionario->getId()
        );

        $html = $this->renderView('@JHWEBPersonal/Default/pdf.acta.html.twig', array(
            'funcionario'=>$funcionario,
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
