<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvSenialInventario;
use JHWEB\SeguridadVialBundle\Entity\SvSenialUbicacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

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

            $inventario = $em->getRepository('JHWEBSeguridadVialBundle:SvSenialInventario')->findOneBy(
                array(
                    'fecha' => $fecha,
                    'tipoSenial' => $params->idTipoSenial
                )
            );

            if (!$inventario) {
                $inventario = new SvSenialInventario();

                $inventario->setFecha($fecha);

                $inventario->setTipoDestino($params->tipoDestino);

                if ($params->idMunicipio) {
                    $municipio = $em->getRepository('AppBundle:Municipio')->find(
                        $params->idMunicipio
                    );
                    $inventario->setMunicipio($municipio);
                }

                if ($params->idTipoSenial) {
                    $tipoSenial = $em->getRepository('JHWEBConfigBundle:CfgSvSenialTipo')->find(
                        $params->idTipoSenial
                    );
                    $inventario->setTipoSenial($tipoSenial);
                }

                $consecutivo = $em->getRepository('JHWEBSeguridadVialBundle:SvSenialInventario')->findMaximo(
                    $fecha->format('Y')
                );
                $consecutivo = (empty($consecutivo['maximo']) ? 1 : $consecutivo['maximo']+=1);
                $inventario->setConsecutivo($consecutivo);

                $em->persist($inventario);
                $em->flush();
            }


            $ubicacion = new SvSenialUbicacion();

            $ubicacion->setInventario($inventario);

            $ubicacion->setFecha(new \Datetime($params->fecha));
            $ubicacion->setHora(new \Datetime($params->hora));
            $ubicacion->setCantidad($params->cantidad);
            $ubicacion->setValor($params->valor);

            if ($request->files->get('file')) {
                $file = $request->files->get('file');
                $extension = $file->guessExtension();
                $fileName = md5(rand().time()).".".$extension;
                $dir=__DIR__.'/../../../../web/uploads/seniales/files';

                $file->move($dir,$fileName);
                $ubicacion->setAdjunto($fileName);
            }

            if ($params->idEstado) {
                $estado = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenialEstado')->find(
                    $params->idEstado
                );
                $ubicacion->setEstado($estado);
            }

            if ($params->idSenial) {
                $senial = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenial')->find(
                    $params->idSenial
                );
                $ubicacion->setSenial($senial);
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

    /**
     * Creates a new svSenialInventario entity.
     *
     * @Route("/search/destino", name="svsenialinventario_search_destino")
     * @Method({"GET", "POST"})
     */
    public function searchByDestinoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("json",null);
            $params = json_decode($json);


            $em = $this->getDoctrine()->getManager();
        
            $ubicaciones = $em->getRepository('JHWEBSeguridadVialBundle:SvSenialUbicacion')->findBy(
                array(
                    'inventario' => $params->inventario->id
                )
            );

            $response['data'] = array();

            if ($ubicaciones) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($ubicaciones)." registros encontrados", 
                    'data'=> $ubicaciones,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Ningún registro encontrado."
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


}
