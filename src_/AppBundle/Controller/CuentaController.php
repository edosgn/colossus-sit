<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Cuenta;
use AppBundle\Form\CuentaType;

/**
 * Cuenta controller.
 *
 * @Route("/cuenta")
 */ 
class CuentaController extends Controller
{
    /**
     * Lists all Cuenta entities.
     *
     * @Route("/", name="cuenta_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $cuentas = $em->getRepository('AppBundle:Cuenta')->findBy(
            array('estado' => 1)
        );
        $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado cuentas", 
                    'data'=> $cuentas,
            );
         
        return $helpers->json($response);
    }

    /**
     * Creates a new Cuenta entity.
     *
     * @Route("/new", name="cuenta_new")
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
            // if (count($params)==0) {
            //     $response = array(
            //         'status' => 'error',
            //         'code' => 400,
            //         'msj' => "los campos no pueden estar vacios", 
            //     );
            // }else{
                $numero = $params->numero;
                $observacion = $params->observacion;
                $bancoId = $params->bancoId;
                $em = $this->getDoctrine()->getManager();
                $banco = $em->getRepository('AppBundle:Banco')->find($bancoId);

                $cuenta = new Cuenta();
                $cuenta->setNumero($numero);
                $cuenta->setObservacion($observacion);
                $cuenta->setBanco($banco);
                $cuenta->setEstado(true);
                $em = $this->getDoctrine()->getManager();
                $em->persist($cuenta);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "cuenta creado con exito", 
                );
                // }
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida", 
            );
            } 
        return $helpers->json($response);
    }

    /**
     * Finds and displays a Cuenta entity.
     *
     * @Route("/show/{id}", name="cuenta_show")
     * @Method("POST")
     */
    public function showAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $cuenta = $em->getRepository('AppBundle:Cuenta')->find($id);
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "cuenta encontrada", 
                    'data'=> $cuenta,
            );
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing Cuenta entity.
     *
     * @Route("/edit", name="cuenta_edit")
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

            $numero = $params->numero;
            $observacion = $params->observacion;
            $bancoId = $params->bancoId;
            $em = $this->getDoctrine()->getManager();
            $banco = $em->getRepository('AppBundle:Banco')->find($bancoId);

            $em = $this->getDoctrine()->getManager();
            $cuenta = $em->getRepository("AppBundle:Cuenta")->find($params->id);

            if ($cuenta!=null) {
                $cuenta->setNumero($numero);
                $cuenta->setObservacion($observacion);
                $cuenta->setBanco($banco);
                $cuenta->setEstado(true);
                $em = $this->getDoctrine()->getManager();
                $em->persist($cuenta);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "cuenta actualizada con exito", 
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "La cuenta no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar banco", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a Cuenta entity.
     *
     * @Route("/{id}/delete", name="cuenta_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $cuenta = $em->getRepository('AppBundle:Cuenta')->find($id);

            $cuenta->setEstado(0);
            $em = $this->getDoctrine()->getManager();
                $em->persist($cuenta);
                $em->flush();
            $response = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "cuenta eliminado con exito", 
                );
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a Cuenta entity.
     *
     * @param Cuenta $cuentum The Cuenta entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Cuenta $cuentum)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cuenta_delete', array('id' => $cuentum->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="cuenta_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $cuentas = $em->getRepository('AppBundle:Cuenta')->findBy(
        array('estado' => 1)
    );
      foreach ($cuentas as $key => $cuenta) {
        $response[$key] = array(
            'value' => $cuenta->getId(),
            'label' => $cuenta->getBanco()->getNombre()."_".$cuenta->getNumero(),
            );
      }
       return $helpers->json($response);
    }
}
