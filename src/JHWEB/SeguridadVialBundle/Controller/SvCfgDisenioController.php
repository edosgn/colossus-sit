<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgDisenio;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgdisenio controller.
 *
 * @Route("svcfgdisenio")
 */
class SvCfgDisenioController extends Controller
{
    /**
     * Lists all svCfgDisenio entities.
     *
     * @Route("/", name="svcfgdisenio_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $disenios = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgDisenio')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($disenios) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($disenios) . " registros encontrados",
                'data' => $disenios,
            );
        }
        return $helpers->json($response);

    }

    /**
     * Creates a new SvCfgDisenio entity.
     *
     * @Route("/new", name="svcfgdisenio_new")
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
            
            $disenio = new SvCfgDisenio();

            $em = $this->getDoctrine()->getManager();

            $disenio->setNombre(strtoupper($params->nombre));
            $disenio->setActivo(true);
            $em->persist($disenio);
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
     * Finds and displays a SvCfgDisenio entity.
     *
     * @Route("/{id}/show", name="svcfgdisenio_show")
     * @Method("GET")
     */
    public function showAction(SvCfgDisenio $svCfgDisenio)
    {
        $deleteForm = $this->createDeleteForm($svCfgDisenio);
        return $this->render('svCfgDisenio/show.html.twig', array(
            'svCfgDisenio' => $svCfgDisenio,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing SvCfgDisenio entity.
     *
     * @Route("/edit", name="svcfgdisenio_edit")
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
            $disenio = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgDisenio')->find($params->id);

            if ($disenio != null) {

                $disenio->setNombre(strtoupper($params->nombre));

                $em->persist($disenio);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $disenio,
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
     * Deletes a SvCfg<Disenio entity.
     *
     * @Route("/delete", name="svcfgdisenio_delete")
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

            $disenio = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgDisenio')->find($params->id);

            $disenio->setActivo(false);

            $em->persist($disenio);
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
     * Creates a form to delete a SvCfgDisenio entity.
     *
     * @param SvCfgDisenio $SvCfgDisenio The SvCfgDisenio entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgDisenio $SvCfgDisenio)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('Svcfgdisenio_delete', array('id' => $SvCfgDisenio->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="svcfgdisenio_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $disenios = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgDisenio')->findBy(
        array('activo' => 1)
    );
    $response = null;

      foreach ($disenios as $key => $disenio) {
        $response[$key] = array(
            'value' => $disenio->getId(),
            'label' => $disenio->getNombre(),
            );
      }
       return $helpers->json($response);
    }
}
