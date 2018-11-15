<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgGravedadVictima;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfggravedadvictima controller.
 *
 * @Route("svcfggravedadvictima")
 */
class SvCfgGravedadVictimaController extends Controller
{
    /**
     * Lists all svCfgGravedadVictima entities.
     *
     * @Route("/", name="svcfggravedadvictima_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $gravedadesVictima = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgGravedadVictima')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($gravedadesVictima) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($gravedadesVictima) . " registros encontrados",
                'data' => $gravedadesVictima,
            );
        }
        return $helpers->json($response);

    }

    /**
     * Creates a new svCfgGravedadVictima entity.
     *
     * @Route("/new", name="svcfggravedadvictima_new")
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
            
            $gravedadVictima = new SvCfgGravedadVictima();

            $em = $this->getDoctrine()->getManager();

            $nombre = strtoupper($params->nombre);

            $gravedadVictima->setNombre($nombre);
            $gravedadVictima->setActivo(true);
            $em->persist($gravedadVictima);
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
     * Finds and displays a svCfgGravedadVictima entity.
     *
     * @Route("/{id}/show", name="svcfggravedadvictima_show")
     * @Method("GET")
     */
    public function showAction(SvCfgGravedadVictima $svCfgGravedadVictima)
    {
        $deleteForm = $this->createDeleteForm($svCfgGravedadVictima);
        return $this->render('svCfgGravedadVictima/show.html.twig', array(
            'svCfgGravedadVictima' => $svCfgGravedadVictima,
            'delete_form' => $deleteForm->createView(),
        ));

    }

    /**
     * Displays a form to edit an existing svCfgGravedadVictima entity.
     *
     * @Route("/edit", name="svcfggravedadvictima_edit")
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
            $gravedadVictima = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgGravedadVictima')->find($params->id);

            if ($gravedadVictima != null) {
                $nombre = strtoupper($params->nombre);

                $gravedadVictima->setNombre($nombre);

                $em->persist($gravedadVictima);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $gravedadVictima,
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
     * Deletes a svCfgGravedadVictima entity.
     *
     * @Route("/delete", name="svcfggravedadvictima_delete")
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

            $gravedadVictima = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgGravedadVictima')->find($params->id);

            $gravedadVictima->setActivo(false);

            $em->persist($gravedadVictima);
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
     * Creates a form to delete a svCfgGravedadVictima entity.
     *
     * @param SvCfgGravedadVictima $svCfgGravedadVictima The svCfgGravedadVictima entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgGravedadVictima $svCfgGravedadVictima)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('svcfggravedadvictima_delete', array('id' => $svCfgGravedadVictima->getId())))
        ->setMethod('DELETE')
        ->getForm();
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="gravedadvictima_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $gravedadesVictima = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgGravedadVictima')->findBy(
            array('activo' => 1)
        );
        $response = null;

        foreach ($gravedadesVictima as $key => $gravedadVictima) {
            $response[$key] = array(
                'value' => $gravedadVictima->getId(),
                'label' => $gravedadVictima->getNombre(),
            );
        }
        return $helpers->json($response);
    }
}
