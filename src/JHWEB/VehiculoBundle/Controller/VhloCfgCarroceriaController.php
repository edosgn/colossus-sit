<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloCfgCarroceria;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlocfgcarrocerium controller.
 *
 * @Route("vhlocfgcarroceria")
 */
class VhloCfgCarroceriaController extends Controller
{
    /**
     * Lists all vhloCfgCarroceria entities.
     *
     * @Route("/", name="vhlocfgcarroceria_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $carrocerias = $em->getRepository('JHWEBVehiculoBundle:VhloCfgCarroceria')->findBy(
            array('activo' => 1)
        );
        $response = array(
            'status' => 'success',
            'code' => 200,
            'message' => "listado carrocerias",
            'data' => $carrocerias,
        );

        return $helpers->json($response);
    }

    /**
     * Creates a new vhloCfgCarroceria entity.
     *
     * @Route("/new", name="vhlocfgcarroceria_new")
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

            $em = $this->getDoctrine()->getManager();
            $clase = $em->getRepository('JHWEBVehiculoBundle:VhloCfgClase')->find($params->idClase);
           
            $carroceria = new VhloCfgCarroceria();
            $carroceria->setNombre(strtoupper($params->nombre));
            $carroceria->setCodigo($params->codigo);
            $carroceria->setClase($clase);
            $carroceria->setActivo(true);

            $em->persist($carroceria);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con éxito",
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorización no válida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Finds and displays a vhloCfgCarroceria entity.
     *
     * @Route("/show/{id}", name="vhlocfgcarroceria_show")
     * @Method("GET")
     */
    public function showAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $carroceria = $em->getRepository('JHWEBVehiculoBundle:VhloCfgCarroceria')->find($id);
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "Carroceria con nombre" . " " . $carroceria->getNombre(),
                'data' => $carroceria,
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing Carroceria entity.
     *
     * @Route("/edit", name="vhlocfgcarroceria_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            $carroceria = $em->getRepository("JHWEBVehiculoBundle:VhloCfgCarroceria")->find($params->id);
            $clase = $em->getRepository("JHWEBVehiculoBundle:VhloCfgClase")->find($params->idClase);

            if ($carroceria != null) {

                $carroceria->setNombre($params->nombre);
                $carroceria->setCodigo($params->codigo);
                $carroceria->setClase($clase);
                $carroceria->setActivo(true);
                $em->persist($carroceria);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Carroceria editada con éxito",
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "La carroceria no se encuentra en la base de datos",
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
     * Deletes a Carroceria entity.
     *
     * @Route("/{id}/delete", name="vhlocfgcarroceria_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $carroceria = $em->getRepository('JHWEBVehiculoBundle:VhloCfgCarroceria')->find($id);

            $carroceria->setActivo(false);
            $em = $this->getDoctrine()->getManager();
            $em->persist($carroceria);
            $em->flush();
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Carroceria eliminada con éxito",
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
     * Creates a form to delete a VhloCfgCarroceria entity.
     *
     * @param VhloCfgCarroceria $vhloCfgCarroceria The VhloCfgCarroceria entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloCfgCarroceria $vhloCfgCarroceria)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhlocfgcarroceria_delete', array('id' => $vhloCfgCarroceria->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * encuentra las carrocerias de una clase.
     *
     * @Route("/clase/{id}", name="carroceria_clase")
     * @Method("POST")
     */
    public function carroceriaClaseAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $carrocerias = $em->getRepository('JHWEBVehiculoBundle:VhloCfgCarroceria')->findBy(
                array(
                    'activo' => 1,
                    'clase' => $id,
                )
            );

            if ($carrocerias != null) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Carroceria encontrada",
                    'data' => $carrocerias,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No existen carrocerias para esta clase",
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
     * datos para select 2
     *
     * @Route("/select", name="vhlocfgcarroceria_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $carrocerias = $em->getRepository('JHWEBVehiculoBundle:VhloCfgCarroceria')->findBy(
            array('activo' => 1)
        );
        $response = null;
        foreach ($carrocerias as $key => $carroceria) {
            $response[$key] = array(
                'value' => $carroceria->getId(),
                'label' => $carroceria->getCodigo() . "_" . $carroceria->getNombre(),
            );
        }
        return $helpers->json($response);
    }

}
