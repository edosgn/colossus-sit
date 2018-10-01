<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\CfgCda;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cfgcda controller.
 *
 * @Route("cfgcda")
 */
class CfgCdaController extends Controller
{
    /**
     * Lists all cfgCda entities.
     *
     * @Route("/", name="cfgcda_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $cdas = $em->getRepository('JHWEBVehiculoBundle:CfgCda')->findBy(
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
     * Creates a new cfgCda entity.
     *
     * @Route("/new", name="cfgcda_new")
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
           
            $cda = new CfgCda();

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
     * Finds and displays a cfgCda entity.
     *
     * @Route("/{id}/show", name="cfgcda_show")
     * @Method("GET")
     */
    public function showAction(CfgCda $cfgCda)
    {
        $deleteForm = $this->createDeleteForm($cfgCda);

        return $this->render('cfgcda/show.html.twig', array(
            'cfgCda' => $cfgCda,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cfgCda entity.
     *
     * @Route("/edit", name="cfgcda_edit")
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
            $cda = $em->getRepository("JHWEBVehiculoBundle:CfgCda")->find($params->id);

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
     * Deletes a cfgCda entity.
     *
     * @Route("/delete", name="cfgcda_delete")
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
            $cda = $em->getRepository("JHWEBVehiculoBundle:CfgCda")->find($params->id);

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
     * Creates a form to delete a cfgCda entity.
     *
     * @param CfgCda $cfgCda The cfgCda entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgCda $cfgCda)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgcda_delete', array('id' => $cfgCda->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="cfgcda_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $cdas = $em->getRepository('JHWEBVehiculoBundle:CfgCda')->findBy(
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
