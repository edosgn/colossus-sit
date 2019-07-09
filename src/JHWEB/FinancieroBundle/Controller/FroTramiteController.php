<?php

namespace JHWEB\FinancieroBundle\Controller;

use JHWEB\FinancieroBundle\Entity\FroTramite;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Frotramite controller.
 *
 * @Route("frotramite")
 */
class FroTramiteController extends Controller
{
    /**
     * Lists all froTramite entities.
     *
     * @Route("/", name="frotramite_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $tramites = $em->getRepository('JHWEBFinancieroBundle:FroTramite')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($tramites) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($tramites) . " registros encontrados",
                'data' => $tramites,
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a new Tramite entity.
     *
     * @Route("/new", name="frotramite_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            
            $tramite = new FroTramite();

            $tramiteOld = $em->getRepository('JHWEBFinancieroBundle:FroTramite')->findOneBy(
                array(
                    'codigo' => $params->codigo,
                    'activo' => true,
                )
            );

            if (!$tramiteOld) {
                $tramite->setCodigo($params->codigo);
                $tramite->setNombre(mb_strtoupper($params->nombre, 'utf-8'));

                $sustrato = ($params->sustrato == 'true') ? true : false;
                $tramite->setSustrato($sustrato);
                $tramite->setActivo(true);

                $em->persist($tramite);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "tramite creado con exito",
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El trámite ya existe.",
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Finds and displays a froTramite entity.
     *
     * @Route("/{id}/show", name="frotramite_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(FroTramite $froTramite)
    {
        $deleteForm = $this->createDeleteForm($froTramite);
        return $this->render('froTramite/show.html.twig', array(
            'froTramite' => $froTramite,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing froTramite entity.
     *
     * @Route("/edit", name="frotramite_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $tramite = $em->getRepository('JHWEBFinancieroBundle:FroTramite')->find(
                $params->id
            );

            if ($tramite) {
                $tramite->setCodigo($params->codigo);
                $tramite->setNombre(mb_strtoupper($params->nombre, 'utf-8'));

                $sustrato = ($params->sustrato == 'true') ? true : false;
                $tramite->setSustrato($sustrato);

                $em->persist($tramite);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $tramite,
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
     * Deletes a froTramite entity.
     *
     * @Route("/delete", name="frotramite_delete")
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

            $tramite = $em->getRepository('JHWEBFinancieroBundle:FroTramite')->find(
                $params->id
            );

            $tramite->setActivo(false);

            $em->persist($tramite);
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
     * Creates a form to delete a froTramite entity.
     *
     * @param FroTramite $froTramite The froTramite entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FroTramite $froTramite)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('frotramite_delete', array('id' => $froTramite->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="frotramite_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $response = null;
        $helpers = $this->get("app.helpers");
        
        $em = $this->getDoctrine()->getManager();

        $tramites = $em->getRepository('JHWEBFinancieroBundle:FroTramite')->findBy(
            array('activo' => true)
        );

        foreach ($tramites as $key => $tramite) {
            $response[$key] = array(
                'value' => $tramite->getId(),
                'label' => $tramite->getCodigo()."_".$tramite->getNombre(),
            );
        }
        return $helpers->json($response);
    }
}
