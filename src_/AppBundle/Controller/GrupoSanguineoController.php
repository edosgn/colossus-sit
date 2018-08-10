<?php

namespace AppBundle\Controller;

use AppBundle\Entity\GrupoSanguineo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Gruposanguineo controller.
 *
 * @Route("gruposanguineo")
 */
class GrupoSanguineoController extends Controller
{
    /**
     * Lists all grupoSanguineo entities.
     *
     * @Route("/", name="gruposanguineo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $gruposSanguineos = $em->getRepository('AppBundle:GrupoSanguineo')->findBy(
            array('estado' => 1)
        );

        $response = array(
            'status' => 'success',
            'code' => 200,
            'msj' => "Lista de grupos sanguineos",
            'data' => $gruposSanguineos, 
        );
        return $helpers->json($response);
    }

    /**
     * Creates a new grupoSanguineo entity.
     *
     * @Route("/new", name="gruposanguineo_new")
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
                $grupoSanguineo = new Gruposanguineo();

                $sigla = "'".$params->sigla."'";

                $grupoSanguineo->setNombre($params->nombre);
                $grupoSanguineo->setSigla($sigla);
                $grupoSanguineo->setEstado(true);

                $em = $this->getDoctrine()->getManager();
                $em->persist($grupoSanguineo);
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
     * Finds and displays a grupoSanguineo entity.
     *
     * @Route("/{id}/show", name="gruposanguineo_show")
     * @Method("GET")
     */
    public function showAction(GrupoSanguineo $grupoSanguineo)
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
                    'data'=> $grupoSanguineo,
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
     * Displays a form to edit an existing grupoSanguineo entity.
     *
     * @Route("/edit", name="gruposanguineo_edit")
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
            $grupoSanguineo = $em->getRepository("AppBundle:GrupoSanguineo")->find($params->id);

            $nombre = $params->nombre;
            $sigla = $params->sigla;

            if ($grupoSanguineo!=null) {
                $grupoSanguineo->setNombre($nombre);
                $grupoSanguineo->setSigla($sigla);

                $em = $this->getDoctrine()->getManager();
                $em->persist($grupoSanguineo);
                $em->flush();

                 $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Registro actualizado con exito", 
                        'data'=> $grupoSanguineo,
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
     * Deletes a grupoSanguineo entity.
     *
     * @Route("/{id}/delete", name="gruposanguineo_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, GrupoSanguineo $grupoSanguineo)
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
     * Creates a form to delete a grupoSanguineo entity.
     *
     * @param GrupoSanguineo $grupoSanguineo The grupoSanguineo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(GrupoSanguineo $grupoSanguineo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('gruposanguineo_delete', array('id' => $grupoSanguineo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="gruposanguineo_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $response = null;
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $gruposSanguineos = $em->getRepository('AppBundle:GrupoSanguineo')->findBy(
            array('estado' => 1)
        );
        foreach ($gruposSanguineos as $key => $grupoSanguineo) {
            $response[$key] = array(
                'value' => $grupoSanguineo->getId(),
                'label' => $grupoSanguineo->getSigla()."_".$grupoSanguineo->getNombre(),
            );
        }
        return $helpers->json($response);
    }
}
