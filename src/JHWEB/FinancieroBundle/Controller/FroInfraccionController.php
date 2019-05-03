<?php

namespace JHWEB\FinancieroBundle\Controller;

use JHWEB\FinancieroBundle\Entity\FroInfraccion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Froinfraccion controller.
 *
 * @Route("froinfraccion")
 */
class FroInfraccionController extends Controller
{
    /**
     * Lists all froInfraccion entities.
     *
     * @Route("/", name="froinfraccion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $infracciones = $em->getRepository('JHWEBFinancieroBundle:FroInfraccion')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($infracciones) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($infracciones).' Registros encontrados.', 
                'data'=> $infracciones,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new froInfraccion entity.
     *
     * @Route("/new", name="froinfraccion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $infraccion = new FroInfraccion();

            $em = $this->getDoctrine()->getManager();

            $infraccion->setNombre(mb_strtoupper($params->nombre, 'utf-8'));
            $infraccion->setCodigo($params->codigo);
            $infraccion->setDescripcion($params->descripcion);
            $infraccion->setRetiene($params->retiene);
            $infraccion->setInmoviliza($params->inmoviliza);
            $infraccion->setActivo(true);

            if ($params->inmoviliza && $params->dias) {
                $infraccion->setDias($params->dias);
            }

            $categoria = $em->getRepository('JHWEBFinancieroBundle:FroInfrCfgCategoria')->find(
                $params->idInfraccionCategoria
            );
            $infraccion->setCategoria($categoria);

            $em->persist($infraccion);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Registro creado con exito.',  
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida.', 
            );
        }

        return $helpers->json($response);
    }

    /**
     * Finds and displays a froInfraccion entity.
     *
     * @Route("/show", name="froinfraccion_show")
     * @Method("POST")
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $infraccion = $em->getRepository("JHWEBFinancieroBundle:FroInfraccion")->find(
                $params->id
            );

            if ($infraccion) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Registro encontrado con exito.', 
                    'data'=> $infraccion,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'El registro no se encuentra en la base de datos.', 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Autorizacion no valida.r', 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing froInfraccion entity.
     *
     * @Route("/edit", name="froinfraccion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $infraccion = $em->getRepository("JHWEBFinancieroBundle:FroInfraccion")->find(
                $params->id
            );

            if ($infraccion) {
                $infraccion->setNombre(mb_strtoupper($params->nombre, 'utf-8'));
                $infraccion->setCodigo($params->codigo);
                $infraccion->setDescripcion($params->descripcion);

                $categoria = $em->getRepository('JHWEBFinancieroBundle:FroInfrCfgCategoria')->find(
                    $params->idInfraccionCategoria
                );
                $infraccion->setCategoria($categoria);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Registro actualizado con exito.', 
                    'data'=> $infraccion,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'El registro no se encuentra en la base de datos.', 
                );
            }
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida para editar.', 
            );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a froInfraccion entity.
     *
     * @Route("/{id}/delete", name="froinfraccion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FroInfraccion $froInfraccion)
    {
        $form = $this->createDeleteForm($froInfraccion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($froInfraccion);
            $em->flush();
        }

        return $this->redirectToRoute('froinfraccion_index');
    }

    /**
     * Creates a form to delete a froInfraccion entity.
     *
     * @param FroInfraccion $froInfraccion The froInfraccion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FroInfraccion $froInfraccion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('froinfraccion_delete', array('id' => $froInfraccion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* =============================================== */

    /**
     * Listado de infracciomes para selección con búsqueda
     *
     * @Route("/select", name="froinfraccion_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $infracciones = $em->getRepository('JHWEBFinancieroBundle:FroInfraccion')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($infracciones as $key => $infraccion) {
            $response[$key] = array(
                'value' => $infraccion->getId(),
                'label' => $infraccion->getCodigo()."_".$infraccion->getNombre()
            );
        }

        return $helpers->json($response);
    }

    /**
     * Finds and displays a comparendo entity.
     *
     * @Route("/calculate/value", name="froinfraccion_calculate_value")
     * @Method("POST")
     */
    public function calculateValueAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);
            
            $em = $this->getDoctrine()->getManager();

            $smlmv = $em->getRepository('JHWEBConfigBundle:CfgSmlmv')->findOneByActivo(
                true
            );

            $infraccion = $em->getRepository('JHWEBFinancieroBundle:FroInfraccion')->find(
                $params->idInfraccion
            );

            //Calcula valor de infracción
            $valorInfraccion = round(($smlmv->getValor() / 30) * $infraccion->getCategoria()->getSmldv());

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Registro encontrado.',
                'data' => $valorInfraccion,
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida.',
            );
        }

        return $helpers->json($response);
    }
}
