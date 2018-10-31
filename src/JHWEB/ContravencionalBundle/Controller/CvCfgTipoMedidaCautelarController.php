<?php

namespace JHWEB\ContravencionalBundle\Controller;

use JHWEB\ContravencionalBundle\Entity\CvCfgTipoMedidaCautelar;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cvcfgtipomedidacautelar controller.
 *
 * @Route("cvcfgtipomedidacautelar")
 */
class CvCfgTipoMedidaCautelarController extends Controller
{

     /**
     * Lists all cvCfgTipoRestriccion entities.
     *
     * @Route("/", name="cvcfgtipomedidacautelar_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $cvCfgTipoMedidaCautelars = $em->getRepository('JHWEBContravencionalBundle:CvCfgTipoMedidaCautelar')->findBy(
            array('activo'=>true)
        );

        $response['data'] = array();

        if ($cvCfgTipoMedidaCautelars) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($cvCfgTipoMedidaCautelars)." Registros encontrados", 
                'data'=> $cvCfgTipoMedidaCautelars,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new cvcfgtipomedidacautelar_index entity.
     *
     * @Route("/new", name="cvcfgtipomedidacautelar_new")
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

            $cvCfgTipoMedidaCautelar = new Cvcfgtipomedidacautelar();
           
            $cvCfgTipoMedidaCautelar->setNombre($params->nombre);
            $cvCfgTipoMedidaCautelar->setCodigo($params->codigo);
            $cvCfgTipoMedidaCautelar->setActivo(true);
            
            $em->persist($cvCfgTipoMedidaCautelar);
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
     * Finds and displays a cvcfgtipomedidacautelar_index entity.
     *
     * @Route("/show", name="cvcfgtipomedidacautelar_show")
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

            $cvCfgTipoMedidaCautelar = $em->getRepository('JHWEBContravencionalBundle:CvCfgTipoMedidaCautelar')->find($params->idMedioCorrespondencia);

            if ($cvCfgTipoMedidaCautelar) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado", 
                    'data'=> $cvCfgTipoMedidaCautelar,
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
     * Displays a form to edit an existing cvcfgtipomedidacautelar_index entity.
     *
     * @Route("/edit", name="cvcfgtipomedidacautelar_edit")
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
            $cvCfgTipoMedidaCautelar = $em->getRepository("JHWEBContravencionalBundle:CvCfgTipoMedidaCautelar")->find($params->id);

            if ($cvCfgTipoMedidaCautelar) {
                $cvCfgTipoMedidaCautelar->setNombre($params->nombre);
                $cvCfgTipoMedidaCautelar->setCodigo($params->codigo);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $cvCfgTipoMedidaCautelar,
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
     * Deletes a cvcfgtipomedidacautelar_index entity.
     *
     * @Route("/delete", name="cvcfgtipomedidacautelar_delete")
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
            $cvCfgTipoMedidaCautelar = $em->getRepository('JJHWEBContravencionalBundle:CvCfgTipoMedidaCautelar')->find($params->id);
            $cvCfgTipoMedidaCautelar->setActivo(false);

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
     * Creates a form to delete a cvCfgTipoMedidaCautelar entity.
     *
     * @param CvCfgTipoMedidaCautelar $cvCfgTipoMedidaCautelar The cvCfgTipoMedidaCautelar entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CvCfgTipoMedidaCautelar $cvCfgTipoMedidaCautelar)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cvcfgtipomedidacautelar_delete', array('id' => $cvCfgTipoMedidaCautelar->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
