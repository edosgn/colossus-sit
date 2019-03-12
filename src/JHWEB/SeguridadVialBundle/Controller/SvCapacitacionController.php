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
                $municipio = $em->getRepository('JHWEBConfigBundle:CfgMunicipio')->find($params->municipio);
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

            $identificacion = (isset($params->identificacion)) ? $params->identificacion : null;
            $nit = (isset($params->nit)) ? $params->nit : null;
            if ($params->identificacion) {
                $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findOneBy(array('identificacion'=> $params->identificacion));
                $capacitacion->setCiudadano($ciudadano);
            }
            if ($params->nit) {
                $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->findOneBy(array('nit'=> $params->nit));
                $capacitacion->setEmpresa($empresa);
            }
            
            $capacitacion->setFechaHoraRegistro(new \Datetime($params->fechaHoraRegistro));
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

            $file = $request->files->get('file');

            if ($file) {
                $extension = $file->guessExtension();
                $filename = md5(rand() . time()) . "." . $extension;
                $dir = __DIR__ . '/../../../../web/docs/sv_capacitaciones';

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

    /**
     * Lists all svCapacitacion by ciudadano entities.
     *
     * @Route("/buscar/capacitacionbyciudadano", name="svCapacitacion_ciudadano")
     * @Method({"GET", "POST"})
     */
    public function buscarCapacitacionByCiudadano(Request $request) {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            var_dump($params);
            die();
            if($params->idTipoIdentificacion == 1) {
                $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findBy(array('identificacion' => $params->identificacion));
                $capacitaciones = $em->getRepository('JHWEBSeguridadVialBundle:SvCapacitacion')->findBy(
                array(
                    'activo' => true,
                    'ciudadano' => $ciudadano
                    )
                );
            }
            
            if($params->idTipoIdentificacion == 4) {
                $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->findBy(array('nit' => $params->nit));
                $capacitaciones = $em->getRepository('JHWEBSeguridadVialBundle:SvCapacitacion')->findBy(
                array(
                    'activo' => true,
                    'empresa' => $empresa
                    )
                );
            }

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
                    'message' => "No se ha encontrado ningun registro de capacitación.",
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
}
