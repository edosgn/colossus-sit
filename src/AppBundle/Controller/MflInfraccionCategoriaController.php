<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MflInfraccionCategoria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Mflinfraccioncategorium controller.
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
        $categorias = $em->getRepository('AppBundle:MflInfraccionCategoria')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($categorias) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => count($categorias)." Registros encontrados", 
                'data'=> $categorias,
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
                $categoria = new MflInfraccionCategoria();

                $categoria->setNombre($params->nombre);
                $categoria->setDescripcion($params->descripcion);
                $categoria->setSmldv($params->smldv);

                $em = $this->getDoctrine()->getManager();
                $em->persist($categoria);
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
     * @Route("/{id}/show", name="mflinfraccioncategoria_show")
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
     * @Route("/edit", name="mflinfraccioncategoria_edit")
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
            $categoria = $em->getRepository("AppBundle:MflInfraccionCategoria")->find($params->id);

            if ($categoria!=null) {
                $categoria->setNombre($params->nombre);
                $categoria->setDescripcion($params->descripcion);
                $categoria->setSmldv($params->smldv);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro actualizado con exito", 
                    'data'=> $categoria,
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
     * Deletes a mflInfraccionCategorium entity.
     *
     * @Route("/delete", name="mflinfraccioncategoria_delete")
     * @Method("POST")
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

    /**
     * datos para select 2
     *
     * @Route("/select", name="mflinfraccioncategoria_select_two")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $categorias = $em->getRepository('AppBundle:MflInfraccionCategoria')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($categorias as $key => $categoria) {
            $response[$key] = array(
                'value' => $categoria->getId(),
                'label' => $categoria->getNombre()
            );
        }
        return $helpers->json($response);
    }
}
