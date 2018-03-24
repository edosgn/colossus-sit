<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Pago;
use AppBundle\Form\PagoType;

/**
 * Pago controller.
 *
 * @Route("/pago")
 */
class PagoController extends Controller
{
    /**
     * Lists all Pago entities.
     *
     * @Route("/", name="pago_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $pagos = $em->getRepository('AppBundle:Pago')->findBy(
            array('estado' => 1)
        );
        $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado pagos", 
                    'data'=> $pagos,
            );
         
        return $helpers->json($responce);
    }

    /**
     * Creates a new Pago entity.
     *
     * @Route("/new", name="pago_new")
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
            if (count($params)==0) {
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "los campos no pueden estar vacios", 
                );
            }else{
                        $valor = $params->valor;
                        $fechaPago = $params->fechaPago;
                        $horaPago = $params->horaPago;
                        $fuente = $params->fuente;
                        $tramiteId = $params->tramiteId;
                        $em = $this->getDoctrine()->getManager();
                        $tramite = $em->getRepository('AppBundle:Tramite')->find($tramiteId);

                        $pago = new Pago();

                        $pago->setValor($valor);
                        $pago->setFechaPago($fechaPago);
                        $pago->setHoraPago($horaPago);
                        $pago->setFuente($fuente);
                        $pago->setTramite($tramite);

                        $pago->setEstado(true);
                        $em = $this->getDoctrine()->getManager();
                        $em->persist($pago);
                        $em->flush();

                        $responce = array(
                            'status' => 'success',
                            'code' => 200,
                            'msj' => "pago creado con exito", 
                        );
                       
                    }
        }else{
            $responce = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida", 
            );
            } 
        return $helpers->json($responce);
    }

    /**
     * Finds and displays a Pago entity.
     *
     * @Route("/show/{id}", name="pago_show")
     * @Method("POST")
     */
    public function showAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $pago = $em->getRepository('AppBundle:Pago')->find($id);
           
            $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "pago", 
                    'data'=> $pago,
            );
        }else{
            $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($responce);
    }

    /**
     * Displays a form to edit an existing Pago entity.
     *
     * @Route("/edit", name="pago_edit")
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

           
            $valor = $params->valor;
            $fechaPago = $params->fechaPago;
            $horaPago = $params->horaPago;
            $fuente = $params->fuente;
            $tramiteId = $params->tramiteId;
            $em = $this->getDoctrine()->getManager();
            $tramite = $em->getRepository('AppBundle:Tramite')->find($tramiteId);
            $pago = $em->getRepository("AppBundle:Pago")->find($params->id);

            if ($pago!=null) {
                $pago->setValor($valor);
                $pago->setFechaPago($fechaPago);
                $pago->setHoraPago($horaPago);
                $pago->setFuente($fuente);
                $pago->setTramite($tramite);

                $pago->setEstado(true);
                $em = $this->getDoctrine()->getManager();
                $em->persist($pago);
                $em->flush();

                $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "pago editado con exito", 
                );
            }else{
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El pago no se encuentra en la base de datos", 
                );
            }
        }else{
            $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar banco", 
                );
        }

        return $helpers->json($responce);
    }

    /**
     * Deletes a Pago entity.
     *
     * @Route("/{id}/delete", name="pago_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $pago = $em->getRepository('AppBundle:Pago')->find($id);

            $pago->setEstado(0);
            $em = $this->getDoctrine()->getManager();
                $em->persist($pago);
                $em->flush();
            $responce = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "pago eliminado con exito", 
                );
        }else{
            $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($responce);
    }

    /**
     * Creates a form to delete a Pago entity.
     *
     * @param Pago $pago The Pago entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Pago $pago)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pago_delete', array('id' => $pago->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


    /**
     * datos para select 2
     *
     * @Route("/select", name="pago_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $pagos = $em->getRepository('AppBundle:Pago')->findAll();
        
    if ($pagos == null) {
       $responce = null;
    }
      foreach ($pagos as $key => $pago) {
        $responce[$key] = array(
            'value' => $pago->getId(),
            'label' => $pago->getTramite()->getNombre(),
            );
      }
       return $helpers->json($responce);
    }
}
