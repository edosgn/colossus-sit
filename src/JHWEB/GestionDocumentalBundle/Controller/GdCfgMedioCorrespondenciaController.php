<?php

namespace JHWEB\GestionDocumentalBundle\Controller;

use JHWEB\GestionDocumentalBundle\Entity\GdCfgMedioCorrespondencia;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Gdcfgmediocorrespondencium controller.
 *
 * @Route("gdcfgmediocorrespondencia")
 */
class GdCfgMedioCorrespondenciaController extends Controller
{
    /**
     * Lists all gdCfgMedioCorrespondencium entities.
     *
     * @Route("/", name="gdcfgmediocorrespondencia_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $mediosCorrespondencia = $em->getRepository('JHWEBGestionDocumentalBundle:GdCfgMedioCorrespondencia')->findBy(
            array('activo'=>true)
        );

        $response['data'] = array();

        if ($mediosCorrespondencia) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($mediosCorrespondencia)." Registros encontrados", 
                'data'=> $mediosCorrespondencia,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new gdCfgMedioCorrespondencium entity.
     *
     * @Route("/new", name="gdcfgmediocorrespondencia_new")
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

            $medioCorrespondencia = new GdCfgMedioCorrespondencia();

            $medioCorrespondencia->setNombre(strtoupper($params->nombre));
            $medioCorrespondencia->setGestionable($params->gestionable);
            $medioCorrespondencia->setActivo(true);
            
            $em->persist($medioCorrespondencia);
            $em->flush();
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con éxito",
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
     * Finds and displays a gdCfgMedioCorrespondencium entity.
     *
     * @Route("/show", name="gdcfgmediocorrespondencia_show")
     * @Method("GET")
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

            $medioCorrespondencia = $em->getRepository('JHWEBGestionDocumentalBundle:GdCfgMedioCorrespondencia')->find($params->idMedioCorrespondencia);

            if ($medioCorrespondencia) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado", 
                    'data'=> $medioCorrespondencia,
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
     * Displays a form to edit an existing gdCfgMedioCorrespondencium entity.
     *
     * @Route("/edit", name="gdcfgmediocorrespondencia_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request){
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            $medioCorrespondencia = $em->getRepository("JHWEBGestionDocumentalBundle:GdCfgMedioCorrespondencia")->find($params->id);

            if ($medioCorrespondencia) {
                $medioCorrespondencia->setNombre(strtoupper($params->nombre));
                $medioCorrespondencia->setGestionable($params->gestionable);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $medioCorrespondencia,
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
     * Deletes a gdCfgMedioCorrespondencium entity.
     *
     * @Route("/delete", name="gdcfgmediocorrespondencia_delete")
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
     * Creates a form to delete a gdCfgMedioCorrespondencium entity.
     *
     * @param GdCfgMedioCorrespondencia $gdCfgMedioCorrespondencium The gdCfgMedioCorrespondencium entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(GdCfgMedioCorrespondencia $gdCfgMedioCorrespondencium)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('gdcfgmediocorrespondencia_delete', array('id' => $gdCfgMedioCorrespondencium->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* =============================================== */

    /**
     * datos para select 2
     *
     * @Route("/select", name="gdcfgmediocorrespondencia_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $mediosCorrespondencia = $em->getRepository('JHWEBGestionDocumentalBundle:GdCfgMedioCorrespondencia')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($mediosCorrespondencia as $key => $medioCorrespondencia) {
            $response[$key] = array(
                'value' => $medioCorrespondencia->getId(),
                'label' => $medioCorrespondencia->getNombre()
            );
        }
        
        return $helpers->json($response);
    }
}
