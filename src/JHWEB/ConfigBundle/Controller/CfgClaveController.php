<?php

namespace JHWEB\ConfigBundle\Controller;

use JHWEB\ConfigBundle\Entity\CfgClave;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * Cfgclave controller.
 *
 * @Route("cfgclave")
 */
class CfgClaveController extends Controller
{
    /**
     * Lists all cfgClave entities.
     *
     * @Route("/", name="cfgclave_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        
        $helpers = $this->get("app.helpers");
        
        $em = $this->getDoctrine()->getManager();
        
        $cfgClaves = $em->getRepository('JHWEBConfigBundle:CfgClave')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($cfgClaves) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($cfgClaves)." registros encontrados", 
                'data'=> $cfgClaves,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new cfgClave entity.
     *
     * @Route("/new", name="cfgclave_new")
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

            $horaCreacion = new \Datetime(date('Y-m-d h:i:s'));

            $funcionario = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->find(
                $params->idFuncionario
            );

            $horaVencimiento = $helpers->getHoraVencimiento($horaCreacion, 5);
            var_dump($horaVencimiento);
            die();

            $cfgClave = new Cfgclave();

            $cfgClave->setCodigo($params->codigo);
            $cfgClave->setObservacion($params->observacion);
            $cfgClave->setFechaCreacion($fechaCreacion);
            $cfgClave->setHoraCreacion($fechaCreacion);
            $cfgClave->setFechaVencimiento($fechaCreacion);
            $cfgClave->setHoraVencimiento($horaVencimiento);
            $cfgClave->setFuncionario($funcionario);
            $cfgClave->setActivo(true); 

            $em = $this->getDoctrine()->getManager();
            $em->persist($cfgClave);
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
     * Finds and displays a cfgClave entity.
     *
     * @Route("/{id}", name="cfgclave_show")
     * @Method("GET")
     */
    public function showAction(CfgClave $cfgClave)
    {
        $deleteForm = $this->createDeleteForm($cfgClave);

        return $this->render('cfgclave/show.html.twig', array(
            'cfgClave' => $cfgClave,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cfgClave entity.
     *
     * @Route("/edit", name="cfgclave_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $em = $this->getDoctrine()->getManager();
            $json = $request->get("data",null);
            $params = json_decode($json);

            $fechaVencimiento = new \Datetime($params->fechaVencimiento);
            $horaVencimiento = new \Datetime($params->horaVencimiento);
         
            $cfgClave = $em->getRepository('JHWEBConfigBundle:CfgClave')->find($params->id);

            $cfgClave->setCodigo($params->codigo);
            $cfgClave->setObservacion($params->observacion);

            $cfgClave->setFechaVencimiento($fechaVencimiento);
            $cfgClave->setHoraVencimiento($horaVencimiento);

            $cfgClave->setActivo(true); 

            $em = $this->getDoctrine()->getManager();
            $em->persist($cfgClave);
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
     * Deletes a cfgClave entity.
     *
     * @Route("/{id}", name="cfgclave_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CfgClave $cfgClave)
    {
        $form = $this->createDeleteForm($cfgClave);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cfgClave);
            $em->flush();
        }

        return $this->redirectToRoute('cfgclave_index');
    }

    /**
     * Creates a form to delete a cfgClave entity.
     *
     * @param CfgClave $cfgClave The cfgClave entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgClave $cfgClave)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgclave_delete', array('id' => $cfgClave->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
