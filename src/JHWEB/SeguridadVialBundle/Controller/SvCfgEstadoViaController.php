<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgEstadoVia;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * Svcfgestadovium controller.
 *
 * @Route("svcfgestadovia")
 */
class SvCfgEstadoViaController extends Controller
{
    /**
     * Lists all svCfgEstadoVia entities.
     *
     * @Route("/", name="svcfgestadovia_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $estadosVia = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgEstadoVia')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($estadosVia) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($estadosVia) . " registros encontrados",
                'data' => $estadosVia,
            );
        }
        return $helpers->json($response);

    }

    /**
     * Creates a new svCfgEstadoVia entity.
     *
     * @Route("/new", name="svcfgestadovia_new")
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
            
            $estadoVia = new SvCfgEstadoVia();

            $em = $this->getDoctrine()->getManager();

            $estadoVia->setNombre($params->nombre);
            $estadoVia->setActivo(true);
            $em->persist($estadoVia);
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
     * Finds and displays a svCfgEstadoVia entity.
     *
     * @Route("/{id}/show", name="svcfgestadovia_show")
     * @Method("GET")
     */
    public function showAction(SvCfgEstadoVia $svCfgEstadoVia)
    {
        $deleteForm = $this->createDeleteForm($svCfgEstadoVia);
        return $this->render('svCfgEstadoVia/show.html.twig', array(
            'svCfgEstadoVia' => $svCfgEstadoVia,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing svCfgEstadoVia entity.
     *
     * @Route("/edit", name="svcfgestadovia_edit")
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
            $estadoVia = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgEstadoVia')->find($params->id);

            if ($estadoVia != null) {
                $estadoVia->setNombre($params->nombre);

                $em->persist($estadoVia);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $estadoVia,
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
     * Deletes a svCfgEstadoVia entity.
     *
     * @Route("/delete", name="svcfgestadovia_delete")
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

            $estadoVia = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgEstadoVia')->find($params->id);

            $estadoVia->setActivo(false);

            $em->persist($estadoVia);
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
     * Creates a form to delete a svCfgEstadoVia entity.
     *
     * @param SvCfgEstadoVia $svCfgEstadoVia The svCfgEstadoVia entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgEstadoVia $svCfgEstadoVia)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svcfgestadovia_delete', array('id' => $svCfgEstadoVia->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="svcfgestadoVia_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $estadosVia = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgEstadoVia')->findBy(
        array('activo' => 1)
    );
    $response = null;

      foreach ($estadosVia as $key => $estadoVia) {
        $response[$key] = array(
            'value' => $estadoVia->getId(),
            'label' => $estadoVia->getNombre(),
            );
      }
       return $helpers->json($response);
    }
}
