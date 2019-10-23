<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgCategoria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgcategorium controller.
 *
 * @Route("svcfgcategoria")
 */
class SvCfgCategoriaController extends Controller
{
    /**
     * Lists all svCfgCategorium entities.
     *
     * @Route("/", name="svcfgcategoria_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $categorias = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgCategoria')->findBy(
            array(
                'activo' => true
            )
        );

        $response = array(
            'title' => 'Perfecto!',
            'status' => 'succes',
            'code' => 200,
            'message' => count($categorias) . " registros encontrados",
            'data' => $categorias,
        );

        return $helpers ->json($response);
    }

    /**
     * Creates a new svCfgCategoria entity.
     *
     * @Route("/new", name="svcfgcategoria_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            
            $em = $this->getDoctrine()->getManager();
            
            $categoria = new SvCfgCategoria();
            $categoria->setNombre(strtoupper($params->nombre));
            $categoria->setHabilitado(true);
            $categoria->setActivo(true);
            $em->persist($categoria);
            $em->flush();

            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Los datos han sido registrados exitosamente.",
            );
        } else {
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Finds and displays a svCfgCategoria entity.
     *
     * @Route("/show", name="svcfgcategoria_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            
            $categoria = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgCategoria')->find($params->id);

            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "categoria con nombre"." ".$categoria->getNombre(), 
                'data'=> $categoria,
            );
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
            );
        }
        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing SvCfgCategoria entity.
     *
     * @Route("/edit", name="svcfgcategoria_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();

            $categoria = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgCategoria')->find($params->id);

            if ($categoria != null) {
                $categoria->setNombre(strtoupper($params->nombre));

                $em->persist($categoria);
                $em->flush();

                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $categoria,
                );
            } else {
                $response = array(
                    'title' => 'Error!',
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
     * Displays a form to edit an existing svCfgCategoria entity.
     *
     * @Route("/edit/estado/categoria", name="svcfgcategoria_estado_edit")
     * @Method({"GET", "POST"})
     */
    public function editEstadoCategoriaAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            
            $em = $this->getDoctrine()->getManager();
            $categoria = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgCategoria')->find($params->id);

            if ($categoria != null) {
                $categoria->setHabilitado(false);

                $em->persist($categoria);
                $em->flush();
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Se actualizó el estado con éxito",
                    'data' => $categoria,
                );
            } else {
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos",
                );
            }
        } else {
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida para editar",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Deletes a svCfgCategoria entity.
     *
     * @Route("/delete", name="svcfgcategoria_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", true);
        $authCheck = $helpers->authCheck($hash);
        
        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();

            $categoria = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgCategoria')->find($params->id);

            $categoria->setActivo(false);

            $em->persist($categoria);
            $em->flush();

            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Registro eliminado con éxito.",
            );
        } else {
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no válida",
            );
        }
        return $helpers->json($response);
    }
    
    /**
     * datos para select 2
     *
     * @Route("/select", name="svcfgcategoria_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $categorias = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgCategoria')->findBy(
            array(
                'habilitado' => 1,
                'activo' => 1,
            )
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
