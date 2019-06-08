<?php

namespace JHWEB\BancoProyectoBundle\Controller;

use JHWEB\BancoProyectoBundle\Entity\BpInsumo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Bpinsumo controller.
 *
 * @Route("bpinsumo")
 */
class BpInsumoController extends Controller
{
    /**
     * Lists all bpInsumo entities.
     *
     * @Route("/", name="bpinsumo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $insumos = $em->getRepository('JHWEBBancoProyectoBundle:BpInsumo')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($insumos) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($insumos)." registros encontrados", 
                'data'=> $insumos,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new bpInsumo entity.
     *
     * @Route("/new", name="bpinsumo_new")
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

            $insumo = new BpInsumo();

            $insumo->setNombre(mb_strtoupper($params->nombre, 'utf-8'));
            $insumo->setUnidadMedida($params->unidadMedida);
            $insumo->setCantidad($params->cantidad);
            $insumo->setValorUnitario($params->valorUnitario);
            $insumo->setValorTotal($params->valorTotal);
            $insumo->setActivo(true);

            if ($params->idTipoInsumo) {
                $tipoInsumo = $em->getRepository('JHWEBBancoProyectoBundle:BpCfgTipoInsumo')->find($params->idTipoInsumo);
                $insumo->setTipo($tipoInsumo);
            }

            if ($params->idActividad) {
                $actividad = $em->getRepository('JHWEBBancoProyectoBundle:BpActividad')->find($params->idActividad);
                $insumo->setActividad($actividad);
            }

            $em->persist($insumo);
            $em->flush();

            //Actualiza costo total de actividad
            $insumos = $em->getRepository('JHWEBBancoProyectoBundle:BpInsumo')->getCostoTotalByActividad(
                $actividad->getId()
            );

            if ($insumos) {
                $actividad->setCostoTotal($insumos['total']);
            }else{
                $actividad->setCostoTotal(0);
            }

            $em->flush();

            //Actualiza costo total de cuenta
            $cuenta = $actividad->getCuenta();

            $actividades = $em->getRepository('JHWEBBancoProyectoBundle:BpActividad')->getCostoTotalByCuenta(
                $cuenta->getId()
            );

            if ($actividades) {
                $cuenta->setCostoTotal($actividades['total']);
            }else{
                $cuenta->setCostoTotal(0);
            }

            $em->flush();

            //Actualiza costo total de proyecto
            $proyecto = $cuenta->getProyecto();

            $cuentas = $em->getRepository('JHWEBBancoProyectoBundle:BpCuenta')->getCostoTotalByProyecto(
                $proyecto->getId()
            );

            if ($cuentas) {
                $proyecto->setCostoTotal($cuentas['total']);
            }else{
                $proyecto->setCostoTotal(0);
            }

            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con exito",
                'data' => $insumo
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
     * Finds and displays a bpInsumo entity.
     *
     * @Route("/{id}", name="bpinsumo_show")
     * @Method("GET")
     */
    public function showAction(BpInsumo $bpInsumo)
    {
        $deleteForm = $this->createDeleteForm($bpInsumo);

        return $this->render('bpinsumo/show.html.twig', array(
            'bpInsumo' => $bpInsumo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing bpInsumo entity.
     *
     * @Route("/{id}/edit", name="bpinsumo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, BpInsumo $bpInsumo)
    {
        $deleteForm = $this->createDeleteForm($bpInsumo);
        $editForm = $this->createForm('JHWEB\BancoProyectoBundle\Form\BpInsumoType', $bpInsumo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('bpinsumo_edit', array('id' => $bpInsumo->getId()));
        }

        return $this->render('bpinsumo/edit.html.twig', array(
            'bpInsumo' => $bpInsumo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a bpInsumo entity.
     *
     * @Route("/delete", name="bpinsumo_delete")
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
            
            $insumo = $em->getRepository('JHWEBBancoProyectoBundle:BpInsumo')->find(
                $params->id
            );

            if ($insumo) {
                $insumo->setActivo(false);

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
     * Creates a form to delete a bpInsumo entity.
     *
     * @param BpInsumo $bpInsumo The bpInsumo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BpInsumo $bpInsumo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bpinsumo_delete', array('id' => $bpInsumo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
