<?php

namespace JHWEB\UsuarioBundle\Controller;

use JHWEB\UsuarioBundle\Entity\UserCfgGenero;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Usercfggenero controller.
 *
 * @Route("usercfggenero")
 */
class UserCfgGeneroController extends Controller
{
    /**
     * Lists all userCfgGenero entities.
     *
     * @Route("/", name="usercfggenero_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $generos = $em->getRepository('JHWEBUsuarioBundle:UserCfgGenero')->findBy(
            array(
                'activo' => true
            )
        );

        $response['data'] = array();

        if ($generos) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($generos)." registros encontrados", 
                'data'=> $generos,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new userCfgGenero entity.
     *
     * @Route("/new", name="usercfggenero_new")
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

            $em = $this->getDoctrine()->getManager();

            $genero = new UserCfgGenero();

            $genero->setNombre(
                mb_strtoupper($params->nombre,'utf-8')
            );
            $genero->setSigla(
                mb_strtoupper($params->sigla,'utf-8')
            );
            $genero->setActivo(true);

            $em->persist($genero);
            $em->flush();
           
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con exito",
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
     * Finds and displays a userCfgGenero entity.
     *
     * @Route("/show", name="usercfggenero_show")
     * @Method("POST")
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $genero = $em->getRepository('JHWEBUsuarioBundle:UserCfgGenero')->find(
                $params->id
            );

            $em->persist($genero);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro encontrado con exito",
                'data' => $genero
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
     * Displays a form to edit an existing userCfgGenero entity.
     *
     * @Route("/edit", name="usercfggenero_edit")
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

            $genero = $em->getRepository("JHWEBContravencionalBundle:UserCfgGenero")->find(
                $params->id
            );

            if ($genero) {
                $genero->setNombre(
                    mb_strtoupper($params->nombre,'utf-8')
                );
                $genero->setSigla(
                    mb_strtoupper($params->sigla,'utf-8')
                );
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $genero,
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
                    'message' => "Autorizacion no valida para editar", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a userCfgGenero entity.
     *
     * @Route("/delete", name="usercfggenero_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $interes = $em->getRepository('JHWEBUsuarioBundle:UserCfgGenero')->find(
                $params->id
            );

            $interes->setActivo(false);

            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro eliminado con exito"
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
     * Creates a form to delete a userCfgGenero entity.
     *
     * @param UserCfgGenero $userCfgGenero The userCfgGenero entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(UserCfgGenero $userCfgGenero)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('usercfggenero_delete', array('id' => $userCfgGenero->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* =================================================== */

    /**
     * Listado de generos para seleccion con busqueda
     *
     * @Route("/select", name="usercfggenero_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $generos = $em->getRepository('JHWEBUsuarioBundle:UserCfgGenero')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($generos as $key => $genero) {
            $response[$key] = array(
                'value' => $genero->getId(),
                'label' => $genero->getNombre(),
            );
        }

        return $helpers->json($response);
    }
}
