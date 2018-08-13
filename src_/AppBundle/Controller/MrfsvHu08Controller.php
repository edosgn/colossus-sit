<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MrfsvHu08;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Mrfsvhu08 controller.
 *
 * @Route("mrfsvHu08")
 */
class MrfsvHu08Controller extends Controller
{
    /**
     * Lists all mrfsvHu08 entities.
     *
     * @Route("/", name="mrfsvHu08_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $mrfsvHu08 = $em->getRepository('AppBundle:MrfsvHu08')->findAll();

        $response['data'] = array();

        if ($mrfsvHu08) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => 'listado senales',
                'data' => $mrfsvHu08,
            );
        }
        return $helpers->json($response);

        /*$em = $this->getDoctrine()->getManager();

        $mrfsvHu08 = $em->getRepository('AppBundle:MrfsvHu08')->findAll();

        return $this->render('mrfsvhu08/index.html.twig', array(
            'mrfsvHu08s' => $mrfsvHu08s,
        ));*/

    }

    /**
     * Creates a new mrfsvHu08 entity.
     *
     */
    public function newAction(Request $request)
    {
        $mrfsvHu08 = new Mrfsvhu08();
        $form = $this->createForm('AppBundle\Form\MrfsvHu08Type', $mrfsvHu08);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mrfsvHu08);
            $em->flush();

            return $this->redirectToRoute('mrfsvhu08_show', array('id' => $mrfsvHu08->getId()));
        }

        return $this->render('mrfsvhu08/new.html.twig', array(
            'mrfsvHu08' => $mrfsvHu08,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a mrfsvHu08 entity.
     *
     */
    public function showAction(MrfsvHu08 $mrfsvHu08)
    {
        $deleteForm = $this->createDeleteForm($mrfsvHu08);

        return $this->render('mrfsvhu08/show.html.twig', array(
            'mrfsvHu08' => $mrfsvHu08,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing mrfsvHu08 entity.
     *
     */
    public function editAction(Request $request, MrfsvHu08 $mrfsvHu08)
    {
        $deleteForm = $this->createDeleteForm($mrfsvHu08);
        $editForm = $this->createForm('AppBundle\Form\MrfsvHu08Type', $mrfsvHu08);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mrfsvhu08_edit', array('id' => $mrfsvHu08->getId()));
        }

        return $this->render('mrfsvhu08/edit.html.twig', array(
            'mrfsvHu08' => $mrfsvHu08,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a mrfsvHu08 entity.
     *
     */
    public function deleteAction(Request $request, MrfsvHu08 $mrfsvHu08)
    {
        $form = $this->createDeleteForm($mrfsvHu08);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mrfsvHu08);
            $em->flush();
        }

        return $this->redirectToRoute('mrfsvhu08_index');
    }

    /**
     * Creates a form to delete a mrfsvHu08 entity.
     *
     * @param MrfsvHu08 $mrfsvHu08 The mrfsvHu08 entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MrfsvHu08 $mrfsvHu08)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mrfsvhu08_delete', array('id' => $mrfsvHu08->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Lists all mpersonalFuncionario entities.
     *
     * @Route("/search/parametros", name="mrfsvhu08_search_parametros")
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

            $senales = $em->getRepository('AppBundle:MrfsvHu08')->getSearch($params);

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
