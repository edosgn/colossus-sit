<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Genero;
use AppBundle\Form\GeneroType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Genero controller.
 *
 * @Route("genero")
 */
class GeneroController extends Controller
{
    /**
     * Lists all genero entities.
     *
     * @Route("/", name="genero_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $generos = $em->getRepository('AppBundle:Genero')->findBy(
            array('estado' => 1)
        );

        $response = array(
            'status' => 'success',
            'code' => 200,
            'msj' => "Lista de generos",
            'data' => $generos, 
        );
        return $helpers->json($response);
    }

    /**
     * Creates a new genero entity.
     *
     * @Route("/new", name="genero_new")
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
                $genero = new Genero();

                $genero->setNombre($params->nombre);
                $genero->setSigla($params->sigla);
                $genero->setEstado(true);

                $em = $this->getDoctrine()->getManager();
                $em->persist($genero);
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
     * Finds and displays a genero entity.
     *
     * @Route("/{id}/show", name="genero_show")
     * @Method("GET")
     */
    public function showAction(Genero $genero)
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
                    'data'=> $genero,
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
     * Displays a form to edit an existing genero entity.
     *
     * @Route("/edit", name="genero_edit")
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
            $genero = $em->getRepository("AppBundle:Genero")->find($params->id);

            $nombre = $params->nombre;
            $sigla = $params->sigla;

            if ($genero!=null) {
                $genero->setNombre($nombre);
                $genero->setSigla($sigla);

                $em = $this->getDoctrine()->getManager();
                $em->persist($genero);
                $em->flush();

                 $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Registro actualizado con exito", 
                        'data'=> $genero,
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
     * Deletes a genero entity.
     *
     * @Route("/{id}/delete", name="genero_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, Genero $genero)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();

            $genero->setEstado(false);
            $em = $this->getDoctrine()->getManager();
                $em->persist($genero);
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
     * Creates a form to delete a genero entity.
     *
     * @param Genero $genero The genero entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Genero $genero)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('genero_delete', array('id' => $genero->getId())))
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
    $generos = $em->getRepository('AppBundle:Genero')->findBy(
        array('estado' => 1)
    );
    foreach ($generos as $key => $genero) {
        $response[$key] = array(
            'value' => $genero->getId(),
            'label' => $genero->getSigla()."_".$genero->getNombre(),
        );
    }
       return $helpers->json($response);
    }
}
