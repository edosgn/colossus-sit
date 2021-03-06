<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvSenialInventario;
use JHWEB\SeguridadVialBundle\Entity\SvSenialUbicacion;
use JHWEB\SeguridadVialBundle\Entity\SvSenialDemarcacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svsenialubicacion controller.
 *
 * @Route("svsenialubicacion")
 */
class SvSenialUbicacionController extends Controller
{
    /**
     * Lists all svSenialUbicacion entities.
     *
     * @Route("/", name="svsenialubicacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $svSenialUbicacions = $em->getRepository('JHWEBSeguridadVialBundle:SvSenialUbicacion')->findAll();

        return $this->render('svsenialubicacion/index.html.twig', array(
            'svSenialUbicacions' => $svSenialUbicacions,
        ));
    }

    /**
     * Creates a new svSenialUbicacion entity.
     *
     * @Route("/new", name="svsenialubicacion_new")
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

            $fecha = new \Datetime($params->fecha);

            if ($params->idSenial) {
                $senial = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenial')->find(
                    $params->idSenial
                );

                if ($params->idProveedor) {
                    $inventario = $em->getRepository('JHWEBSeguridadVialBundle:SvSenialInventario')->findOneBy(
                        array(
                            'fecha' => $fecha,
                            'tipoDestino' => 'MUNICIPIO',
                            'tipoSenial' => $senial->getTipoSenial()->getId()
                        )
                    );

                    if (!$inventario) {
                        $inventario = new SvSenialInventario();

                        $inventario->setFecha($fecha);

                        $inventario->setTipoDestino('MUNICIPIO');

                        if ($senial) {
                            $inventario->setTipoSenial($senial->getTipoSenial());
                        }

                        if ($params->idMunicipio) {
                            $municipio = $em->getRepository('JHWEBConfigBundle:CfgMunicipio')->find(
                                $params->idMunicipio
                            );
                            $inventario->setMunicipio($municipio);
                        }

                        $consecutivo = $em->getRepository('JHWEBSeguridadVialBundle:SvSenialInventario')->getMaximo(
                            $fecha->format('Y')
                        );
                        $consecutivo = (empty($consecutivo['maximo']) ? 1 : $consecutivo['maximo']+=1);
                        $inventario->setConsecutivo($consecutivo);

                        $em->persist($inventario);
                        $em->flush();
                    }

                    $ubicacion = new SvSenialUbicacion();

                    $ubicacion->setInventario($inventario);

                     if ($params->idMunicipio) {
                        $municipio = $em->getRepository('JHWEBConfigBundle:CfgMunicipio')->find(
                            $params->idMunicipio
                        );
                        $ubicacion->setMunicipio($municipio);
                    }

                    $ubicacion->setFecha(new \Datetime($params->fecha));
                    $ubicacion->setHora(new \Datetime(date('h:i:s A')));
                    $ubicacion->setCantidad($params->cantidad);

                    $markers = null;
                    if ($params->markers) {
                        foreach ($params->markers as $key => $marker) {
                            $markers[] = (array)$marker;
                        }

                        $ubicacion->setGeolocalizacion(
                            $markers
                        );
                    }                    

                    if ($senial) {
                        $ubicacion->setSenial($senial);

                        $senial->setCantidad($senial->getCantidad() - $params->cantidad);
                        $em->flush();
                    }

                    if ($params->idEstado) {
                        $estado = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenialEstado')->find(
                            $params->idEstado
                        );
                        $ubicacion->setEstado($estado);
                    }

                    if ($request->files->get('file')) {
                        $file = $request->files->get('file');
                        $extension = $file->guessExtension();
                        $fileName = md5(rand().time()).".".$extension;
                        $dir=__DIR__.'/../../../../web/uploads/seniales/files';

                        $file->move($dir,$fileName);
                        $ubicacion->setAdjunto($fileName);
                    }

                    $em->persist($ubicacion);
                    $em->flush();

                    $proveedor = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenialProveedor')->find(
                        $params->idProveedor);
                    $ubicacion->setProveedor($proveedor);

                    if ($params->demarcaciones) {
                        foreach ($params->demarcaciones as $demarcacion) {
                            $demarcacionNew = new SvSenialDemarcacion();

                            if ($params->idLinea) {
                                $linea = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenialLinea')->find(
                                    $params->idLinea
                                );
                                $demarcacionNew->setLinea($linea);
                            }

                            if ($params->idUnidadMedida) {
                                $unidadMedida = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenialUnidadMedida')->find(
                                    $params->idUnidadMedida
                                );
                                $demarcacionNew->setUnidadMedida($unidadMedida);
                            }

                            if ($demarcacion->cantidad) {
                                $demarcacionNew->setCantidad($demarcacion->cantidad);
                            }

                            if ($demarcacion->area) {
                                $demarcacionNew->setArea($demarcacion->area);
                            }

                            if ($demarcacion->largo) {
                                $demarcacionNew->setLargo($demarcacion->largo);
                            }

                            if ($demarcacion->ancho) {
                                $demarcacionNew->setAncho(
                                    $demarcacion->ancho
                                );
                            }

                            $demarcacionNew->setTotal($demarcacion->total);
                            $demarcacionNew->setTramoVial($demarcacion->tramoVial);
                            $demarcacionNew->setActivo(true);

                            $demarcacionNew->setUbicacion($ubicacion);

                            $em->persist($demarcacionNew);
                            $em->flush();
                        }
                    }                    

                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => "Registro creado con exito",
                    );
                }else{
                    if ($senial->getCantidad() >= $params->cantidad)  {
                        $inventario = $em->getRepository('JHWEBSeguridadVialBundle:SvSenialInventario')->findOneBy(
                            array(
                                'fecha' => $fecha,
                                'tipoDestino' => 'MUNICIPIO',
                                'tipoSenial' => $senial->getTipoSenial()->getId()
                            )
                        );

                        if (!$inventario) {
                            $inventario = new SvSenialInventario();

                            $inventario->setFecha($fecha);

                            $inventario->setTipoDestino('MUNICIPIO');

                            if ($senial) {
                                $inventario->setTipoSenial($senial->getTipoSenial());
                            }

                            if ($params->idMunicipio) {
                                $municipio = $em->getRepository('JHWEBConfigBundle:CfgMunicipio')->find(
                                    $params->idMunicipio
                                );
                                $inventario->setMunicipio($municipio);
                            }

                            $consecutivo = $em->getRepository('JHWEBSeguridadVialBundle:SvSenialInventario')->getMaximo(
                                $fecha->format('Y')
                            );
                            $consecutivo = (empty($consecutivo['maximo']) ? 1 : $consecutivo['maximo']+=1);
                            $inventario->setConsecutivo($consecutivo);

                            $em->persist($inventario);
                            $em->flush();
                        }

                        $ubicacion = new SvSenialUbicacion();

                        $ubicacion->setInventario($inventario);

                         if ($params->idMunicipio) {
                            $municipio = $em->getRepository('JHWEBConfigBundle:CfgMunicipio')->find(
                                $params->idMunicipio
                            );
                            $ubicacion->setMunicipio($municipio);
                        }

                        $ubicacion->setFecha(new \Datetime($params->fecha));
                        $ubicacion->setHora(new \Datetime(date('h:i:s A')));
                        $ubicacion->setCantidad($params->cantidad);

                        $markers = null;
                        if ($params->markers) {
                            foreach ($params->markers as $key => $marker) {
                                $markers[] = (array)$marker;
                            }

                            $ubicacion->setGeolocalizacion(
                                $markers
                            );
                        }

                        if ($params->idBodega) {
                            $bodega = $em->getRepository('JHWEBSeguridadVialBundle:SvSenialBodega')->find(
                                $params->idBodega);
                            $ubicacion->setBodega($bodega);
                            
                            if (!$params->idUnidadMedida && !$params->idProveedor) {
                                $bodega->setCantidadDisponible($bodega->getCantidadDisponible() - $params->cantidad);
                                $em->flush();
                            }

                            if ($params->idLinea) {
                                $linea = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenialLinea')->find(
                                    $params->idLinea
                                );
                                $ubicacion->setLinea($linea);
                            }

                            if ($params->idUnidadMedida) {
                                $unidadMedida = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenialUnidadMedida')->find(
                                    $params->idUnidadMedida
                                );
                                $ubicacion->setUnidadMedida($unidadMedida);
                            }
                        }                    

                        if ($senial) {
                            $ubicacion->setSenial($senial);

                            $senial->setCantidad($senial->getCantidad() - $params->cantidad);
                            $em->flush();
                        }

                        if ($params->idEstado) {
                            $estado = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenialEstado')->find(
                                $params->idEstado
                            );
                            $ubicacion->setEstado($estado);
                        }

                        if ($request->files->get('file')) {
                            $file = $request->files->get('file');
                            $extension = $file->guessExtension();
                            $fileName = md5(rand().time()).".".$extension;
                            $dir=__DIR__.'/../../../../web/uploads/seniales/files';

                            $file->move($dir,$fileName);
                            $ubicacion->setAdjunto($fileName);
                        }

                        $em->persist($ubicacion);
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
                            'message' => "La cantidad solicitada supera los ".$senial->getCantidad()." disponibles.", 
                        );
                    }
                }
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "La señal selecionada no existe en la sabe de datos", 
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
     * Finds and displays a svSenialUbicacion entity.
     *
     * @Route("/{id}/show", name="svsenialubicacion_show")
     * @Method("GET")
     */
    public function showAction(SvSenialUbicacion $svSenialUbicacion)
    {
        $deleteForm = $this->createDeleteForm($svSenialUbicacion);

        return $this->render('svsenialubicacion/show.html.twig', array(
            'svSenialUbicacion' => $svSenialUbicacion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing svSenialUbicacion entity.
     *
     * @Route("/{id}/edit", name="svsenialubicacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SvSenialUbicacion $svSenialUbicacion)
    {
        $deleteForm = $this->createDeleteForm($svSenialUbicacion);
        $editForm = $this->createForm('JHWEB\SeguridadVialBundle\Form\SvSenialUbicacionType', $svSenialUbicacion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('svsenialubicacion_edit', array('id' => $svSenialUbicacion->getId()));
        }

        return $this->render('svsenialubicacion/edit.html.twig', array(
            'svSenialUbicacion' => $svSenialUbicacion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a svSenialUbicacion entity.
     *
     * @Route("/{id}/delete", name="svsenialubicacion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SvSenialUbicacion $svSenialUbicacion)
    {
        $form = $this->createDeleteForm($svSenialUbicacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($svSenialUbicacion);
            $em->flush();
        }

        return $this->redirectToRoute('svsenialubicacion_index');
    }

    /**
     * Creates a form to delete a svSenialUbicacion entity.
     *
     * @param SvSenialUbicacion $svSenialUbicacion The svSenialUbicacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvSenialUbicacion $svSenialUbicacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svsenialubicacion_delete', array('id' => $svSenialUbicacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ================================= */

    /**
     * Busca todos los regitros con georeferenciacion por fechas.
     *
     * @Route("/search/fechas/municipio", name="svsenialubicacion_search_fechas_municipio")
     * @Method({"GET", "POST"})
     */
    public function searchByFechasAndMunicipioAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $idMunicipio = (isset($params->idMunicipio)) ? $params->idMunicipio : null;

            $ubicaciones = $em->getRepository('JHWEBSeguridadVialBundle:SvSenialUbicacion')->getByFechasAndMunicipio(
                new \Datetime($params->fechaInicial),
                new \Datetime($params->fechaFinal),
                $idMunicipio
            );

            if ($ubicaciones) {
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($ubicaciones).' registros encontrados con exito.',
                    'data' => $ubicaciones,
                );
            } else {
                $response = array(
                    'title' => 'Atención!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => 'Nogún registro encontrado.',
                );
            }
        } else {
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida.',
            );
        }

        return $helpers->json($response);
    }
}
