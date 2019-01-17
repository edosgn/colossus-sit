<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgSenialColor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgsenialcolor controller.
 *
 * @Route("svcfgsenialcolor")
 */
class SvCfgSenialColorController extends Controller
{
    /**
     * Lists all svCfgSenialColor entities.
     *
     * @Route("/", name="svcfgsenialcolor_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $colores = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenialColor')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($colores) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($colores)." registros encontrados", 
                'data'=> $colores,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new svCfgSenialColor entity.
     *
     * @Route("/new", name="svcfgsenialcolor_new")
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
           
            $color = new SvCfgSenialColor();

            $color->setNombre(strtoupper($params->nombre));
            $color->setHexadecimal('#000000');
            $color->setActivo(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($color);
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
     * Finds and displays a svCfgSenialColor entity.
     *
     * @Route("/{id}/show", name="svcfgsenialcolor_show")
     * @Method("GET")
     */
    public function showAction(SvCfgSenialColor $svCfgSenialColor)
    {
        $deleteForm = $this->createDeleteForm($svCfgSenialColor);

        return $this->render('svcfgsenialcolor/show.html.twig', array(
            'svCfgSenialColor' => $svCfgSenialColor,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing svCfgSenialColor entity.
     *
     * @Route("/edit", name="svcfgsenialcolor_edit")
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
            $color = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenialColor')->find($params->id);

            if ($color) {
                $color->setNombre(strtoupper($params->nombre));

                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $color,
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
     * Deletes a svCfgSenialColor entity.
     *
     * @Route("/{id}/delete", name="svcfgsenialcolor_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SvCfgSenialColor $svCfgSenialColor)
    {
        $form = $this->createDeleteForm($svCfgSenialColor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($svCfgSenialColor);
            $em->flush();
        }

        return $this->redirectToRoute('svcfgsenialcolor_index');
    }

    /**
     * Creates a form to delete a svCfgSenialColor entity.
     *
     * @param SvCfgSenialColor $svCfgSenialColor The svCfgSenialColor entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgSenialColor $svCfgSenialColor)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svcfgsenialcolor_delete', array('id' => $svCfgSenialColor->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ================================================== */
    
    /**
     * datos para select 2
     *
     * @Route("/select", name="svcfgsenialcolor_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $colores = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenialColor')->findBy(
            array('activo' => 1)
        );

        $response = null;

        foreach ($colores as $key => $color) {
            $response[$key] = array(
                'value' => $color->getId(),
                'label' => $color->getNombre(),
            );
        }

        return $helpers->json($response);
    }
}
