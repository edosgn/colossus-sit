<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TipoSociedad;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Tiposociedad controller.
 *
 * @Route("tipoSociedad")
 */
class TipoSociedadController extends Controller
{
    /**
     * Lists all tipoSociedad entities.
     *
     * @Route("/", name="tipoSociedad_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $tipoSociedad = $em->getRepository('AppBundle:TipoSociedad')->findBy(
            array('estado' => true)
        );

        $response = array(
            'status' => 'success',
            'code' => 200,
            'msj' => "Lista de tipoSociedad",
            'data' => $tipoSociedad, 
        );
        return $helpers->json($response);
    }

    /**
     * Creates a new tipoSociedad entity.
     *
     * @Route("/new", name="tiposociedad_new")
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
                $tipoSociedad = new TipoSociedad();

                $tipoSociedad->setNombre($params->nombre);
                $tipoSociedad->setEstado(true);

                $em = $this->getDoctrine()->getManager();
                $em->persist($tipoSociedad);
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
     * Finds and displays a tipoSociedad entity.
     *
     * @Route("/{id}/show", name="tiposociedad_show")
     * @Method("GET")
     */
    public function showAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $tipoSociedad = $em->getRepository('AppBundle:TipoSociedad')->find($id);

            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "Registro encontrado", 
                'data'=> $tiposociedad,
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
     * Displays a form to edit an existing tipoSociedad entity.
     *
     * @Route("/edit", name="tiposociedad_edit")
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
            $tipoSociedad = $em->getRepository("AppBundle:TipoSociedad")->find($params->id);

            $nombre = $params->nombre;

            if ($tipoSociedad!=null) {
                $tipoSociedad->setNombre($nombre);

                $em = $this->getDoctrine()->getManager();
                $em->persist($tipoSociedad);
                $em->flush();

                 $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Registro actualizado con exito", 
                        'data'=> $tipoSociedad,
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
     * Deletes a tipoSociedad entity.
     *
     * @Route("/{id}/delete", name="tiposociedad_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $tipoSociedad = $em->getRepository('AppBundle:TipoSociedad')->find($id);

            $tipoSociedad->setEstado(false);
            $em = $this->getDoctrine()->getManager();
                $em->persist($tipoSociedad);
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
     * Creates a form to delete a tipoSociedad entity.
     *
     * @param TipoSociedad $tipoSociedad The tipoSociedad entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TipoSociedad $tipoSociedad)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tiposociedad_delete', array('id' => $tipoSociedad->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="genero_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $response = null;
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $tiposSociedad = $em->getRepository('AppBundle:TipoSociedad')->findBy(
            array('estado' => true)
        );
        foreach ($tiposSociedad as $key => $tipoSociedad) {
            $response[$key] = array(
                'value' => $tipoSociedad->getId(),
                'label' => $tipoSociedad->getNombre(),
            );
        }
       return $helpers->json($response);
    }
}
