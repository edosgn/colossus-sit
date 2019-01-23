<?php

namespace JHWEB\BancoProyectoBundle\Controller;

use JHWEB\BancoProyectoBundle\Entity\BpCfgTipoInsumo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Bpcfgtipoinsumo controller.
 *
 * @Route("bpcfgtipoinsumo")
 */
class BpCfgTipoInsumoController extends Controller
{
    /**
     * Lists all bpCfgTipoInsumo entities.
     *
     * @Route("/", name="bpcfgtipoinsumo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $tipos = $em->getRepository('JHWEBBancoProyectoBundle:BpCfgTipoInsumo')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($tipos) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($tipos)." registros encontrados", 
                'data'=> $tipos,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new bpCfgTipoInsumo entity.
     *
     * @Route("/new", name="bpcfgtipoinsumo_new")
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
           
            $tipo = new BpCfgTipoInsumo();

            $tipo->setNombre(strtoupper($params->nombre));
            $tipo->setActivo(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($tipo);
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
     * Finds and displays a bpCfgTipoInsumo entity.
     *
     * @Route("/{id}/show", name="bpcfgtipoinsumo_show")
     * @Method("GET")
     */
    public function showAction(BpCfgTipoInsumo $bpCfgTipoInsumo)
    {
        $deleteForm = $this->createDeleteForm($bpCfgTipoInsumo);

        return $this->render('bpcfgtipoinsumo/show.html.twig', array(
            'bpCfgTipoInsumo' => $bpCfgTipoInsumo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing bpCfgTipoInsumo entity.
     *
     * @Route("/edit", name="bpcfgtipoinsumo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            
            $tipo = $em->getRepository('JHWEBBancoProyectoBundle:BpCfgTipoInsumo')->find(
                $params->id
            );

            if ($tipo) {
                $tipo->setNombre(strtoupper($params->nombre));

                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $tipo,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos",
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida para editar",
            );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a bpCfgTipoInsumo entity.
     *
     * @Route("/delete", name="bpcfgtipoinsumo_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            
            $tipo = $em->getRepository('JHWEBBancoProyectoBundle:BpCfgTipoInsumo')->find(
                $params->id
            );

            if ($tipo) {
                $tipo->setActivo(false);

                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro eliminado con éxito"
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos",
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida",
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a bpCfgTipoInsumo entity.
     *
     * @param BpCfgTipoInsumo $bpCfgTipoInsumo The bpCfgTipoInsumo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BpCfgTipoInsumo $bpCfgTipoInsumo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bpcfgtipoinsumo_delete', array('id' => $bpCfgTipoInsumo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* =================================================== */

    /**
     * datos para select 2
     *
     * @Route("/select", name="bpcfgtipoinsumo_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $tipos = $em->getRepository('JHWEBBancoProyectoBundle:BpCfgTipoInsumo')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($tipos as $key => $tipo) {
            $response[$key] = array(
                'value' => $tipo->getId(),
                'label' => $tipo->getNombre(),
            );
        }

        return $helpers->json($response);
    }
}
