<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgFuncionCriterio;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * Svcfgfuncioncriterio controller.
 *
 * @Route("svcfgfuncioncriterio")
 */
class SvCfgFuncionCriterioController extends Controller
{
    /**
     * Lists all svCfgFuncionCriterio entities.
     *
     * @Route("/", name="svcfgfuncioncriterio_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $funcionCriterio = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgFuncionCriterio')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($funcionCriterio) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($funcionCriterio) . " registros encontrados",
                'data' => $funcionCriterio,
            );
        }
        return $helpers->json($response);

    }

    /**
     * Creates a new svCfgFuncionCriterio entity.
     *
     * @Route("/new", name="svcfgfuncioncriterio_new")
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
            
            $funcionCriterio = new SvCfgFuncionCriterio();

            $em = $this->getDoctrine()->getManager();
            if ($params->funcionId) {
                $funcion = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgFuncion')->find(
                    $params->funcionId
                );
                $funcionCriterio->setFuncion($funcion);
            }

            $funcionCriterio->setNombre($params->nombre);
            $funcionCriterio->setActivo(true);
            $em->persist($funcionCriterio);
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
     * Finds and displays a svCfgFuncionCriterio entity.
     *
     * @Route("/{id}/show", name="svcfgfuncioncriterio_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(SvCfgFuncionCriterio $svCfgFuncionCriterio)
    {
        $deleteForm = $this->createDeleteForm($svCfgFuncionCriterio);
        return $this->render('svCfgFuncionCriterio/show.html.twig', array(
            'svCfgFuncionCriterio' => $svCfgFuncionCriterio,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing SvCfgFuncionCriterio entity.
     *
     * @Route("/edit", name="svcfgfuncioncriterio_edit")
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
            $funcionCriterio = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgFuncionCriterio')->find($params->id);

            $funcion = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgFuncion')->find($params->funcion);
            if ($funcionCriterio != null) {
                $funcionCriterio->setNombre($params->nombre);
                $funcionCriterio->setFuncion($funcion);

                $em->persist($funcionCriterio);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $funcionCriterio,
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
     * Deletes a svCfgFuncionCriterio entity.
     *
     * @Route("/delete", name="svcfgfuncioncriterio_delete")
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

            $funcionCriterio = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgFuncionCriterio')->find($params->id);

            $funcionCriterio->setActivo(false);

            $em->persist($funcionCriterio);
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
     * Creates a form to delete a SvCfgFuncionCriterio entity.
     *
     * @param SvCfgFuncionCriterio $svCfgFuncionCriterio The svCfgFuncionCriterio entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgFuncionCriterio $svCfgFuncionCriterio)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svcfgfuncioncriterio_delete', array('id' => $svCfgFuncionCriterio->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

     /**
     * datos para select 2
     *
     * @Route("/select", name="funcioncriterio_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $criterios = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgFuncionCriterio')->findBy(
        array('activo' => 1)
    );
      foreach ($criterios as $key => $criterio) {
        $response[$key] = array(
            'value' => $criterio->getId(),
            'label' => $criterio->getNombre(),
            );
      }
       return $helpers->json($response);
    }


}
