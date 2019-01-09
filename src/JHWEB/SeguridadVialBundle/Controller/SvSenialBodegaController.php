<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvSenialInventario;
use JHWEB\SeguridadVialBundle\Entity\SvSenialBodega;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Svsenialbodega controller.
 *
 * @Route("svsenialbodega")
 */
class SvSenialBodegaController extends Controller
{
    /**
     * Lists all svSenialBodega entities.
     *
     * @Route("/", name="svsenialbodega_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $svSenialBodegas = $em->getRepository('JHWEBSeguridadVialBundle:SvSenialBodega')->findAll();

        return $this->render('svsenialbodega/index.html.twig', array(
            'svSenialBodegas' => $svSenialBodegas,
        ));
    }

    /**
     * Creates a new svSenialBodega entity.
     *
     * @Route("/new", name="svsenialbodega_new")
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
            }

            $inventario = $em->getRepository('JHWEBSeguridadVialBundle:SvSenialInventario')->findOneBy(
                array(
                    'fecha' => $fecha,
                    'tipoDestino' => 'BODEGA',
                    'tipoSenial' => $senial->getTipoSenial()->getId()
                )
            );

            if (!$inventario) {
                $inventario = new SvSenialInventario();

                $inventario->setFecha($fecha);

                $inventario->setTipoDestino('BODEGA');

                if ($senial) {
                    $inventario->setTipoSenial($senial->getTipoSenial());
                }

                $consecutivo = $em->getRepository('JHWEBSeguridadVialBundle:SvSenialInventario')->getMaximo(
                    $fecha->format('Y'));

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

            if ($senial) {
                $bodega->setSenial($senial);

                $senial->setCantidad($senial->getCantidad() + $params->cantidad);
                $em->flush();
            }

            if ($params->idEstado) {
                $estado = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenialEstado')->find(
                    $params->idEstado);
                $bodega->setEstado($estado);
            }

            if ($params->idProveedor) {
                $proveedor = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenialProveedor')->find(
                    $params->idProveedor);
                $bodega->setProveedor($proveedor);
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
     * Finds and displays a svSenialBodega entity.
     *
     * @Route("/{id}", name="svsenialbodega_show")
     * @Method("GET")
     */
    public function showAction(SvSenialBodega $svSenialBodega)
    {
        $deleteForm = $this->createDeleteForm($svSenialBodega);

        return $this->render('svsenialbodega/show.html.twig', array(
            'svSenialBodega' => $svSenialBodega,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing svSenialBodega entity.
     *
     * @Route("/{id}/edit", name="svsenialbodega_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SvSenialBodega $svSenialBodega)
    {
        $deleteForm = $this->createDeleteForm($svSenialBodega);
        $editForm = $this->createForm('JHWEB\SeguridadVialBundle\Form\SvSenialBodegaType', $svSenialBodega);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('svsenialbodega_edit', array('id' => $svSenialBodega->getId()));
        }

        return $this->render('svsenialbodega/edit.html.twig', array(
            'svSenialBodega' => $svSenialBodega,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a svSenialBodega entity.
     *
     * @Route("/{id}", name="svsenialbodega_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SvSenialBodega $svSenialBodega)
    {
        $form = $this->createDeleteForm($svSenialBodega);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($svSenialBodega);
            $em->flush();
        }

        return $this->redirectToRoute('svsenialbodega_index');
    }

    /**
     * Creates a form to delete a svSenialBodega entity.
     *
     * @param SvSenialBodega $svSenialBodega The svSenialBodega entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvSenialBodega $svSenialBodega)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svsenialbodega_delete', array('id' => $svSenialBodega->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
