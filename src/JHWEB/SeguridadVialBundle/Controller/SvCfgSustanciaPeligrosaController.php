<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgSustanciaPeligrosa;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgsustanciapeligrosa controller.
 *
 * @Route("svcfgsustanciapeligrosa")
 */
class SvCfgSustanciaPeligrosaController extends Controller
{
    /**
     * Lists all svCfgSustanciaPeligrosa entities.
     *
     * @Route("/", name="svcfgsustanciapeligrosa_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $sustanciasPeligrosas = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSustanciaPeligrosa')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($sustanciasPeligrosas) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($sustanciasPeligrosas) . " registros encontrados",
                'data' => $sustanciasPeligrosas,
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a new svCfgSustanciaPeligrosa entity.
     *
     * @Route("/new", name="svcfgsustanciapeligrosa_new")
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
            
            $sustanciaPeligrosa = new SvCfgSustanciaPeligrosa();

            $em = $this->getDoctrine()->getManager();

            $nombre = strtoupper($params->nombre);

            $sustanciaPeligrosa->setNombre($nombre);
            $sustanciaPeligrosa->setActivo(true);
            $em->persist($sustanciaPeligrosa);
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
     * Finds and displays a svCfgSustanciaPeligrosa entity.
     *
     * @Route("/{id}", name="svcfgsustanciapeligrosa_show")
     * @Method("GET")
     */
    public function showAction(SvCfgSustanciaPeligrosa $svCfgSustanciaPeligrosa)
    {
        $deleteForm = $this->createDeleteForm($svCfgSustanciaPeligrosa);
        return $this->render('svCfgSustanciaPeligrosa/show.html.twig', array(
            'svCfgSustanciaPeligrosa' => $svCfgSustanciaPeligrosa,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing SvCfgsustanciaPeligrosa entity.
     *
     * @Route("/edit", name="svcfgsustanciaPeligrosa_edit")
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
            $sustanciaPeligrosa = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSustanciaPeligrosa')->find($params->id);

            if ($sustanciaPeligrosa != null) {
                $sustanciaPeligrosa->setNombre($params->nombre);

                $em->persist($sustanciaPeligrosa);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $sustanciaPeligrosa,
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
     * Deletes a SvCfgsustanciaPeligrosa entity.
     *
     * @Route("/delete", name="svcfgsustanciapeligrosa_delete")
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

            $sustanciaPeligrosa = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSustanciaPeligrosa')->find($params->id);

            $sustanciaPeligrosa->setActivo(false);

            $em->persist($sustanciaPeligrosa);
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
     * Creates a form to delete a svCfgSustanciaPeligrosa entity.
     *
     * @param SvCfgSustanciaPeligrosa $svCfgSustanciaPeligrosa The svCfgSustanciaPeligrosa entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgSustanciaPeligrosa $svCfgSustanciaPeligrosa)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('svcfgsustanciapeligrosa_delete', array('id' => $svCfgSustanciaPeligrosa->getId())))
        ->setMethod('DELETE')
        ->getForm();
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="sustanciapeligrosa_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $sustanciaPeligrosas = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgsustanciaPeligrosa')->findBy(
            array('activo' => 1)
        );
        $response = null;

        foreach ($sustanciaPeligrosas as $key => $sustanciaPeligrosa) {
            $response[$key] = array(
                'value' => $sustanciaPeligrosa->getId(),
                'label' => $sustanciaPeligrosa->getNombre(),
            );
        }
        return $helpers->json($response);
    }
}
