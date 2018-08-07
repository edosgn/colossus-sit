<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CfgObjetoFijo;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;use Symfony\Component\HttpFoundation\Request;

/**
 * Cfgobjetofijo controller.
 *
 * @Route("cfgobjetofijo")
 */
class CfgObjetoFijoController extends Controller
{
    /**
     * Lists all cfgObjetoFijo entities.
     *
     * @Route("/", name="cfgobjetofijo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $cfgObjetosFijos = $em->getRepository('AppBundle:CfgObjetoFijo')->findBy(
            array('estado' => 1)
        );
        $response = array(
            'status' => 'success',
            'code' => 200,
            'msj' => "listado objetos fijos",
            'data' => $cfgObjetosFijos,
        );

        return $helpers->json($response);

    }

    /**
     * Creates a new cfgObjetoFijo entity.
     *
     * @Route("/new", name="cfgobjetofijo_new")
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
            $cfgObjetoFijo = $em->getRepository('AppBundle:CfgObjetoFijo')->findOneByNombre($params->nombre);

            if ($cfgObjetoFijo == null) {
                $cfgObjetoFijo = new CfgObjetoFijo();

                $cfgObjetoFijo->setNombre(strtoupper($nombre));
                $cfgObjetoFijo->setEstado(true);

                $em->persist($cfgObjetoFijo);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Objeto fijo creado con exito",
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El nombre del objeto fijo ya se encuentra registrado",
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
     * Finds and displays a cfgObjetoFijo entity.
     *
     * @Route("/show/{id}", name="cfgobjetofijo_show")
     * @Method("POST")
     */
    public function showAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $cfgObjetoFijo = $em->getRepository('AppBundle:CfgObjetoFijo')->find($id);
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "objeto fijo encontrado",
                'data' => $cfgObjetoFijo,
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
     * Displays a form to edit an existing cfgObjetoFijo entity.
     *
     * @Route("/edit", name="cfgobjetofijo_edit")
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
            $cfgObjetoFijo = $em->getRepository('AppBundle:CfgObjetoFijo')->find($params->id);
            if ($cfgObjetoFijo != null) {

                $cfgObjetoFijo->setNombre($nombre);
                $cfgObjetoFijo->setEstado(true);

                $em = $this->getDoctrine()->getManager();
                $em->persist($cfgObjetoFijo);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "objeto fijo editada con exito",
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Objeto fijo no se encuentra en la base de datos",
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
     * Deletes a cfgObjetoFijo entity.
     *
     * @Route("/{id}/delete", name="cfgobjetofijo_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $cfgObjetoFijo = $em->getRepository('AppBundle:CfgObjetoFijo')->find($id);

            $cfgObjetoFijo->setEstado(0);
            $em = $this->getDoctrine()->getManager();
            $em->persist($cfgObjetoFijo);
            $em->flush();
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "objeto fijo eliminado con exito",
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
     * Creates a form to delete a cfgObjetoFijo entity.
     *
     * @param CfgObjetoFijo $cfgObjetoFijo The cfgObjetoFijo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgObjetoFijo $cfgObjetoFijo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgobjetofijo_delete', array('id' => $cfgObjetoFijo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="cfgobjetofijo_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $cfgObjetosFijos = $em->getRepository('AppBundle:CfgObjetoFijo')->findBy(
            array('estado' => 1)
        );

        foreach ($cfgObjetosFijos as $key => $cfgObjetoFijo) {
            $response[$key] = array(
                'value' => $cfgObjetoFijo->getId(),
                'label' => $cfgObjetoFijo->getNombre(),
            );
        }
        return $helpers->json($response);
    }
}
