<?php

namespace JHWEB\ConfigBundle\Controller;

use JHWEB\ConfigBundle\Entity\CfgEmpresaServicio;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cfgempresaservicio controller.
 *
 * @Route("cfgempresaservicio")
 */
class CfgEmpresaServicioController extends Controller
{
    /**
     * Lists all cfgEmpresaServicio entities.
     *
     * @Route("/", name="cfgempresaservicio_index")
     * @Method("GET")
     */
    public function indexAction()
    {

        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $CfgEmpresaServicio = $em->getRepository('JHWEBConfigBundle:CfgEmpresaServicio')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($CfgEmpresaServicio) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($CfgEmpresaServicio)." registros encontrados", 
                'data'=> $CfgEmpresaServicio,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new cfgEmpresaServicio entity.
     *
     * @Route("/new", name="cfgempresaservicio_new")
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
           
            $cfgEmpresaServicio = new Cfgempresaservicio();

            $cfgEmpresaServicio->setNombre($params->nombre);
            $cfgEmpresaServicio->setActivo(true);
            $cfgEmpresaServicio->setGestionable($params->gestionable);

            $em = $this->getDoctrine()->getManager();
            $em->persist($cfgEmpresaServicio);
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
     * Finds and displays a cfgEmpresaServicio entity.
     *
     * @Route("/{id}", name="cfgempresaservicio_show")
     * @Method("GET")
     */
    public function showAction(CfgEmpresaServicio $cfgEmpresaServicio)
    {
        $deleteForm = $this->createDeleteForm($cfgEmpresaServicio);

        return $this->render('cfgempresaservicio/show.html.twig', array(
            'cfgEmpresaServicio' => $cfgEmpresaServicio,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cfgEmpresaServicio entity.
     *
     * @Route("/edit", name="cfgempresaservicio_edit")
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
            $cfgEmpresaServicio = $em->getRepository("JHWEBConfigBundle:CfgEmpresaServicio")->find($params->id);

            if ($cfgEmpresaServicio!=null) {
                $cfgEmpresaServicio->setNombre($params->nombre);
                $cfgEmpresaServicio->setGestionable($params->gestionable);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $cfgEmpresaServicio,
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
     * Deletes a cfgEmpresaServicio entity.
     *
     * @Route("/{id}", name="cfgempresaservicio_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CfgEmpresaServicio $cfgEmpresaServicio)
    {
        $form = $this->createDeleteForm($cfgEmpresaServicio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cfgEmpresaServicio);
            $em->flush();
        }

        return $this->redirectToRoute('cfgempresaservicio_index');
    }

    /**
     * Creates a form to delete a cfgEmpresaServicio entity.
     *
     * @param CfgEmpresaServicio $cfgEmpresaServicio The cfgEmpresaServicio entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgEmpresaServicio $cfgEmpresaServicio)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgempresaservicio_delete', array('id' => $cfgEmpresaServicio->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
