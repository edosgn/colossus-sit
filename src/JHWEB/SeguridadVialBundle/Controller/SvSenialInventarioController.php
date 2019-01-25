<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvSenialInventario;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Svsenialinventario controller.
 *
 * @Route("svsenialinventario")
 */
class SvSenialInventarioController extends Controller
{
    /**
     * Lists all svSenialInventario entities.
     *
     * @Route("/", name="svsenialinventario_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $svSenialInventarios = $em->getRepository('JHWEBSeguridadVialBundle:SvSenialInventario')->findAll();

        return $this->render('svsenialinventario/index.html.twig', array(
            'svSenialInventarios' => $svSenialInventarios,
        ));
    }

    /**
     * Creates a new svSenialInventario entity.
     *
     * @Route("/new", name="svsenialinventario_new")
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


            $bodega = new SvSenialBodega();

            $bodega->setInventario($inventario);

            $bodega->setFecha(new \Datetime($params->fecha));
            $bodega->setHora(new \Datetime($params->hora));
            $bodega->setCantidad($params->cantidad);
            $bodega->setValor($params->valor);

            if ($request->files->get('file')) {
                $file = $request->files->get('file');
                $extension = $file->guessExtension();
                $fileName = md5(rand().time()).".".$extension;
                $dir=__DIR__.'/../../../../web/uploads/seniales/files';

                $file->move($dir,$fileName);
                $bodega->setAdjunto($fileName);
            }

            if ($params->idEstado) {
                $estado = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenialEstado')->find(
                    $params->idEstado
                );
                $bodega->setEstado($estado);
            }

            if ($params->idSenial) {
                $senial = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenial')->find(
                    $params->idSenial
                );
                $bodega->setSenial($senial);
            }

            $em->persist($bodega);
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
     * Finds and displays a svSenialInventario entity.
     *
     * @Route("/{id}/show", name="svsenialinventario_show")
     * @Method("GET")
     */
    public function showAction(SvSenialInventario $svSenialInventario)
    {
        $deleteForm = $this->createDeleteForm($svSenialInventario);

        return $this->render('svsenialinventario/show.html.twig', array(
            'svSenialInventario' => $svSenialInventario,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing svSenialInventario entity.
     *
     * @Route("/{id}/edit", name="svsenialinventario_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SvSenialInventario $svSenialInventario)
    {
        $deleteForm = $this->createDeleteForm($svSenialInventario);
        $editForm = $this->createForm('JHWEB\SeguridadVialBundle\Form\SvSenialInventarioType', $svSenialInventario);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('svsenialinventario_edit', array('id' => $svSenialInventario->getId()));
        }

        return $this->render('svsenialinventario/edit.html.twig', array(
            'svSenialInventario' => $svSenialInventario,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a svSenialInventario entity.
     *
     * @Route("/{id}/delete", name="svsenialinventario_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SvSenialInventario $svSenialInventario)
    {
        $form = $this->createDeleteForm($svSenialInventario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($svSenialInventario);
            $em->flush();
        }

        return $this->redirectToRoute('svsenialinventario_index');
    }

    /**
     * Creates a form to delete a svSenialInventario entity.
     *
     * @param SvSenialInventario $svSenialInventario The svSenialInventario entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvSenialInventario $svSenialInventario)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svsenialinventario_delete', array('id' => $svSenialInventario->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* =================================================== */

    /**
     * Lists all mpersonalFuncionario entities.
     *
     * @Route("/search/date/tipo/destino", name="svsenialinventario_search_date_tipo_destino")
     * @Method({"GET", "POST"})
     */
    public function searchByDateAndTipoDestinoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            if ($params->fechaInicial) {
                $fechaInicial = new \Datetime($params->fechaInicial);
            }

            if ($params->fechaFinal) {
                $fechaFinal = new \Datetime($params->fechaFinal);
            }            

            $inventarios = $em->getRepository('JHWEBSeguridadVialBundle:SvSenialInventario')->getByDateAndTipoDestino(
                    $fechaInicial,
                    $fechaFinal,
                    $params->idTipoSenial,
                    $params->tipoDestino,
                    $params->idMunicipio
                );

            if ($inventarios) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($inventarios)." inventario(s) encontrado(s)",
                    'data'=> $inventarios
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Ningún registro no encontrado"
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
     * Lists all mpersonalFuncionario entities.
     *
     * @Route("/search/cantidad/senial/tipo/destino", name="svsenialinventario_search_cantidad_senial_tipo_destino")
     * @Method({"GET", "POST"})
     */
    public function searchCantidadBySenialAndTipoDestinoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);          

            $inventarios = $em->getRepository('JHWEBSeguridadVialBundle:SvSenialInventario')->getCantidadBySenialAndTipoDestino(
                    $params->idTipoSenial,
                    $params->tipoDestino,
                    $params->idMunicipio
                );

            if ($inventarios) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($inventarios)." inventario(s) encontrado(s)",
                    'data'=> $inventarios
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Ningún registro no encontrado"
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
     * Creates a new svSenialInventario entity.
     *
     * @Route("/search/senial/tipo/destino", name="svsenialinventario_search_senial_tipo_destino")
     * @Method({"GET", "POST"})
     */
    public function searchBySenialAndTipoDestinoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            if ($params->tipoDestino == 'BODEGA') {
                $seniales = $em->getRepository('JHWEBSeguridadVialBundle:SvSenialBodega')->getBySenial(
                    $params->idSenial
                ); 
            }else{
                $seniales = $em->getRepository('JHWEBSeguridadVialBundle:SvSenialUbicacion')->getBySenial(
                    $params->idSenial
                ); 
            }
        

            $response['data'] = array();

            if ($seniales) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($seniales)." registros encontrados", 
                    'data'=> $seniales,
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
