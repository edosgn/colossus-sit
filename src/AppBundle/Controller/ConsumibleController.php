<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Consumible;
use AppBundle\Form\ConsumibleType;

/**
 * Consumible controller.
 *
 * @Route("/consumible")
 */
class ConsumibleController extends Controller
{
    /**
     * Lists all Consumible entities.
     *
     * @Route("/", name="consumible_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $consumibles = $em->getRepository('AppBundle:Consumible')->findBy(
            array('estado' => 1)
        );
        $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado consumibles", 
                    'data'=> $consumibles,
            );
         
        return $helpers->json($responce);
    }

    /**
     * Creates a new Consumible entity.
     *
     * @Route("/new", name="consumible_new")
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
            // if (count($params)==0) {
            //     $responce = array(
            //         'status' => 'error',
            //         'code' => 400,
            //         'msj' => "los campos no pueden estar vacios", 
            //     );
            // }else{
                        $nombre = $params->nombre;
                        $consumible = new Consumible();

                        $consumible->setNombre($nombre);
                        $consumible->setEstado(true);

                        $em = $this->getDoctrine()->getManager();
                        $em->persist($consumible);
                        $em->flush();

                        $responce = array(
                            'status' => 'success',
                            'code' => 200,
                            'msj' => "consumible creado con exito", 
                        );
                       
                    // }
        }else{
            $responce = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida", 
            );
            } 
        return $helpers->json($responce);
    }

    /**
     * Finds and displays a Consumible entity.
     *
     * @Route("/show/{id}", name="consumible_show")
     * @Method("POST")
     */
    public function showAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $consumible = $em->getRepository('AppBundle:Consumible')->find($id);
            $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "consumible encontrado", 
                    'data'=> $consumible,
            );
        }else{
            $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($responce);
    }

    /**
     * Displays a form to edit an existing Consumible entity.
     *
     * @Route("/edit", name="consumible_edit")
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

            $consumibleId = $params->id;
            $nombre = $params->nombre;

            $em = $this->getDoctrine()->getManager();
            $consumible = $em->getRepository("AppBundle:Consumible")->find($consumibleId);

            if ($consumible!=null) {
                $consumible->setNombre($nombre);
                $em = $this->getDoctrine()->getManager();
                $em->persist($consumible);
                $em->flush();

                 $responce = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "consumible actualizado con exito", 
                        'data'=> $consumible,
                );
            }else{
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El consumible no se encuentra en la base de datos", 
                );
            }
        }else{
            $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar consumible", 
                );
        }

        return $helpers->json($responce);
    }

    /**
     * Deletes a Consumible entity.
     *
     * @Route("/{id}/delete", name="consumible_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $consumible = $em->getRepository('AppBundle:Consumible')->find($id);

            $consumible->setEstado(0);
            $em = $this->getDoctrine()->getManager();
                $em->persist($consumible);
                $em->flush();
            $responce = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "consumible eliminado con exito", 
                );
        }else{
            $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($responce);
    }

    /**
     * Creates a form to delete a Consumible entity.
     *
     * @param Consumible $consumible The Consumible entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Consumible $consumible)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('consumible_delete', array('id' => $consumible->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


    /**
     * datos para select 2
     *
     * @Route("/select", name="consumible_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $consumibles = $em->getRepository('AppBundle:Consumible')->findBy(
        array('estado' => 1)
    );
      foreach ($consumibles as $key => $consumible) {
        $responce[$key] = array(
            'value' => $consumible->getId(),
            'label' => $consumible->getNombre(),
            );
      }
       return $helpers->json($responce);
    }
}
