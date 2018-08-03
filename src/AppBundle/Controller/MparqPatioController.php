<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MparqPatio;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Mparqpatio controller.
 *
 * @Route("mparqpatio")
 */
class MparqPatioController extends Controller
{
    /**
     * Lists all mparqPatio entities.
     *
     * @Route("/", name="mparqpatio_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $patios = $em->getRepository('AppBundle:MparqPatio')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($patios) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => count($patios)." Registros encontrados", 
                'data'=> $patios,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new mparqPatio entity.
     *
     * @Route("/new", name="mparqpatio_new")
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

            /*if (count($params)==0) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "los campos no pueden estar vacios", 
                );
            }else{*/
                $patio = new MparqPatio();

                $patio->setNombre($params->nombre);
                $patio->setDireccion($params->direccion);
                $patio->setActivo(true);

                $em = $this->getDoctrine()->getManager();
                $em->persist($patio);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro creado con exito",
                    'data' => $patio
                );
            //}
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
     * Finds and displays a mparqPatio entity.
     *
     * @Route("/{id}/show", name="mparqpatio_show")
     * @Method("GET")
     */
    public function showAction(MparqPatio $mparqPatio)
    {
        $deleteForm = $this->createDeleteForm($mparqPatio);

        return $this->render('mparqpatio/show.html.twig', array(
            'mparqPatio' => $mparqPatio,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing mparqPatio entity.
     *
     * @Route("/{id}/edit", name="mparqpatio_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MparqPatio $mparqPatio)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            $patio = $em->getRepository("AppBundle:MparqPatio")->find($params->id);

            if ($patio!=null) {
                $patio->setNombre($params->nombre);
                $patio->setDireccion($params->direccion);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro actualizado con exito", 
                    'data'=> $patio,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El registro no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a mparqPatio entity.
     *
     * @Route("/{id}/delete", name="mparqpatio_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MparqPatio $mparqPatio)
    {
        $form = $this->createDeleteForm($mparqPatio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mparqPatio);
            $em->flush();
        }

        return $this->redirectToRoute('mparqpatio_index');
    }

    /**
     * Creates a form to delete a mparqPatio entity.
     *
     * @param MparqPatio $mparqPatio The mparqPatio entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MparqPatio $mparqPatio)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mparqpatio_delete', array('id' => $mparqPatio->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="mparqpatio_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $response = null;
        
        $patios = $em->getRepository('AppBundle:MparqPatio')->findBy(
            array(
                'activo' => true,
            )
        );

        foreach ($patios as $key => $patio) {
            $response[$key] = array(
                'value' => $patio->getId(),
                'label' => $patio->getNombre()
            );
        }
        return $helpers->json($response);
    }
}
