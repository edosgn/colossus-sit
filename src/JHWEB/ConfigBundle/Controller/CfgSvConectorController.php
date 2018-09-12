<?php

namespace JHWEB\ConfigBundle\Controller;

use JHWEB\ConfigBundle\Entity\CfgSvConector;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cfgsvconector controller.
 *
 * @Route("cfgsvconector")
 */
class CfgSvConectorController extends Controller
{
    /**
     * Lists all cfgSvConector entities.
     *
     * @Route("/", name="cfgsvconector_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $conectores = $em->getRepository('JHWEBConfigBundle:CfgSvConector')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($conectores) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($conectores)." registros encontrados", 
                'data'=> $conectores,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new cfgSvConector entity.
     *
     * @Route("/new", name="cfgsvconector_new")
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
           
            $conector = new CfgSvConector();

            $conector->setNombre($params->nombre);
            $conector->setActivo(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($conector);
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
     * Finds and displays a cfgSvConector entity.
     *
     * @Route("/{id}/show", name="cfgsvconector_show")
     * @Method("GET")
     */
    public function showAction(CfgSvConector $cfgSvConector)
    {
        $deleteForm = $this->createDeleteForm($cfgSvConector);

        return $this->render('cfgsvconector/show.html.twig', array(
            'cfgSvConector' => $cfgSvConector,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cfgSvConector entity.
     *
     * @Route("/edit", name="cfgsvconector_edit")
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
            $conector = $em->getRepository("JHWEBConfigBundle:CfgSvConector")->find(
                $params->id
            );

            if ($conector) {
                $conector->setNombre($params->nombre);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $conector,
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
     * Deletes a cfgSvConector entity.
     *
     * @Route("/delete", name="cfgsvconector_delete")
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
            $conector = $em->getRepository("JHWEBConfigBundle:CfgSvConector")->find(
                $params->id
            );

            if ($conector) {
                $conector->setActivo(false);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro eliminado con exito", 
                    'data'=> $conector,
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
     * Creates a form to delete a cfgSvConector entity.
     *
     * @param CfgSvConector $cfgSvConector The cfgSvConector entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgSvConector $cfgSvConector)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgsvconector_delete', array('id' => $cfgSvConector->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="cfgsvconector_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $conectores = $em->getRepository('JHWEBConfigBundle:CfgSvConector')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($conectores as $key => $conector) {
            $response[$key] = array(
                'value' => $conector->getId(),
                'label' => $conector->getNombre()
            );
        }
        return $helpers->json($response);
    }
}
