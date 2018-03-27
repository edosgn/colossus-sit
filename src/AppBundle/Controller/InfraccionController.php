<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Infraccion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Infraccion controller.
 *
 * @Route("infraccion")
 */
class InfraccionController extends Controller
{
    /**
     * Lists all infraccion entities.
     *
     * @Route("/", name="infraccion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $infracciones = $em->getRepository('AppBundle:Infraccion')->findAll();

        $response = array(
            'status' => 'success',
            'code' => 200,
            'msj' => "Lista de infracciones",
            'data' => $infracciones, 
        );
        return $helpers->json($response);
    }

    /**
     * Creates a new infraccion entity.
     *
     * @Route("/new", name="infraccion_new")
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
            if (count($params)==0) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Los campos no pueden estar vacios", 
                );
            }else{
                $codigoInfraccion = $params->codigoInfraccion;
                $descripcionInfraccion = $params->descripcionInfraccion;
                $valorInfraccion = $params->valorInfraccion;

                $infraccion = new Infraccion();

                $infraccion->setCodigoInfraccion($codigoInfraccion);
                $infraccion->setDescripcionInfraccion($descripcionInfraccion);
                $infraccion->setValorInfraccion($valorInfraccion);

                $em = $this->getDoctrine()->getManager();
                $em->persist($infraccion);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro creado con exito", 
                );
            }
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
     * Finds and displays a infraccion entity.
     *
     * @Route("/{id}/show", name="infraccion_show")
     * @Method("GET")
     */
    public function showAction(Infraccion $infraccion)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro encontrado", 
                    'data'=> $infraccion,
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
     * Displays a form to edit an existing infraccion entity.
     *
     * @Route("/{id}/edit", name="infraccion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Infraccion $infraccion)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $codigoInfraccion = $params->codigoInfraccion;
            $descripcionInfraccion = $params->descripcionInfraccion;
            $valorInfraccion = $params->valorInfraccion;

            $em = $this->getDoctrine()->getManager();

            if ($infraccion) {
                $infraccion->setCodigoInfraccion($codigoInfraccion);
                $infraccion->setDescripcionInfraccion($descripcionInfraccion);
                $infraccion->setValorInfraccion($valorInfraccion);

                $em = $this->getDoctrine()->getManager();
                $em->persist($infraccion);
                $em->flush();

                 $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Registro actualizado con exito", 
                        'data'=> $infraccion,
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
                    'msj' => "Autorizacion no valida para editar banco", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a infraccion entity.
     *
     * @Route("/{id}/delete", name="infraccion_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, Infraccion $infraccion)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();

            $infraccion->setEstado(false);
            $em = $this->getDoctrine()->getManager();
                $em->persist($infraccion);
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
     * Creates a form to delete a infraccion entity.
     *
     * @param Infraccion $infraccion The infraccion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Infraccion $infraccion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('infraccion_delete', array('id' => $infraccion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
