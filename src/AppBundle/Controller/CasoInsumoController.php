<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CasoInsumo;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Casoinsumo controller.
 *
 * @Route("casoinsumo")
 */
class CasoInsumoController extends Controller
{
    /**
     * Lists all CasoInsumo entities.
     *
     * @Route("/", name="casoInsumo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $casoInsumos = $em->getRepository('AppBundle:CasoInsumo')->findBy(
            array('estado' => 1)
        );

        $response['data'] = array();

        $response = array(
            'status' => 'success',
            'code' => 200,
            'msj' => "listado casoInsumos",
            'data' => $casoInsumos,
        );

        return $helpers->json($response);
    }

    /**
     * Creates a new CasoInsumo entity.
     *
     * @Route("/new", name="casoInsumo_new")
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

            $modulo = $em->getRepository('AppBundle:Modulo')->find($params->moduloId);
            
            $casoInsumo = $em->getRepository('AppBundle:CasoInsumo')->findOneBy(
                array(
                    'nombre' => $params->nombre,
                    'modulo' => $modulo->getId()
                )
            );
            
            if (!$casoInsumo) {
                $casoInsumo = new CasoInsumo();

                $casoInsumo->setNombre(strtoupper($params->nombre));
                $casoInsumo->setModulo($modulo);
                $casoInsumo->setReferencia($params->referencia);
                $casoInsumo->setValor($params->valor);
                $casoInsumo->setTipo($params->tipo);
                $casoInsumo->setEstado(true);

                $em->persist($casoInsumo);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro creado con exito", 
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El registro ya se encuentra registrado", 
                );
            }
        }else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Finds and displays a CasoInsumo entity.
     *
     * @Route("/show/{id}", name="casoInsumo_show")
     * @Method("POST")
     */
    public function showAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $casoInsumo = $em->getRepository('AppBundle:CasoInsumo')->find($id);
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "casoInsumo encontrado",
                'data' => $casoInsumo,
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
     * Displays a form to edit an existing CasoInsumo entity.
     *
     * @Route("/edit", name="casoInsumo_edit")
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

            $nombre = $params->nombre;
            $moduloId = $params->moduloId;
            $referencia = $params->referencia;
            $tipo = $params->tipo;
            $em = $this->getDoctrine()->getManager();
            $casoInsumo = $em->getRepository('AppBundle:CasoInsumo')->find($params->id);
            $modulo = $em->getRepository('AppBundle:Modulo')->find($moduloId);

            if ($casoInsumo != null) {

                $casoInsumo->setNombre(strtoupper($nombre));
                $casoInsumo->setModulo($modulo);
                $casoInsumo->setReferencia($referencia);
                $casoInsumo->setTipo($tipo);
                $casoInsumo->setEstado(true);

                $em = $this->getDoctrine()->getManager();
                $em->persist($casoInsumo);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "casoInsumo editada con exito",
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "La casoInsumo no se encuentra en la base de datos",
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
     * Deletes a CasoInsumo entity.
     *
     * @Route("/delete", name="casoInsumo_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            $casoInsumo = $em->getRepository('AppBundle:CasoInsumo')->find($params->id);

            $casoInsumo->setEstado(0);
            $em = $this->getDoctrine()->getManager();
            $em->persist($casoInsumo);
            $em->flush();
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "casoInsumo eliminado con exito",
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
     * Creates a form to delete a CasoInsumo entity.
     *
     * @param CasoInsumo $casoInsumo The CasoInsumo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CasoInsumo $casoInsumo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('casoInsumo_delete', array('id' => $casoInsumo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select/sustrato", name="casoInsumo_select_sustrato")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        $insumos = $em->getRepository('AppBundle:CasoInsumo')->findBy(
            array('estado' => 1, 'tipo' => 'Sustrato')
        );

        $response = null;

        foreach ($insumos as $key => $insumo) {
            $response[$key] = array(
                'value' => $insumo->getId(),
                'label' => $insumo->getNombre(),
            );
        }
        return $helpers->json($response);
    }

    /**
     * datos para select 2
     *
     * @Route("/select/insumo", name="casoInsumo_select_insumo")
     * @Method({"GET", "POST"})
     */
    public function selectInsumoAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        $insumos = $em->getRepository('AppBundle:CasoInsumo')->findBy(
            array('estado' => 1, 'tipo' => 'Insumo')
        );

        $response = null;

        foreach ($insumos as $key => $insumo) {
            $response[$key] = array(
                'value' => $insumo->getId(),
                'label' => $insumo->getNombre(),
            );
        }
        return $helpers->json($response);
    }

}
