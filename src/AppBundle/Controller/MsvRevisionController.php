<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MsvRevision;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Msvrevision controller.
 *
 * @Route("msvrevision")
 */
class MsvRevisionController extends Controller
{
    /**
     * Lists all msvRevision entities.
     *
     * @Route("/", name="msvrevision_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $msvRevisiones = $em->getRepository('AppBundle:MsvRevision')->findBy(array('estado' => 1));

        $response = array(
            'status' => 'succes',
            'code' => 200,
            'msj' => "Listado revisiones",
            'data' => $msvRevisiones,
        );
        return $helpers -> json($response);
    }

    /**
     * Creates a new msvRevision entity.
     *
     * @Route("/new", name="msvrevision_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization",null);
        $authCheck = $helpers->authCheck($hash);
        if($authCheck == true){
            $json = $request->get("json",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            
                $revision = new MsvRevision();
                $revision->setFechaRecepcion($params->fechaRecepcion);
                $revision->setFechaDevolucion($params->fechaDevolucion);
                $revision->setFechaOtorgamiento($params->fechaOtorgamiento);
                $revision->setFuncionario($params->funcionario);
                $revision->setEstado(true);
                $em->persist($revision);
                $em->flush();
                $response = array(
                            'status' => 'success',
                            'code' => 200,
                            'msj' => "Revisión creada con éxito",
                );    
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorización no valida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Finds and displays a msvRevision entity.
     *
     * @Route("/{id}", name="msvrevision_show")
     * @Method("GET")
     */
    public function showAction(MsvRevision $msvRevision)
    {
        $deleteForm = $this->createDeleteForm($msvRevision);

        return $this->render('msvrevision/show.html.twig', array(
            'msvRevision' => $msvRevision,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing msvRevision entity.
     *
     * @Route("/{id}/edit", name="msvrevision_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MsvRevision $msvRevision)
    {
        $deleteForm = $this->createDeleteForm($msvRevision);
        $editForm = $this->createForm('AppBundle\Form\MsvRevisionType', $msvRevision);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('msvrevision_edit', array('id' => $msvRevision->getId()));
        }

        return $this->render('msvrevision/edit.html.twig', array(
            'msvRevision' => $msvRevision,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a msvRevision entity.
     *
     * @Route("/{id}", name="msvrevision_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MsvRevision $msvRevision)
    {
        $form = $this->createDeleteForm($msvRevision);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($msvRevision);
            $em->flush();
        }

        return $this->redirectToRoute('msvrevision_index');
    }

    /**
     * Creates a form to delete a msvRevision entity.
     *
     * @param MsvRevision $msvRevision The msvRevision entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MsvRevision $msvRevision)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('msvrevision_delete', array('id' => $msvRevision->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
