<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MsvCriterio;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Msvcriterio controller.
 *
 * @Route("msvcriterio")
 */
class MsvCriterioController extends Controller
{
    /**
     * Lists all msvCriterio entities.
     *
     * @Route("/", name="msvcriterio_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $criterios = $em->getRepository('AppBundle:MsvCriterio')->findBy(array('estado' => true));

        $response['data'] = array();

        if ($criterios) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($criterios) . " registros encontrados",
                'data' => $criterios,
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a new msvCriterio entity.
     *
     * @Route("/new", name="msvcriterio_new")
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
            
            $criterio = new MsvCriterio();

            $em = $this->getDoctrine()->getManager();
            if ($params->idVariable) {
                $idVariable = $em->getRepository('AppBundle:MsvVariable')->find(
                    $params->idVariable
                );
                $criterio->setVariable($idVariable);
            }

            $criterio->setNombre(strtoupper($params->nombre));
            $criterio->setEstado(true);
            $em->persist($criterio);
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
     * Finds and displays a msvCriterio entity.
     *
     * @Route("/{id}/show", name="msvcriterio_show")
     * @Method("GET")
     */
    public function showAction(MsvCriterio $msvCriterio)
    {
        $deleteForm = $this->createDeleteForm($msvCriterio);

        return $this->render('msvcriterio/show.html.twig', array(
            'msvCriterio' => $msvCriterio,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing msvCriterio entity.
     *
     * @Route("/edit", name="msvcriterio_edit")
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
            $criterio = $em->getRepository('AppBundle:MsvCriterio')->find($params->id);

            $variable = $em->getRepository('AppBundle:MsvVariable')->find($params->idVariable);
            if ($criterio != null) {

                $criterio->setNombre(strtoupper($params->nombre));
                $criterio->setVariable($variable);

                $em->persist($criterio);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $criterio,
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
     * Deletes a msvCriterio entity.
     *
     * @Route("/delete", name="msvcriterio_delete")
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

            $criterio = $em->getRepository('AppBundle:MsvCriterio')->find($params->id);

            $criterio->setEstado(false);

            $em->persist($criterio);
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
     * Creates a form to delete a msvCriterio entity.
     *
     * @param MsvCriterio $msvCriterio The msvCriterio entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MsvCriterio $msvCriterio)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('msvcriterio_delete', array('id' => $msvCriterio->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
