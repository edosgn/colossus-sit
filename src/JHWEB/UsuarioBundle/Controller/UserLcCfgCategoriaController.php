<?php

namespace JHWEB\UsuarioBundle\Controller;

use JHWEB\UsuarioBundle\Entity\UserLcCfgCategoria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Userlccfgcategorium controller.
 *
 * @Route("userlccfgcategoria")
 */
class UserLcCfgCategoriaController extends Controller
{
    /**
     * Lists all userLcCfgCategorium entities.
     *
     * @Route("/", name="userlccfgcategoria_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $categorias = $em->getRepository('JHWEBUsuarioBundle:UserLcCfgCategoria')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($categorias) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($categorias)." Registros encontrados", 
                'data'=> $categorias,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new cfgLicenciaConduccionCategorium entity.
     *
     * @Route("/new", name="userlccfgcategoria_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization",null);
        $authCheck = $helpers->authCheck($hash);

        if($authCheck == true){
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            
            $categoria = new UserLcCfgCategoria();

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
                'message' => "Registro creado con éxito",
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no valida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Finds and displays a userLcCfgCategorium entity.
     *
     * @Route("/show", name="userlccfgcategoria_show")
     * @Method("GET")
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

            $categoria = $em->getRepository('JHWEBUsuarioBundle:UsercLcCfgCategoria')->find(
                $params->id
            );

            $em->persist($categoria);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro encontrado con exito",
                'data' => $categoria,
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida",
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing userLcCfgCategoria entity.
     *
     * @Route("/edit", name="userlccfgcategoria_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            $categoria = $em->getRepository("JHWEBUsuarioBundle:UserLcCfgCategoria")->find(
                $params->id
            );

            if ($categoria!=null) {
                $categoria->setNombre($params->nombre);

                if ($params->descripcion) {
                    $categoria->setDescripcion($params->descripcion);
                }
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $categoria,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorización no valida", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Finds and displays a userLcCfgCategorium entity.
     *
     * @Route("/delete", name="userlccfgcategoria_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $categoria = $em->getRepository('JHWEBUsuarioBundle:UserLcCfgCategoria')->find(
                $params->id
            );

            $categoria->setActivo(false);
            $em->persist($categoria);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro eliminado con éxito",
                'data' => $categoria,
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no valida",
            );
        }
        
        return $helpers->json($response);
    }

    /* ========================================= */

    /**
     * Listado de todas las categorias para selección con búsqueda
     *
     * @Route("/select", name="userlccfgcategoria_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $categorias = $em->getRepository('JHWEBUsuarioBundle:UserLcCfgCategoria')->findBy(
            array('activo' => true)
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

    /**
     * Listado de todas las categorias según el tipo de vehiculo para selección con búsqueda
     *
     * @Route("/servicio/tipovehiculo/select", name="userlccfgcategoria_servicio_tipovehiculo_select")
     * @Method({"GET", "POST"})
     */
    public function selectByServicioAndTipoVehiculoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            
            $em = $this->getDoctrine()->getManager();
            
            $categorias = $em->getRepository('JHWEBUsuarioBundle:UserLcCfgCategoria')->findBy(
                array('activo' => true)
            );

            $tipoVehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloCfgTipoVehiculo')->find(
                $params->idTipoVehiculo
            );

            $servicio = $em->getRepository('JHWEBVehiculoBundle:VhloCfgServicio')->find(
                $params->idServicio
            );

            $arrayCategorias = null;

            if ($categorias) {
                foreach ($categorias as $key => $categoria) {
                    if ($tipoVehiculo->getId() == 1 && ($categoria->getId() == 1 || $categoria->getId() == 1)) {
                        $arrayCategorias[$key] = array(
                            'value' => $categoria->getId(),
                            'label' => $categoria->getNombre(),
                        );
                    }elseif ($tipoVehiculo->getId() == 2 && $servicio->getId() == 1 && ($categoria->getId() == 3 || $categoria->getId() == 4 || $categoria->getId() == 5)) {
                        $arrayCategorias[$key] = array(
                            'value' => $categoria->getId(),
                            'label' => $categoria->getNombre(),
                        );
                    }elseif ($tipoVehiculo->getId() == 2 && $servicio->getId() == 2 && ($categoria->getId() == 6 || $categoria->getId() == 7 || $categoria->getId() == 8)) {
                        $arrayCategorias[$key] = array(
                            'value' => $categoria->getId(),
                            'label' => $categoria->getNombre(),
                        );
                    }
                }

                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Categorias encontradas.',
                    'data' => $arrayCategorias,
                );
            }else{
                $response = array(
                    'title' => 'Atención!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => 'No existen categorias activas en el sistema.',
                );
            }
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no valida",
            );
        }
        
        return $helpers->json($response);
    }
}
