<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgFalla;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgfalla controller.
 *
 * @Route("svcfgfalla")
 */
class SvCfgFallaController extends Controller
{
    /**
     * Lists all svCfgFalla entities.
     *
     * @Route("/", name="svcfgfalla_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $fallas = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgFalla')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($fallas) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($fallas) . " registros encontrados",
                'data' => $fallas,
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a new svCfgFalla entity.
     *
     * @Route("/new", name="svcfgfalla_new")
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
            
            $falla = new SvCfgFalla();

            $em = $this->getDoctrine()->getManager();

            $falla->setNombre(strtoupper($params->nombre));
            $falla->setActivo(true);
            $em->persist($falla);
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
     * Finds and displays a svCfgFalla entity.
     *
     * @Route("/{id}/show", name="svcfgfalla_show")
     * @Method("GET")
     */
    public function showAction(SvCfgFalla $svCfgFalla)
    {
        
        $deleteForm = $this->createDeleteForm($svCfgFalla);
        return $this->render('svCfgFalla/show.html.twig', array(
            'svCfgFalla' => $svCfgFalla,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing SvCfgFalla entity.
     *
     * @Route("/edit", name="svcfgfalla_edit")
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
            $falla = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgFalla')->find($params->id);

            if ($falla != null) {
            
                $falla->setNombre(strtoupper($params->nombre));

                $em->persist($falla);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $falla,
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
     * Deletes a SvCfgFalla entity.
     *
     * @Route("/delete", name="svcfgfalla_delete")
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

            $falla = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgFalla')->find($params->id);

            $falla->setActivo(false);

            $em->persist($falla);
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
     * Creates a form to delete a SvCfgFalla entity.
     *
     * @param SvCfgFalla $svCfgFalla The SvCfgFalla entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgFalla $svCfgFalla)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('svcfgfalla_delete', array('id' => $svCfgFalla->getId())))
        ->setMethod('DELETE')
        ->getForm();
   }

    /**
     * datos para select 2
     *
     * @Route("/select", name="falla_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
       $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $fallas = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgFalla')->findBy(
            array('activo' => 1)
        );
        $response = null;

        foreach ($fallas as $key => $falla) {
            $response[$key] = array(
                'value' => $falla->getId(),
                'label' => $falla->getNombre(),
            );
        }
        return $helpers->json($response);

    }
}
