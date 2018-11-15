<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgCalzadaCarril;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgcalzadacarril controller.
 *
 * @Route("svcfgcalzadacarril")
 */
class SvCfgCalzadaCarrilController extends Controller
{
    /**
     * Lists all svCfgCalzadaCarril entities.
     *
     * @Route("/", name="svcfgcalzadacarril_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $calzadas = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgCalzadaCarril')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($calzadas) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($calzadas) . " registros encontrados",
                'data' => $calzadas,
            );
        }
        return $helpers->json($response);

    }

    /**
     * Creates a new svCfgCalzadaCarril entity.
     *
     * @Route("/new", name="svcfgcalzadacarril_new")
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
            
            $calzada = new SvCfgCalzadaCarril();

            $em = $this->getDoctrine()->getManager();
            $nombre = strtoupper($params->nombre);
            $calzada->setNombre($nombre);
            $calzada->setActivo(true);
            $em->persist($calzada);
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
     * Finds and displays a svCfgCalzadaCarril entity.
     *
     * @Route("/{id}/show", name="svcfgcalzadacarril_show")
     * @Method("GET")
     */
    public function showAction(SvCfgCalzadaCarril $svCfgCalzadaCarril)
    {
        $deleteForm = $this->createDeleteForm($svCfgCalzadaCarril);
        return $this->render('svCfgCalzadaCarril/show.html.twig', array(
            'svCfgCalzadaCarril' => $svCfgCalzadaCarril,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing svCfgCalzadaCarril entity.
     *
     * @Route("/edit", name="svcfgcalzadacarril_edit")
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
            $calzada = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgCalzadaCarril')->find($params->id);

            if ($calzada != null) {
                $nombre = strtoupper($params->nombre);

                $calzada->setNombre($nombre);

                $em->persist($calzada);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $calzada,
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
     * Deletes a svCfgCalzadaCarril entity.
     *
     * @Route("/delete", name="svcfgcalzadacarril_delete")
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

            $calzada = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgCalzadaCarril')->find($params->id);

            $calzada->setActivo(false);

            $em->persist($calzada);
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
     * Creates a form to delete a SvCfgCalzadaCarril entity.
     *
     * @param SvCfgCalzadaCarril $svCfgcalzada The SvCfgCalzadaCarril entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgCalzadaCarril $svCfgCalzadaCarril)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svcfgcalzadacarril_delete', array('id' => $svCfgCalzadaCarril->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="calzada_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $calzadas = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgCalzadaCarril')->findBy(
        array('activo' => 1)
    );
        $response = null;
        foreach ($calzadas as $key => $calzada) {
        $response[$key] = array(
            'value' => $calzada->getId(),
            'label' => $calzada->getNombre(),
            );
      }
       return $helpers->json($response);
    }
}
