<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCapacitacion;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * SvCapacitacion controller.
 *
 * @Route("svcapacitacion")
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
            
            $em = $this->getDoctrine()->getManager();

            $capacitacion = new SvCapacitacion();

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

            $identificacion = (isset($params->identificacion)) ? $params->identificacion : null;
            $nit = (isset($params->nit)) ? $params->nit : null;
            if ($params->identificacion) {
                $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findOneBy(array('identificacion' => $params->identificacion));
                $capacitacion->setCiudadano($ciudadano);
            }
            if ($params->nit) {
                $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->findOneBy(array('nit' => $params->nit));
                $capacitacion->setEmpresa($empresa);
            }

            $capacitacion->setFechaHoraRegistro(new \Datetime($params->fechaHoraRegistro));
            $capacitacion->setFechaActividad(new \Datetime($params->fechaActividad));

            if ($params->funcionCriterio) {
                $funcionCriterio = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgFuncionCriterio')->find($params->funcionCriterio);
                $capacitacion->setFuncionCriterio($funcionCriterio);
            }
            $capacitacion->setDescripcionActividad($params->descripcionActividad);

            $idTipoIdentificacion = (isset($params->idTipoIdentificacion)) ? $params->idTipoIdentificacion : null;
            if ($idTipoIdentificacion) {
                $tipoIdentificacion = $em->getRepository('JHWEBUsuarioBundle:UserCfgTipoIdentificacion')->find($idTipoIdentificacion);
                $capacitacion->setTipoIdentificacionActorVial($tipoIdentificacion);
            }

            $capacitacion->setNumeroCedulaActorVial($params->numeroCedulaActorVial);
            $capacitacion->setNombreActorVial($params->nombreActorVial);
            $capacitacion->setApellidoActorVial($params->apellidoActorVial);
            $capacitacion->setfechaNacimientoActorVial(new \Datetime ($params->fechaNacimientoActorVial));
            $capacitacion->setEmailActorVial($params->emailActorVial);
            
            if ($params->genero) {
                $genero = $em->getRepository('JHWEBUsuarioBundle:UserCfgGenero')->find($params->genero);
                $capacitacion->setGenero($genero);
            }
            
            if ($params->idGrupoEtnico) {
                $grupoEtnico = $em->getRepository('JHWEBUsuarioBundle:UserCfgGrupoEtnico')->find($params->idGrupoEtnico);
                $capacitacion->setGrupoEtnicoActorVial($grupoEtnico);
            }

            if ($params->claseActorVial) {
                $claseActorVial = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgClaseActorVia')->find($params->claseActorVial);
                $capacitacion->setClaseActorVial($claseActorVial);
            }

            $capacitacion->setDiscapacidad($params->discapacidad);
            $capacitacion->setVictima($params->victima);

            $capacitacion->setActivo(true);

            $file = $request->files->get('file');

            if ($file) {
                $extension = $file->guessExtension();
                $filename = md5(rand() . time()) . "." . $extension;
                $dir = __DIR__ . '/../../../../web/docs/capacitaciones';

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
     * Lists all svCapacitacion by ciudadano entities.
     *
     * @Route("/buscar/capacitacionbyciudadano", name="svCapacitacion_ciudadano")
     * @Method({"GET", "POST"})
     */
    public function buscarCapacitacionByCiudadano(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            
            if ($params->idTipoIdentificacion == 1) {
                $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findOneBy(array('identificacion' => $params->identificacion));
                $capacitaciones = $em->getRepository('JHWEBSeguridadVialBundle:SvCapacitacion')->findBy(
                    array(
                        'activo' => true,
                        'ciudadano' => $ciudadano,
                    )
                );
            }

            if ($params->idTipoIdentificacion == 4) {
                $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->findBy(array('nit' => $params->nit));
                $capacitaciones = $em->getRepository('JHWEBSeguridadVialBundle:SvCapacitacion')->findBy(
                    array(
                        'activo' => true,
                        'empresa' => $empresa,
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
            } else {
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

    /**
     * cargar personas capacitadas.
     *
     * @Route("/cargar/capacitados", name="cargar_capacitados")
     * @Method({"GET", "POST"})
     */
    public function cargarCapacitadosAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        $em = $this->getDoctrine()->getManager();

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();

            if ($params->file == null) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Por favor seleccione un archivo para subir",
                );
            } else {
                foreach ($params->file as $key => $dato) {

                    $capacitacion = new SvCapacitacion();

                    $capacitacion->setFechaHoraRegistro(new \Datetime($params->capacitacion->fechaHoraRegistro));

                    $identificacion = (isset($params->capacitacion->identificacion)) ? $params->capacitacion->identificacion : null;
                    $nit = (isset($params->capacitacion->nit)) ? $params->capacitacion->nit : null;

                    $ciudadano = null;
                    $empresa = null;
                    
                    if ($params->capacitacion->identificacion) {
                        $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findOneBy(array('identificacion' => $params->capacitacion->identificacion));
                        $capacitacion->setCiudadano($ciudadano);
                    }

                    if ($params->capacitacion->nit) {
                        $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->findOneBy(array('nit' => $params->capacitacion->nit));
                        $capacitacion->setEmpresa($empresa);
                    }
                    
                    $capacitacion->setFechaActividad(new \Datetime($params->capacitacion->fechaActividad));
                    
                    if ($params->capacitacion->municipio) {
                        $municipio = $em->getRepository('JHWEBConfigBundle:CfgMunicipio')->find($params->capacitacion->municipio);
                        $capacitacion->setMunicipio($municipio);
                    }

                    if ($params->capacitacion->funcion) {
                        $funcion = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgFuncion')->find($params->capacitacion->funcion);
                        $capacitacion->setFuncion($funcion);
                    }

                    if ($params->capacitacion->funcionCriterio) {
                        $funcionCriterio = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgFuncionCriterio')->find($params->capacitacion->funcionCriterio);
                        $capacitacion->setFuncionCriterio($funcionCriterio);
                    }

                    if ($params->capacitacion->temaCapacitacion) {
                        $temaCapacitacion = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTemaCapacitacion')->find($params->capacitacion->temaCapacitacion);
                        $capacitacion->setTemaCapacitacion($temaCapacitacion);
                    }

                    $capacitacion->setDescripcionActividad($params->capacitacion->descripcionActividad);

                    //DATOS PERSONAS CAPACITADAS
                    $tipoIdentificacion = $em->getRepository('JHWEBUsuarioBundle:UserCfgTipoIdentificacion')->findOneBy(
                        array(
                            'sigla' => $dato[0],
                            'activo' => true,
                        )
                    );
                    $capacitacion->setTipoIdentificacionActorVial($tipoIdentificacion);

                    $capacitacion->setNumeroCedulaActorVial($dato[1]);
                    $capacitacion->setNombreActorVial($dato[2]);
                    $capacitacion->setApellidoActorVial($dato[3]);
                    $capacitacion->setFechaNacimientoActorVial(new \Datetime ($dato[4]));
                    $capacitacion->setEmailActorVial($dato[5]);                    

                    $genero = $em->getRepository('JHWEBUsuarioBundle:UserCfgGenero')->findOneBy(
                         array (
                            'sigla' => $dato[6]
                        ));
                    $capacitacion->setGenero($genero);

                    $grupoEtnico = $em->getRepository('JHWEBUsuarioBundle:UserCfgGrupoEtnico')->findOneBy(
                        array(
                            'nombre' => $dato[7]
                        ));
                    $capacitacion->setGrupoEtnicoActorVial($grupoEtnico);

                    $claseActorVial = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgClaseActorVia')->findOneBy(
                        array(
                            'nombre' => $dato[8]
                        ));
                    $capacitacion->setClaseActorVial($claseActorVial);
                    
                    $capacitacion->setDiscapacidad($dato[9]);
                    $capacitacion->setVictima($dato[10]);

                    $capacitacion->setActivo(true);

                    $em->persist($capacitacion);
                    $em->flush();

                }

                if ($ciudadano) {
                    $capacitaciones = $em->getRepository('JHWEBSeguridadVialBundle:SvCapacitacion')->findBy(
                        array(
                        'ciudadano' => $ciudadano,
                        'activo' => true,
                        )
                    );
                }

                if ($empresa) {
                    $capacitaciones = $em->getRepository('JHWEBSeguridadVialBundle:SvCapacitacion')->findBy(
                        array(
                        'empresa' => $empresa,
                        'activo' => true,
                        )
                    );
                }

                $response['data'] = array();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Los datos se cargaron satisfactoriamente.",
                    'data' => $capacitaciones
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
     * Lists all show by capacitacion entities.
     *
     * @Route("/show/capacitacion", name="show_by_capacitacion")
     * @Method({"GET", "POST"})
     */
    public function showByCapacitacion(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();

            var_dump($params);
            die();
            
            $response['data'] = array();

            if ($capacitaciones) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($capacitaciones) . " registros encontrados",
                    'data' => $capacitaciones,
                );
            } else {
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
