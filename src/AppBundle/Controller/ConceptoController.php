<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Concepto;
use AppBundle\Form\ConceptoType;

/**
 * Concepto controller.
 *
 * @Route("/concepto")
 */
class ConceptoController extends Controller
{
    /**
     * Lists all Concepto entities.
     *
     * @Route("/", name="concepto_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $conceptos = $em->getRepository('AppBundle:Concepto')->findBy(
            array('estado' => 1)
        );
        $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado conceptos", 
                    'data'=> $conceptos,
            );
         
        return $helpers->json($responce);
    }

    /**
     * Creates a new Concepto entity.
     *
     * @Route("/new", name="concepto_new")
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
                        $descripcion = $params->descripcion;
                        $valor = $params->valor;
                        $tramiteId = $params->tramiteId;
                        $cuentaId = $params->cuentaId;
                        $em = $this->getDoctrine()->getManager();
                        $tramite = $em->getRepository('AppBundle:Tramite')->find($tramiteId);
                        $cuenta = $em->getRepository('AppBundle:Cuenta')->find($cuentaId);
           
                        $concepto = new Concepto();
                        $concepto->setDescripcion($descripcion);
                        $concepto->setValor($valor);
                        $concepto->setTramite($tramite);
                        $concepto->setCuenta($cuenta);
                        $concepto->setEstado(true);

                        $em = $this->getDoctrine()->getManager();
                        $em->persist($concepto);
                        $em->flush();

                        $responce = array(
                            'status' => 'success',
                            'code' => 200,
                            'msj' => "concepto creado con exito", 
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
     * Finds and displays a Concepto entity.
     *
     * @Route("/show/{id}", name="concepto_show")
     * @Method("POST")
     */
    public function showAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $concepto = $em->getRepository('AppBundle:Concepto')->find($id);
            $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "concepto encontrado", 
                    'data'=> $concepto,
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
     * Displays a form to edit an existing Concepto entity.
     *
     * @Route("/edit", name="concepto_edit")
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

            
            $descripcion = $params->descripcion;
            $valor = $params->valor;
            $tramiteId = $params->tramiteId;
            $cuentaId = $params->cuentaId;
            $em = $this->getDoctrine()->getManager();
            $tramite = $em->getRepository('AppBundle:Tramite')->find($tramiteId);
            $cuenta = $em->getRepository('AppBundle:Cuenta')->find($cuentaId);

            $em = $this->getDoctrine()->getManager();
            $concepto = $em->getRepository("AppBundle:Concepto")->find($params->id);

            if ($concepto!=null) {
                        $concepto->setDescripcion($descripcion);
                        $concepto->setValor($valor);
                        $concepto->setTramite($tramite);
                        $concepto->setCuenta($cuenta);
                        $concepto->setEstado(true);

                        $em = $this->getDoctrine()->getManager();
                        $em->persist($concepto);
                        $em->flush();

                        $responce = array(
                            'status' => 'success',
                            'code' => 200,
                            'msj' => "concepto editado con exito", 
                        );
            }else{
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El concepto no se encuentra en la base de datos", 
                );
            }
        }else{
            $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar concepto", 
                );
        }

        return $helpers->json($responce);
    }

    /**
     * Deletes a Concepto entity.
     *
     * @Route("/{id}/delete", name="concepto_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $concepto = $em->getRepository('AppBundle:Concepto')->find($id);

            $concepto->setEstado(0);
            $em = $this->getDoctrine()->getManager();
                $em->persist($concepto);
                $em->flush();
            $responce = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "concepto eliminado con exito", 
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
     * Creates a form to delete a Concepto entity.
     *
     * @param Concepto $concepto The Concepto entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Concepto $concepto)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('concepto_delete', array('id' => $concepto->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
