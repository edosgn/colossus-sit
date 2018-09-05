<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\TecnoMecanica;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Tecnomecanica controller.
 *
 * @Route("tecnomecanica")
 */
class TecnoMecanicaController extends Controller
{
    /**
     * Lists all tecnoMecanica entities.
     *
     * @Route("/", name="tecnomecanica_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
        
            $tecnoMecanicas = $em->getRepository('JHWEBVehiculoBundle:TecnoMecanica')->findBy(
                array(
                    'activo' => true,
                    'vehiculo' => $params->idVehiculo
                )
            );

            $response['data'] = array();

            if ($tecnoMecanicas) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($tecnoMecanicas)." registros encontrados", 
                    'data'=> $tecnoMecanicas,
                );
            }
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
     * Creates a new tecnoMecanica entity.
     *
     * @Route("/new", name="tecnomecanica_new")
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

            $tecnoMecanica = new TecnoMecanica();

            $em = $this->getDoctrine()->getManager();

            if ($params->idCda) {
                $cfgCda = $em->getRepository('JHWEBVehiculoBundle:CfgCda')->find(
                    $params->idCda
                );
                $tecnoMecanica->setCda($cfgCda);
            }

            if ($params->idVehiculo) {
                $vehiculo = $em->getRepository('AppBundle:Vehiculo')->find(
                    $params->idVehiculo
                );
                $tecnoMecanica->setVehiculo($vehiculo);
            }


            $tecnoMecanica->setNumeroControl($params->numeroControl);
            $tecnoMecanica->setFechaExpedicion(new \Datetime($params->fechaExpedicion));
            $tecnoMecanica->setFechaVencimiento(new \Datetime($params->fechaVencimiento));
            $tecnoMecanica->setActivo(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($tecnoMecanica);
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
     * Finds and displays a tecnoMecanica entity.
     *
     * @Route("/{id}", name="tecnomecanica_show")
     * @Method("GET")
     */
    public function showAction(TecnoMecanica $tecnoMecanica)
    {
        $deleteForm = $this->createDeleteForm($tecnoMecanica);

        return $this->render('tecnomecanica/show.html.twig', array(
            'tecnoMecanica' => $tecnoMecanica,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing tecnoMecanica entity.
     *
     * @Route("/{id}/edit", name="tecnomecanica_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TecnoMecanica $tecnoMecanica)
    {
        $deleteForm = $this->createDeleteForm($tecnoMecanica);
        $editForm = $this->createForm('JHWEB\VehiculoBundle\Form\TecnoMecanicaType', $tecnoMecanica);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tecnomecanica_edit', array('id' => $tecnoMecanica->getId()));
        }

        return $this->render('tecnomecanica/edit.html.twig', array(
            'tecnoMecanica' => $tecnoMecanica,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a tecnoMecanica entity.
     *
     * @Route("/{id}", name="tecnomecanica_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TecnoMecanica $tecnoMecanica)
    {
        $form = $this->createDeleteForm($tecnoMecanica);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tecnoMecanica);
            $em->flush();
        }

        return $this->redirectToRoute('tecnomecanica_index');
    }

    /**
     * Creates a form to delete a tecnoMecanica entity.
     *
     * @param TecnoMecanica $tecnoMecanica The tecnoMecanica entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TecnoMecanica $tecnoMecanica)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tecnomecanica_delete', array('id' => $tecnoMecanica->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Creates a new cfgCda entity.
     *
     * @Route("/get/fecha/vencimiento", name="tecnomecanica_fecha_vencimiento")
     * @Method({"GET", "POST"})
     */
    public function getFechaVencimientoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $fechaVencimiento = new \Datetime(date('Y-m-d', strtotime('+1 year', strtotime($params->fechaExpedicion))));

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Fecha de vencimiento calculada con exito",
                'data' => $fechaVencimiento->format('Y-m-d')
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
}
