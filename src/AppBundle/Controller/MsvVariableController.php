<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MsvVariable;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Msvvariable controller.
 *
 * @Route("msvvariable")
 */
class MsvVariableController extends Controller
{
    /**
     * Lists all msvVariable entities.
     *
     * @Route("/", name="msvvariable_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $msvVariable = $em->getRepository('AppBundle:MsvVariable')->findBy( array('estado' => 1));

        $response = array(
                    'status' => 'succes',
                    'code' => 200,
                    'msj' => "listado festivos",
                    'data' => $msvVariable,
        );

        return $helpers ->json($response);
    }

    /**
     * Creates a new msvVariable entity.
     *
     * @Route("/new", name="msvvariable_new")
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
            
            $variable = new MsvVariable();

            $em = $this->getDoctrine()->getManager();

            $nombre = strtoupper($params->nombre);

            $variable->setNombre($nombre);

            $parametro = $em->getRepository('AppBundle:MsvParametro')->find($params->idParametro);
            $variable->setParametro($parametro);
            $variable->setEstado(true);
            $em->persist($variable);
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
     * Finds and displays a msvVariable entity.
     *
     * @Route("/{id}/show", name="msvvariable_show")
     * @Method("GET")
     */
    public function showAction(MsvVariable $msvVariable)
    {
        $deleteForm = $this->createDeleteForm($msvVariable);

        return $this->render('msvvariable/show.html.twig', array(
            'msvVariable' => $msvVariable,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing msvVariable entity.
     *
     * @Route("/edit", name="msvvariable_edit")
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
            $variable = $em->getRepository('AppBundle:MsvVariable')->find($params->id);

            if ($variable != null) {
                $nombre = strtoupper($params->nombre);

                $variable->setNombre($nombre);
                $parametro = $em->getRepository('AppBundle:MsvParametro')->find($params->idParametro);
                $variable->setParametro($parametro);
                $em->persist($variable);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $variable,
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
     * Deletes a msvVariable entity.
     *
     * @Route("/delete", name="msvvariable_delete")
     * @Method({"GET","POST"})
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

            $variable = $em->getRepository('AppBundle:MsvVariable')->find($params->id);

            $variable->setEstado(false);

            $em->persist($variable);
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
     * Creates a form to delete a msvVariable entity.
     *
     * @param MsvVariable $msvVariable The msvVariable entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MsvVariable $msvVariable)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('msvvariable_delete', array('id' => $msvVariable->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="variable_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $variables = $em->getRepository('AppBundle:MsvVariable')->findBy(
        array('estado' => 1)
    );
    $response = null;

      foreach ($variables as $key => $variable) {
        $response[$key] = array(
            'value' => $variable->getId(),
            'label' => $variable->getNombre(),
            );
      }
       return $helpers->json($response);
    }
}
