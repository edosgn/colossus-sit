<?php

namespace JHWEB\ConfigBundle\Controller;

use JHWEB\ConfigBundle\Entity\CfgSmlmv;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cfgsmlmv controller.
 *
 * @Route("cfgsmlmv")
 */
class CfgSmlmvController extends Controller
{
    /**
     * Lists all cfgSmlmv entities.
     *
     * @Route("/", name="cfgsmlmv_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $salarios = $em->getRepository('JHWEBConfigBundle:CfgSmlmv')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($salarios) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($salarios).' Registros encontrados.', 
                'data'=> $salarios,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new cfgSmlmv entity.
     *
     * @Route("/new", name="cfgsmlmv_new")
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

            $em = $this->getDoctrine()->getManager();

            $salario = new CfgSmlmv();

            $salario->setValor($params->valor);
            $salario->setAnio($params->anio);
            $salario->setFecha(new \Datetime(date('Y-m-d')));

            $em->persist($salario);
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
     * Finds and displays a cfgSmlmv entity.
     *
     * @Route("/{id}/show", name="cfgsmlmv_show")
     * @Method("GET")
     */
    public function showAction(CfgSmlmv $cfgSmlmv)
    {
        $deleteForm = $this->createDeleteForm($cfgSmlmv);

        return $this->render('cfgsmlmv/show.html.twig', array(
            'cfgSmlmv' => $cfgSmlmv,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cfgSmlmv entity.
     *
     * @Route("/edit", name="cfgsmlmv_edit")
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

            $salario = $em->getRepository("JHWEBConfigBundle:CfgSmlmv")->find(
                $params->id
            );

            if ($salario) {
                $salario->setValor($params->valor);
                $salario->setAnio($params->anio);
                $salario->setFecha(new \Datetime(date('Y-m-d')));
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Registro actualizado con exito.', 
                    'data'=> $salario,
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
     * Deletes a cfgSmlmv entity.
     *
     * @Route("/{id}/delete", name="cfgsmlmv_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CfgSmlmv $cfgSmlmv)
    {
        $form = $this->createDeleteForm($cfgSmlmv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cfgSmlmv);
            $em->flush();
        }

        return $this->redirectToRoute('cfgsmlmv_index');
    }

    /**
     * Creates a form to delete a cfgSmlmv entity.
     *
     * @param CfgSmlmv $cfgSmlmv The cfgSmlmv entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgSmlmv $cfgSmlmv)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgsmlmv_delete', array('id' => $cfgSmlmv->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
