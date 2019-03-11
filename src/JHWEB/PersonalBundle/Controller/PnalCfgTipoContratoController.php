<?php

namespace JHWEB\PersonalBundle\Controller;

use JHWEB\PersonalBundle\Entity\PnalCfgTipoContrato;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Pnalcfgtipocontrato controller.
 *
 * @Route("pnalcfgtipocontrato")
 */
class PnalCfgTipoContratoController extends Controller
{
    /**
     * Lists all pnalCfgTipoContrato entities.
     *
     * @Route("/", name="pnalcfgtipocontrato_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $tiposContrato = $em->getRepository('JHWEBPersonalBundle:PnalCfgTipoContrato')->findBy(
            array(
                'activo' => true
            )
        );

        $response['data'] = array();

        if ($tiposContrato) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($tiposContrato)." registros encontrados", 
                'data'=> $tiposContrato,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new pnalCfgTipoContrato entity.
     *
     * @Route("/new", name="pnalcfgtipocontrato_new")
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

            $em = $this->getDoctrine()->getManager();

            $tipoContrato = new PnalCfgTipoContrato();

            $tipoContrato->setNombre(mb_strtoupper($params->nombre, 'utf-8'));
            $tipoContrato->setHorarios($params->horarios);
            $tipoContrato->setProrroga($params->prorroga);
            $tipoContrato->setActivo(true);
            
            $em->persist($tipoContrato);
            
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
     * Finds and displays a pnalCfgTipoContrato entity.
     *
     * @Route("/show", name="pnalcfgtipocontrato_show")
     * @Method("POST")
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $tipoContrato = $em->getRepository('JHWEBPersonalBundle:PnalCfgTipoContrato')->find(
                $params->id
            );

            $em->persist($tipoContrato);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro encontrado con exito",
                'data' => $tipoContrato
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
     * Displays a form to edit an existing pnalCfgTipoContrato entity.
     *
     * @Route("/edit", name="pnalcfgtipocontrato_edit")
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

            $tipoContrato = $em->getRepository("JHWEBPersonalBundle:PnalCfgTipoContrato")->find($params->id);

            if ($tipoContrato) {
                $tipoContrato->setNombre(mb_strtoupper($params->nombre, 'utf-8'));
                $tipoContrato->setHorarios($params->horarios);
                $tipoContrato->setProrroga($params->prorroga);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Registro actualizado con exito.', 
                    'data'=> $tipoContrato,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'El registro no se encuentra en la base de datos.', 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Autorizacion no valida para editar.', 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a pnalCfgTipoContrato entity.
     *
     * @Route("/{id}", name="pnalcfgtipocontrato_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $tipoContrato = $em->getRepository('JHWEBPersonalBundle:PnalCfgTipoContrato')->find(
                $params->id
            );

            $tipoContrato->setActivo(false);

            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Registro eliminado con exito.'
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida.', 
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a pnalCfgTipoContrato entity.
     *
     * @param PnalCfgTipoContrato $pnalCfgTipoContrato The pnalCfgTipoContrato entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PnalCfgTipoContrato $pnalCfgTipoContrato)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pnalcfgtipocontrato_delete', array('id' => $pnalCfgTipoContrato->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ============================================== */

    /**
     * Listado de tipos de contrato para selección con búsqueda
     *
     * @Route("/select", name="pnalcfgtipocontrato_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $tiposContrato = $em->getRepository('JHWEBPersonalBundle:PnalCfgTipoContrato')->findBy(
            array('activo' => true)
        );
        
        $response = null;

        foreach ($tiposContrato as $key => $tipoContrato) {
            $response[$key] = array(
                'value' => $tipoContrato->getId(),
                'label' => $tipoContrato->getNombre(),
            );
        }
        
        return $helpers->json($response);
    }
}
