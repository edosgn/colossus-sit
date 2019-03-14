<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgFuncion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * Svcfgfuncion controller.
 *
 * @Route("svcfgfuncion")
 */
class SvCfgFuncionController extends Controller
{
    /**
     * Lists all svCfgFuncion entities.
     *
     * @Route("/", name="svcfgfuncion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $funciones = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgFuncion')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($funciones) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($funciones) . " registros encontrados",
                'data' => $funciones,
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a new svCfgFuncion entity.
     *
     * @Route("/new", name="svcfgfuncion_new")
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
            
            $funcion = new SvCfgFuncion();

            $em = $this->getDoctrine()->getManager();

            $funcion->setNombre(strtoupper($params->nombre));
            $funcion->setActivo(true);
            $em->persist($funcion);
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
     * Finds and displays a svCfgFuncion entity.
     *
     * @Route("/{id}/show", name="svcfgfuncion_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(SvCfgFuncion $svCfgFuncion)
    {
        $deleteForm = $this->createDeleteForm($svCfgFuncion);
        return $this->render('svCfgFuncion/show.html.twig', array(
            'svCfgFuncion' => $svCfgFuncion,
            'delete_form' => $deleteForm->createView(),
        ));

    }

    /**
     * Displays a form to edit an existing SvCfgFuncion entity.
     *
     * @Route("/edit", name="svcfgfuncion_edit")
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
            $funcion = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgFuncion')->find($params->id);

            if ($funcion != null) {
                $funcion->setNombre(strtoupper($params->nombre));

                $em->persist($funcion);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $funcion,
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
     * Deletes a svCfgFuncion entity.
     *
     * @Route("/delete", name="svcfgfuncion_delete")
     * @Method({"GET", "POST"})
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

            $funcion = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgFuncion')->find($params->id);

            $funcion->setActivo(false);

            $em->persist($funcion);
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
     * Creates a form to delete a SvCfgFuncion entity.
     *
     * @param SvCfgFuncion $svCfgFuncion The SvCfgFuncion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgFuncion $svCfgFuncion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svCfgFuncion_delete', array('id' => $svCfgFuncion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="funcion_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $funciones = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgFuncion')->findBy(
        array('activo' => 1)
    );
    $response = null;

      foreach ($funciones as $key => $funcion) {
        $response[$key] = array(
            'value' => $funcion->getId(),
            'label' => $funcion->getNombre(),
            );
      }
       return $helpers->json($response);
    }
}
