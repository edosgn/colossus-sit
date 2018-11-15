<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgEntidadAccidente;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgentidadaccidente controller.
 *
 * @Route("svcfgentidadaccidente")
 */
class SvCfgEntidadAccidenteController extends Controller
{
    /**
     * Lists all svCfgEntidadAccidente entities.
     *
     * @Route("/", name="svcfgentidadaccidente_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $entidadesAccidente = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgEntidadAccidente')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($entidadesAccidente) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($entidadesAccidente) . " registros encontrados",
                'data' => $entidadesAccidente,
            );
        }
        return $helpers->json($response);

    }

    /**
     * Creates a new SvCfgEntidadAccidente entity.
     *
     * @Route("/new", name="svcfgentidadaccidente_new")
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
            
            $entidadAccidente = new SvCfgEntidadAccidente();

            $em = $this->getDoctrine()->getManager();

            $nombre = strtoupper($params->nombre);

            $entidadAccidente->setNombre($nombre);
            $entidadAccidente->setActivo(true);
            $em->persist($entidadAccidente);
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
     * Finds and displays a SvCfgEntidadAccidente entity.
     *
     * @Route("/{id}/show", name="svcfgentidadaccidente_show")
     * @Method("GET")
     */
    public function showAction(SvCfgEntidadAccidente $svCfgEntidadAccidente)
    {
        $deleteForm = $this->createDeleteForm($svCfgEntidadAccidente);
        return $this->render('svCfgEntidadAccidente/show.html.twig', array(
            'svCfgEntidadAccidente' => $svCfgEntidadAccidente,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing SvCfgEntidadAccidente entity.
     *
     * @Route("/edit", name="svcfgentidadaccidente_edit")
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
            $entidadAccidente = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgEntidadAccidente')->find($params->id);

            if ($entidadAccidente != null) {
                $entidadAccidente->setNombre($params->nombre);

                $em->persist($entidadAccidente);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $entidadAccidente,
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
     * Deletes a SvCfgEntidadAccidente entity.
     *
     * @Route("/delete", name="svcfgentidadaccidente_delete")
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

            $entidadAccidente = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgEntidadAccidente')->find($params->id);

            $entidadAccidente->setActivo(false);

            $em->persist($entidadAccidente);
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
     * Creates a form to delete a SvCfgEntidadAccidente entity.
     *
     * @param SvCfgEntidadAccidente $SvCfgEntidadAccidente The SvCfgEntidadAccidente entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgEntidadAccidente $SvCfgEntidadAccidente)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svcfgentidadaccidente_delete', array('id' => $SvCfgEntidadAccidente->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="svcfgentidadaccidente_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $entidadesAccidente = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgEntidadAccidente')->findBy(
        array('activo' => 1)
    );
    $response = null;

      foreach ($entidadesAccidente as $key => $entidadAccidente) {
        $response[$key] = array(
            'value' => $entidadAccidente->getId(),
            'label' => $entidadAccidente->getNombre(),
            );
      }
       return $helpers->json($response);
    }
}
