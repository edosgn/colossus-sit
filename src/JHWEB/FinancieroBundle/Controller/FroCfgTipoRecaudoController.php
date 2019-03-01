<?php

namespace JHWEB\FinancieroBundle\Controller;

use JHWEB\FinancieroBundle\Entity\FroCfgTipoRecaudo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Frocfgtiporecaudo controller.
 *
 * @Route("frocfgtiporecaudo")
 */
class FroCfgTipoRecaudoController extends Controller
{
    /**
     * Lists all froCfgTipoRecaudo entities.
     *
     * @Route("/", name="frocfgtiporecaudo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $tiposRecaudo = $em->getRepository('JHWEBFinancieroBundle:FroCfgTipoRecaudo')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($tiposRecaudo) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($tiposRecaudo) . " registros encontrados",
                'data' => $tiposRecaudo,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Finds and displays a froCfgTipoRecaudo entity.
     *
     * @Route("/{id}/show", name="frocfgtiporecaudo_show")
     * @Method("GET")
     */
    public function showAction(FroCfgTipoRecaudo $froCfgTipoRecaudo)
    {
        $deleteForm = $this->createDeleteForm($froCfgTipoRecaudo);
        return $this->render('froCfgTipoRecaudo/show.html.twig', array(
            'froCfgTipoRecaudo' => $froCfgTipoRecaudo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing froCfgTipoRecaudo entity.
     *
     * @Route("/edit", name="frocfgtiporecaudo_edit")
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
            $tipoRecaudo = $em->getRepository('JHWEBFinancieroBundle:FroCfgTipoRecaudo')->find($params->id);

            if ($tipoRecaudo != null) {
                $nombre = strtoupper($params->nombre);
                $tipoRecaudo->setNombre($nombre);
                $em->persist($tipoRecaudo);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $tipoRecaudo,
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
     * Deletes a froCfgTipoRecaudo entity.
     *
     * @Route("/delete", name="frocfgtiporecaudo_delete")
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

            $tipoRecaudo = $em->getRepository('JHWEBFinancieroBundle:FroCfgTipoRecaudo')->find($params->id);

            $tipoRecaudo->setActivo(false);

            $em->persist($tipoRecaudo);
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
     * Creates a form to delete a froCfgTipoRecaudo entity.
     *
     * @param FroCfgTipoRecaudo $froCfgTipoRecaudo The froCfgTipoRecaudo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FroCfgTipoRecaudo $froCfgTipoRecaudo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('frocfgtiporecaudo_delete', array('id' => $froCfgTipoRecaudo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ============================================== */

    /**
     * Listado de tipos de recaudo para select con búsqueda
     *
     * @Route("/select", name="frocfgtiporecaudo_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $tiposRecaudo = $em->getRepository('JHWEBFinancieroBundle:FroCfgTipoRecaudo')->findBy(
            array('activo' => true)
        );
        
        $response = null;

        foreach ($tiposRecaudo as $key => $tipoRecaudo) {
            $response[$key] = array(
                'value' => $tipoRecaudo->getId(),
                'label' => $tipoRecaudo->getNombre(),
            );
        }
        
        return $helpers->json($response);
    }
}
