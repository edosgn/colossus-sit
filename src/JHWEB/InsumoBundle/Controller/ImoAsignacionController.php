<?php

namespace JHWEB\InsumoBundle\Controller;

use JHWEB\InsumoBundle\Entity\ImoAsignacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Imoasignacion controller.
 *
 * @Route("imoasignacion")
 */
class ImoAsignacionController extends Controller
{
    /**
     * Lists all imoAsignacion entities.
     *
     * @Route("/", name="imoasignacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $imoAsignacions = $em->getRepository('JHWEBInsumoBundle:ImoAsignacion')->findAll();

        return $this->render('imoasignacion/index.html.twig', array(
            'imoAsignacions' => $imoAsignacions,
        ));
    }

    /**
     * Lists all imoAsignacion entities.
     *
     * @Route("/show/trazabilidad/{trazabilidadId}", name="imoasignacion_index")
     * @Method({"GET", "POST"})
     */
    public function showTrazabilidadAction(Request $request,$trazabilidadId)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $imoAsignacion = $em->getRepository('JHWEBInsumoBundle:ImoAsignacion')->findBy(
                array('imoTrazabilidad' => $trazabilidadId)
            );
    
            $response['data'] = array();
    
            if ($imoAsignacion) { 
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'listado placas',
                    'data' => $imoAsignacion,
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
     * Creates a new imoAsignacion entity.
     *
     * @Route("/new", name="imoasignacion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $imoAsignacion = new Imoasignacion();
        $form = $this->createForm('JHWEB\InsumoBundle\Form\ImoAsignacionType', $imoAsignacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($imoAsignacion); 
            $em->flush();

            return $this->redirectToRoute('imoasignacion_show', array('id' => $imoAsignacion->getId()));
        }

        return $this->render('imoasignacion/new.html.twig', array(
            'imoAsignacion' => $imoAsignacion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a imoAsignacion entity.
     *
     * @Route("/{id}", name="imoasignacion_show")
     * @Method("GET")
     */
    public function showAction(ImoAsignacion $imoAsignacion)
    {
        $deleteForm = $this->createDeleteForm($imoAsignacion);

        return $this->render('imoasignacion/show.html.twig', array(
            'imoAsignacion' => $imoAsignacion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing imoAsignacion entity.
     *
     * @Route("/{id}/edit", name="imoasignacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ImoAsignacion $imoAsignacion)
    {
        $deleteForm = $this->createDeleteForm($imoAsignacion);
        $editForm = $this->createForm('JHWEB\InsumoBundle\Form\ImoAsignacionType', $imoAsignacion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('imoasignacion_edit', array('id' => $imoAsignacion->getId()));
        }

        return $this->render('imoasignacion/edit.html.twig', array(
            'imoAsignacion' => $imoAsignacion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a imoAsignacion entity.
     *
     * @Route("/{id}", name="imoasignacion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ImoAsignacion $imoAsignacion)
    {
        $form = $this->createDeleteForm($imoAsignacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($imoAsignacion);
            $em->flush();
        }

        return $this->redirectToRoute('imoasignacion_index');
    }

    /**
     * Creates a form to delete a imoAsignacion entity.
     *
     * @param ImoAsignacion $imoAsignacion The imoAsignacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ImoAsignacion $imoAsignacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('imoasignacion_delete', array('id' => $imoAsignacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ============================================ */

    /**
     * Creates a new Cuenta entity.
     *
     * @Route("/pdf/acta/reasignacion", name="imoasignacion_pdf_acta_reasignacion")
     * @Method({"GET", "POST"})
     */
    public function pdfAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            setlocale(LC_ALL,"es_ES");
            $fechaActual = strftime("%d de %B del %Y");

            $em = $this->getDoctrine()->getManager();
            
            $trazabilidad = $em->getRepository('JHWEBInsumoBundle:ImoTrazabilidad')->find(
                $params->idTrazabilidad
            );
            
            $funcionario = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->find(
                $params->idFuncionario
            );

            $reasignaciones = $em->getRepository('JHWEBInsumoBundle:ImoAsignacion')->findBy(
                array(
                    'imoTrazabilidad' => $trazabilidad->getId()
                )
            );

            if ($trazabilidad) {
                $html = $this->renderView('@JHWEBInsumo/Default/pdf.acta.reasignacion.html.twig', array(
                    'reasignaciones' => $reasignaciones,
                    'trazabilidad' => $trazabilidad,
                    'funcionario' => $funcionario,
                )); 
    
                return new Response(
                    $this->get('app.pdf')->templatePreview($html, 'Acta reasignacion'),
                    200,
                    array(
                        'Content-Type'        => 'application/pdf',
                        'Content-Disposition' => 'attachment; filename="acta_reasignacion.pdf"'
                    )
                );
            }else{
                $response = array(
                    'title' => 'Atención!!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => 'No existen reasignaciones.', 
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
