<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MflInfraccion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Mflinfraccion controller.
 *
 * @Route("mflinfraccion")
 */
class MflInfraccionController extends Controller
{
    /**
     * Lists all mflInfraccion entities.
     *
     * @Route("/", name="mflinfraccion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $infracciones = $em->getRepository('AppBundle:MflInfraccion')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($infracciones) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => count($infracciones)." Registros encontrados", 
                'data'=> $infracciones,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new mflInfraccion entity.
     *
     * @Route("/new", name="mflinfraccion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck== true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $infraccion = new MflInfraccion();

            $em = $this->getDoctrine()->getManager();

            $infraccion->setNombre($params->nombre);
            $infraccion->setCodigo($params->codigo);
            $infraccion->setDescripcion($params->descripcion);
            $infraccion->setRetiene($params->retiene);
            $infraccion->setInmoviliza($params->inmoviliza);

            if ($params->inmoviliza && $params->dias) {
                $infraccion->setDias($params->dias);
            }

            $categoria = $em->getRepository('AppBundle:MflInfraccionCategoria')->find(
                $params->infraccionCategoriaId
            );
            $infraccion->setCategoria($categoria);

            $em->persist($infraccion);
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
                'msj' => "Autorizacion no valida", 
            );
        } 
        return $helpers->json($response);
    }

    /**
     * Finds and displays a mflInfraccion entity.
     *
     * @Route("/show", name="mflinfraccion_show")
     * @Method("POST")
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            $infraccion = $em->getRepository("AppBundle:MflInfraccion")->find($params->id);

            if ($infraccion) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $infraccion,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorizacion no valida para editar", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing mflInfraccion entity.
     *
     * @Route("/edit", name="mflinfraccion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            $infraccion = $em->getRepository("AppBundle:MflInfraccion")->find($params->id);

            if ($infraccion!=null) {
                $infraccion->setNombre($params->nombre);
                $infraccion->setCodigo($params->codigo);
                $infraccion->setDescripcion($params->descripcion);

                $categoria = $em->getRepository('AppBundle:MflInfraccionCategoria')->find(
                    $params->infraccionCategoriaId
                );
                $infraccion->setCategoria($categoria);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro actualizado con exito", 
                    'data'=> $infraccion,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El registro no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a mflInfraccion entity.
     *
     * @Route("/{id}/delete", name="mflinfraccion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MflInfraccion $mflInfraccion)
    {
        $form = $this->createDeleteForm($mflInfraccion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mflInfraccion);
            $em->flush();
        }

        return $this->redirectToRoute('mflinfraccion_index');
    }

    /**
     * Creates a form to delete a mflInfraccion entity.
     *
     * @param MflInfraccion $mflInfraccion The mflInfraccion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MflInfraccion $mflInfraccion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mflinfraccion_delete', array('id' => $mflInfraccion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="mflinfraccion_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $infracciones = $em->getRepository('AppBundle:MflInfraccion')->findBy(
            array('activo' => true)
        );

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
     * @Route("/calculate/value", name="mflinfraccion_calculate_value")
     * @Method("POST")
     */
    public function calculateValueAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json",null);
            $params = json_decode($json);
            
            $em = $this->getDoctrine()->getManager();

            //Calcula valor de infracción
            $smlmv = $em->getRepository('AppBundle:CfgSmlmv')->findOneByActivo(
                true
            );

            $infraccion = $em->getRepository('AppBundle:MflInfraccion')->find(
                $params->idInfraccion
            );

            $valorInfraccion = round(($smlmv->getValor() / 30) * $infraccion->getCategoria()->getSmldv());

            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "Registro encontrado",
                'data' => $valorInfraccion,
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
}
