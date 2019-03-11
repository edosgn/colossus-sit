<?php

namespace JHWEB\PersonalBundle\Controller;

use JHWEB\PersonalBundle\Entity\PnalCfgCargo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Pnalcfgcargo controller.
 *
 * @Route("pnalcfgcargo")
 */
class PnalCfgCargoController extends Controller
{
    /**
     * Lists all pnalCfgCargo entities.
     *
     * @Route("/", name="pnalcfgcargo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $cargos = $em->getRepository('JHWEBPersonalBundle:PnalCfgCargo')->findBy(
            array(
                'activo' => true
            )
        );

        $response['data'] = array();

        if ($cargos) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($cargos).' registros encontrados.', 
                'data'=> $cargos,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new pnalCfgCargo entity.
     *
     * @Route("/new", name="pnalcfgcargo_new")
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

            $cargo = new PnalCfgCargo();

            $cargo->setNombre(mb_strtoupper($params->nombre, 'utf-8'));
            $cargo->setGestionable($params->gestionable);
            $cargo->setActivo(true);
            
            $em->persist($cargo);
            
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
     * Finds and displays a pnalCfgCargo entity.
     *
     * @Route("/show", name="pnalcfgcargo_show")
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

            $cargo = $em->getRepository('JHWEBPersonalBundle:PnalCfgCargo')->find(
                $params->id
            );

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro encontrado con exito",
                'data' => $cargo
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
     * Displays a form to edit an existing pnalCfgCargo entity.
     *
     * @Route("/edit", name="pnalcfgcargo_edit")
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

            $cargo = $em->getRepository("JHWEBPersonalBundle:PnalCfgCargo")->find($params->id);

            if ($cargo) {
                $cargo->setNombre(mb_strtoupper($params->nombre, 'utf-8'));
                $cargo->setGestionable($params->gestionable);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Registro actualizado con exito.', 
                    'data'=> $cargo,
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
     * Deletes a pnalCfgCargo entity.
     *
     * @Route("/delete", name="pnalcfgcargo_delete")
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

            $cargo = $em->getRepository('JHWEBPersonalBundle:PnalCfgCargo')->find(
                $params->id
            );

            $cargo->setActivo(false);

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
     * Creates a form to delete a pnalCfgCargo entity.
     *
     * @param PnalCfgCargo $pnalCfgCargo The pnalCfgCargo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PnalCfgCargo $pnalCfgCargo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pnalcfgcargo_delete', array('id' => $pnalCfgCargo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ============================================== */

    /**
     * Listado de cargos para selección con búsqueda
     *
     * @Route("/select", name="pnalcfgcargo_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $cargos = $em->getRepository('JHWEBPersonalBundle:PnalCfgCargo')->findBy(
            array('activo' => true)
        );
        
        $response = null;

        foreach ($cargos as $key => $cargo) {
            $response[$key] = array(
                'value' => $cargo->getId(),
                'label' => $cargo->getNombre(),
            );
        }
        
        return $helpers->json($response);
    }
}
