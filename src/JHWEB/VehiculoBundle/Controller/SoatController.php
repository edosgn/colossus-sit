<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\Soat;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Soat controller.
 *
 * @Route("soat")
 */
class SoatController extends Controller
{
    /**
     * Lists all Soat entities.
     *
     * @Route("/", name="soat_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            $soats = $em->getRepository('JHWEBVehiculoBundle:Soat')->findBy(
                array(
                    'activo' => true,
                    'vehiculo' => $params->idVehiculo,
                )
            );
            $response['data'] = array();

            if ($soats) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($soats) . " registros encontrados",
                    'data' => $soats,
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
     * Creates a new Soat entity.
     *
     * @Route("/new", name="soat_new")
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
            $soat = new Soat();

            $em = $this->getDoctrine()->getManager();
            if ($params->idMunicipio) {
                $municipio = $em->getRepository('AppBundle:Municipio')->find(
                    $params->idMunicipio
                );
                $soat->setMunicipio($municipio);
            }

            if ($params->idVehiculo) {
                $vehiculo = $em->getRepository('AppBundle:Vehiculo')->find(
                    $params->idVehiculo
                );
                $soat->setVehiculo($vehiculo);
            }

            $soat->setFechaExpedicion(new \Datetime($params->fechaExpedicion));
            $soat->setVigencia(new \Datetime($params->vigencia));
            $soat->setNumeroPoliza($params->numeroPoliza);
            $soat->setNombreEmpresa($params->nombreEmpresa);
            $soat->setActivo(true);
            $em->persist($soat);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Los datos han sido registrados exitosamente.",
            );
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
     * Finds and displays a Soat entity.
     *
     * @Route("/{id}", name="soat_show")
     * @Method("GET")
     */
    public function showAction(Soat $soat)
    {
        $deleteForm = $this->createDeleteForm($soat);
        return $this->render('soat/show.html.twig', array(
            'soat' => $soat,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Soat entity.
     *
     * @Route("/{id}/edit", name="soat_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Soat $soat)
    {
        $deleteForm = $this->createDeleteForm($soat);
        $editForm = $this->createForm('JHWEB\VehiculoBundle\Form\SoatType', $soat);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('soat_edit', array('id' => $soat->getId()));
        }

        return $this->render('soat/edit.html.twig', array(
            'soat' => $soat,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a soat entity.
     *
     * @Route("/{id}", name="soat_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Soat $soat)
    {
        $form = $this->createDeleteForm($soat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($soat);
            $em->flush();
        }

        return $this->redirectToRoute('soat_index');
    }

    /**
     * Creates a form to delete a soat entity.
     *
     * @param Soat $soat The Soat entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Soat $soat)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('soat_delete', array('id' => $soat->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Creates a new Soat entity.
     *
     * @Route("/get/vigencia", name="vigencia_soat")
     * @Method({"GET", "POST"})
     */
    public function getVigenciaSoatAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $vigencia = new \Datetime(date('Y-m-d', strtotime('+1 year', strtotime($params->fechaExpedicion))));

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Fecha de vigencia soat calculada con exito",
                'data' => $vigencia->format('Y-m-d')
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
