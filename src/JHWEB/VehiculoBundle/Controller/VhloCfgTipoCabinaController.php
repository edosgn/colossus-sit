<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloCfgTipoCabina;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlocfgtipocabina controller.
 *
 * @Route("vhlocfgtipocabina")
 */
class VhloCfgTipoCabinaController extends Controller
{
    /**
     * Lists all vhloCfgTipoCabina entities.
     *
     * @Route("/", name="vhlocfgtipocabina_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $tiposCabina = $em->getRepository('JHWEBVehiculoBundle:VhloCfgTipoCabina')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($tiposCabina) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($tiposCabina)." registros encontrados", 
                'data'=> $tiposCabina,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new vhloCfgTipoCabina entity.
     *
     * @Route("/new", name="vhlocfgtipocabina_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);
           
            $tipoCabina = new VhloCfgTipoCabina();

            $tipoCabina->setNombre($params->nombre);
            $tipoCabina->setActivo(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($tipoCabina);
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
     * Finds and displays a vhloCfgTipoCabina entity.
     *
     * @Route("/{id}/show", name="vhlocfgtipocabina_show")
     * @Method("GET")
     */
    public function showAction(VhloCfgTipoCabina $vhloCfgTipoCabina)
    {
        $deleteForm = $this->createDeleteForm($vhloCfgTipoCabina);

        return $this->render('vhlocfgtipocabina/show.html.twig', array(
            'vhloCfgTipoCabina' => $vhloCfgTipoCabina,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vhloCfgTipoCabina entity.
     *
     * @Route("/edit", name="vhlocfgtipocabina_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            $tipoCabina = $em->getRepository("JHWEBVehiculoBundle:VhloCfgTipoCabina")->find($params->id);

            if ($tipoCabina) {
                $tipoCabina->setNombre($params->nombre);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $tipoCabina,
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
     * Deletes a vhloCfgTipoCabina entity.
     *
     * @Route("/delete", name="vhlocfgtipocabina_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            $tipoCabina = $em->getRepository("JHWEBVehiculoBundle:VhloCfgTipoCabina")->find($params->id);

            if ($tipoCabina) {
                $tipoCabina->setActivo(false);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro eliminado con exito", 
                    'data'=> $tipoCabina,
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
     * Creates a form to delete a vhloCfgTipoCabina entity.
     *
     * @param VhloCfgTipoCabina $vhloCfgTipoCabina The vhloCfgTipoCabina entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloCfgTipoCabina $vhloCfgTipoCabina)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhlocfgtipocabina_delete', array('id' => $vhloCfgTipoCabina->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="vhlocfgtipocabina_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $tiposCabina = $em->getRepository('JHWEBVehiculoBundle:VhloCfgTipoCabina')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($tiposCabina as $key => $tipoCabina) {
            $response[$key] = array(
                'value' => $tipoCabina->getId(),
                'label' => $tipoCabina->getNombre()
            );
        }
        
        return $helpers->json($response);
    }
}
