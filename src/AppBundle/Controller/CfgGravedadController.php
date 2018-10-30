<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CfgGravedad;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;use Symfony\Component\HttpFoundation\Request;

/**
 * Cfggravedad controller.
 *
 * @Route("cfggravedad")
 */
class CfgGravedadController extends Controller
{
    /**
     * Lists all cfgGravedad entities.
     *
     * @Route("/", name="cfggravedad_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $cfgGravedades = $em->getRepository('AppBundle:CfgGravedad')->findBy(
            array('estado' => 1)
        );
        $response = array(
            'status' => 'success',
            'code' => 200,
            'msj' => "listado gravedad",
            'data' => $cfgGravedades,
        );

        return $helpers->json($response);

    }

    /**
     * Creates a new cfgGravedad entity.
     *
     * @Route("/new", name="cfggravedad_new")
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
            $cfgGravedad = $em->getRepository('AppBundle:CfgGravedad')->findOneByNombre($params->nombre);

            if ($cfgGravedad == null) {
                $cfgGravedad = new CfgGravedad();

                $cfgGravedad->setNombre(strtoupper($nombre));
                $cfgGravedad->setEstado(true);

                $em->persist($cfgGravedad);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Gravedad creado con exito",
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El nombre de la gravedad ya se encuentra registrada",
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
     * Finds and displays a cfgGravedad entity.
     *
     * @Route("/show/{id}", name="cfggravedad_show")
     * @Method("POST")
     */
    public function showAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $cfgGravedad = $em->getRepository('AppBundle:CfgGravedad')->find($id);
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "Gravedad encontrado",
                'data' => $cfgGravedad,
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
     * Displays a form to edit an existing cfgGravedad entity.
     *
     * @Route("/edit", name="cfggravedad_edit")
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
            $cfgGravedad = $em->getRepository('AppBundle:CfgGravedad')->find($params->id);
            if ($cfgGravedad != null) {

                $cfgGravedad->setNombre($nombre);
                $cfgGravedad->setEstado(true);

                $em = $this->getDoctrine()->getManager();
                $em->persist($cfgGravedad);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "gravedad editada con exito",
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "La gravedad no se encuentra en la base de datos",
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
     * Deletes a cfgGravedad entity.
     *
     * @Route("/{id}/delete", name="cfggravedad_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $cfgGravedad = $em->getRepository('AppBundle:CfgGravedad')->find($id);

            $cfgGravedad->setEstado(0);
            $em = $this->getDoctrine()->getManager();
            $em->persist($cfgGravedad);
            $em->flush();
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "gravedad eliminado con exito",
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
     * Creates a form to delete a cfgGravedad entity.
     *
     * @param CfgGravedad $cfgGravedad The cfgGravedad entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgGravedad $cfgGravedad)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfggravedad_delete', array('id' => $cfgGravedad->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

        /**
     * datos para select 2
     *
     * @Route("/select", name="cfggravedad_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");

    $em = $this->getDoctrine()->getManager();
    $cfgGravedades = $em->getRepository('AppBundle:CfgGravedad')->findBy(
        array('estado' => 1)
    );

    $response = null;
    
    foreach ($cfgGravedades as $key => $cfgGravedad) {
        $response[$key] = array(
            'value' => $cfgGravedad->getNombre(),
            'label' => $cfgGravedad->getNombre(),
        );
      }
       return $helpers->json($response);
    }
}
