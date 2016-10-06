<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Variante;
use AppBundle\Form\VarianteType;

/**
 * Variante controller.
 *
 * @Route("/variante")
 */
class VarianteController extends Controller
{
    /**
     * Lists all Variante entities.
     *
     * @Route("/", name="variante_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $variantes = $em->getRepository('AppBundle:Variante')->findBy(
            array('estado' => 1)
        );
        $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado variantes", 
                    'data'=> $variantes,
            );
         
        return $helpers->json($responce);
    }

    /**
     * Creates a new Variante entity.
     *
     * @Route("/new", name="variante_new")
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
            if (count($params)==0) {
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "los campos no pueden estar vacios", 
                );
            }else{
                        $nombre = $params->nombre;
                        $banco = new Banco();

                        $banco->setNombre($nombre);
                        $banco->setEstado(true);

                        $em = $this->getDoctrine()->getManager();
                        $em->persist($banco);
                        $em->flush();

                        $responce = array(
                            'status' => 'success',
                            'code' => 200,
                            'msj' => "Banco creado con exito", 
                        );
                       
                    }
        }else{
            $responce = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida", 
            );
            } 
        return $helpers->json($responce);
    }

    /**
     * Finds and displays a Variante entity.
     *
     * @Route("/{id}", name="variante_show")
     * @Method("GET")
     */
    public function showAction(Variante $variante)
    {
        $deleteForm = $this->createDeleteForm($variante);

        return $this->render('AppBundle:Variante:show.html.twig', array(
            'variante' => $variante,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Variante entity.
     *
     * @Route("/{id}/edit", name="variante_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Variante $variante)
    {
        $deleteForm = $this->createDeleteForm($variante);
        $editForm = $this->createForm('AppBundle\Form\VarianteType', $variante);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($variante);
            $em->flush();

            return $this->redirectToRoute('variante_edit', array('id' => $variante->getId()));
        }

        return $this->render('AppBundle:Variante:edit.html.twig', array(
            'variante' => $variante,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Variante entity.
     *
     * @Route("/{id}", name="variante_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Variante $variante)
    {
        $form = $this->createDeleteForm($variante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($variante);
            $em->flush();
        }

        return $this->redirectToRoute('variante_index');
    }

    /**
     * Creates a form to delete a Variante entity.
     *
     * @param Variante $variante The Variante entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Variante $variante)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('variante_delete', array('id' => $variante->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
