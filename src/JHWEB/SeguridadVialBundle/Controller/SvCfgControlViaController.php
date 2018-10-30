<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgControlVia;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgcontrolvia controller.
 *
 * @Route("svcfgcontrolvia")
 */
class SvCfgControlViaController extends Controller
{
    /**
     * Lists all svCfgControlVia entities.
     *
     * @Route("/", name="svcfgcontrolvia_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $controlesVia = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgControlVia')->findBy(
            array(
                'activo' => true,
                )
        );

        $response['data'] = array();

        if ($controlesVia) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($controlesVia) . " registros encontrados",
                'data' => $controlesVia,
            );
        }
        return $helpers->json($response);

    }

    /**
     * Lists all svCfgControlVia entities.
     *
     * @Route("/senialvertical", name="svcfgcontrolvia_senialvertical_index")
     * @Method("GET")
     */
    public function indexSenialVerticalAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $controlesVia = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgControlVia')->findBy(
            array(
                'activo' => true,
                'tipoControl' => 3
                )
        );

        $response['data'] = array();

        if ($controlesVia) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($controlesVia) . " registros encontrados",
                'data' => $controlesVia,
            );
        }
        return $helpers->json($response);

    }

    /**
     * Lists all svCfgControlVia entities.
     *
     * @Route("/senialhorizontal", name="svcfgcontrolvia_senialhorizontal_index")
     * @Method("GET")
     */
    public function indexSenialHorizontalAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $controlesVia = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgControlVia')->findBy(
            array(
                'activo' => true,
                'tipoControl' => 4
                )
        );

        $response['data'] = array();

        if ($controlesVia) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($controlesVia) . " registros encontrados",
                'data' => $controlesVia,
            );
        }
        return $helpers->json($response);

    }

    /**
     * Lists all svCfgControlVia entities.
     *
     * @Route("/reductorvelocidad", name="svcfgcontrolvia_reductorvelovidad_index")
     * @Method("GET")
     */
    public function indexReductorVelocidadAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $controlesVia = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgControlVia')->findBy(
            array(
                'activo' => true,
                'tipoControl' => 5
                )
        );

        $response['data'] = array();

        if ($controlesVia) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($controlesVia) . " registros encontrados",
                'data' => $controlesVia,
            );
        }
        return $helpers->json($response);

    }

    /**
     * Lists all svCfgControlVia entities.
     *
     * @Route("/delineadorpiso", name="svcfgcontrolvia_delineadorpiso_index")
     * @Method("GET")
     */
    public function indexDelineadorPisoAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $controlesVia = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgControlVia')->findBy(
            array(
                'activo' => true,
                'tipoControl' => 6
                )
        );

        $response['data'] = array();

        if ($controlesVia) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($controlesVia) . " registros encontrados",
                'data' => $controlesVia,
            );
        }
        return $helpers->json($response);

    }

    /**
     * Creates a new svCfgControlVia entity.
     *
     * @Route("/new", name="svcfgcontrolvia_new")
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
            
            $controlVia = new SvCfgControlVia();

            $em = $this->getDoctrine()->getManager();
            if ($params->tipoControl) {
                $tipoControl = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTipoControl')->find(
                    $params->tipoControl
                );
                $controlVia->setTipoControl($tipoControl);
            }

            $controlVia->setNombre($params->nombre);
            $controlVia->setActivo(true);
            $em->persist($controlVia);
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
     * Finds and displays a svCfgControlVia entity.
     *
     * @Route("/{id}/show", name="svcfgcontrolvia_show")
     * @Method("GET")
     */
    public function showAction(SvCfgControlVia $svCfgControlVia)
    {
        $deleteForm = $this->createDeleteForm($svCfgControlVia);
        return $this->render('svCfgControlVia/show.html.twig', array(
            'svCfgControlVia' => $svCfgControlVia,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing svCfgControlVia entity.
     *
     * @Route("/edit", name="svcfgcontrolvia_edit")
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
            $controlVia = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgControlVia')->find($params->id);

            $tipoControl = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTipoControl')->find($params->tipoControl);
            if ($controlVia != null) {
                $controlVia->setNombre($params->nombre);
                $controlVia->setTipoControl($tipoControl);

                $em->persist($controlVia);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $controlVia,
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
     * Deletes a svCfgControlVia entity.
     *
     * @Route("/delete", name="svcfgcontrolvia_delete")
     * @Method("POST")
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

            $controlVia = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgControlVia')->find($params->id);

            $controlVia->setActivo(false);

            $em->persist($controlVia);
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
     * Creates a form to delete a SvCfgControlVia entity.
     *
     * @param SvCfgControlVia $svCfgControlVia The svCfgControlVia entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgFuncion $svCfgControlVia)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svcfgcontrolvia_delete', array('id' => $svCfgControlVia->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

     /**
     * datos para select 2
     *
     * @Route("/select", name="controlvia_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $controlesVia = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgControlVia')->findBy(
        array('activo' => 1)
    );
    $response = null;

      foreach ($controlesVia as $key => $controlVia) {
        $response[$key] = array(
            'value' => $controlVia->getId(),
            'label' => $controlVia->getNombre(),
            );
      }
       return $helpers->json($response);
    }
    
    /**
     * datos para select 2
     *
     * @Route("/select/semaforo", name="controlvia_semaforo_select")
     * @Method({"GET", "POST"})
     */
    public function selectSemaforoAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $controlesVia = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgControlVia')->findBy(
        array('activo' => 1,
            'tipoControl' => 2,
            )
    );
    $response = null;

      foreach ($controlesVia as $key => $controlVia) {
        $response[$key] = array(
            'value' => $controlVia->getId(),
            'label' => $controlVia->getNombre(),
            );
      }
       return $helpers->json($response);
    }

    /**
     * datos para select 2
     *
     * @Route("/select/delineadorpiso", name="controlvia_delineadorpiso_select")
     * @Method({"GET", "POST"})
     */
    public function selectDelineadorPisoAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $controlesVia = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgControlVia')->findBy(
        array('activo' => 1,
            'tipoControl' => 6,
            )
    );
    $response = null;

      foreach ($controlesVia as $key => $controlVia) {
        $response[$key] = array(
            'value' => $controlVia->getId(),
            'label' => $controlVia->getNombre(),
            );
      }
       return $helpers->json($response);
    }

}
