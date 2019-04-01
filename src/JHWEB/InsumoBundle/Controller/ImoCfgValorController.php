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
            $em = $this->getDoctrine()->getManager();
            $json = $request->get("data",null);
            $params = json_decode($json);
            // var_dump($params);
            // die();

            
            // $imoCfgValorActivo = $em->getRepository('JHWEBInsumoBundle:ImoCfgValor')->findOneByActivo(true);
            // if ($imoCfgValorActivo) {
            //     $imoCfgValorActivo->setActivo(false);
            // }

            $casoInsumo = $em->getRepository('JHWEBInsumoBundle:ImoCfgTipo')->find($params->idCasoInsumo); 
            
            $imoCfgValor = new ImoCfgValor();
            $fecha = new \DateTime($params->fecha);

            $imoCfgValor->setImoCfgTipo($casoInsumo);
            $imoCfgValor->setValor($params->valor);
            $imoCfgValor->setFecha($fecha);
            $imoCfgValor->setActivo(false);

            $em->persist($imoCfgValor);
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
     * Finds and displays a Cuenta entity.
     *
     * @Route("/show/casoInsumo/{idTipoInsumo}", name="imocfgvalor_show")
     * @Method("POST")
     */
    public function showAction(Request $request,$idTipoInsumo)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $valores = $em->getRepository('JHWEBInsumoBundle:ImoCfgValor')->findByImoCfgTipo($idTipoInsumo);
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "valores encontrada", 
                    'data'=> $valores,
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
