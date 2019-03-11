<?php

namespace JHWEB\PersonalBundle\Controller;

use JHWEB\PersonalBundle\Entity\PnalCfgTipoNombramiento;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Pnalcfgtiponombramiento controller.
 *
 * @Route("pnalcfgtiponombramiento")
 */
class PnalCfgTipoNombramientoController extends Controller
{
    /**
     * Lists all pnalCfgTipoNombramiento entities.
     *
     * @Route("/", name="pnalcfgtiponombramiento_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $tiposNombramiento = $em->getRepository('JHWEBPersonalBundle:PnalCfgTipoNombramiento')->findBy(
            array(
                'activo' => true
            )
        );

        $response['data'] = array();

        if ($tiposNombramiento) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($tiposNombramiento).' registros encontrados.', 
                'data'=> $tiposNombramiento,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new pnalCfgTipoNombramiento entity.
     *
     * @Route("/new", name="pnalcfgtiponombramiento_new")
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
            $tipoContrato->setGestionable($params->gestionable);
            $tipoContrato->setActivo(true);
            
            $em->persist($tipoContrato);
            
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Registro creado con exito.',
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
     * Finds and displays a pnalCfgTipoNombramiento entity.
     *
     * @Route("/show", name="pnalcfgtiponombramiento_show")
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

            $tipoNombramiento = $em->getRepository('JHWEBPersonalBundle:PnalCfgTipoNombramiento')->find(
                $params->id
            );

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Registro encontrado con exito.',
                'data' => $tipoNombramiento
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
     * Displays a form to edit an existing pnalCfgTipoNombramiento entity.
     *
     * @Route("/edit", name="pnalcfgtiponombramiento_edit")
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

            $tipoNombramiento = $em->getRepository("JHWEBPersonalBundle:PnalCfgTipoNombramiento")->find($params->id);

            if ($tipoNombramiento) {
                $tipoNombramiento->setNombre(
                    mb_strtoupper($params->nombre, 'utf-8')
                );
                $tipoNombramiento->setGestionable($params->gestionable);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Registro actualizado con exito.', 
                    'data'=> $tipoNombramiento,
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
     * Deletes a pnalCfgTipoNombramiento entity.
     *
     * @Route("/delete", name="pnalcfgtiponombramiento_delete")
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

            $tipoNombramiento = $em->getRepository('JHWEBPersonalBundle:PnalCfgTipoNombramiento')->find(
                $params->id
            );

            $tipoNombramiento->setActivo(false);

            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro eliminado con exito"
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
     * Creates a form to delete a pnalCfgTipoNombramiento entity.
     *
     * @param PnalCfgTipoNombramiento $pnalCfgTipoNombramiento The pnalCfgTipoNombramiento entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PnalCfgTipoNombramiento $pnalCfgTipoNombramiento)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pnalcfgtiponombramiento_delete', array('id' => $pnalCfgTipoNombramiento->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ============================================== */

    /**
     * Listado de tipos de nombramiento para selección con búsqueda
     *
     * @Route("/select", name="pnalcfgtiponombramiento_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $tiposNombramiento = $em->getRepository('JHWEBPersonalBundle:PnalCfgTipoNombramiento')->findBy(
            array('activo' => true)
        );
        
        $response = null;

        foreach ($tiposNombramiento as $key => $tipoNombramiento) {
            $response[$key] = array(
                'value' => $tipoNombramiento->getId(),
                'label' => $tipoNombramiento->getNombre(),
            );
        }
        
        return $helpers->json($response);
    }
}
