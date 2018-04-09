<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Combustible;
use AppBundle\Form\CombustibleType;

/**
 * Combustible controller. 
 *
 * @Route("/combustible")
 */
class CombustibleController extends Controller
{
    /**
     * Lists all Combustible entities.
     *
     * @Route("/", name="combustible_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $combustibles = $em->getRepository('AppBundle:Combustible')->findBy(
            array('estado' => 1)
        );
        $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado combustibles", 
                    'data'=> $combustibles,
            );
         
        return $helpers->json($response);
    }

    /**
     * Creates a new Combustible entity.
     *
     * @Route("/new", name="combustible_new")
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
                $codigoMt = $params->codigoMt;
                $em = $this->getDoctrine()->getManager();
                $combustible = $em->getRepository('AppBundle:Combustible')->findBy(
                    array('codigoMt' => $codigoMt)
                );

                if ($combustible==null) {
                    $combustible = new Combustible();
                    $combustible->setNombre($nombre);
                    $combustible->setEstado(true);
                    $combustible->setCodigoMt($codigoMt);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($combustible);
                    $em->flush();
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Combustible creada con exito", 
                    );
                }else{
                     $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'msj' => "Codigo de ministerio de transporte debe ser unico",
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
     * Finds and displays a Combustible entity.
     *
     * @Route("/show/{id}", name="combustible_show")
     * @Method("POST")
     */
    public function showAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $combustible = $em->getRepository('AppBundle:Combustible')->find($id);
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "combustible encontrado", 
                    'data'=> $combustible,
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
     * Displays a form to edit an existing Combustible entity.
     *
     * @Route("/edit", name="combustible_edit")
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
            $codigoMt = $params->codigoMt;
            $em = $this->getDoctrine()->getManager();
            $combustible = $em->getRepository('AppBundle:Combustible')->find($params->id);
            if ($combustible!=null) {

                $combustible->setNombre($nombre);
                $combustible->setEstado(true);
                $combustible->setCodigoMt($codigoMt);

                $em = $this->getDoctrine()->getManager();
                $em->persist($combustible);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "combustible editada con exito", 
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "La combustible no se encuentra en la base de datos", 
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
     * Deletes a Combustible entity.
     *
     * @Route("/{id}/delete", name="combustible_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $combustible = $em->getRepository('AppBundle:Combustible')->find($id);

            $combustible->setEstado(0);
            $em = $this->getDoctrine()->getManager();
                $em->persist($combustible);
                $em->flush();
            $response = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "Combustible eliminado con exito", 
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
     * Creates a form to delete a Combustible entity.
     *
     * @param Combustible $combustible The Combustible entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Combustible $combustible)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('combustible_delete', array('id' => $combustible->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

     /**
     * datos para select 2
     *
     * @Route("/select", name="combustible_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $combustibles = $em->getRepository('AppBundle:Combustible')->findBy(
        array('estado' => 1)
    );
      foreach ($combustibles as $key => $combustible) {
        $response[$key] = array(
            'value' => $combustible->getId(),
            'label' => $combustible->getNombre(),
            );
      }
       return $helpers->json($response);
    }
}
