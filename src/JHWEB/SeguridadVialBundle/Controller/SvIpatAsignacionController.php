<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvIpatAsignacion;
use JHWEB\SeguridadVialBundle\Entity\SvIpatConsecutivo;
use JHWEB\SeguridadVialBundle\Entity\SvIpatTalonario;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svipatasignacion controller.
 *
 * @Route("svipatasignacion")
 */
class SvIpatAsignacionController extends Controller
{
    /**
     * Lists all svIpatAsignacion entities.
     *
     * @Route("/", name="svipatasignacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $svIpatAsignacions = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatAsignacion')->findAll();

        return $this->render('svipatasignacion/index.html.twig', array(
            'svIpatAsignacions' => $svIpatAsignacions,
        ));
    }

    /**
     * Creates a new svIpatAsignacion entity.
     *
     * @Route("/new", name="svipatasignacion_new")
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

            $asignacion = new SvIpatAsignacion();

            $talonario = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatTalonario')->find(
                $params->idTalonario
            );
            $asignacion->setTalonario($talonario);

            $fecha = new \Datetime($params->fecha);

            $asignacion->setRangoInicial($params->rangoInicial);
            $asignacion->setRangoFinal($params->rangoFinal);
            $asignacion->setTotal($params->total);
            $asignacion->setFecha($fecha);
            $asignacion->setActivo(true);

            $consecutivo = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatAsignacion')->getMaximo(date('Y'));
            $consecutivo = (empty($consecutivo['maximo']) ? 1 : $consecutivo['maximo']+=1);
            
            $asignacion->setNumeroActa(
                $fecha->format('Y').$fecha->format('m').str_pad($consecutivo, 3, '0', STR_PAD_LEFT)
            );

            $talonario->setDisponible($talonario->getTotal() - $params->total);

            $em->persist($asignacion);
            $em->flush();

            $divipo = $talonario->getOrganismoTransito()->getDivipo();

            for ($rango = $asignacion->getRangoInicial(); $rango <= $asignacion->getRangoFinal(); $rango++) {
                $consecutivo = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatConsecutivo')->findOneBy(
                    array(
                        'numero' => $divipo.$rango,
                    )
                );
                
                $consecutivo->setAsignacion($asignacion);
                $consecutivo->setEstado("ASIGNADO");

                $em->flush();
            }
        
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Registros asignados con exito.', 
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
     * Finds and displays a svIpatAsignacion entity.
     *
     * @Route("/{id}/show", name="svipatasignacion_show")
     * @Method("GET")
     */
    public function showAction(SvIpatAsignacion $svIpatAsignacion)
    {
        $deleteForm = $this->createDeleteForm($svIpatAsignacion);

        return $this->render('svipatasignacion/show.html.twig', array(
            'svIpatAsignacion' => $svIpatAsignacion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing svIpatAsignacion entity.
     *
     * @Route("/{id}/edit", name="svipatasignacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SvIpatAsignacion $svIpatAsignacion)
    {
        $deleteForm = $this->createDeleteForm($svIpatAsignacion);
        $editForm = $this->createForm('JHWEB\SeguridadVialBundle\Form\SvIpatAsignacionType', $svIpatAsignacion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('svipatasignacion_edit', array('id' => $svIpatAsignacion->getId()));
        }

        return $this->render('svipatasignacion/edit.html.twig', array(
            'svIpatAsignacion' => $svIpatAsignacion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a svIpatAsignacion entity.
     *
     * @Route("/{id}/delete", name="svipatasignacion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SvIpatAsignacion $svIpatAsignacion)
    {
        $form = $this->createDeleteForm($svIpatAsignacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($svIpatAsignacion);
            $em->flush();
        }

        return $this->redirectToRoute('svipatasignacion_index');
    }

    /**
     * Creates a form to delete a svIpatAsignacion entity.
     *
     * @param SvIpatAsignacion $svIpatAsignacion The svIpatAsignacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvIpatAsignacion $svIpatAsignacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svipatasignacion_delete', array('id' => $svIpatAsignacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ============================================================== */

    /**
     * Busca todas las asignaciones por talonario.
     *
     * @Route("/record/talonario", name="svipatasignacion_record_talonario")
     * @Method({"GET", "POST"})
     */
    public function recordByTalonarioAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        
        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $asignaciones = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatAsignacion')->findBy(
                array(
                    'talonario' => $params->idTalonario
                )
            );
                
            if ($asignaciones) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($asignaciones).' Registros encontrados',  
                    'data'=> $asignaciones,
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
                'message' => 'Autorizacion no valida', 
            );
        }

        return $helpers->json($response);
    }

    /**
     * Genera el acta de entrega de impresos.
     *
     * @Route("/acta/{id}/pdf", name="svipatasignacion_acta_pdf")
     * @Method({"GET", "POST"})
     */
    public function pdfAction(Request $request, $id)
    {
        setlocale(LC_ALL,"es_ES");
        $fechaActual = strftime("%d de %B del %Y");

        $em = $this->getDoctrine()->getManager();

        $asignacion = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatAsignacion')->find(
            $id
        );

        $consecutivos = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatConsecutivo')->findBy(
            array(
                'asignacion' => $asignacion->getId(),
            )
        );

        $html = $this->renderView('@JHWEBSeguridadVial/Default/pdf.asignacion.html.twig', array(
            'asignacion' => $asignacion,
            'consecutivos' => $consecutivos,
            'fechaActual' => $fechaActual
        ));

        $this->get('app.pdf')->templateActaIpat($html, $asignacion);
    }
}
