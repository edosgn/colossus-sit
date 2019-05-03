<?php

namespace JHWEB\FinancieroBundle\Controller;

use JHWEB\FinancieroBundle\Entity\FroInfrCfgCategoria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Froinfrcfgcategorium controller.
 *
 * @Route("froinfrcfgcategoria")
 */
class FroInfrCfgCategoriaController extends Controller
{
    /**
     * Lists all froInfrCfgCategorium entities.
     *
     * @Route("/", name="froinfrcfgcategoria_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $categorias = $em->getRepository('JHWEBFinancieroBundle:FroInfrCfgCategoria')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($categorias) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($categorias).' Registros encontrados', 
                'data'=> $categorias,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new froInfrCfgCategorium entity.
     *
     * @Route("/new", name="froinfrcfgcategoria_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $categoria = new FroInfrCfgCategoria();

            $categoria->setNombre(mb_strtoupper($params->nombre, 'utf-8'));
            $categoria->setDescripcion($params->descripcion);
            $categoria->setSmldv($params->smldv);
            $categoria->setActivo(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($categoria);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Registro creado con exito',  
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida', 
            );
        } 
        return $helpers->json($response);
    }

    /**
     * Finds and displays a froInfrCfgCategorium entity.
     *
     * @Route("/{id}/show", name="froinfrcfgcategoria_show")
     * @Method("GET")
     */
    public function showAction(FroInfrCfgCategoria $froInfrCfgCategorium)
    {
        $deleteForm = $this->createDeleteForm($froInfrCfgCategorium);

        return $this->render('froinfrcfgcategoria/show.html.twig', array(
            'froInfrCfgCategorium' => $froInfrCfgCategorium,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing froInfrCfgCategorium entity.
     *
     * @Route("/{id}/edit", name="froinfrcfgcategoria_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FroInfrCfgCategoria $froInfrCfgCategorium)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            $categoria = $em->getRepository("JHWEBFinancieroBundle:FroInfrCfgCategoria")->find(
                $params->id
            );

            if ($categoria) {
                $categoria->setNombre(mb_strtoupper($params->nombre, 'utf-8'));
                $categoria->setDescripcion($params->descripcion);
                $categoria->setSmldv($params->smldv);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Registro actualizado con exito', 
                    'data'=> $categoria,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'El registro no se encuentra en la base de datos', 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Autorizacion no valida para editar', 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a froInfrCfgCategorium entity.
     *
     * @Route("/{id}/delete", name="froinfrcfgcategoria_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FroInfrCfgCategoria $froInfrCfgCategorium)
    {
        $form = $this->createDeleteForm($froInfrCfgCategorium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($froInfrCfgCategorium);
            $em->flush();
        }

        return $this->redirectToRoute('froinfrcfgcategoria_index');
    }

    /**
     * Creates a form to delete a froInfrCfgCategorium entity.
     *
     * @param FroInfrCfgCategoria $froInfrCfgCategorium The froInfrCfgCategorium entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FroInfrCfgCategoria $froInfrCfgCategorium)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('froinfrcfgcategoria_delete', array('id' => $froInfrCfgCategorium->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* =============================================== */

    /**
     * Listado de todas la categorias para selección con búsqueda
     *
     * @Route("/select", name="froinfrcfgcategoria_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $categorias = $em->getRepository('JHWEBFinancieroBundle:FroInfrCfgCategoria')->findBy(
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
