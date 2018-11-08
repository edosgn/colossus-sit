<?php

namespace JHWEB\ContravencionalBundle\Controller;

use JHWEB\ContravencionalBundle\Entity\CvLcCfgMotivo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cvlccfgmotivo controller.
 *
 * @Route("cvlccfgmotivo")
 */
class CvLcCfgMotivoController extends Controller
{
    /**
     * Lists all cvLcCfgMotivo entities.
     *
     * @Route("/", name="cvlccfgmotivo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $motivos = $em->getRepository('JHWEBContravencionalBundle:CvLcCfgMotivo')->findBy(
            array(
                'activo' => true
            )
        );

        $response['data'] = array();

        if ($motivos) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($motivos)." registros encontrados", 
                'data'=> $motivos,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new cvLcCfgMotivo entity.
     *
     * @Route("/new", name="cvlccfgmotivo_new")
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
           
            $motivo = new CvLcCfgMotivo();

            $motivo->setDescripcion($params->descripcion);
            $motivo->setTipo($params->tipo);
            $motivo->setActivo(true);

            $em = $this->getDoctrine()->getManager();
            
            $em->persist($motivo);
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
     * Finds and displays a cvLcCfgMotivo entity.
     *
     * @Route("/show", name="cvlccfgmotivo_show")
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

            $motivo = $em->getRepository('JHWEBContravencionalBundle:CvLcCfgMotivo')->find($params->id);

            if ($motivo) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado", 
                    'data'=> $motivo,
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
     * Displays a form to edit an existing cvLcCfgMotivo entity.
     *
     * @Route("/edit", name="cvlccfgmotivo_edit")
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
            $motivo = $em->getRepository("JHWEBContravencionalBundle:CvLcCfgMotivo")->find($params->id);

            if ($motivo) {
                $motivo->setDescripcion($params->descripcion);
                $motivo->setTipo($params->tipo);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $motivo,
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
     * Deletes a cvLcCfgMotivo entity.
     *
     * @Route("/delete", name="cvlccfgmotivo_delete")
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
            $motivo = $em->getRepository('JHWEBContravencionalBundle:CvLcCfgMotivo')->find($params->id);
            $motivo->setActivo(false);

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
     * Creates a form to delete a cvLcCfgMotivo entity.
     *
     * @param CvLcCfgMotivo $cvLcCfgMotivo The cvLcCfgMotivo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CvLcCfgMotivo $cvLcCfgMotivo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cvlccfgmotivo_delete', array('id' => $cvLcCfgMotivo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ============================================== */

    /**
     * datos para select 2
     *
     * @Route("/select", name="cvlccfgmotivo_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $json = $request->get("data",null);
        $params = json_decode($json);
        
        $motivos = $em->getRepository('JHWEBContravencionalBundle:CvLcCfgMotivo')->findBy(
            array(
                'tipo' => $params->tipo,
                'activo' => true
            )
        );

        $response = null;

        foreach ($motivos as $key => $motivo) {
            $response[$key] = array(
                'value' => $motivo->getId(),
                'label' => $motivo->getDescripcion()
            );
        }
        
        return $helpers->json($response);
    }
}
