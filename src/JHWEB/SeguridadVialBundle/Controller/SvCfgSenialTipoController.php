<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgSenialTipo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgsenialtipo controller.
 *
 * @Route("svcfgsenialtipo")
 */
class SvCfgSenialTipoController extends Controller
{
    /**
     * Lists all svCfgSenialTipo entities.
     *
     * @Route("/", name="svcfgsenialtipo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $tipos = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenialTipo')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($tipos) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($tipos)." registros encontrados", 
                'data'=> $tipos,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new svCfgSenialTipo entity.
     *
     * @Route("/new", name="svcfgsenialtipo_new")
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
           
            $tipo = new SvCfgSenialTipo();

            $tipo->setNombre(strtoupper($params->nombre));
            $tipo->setGestionable($params->gestionable);
            $tipo->setColor($params->color);
            $tipo->setActivo(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($tipo);
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
     * Finds and displays a svCfgSenialTipo entity.
     *
     * @Route("/{id}/show", name="svcfgsenialtipo_show")
     * @Method("GET")
     */
    public function showAction(SvCfgSenialTipo $svCfgSenialTipo)
    {
        $deleteForm = $this->createDeleteForm($svCfgSenialTipo);

        return $this->render('svcfgsenialtipo/show.html.twig', array(
            'svCfgSenialTipo' => $svCfgSenialTipo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing svCfgSenialTipo entity.
     *
     * @Route("/edit", name="svcfgsenialtipo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            $tipo = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenialTipo')->find($params->id);

            if ($tipo) {
                $tipo->setNombre(strtoupper($params->nombre));
                $tipo->setGestionable($params->gestionable);
                $tipo->setColor($params->color);

                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $tipo,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos",
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida para editar",
            );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a svCfgSenialTipo entity.
     *
     * @Route("/{id}", name="svcfgsenialtipo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SvCfgSenialTipo $svCfgSenialTipo)
    {
        $form = $this->createDeleteForm($svCfgSenialTipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($svCfgSenialTipo);
            $em->flush();
        }

        return $this->redirectToRoute('svcfgsenialtipo_index');
    }

    /**
     * Creates a form to delete a svCfgSenialTipo entity.
     *
     * @param SvCfgSenialTipo $svCfgSenialTipo The svCfgSenialTipo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgSenialTipo $svCfgSenialTipo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svcfgsenialtipo_delete', array('id' => $svCfgSenialTipo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ================================================== */
    
    /**
     * datos para select 2
     *
     * @Route("/select", name="svcfgsenialtipo_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $tipos = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenialTipo')->findBy(
            array('activo' => 1)
        );

        $response = null;

        foreach ($tipos as $key => $tipo) {
            $response[$key] = array(
                'value' => $tipo->getId(),
                'label' => $tipo->getNombre(),
            );
        }

        return $helpers->json($response);
    }
}
