<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Caso;
use AppBundle\Form\CasoType;

/**
 * Caso controller.
 *
 * @Route("/caso")
 */
class CasoController extends Controller
{
    /**
     * Lists all Caso entities.
     *
     * @Route("/", name="caso_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $casos = $em->getRepository('AppBundle:Caso')->findBy(
            array('estado' => 1)
        );
        $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado casos", 
                    'data'=> $casos,
            );
         
        return $helpers->json($response);
    }

    /**
     * Creates a new Caso entity.
     *
     * @Route("/new", name="caso_new")
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
                    'msj' => "los campos no pueden estar vacios", 
                );
            }else{*/
                $nombre = $params->nombre;
                $tramiteId = $params->tramiteId;
                $em = $this->getDoctrine()->getManager();
                $tramite = $em->getRepository('AppBundle:Tramite')->find($tramiteId);

                if ($tramite==null) {
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'msj' => "no existe el tramite", 
                    );
                }else{
                    $caso = new Caso();

                    $caso->setNombre($nombre);
                    $caso->setEstado(true);
                    $caso->setTramite($tramite);

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($caso);
                    $em->flush();

                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Caso creado con exito", 
                    );
                }
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
     * Finds and displays a Caso entity.
     *
     * @Route("/show/{id}", name="caso_show")
     * @Method("POST")
     */
    public function showAction(Request  $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $caso = $em->getRepository('AppBundle:Caso')->find($id);
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "caso encontrado", 
                    'data'=> $caso,
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
     * Displays a form to edit an existing Caso entity.
     *
     * @Route("/edit", name="caso_edit")
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
            $tramiteId = $params->tramiteId;
            $em = $this->getDoctrine()->getManager();
            $tramite = $em->getRepository('AppBundle:Tramite')->find($tramiteId);
            $caso = $em->getRepository("AppBundle:Caso")->find($params->id);

            if ($caso!=null) {
                $caso->setNombre($nombre);
                $caso->setEstado(true);
                $caso->setTramite($tramite);

                $em = $this->getDoctrine()->getManager();
                $em->persist($caso);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Caso editado con exito", 
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El caso no se encuentra en la base de datos", 
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
     * Deletes a Caso entity.
     *
     * @Route("/{id}/delete", name="caso_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $caso = $em->getRepository('AppBundle:Caso')->find($id);

            $caso->setEstado(0);
            $em = $this->getDoctrine()->getManager();
                $em->persist($caso);
                $em->flush();
            $response = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "caso eliminado con exito", 
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
     * Creates a form to delete a Caso entity.
     *
     * @param Caso $caso The Caso entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Caso $caso)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('caso_delete', array('id' => $caso->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * busca los casos de un tramite.
     *
     * @Route("/showCasos/{id}", name="caso_tramites_show")
     * @Method("POST")
     */
    public function showCasosAction(Request  $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $casos = $em->getRepository('AppBundle:Caso')->findBy(
            array('estado' => 1,'tramite'=> $id)
            );

            if ($casos==null) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "No hay casos asigandos a este tramite", 
                );
            }
            else{
               $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "casos encontrado", 
                    'data'=> $casos,
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
}
