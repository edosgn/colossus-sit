<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MsvCategoria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Msvcategoria controller.
 *
 * @Route("msvcategoria")
 */
class MsvCategoriaController extends Controller
{
    /**
     * Lists all msvCategoria entities.
     *
     * @Route("/", name="msvcategoria_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $categorias = $em->getRepository('AppBundle:MsvCategoria')->findBy( array('estado' => true));

        $response = array(
                    'status' => 'succes',
                    'code' => 200,
                    'message' => count($categorias) . " registros encontrados",
                    'data' => $categorias,
        );

        return $helpers ->json($response);
    }

    /**
     * Categoria por id.
     *
     * @Route("/getById", name="msvcategoria_id")
     * @Method({"GET", "POST"})
     */
    public function getCategoriaById(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $hash = $request->get("authorization", null);
        $categoriaId = $request->get("json", null);
        $authCheck = $helpers->authCheck($hash);
        $msvCategoria = $em->getRepository('AppBundle:MsvCategoria')->findById($categoriaId);

        $response = array(
                    'status' => 'succes',
                    'code' => 200,
                    'msj' => "Categoria encontrada",
                    'data' => $msvCategoria,
        );

        return $helpers ->json($response);
    }

    /**
     * Creates a new msvCategoria entity.
     *
     * @Route("/new", name="msvcategoria_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);
            
            $categoria = new MsvCategoria();

            $em = $this->getDoctrine()->getManager();

            $categoria->setNombre(strtoupper($params->nombre));
            $categoria->setEstado(true);
            $em->persist($categoria);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Los datos han sido registrados exitosamente.",
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Finds and displays a msvCategoria entity.
     *
     * @Route("/{id}/show", name="msvcategoria_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $categoria = $em->getRepository('AppBundle:MsvCategoria')->find($id);
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "categoria con nombre"." ".$categoria->getNombre(), 
                    'data'=> $categoria,
            );
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing msvCategoria entity.
     *
     * @Route("/edit", name="msvcategoria_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            $categoria = $em->getRepository('AppBundle:MsvCategoria')->find($params->id);

            if ($categoria != null) {
                $categoria->setNombre(strtoupper($params->nombre));

                $em->persist($categoria);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $categoria,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos",
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida para editar",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Deletes a msvCategoria entity.
     *
     * @Route("/delete", name="msvcategoria_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", true);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $json = $request->get("json", null);
            $params = json_decode($json);
            $categoria = $em->getRepository('AppBundle:MsvCategoria')->find($params);

            $categoria->setEstado(false);

            $em->persist($categoria);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro eliminado con éxito.",
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no válida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a msvCategoria entity.
     *
     * @param MsvCategoria $msvCategoria The msvCategoria entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MsvCategoria $msvCategoria)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('msvcategoria_delete', array('id' => $msvCategoria->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    
    /**
     * datos para select 2
     *
     * @Route("/select/categoria", name="msvCategoria_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $categorias = $em->getRepository('AppBundle:MsvCategoria')->findBy(
            array('estado' => 1)
        );
        $response = null;

        foreach ($categorias as $key => $categoria) {
            $response[$key] = array(
                'value' => $categoria->getId(),
                'label' => $categoria->getNombre(),
            );
        }
        return $helpers->json($response);
    }
}
