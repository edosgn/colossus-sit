<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgClaseChoque;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgclasechoque controller.
 *
 * @Route("svcfgclasechoque")
 */
class SvCfgClaseChoqueController extends Controller
{
    /**
     * Lists all svCfgClaseChoque entities.
     *
     * @Route("/", name="svcfgclasechoque_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $clasesChoque = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgClaseChoque')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($clasesChoque) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($clasesChoque) . " registros encontrados",
                'data' => $clasesChoque,
            );
        }
        return $helpers->json($response);

    }

    /**
     * Creates a new svCfgClaseChoque entity.
     *
     * @Route("/new", name="svcfgclasechoque_new")
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
            
            $claseChoque = new SvCfgClaseChoque();

            $em = $this->getDoctrine()->getManager();

            if ($params->claseAccidente) {
                $claseAccidente = $em->getRepository('AppBundle:CfgClaseAccidente')->find(
                    $params->claseAccidente
                );
                $claseChoque->setClaseAccidente($claseAccidente);
            }

            $claseChoque->setNombre($params->nombre);
            $claseChoque->setActivo(true);
            $em->persist($claseChoque);
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
     * Finds and displays a svCfgClaseChoque entity.
     *
     * @Route("/{id}/show", name="svcfgclasechoque_show")
     * @Method("GET")
     */
    public function showAction(SvCfgClaseChoque $svCfgClaseChoque)
    {
        $deleteForm = $this->createDeleteForm($svCfgClaseChoque);
        return $this->render('svCfgClaseChoque/show.html.twig', array(
            'svCfgClaseChoque' => $svCfgClaseChoque,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing svCfgClaseChoque entity.
     *
     * @Route("/edit", name="svcfgclasechoque_edit")
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
            $claseChoque = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgClaseChoque')->find($params->id);
            $claseAccidente = $em->getRepository('AppBundle:CfgClaseAccidente')->find($params->claseAccidente);
            
            if ($claseChoque != null) {
                $claseChoque->setNombre($params->nombre);
                $claseChoque->setClaseAccidente($claseAccidente);

                $em->persist($claseChoque);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $claseChoque,
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
     * Deletes a SvCfgClaseChoque entity.
     *
     * @Route("/delete", name="svcfclasechoque_delete")
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

            $claseChoque = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgClaseChoque')->find($params->id);

            $claseChoque->setActivo(false);

            $em->persist($claseChoque);
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
     * Creates a form to delete a SvCfgClaseChoque entity.
     *
     * @param SvCfgClaseChoque $svCfgClaseChoque The SvCfgClaseChoque entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgClaseChoque $svCfgClaseChoque)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svCfgClaseChoque_delete', array('id' => $svCfgClaseChoque->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="clasechoque_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $clasesChoque = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgClaseChoque')->findBy(
        array('activo' => 1)
    );
         $response = null;

      foreach ($clasesChoque as $key => $claseChoque) {
        $response[$key] = array(
            'value' => $claseChoque->getId(),
            'label' => $claseChoque->getNombre(),
            );
      }
       return $helpers->json($response);
    }
}
