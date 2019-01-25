<?php

namespace JHWEB\FinancieroBundle\Controller;

use JHWEB\FinancieroBundle\Entity\FroRecaudo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Frorecaudo controller.
 *
 * @Route("frorecaudo")
 */ 
class FroRecaudoController extends Controller
{
    /**
     * Lists all FroRecaudo entities.
     *
     * @Route("/", name="froRecaudo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $froRecaudo = $em->getRepository('JHWEBFinancieroBundle:FroRecaudo')->findBy(
            array('activo'=>true)
        );

        $response['data'] = array();

        if ($froRecaudo) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($froRecaudo)." Registros encontrados", 
                'data'=> $froRecaudo,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new froRecaudo_index entity.
     *
     * @Route("/new", name="froRecaudo_new")
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

            $fecha = new \DateTime($params->fecha);

            $froRecaudo = new FroRecaudo();

            // var_dump($params);
            // die();

            $froFactura = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->find($params->IdFroFactura);
            $sedeOperativa = $em->getRepository('AppBundle:SedeOperativa')->find($params->IdSedeOperativa);
           
            $froRecaudo->setFecha($fecha);
            $froRecaudo->setValor($params->valor);
            $froRecaudo->setValorMora($params->valorMora);
            $froRecaudo->setValorFinanciacion($params->valorFinanciacion);
            $froRecaudo->setValorCapital($params->valorCapital);
            $froRecaudo->setValorDescuento($params->valorDescuento);
            $froRecaudo->setFroFactura($froFactura);
            $froRecaudo->setSedeOperativa($sedeOperativa);
            $froRecaudo->setActivo(true);
            
            $em->persist($froRecaudo);
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
     * Finds and displays a froRecaudo_index entity.
     *
     * @Route("/show", name="froRecaudo_show")
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

            $froRecaudo = $em->getRepository('JHWEBFinancieroBundle:FroRecaudo')->find($params->idMedioCorrespondencia);

            if ($froRecaudo) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado", 
                    'data'=> $froRecaudo,
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
     * Displays a form to edit an existing froRecaudo_index entity.
     *
     * @Route("/edit", name="froRecaudo_edit")
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
            $froRecaudo = $em->getRepository("JHWEBFinancieroBundle:FroRecaudo")->find($params->id);

            if ($froRecaudo) {
                $fecha = new \DateTime($params->fecha);
                $froFactura = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->find($params->IdFroFactura);
                $sedeOperativa = $em->getRepository('AppBundle:SedeOperativa')->find($params->IdSedeOperativa);
               
                $froRecaudo->setFecha($fecha);
                $froRecaudo->setValor($params->valor);
                $froRecaudo->setValorMora($params->valorMora);
                $froRecaudo->setValorFinanciacion($params->valorFinanciacion);
                $froRecaudo->setValorCapital($params->valorCapital);
                $froRecaudo->setValorDescuento($params->valorDescuento);
                $froRecaudo->setFroFactura($froFactura);
                $froRecaudo->setSedeOperativa($sedeOperativa);
                $froRecaudo->setActivo(true);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $froRecaudo,
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
     * Deletes a froRecaudo_index entity.
     *
     * @Route("/delete", name="froRecaudo_delete")
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
     * Creates a form to delete a froRecaudo_index entity.
     *
     * @param FroRecaudo $froRecaudo_index The froRecaudo_index entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FroRecaudo $froRecaudo_index)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('froRecaudo_delete', array('id' => $froRecaudo_index->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="froRecaudo_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $froRecaudo = $em->getRepository('JHWEBFinancieroBundle:FroRecaudo')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($froRecaudo as $key => $froRecaudo) {
            $response[$key] = array(
                'value' => $froRecaudo->getId(),
                'label' => $froRecaudo->getNombre()
            );
        }
        
        return $helpers->json($response);
    }
}
