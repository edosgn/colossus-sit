<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MpersonalComparendo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Mpersonalcomparendo controller.
 *
 * @Route("mpersonalcomparendo")
 */
class MpersonalComparendoController extends Controller
{
    /**
     * Lists all mpersonalComparendo entities.
     *
     * @Route("/", name="mpersonalcomparendo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $comparendos = $em->getRepository('AppBundle:MpersonalComparendo')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($comparendos) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => count($comparendos)." Registros encontrados", 
                'data'=> $comparendos,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new mpersonalComparendo entity.
     *
     * @Route("/new", name="mpersonalcomparendo_new")
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
                $comparendo = new MpersonalComparendo();

                $comparendo->setInicio($params->incio);
                $comparendo->setFin($params->fin);
                $comparendo->setFechaAsignación(new \Datetime($params->fechaAsignacion));
                $comparendo->setNumeroResolucion($params->numeroResolucion);

                $sedeOperativa = $em->getRepository('AppBundle:sedeOperativa')->find(
                    $params->sedeOperativaId
                );
                $comparendo->setSedeOperativa($sedeOperativa);

                $em = $this->getDoctrine()->getManager();
                $em->persist($comparendo);
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
     * Finds and displays a mpersonalComparendo entity.
     *
     * @Route("/{id}", name="mpersonalcomparendo_show")
     * @Method("GET")
     */
    public function showAction(MpersonalComparendo $mpersonalComparendo)
    {
        $deleteForm = $this->createDeleteForm($mpersonalComparendo);

        return $this->render('mpersonalcomparendo/show.html.twig', array(
            'mpersonalComparendo' => $mpersonalComparendo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing mpersonalComparendo entity.
     *
     * @Route("/{id}/edit", name="mpersonalcomparendo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MpersonalComparendo $mpersonalComparendo)
    {
        $deleteForm = $this->createDeleteForm($mpersonalComparendo);
        $editForm = $this->createForm('AppBundle\Form\MpersonalComparendoType', $mpersonalComparendo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mpersonalcomparendo_edit', array('id' => $mpersonalComparendo->getId()));
        }

        return $this->render('mpersonalcomparendo/edit.html.twig', array(
            'mpersonalComparendo' => $mpersonalComparendo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a mpersonalComparendo entity.
     *
     * @Route("/{id}", name="mpersonalcomparendo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MpersonalComparendo $mpersonalComparendo)
    {
        $form = $this->createDeleteForm($mpersonalComparendo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mpersonalComparendo);
            $em->flush();
        }

        return $this->redirectToRoute('mpersonalcomparendo_index');
    }

    /**
     * Creates a form to delete a mpersonalComparendo entity.
     *
     * @param MpersonalComparendo $mpersonalComparendo The mpersonalComparendo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MpersonalComparendo $mpersonalComparendo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mpersonalcomparendo_delete', array('id' => $mpersonalComparendo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
