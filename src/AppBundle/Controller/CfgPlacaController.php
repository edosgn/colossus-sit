<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CfgPlaca;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Cfgplaca controller.
 *
 * @Route("cfgplaca")
 */
class CfgPlacaController extends Controller
{
    /**
     * Lists all cfgPlaca entities.
     *
     * @Route("/", name="cfgplaca_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $cfgPlacas = $em->getRepository('AppBundle:CfgPlaca')->findAll();
        $response=null;
        if ($cfgPlacas) {
            $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => 'listado placas',
                        'data' => $cfgPlacas,
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a new cfgPlaca entity.
     *
     * @Route("/new", name="cfgplaca_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $hash = $request->get("authorization",null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $numero = $params->numero;

            $estado = $params->estado;
            $sedeOperativaId = $params->sedeOperativaId;
            $claseId = $params = $params->claseId;

            $sedeOperativa = $em->getRepository('AppBundle:SedeOperativa')->find($sedeOperativaId);

            $clase = $em->getRepository('AppBundle:Clase')->find($claseId);

            $cfgPlaca = $em->getRepository('AppBundle:CfgPlaca')->findBy(
                    array('id' => $numero)
                );

            if ($cfgPlaca == null) {
                    $cfgPlaca = new CfgPlaca();
                    $cfgPlaca->setNumero($numero);
                    $cfgPlaca->setEstado($estado);
                    $cfgPlaca->setClase($clase);
                    $cfgPlaca->setSedeOperativa($sedeOperativa);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($cfgPlaca);
                    $em->flush();
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Placa creada con éxito",
                    );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Error al crear la placa",
                );
            }

        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorización no válida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Finds and displays a cfgPlaca entity.
     *
     * @Route("/show/{id}", name="cfgplaca_show")
     * @Method("POST")
     */
    public function showAction(CfgPlaca $cfgPlaca)
    {
        $deleteForm = $this->createDeleteForm($cfgPlaca);

        return $this->render('cfgplaca/show.html.twig', array(
            'cfgPlaca' => $cfgPlaca,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cfgPlaca entity.
     *
     * @Route("/edit", name="cfgplaca_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization",null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);

            $numero = $params->numero;
            $estado = $params->estado;
            $claseId = $params->claseId;
            $sedeOperativaId = $params->sedeOperativaId;

            $em = $this->getDoctrine()->getManager();
            $cfgPlaca = $em->getRepository('AppBundle:CfgPlaca')->find($params->id);
            $clase = $em->getRepository('AppBundle:Clase')->find($claseId);
            $sedeOperativa = $em->getRepository('AppBundle:SedeOperativa')->find($sedeOperativaId);

            if ($cfgPlaca != null) {
                $cfgPlaca->setNumero($numero);
                $cfgPlaca->setEstado($estado);
                $cfgPlaca->setClase($clase);
                $cfgPlaca->setSedeOperativa($sedeOperativa);

                $em = $this->getDoctrine()->getManager();
                $em->persist($cfgPlaca);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Placa editada con éxito",
                );

            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "La placa no se encuentra en la base de datos",
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autrización no válida para editar placa",
                );
        }
        return $helpers->json($response);
    }

    /**
     * Deletes a cfgPlaca entity.
     *
     * @Route("/delete", name="cfgplaca_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $json = $request->get("json", null);
            $params = json_decode($json);

            $cfgPlaca = $em->getRepository('AppBundle:CfgPlaca')->find($params);

            $cfgPlaca->setEstado(0);
            $em = $this->getDoctrine()->getManager();
                $em->persist($cfgPlaca);
                $em->flush();
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Placa eliminada con éxto",
            );

        }else{
            $reponse = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorización no válida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a cfgPlaca entity.
     *
     * @param CfgPlaca $cfgPlaca The cfgPlaca entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgPlaca $cfgPlaca)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgplaca_delete', array('id' => $cfgPlaca->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2 por modulo
     *
     * @Route("/select/placas/por/sedeOperativa/{id}", name="placas_select_por_sedeOperativa")
     * @Method({"GET", "POST"})
     */

    public function SelectPlacaPorSede( $id)
    {
        $response = null;
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $placas = $em->getRepository('AppBundle:CfgPlaca')->findBy(
            array(
                'sedeOperativa' => $id,
                'estado' => 1
            )
        );
        foreach ($placas as $key => $placa) {
            $response[$key] = array(
                'value' => $placa->getNumero(),
                'label' => $placa->getNumero(),
            );
        }
        return $helpers->json($response);
    }
}
