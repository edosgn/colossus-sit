<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgEstadoConductor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgestadoconductor controller.
 *
 * @Route("svcfgestadoconductor")
 */
class SvCfgEstadoConductorController extends Controller
{
    /**
     * Lists all SvCfgEstadoConductor entities.
     *
     * @Route("/", name="svcfgestadoconductor_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $estadosConductor = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgEstadoConductor')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($estadosConductor) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($estadosConductor) . " registros encontrados",
                'data' => $estadosConductor,
            );
        }
        return $helpers->json($response);

    }

    /**
     * Creates a new SvCfgEstadoConductor entity.
     *
     * @Route("/new", name="svcfgestadoconductor_new")
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
            
            $estadoConductor = new SvCfgEstadoConductor();

            $em = $this->getDoctrine()->getManager();

            $estadoConductor->setNombre(strtoupper($params->nombre));
            $estadoConductor->setActivo(true);
            $em->persist($estadoConductor);
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
     * Finds and displays a SvCfgEstadoConductor entity.
     *
     * @Route("/{id}/show", name="svcfgestadoconductor_show")
     * @Method("GET")
     */
    public function showAction(SvCfgEstadoConductor $svCfgEstadoConductor)
    {
        $deleteForm = $this->createDeleteForm($svCfgEstadoConductor);
        return $this->render('svCfgEstadoConductor/show.html.twig', array(
            'svCfgEstadoConductor' => $svCfgEstadoConductor,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing SvCfgEstadoConductor entity.
     *
     * @Route("/edit", name="svcfgestadoconductor_edit")
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
            $estadoConductor = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgEstadoConductor')->find($params->id);

            if ($estadoConductor != null) {

                $estadoConductor->setNombre(strtoupper($params->nombre));

                $em->persist($estadoConductor);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $estadoConductor,
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
     * Deletes a SvCfgEstadoConductor entity.
     *
     * @Route("/delete", name="svcfgestadoconductor_delete")
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

            $estadoConductor = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgEstadoConductor')->find($params->id);

            $estadoConductor->setActivo(false);

            $em->persist($estadoConductor);
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
     * Creates a form to delete a SvCfgEstadoConductor entity.
     *
     * @param SvCfgEstadoConductor $svCfgEstadoConductor The svCfgEstadoConductor entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgEstadoConductor $svCfgEstadoConductor)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svcfgestadoconductor_delete', array('id' => $svCfgEstadoConductor->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="svcfgestadoconductor_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $estadosConductor = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgEstadoConductor')->findBy(
        array('activo' => 1)
    );
    $response = null;

      foreach ($estadosConductor as $key => $estadoConductor) {
        $response[$key] = array(
            'value' => $estadoConductor->getId(),
            'label' => $estadoConductor->getNombre(),
            );
      }
       return $helpers->json($response);
    }
}
