<?php

namespace JHWEB\InsumoBundle\Controller;

use JHWEB\InsumoBundle\Entity\ImoCfgTipo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Imocfgtipo controller.
 *
 * @Route("imocfgtipo")
 */
class ImoCfgTipoController extends Controller
{
    /**
     * Lists all ImoCfgTipo entities.
     *
     * @Route("/", name="imocfgtipo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $casoInsumos = $em->getRepository('JHWEBInsumoBundle:ImoCfgTipo')->findBy(
            array('activo' => 1)
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
     * Creates a new ImoCfgTipo entity.
     *
     * @Route("/new", name="imocfgtipo_new")
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

            $modulo = $em->getRepository('JHWEBConfigBundle:CfgModulo')->find($params->moduloId);
            
            $casoInsumo = $em->getRepository('JHWEBInsumoBundle:ImoCfgTipo')->findOneBy(
                array(
                    'nombre' => $params->nombre,
                    'modulo' => $modulo->getId()
                )
            );
            
            if (!$casoInsumo) {
                $casoInsumo = new ImoCfgTipo();

                $casoInsumo->setNombre(mb_strtoupper($params->nombre, 'utf-8'));
                $casoInsumo->setModulo($modulo);
                $casoInsumo->setReferencia($params->referencia);
                $casoInsumo->setCategoria(mb_strtoupper($params->categoria, 'utf-8'));
                $casoInsumo->setActivo(true);

                $em->persist($casoInsumo);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro creado con exito", 
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro ya se encuentra registrado", 
                );
            }
        }else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Finds and displays a ImoCfgTipo entity.
     *
     * @Route("/show/{id}", name="imocfgtipo_show")
     * @Method("POST")
     */
    public function showAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $casoInsumo = $em->getRepository('JHWEBInsumoBundle:ImoCfgTipo')->find($id);
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
     * Displays a form to edit an existing ImoCfgTipo entity.
     *
     * @Route("/edit", name="imocfgtipo_edit")
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

            $nombre = $params->nombre;
            $moduloId = $params->moduloId;
            $referencia = $params->referencia;
            $tipo = $params->tipo;
            $em = $this->getDoctrine()->getManager();
            $casoInsumo = $em->getRepository('JHWEBInsumoBundle:ImoCfgTipo')->find($params->id);
            $modulo = $em->getRepository('JHWEBConfigBundle:CfgModulo')->find($moduloId);

            if ($casoInsumo != null) {

                $casoInsumo->setNombre(strtoupper($params->nombre));
                $casoInsumo->setModulo($modulo);
                $casoInsumo->setReferencia($params->referencia);
                $casoInsumo->setTipo($params->tipo);
                $casoInsumo->setActivo(true);

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
     * Deletes a ImoCfgTipo entity.
     *
     * @Route("/delete", name="imocfgtipo_delete")
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
            $casoInsumo = $em->getRepository('JHWEBInsumoBundle:ImoCfgTipo')->find($params->id);

            $casoInsumo->setActivo(0);
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
     * Creates a form to delete a ImoCfgTipo entity.
     *
     * @param ImoCfgTipo $casoInsumo The ImoCfgTipo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ImoCfgTipo $casoInsumo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('imocfgtipo_delete', array('id' => $casoInsumo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    
    /**
     * datos para select 2
     *
     * @Route("/select/sustrato", name="imocfgtipo_select_sustrato")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        $insumos = $em->getRepository('JHWEBInsumoBundle:ImoCfgTipo')->findBy(
            array(
                'activo' => 1, 
                'tipo' => 'SUSTRATO'
            )
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
     * @Route("/select/insumo", name="imocfgtipo_select_insumo")
     * @Method({"GET", "POST"})
     */
    public function selectInsumoAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        $insumos = $em->getRepository('JHWEBInsumoBundle:ImoCfgTipo')->findBy(
            array('activo' => 1, 'tipo' => 'Insumo')
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
