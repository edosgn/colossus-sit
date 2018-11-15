<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgHospital;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfghospital controller.
 *
 * @Route("svcfghospital")
 */
class SvCfgHospitalController extends Controller
{
    /**
     * Lists all svCfgHospital entities.
     *
     * @Route("/", name="svcfghospital_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $hospitales = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgHospital')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($hospitales) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($hospitales) . " registros encontrados",
                'data' => $hospitales,
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a new svCfgHospital entity.
     *
     * @Route("/new", name="svcfghospital_new")
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
            
            $hospital = new SvCfgHospital();

            $em = $this->getDoctrine()->getManager();

            if ($params->sedeOperativa) {
                $sedeOperativa = $em->getRepository('AppBundle:SedeOperativa')->find($params->sedeOperativa);
                $hospital->setSedeOperativa($sedeOperativa);
            }

            if ($params->municipio) {
                $municipio = $em->getRepository('AppBundle:Municipio')->find($params->municipio);
                $hospital->setMunicipio($municipio);
            }

            $nombre = strtoupper($params->nombre);

            $hospital->setNombre($nombre);
            $hospital->setActivo(true);
            $em->persist($hospital);
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
     * Finds and displays a svCfgHospital entity.
     *
     * @Route("/{id}/show", name="svcfghospital_show")
     * @Method("GET")
     */
    public function showAction(SvCfgHospital $svCfgHospital)
    {
        $deleteForm = $this->createDeleteForm($svCfgHospital);
        return $this->render('svCfgHospital/show.html.twig', array(
            'svCfgHospital' => $svCfgHospital,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing svCfgHospital entity.
     *
     * @Route("/edit", name="svcfghospital_edit")
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
            $hospital = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgHospital')->find($params->id);
            $municipio = $em->getRepository('AppBundle:Municipio')->find($params->municipio);
            $sedeOperativa = $em->getRepository('AppBundle:SedeOperativa')->find($params->sedeOperativa);
            
            if ($hospital != null) {
                $hospital->setNombre($params->nombre);
                $hospital->setSedeOperativa($sedeOperativa);
                $hospital->setMunicipio($municipio);

                $em->persist($hospital);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $hospital,
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
     * Deletes a svCfgHospital entity.
     *
     * @Route("/delete", name="svcfghospital_delete")
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

            $hospital = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgHospital')->find($params->id);

            $hospital->setActivo(false);

            $em->persist($hospital);
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
     * Creates a form to delete a SvCfgHospital entity.
     *
     * @param SvCfgHospital $svCfgHospital The SvCfgHospital entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgHospital $svCfgHospital)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('svcfghospital_delete', array('id' => $svCfgHospital->getId())))
        ->setMethod('DELETE')
        ->getForm();
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="hospital_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $hospitales = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgHospital')->findBy(
            array('activo' => 1)
        );
        $response = null;

        foreach ($hospitales as $key => $hospital) {
            $response[$key] = array(
                'value' => $hospital->getId(),
                'label' => $hospital->getId().'_'.$hospital->getNombre(),
            );
        }
        return $helpers->json($response);
    }
}
