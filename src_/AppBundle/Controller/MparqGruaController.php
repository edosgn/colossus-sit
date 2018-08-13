<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MparqGrua;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Mparqgrua controller.
 *
 * @Route("mparqgrua")
 */
class MparqGruaController extends Controller
{
    /**
     * Lists all mparqGrua entities.
     *
     * @Route("/", name="mparqgrua_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $json = $request->get("json",null);
        $params = json_decode($json);

        $em = $this->getDoctrine()->getManager();
        $gruas = $em->getRepository('AppBundle:MparqGrua')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($gruas) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => count($gruas)." Registros encontrados", 
                'data'=> $gruas,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new mparqGrua entity.
     *
     * @Route("/new", name="mparqgrua_new")
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
                $grua = new MparqGrua();

                $grua->setPlaca($params->placa);
                $grua->setNumeroInterno($params->numeroInterno);

                $em = $this->getDoctrine()->getManager();
                $em->persist($grua);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro creado con exito",  
                );
            //}
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida", 
            );
        } 
        return $helpers->json($response);
    }

    /**
     * Finds and displays a mparqGrua entity.
     *
     * @Route("/{id}", name="mparqgrua_show")
     * @Method("GET")
     */
    public function showAction(MparqGrua $mparqGrua)
    {
        $deleteForm = $this->createDeleteForm($mparqGrua);

        return $this->render('mparqgrua/show.html.twig', array(
            'mparqGrua' => $mparqGrua,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing mparqGrua entity.
     *
     * @Route("/edit", name="mparqgrua_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            $grua = $em->getRepository("AppBundle:MparqGrua")->find($params->id);

            if ($grua!=null) {
                $grua->setPlaca($params->placa);
                $grua->setNumeroInterno($params->numeroInterno);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro actualizado con exito", 
                    'data'=> $grua,
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
     * Deletes a mparqGrua entity.
     *
     * @Route("/{id}", name="mparqgrua_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MparqGrua $mparqGrua)
    {
        $form = $this->createDeleteForm($mparqGrua);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mparqGrua);
            $em->flush();
        }

        return $this->redirectToRoute('mparqgrua_index');
    }

    /**
     * Creates a form to delete a mparqGrua entity.
     *
     * @param MparqGrua $mparqGrua The mparqGrua entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MparqGrua $mparqGrua)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mparqgrua_delete', array('id' => $mparqGrua->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
