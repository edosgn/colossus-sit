<?php

namespace JHWEB\InsumoBundle\Controller;

use JHWEB\InsumoBundle\Entity\ImoCfgValor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Imocfgvalor controller.
 *
 * @Route("imocfgvalor")
 */
class ImoCfgValorController extends Controller
{
    /**
     * Lists all imoCfgValor entities.
     *
     * @Route("/", name="imocfgvalor_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $imoCfgValors = $em->getRepository('JHWEBInsumoBundle:ImoCfgValor')->findAll();

        return $this->render('imocfgvalor/index.html.twig', array(
            'imoCfgValors' => $imoCfgValors,
        ));
    }

    /**
     * Creates a new imoCfgValor entity.
     *
     * @Route("/new", name="imocfgvalor_new")
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
            
            $fecha = new \DateTime($params->fecha);

            $tipoInsumo = $em->getRepository('JHWEBInsumoBundle:ImoCfgTipo')->find(
                $params->idTipoInsumo
            ); 
            
            $valor = new ImoCfgValor();

            $valor->setTipo($tipoInsumo);
            $valor->setValor($params->valorUnitario);
            $valor->setFecha($fecha);
            $valor->setActivo(false);

            $em->persist($valor);
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
                'message' => "Autorizacion no valida", 
            );
        } 
        return $helpers->json($response);
    }

    /**
     * Finds and displays a Cuenta entity.
     *
     * @Route("/show", name="imocfgvalor_show")
     * @Method("POST")
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $valores = $em->getRepository('JHWEBInsumoBundle:ImoCfgValor')->findByTipo($params);
            
            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Registro encontrado", 
                'data'=> $valores,
            );
        }else{
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
     * Displays a form to edit an existing imoCfgValor entity.
     *
     * @Route("/{id}/edit", name="imocfgvalor_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ImoCfgValor $imoCfgValor)
    {
        $deleteForm = $this->createDeleteForm($imoCfgValor);
        $editForm = $this->createForm('JHWEB\InsumoBundle\Form\ImoCfgValorType', $imoCfgValor);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('imocfgvalor_edit', array('id' => $imoCfgValor->getId()));
        }

        return $this->render('imocfgvalor/edit.html.twig', array(
            'imoCfgValor' => $imoCfgValor,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a imoCfgValor entity.
     *
     * @Route("/{id}", name="imocfgvalor_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ImoCfgValor $imoCfgValor)
    {
        $form = $this->createDeleteForm($imoCfgValor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($imoCfgValor);
            $em->flush();
        }

        return $this->redirectToRoute('imocfgvalor_index');
    }

    /**
     * Creates a form to delete a imoCfgValor entity.
     *
     * @param ImoCfgValor $imoCfgValor The imoCfgValor entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ImoCfgValor $imoCfgValor)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('imocfgvalor_delete', array('id' => $imoCfgValor->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    
}
