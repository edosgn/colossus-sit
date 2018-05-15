<?php

namespace AppBundle\Controller;

use AppBundle\Entity\OrigenRegistro;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Origenregistro controller.
 *
 * @Route("origenregistro")
 */
class OrigenRegistroController extends Controller
{
    /**
     * Lists all origenRegistro entities.
     *
     * @Route("/", name="origenregistro_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $origenesRegistro = $em->getRepository('AppBundle:CondicionIngreso')->findBy(
            array('estado' => true)
        );
        $response = array(
            'status' => 'success',
            'code' => 200,
            'msj' => "Listado de origenes de registro", 
            'data'=> $origenesRegistro,
        );
         
        return $helpers->json($response);
    }

    /**
     * Creates a new origenRegistro entity.
     *
     * @Route("/new", name="origenregistro_new")
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
                    'msj' => "Los campos no pueden estar vacios", 
                );
            }else{*/
                $origenRegistro = new OrigenRegistro();

                $origenRegistro->setNombre($params->nombre);
                $origenRegistro->setEstado(true);

                $em = $this->getDoctrine()->getManager();
                $em->persist($origenRegistro);
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
     * Finds and displays a origenRegistro entity.
     *
     * @Route("/{id}/show", name="origenregistro_show")
     * @Method("POST")
     */
    public function showAction($id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $origenSolicitud = $em->getRepository('AppBundle:OrigenRegistro')->find($id);
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro encontrado: ".$origenSolicitud->getNombre(), 
                    'data'=> $origenSolicitud,
            );
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
     * Displays a form to edit an existing origenRegistro entity.
     *
     * @Route("/{id}/edit", name="origenregistro_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            $origenRegistro = $em->getRepository("AppBundle:OrigenRegistro")->find($params->id);

            $nombre = $params->nombre;

            if ($origenRegistro!=null) {
                $origenRegistro->setNombre($nombre);

                $em = $this->getDoctrine()->getManager();
                $em->persist($origenRegistro);
                $em->flush();

                 $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Registro actualizado con exito", 
                        'data'=> $condicionIngreso,
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
     * Deletes a origenRegistro entity.
     *
     * @Route("/{id}/delete", name="origenregistro_delete")
     * @Method("POST")
     */
    public function deleteAction($id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();

            $origenRegistro = $em->getRepository("AppBundle:OrigenRegistro")->find($params->id);
            $origenRegistro->setEstado(false);

            $em->persist($origenRegistro);
            $em->flush();
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "Registro eliminado con exito", 
            );
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
     * Creates a form to delete a origenRegistro entity.
     *
     * @param OrigenRegistro $origenRegistro The origenRegistro entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(OrigenRegistro $origenRegistro)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('origenregistro_delete', array('id' => $origenRegistro->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="origenregistro_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $response = null;
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $origenesRegistro = $em->getRepository('AppBundle:OrigenRegistro')->findBy(
            array('estado' => 1)
        );
        foreach ($origenesRegistro as $key => $origenRegistro) {
            $response[$key] = array(
                'value' => $origenRegistro->getId(),
                'label' => $origenRegistro->getNombre(),
            );
        }
        return $helpers->json($response);
    }
}
