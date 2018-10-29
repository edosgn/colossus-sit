<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CfgClaseAccidente;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;use Symfony\Component\HttpFoundation\Request;

/**
 * Cfgclaseaccidente controller.
 *
 * @Route("cfgclaseaccidente")
 */
class CfgClaseAccidenteController extends Controller
{
    /**
     * Lists all cfgClaseAccidente entities.
     *
     * @Route("/", name="cfgclaseaccidente_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $cfgClasesAccidente = $em->getRepository('AppBundle:CfgClaseAccidente')->findBy(
            array('estado' => 1)
        );
        $response = array(
            'status' => 'success',
            'code' => 200,
            'msj' => "listado clases accidente",
            'data' => $cfgClasesAccidente,
        );

        return $helpers->json($response);

    }

    /**
     * Creates a new cfgClaseAccidente entity.
     *
     * @Route("/new", name="cfgclaseaccidente_new")
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

            $nombre = $params->nombre;

            $em = $this->getDoctrine()->getManager();
            $cfgClaseAccidente = $em->getRepository('AppBundle:CfgClaseAccidente')->findOneByNombre($params->nombre);

            if ($cfgClaseAccidente == null) {
                $cfgClaseAccidente = new CfgClaseAccidente();

                $cfgClaseAccidente->setNombre(strtoupper($nombre));
                $cfgClaseAccidente->setEstado(true);

                $em->persist($cfgClaseAccidente);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Clase accidente creado con exito",
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El nombre de la clase accidente ya se encuentra registrado",
                );
            }

            //}
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
     * Finds and displays a cfgClaseAccidente entity.
     *
     * @Route("/show/{id}", name="cfgclaseaccidente_show")
     * @Method("POST")
     */
    public function showAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $cfgClaseAccidente = $em->getRepository('AppBundle:CfgClaseAccidente')->find($id);
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "clase accidente encontrado",
                'data' => $cfgClaseAccidente,
            );
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
     * Displays a form to edit an existing cfgClaseAccidente entity.
     *
     * @Route("/edit", name="cfgclaseaccidente_edit")
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

            $nombre = $params->nombre;
            $em = $this->getDoctrine()->getManager();
            $cfgClaseAccidente = $em->getRepository('AppBundle:CfgClaseAccidente')->find($params->id);
            if ($cfgClaseAccidente != null) {

                $cfgClaseAccidente->setNombre($nombre);
                $cfgClaseAccidente->setEstado(true);

                $em = $this->getDoctrine()->getManager();
                $em->persist($cfgClaseAccidente);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "clase accidente editada con exito",
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "La clase accidente no se encuentra en la base de datos",
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida para editar banco",
            );
        }

        return $helpers->json($response);

    }

    /**
     * Deletes a cfgClaseAccidente entity.
     *
     * @Route("/{id}/delete", name="cfgclaseaccidente_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $cfgClaseAccidente = $em->getRepository('AppBundle:CfgClaseAccidente')->find($id);

            $cfgClaseAccidente->setEstado(0);
            $em = $this->getDoctrine()->getManager();
            $em->persist($cfgClaseAccidente);
            $em->flush();
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "clase accidente eliminado con exito",
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
     * Creates a form to delete a cfgClaseAccidente entity.
     *
     * @param CfgClaseAccidente $cfgClaseAccidente The cfgClaseAccidente entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgClaseAccidente $cfgClaseAccidente)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgclaseaccidente_delete', array('id' => $cfgClaseAccidente->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="cfgclaseaccidente_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        $cfgClasesAccidente = $em->getRepository('AppBundle:CfgClaseAccidente')->findBy(
            array('estado' => 1)
        );

        $response = null;

        foreach ($cfgClasesAccidente as $key => $cfgClaseAccidente) {
            $response[$key] = array(
                'value' => $cfgClaseAccidente->getNombre(),
                'label' => $cfgClaseAccidente->getNombre(),
                //'label' => $cfgClaseAccidente->getNombre(),
            );
        }
        return $helpers->json($response);
    }
}
