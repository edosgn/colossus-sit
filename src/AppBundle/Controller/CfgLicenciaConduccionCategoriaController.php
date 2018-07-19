<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CfgLicenciaConduccionCategoria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cfglicenciaconduccioncategorium controller.
 *
 * @Route("cfglicenciaconduccioncategoria")
 */
class CfgLicenciaConduccionCategoriaController extends Controller
{
    /**
     * Lists all cfgLicenciaConduccionCategorium entities.
     *
     * @Route("/", name="cfglicenciaconduccioncategoria_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $categorias = $em->getRepository('AppBundle:CfgLicenciaConduccionCategoria')->findBy(
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
     * Creates a new cfgLicenciaConduccionCategorium entity.
     *
     * @Route("/new", name="cfglicenciaconduccioncategoria_new")
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
            
            $categoria = new CfgLicenciaConduccionCategoria();

            $categoria->setNombre($params->nombre);
            if ($params->descripcion) {
                $categoria->setDescripcion($params->descripcion);
            }
            $categoria->setActivo(true);

            $em->persist($categoria);
            $em->flush();
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "Categoria creada con éxito",
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
     * Finds and displays a cfgLicenciaConduccionCategorium entity.
     *
     * @Route("/{id}/show", name="cfglicenciaconduccioncategoria_show")
     * @Method("GET")
     */
    public function showAction(CfgLicenciaConduccionCategoria $cfgLicenciaConduccionCategorium)
    {
        $deleteForm = $this->createDeleteForm($cfgLicenciaConduccionCategorium);

        return $this->render('cfglicenciaconduccioncategoria/show.html.twig', array(
            'cfgLicenciaConduccionCategorium' => $cfgLicenciaConduccionCategorium,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cfgLicenciaConduccionCategorium entity.
     *
     * @Route("/{id}/edit", name="cfglicenciaconduccioncategoria_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CfgLicenciaConduccionCategoria $cfgLicenciaConduccionCategorium)
    {
        $deleteForm = $this->createDeleteForm($cfgLicenciaConduccionCategorium);
        $editForm = $this->createForm('AppBundle\Form\CfgLicenciaConduccionCategoriaType', $cfgLicenciaConduccionCategorium);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cfglicenciaconduccioncategoria_edit', array('id' => $cfgLicenciaConduccionCategorium->getId()));
        }

        return $this->render('cfglicenciaconduccioncategoria/edit.html.twig', array(
            'cfgLicenciaConduccionCategorium' => $cfgLicenciaConduccionCategorium,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cfgLicenciaConduccionCategorium entity.
     *
     * @Route("/delete", name="cfglicenciaconduccioncategoria_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CfgLicenciaConduccionCategoria $cfgLicenciaConduccionCategorium)
    {
        $form = $this->createDeleteForm($cfgLicenciaConduccionCategorium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cfgLicenciaConduccionCategorium);
            $em->flush();
        }

        return $this->redirectToRoute('cfglicenciaconduccioncategoria_index');
    }

    /**
     * Creates a form to delete a cfgLicenciaConduccionCategorium entity.
     *
     * @param CfgLicenciaConduccionCategoria $cfgLicenciaConduccionCategorium The cfgLicenciaConduccionCategorium entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgLicenciaConduccionCategoria $cfgLicenciaConduccionCategorium)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfglicenciaconduccioncategoria_delete', array('id' => $cfgLicenciaConduccionCategorium->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="cfglicenciaconduccioncategoria_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $categorias = $em->getRepository('AppBundle:CfgLicenciaConduccionCategoria')->findBy(
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
