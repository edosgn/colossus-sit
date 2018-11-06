<?php

namespace JHWEB\ConfigBundle\Controller;

use JHWEB\ConfigBundle\Entity\CfgEntidadJudicial;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cfgentidadjudicial controller.
 *
 * @Route("cfgentidadjudicial")
 */
class CfgEntidadJudicialController extends Controller
{
   /**
     * Lists all cfgEntidadJudicial entities.
     *
     * @Route("/", name="cfgentidadjudicial_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $response = null;
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $cfgEntidadesJudiciales = $em->getRepository('JHWEBConfigBundle:CfgEntidadJudicial')->findBy(
            array('estado' => 1)
        );

        $response = array(
            'status' => 'success',
            'code' => 200,
            'msj' => "lista de entidades judiciales",
            'data' => $cfgEntidadesJudiciales,
        );
        return $helpers->json($response);
    }

    /**
     * Creates a new cfgEntidadJudicial entity.
     *
     * @Route("/new", name="cfgentidadjudicial_new")
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
            

            $cfgEntidadJudicial = new CfgEntidadJudicial();

            $cfgEntidadJudicial->setNombre(strtoupper($params->nombre));
            $cfgEntidadJudicial->setCodigo($params->codigo);
            $cfgEntidadJudicial->setEstado(true);

            $municipio = $em->getRepository('AppBundle:Municipio')->find(
                $params->municipioId
            );
            $cfgEntidadJudicial->setMunicipio($municipio);

            $em->persist($cfgEntidadJudicial);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "Registro creado con exito",
            );
            // }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Finds and displays a cfgEntidadJudicial entity.
     *
     * @Route("/{id}/show", name="cfgentidadjudicial_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request, CfgEntidadJudicial $cfgEntidadJudicial)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "Registro encontrado",
                'data' => $cfgEntidadJudicial,
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing cfgEntidadJudicial entity.
     *
     * @Route("/edit", name="cfgentidadjudicial_edit")
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

            $cfgEntidadJudicial = $em->getRepository('JHWEBConfigBundle:CfgEntidadJudicial')->find($params->id);

            if ($cfgEntidadJudicial != null) {
                $cfgEntidadJudicial->setNombre(strtoupper($params->nombre));
                $cfgEntidadJudicial->setCodigo($params->codigo);

                $municipio = $em->getRepository('AppBundle:Municipio')->find(
                    $params->municipioId
                );
                $cfgEntidadJudicial->setMunicipio($municipio);

                $em->persist($cfgEntidadJudicial);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro actualizado con exito",
                    'data' => $cfgEntidadJudicial,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El registro no se encuentra en la base de datos",
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida para editar banco",
            );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a cfgEntidadJudicial entity.
     *
     * @Route("/{id}/delete", name="cfgentidadjudicial_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, CfgEntidadJudicial $cfgEntidadJudicial)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();

            $cfgEntidadJudicial->setEstado(false);

            $em = $this->getDoctrine()->getManager();
            $em->persist($cfgEntidadJudicial);
            $em->flush();
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "Registro eliminado con exito",
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a cfgEntidadJudicial entity.
     *
     * @param CfgEntidadJudicial $cfgEntidadJudicial The cfgEntidadJudicial entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgEntidadJudicial $cfgEntidadJudicial)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgentidadjudicial_delete', array('id' => $cfgEntidadJudicial->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Datos para select 2
     *
     * @Route("/select", name="cfgEntidadJudicial_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $response = null;
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $cfgEntidadesJudiciales = $em->getRepository('JHWEBConfigBundle:CfgEntidadJudicial')->findBy(
            array('estado' => 1)
        );
        foreach ($cfgEntidadesJudiciales as $key => $cfgEntidadJudicial) {
            $consecutive = substr($cfgEntidadJudicial->getCodigoDivipo(), 0, 12);
            $response[$key] = array(
                'value' => $cfgEntidadJudicial->getId(),
                'label' => $cfgEntidadJudicial->getCodigoDivipo() . "_" . $cfgEntidadJudicial->getNombre() . "  -  " . $cfgEntidadJudicial->getMunicipio(),
                'consecutive' => $consecutive,
            );
        }
        return $helpers->json($response);
    }
}
