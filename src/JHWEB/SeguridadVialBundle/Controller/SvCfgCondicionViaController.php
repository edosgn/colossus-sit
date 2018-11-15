<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgCondicionVia;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgcondicionvium controller.
 *
 * @Route("svcfgcondicionvia")
 */
class SvCfgCondicionViaController extends Controller
{
    /**
     * Lists all svCfgCondicionVia entities.
     *
     * @Route("/", name="svcfgcondicionvia_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $condiciones = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgCondicionVia')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($condiciones) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($condiciones) . " registros encontrados",
                'data' => $condiciones,
            );
        }
        return $helpers->json($response);

    }

    /**
     * Creates a new svCfgCondicionVia entity.
     *
     * @Route("/new", name="svcfgcondicionvia_new")
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
            
            $condicionVia = new SvCfgCondicionVia();

            $em = $this->getDoctrine()->getManager();

            $nombre = strtoupper($params->nombre);

            $condicionVia->setNombre($nombre);
            $condicionVia->setActivo(true);
            $em->persist($condicionVia);
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
     * Finds and displays a svCfgCondicionVia entity.
     *
     * @Route("/{id}/show", name="svcfgcondicionvia_show")
     * @Method("GET")
     */
    public function showAction(SvCfgCondicionVia $svCfgCondicionVia)
    {
        $deleteForm = $this->createDeleteForm($svCfgCondicionVia);
        return $this->render('svCfgCondicionVia/show.html.twig', array(
            'svCfgCondicionVia' => $svCfgCondicionVia,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing svCfgCondicionVia entity.
     *
     * @Route("/edit", name="svcfgcondicionvia_edit")
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
            $condicionVia = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgCondicionVia')->find($params->id);

            if ($condicionVia != null) {
                $nombre = strtoupper($params->nombre);

                $condicionVia->setNombre($nombre);

                $em->persist($condicionVia);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $condicionVia,
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
     * Deletes a SvCfgCondicionVia entity.
     *
     * @Route("/delete", name="svcfgcondicionvia_delete")
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

            $condicionVia = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgCondicionVia')->find($params->id);

            $condicionVia->setActivo(false);

            $em->persist($condicionVia);
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
     * Creates a form to delete a SvCfgCondicionVia entity.
     *
     * @param SvCfgCondicionVia $svCfgCondicionVia The SvCfgCondicionVia entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgCondicionVia $svCfgCondicionVia)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svcfgcondicionvia_delete', array('id' => $svCfgCondicionVia->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="svcfgcondicionvia_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $condiciones = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgCondicionVia')->findBy(
        array('activo' => 1)
    );
        $response = null;

      foreach ($condiciones as $key => $condicionVia) {
        $response[$key] = array(
            'value' => $condicionVia->getId(),
            'label' => $condicionVia->getNombre(),
            );
      }
       return $helpers->json($response);
    }
}
