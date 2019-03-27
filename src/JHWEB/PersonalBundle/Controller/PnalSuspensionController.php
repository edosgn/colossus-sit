<?php

namespace JHWEB\PersonalBundle\Controller;

use JHWEB\PersonalBundle\Entity\PnalSuspension;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Pnalsuspension controller.
 *
 * @Route("pnalsuspension")
 */
class PnalSuspensionController extends Controller
{
    /**
     * Lists all pnalSuspension entities.
     *
     * @Route("/", name="pnalsuspension_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pnalSuspensions = $em->getRepository('JHWEBPersonalBundle:PnalSuspension')->findAll();

        return $this->render('pnalsuspension/index.html.twig', array(
            'pnalSuspensions' => $pnalSuspensions,
        ));
    }

    /**
     * Creates a new pnalSuspension entity.
     *
     * @Route("/new", name="pnalsuspension_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization",null);
        $authCheck = $helpers->authCheck($hash);

        if($authCheck == true){
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $pnalSuspension = new PnalSuspension();

            $fechaActual =  new \DateTime();
            $fechaInicial = new \DateTime($params->fechaInicio);
            $fechaFinal = new \DateTime($params->fechaFin);
            if($fechaInicial > $fechaActual){
                $funcionario = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->find($params->idFuncionario);
    
                $funcionario->setActivo(false);
                $em->persist($funcionario);
    
                $pnalSuspension->setFechaInicial($fechaInicial);
                $pnalSuspension->setFechaFinal($fechaFinal);
                $pnalSuspension->setObservacion($params->observacion);
                $pnalSuspension->setFuncionario($funcionario);
                
                $em->persist($pnalSuspension);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro creado con éxito",
                );
            } elseif($fechaFinal < $fechaActual) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "La fecha final debe ser mayor a la fecha actual",
                );
                return $helpers->json($response);
            } elseif($fechaFinal < $fechaInicial) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "La fecha inicial debe ser mayor a la fecha final",
                );
                return $helpers->json($response);
            }else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "La fecha inicial debe ser mayor o igual a la fecha actual",
                );
                return $helpers->json($response);
            }
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no valida",
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Finds and displays a pnalSuspension entity.
     *
     * @Route("/{id}", name="pnalsuspension_show")
     * @Method("GET")
     */
    public function showAction(PnalSuspension $pnalSuspension)
    {
        $deleteForm = $this->createDeleteForm($pnalSuspension);

        return $this->render('pnalsuspension/show.html.twig', array(
            'pnalSuspension' => $pnalSuspension,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing pnalSuspension entity.
     *
     * @Route("/{id}/edit", name="pnalsuspension_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, PnalSuspension $pnalSuspension)
    {
        $deleteForm = $this->createDeleteForm($pnalSuspension);
        $editForm = $this->createForm('JHWEB\PersonalBundle\Form\PnalSuspensionType', $pnalSuspension);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pnalsuspension_edit', array('id' => $pnalSuspension->getId()));
        }

        return $this->render('pnalsuspension/edit.html.twig', array(
            'pnalSuspension' => $pnalSuspension,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a pnalSuspension entity.
     *
     * @Route("/{id}", name="pnalsuspension_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, PnalSuspension $pnalSuspension)
    {
        $form = $this->createDeleteForm($pnalSuspension);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pnalSuspension);
            $em->flush();
        }

        return $this->redirectToRoute('pnalsuspension_index');
    }

    /**
     * Creates a form to delete a pnalSuspension entity.
     *
     * @param PnalSuspension $pnalSuspension The pnalSuspension entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PnalSuspension $pnalSuspension)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pnalsuspension_delete', array('id' => $pnalSuspension->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
