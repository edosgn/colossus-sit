<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CfgComparendoEstado;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cfgcomparendoestado controller.
 *
 * @Route("cfgcomparendoestado")
 */
class CfgComparendoEstadoController extends Controller
{
    /**
     * Lists all cfgComparendoEstado entities.
     *
     * @Route("/", name="cfgcomparendoestado_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $estados = $em->getRepository('AppBundle:CfgComparendoEstado')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($estados) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($estados)." registros encontrados", 
                'data'=> $estados,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new cfgComparendoEstado entity.
     *
     * @Route("/new", name="cfgcomparendoestado_new")
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

            $estado = new CfgComparendoEstado();

            $estado->setNombre(strtoupper($params->nombre));
            $estado->setSigla(strtoupper($params->sigla));
            $estado->setActualiza($params->actualiza);
            $estado->setActivo(true);

            if ($params->idFormato) {
                $formato = $em->getRepository('JHWEBConfigBundle:CfgAdmFormato')->find(
                    $params->idFormato
                );
                $estado->setFormato($formato);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($estado);
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
                'message' => "Autorizacion no valida", 
            );
        } 
        return $helpers->json($response);
    }

    /**
     * Finds and displays a cfgComparendoEstado entity.
     *
     * @Route("/{id}/show", name="cfgcomparendoestado_show")
     * @Method("GET")
     */
    public function showAction(CfgComparendoEstado $cfgComparendoEstado)
    {
        $deleteForm = $this->createDeleteForm($cfgComparendoEstado);

        return $this->render('cfgcomparendoestado/show.html.twig', array(
            'cfgComparendoEstado' => $cfgComparendoEstado,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cfgComparendoEstado entity.
     *
     * @Route("/edit", name="cfgcomparendoestado_edit")
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

            var_dump($params);
            die();

            $em = $this->getDoctrine()->getManager();
            
            $estado = $em->getRepository("AppBundle:CfgComparendoEstado")->find(
                $params->id
            );

            if ($estado) {
                $estado->setNombre(strtoupper($params->nombre));
                $estado->setSigla(strtoupper($params->sigla));
                $estado->setActualiza($params->actualiza);
                
                if ($params->idFormato) {
                    $formato = $em->getRepository('JHWEBConfigBundle:CfgAdmFormato')->find(
                        $params->idFormato
                    );
                    $estado->setFormato($formato);
                }
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $estado,
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
     * Deletes a cfgComparendoEstado entity.
     *
     * @Route("/{id}/delete", name="cfgcomparendoestado_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CfgComparendoEstado $cfgComparendoEstado)
    {
        $form = $this->createDeleteForm($cfgComparendoEstado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cfgComparendoEstado);
            $em->flush();
        }

        return $this->redirectToRoute('cfgcomparendoestado_index');
    }

    /**
     * Creates a form to delete a cfgComparendoEstado entity.
     *
     * @param CfgComparendoEstado $cfgComparendoEstado The cfgComparendoEstado entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgComparendoEstado $cfgComparendoEstado)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgcomparendoestado_delete', array('id' => $cfgComparendoEstado->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="cfgcomparendoestado_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $estados = $em->getRepository('AppBundle:CfgComparendoEstado')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($estados as $key => $estado) {
            $response[$key] = array(
                'value' => $estado->getId(),
                'label' => $estado->getNombre()
            );
        }
        return $helpers->json($response);
    }
}
