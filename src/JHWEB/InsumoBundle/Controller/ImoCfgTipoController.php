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

        $tiposInsumos = $em->getRepository('JHWEBInsumoBundle:ImoCfgTipo')->findBy(
            array('activo' => 1)
        );

        $response['data'] = array();

        $response = array(
            'title' => 'Perfecto!',
            'status' => 'success',
            'code' => 200,
            'message' => "listado tipos de insumos",
            'data' => $tiposInsumos,
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

            $modulo = $em->getRepository('JHWEBConfigBundle:CfgModulo')->find($params->idModulo);
            
            $tipoInsumo = $em->getRepository('JHWEBInsumoBundle:ImoCfgTipo')->findOneBy(
                array(
                    'nombre' => $params->nombre,
                    'modulo' => $modulo->getId()
                )
            );
            
            if (!$tipoInsumo) {
                $tipoInsumo = new ImoCfgTipo();

                $tipoInsumo->setNombre(mb_strtoupper($params->nombre, 'utf-8'));
                $tipoInsumo->setModulo($modulo);
                $tipoInsumo->setReferencia($params->referencia);
                $tipoInsumo->setCategoria(mb_strtoupper($params->categoria, 'utf-8'));
                $tipoInsumo->setActivo(true);

                $em->persist($tipoInsumo);
                $em->flush();

                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro creado con exito", 
                );
            }else{
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro ya se encuentra registrado", 
                );
            }
        }else {
            $response = array(
                'title' => 'Error!',
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
     * @Route("/show", name="imocfgtipo_show")
     * @Method("POST")
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();

            $tipoInsumo = $em->getRepository('JHWEBInsumoBundle:ImoCfgTipo')->find($params->id);

            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Registro encontrado",
                'data' => $tipoInsumo,
            );
        } else {
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida",
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
            $em = $this->getDoctrine()->getManager();

            $tipoInsumo = $em->getRepository('JHWEBInsumoBundle:ImoCfgTipo')->find($params->id);
            $modulo = $em->getRepository('JHWEBConfigBundle:CfgModulo')->find($params->idModulo);

            if ($tipoInsumo != null) {

                $tipoInsumo->setNombre(strtoupper($params->nombre));
                $tipoInsumo->setModulo($modulo);
                $tipoInsumo->setReferencia($params->referencia);
                $tipoInsumo->setCategoria($params->categoria);
                $tipoInsumo->setActivo(true);

                $em->persist($tipoInsumo);
                $em->flush();

                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro editado con éxito",
                );
            } else {
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El tipo de insumo no se encuentra en la base de datos",
                );
            }
        } else {
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no valida.",
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
            $json = $request->get("data", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();

            $tipoInsumo = $em->getRepository('JHWEBInsumoBundle:ImoCfgTipo')->find($params->id);

            $tipoInsumo->setActivo(false);
            
            $em->persist($tipoInsumo);
            $em->flush();
            
            $response = array(
                'title'=> 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Registro eliminado con exito",
            );
        } else {
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida",
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
                'categoria' => 'SUSTRATO'
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
            array(
                'activo' => 1,
                'categoria' => 'INSUMO'
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
}
