<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CondicionIngreso;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Condicioningreso controller.
 *
 * @Route("condicioningreso")
 */
class CondicionIngresoController extends Controller
{
    /**
     * Lists all condicionIngreso entities.
     *
     * @Route("/", name="condicioningreso_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $condicionesIngreso = $em->getRepository('AppBundle:CondicionIngreso')->findBy(
            array('estado' => true)
        );
        $response = array(
            'status' => 'success',
            'code' => 200,
            'msj' => "Listado de condiciones de ingreso", 
            'data'=> $condicionesIngreso,
        );
         
        return $helpers->json($response);
    }

    /**
     * Creates a new condicionIngreso entity.
     *
     * @Route("/new", name="condicioningreso_new")
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
                $condicionIngreso = new CondicionIngreso();

                $condicionIngreso->setNombre($params->nombre);
                $condicionIngreso->setEstado(true);

                $em = $this->getDoctrine()->getManager();
                $em->persist($condicionIngreso);
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
     * Finds and displays a condicionIngreso entity.
     *
     * @Route("/{id}/show", name="condicioningreso_show")
     * @Method("POST")
     */
    public function showAction($id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $condicionIngreso = $em->getRepository('AppBundle:CondicionIngreso')->find($id);
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro encontrado: ".$condicionIngreso->getNombre(), 
                    'data'=> $condicionIngreso,
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
     * Displays a form to edit an existing condicionIngreso entity.
     *
     * @Route("/{id}/edit", name="condicioningreso_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            $condicionIngreso = $em->getRepository("AppBundle:CondicionIngreso")->find($params->id);

            $nombre = $params->nombre;

            if ($condicionIngreso!=null) {
                $condicionIngreso->setNombre($nombre);

                $em = $this->getDoctrine()->getManager();
                $em->persist($condicionIngreso);
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
     * Deletes a condicionIngreso entity.
     *
     * @Route("/{id}/delete", name="condicioningreso_delete")
     * @Method("POST")
     */
    public function deleteAction($id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();

            $condicionIngreso = $em->getRepository("AppBundle:CondicionIngreso")->find($params->id);
            $condicionIngreso->setEstado(false);

            $em->persist($condicionIngreso);
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
     * Creates a form to delete a condicionIngreso entity.
     *
     * @param CondicionIngreso $condicionIngreso The condicionIngreso entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CondicionIngreso $condicionIngreso)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('condicioningreso_delete', array('id' => $condicionIngreso->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="lista_condicioningreso_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $response = null;
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $condicionesIngreso = $em->getRepository('AppBundle:CondicionIngreso')->findBy(
            array('estado' => 1)
        );
        foreach ($condicionesIngreso as $key => $condicionIngreso) {
            $response[$key] = array(
                'value' => $condicionIngreso->getId(),
                'label' => $condicionIngreso->getNombre(),
            );
        }
        return $helpers->json($response);
    }
}
