<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgClaseActorVia;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgclaseactorvium controller.
 *
 * @Route("svcfgclaseactorvia")
 */
class SvCfgClaseActorViaController extends Controller
{
    /**
     * Lists all svCfgClaseActorVia entities.
     *
     * @Route("/", name="svcfgclaseactorvia_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $clasesActor = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgClaseActorVia')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($clasesActor) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($clasesActor) . " registros encontrados",
                'data' => $clasesActor,
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a new SvCfgClaseActorVia entity.
     *
     * @Route("/new", name="svcfgclaseactorvia_new")
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
            
            $em = $this->getDoctrine()->getManager();

            $claseActorVia = new SvCfgClaseActorVia();

            $claseActorVia->setNombre($params->nombre);
            $claseActorVia->setActivo(true);
            $em->persist($claseActorVia);
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
     * Finds and displays a svCfgClaseActorVia entity.
     *
     * @Route("/{id}/show", name="svcfgclaseactorvia_show")
     * @Method("GET")
     */
    public function showAction(SvCfgClaseActorVia $svCfgClaseActorVia)
    {
        $deleteForm = $this->createDeleteForm($svCfgClaseActorVia);
        return $this->render('svCfgClaseActorVia/show.html.twig', array(
            'svCfgClaseActorVia' => $svCfgClaseActorVia,
            'delete_form' => $deleteForm->createView(),
        ));

    }

    /**
     * Displays a form to edit an existing svCfgClaseActorVia entity.
     *
     * @Route("/edit", name="svcfgclaseactorvia_edit")
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
            $claseActor = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgClaseActorVia')->find($params->id);

            if ($claseActor != null) {
                $claseActor->setNombre($params->nombre);

                $em->persist($claseActor);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $claseActor,
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
     * Deletes a SvCfgClaseActorVia entity.
     *
     * @Route("/delete", name="svcfgclaseactorvia_delete")
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

            $claseActor = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgClaseActorVia')->find($params->id);

            $claseActor->setActivo(false);

            $em->persist($claseActor);
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
     * Creates a form to delete a SvCfgClaseActorVia entity.
     *
     * @param SvCfgClaseActorVia $svCfgClaseActorVia The SvCfgClaseActorVia entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgClaseActorVia $svCfgClaseActorVia)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svcfgclaseactorvia_delete', array('id' => $svCfgClaseActorVia->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="claseactorvia_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $clases = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgClaseActorVia')->findBy(
        array('activo' => 1)
    );
        $response = null;
      foreach ($clases as $key => $clase) {
        $response[$key] = array(
            'value' => $clase->getId(),
            'label' => $clase->getNombre(),
            );
      }
       return $helpers->json($response);
    }
}
