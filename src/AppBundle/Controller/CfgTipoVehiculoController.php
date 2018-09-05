<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CfgTipoVehiculo;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;use Symfony\Component\HttpFoundation\Request;

/**
 * Cfgtipovehiculo controller.
 *
 * @Route("cfgtipovehiculo")
 */
class CfgTipoVehiculoController extends Controller
{
    /**
     * Lists all cfgTipoVehiculo entities.
     *
     * @Route("/", name="cfgtipovehiculo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $estados = $em->getRepository('AppBundle:CfgTipoVehiculo')->findBy(
            array('activo' => true)
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
     * Creates a new cfgTipoVehiculo entity.
     *
     * @Route("/new", name="cfgtipovehiculo_new")
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

            $moduloId = $params->moduloId;
            $em = $this->getDoctrine()->getManager();
            $modulo = $em->getRepository('AppBundle:Modulo')->find($moduloId);

            $activo = new CfgTipoVehiculo();

            $activo->setNombre($params->nombre);
            $activo->setModulo($modulo);
            $activo->setActivo(true);

            $em->persist($activo);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con éxito",
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
     * Finds and displays a cfgTipoVehiculo entity.
     *
     * @Route("/show", name="cfgtipovehiculo_show")
     * @Method("POST")
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", true);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $json = $request->get("json", null);
            $params = json_decode($json);

            $cfgTipoVehiculo = $em->getRepository('AppBundle:CfgTipoVehiculo')->find($params->id);

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro enconrado con éxito.",
                'data' => $cfgTipoVehiculo,
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
     * Displays a form to edit an existing cfgTipoVehiculo entity.
     *
     * @Route("/edit", name="cfgtipovehiculo_edit")
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
            $activo = $em->getRepository("AppBundle:CfgTipoVehiculo")->find($params->id);

            if ($activo != null) {
                $activo->setNombre($params->nombre);

                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $activo,
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
     * Deletes a cfgTipoVehiculo entity.
     *
     * @Route("/delete", name="cfgtipovehiculo_delete")
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

            $tipo = $em->getRepository('AppBundle:CfgTipoVehiculo')->find($params->id);

            $tipo->setActivo(false);

            $em->persist($tipo);
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
     * Creates a form to delete a cfgTipoVehiculo entity.
     *
     * @param CfgTipoVehiculo $cfgTipoVehiculo The cfgTipoVehiculo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgTipoVehiculo $cfgTipoVehiculo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgtipovehiculo_delete', array('id' => $cfgTipoVehiculo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="cfgtipovehiculo_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $tipos = $em->getRepository('AppBundle:CfgTipoVehiculo')->findBy(
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
