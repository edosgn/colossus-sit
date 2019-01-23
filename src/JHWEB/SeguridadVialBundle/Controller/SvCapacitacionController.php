<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCapacitacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * SvCapacitacion controller.
 *
 * @Route("svCapacitacion")
 */
class SvCapacitacionController extends Controller
{
    /**
     * Lists all svCapacitacion entities.
     *
     * @Route("/", name="svCapacitacion_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            $capacitaciones = $em->getRepository('JHWEBSeguridadVialBundle:SvCapacitacion')->findBy(
            array(
                'activo' => true,
                'cedula' => $params->identificacion
                )
            );
            $response['data'] = array();

            if ($capacitaciones) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($capacitaciones) . " registros encontrados",
                    'data' => $capacitaciones,
                );
            }
            else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No se ha encontrado ningun registro de capacitación para este ciudadano",
                    'data' => $capacitaciones,
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a new SvCapacitacion entity.
     *
     * @Route("/new", name="svCapacitacion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            
            $capacitacion = new SvCapacitacion();

            $em = $this->getDoctrine()->getManager();
            if ($params->municipio) {
                $municipio = $em->getRepository('AppBundle:Municipio')->find($params->municipio);
                $capacitacion->setMunicipio($municipio);
            }
            if ($params->funcion) {
                $funcion = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgFuncion')->find($params->funcion);
                $capacitacion->setFuncion($funcion);
            }
            if ($params->temaCapacitacion) {
                $temaCapacitacion = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTemaCapacitacion')->find($params->temaCapacitacion);
                $capacitacion->setTemaCapacitacion($temaCapacitacion);
            }
            if ($params->claseActorVial) {
                $claseActorVial = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgClaseActorVia')->find($params->claseActorVial);
                $capacitacion->setClaseActorVial($claseActorVial);
            }

            /*if ($params->cedula) {
                $ciudadano = $em->getRepository('AppBundle:Ciudadano')->find($params->cedula);
                var_dump($ciudadano);
                die();
                $capacitacion->setCedula($ciudadano);
            }*/
            $capacitacion->setFechaHoraRegistro(new \Datetime(date('Y-m-d h:i:s', strtotime($params->fechaHoraRegistro))));
            $capacitacion->setEmailFormador($params->emailFormador);
            $capacitacion->setCedula($params->cedula);
            $capacitacion->setFormador($params->formador);
            $capacitacion->setSemana($params->semana);
            $capacitacion->setFechaActividad(new \Datetime($params->fechaActividad));

            if ($params->funcionCriterio) {
                $funcionCriterio = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgFuncionCriterio')->find($params->funcionCriterio);
                $capacitacion->setFuncionCriterio($funcionCriterio);
            }
            $capacitacion->setDescripcionActividad($params->descripcionActividad);
            $capacitacion->setNombreActorVial($params->nombreActorVial);
            $capacitacion->setApellidoActorVial($params->apellidoActorVial);
            $capacitacion->setNumeroCedulaActorVial($params->numeroCedulaActorVial);
            $capacitacion->setActivo(true);
            //$capacitacion->setDocumento($params->documento);

            $file = $request->files->get('file');

            if ($file) {
                $extension = $file->guessExtension();
                $filename = md5(rand() . time()) . "." . $extension;
                $dir = __DIR__ . '/../../../../web/docs';

                $file->move($dir, $filename);
                $capacitacion->setDocumento($filename);
            }

            $em->persist($capacitacion);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Los datos han sido registrados exitosamente.",
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida",
            );
        }
        return $helpers->json($response);
    }


    /**
     * Finds and displays a SvCapacitacion entity.
     *
     * @Route("/{id}", name="svCapacitacion_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(SvCapacitacion $svCapacitacion)
    {
        $deleteForm = $this->createDeleteForm($svCapacitacion);
        return $this->render('svCapacitacion/show.html.twig', array(
            'svCapacitacion' => $svCapacitacion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing SvCapacitacion entity.
     *
     * @Route("/{id}/edit", name="svCapacitacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SvCapacitacion $svCapacitacion)
    {
        $deleteForm = $this->createDeleteForm($svCapacitacion);
        $editForm = $this->createForm('JHWEB\SeguridadVial\Form\SvCapacitacionType', $svCapacitacion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('svCapacitacion_edit', array('id' => $svCapacitacion->getId()));
        }

        return $this->render('svCapacitacion/edit.html.twig', array(
            'svCapacitacion' => $svCapacitacion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a SvCapacitacion entity.
     *
     * @Route("/{id}", name="svCapacitacion_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, SvCapacitacion $svCapacitacion)
    {
        $form = $this->createDeleteForm($svCapacitacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($svCapacitacion);
            $em->flush();
        }

        return $this->redirectToRoute('svCapacitacion_index');
    }

    /**
     * Creates a form to delete a SvCapacitacion entity.
     *
     * @param SvCapacitacion $svCapacitacion The SvCapacitacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCapacitacion $svCapacitacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svCapacitacion_delete', array('id' => $svCapacitacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
