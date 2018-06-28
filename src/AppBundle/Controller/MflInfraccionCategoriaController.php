<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MflInfraccionCategoria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Mflinfraccioncategoria controller.
 *
 * @Route("mflinfraccioncategoria")
 */
class MflInfraccionCategoriaController extends Controller
{
    /**
     * Lists all mflInfraccionCategorium entities.
     *
     * @Route("/", name="mflinfraccioncategoria_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $infraccionCategorias = $em->getRepository('AppBundle:MflInfraccionCategoria')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($infraccionCategorias) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "Lista de categorias", 
                'data'=> $infraccionCategorias,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new mflInfraccionCategorium entity.
     *
     * @Route("/new", name="mflinfraccioncategoria_new")
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
                $infraccionCategoria = new MflInfraccionCategoria();

                $infraccionCategoria->setNombre($params->nombre);
                $infraccionCategoria->setDescripcion($params->descripcion);
                $infraccionCategoria->setSmldv($params->smldv);

                $em = $this->getDoctrine()->getManager();
                $em->persist($infraccionCategoria);
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
     * Finds and displays a mflInfraccionCategorium entity.
     *
     * @Route("/{id}", name="mflinfraccioncategoria_show")
     * @Method("GET")
     */
    public function showAction(MflInfraccionCategoria $mflInfraccionCategorium)
    {
        $deleteForm = $this->createDeleteForm($mflInfraccionCategorium);

        return $this->render('mflinfraccioncategoria/show.html.twig', array(
            'mflInfraccionCategorium' => $mflInfraccionCategorium,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing mflInfraccionCategorium entity.
     *
     * @Route("/{id}/edit", name="mflinfraccioncategoria_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MflInfraccionCategoria $mflInfraccionCategorium)
    {
        $deleteForm = $this->createDeleteForm($mflInfraccionCategorium);
        $editForm = $this->createForm('AppBundle\Form\MflInfraccionCategoriaType', $mflInfraccionCategorium);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mflinfraccioncategoria_edit', array('id' => $mflInfraccionCategorium->getId()));
        }

        return $this->render('mflinfraccioncategoria/edit.html.twig', array(
            'mflInfraccionCategorium' => $mflInfraccionCategorium,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a mflInfraccionCategorium entity.
     *
     * @Route("/{id}", name="mflinfraccioncategoria_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MflInfraccionCategoria $mflInfraccionCategorium)
    {
        $form = $this->createDeleteForm($mflInfraccionCategorium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mflInfraccionCategorium);
            $em->flush();
        }

        return $this->redirectToRoute('mflinfraccioncategoria_index');
    }

    /**
     * Creates a form to delete a mflInfraccionCategorium entity.
     *
     * @param MflInfraccionCategoria $mflInfraccionCategorium The mflInfraccionCategorium entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MflInfraccionCategoria $mflInfraccionCategorium)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mflinfraccioncategoria_delete', array('id' => $mflInfraccionCategorium->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
