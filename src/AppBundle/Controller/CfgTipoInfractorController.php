<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CfgTipoInfractor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cfgtipoinfractor controller.
 *
 * @Route("cfgtipoinfractor")
 */
class CfgTipoInfractorController extends Controller
{
    /**
     * Lists all cfgTipoInfractor entities.
     *
     * @Route("/", name="cfgtipoinfractor_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $tipos = $em->getRepository('AppBundle:CfgTipoInfractor')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($tipos) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($tipos)." registros encontrados", 
                'data'=> $tipos,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new cfgTipoInfractor entity.
     *
     * @Route("/new", name="cfgtipoinfractor_new")
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

            /*if (count($params)==0) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "los campos no pueden estar vacios", 
                );
            }else{*/
                $tipo = new CfgTipoInfractor();

                $tipo->setNombre($params->nombre);
                $tipo->setActivo(true);

                $em = $this->getDoctrine()->getManager();
                $em->persist($tipo);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro creado con exito",
                );
            //}
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
     * Finds and displays a cfgTipoInfractor entity.
     *
     * @Route("/{id}/show", name="cfgtipoinfractor_show")
     * @Method("GET")
     */
    public function showAction(CfgTipoInfractor $cfgTipoInfractor)
    {
        $deleteForm = $this->createDeleteForm($cfgTipoInfractor);

        return $this->render('cfgtipoinfractor/show.html.twig', array(
            'cfgTipoInfractor' => $cfgTipoInfractor,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cfgTipoInfractor entity.
     *
     * @Route("/edit", name="cfgtipoinfractor_edit")
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
            $tipo = $em->getRepository("AppBundle:CfgTipoInfractor")->find($params->id);

            if ($tipo!=null) {
                $tipo->setNombre($params->nombre);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $tipo,
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
     * Deletes a cfgTipoInfractor entity.
     *
     * @Route("/{id}/delete", name="cfgtipoinfractor_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CfgTipoInfractor $cfgTipoInfractor)
    {
        $form = $this->createDeleteForm($cfgTipoInfractor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cfgTipoInfractor);
            $em->flush();
        }

        return $this->redirectToRoute('cfgtipoinfractor_index');
    }

    /**
     * Creates a form to delete a cfgTipoInfractor entity.
     *
     * @param CfgTipoInfractor $cfgTipoInfractor The cfgTipoInfractor entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgTipoInfractor $cfgTipoInfractor)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgtipoinfractor_delete', array('id' => $cfgTipoInfractor->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="cfgtipoinfractor_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $tipos = $em->getRepository('AppBundle:CfgTipoInfractor')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($tipos as $key => $tipo) {
            $response[$key] = array(
                'value' => $tipo->getId(),
                'label' => $tipo->getNombre()
            );
        }
        return $helpers->json($response);
    }
}
