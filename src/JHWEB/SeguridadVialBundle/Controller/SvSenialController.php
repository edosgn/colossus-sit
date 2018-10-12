<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvSenial;
use JHWEB\SeguridadVialBundle\Entity\SvSenialInventarioBodega;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svsenial controller.
 *
 * @Route("svsenial")
 */
class SvSenialController extends Controller
{
    /**
     * Lists all svSenial entities.
     *
     * @Route("/", name="svsenial_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $svSenials = $em->getRepository('JHWEBSeguridadVialBundle:SvSenial')->findAll();

        return $this->render('svsenial/index.html.twig', array(
            'svSenials' => $svSenials,
        ));
    }

    /**
     * Creates a new svSenial entity.
     *
     * @Route("/new", name="svsenial_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $fecha = new \Datetime($params->fecha);

            $inventario = $em->getRepository('JHWEBSeguridadVialBundle:SvSenialInventarioBodega')->findOneBy(
                array(
                    'fecha' => $fecha,
                    'tipoSenial' => $params->idTipoSenial
                )
            );

            if (!$inventario) {
                $inventario = new SvSenialInventarioBodega();

                $inventario->setFecha($fecha);

                if ($params->idTipoSenial) {
                    $tipoSenial = $em->getRepository('JHWEBConfigBundle:CfgSvSenialTipo')->find(
                        $params->idTipoSenial
                    );
                    $inventario->setTipoSenial($tipoSenial);
                }

                $consecutivo = $em->getRepository('JHWEBSeguridadVialBundle:SvSenialInventarioBodega')->findMaximo(
                    $fecha->format('Y')
                );
                $consecutivo = (empty($consecutivo['maximo']) ? 1 : $consecutivo['maximo']+=1);
                $inventario->setConsecutivo($consecutivo);

                $em->persist($inventario);
                $em->flush();
            }


            $senial = new SvSenial();

            $senial->setInventario($inventario);
            $senial->setFecha(new \Datetime($params->fecha));
            $senial->setCodigo($params->codigo);
            $senial->setNombre($params->nombre);
            $senial->setCantidad($params->cantidad);
            $senial->setValor($params->valor);

            if ($request->files->get('file')) {
                $file = $request->files->get('file');
                $extension = $file->guessExtension();
                $fileName = md5(rand().time()).".".$extension;
                $dir=__DIR__.'/../../../../web/uploads/seniales/files';

                $file->move($dir,$fileName);
                $senial->setAdjunto($fileName);
            }

            if ($request->files->get('logo')) {
                $logo = $request->files->get('logo');
                $extension = $logo->guessExtension();
                $logoName = md5(rand().time()).".".$extension;
                $dir=__DIR__.'/../../../../web/uploads/seniales/files';

                $logo->move($dir,$fileName);
                $senial->setLogo($fileName);
            }

            if (isset($params->idEstado)) {
                $estado = $em->getRepository('JHWEBConfigBundle:CfgSvSenialEstado')->find(
                    $params->idEstado
                );
                $senial->setEstado($estado);
            }

            if (isset($params->idColor)) {
                $color = $em->getRepository('JHWEBConfigBundle:CfgSvSenialColor')->find(
                    $params->idColor
                );
                $senial->setColor($color);
            }

            if (isset($params->idUnidadMedida)) {
                $unidadMedida = $em->getRepository('JHWEBConfigBundle:CfgSvUnidadMedida')->find(
                    $params->idUnidadMedida
                );
                $senial->setUnidadMedida($unidadMedida);
            }

            $em->persist($senial);
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
     * Finds and displays a svSenial entity.
     *
     * @Route("/show", name="svsenial_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            if ($params->idSenial) {
                $senial = $em->getRepository('JHWEBSeguridadVialBundle:SvSenial')->find(
                    $params->idSenial
                );
            }


            if ($senial) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Registro encontrado con exito',
                    'data' => $senial
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Registro no encontrado', 
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
     * Displays a form to edit an existing svSenial entity.
     *
     * @Route("/{id}/edit", name="svsenial_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SvSenial $svSenial)
    {
        $deleteForm = $this->createDeleteForm($svSenial);
        $editForm = $this->createForm('JHWEB\SeguridadVialBundle\Form\SvSenialType', $svSenial);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('svsenial_edit', array('id' => $svSenial->getId()));
        }

        return $this->render('svsenial/edit.html.twig', array(
            'svSenial' => $svSenial,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a svSenial entity.
     *
     * @Route("/{id}", name="svsenial_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SvSenial $svSenial)
    {
        $form = $this->createDeleteForm($svSenial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($svSenial);
            $em->flush();
        }

        return $this->redirectToRoute('svsenial_index');
    }

    /**
     * Creates a form to delete a svSenial entity.
     *
     * @param SvSenial $svSenial The svSenial entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvSenial $svSenial)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svsenial_delete', array('id' => $svSenial->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select/tiposenial", name="svsenial_select_tiposenial")
     * @Method({"GET", "POST"})
     */
    public function selectTipoSenialAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        //if ($authCheck== true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
           
            $seniales = $em->getRepository('JHWEBSeguridadVialBundle:SvSenial')->getByTipoSenial(
                $params->idTipoSenial
            );
            
            $response = null;

            foreach ($seniales as $key => $senial) {
                $response[$key] = array(
                    'value' => $senial->getId(),
                    'label' => $senial->getNombre()
                );
            }
        /*}else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
            );
        }*/

        return $helpers->json($response);
    }
}
