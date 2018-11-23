<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgSenial;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgsenial controller.
 *
 * @Route("svcfgsenial")
 */
class SvCfgSenialController extends Controller
{
    /**
     * Lists all svCfgSenial entities.
     *
     * @Route("/", name="svcfgsenial_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $seniales = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenial')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($seniales) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($seniales)." registros encontrados", 
                'data'=> $seniales,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new svCfgSenial entity.
     *
     * @Route("/new", name="svcfgsenial_new")
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
           
            $senial = new SvCfgSenial();

            $senial->setCodigo($params->codigo);
            $senial->setNombre(strtoupper($params->nombre));

            $file = $request->files->get('file');
                   
            if ($file) {
                $extension = $file->guessExtension();
                $filename = md5(rand().time()).".".$extension;
                $dir=__DIR__.'/../../../../web/uploads/seniales';

                $file->move($dir,$filename);
                $senial->setLogo($filename);
            }

            if ($params->idSenialTipo) {
                $tipo = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenialTipo')->find(
                    $params->idSenialTipo
                );
                $senial->setTipoSenial($tipo);
            }

            if ($params->idColor) {
                $color = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgColor')->find(
                    $params->idColor
                );
                $senial->setColor($color);
            }

            $senial->setActivo(true);

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
     * Finds and displays a svCfgSenial entity.
     *
     * @Route("/{id}", name="svcfgsenial_show")
     * @Method("GET")
     */
    public function showAction(SvCfgSenial $svCfgSenial)
    {
        $deleteForm = $this->createDeleteForm($svCfgSenial);

        return $this->render('svcfgsenial/show.html.twig', array(
            'svCfgSenial' => $svCfgSenial,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing svCfgSenial entity.
     *
     * @Route("/{id}/edit", name="svcfgsenial_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SvCfgSenial $svCfgSenial)
    {
        $deleteForm = $this->createDeleteForm($svCfgSenial);
        $editForm = $this->createForm('JHWEB\SeguridadVialBundle\Form\SvCfgSenialType', $svCfgSenial);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('svcfgsenial_edit', array('id' => $svCfgSenial->getId()));
        }

        return $this->render('svcfgsenial/edit.html.twig', array(
            'svCfgSenial' => $svCfgSenial,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a svCfgSenial entity.
     *
     * @Route("/{id}", name="svcfgsenial_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SvCfgSenial $svCfgSenial)
    {
        $form = $this->createDeleteForm($svCfgSenial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($svCfgSenial);
            $em->flush();
        }

        return $this->redirectToRoute('svcfgsenial_index');
    }

    /**
     * Creates a form to delete a svCfgSenial entity.
     *
     * @param SvCfgSenial $svCfgSenial The svCfgSenial entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgSenial $svCfgSenial)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svcfgsenial_delete', array('id' => $svCfgSenial->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
