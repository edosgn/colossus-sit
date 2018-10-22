<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgControlesTransito;
use JHWEB\SeguridadVialBundle\Entity\SvCfgTipoControlesTransito;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgcontrolestransito controller.
 *
 * @Route("svcfgcontrolestransito")
 */
class SvCfgControlesTransitoController extends Controller
{
    /**
     * Lists all svCfgControlesTransito entities.
     *
     * @Route("/", name="svcfgcontrolestransito_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $controlTransito = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgControlesTransito')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($controlTransito) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($controlTransito) . " registros encontrados",
                'data' => $controlTransito,
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a new svCfgControlesTransito entity.
     *
     * @Route("/new", name="svcfgcontrolestransito_new")
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
            
            $controlTransito = new SvCfgControlesTransito();

            $em = $this->getDoctrine()->getManager();

            if ($params->idTipoControlesTransito) {
                $tipoControlTransito = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTipoControlesTransito')->find(
                    $params->idTipoControlesTransito
                );
                $controlTransito->setTipoControlTransito($tipoControlTransito);
            }

            $controlTransito->setNombre($params->nombre);
            $controlTransito->setActivo(true);
            $em->persist($controlTransito);
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
     * Finds and displays a svCfgControlesTransito entity.
     *
     * @Route("/{id}/show", name="svcfgcontrolestransito_show")
     * @Method("GET")
     */
    public function showAction(SvCfgControlesTransito $svCfgControlesTransito)
    {
        $deleteForm = $this->createDeleteForm($svCfgControlesTransito);   
        return $this->render('svCfgControlesTransito/show.html.twig', array(
            'svCfgControlesTransito' => $svCfgControlesTransito,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing svCfgControlesTransito entity.
     *
     * @Route("/edit", name="svcfgcontrolestransito_edit")
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
            $controlTransito = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgControlesTransito')->find($params->id);
            $idTipoControlesTransito = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTipoControlesTransito')->find($params->idTipoControlesTransito);
            
            if ($controlTransito != null) {
                $controlTransito->setNombre($params->nombre);
                $controlTransito->setTipoControlesTransito($idTipoControlesTransito);

                $em->persist($controlTransito);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $controlTransito,
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
     * Deletes a svCfgControlesTransito entity.
     *
     * @Route("/delete", name="svcfgcontrolestransito_delete")
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

            $controlTransito = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgControlesTransito')->find($params->id);

            $controlTransito->setActivo(false);

            $em->persist($controlTransito);
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
     * Creates a form to delete a svCfgControlesTransito entity.
     *
     * @param SvCfgControlesTransito $svCfgControlesTransito The svCfgControlesTransito entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgControlesTransito $svCfgControlesTransito)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svcfgcontrolestransito_delete', array('id' => $svCfgControlesTransito->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="controlestransito_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $controlesTransito = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgControlesTransito')->findBy(
        array('activo' => 1)
    );
      foreach ($controlesTransito as $key => $controlTransito) {
        $response[$key] = array(
            'value' => $controlTransito->getId(),
            'label' => $controlTransito->getNombre(),
            );
      }
       return $helpers->json($response);
    }
}
