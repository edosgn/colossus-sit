<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MsvInventarioSenial;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * MsvInventarioSenial controller.
 *
 * @Route("msvInventarioSenial")
 */
class MsvInventarioSenialController extends Controller
{
    /**
     * Lists all msvInventarioSenial entities.
     *
     * @Route("/", name="msvInventarioSenial_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $msvInventarioSenial = $em->getRepository('AppBundle:MsvInventarioSenial')->findAll();

        $response['data'] = array();

        if ($msvInventarioSenial) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => 'listado senales',
                'data' => $msvInventarioSenial,
            );
        }
        return $helpers->json($response);

        /*$em = $this->getDoctrine()->getManager();

        $msvInventarioSenial = $em->getRepository('AppBundle:MsvInventarioSenial')->findAll();

        return $this->render('msvInventarioSenial/index.html.twig', array(
            'msvInventarioSenials' => $msvInventarioSenials,
        ));*/

    }

    /**
     * Creates a new msvInventarioSenial entity.
     *
     */
    public function newAction(Request $request)
    {
        $msvInventarioSenial = new MsvInventarioSenial();
        $form = $this->createForm('AppBundle\Form\MsvInventarioSenialType', $msvInventarioSenial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($msvInventarioSenial);
            $em->flush();

            return $this->redirectToRoute('msvInventarioSenial_show', array('id' => $msvInventarioSenial->getId()));
        }

        return $this->render('msvInventarioSenial/new.html.twig', array(
            'msvInventarioSenial' => $msvInventarioSenial,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a msvInventarioSenial entity.
     *
     */
    public function showAction(MsvInventarioSenial $msvInventarioSenial)
    {
        $deleteForm = $this->createDeleteForm($msvInventarioSenial);

        return $this->render('msvInventarioSenial/show.html.twig', array(
            'msvInventarioSenial' => $msvInventarioSenial,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing msvInventarioSenial entity.
     *
     */
    public function editAction(Request $request, MsvInventarioSenial $msvInventarioSenial)
    {
        $deleteForm = $this->createDeleteForm($msvInventarioSenial);
        $editForm = $this->createForm('AppBundle\Form\MsvInventarioSenialType', $msvInventarioSenial);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('msvInventarioSenial_edit', array('id' => $msvInventarioSenial->getId()));
        }

        return $this->render('msvInventarioSenial/edit.html.twig', array(
            'msvInventarioSenial' => $msvInventarioSenial,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a msvInventarioSenial entity.
     *
     */
    public function deleteAction(Request $request, MsvInventarioSenial $msvInventarioSenial)
    {
        $form = $this->createDeleteForm($msvInventarioSenial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($msvInventarioSenial);
            $em->flush();
        }

        return $this->redirectToRoute('msvInventarioSenial_index');
    }

    /**
     * Creates a form to delete a msvInventarioSenial entity.
     *
     * @param MsvInventarioSenial $msvInventarioSenial The msvInventarioSenial entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MsvInventarioSenial $msvInventarioSenial)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('msvInventarioSenial_delete', array('id' => $msvInventarioSenial->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Lists all mpersonalFuncionario entities.
     *
     * @Route("/search/parametros", name="msvInventarioSenial_search_parametros")
     * @Method({"GET", "POST"})
     */
    public function searchByParametrosAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $senales['data'] = array();

        //if ($authCheck == true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $senales = $em->getRepository('AppBundle:MsvInventarioSenial')->getSearch($params);

            if ($senales == null) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Registro no encontrado",
                );
            }else{
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado",
                    'data'=> $senales,
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
