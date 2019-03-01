<?php

namespace JHWEB\FinancieroBundle\Controller;

use JHWEB\FinancieroBundle\Entity\FroTrteCfgConcepto;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Frotrtecfgconcepto controller.
 *
 * @Route("frotrtecfgconcepto")
 */
class FroTrteCfgConceptoController extends Controller
{
    /**
     * Lists all froTrteCfgConcepto entities.
     *
     * @Route("/", name="frotrtecfgconcepto_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $conceptos = $em->getRepository('JHWEBFinancieroBundle:FroTrteCfgConcepto')->findBy(
            array('activo' => true)
        );

        $response = array(
            'status' => 'success',
            'code' => 200,
            'message' => count($conceptos) . " registros encontrados",
            'data'=> $conceptos,
        );
         
        return $helpers->json($response);
    }

    /**
     * Creates a new Tramite Concepto entity.
     *
     * @Route("/new", name="tramite_concepto_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $concepto = new FroTrteCfgConcepto();

            $concepto->setNombre(mb_strtoupper($params->nombre, 'utf-8'));
            $concepto->setValor($params->valor);
            $concepto->setActivo(true);

            if ($params->idCuenta) {
                $cuenta = $em->getRepository('JHWEBFinancieroBundle:FroTrteCfgCuenta')->find(
                    $params->idCuenta
                );
                $concepto->setCuenta($cuenta);
            }

            $em = $this->getDoctrine()->getManager();

            $em->persist($concepto);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Concepto creado con exito',
            );
        }else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida',
            );
        }

        return $helpers->json($response);
    }

    /**
     * Finds and displays a froTrteCfgConcepto entity.
     *
     * @Route("/{id}/show", name="frotrtecfgconcepto_show")
     * @Method("POST")
     */
    public function showAction(Request $request,$id)
    {

        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $concepto = $em->getRepository('JHWEBFinancieroBundle:FroTrteCfgConcepto')->find($id);
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Concepto encontrado", 
                    'data'=> $concepto,
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
     * Displays a form to edit an existing Concepto entity.
     *
     * @Route("/edit", name="frotrtecfgconcepto_edit")
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
            $concepto = $em->getRepository("JHWEBFinancieroBundle:FroTrteCfgConcepto")->find($params->id);

            if ($concepto!=null) {
                $concepto->setNombre($params->nombre);
                $concepto->setValor($params->valor);
                $concepto->setCuenta($params->cuenta);
                $concepto->setActivo(true);

                $em->persist($concepto);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Concepto editado con éxito", 
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El concepto no se encuentra en la base de datos", 
                );
            }
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
     * Deletes a Concepto entity.
     *
     * @Route("/{id}/delete", name="frotrtecfgconcepto_delete")
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
            $response = array(
                    'status' => 'success',
                        'code' => 200,
                        'message' => "concepto eliminado con exito", 
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

    /* ============================================== */

    /**
     * Listado de tipos de recaudo para select con búsqueda
     *
     * @Route("/select", name="frotrteconcepto_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $conceptos = $em->getRepository('JHWEBFinancieroBundle:FroTrteCfgConcepto')->findBy(
            array('activo' => true)
        );
        
        $response = null;

        foreach ($conceptos as $key => $concepto) {
            $response[$key] = array(
                'value' => $concepto->getId(),
                'label' => $concepto->getNombre(),
            );
        }
        
        return $helpers->json($response);
    }
}
