<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MrfsvHu09;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Mrfsvhu09 controller.
 *
 * @Route("mrfsvHu09")
 */
class MrfsvHu09Controller extends Controller
{
    /**
     * Lists all mrfsvHu09 entities.
     *
     * @Route("/", name="mrfsvhu09_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $mrfsvHu09s = $em->getRepository('AppBundle:MrfsvHu09')->findAll();

        return $this->render('mrfsvhu09/index.html.twig', array(
            'mrfsvHu09s' => $mrfsvHu09s,
        ));
    }

    /**
     * Creates a new mrfsvHu09 entity.
     *
     * Route("/new", name="mrfsvhu09_new")
     * Method({"GET", "POST"})
     */
    /*public function newAction(Request $request)
    {
        $mrfsvHu09 = new Mrfsvhu09();
        $form = $this->createForm('AppBundle\Form\MrfsvHu09Type', $mrfsvHu09);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mrfsvHu09);
            $em->flush();

            return $this->redirectToRoute('mrfsvhu09_show', array('id' => $mrfsvHu09->getId()));
        }

        return $this->render('mrfsvhu09/new.html.twig', array(
            'mrfsvHu09' => $mrfsvHu09,
            'form' => $form->createView(),
        ));
    }*/

    /**
     * Creates a new mpersonalFuncionario entity.
     *
     * @Route("/new", name="mrfsvhu09_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        /*$helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck== true) {
            $json = $request->get("json",null);
            $params = json_decode($json);*/

            /*if (count($params)==0) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "los campos no pueden estar vacios",
                );
            }else{*/
 /*           $mrfsvHu09 = new MrfsvHu09();

            $em = $this->getDoctrine()->getManager();

            $tipoDestino = $em->getRepository()->find(
                $params->tipoDestinoId
            );
            $mrfsvHu09->setTipoDestino($tipoDestino);

            if ($params->destinoId) {
                $mrfsvHu09->setXDestino($params->destinoId);
            }

            $tipoSenal = $em->getRepository()->find(
                $params->tipoSenalId
            );
            $mrfsvHu09->setTipoSenal($tipoSenal);

            //if ($params->file) {
              //  $mrfsvHu09->setArchivo($params->file);
            //}

            $em->persist($mrfsvHu09);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con exito",
                'data' => $mrfsvHu09
            );
            //}
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida",
            );
        }
        return $helpers->json($response);*/

        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        //if ($authCheck== true) {
            $json = $request->get("json", null);
            $params = json_decode($json);


        //}



        return new Response(print_r($params));

        //public destinoId:number,
		//public tipoDestinoId:number,
		//public tipoSenalId:number,
		//public mrfsvHu08Id:number,
		//public archivo:string
    }

    /**
     * Finds and displays a mrfsvHu09 entity.
     *
     * Route("/{id}", name="mrfsvhu09_show")
     * Method("GET")
     */
    public function showAction(MrfsvHu09 $mrfsvHu09)
    {
        $deleteForm = $this->createDeleteForm($mrfsvHu09);

        return $this->render('mrfsvhu09/show.html.twig', array(
            'mrfsvHu09' => $mrfsvHu09,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing mrfsvHu09 entity.
     *
     * @Route("/{id}/edit", name="mrfsvhu09_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MrfsvHu09 $mrfsvHu09)
    {
        $deleteForm = $this->createDeleteForm($mrfsvHu09);
        $editForm = $this->createForm('AppBundle\Form\MrfsvHu09Type', $mrfsvHu09);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mrfsvhu09_edit', array('id' => $mrfsvHu09->getId()));
        }

        return $this->render('mrfsvhu09/edit.html.twig', array(
            'mrfsvHu09' => $mrfsvHu09,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a mrfsvHu09 entity.
     *
     * @Route("/{id}", name="mrfsvhu09_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MrfsvHu09 $mrfsvHu09)
    {
        $form = $this->createDeleteForm($mrfsvHu09);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mrfsvHu09);
            $em->flush();
        }

        return $this->redirectToRoute('mrfsvhu09_index');
    }

    /**
     * Creates a form to delete a mrfsvHu09 entity.
     *
     * @param MrfsvHu09 $mrfsvHu09 The mrfsvHu09 entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MrfsvHu09 $mrfsvHu09)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mrfsvhu09_delete', array('id' => $mrfsvHu09->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Lists all mpersonalFuncionario entities.
     *
     * @Route("/search/parametros", name="mrfsvhu09_search_parametros")
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

        $senales = $em->getRepository('AppBundle:MrfsvHu09')->getSearch($params);

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

    /**
     * Lists all mrfsvHu09 entities.
     *
     * @Route("/full", name="mrfsvhu09_search_full")
     * @Method("GET")
     */
    public function searchByFullAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $mrfsvHu09 = $em->getRepository('AppBundle:MrfsvHu09')->getFull();

        $response['data'] = array();

        if ($mrfsvHu09) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => 'listado senales',
                'data' => $mrfsvHu09,
            );
        }
        return $helpers->json($response);

    }

    /**
     * Lists all mrfsvHu09 entities.
     *
     * @Route("/export", name="mrfsvhu09_export")
     * @Method("GET")
     */
    public function exportAction()
    {
        return new Response();
    }
}
