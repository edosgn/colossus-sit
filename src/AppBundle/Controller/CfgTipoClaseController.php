<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CfgTipoClase;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Cfgtipoclase controller.
 *
 * @Route("cfgtipoclase")
 */
class CfgTipoClaseController extends Controller
{
    /**
     * Lists all cfgTipoClase entities.
     *
     * @Route("/", name="cfgtipoclase_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $estados = $em->getRepository('AppBundle:CfgTipoClase')->findBy(
            array('estado' => true)
        );

        $response['data'] = array();

        if ($estados) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($estados) . " registros encontrados",
                'data' => $estados,
            );
        }
        return $helpers->json($response);

    }

    /**
     * Creates a new cfgComparendoEstado entity.
     *
     * @Route("/new", name="cfgcomparendoestado_new")
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

            $tipoId = $params->tipoId;
            $claseId = $params->claseId;

            $em = $this->getDoctrine()->getManager();

            $tipo = $em->getRepository('AppBundle:CfgTipoVehiculo')->find($tipoId);
            $clase = $em->getRepository('AppBundle:Clase')->find($claseId);
            $estado = new CfgTipoClase();

            $estado->setTipoVehiculo($tipo);
            $estado->setClase($clase);
            $estado->setEstado(true);

            $em->persist($estado);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con exito",
            );
            //}
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
     * Finds and displays a cfgTipoClase entity.
     *
     * @Route("/{id}", name="cfgtipoclase_show")
     * @Method("GET")
     */
    public function showAction(CfgTipoClase $cfgTipoClase)
    {

        return $this->render('cfgtipoclase/show.html.twig', array(
            'cfgTipoClase' => $cfgTipoClase,
        ));
    }

    /**
     * Displays a form to edit an existing cfgAsignacionPlacaSede entity.
     *
     * @Route("/edit", name="cfgasignacionplacasede_edit")
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
            $tipo = $em->getRepository('AppBundle:CfgTipoClase')->find($params->id);

            $tipoVehiculo = $em->getRepository('AppBundle:CfgTipoVehiculo')->find($params->tipoVehiculo);
            $clase = $em->getRepository('AppBundle:Clase')->find($params->clase);
            if ($tipo != null) {
                $tipo->setTipoVehiculo($tipoVehiculo);
                $tipo->setClase($clase);

                $em->persist($tipo);
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
     * Deletes a cfgTipoClase entity.
     *
     * @Route("/delete", name="cfgtipoclase_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", true);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $json = $request->get("json", null);
            $params = json_decode($json);

            $cfgTipoClase = $em->getRepository('AppBundle:CfgTipoClase')->find($params->id);

            $cfgTipoClase->setEstado(false);

            $em->persist($cfgTipoClase);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro eliminado con éxito.",
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no válida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a cfgTipoClase entity.
     *
     * @param CfgTipoClase $cfgTipoClase The cfgTipoClase entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgTipoClase $cfgTipoClase)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgtipoclase_delete', array('id' => $cfgTipoClase->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

}
