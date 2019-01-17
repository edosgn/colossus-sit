<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloCfgCda;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlocfgcda controller.
 *
 * @Route("vhlocfgcda")
 */
class VhloCfgCdaController extends Controller
{
    /**
     * Lists all vhloCfgCda entities.
     *
     * @Route("/", name="vhlocfgcda_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $cdas = $em->getRepository('JHWEBVehiculoBundle:VhloCfgCda')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($cdas) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($cdas)." registros encontrados", 
                'data'=> $cdas,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new vhloCfgCda entity.
     *
     * @Route("/new", name="vhlocfgcda_new")
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
           
            $cda = new VhloCfgCda();

            $cda->setNombre($params->nombre);
            $cda->setNit($params->nit);
            $cda->setActivo(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($cda);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con exito",
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Finds and displays a vhloCfgCda entity.
     *
     * @Route("/{id}/show", name="vhlocfgcda_show")
     * @Method("GET")
     */
    public function showAction(VhloCfgCda $vhloCfgCda)
    {
        $deleteForm = $this->createDeleteForm($vhloCfgCda);

        return $this->render('vhlocfgcda/show.html.twig', array(
            'vhloCfgCda' => $vhloCfgCda,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vhloCfgCda entity.
     *
     * @Route("/edit", name="vhlocfgcda_edit")
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

            $em = $this->getDoctrine()->getManager();
            $cda = $em->getRepository("JHWEBVehiculoBundle:VhloCfgCda")->find($params->id);

            if ($cda) {
                $cda->setNombre($params->nombre);
                $cda->setNit($params->nit);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $cda,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorizacion no valida para editar", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a vhloCfgCda entity.
     *
     * @Route("/delete", name="vhlocfgcda_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            $cda = $em->getRepository("JHWEBVehiculoBundle:VhloCfgCda")->find($params->id);

            if ($cda) {
                $cda->setActivo(false);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro eliminado con exito", 
                    'data'=> $cda,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorizacion no valida para editar", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a vhloCfgCda entity.
     *
     * @param VhloCfgCda $vhloCfgCda The vhloCfgCda entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloCfgCda $vhloCfgCda)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhlocfgcda_delete', array('id' => $vhloCfgCda->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="vhlocfgcda_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $cdas = $em->getRepository('JHWEBVehiculoBundle:VhloCfgCda')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($cdas as $key => $cda) {
            $response[$key] = array(
                'value' => $cda->getId(),
                'label' => $cda->getNombre()
            );
        }
        return $helpers->json($response);
    }
}
