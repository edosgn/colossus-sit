<?php

namespace JHWEB\UsuarioBundle\Controller;

use JHWEB\UsuarioBundle\Entity\UserLcCfgRestriccion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Userlccfgrestriccion controller.
 *
 * @Route("userlccfgrestriccion")
 */
class UserLcCfgRestriccionController extends Controller
{
    /**
     * Lists all userLcCfgRestriccion entities.
     *
     * @Route("/", name="userlccfgrestriccion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $restricciones = $em->getRepository('JHWEBUsuarioBundle:UserLcCfgRestriccion')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($restricciones) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($restricciones)." Registros encontrados", 
                'data'=> $restricciones,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new userLcCfgRestriccion entity.
     *
     * @Route("/new", name="userlccfgrestriccion_new")
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
            
            $restriccion = new UserLcCfgRestriccion();

            $restriccion->setNombre(mb_strtoupper($params->nombre, 'utf-8'));
            if ($params->codigo) {
                $restriccion->setCodigo($params->codigo);
            }
            $restriccion->setActivo(true);

            $em->persist($restriccion);
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
     * Finds and displays a userLcCfgRestriccion entity.
     *
     * @Route("/show", name="userlccfgrestriccion_show")
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

            $restriccion = $em->getRepository('JHWEBUsuarioBundle:UsercLcCfgRestriccion')->find(
                $params->id
            );

            $em->persist($restriccion);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro encontrado con exito",
                'data' => $restriccion,
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
     * Displays a form to edit an existing userLcCfgRestriccion entity.
     *
     * @Route("/edit", name="userlccfgrestriccion_edit")
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

            $restriccion = $em->getRepository("JHWEBUsuarioBundle:UserLcCfgRestriccion")->find(
                $params->id
            );

            if ($restriccion!=null) {
                $restriccion->setNombre($params->nombre);

                if ($params->codigo) {
                    $restriccion->setCodigo($params->codigo);
                }
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $restriccion,
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
     * Deletes a userLcCfgRestriccion entity.
     *
     * @Route("/{id}", name="userlccfgrestriccion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, UserLcCfgRestriccion $userLcCfgRestriccion)
    {
        $form = $this->createDeleteForm($userLcCfgRestriccion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($userLcCfgRestriccion);
            $em->flush();
        }

        return $this->redirectToRoute('userlccfgrestriccion_index');
    }

    /**
     * Creates a form to delete a userLcCfgRestriccion entity.
     *
     * @param UserLcCfgRestriccion $userLcCfgRestriccion The userLcCfgRestriccion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(UserLcCfgRestriccion $userLcCfgRestriccion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('userlccfgrestriccion_delete', array('id' => $userLcCfgRestriccion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Listado de todas las restriccions para selección con búsqueda
     *
     * @Route("/select", name="userlccfgrestriccion_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $restricciones = $em->getRepository('JHWEBUsuarioBundle:UserLcCfgRestriccion')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($restricciones as $key => $restriccion) {
            $response[$key] = array(
                'value' => $restriccion->getId(),
                'label' => $restriccion->getNombre(),
            );
        }

        return $helpers->json($response);
    }
}
