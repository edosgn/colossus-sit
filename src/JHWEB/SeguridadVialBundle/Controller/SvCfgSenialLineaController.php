<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgSenialLinea;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgseniallinea controller.
 *
 * @Route("svcfgseniallinea")
 */
class SvCfgSenialLineaController extends Controller
{
    /**
     * Lists all svCfgSenialLinea entities.
     *
     * @Route("/", name="svcfgseniallinea_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $lineas = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenialLinea')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($lineas) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($lineas)." registros encontrados", 
                'data'=> $lineas,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new svCfgSenialLinea entity.
     *
     * @Route("/new", name="svcfgseniallinea_new")
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
           
            $linea = new SvCfgSenialLinea();

            $linea->setNombre(strtoupper($params->nombre));
            $linea->setActivo(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($linea);
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
     * Finds and displays a svCfgSenialLinea entity.
     *
     * @Route("/{id}/show", name="svcfgseniallinea_show")
     * @Method("GET")
     */
    public function showAction(SvCfgSenialLinea $svCfgSenialLinea)
    {
        $deleteForm = $this->createDeleteForm($svCfgSenialLinea);

        return $this->render('svcfgseniallinea/show.html.twig', array(
            'svCfgSenialLinea' => $svCfgSenialLinea,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing svCfgSenialLinea entity.
     *
     * @Route("/edit", name="svcfgseniallinea_edit")
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
            $linea = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenialLinea')->find($params->id);

            if ($linea) {
                $linea->setNombre(strtoupper($params->nombre));

                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $linea,
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
     * Deletes a svCfgSenialLinea entity.
     *
     * @Route("/{id}", name="svcfgseniallinea_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SvCfgSenialLinea $svCfgSenialLinea)
    {
        $form = $this->createDeleteForm($svCfgSenialLinea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($svCfgSenialLinea);
            $em->flush();
        }

        return $this->redirectToRoute('svcfgseniallinea_index');
    }

    /**
     * Creates a form to delete a svCfgSenialLinea entity.
     *
     * @param SvCfgSenialLinea $svCfgSenialLinea The svCfgSenialLinea entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgSenialLinea $svCfgSenialLinea)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svcfgseniallinea_delete', array('id' => $svCfgSenialLinea->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* =================================================== */

    /**
     * datos para select 2
     *
     * @Route("/select", name="svcfgseniallinea_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $lineas = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenialLinea')->findBy(
            array('activo' => 1)
        );

        $response = null;

        foreach ($lineas as $key => $linea) {
            $response[$key] = array(
                'value' => $linea->getId(),
                'label' => $linea->getNombre(),
            );
        }

        return $helpers->json($response);
    }
}
