<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgGradoExamen;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfggradoexamen controller.
 *
 * @Route("svcfggradoexamen")
 */
class SvCfgGradoExamenController extends Controller
{
    /**
     * Lists all svCfgGradoExamen entities.
     *
     * @Route("/", name="svcfggradoexamen_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $gradosExamen = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgGradoExamen')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($gradosExamen) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($gradosExamen) . " registros encontrados",
                'data' => $gradosExamen,
            );
        }
        return $helpers->json($response);

    }

    /**
     * Creates a new svCfgGradoExamen entity.
     *
     * @Route("/new", name="svcfggradoexamen_new")
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
            
            $gradoExamen = new SvCfgGradoExamen();

            $em = $this->getDoctrine()->getManager();

            $gradoExamen->setNombre(strtoupper($params->nombre));
            $gradoExamen->setActivo(true);
            $em->persist($gradoExamen);
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
     * Finds and displays a svCfgGradoExamen entity.
     *
     * @Route("/{id}/show", name="svcfggradoexamen_show")
     * @Method("GET")
     */
    public function showAction(SvCfgGradoExamen $svCfgGradoExamen)
    {
        $deleteForm = $this->createDeleteForm($svCfgGradoExamen);
        return $this->render('svCfgGradoExamen/show.html.twig', array(
            'svCfgGradoExamen' => $svCfgGradoExamen,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing svCfgGradoExamen entity.
     *
     * @Route("/edit", name="svcfggradoexamen_edit")
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
            $gradoExamen = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgGradoExamen')->find($params->id);

            if ($gradoExamen != null) {
                $gradoExamen->setNombre(strtoupper($params->nombre));

                $em->persist($gradoExamen);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $gradoExamen,
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
     * Deletes a svCfgGradoExamen entity.
     *
     * @Route("/delete", name="svcfggradoexamen_delete")
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

            $gradoExamen = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgGradoExamen')->find($params->id);

            $gradoExamen->setActivo(false);

            $em->persist($gradoExamen);
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
     * Creates a form to delete a svCfgGradoExamen entity.
     *
     * @param SvCfgGradoExamen $svCfgGradoExamen The svCfgGradoExamen entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgGradoExamen $svCfgGradoExamen)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('svcfggradoexamen_delete', array('id' => $svCfgGradoExamen->getId())))
        ->setMethod('DELETE')
        ->getForm();
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="svcfggradoexamen_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $gradosExamen = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgGradoExamen')->findBy(
            array('activo' => 1)
        );
        $response = null;

        foreach ($gradosExamen as $key => $gradoExamen) {
            $response[$key] = array(
                'value' => $gradoExamen->getId(),
                'label' => $gradoExamen->getNombre(),
            );
        }
        return $helpers->json($response);
    }
}
