<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\OrganismoTransito;
use AppBundle\Form\OrganismoTransitoType;

/**
 * OrganismoTransito controller.
 *
 * @Route("/organismotransito")
 */
class OrganismoTransitoController extends Controller
{
    /**
     * Lists all OrganismoTransito entities.
     *
     * @Route("/", name="organismotransito_index")
     * @Method("GET")
     */ 
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $organismoTransito = $em->getRepository('AppBundle:OrganismoTransito')->findBy(
            array('estado' => 1)
        );
        $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado organismoTransito", 
                    'data'=> $organismoTransito,
            );
         
        return $helpers->json($responce);
    }

    /**
     * Creates a new OrganismoTransito entity.
     *
     * @Route("/new", name="organismotransito_new")
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
                        $organismoTransito = new OrganismoTransito();

                        $organismoTransito->setNombre($nombre);
                        $organismoTransito->setEstado(true);

                        $em = $this->getDoctrine()->getManager();
                        $em->persist($organismoTransito);
                        $em->flush();

                        $responce = array(
                            'status' => 'success',
                            'code' => 200,
                            'msj' => "organismoTransito creado con exito", 
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
     * Finds and displays a OrganismoTransito entity.
     *
     * @Route("/show/{id}", name="organismotransito_show")
     * @Method("POST")
     */
    public function showAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $organismoTransito = $em->getRepository('AppBundle:OrganismoTransito')->find($id);
            $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "organismoTransito con nombre"." ".$organismoTransito->getNombre(), 
                    'data'=> $organismoTransito,
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
     * Displays a form to edit an existing OrganismoTransito entity.
     *
     * @Route("/edit", name="organismotransito_edit")
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

           
            $nombre = $params->nombre;

            $em = $this->getDoctrine()->getManager();
            $organismoTransito = $em->getRepository("AppBundle:OrganismoTransito")->find($params->id);

            if ($organismoTransito!=null) {
                $organismoTransito->setNombre($nombre);
                $em = $this->getDoctrine()->getManager();
                $em->persist($organismoTransito);
                $em->flush();

                 $responce = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "organismoTransito actualizado con exito", 
                        'data'=> $organismoTransito,
                );
            }else{
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El organismoTransito no se encuentra en la base de datos", 
                );
            }
        }else{
            $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar organismoTransito", 
                );
        }

        return $helpers->json($responce);
    }

    /**
     * Deletes a OrganismoTransito entity.
     *
     * @Route("/{id}/delete", name="organismotransito_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $organismoTransito = $em->getRepository('AppBundle:OrganismoTransito')->find($id);

            $organismoTransito->setEstado(0);
            $em = $this->getDoctrine()->getManager();
                $em->persist($organismoTransito);
                $em->flush();
            $responce = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "organismoTransito eliminado con exito", 
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
     * Creates a form to delete a OrganismoTransito entity.
     *
     * @param OrganismoTransito $organismoTransito The OrganismoTransito entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(OrganismoTransito $organismoTransito)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('organismotransito_delete', array('id' => $organismoTransito->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="organismoTransito_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $organismoTransitos = $em->getRepository('AppBundle:OrganismoTransito')->findBy(
        array('estado' => 1)
    );
      foreach ($organismoTransitos as $key => $organismoTransito) {
        $responce[$key] = array(
            'value' => $organismoTransito->getId(),
            'label' => $organismoTransito->getNombre(),
            );
      }
       return $helpers->json($responce);
    }
}
