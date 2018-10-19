<?php

namespace JHWEB\ContravencionalBundle\Controller;

use JHWEB\ContravencionalBundle\Entity\CvCfgTipoRestriccion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cvcfgtiporestriccion controller.
 *
 * @Route("cvcfgtiporestriccion")
 */
class CvCfgTipoRestriccionController extends Controller
{
    /**
     * Lists all cvCfgTipoRestriccion entities.
     *
     * @Route("/", name="cvcfgtiporestriccion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $mediosCorrespondencia = $em->getRepository('JHWEBContravencionalBundle:CvCfgTipoRestriccion')->findBy(
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
     * Creates a new cvcfgtiporestriccion_index entity.
     *
     * @Route("/new", name="cvcfgtiporestriccion_new")
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

            $tipoRestriccion = new CvCfgTipoRestriccion();
           
            $tipoRestriccion->setNombre($params->nombre);
            $tipoRestriccion->setCodigo($params->codigo);
            $tipoRestriccion->setActivo(true);
            
            $em->persist($tipoRestriccion);
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
     * Finds and displays a cvcfgtiporestriccion_index entity.
     *
     * @Route("/show", name="cvcfgtiporestriccion_show")
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

            $tipoRestriccion = $em->getRepository('JHWEBContravencionalBundle:CvCfgTipoRestriccion')->find($params->idMedioCorrespondencia);

            if ($tipoRestriccion) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado", 
                    'data'=> $tipoRestriccion,
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
     * Displays a form to edit an existing cvcfgtiporestriccion_index entity.
     *
     * @Route("/edit", name="cvcfgtiporestriccion_edit")
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
            $tipoRestriccion = $em->getRepository("JHWEBContravencionalBundle:CvCfgTipoRestriccion")->find($params->id);

            if ($tipoRestriccion) {
                $tipoRestriccion->setNombre($params->nombre);
                $tipoRestriccion->setCodigo($params->codigo);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $tipoRestriccion,
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
     * Deletes a cvcfgtiporestriccion_index entity.
     *
     * @Route("/delete", name="cvcfgtiporestriccion_delete")
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
     * Creates a form to delete a cvcfgtiporestriccion_index entity.
     *
     * @param CvCfgTipoRestriccion $cvcfgtiporestriccion_index The cvcfgtiporestriccion_index entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CvCfgTipoRestriccion $cvcfgtiporestriccion_index)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cvcfgtiporestriccion_delete', array('id' => $cvcfgtiporestriccion_index->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="cvcfgtiporestriccion_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $mediosCorrespondencia = $em->getRepository('JHWEBContravencionalBundle:CvCfgTipoRestriccion')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($mediosCorrespondencia as $key => $tipoRestriccion) {
            $response[$key] = array(
                'value' => $tipoRestriccion->getId(),
                'label' => $tipoRestriccion->getNombre()
            );
        }
        
        return $helpers->json($response);
    }
}
