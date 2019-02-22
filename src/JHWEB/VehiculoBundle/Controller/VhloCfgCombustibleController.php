<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloCfgCombustible;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlocfgcombustible controller.
 *
 * @Route("vhlocfgcombustible")
 */
class VhloCfgCombustibleController extends Controller
{
    /**
     * Lists all vhloCfgCombustible entities.
     *
     * @Route("/", name="vhlocfgcombustible_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $vhloCfgCombustibles = $em->getRepository('JHWEBVehiculoBundle:VhloCfgCombustible')->findBy(
            array('estado' => 1)
        );   

        $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "listado combustibles", 
                    'data'=> $vhloCfgCombustibles,
            );
         
        return $helpers->json($response);
    }

    /**
     * Creates a new vhloCfgCombustible entity.
     *
     * @Route("/new", name="vhlocfgcombustible_new")
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
            $codigoMt = $params->codigoMt;

            $em = $this->getDoctrine()->getManager();
            $combustible = $em->getRepository('JHWEBVehiculoBundle:VhloCfgConbustible')->findBy(
                array('codigoMt' => $codigoMt)
            );

            if ($combustible == null) {
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
                    'message' => "Combustible creado con éxito",
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Codigo de ministerio de transporte debe ser único",
                );
            }                
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida", 
            );
            } 
        return $helpers->json($response);
    }

    /**
     * Finds and displays a vhloCfgCombustible entity.
     *
     * @Route("/show/{id}", name="vhlocfgcombustible_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $combustible = $em->getRepository('JHWEBVehiculoBundle:VhloCfgCombustible')->find($id);
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
                    'msj' => "Autorización no válida", 
                );
        }
        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing Combustible entity.
     *
     * @Route("/edit", name="vhlocfgcombustible_edit")
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
            $combustible = $em->getRepository('JHWEBVehiculoBundle:VhloCfgCombustible')->find($params->id);
            if ($combustible!=null) {

                $combustible->setNombre($nombre);
                $combustible->setEstado(true);
                $combustible->setCodigoMt($codigoMt);

                
                $em->persist($combustible);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "combustible editado con éxito", 
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El combustible no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorización no válida.", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a Combustible entity.
     *
     * @Route("/{id}/delete", name="vhlocfgcombustible_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $combustible = $em->getRepository('JHWEBVehiculoBundle:VhloCfgCombustible')->find($id);

            $combustible->setEstado(0);

            $em->persist($combustible);
            $em->flush();
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Combustible eliminado con éxito", 
                );
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorización no válida", 
                );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a VhloCfgCombustible entity.
     *
     * @param VhloCfgCombustible $combustible The VhloCfgCombustible entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloCfgCombustible $vhloCfgcombustible)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhlocfgcombustible_delete', array('id' => $vhloCfgCombustible->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

     /**
     * datos para select 2
     *
     * @Route("/select", name="vhlocfgcombustible_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $combustibles = $em->getRepository('JHWEBVehiculoBundle:VhloCfgCombustible')->findBy(
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
