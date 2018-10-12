<?php

namespace JHWEB\GestionDocumentalBundle\Controller;

use JHWEB\GestionDocumentalBundle\Entity\GdCfgTipoCorrespondencia;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Gdcfgtipocorrespondencium controller.
 *
 * @Route("gdcfgtipocorrespondencia")
 */
class GdCfgTipoCorrespondenciaController extends Controller
{
    /**
     * Lists all gdCfgTipoCorrespondencia entities.
     *
     * @Route("/", name="gdcfgtipocorrespondencia_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $tiposCorrespondencia = $em->getRepository('JHWEBGestionDocumentalBundle:GdCfgTipoCorrespondencia')->findBy(
            array('activo'=>true)
        );

        $response['data'] = array();

        if ($tiposCorrespondencia) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($tiposCorrespondencia)." Registros encontrados", 
                'data'=> $tiposCorrespondencia,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new gdCfgTipoCorrespondencia entity.
     *
     * @Route("/new", name="gdcfgtipocorrespondencia_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization",null);
        $authCheck = $helpers->authCheck($hash);

        if($authCheck == true){
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $tipoCorrespondencia = new GdCfgTipoCorrespondencia();

            $tipoCorrespondencia->setNombre($params->nombre);
            $tipoCorrespondencia->setActivo(true);
            
            $em->persist($tipoCorrespondencia);
            $em->flush();
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con éxito",
                'data' => $tipoCorrespondencia
            );
        
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no valida",
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Finds and displays a gdCfgTipoCorrespondencia entity.
     *
     * @Route("/show", name="gdcfgtipocorrespondencia_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $tipoCorrespondencia = $em->getRepository('JHWEBGestionDocumentalBundle:GdCfgTipoCorrespondencia')->find($params->idTipoCorrespondencia);

            if ($tipoCorrespondencia) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado", 
                    'data'=> $tipoCorrespondencia,
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
                    'message' => "Autorizacion no valida", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing cfgCargo entity.
     *
     * @Route("/edit", name="gdcfgtipocorrespondencia_edit")
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
            $tipoCorrespondencia = $em->getRepository("JHWEBGestionDocumentalBundle:GdCfgTipoCorrespondencia")->find($params->id);

            if ($tipoCorrespondencia) {
                $tipoCorrespondencia->setNombre($params->nombre);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $tipoCorrespondencia,
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
     * Deletes a cfgCargo entity.
     *
     * @Route("/delete", name="gdcfgtipocorrespondencia_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if($authCheck == true){
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            $tipoCorrespondencia = $em->getRepository('JHWEBGestionDocumentalBundle:GdCfgTipoCorrespondencia')->find($params->id);
            
            $tipoCorrespondencia->setActivo(false);
            $em->flush();

            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro eliminado con éxito", 
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no valida", 
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a gdCfgTipoCorrespondencia entity.
     *
     * @param GdCfgTipoCorrespondencia $gdCfgTipoCorrespondencia The gdCfgTipoCorrespondencia entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(GdCfgTipoCorrespondencia $gdCfgTipoCorrespondencia)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('gdcfgtipocorrespondencia_delete', array('id' => $gdCfgTipoCorrespondencia->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="gdcfgtipocorrespondencia_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $tiposCorrespondencia = $em->getRepository('JHWEBGestionDocumentalBundle:GdCfgTipoCorrespondencia')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($tiposCorrespondencia as $key => $tipoCorrespondencia) {
            $response[$key] = array(
                'value' => $tipoCorrespondencia->getId(),
                'label' => $tipoCorrespondencia->getNombre()
            );
        }
        return $helpers->json($response);
    }
}
