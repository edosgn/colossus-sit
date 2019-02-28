<?php

namespace JHWEB\FinancieroBundle\Controller;

use JHWEB\FinancieroBundle\Entity\FroTrteCfgCuenta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Frotrtecfgcuentum controller.
 *
 * @Route("frotrtecfgcuenta")
 */
class FroTrteCfgCuentaController extends Controller
{
    /**
     * Lists all froTrteCfgCuentum entities.
     *
     * @Route("/", name="frotrtecfgcuenta_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $cuentas = $em->getRepository('JHWEBFinancieroBundle:FroTrteCfgCuenta')->findBy(
            array('activo' => 1)
        );
        $response = array(
            'status' => 'success',
            'code' => 200,
            'message' => "listado cuentas",
            'data' => $cuentas,
        );

        return $helpers->json($response);
    }

    /**
     * Creates a new Cuenta entity.
     *
     * @Route("/new", name="frotrtecfgcuenta_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);
            
            $em = $this->getDoctrine()->getManager();

            $cuenta = new FroTrteCfgCuenta();
            $cuenta->setNombre($params->nombre);
            $cuenta->setNumero($params->numero);
            $cuenta->setActivo(true);
            $em->persist($cuenta);
            $em->flush();
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Cuenta creada con éxito",
            );

        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Finds and displays a froTrteCfgCuentum entity.
     *
     * @Route("/{id}/show", name="frotrtecfgcuenta_show")
     * @Method("POST")
     */
    public function showAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $cuenta = $em->getRepository('JHWEBFinancieroBundle:FroTrteCfgCuenta')->find($id);
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Cuenta encontrada", 
                    'data'=> $cuenta,
            );
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorización no válida", 
                );
        }
        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing Cuenta entity.
     *
     * @Route("/edit", name="frotrtecfgcuenta_edit")
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

            $em = $this->getDoctrine()->getManager();
            $cuenta = $em->getRepository('JHWEBFinancieroBundle:FroTrteCfgCuenta')->find($params->id);

            if ($cuenta!=null) {
                $cuenta->setNombre($params->nombre);
                $cuenta->setNumero($params->numero);
                $cuenta->setActivo(true);
                $em->persist($cuenta);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Cuenta actualizada con exito", 
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "La cuenta no se encuentra en la base de datos", 
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
            $cuenta = $em->getRepository('JHWEBFinancieroBundle:FroTrteCfgCuenta')->find($id);

            $cuenta->setActivo(0);
            $em->persist($cuenta);
            $em->flush();
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Cuenta eliminada con éxito", 
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida", 
            );
        }
        return $helpers->json($response);
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="frotrtecfgcuenta_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $cuentas = $em->getRepository('JHWEBFinancieroBundle:FroTrteCfgCuenta')->findBy(
            array('activo' => 1)
        );
        $response = null;

        foreach ($cuentas as $key => $cuenta) {
            $response[$key] = array(
                'value' => $cuenta->getId(),
                'label' => $cuenta->getNombre(),
            );
        }
        return $helpers->json($response);
    }
}
