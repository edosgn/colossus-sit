<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Servicio;
use AppBundle\Form\ServicioType;

/**
 * Servicio controller.
 *
 * @Route("/servicio")
 */
class ServicioController extends Controller
{
    /**
     * Lists all Servicio entities.
     *
     * @Route("/", name="servicio_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $servicios = $em->getRepository('AppBundle:Servicio')->findBy(
            array('estado' => 1)
        );
        $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado servicios", 
                    'data'=> $servicios,
            );
         
        return $helpers->json($response);
    }

    /**
     * Creates a new Servicio entity.
     *
     * @Route("/new", name="servicio_new")
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

            $nombre = $params->nombre;
            $codigo = $params->codigo;

            $em = $this->getDoctrine()->getManager();
            $servicio = $em->getRepository('AppBundle:Servicio')->findBy(
                array('codigo' => $codigo)
            );

            if ($servicio==null) {
                $servicio = new Servicio();

                $servicio->setNombre(strtoupper($nombre));
                $servicio->setCodigo($codigo);
                $servicio->setEstado(true);
                $em = $this->getDoctrine()->getManager();
                $em->persist($servicio);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "servicio creado con exito", 
                ); 
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "codigo no puede ser repetido", 
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
     * Finds and displays a Servicio entity.
     *
     * @Route("/show/{id}", name="servicio_show")
     * @Method("POST")
     */
    public function showAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $servicio = $em->getRepository('AppBundle:Servicio')->find($id);
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "servicio con nombre"." ".$servicio->getNombre(), 
                    'data'=> $servicio,
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
     * Displays a form to edit an existing Servicio entity.
     *
     * @Route("/edit", name="servicio_edit")
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
            $codigo = $params->codigo;

            $em = $this->getDoctrine()->getManager();
            $servicio = $em->getRepository("AppBundle:Servicio")->find($params->id);

            if ($servicio!=null) {
                $servicio->setNombre(strtoupper($nombre));
                $servicio->setCodigo($codigo);
                $servicio->setEstado(true);
                $em = $this->getDoctrine()->getManager();
                $em->persist($servicio);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "servicio editado con exito", 
                ); 
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El servicio no se encuentra en la base de datos", 
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
     * Deletes a Servicio entity.
     *
     * @Route("/{id}/delete", name="servicio_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $servicio = $em->getRepository('AppBundle:Servicio')->find($id);

            $servicio->setEstado(0);
            $em = $this->getDoctrine()->getManager();
                $em->persist($servicio);
                $em->flush();
            $response = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "servicio eliminado con exito", 
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
     * Creates a form to delete a Servicio entity.
     *
     * @param Servicio $servicio The Servicio entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Servicio $servicio)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('servicio_delete', array('id' => $servicio->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


    /**
     * datos para select 2
     *
     * @Route("/select", name="servicio_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $servicios = $em->getRepository('AppBundle:Servicio')->findBy(
        array('estado' => 1)
    );
      foreach ($servicios as $key => $servicio) {
        $response[$key] = array(
            'value' => $servicio->getId(),
            'label' => $servicio->getCodigo()."_".$servicio->getNombre(),
            );
      }
       return $helpers->json($response);
    }
}
