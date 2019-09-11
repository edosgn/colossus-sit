<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloRestriccion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlorestriccion controller.
 *
 * @Route("vhlorestriccion")
 */
class VhloRestriccionController extends Controller
{
    /**
     * Lists all vhloRestriccion entities.
     *
     * @Route("/", name="vhlorestriccion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $vhloRestriccions = $em->getRepository('JHWEBVehiculoBundle:VhloRestriccion')->findAll();

        return $this->render('vhlorestriccion/index.html.twig', array(
            'vhloRestriccions' => $vhloRestriccions,
        ));
    }

    /**
     * Creates a new vhloRestriccion entity.
     *
     * @Route("/new", name="vhlorestriccion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $vhloRestriccion = new Vhlorestriccion();
        $form = $this->createForm('JHWEB\VehiculoBundle\Form\VhloRestriccionType', $vhloRestriccion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($vhloRestriccion);
            $em->flush();

            return $this->redirectToRoute('vhlorestriccion_show', array('id' => $vhloRestriccion->getId()));
        }

        return $this->render('vhlorestriccion/new.html.twig', array(
            'vhloRestriccion' => $vhloRestriccion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a vhloRestriccion entity.
     *
     * @Route("/{id}/show", name="vhlorestriccion_show")
     * @Method("GET")
     */
    public function showAction(VhloRestriccion $vhloRestriccion)
    {
        $deleteForm = $this->createDeleteForm($vhloRestriccion);

        return $this->render('vhlorestriccion/show.html.twig', array(
            'vhloRestriccion' => $vhloRestriccion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vhloRestriccion entity.
     *
     * @Route("/{id}/edit", name="vhlorestriccion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, VhloRestriccion $vhloRestriccion)
    {
        $deleteForm = $this->createDeleteForm($vhloRestriccion);
        $editForm = $this->createForm('JHWEB\VehiculoBundle\Form\VhloRestriccionType', $vhloRestriccion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vhlorestriccion_edit', array('id' => $vhloRestriccion->getId()));
        }

        return $this->render('vhlorestriccion/edit.html.twig', array(
            'vhloRestriccion' => $vhloRestriccion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a vhloRestriccion entity.
     *
     * @Route("/{id}/delete", name="vhlorestriccion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, VhloRestriccion $vhloRestriccion)
    {
        $form = $this->createDeleteForm($vhloRestriccion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vhloRestriccion);
            $em->flush();
        }

        return $this->redirectToRoute('vhlorestriccion_index');
    }

    /**
     * Creates a form to delete a vhloRestriccion entity.
     *
     * @param VhloRestriccion $vhloRestriccion The vhloRestriccion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloRestriccion $vhloRestriccion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhlorestriccion_delete', array('id' => $vhloRestriccion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ============================================== */

    /**
     * Busca las restricciones activas por vehiculo.
     *
     * @Route("/search/vehiculo", name="vhlolimitacion_search_vehiculo")
     * @Method({"GET", "POST"})
     */
    public function searchByVehiculoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->find(
                $params->idVehiculo
            );

            if ($vehiculo) {
                $restricciones = $em->getRepository('JHWEBVehiculoBundle:VhloLimitacion')->findBy(
                    array(
                        'vehiculo' => $vehiculo->getId(),
                        'activo' => true,
                    )
                );

                if ($restricciones) {
                    $response = array(
                        'title' => 'Perfecto!',
                        'status' => 'success',
                        'code' => 200,
                        'message' => count($restricciones).' restricciones encontradas.',
                        'data' => $restricciones,
                    );
                }else{
                    $response = array(
                        'title' => 'Atención!',
                        'status' => 'warning',
                        'code' => 401,
                        'message' => 'El vehiculo no presenta restricciones vigentes.',
                    );
                }
            }else{
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'No se encuentra ningún vehiculo con el número de placa digitada.',
                );
            }
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
     * Busca las restricciones activas por vehiculo.
     *
     * @Route("/search/vehiculo/tipo", name="vhlolimitacion_search_vehiculo_tipo")
     * @Method({"GET", "POST"})
     */
    public function searchByVehiculoAndTipoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->find(
                $params->idVehiculo
            );

            if ($vehiculo) {
                $restricciones = $em->getRepository('JHWEBVehiculoBundle:VhloLimitacion')->findBy(
                    array(
                        'vehiculo' => $vehiculo->getId(),
                        'tipo' => $params->tipo,
                        'activo' => true,
                    )
                );

                if ($restricciones) {
                    $response = array(
                        'title' => 'Perfecto!',
                        'status' => 'success',
                        'code' => 200,
                        'message' => count($restricciones).' restricciones encontradas.',
                        'data' => $restricciones,
                    );
                }else{
                    $response = array(
                        'title' => 'Atención!',
                        'status' => 'warning',
                        'code' => 401,
                        'message' => 'El vehiculo no presenta restricciones vigentes.',
                    );
                }
            }else{
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'No se encuentra ningún vehiculo con el número de placa digitada.',
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida",
            );
        }
        
        return $helpers->json($response);
    }
}
