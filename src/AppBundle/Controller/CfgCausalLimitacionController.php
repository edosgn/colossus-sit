<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CfgCausalLimitacion;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;use Symfony\Component\HttpFoundation\Request;

/**
 * Cfgcausallimitacion controller.
 *
 * @Route("cfgCausalLimitacion")
 */
class CfgCausalLimitacionController extends Controller
{
    /**
     * Lists all cfgCausalLimitacion entities.
     *
     * @Route("/", name="cfgcausallimitacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $response = null;
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $cfgCausalLimitacion = $em->getRepository('AppBundle:CfgCausalLimitacion')->findBy(
            array('activo' => 1)
        );

        $response = array(
            'status' => 'success',
            'code' => 200,
            'msj' => "listado causales limitaciones",
            'data' => $cfgCausalLimitacion,
        );

        return $helpers->json($response);

    }

    /**
     * Creates a new cfgCausalLimitacion entity.
     *
     * @Route("/new", name="cfgcausallimitacion_new")
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
            $cfgCausalLimitacion = $em->getRepository('AppBundle:CfgCausalLimitacion')->findOneByNombre($params->nombre);

            if ($cfgCausalLimitacion == null) {
                $cfgCausalLimitacion = new CfgCausalLimitacion();

                $cfgCausalLimitacion->setNombre(strtoupper($nombre));
                $cfgCausalLimitacion->setActivo(true);

                $em->persist($cfgCausalLimitacion);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Causal limitacion creado con exito",
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El nombre del causal limitacion ya se encuentra registrado",
                );
            }
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida",
            );
        }
        return $helpers->json($response);

    }

    /**
     * Finds and displays a cfgCausalLimitacion entity.
     *
     * @Route("/show/{id}", name="cfgcausallimitacion_show")
     * @Method("GET")
     */
    public function showAction(CfgCausalLimitacion $cfgCausalLimitacion)
    {
        $deleteForm = $this->createDeleteForm($cfgCausalLimitacion);

        return $this->render('cfgcausallimitacion/show.html.twig', array(
            'cfgCausalLimitacion' => $cfgCausalLimitacion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cfgCausalLimitacion entity.
     *
     * @Route("/edit", name="cfgcausallimitacion_edit")
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
            $cfgCausalLimitacion = $em->getRepository('AppBundle:CfgCausalLimitacion')->find($params->id);
            if ($cfgCausalLimitacion != null) {
                $cfgCausalLimitacion->setNombre($nombre);
                $cfgCausalLimitacion->setActivo(true);
                $em->persist($cfgCausalLimitacion);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Causal de limitación editada con exito",
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El causal de limitación no se encuentra en la base de datos",
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
     * Deletes a cfgCausalLimitacion entity.
     *
     * @Route("/{id}/delete", name="cfgcausallimitacion_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $cfgCausalLimitacion = $em->getRepository('AppBundle:CfgCausalLimitacion')->find($id);
            $cfgCausalLimitacion->setActivo(0);
            $em = $this->getDoctrine()->getManager();
            $em->persist($cfgCausalLimitacion);
            $em->flush();
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "Causal de limitación eliminada con exito",
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
     * Creates a form to delete a cfgCausalLimitacion entity.
     *
     * @param CfgCausalLimitacion $cfgCausalLimitacion The cfgCausalLimitacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgCausalLimitacion $cfgCausalLimitacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgcausallimitacion_delete', array('id' => $cfgCausalLimitacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select
     *
     * @Route("/select", name="cfgcausallimitacion_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $response = null;
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $cfgCausalesLimitaciones = $em->getRepository('AppBundle:CfgCausalLimitacion')->findBy(
            array('activo' => 1)
        );
        foreach ($cfgCausalesLimitaciones as $key => $cfgCausalLimitacion) {
            $response[$key] = array(
                'value' => $cfgCausalLimitacion->getId(),
                'label' => $cfgCausalLimitacion->getNombre(),
            );
        }
        return $helpers->json($response);
    }
}
