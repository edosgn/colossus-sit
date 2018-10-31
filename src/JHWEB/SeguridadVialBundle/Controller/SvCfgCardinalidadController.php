<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgCardinalidad;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgcardinalidad controller.
 *
 * @Route("svcfgcardinalidad")
 */
class SvCfgCardinalidadController extends Controller
{
    /**
     * Lists all svCfgCardinalidad entities.
     *
     * @Route("/", name="svcfgcardinalidad_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $cardinalidades = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgCardinalidad')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($cardinalidades) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($cardinalidades) . " registros encontrados",
                'data' => $cardinalidades,
            );
        }
        return $helpers->json($response);

    }

    /**
     * Creates a new svCfgCardinalidad entity.
     *
     * @Route("/new", name="svcfgcardinalidad_new")
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
            
            $cardinalidad = new SvCfgCardinalidad();

            $em = $this->getDoctrine()->getManager();

            $cardinalidad->setNombre($params->nombre);
            $cardinalidad->setActivo(true);
            $em->persist($cardinalidad);
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
     * Finds and displays a svCfgCardinalidad entity.
     *
     * @Route("/{id}/show", name="svcfgcardinalidad_show")
     * @Method("GET")
     */
    public function showAction(SvCfgCardinalidad $svCfgCardinalidad)
    {
        $deleteForm = $this->createDeleteForm($svCfgCardinalidad);
        return $this->render('svCfgCardinalidad/show.html.twig', array(
            'svCfgCardinalidad' => $svCfgCardinalidad,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing SvCfgCardinalidad entity.
     *
     * @Route("/edit", name="svcfgCardinalidad_edit")
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
            $cardinalidad = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgCardinalidad')->find($params->id);

            if ($cardinalidad != null) {
                $cardinalidad->setNombre($params->nombre);

                $em->persist($cardinalidad);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $cardinalidad,
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
     * Deletes a SvCfgCardinalidad entity.
     *
     * @Route("/delete", name="svcfgcardinalidad_delete")
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

            $cardinalidad = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgCardinalidad')->find($params->id);

            $cardinalidad->setActivo(false);

            $em->persist($cardinalidad);
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
     * Creates a form to delete a SvCfgCardinalidad entity.
     *
     * @param SvCfgCardinalidad $svCfgCardinalidad The SvCfgCardinalidad entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgCardinalidad $svCfgCardinalidad)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svCfgCardinalidad_delete', array('id' => $svCfgCardinalidad->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="Cardinalidad_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $cardinalidades = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgCardinalidad')->findBy(
        array('activo' => 1)
    );
        $response = null;
      foreach ($cardinalidades as $key => $cardinalidad) {
        $response[$key] = array(
            'value' => $cardinalidad->getId(),
            'label' => $cardinalidad->getNombre(),
            );
      }
       return $helpers->json($response);
    }
}
