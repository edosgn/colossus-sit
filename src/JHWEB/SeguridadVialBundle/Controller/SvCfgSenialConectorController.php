<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgSenialConector;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgsenialconector controller.
 *
 * @Route("svcfgsenialconector")
 */
class SvCfgSenialConectorController extends Controller
{
    /**
     * Lists all svCfgSenialConector entities.
     *
     * @Route("/", name="svcfgsenialconector_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $conectores = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenialConector')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($conectores) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($conectores)." registros encontrados", 
                'data'=> $conectores,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new svCfgSenialConector entity.
     *
     * @Route("/new", name="svcfgsenialconector_new")
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
           
            $conector = new SvCfgSenialConector();

            $conector->setNombre(strtoupper($params->nombre));
            $conector->setActivo(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($conector);
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
     * Finds and displays a svCfgSenialConector entity.
     *
     * @Route("/{id}/show", name="svcfgsenialconector_show")
     * @Method("GET")
     */
    public function showAction(SvCfgSenialConector $svCfgSenialConector)
    {
        $deleteForm = $this->createDeleteForm($svCfgSenialConector);

        return $this->render('svcfgsenialconector/show.html.twig', array(
            'svCfgSenialConector' => $svCfgSenialConector,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing svCfgSenialConector entity.
     *
     * @Route("/edit", name="svcfgsenialconector_edit")
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
            $conector = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenialConector')->find($params->id);

            if ($conector) {
                $conector->setNombre(strtoupper($params->nombre));

                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $conector,
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
     * Deletes a svCfgSenialConector entity.
     *
     * @Route("/{id}", name="svcfgsenialconector_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SvCfgSenialConector $svCfgSenialConector)
    {
        $form = $this->createDeleteForm($svCfgSenialConector);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($svCfgSenialConector);
            $em->flush();
        }

        return $this->redirectToRoute('svcfgsenialconector_index');
    }

    /**
     * Creates a form to delete a svCfgSenialConector entity.
     *
     * @param SvCfgSenialConector $svCfgSenialConector The svCfgSenialConector entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgSenialConector $svCfgSenialConector)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svcfgsenialconector_delete', array('id' => $svCfgSenialConector->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="svcfgsenialconector_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $conectores = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenialConector')->findBy(
            array('activo' => 1)
        );

        $response = null;

        foreach ($conectores as $key => $conector) {
            $response[$key] = array(
                'value' => $conector->getId(),
                'label' => $conector->getNombre(),
            );
        }

        return $helpers->json($response);
    }
}
