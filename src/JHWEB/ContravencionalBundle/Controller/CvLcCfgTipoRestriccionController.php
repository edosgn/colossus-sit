<?php

namespace JHWEB\ContravencionalBundle\Controller;

use JHWEB\ContravencionalBundle\Entity\CvLcCfgTipoRestriccion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cvcfgtiporestriccion controller.
 *
 * @Route("cvlccfgtiporestriccion")
 */
class CvLcCfgTipoRestriccionController extends Controller
{
    /**
     * Lists all cvCfgTipoRestriccion entities.
     *
     * @Route("/", name="cvlccfgtiporestriccion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $cvLcCfgTipoLcensias = $em->getRepository('JHWEBContravencionalBundle:CvLcCfgTipoRestriccion')->findBy(
            array('activo'=>true)
        );

        $response['data'] = array();

        if ($cvLcCfgTipoLcensias) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($cvLcCfgTipoLcensias)." Registros encontrados", 
                'data'=> $cvLcCfgTipoLcensias,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new cvlccfgtiporestriccion_index entity.
     *
     * @Route("/new", name="cvlccfgtiporestriccion_new")
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

            $tipoRestriccion = new CvLcCfgTipoRestriccion();
           
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
     * Finds and displays a cvlccfgtiporestriccion_index entity.
     *
     * @Route("/show", name="cvlccfgtiporestriccion_show")
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

            $tipoRestriccion = $em->getRepository('JHWEBContravencionalBundle:CvLcCfgTipoRestriccion')->find($params->idMedioCorrespondencia);

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
     * Displays a form to edit an existing cvlccfgtiporestriccion_index entity.
     *
     * @Route("/edit", name="cvlccfgtiporestriccion_edit")
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
            $tipoRestriccion = $em->getRepository("JHWEBContravencionalBundle:CvLcCfgTipoRestriccion")->find($params->id);

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
     * Deletes a cvlccfgtiporestriccion_index entity.
     *
     * @Route("/delete", name="cvlccfgtiporestriccion_delete")
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
     * Creates a form to delete a cvlccfgtiporestriccion_index entity.
     *
     * @param CvLcCfgTipoRestriccion $cvlccfgtiporestriccion_index The cvlccfgtiporestriccion_index entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CvLcCfgTipoRestriccion $cvlccfgtiporestriccion_index)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cvlccfgtiporestriccion_delete', array('id' => $cvlccfgtiporestriccion_index->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="cvlccfgtiporestriccion_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $cvLcCfgTipoLcensias = $em->getRepository('JHWEBContravencionalBundle:CvLcCfgTipoRestriccion')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($cvLcCfgTipoLcensias as $key => $tipoRestriccion) {
            $response[$key] = array(
                'value' => $tipoRestriccion->getId(),
                'label' => $tipoRestriccion->getNombre()
            );
        }
        
        return $helpers->json($response);
    }
}
