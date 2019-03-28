<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloActaTraspaso;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Vhloactatraspaso controller.
 *
 * @Route("vhloactatraspaso")
 */
class VhloActaTraspasoController extends Controller
{
    /**
     * Lists all vhloActaTraspaso entities.
     *
     * @Route("/", name="vhloactatraspaso_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $vhloActaTraspasos = $em->getRepository('JHWEBVehiculoBundle:VhloActaTraspaso')->findAll();

        return $this->render('vhloactatraspaso/index.html.twig', array(
            'vhloActaTraspasos' => $vhloActaTraspasos,
        ));
    }
 
    /**
     * Creates a new vhloActaTraspaso entity.
     *
     * @Route("/new", name="vhloactatraspaso_new")
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
            
                $vhloActaTraspaso = new VhloActaTraspaso();

                $vhloActaTraspaso->setNumero($params->numero);

                $tramiteSolicitud = $em->getRepository('AppBundle:TramiteSolicitud')->find(
                    $params->tramiteSolicitud
                );
                $vhloActaTraspaso->setTramiteSolicitud($tramiteSolicitud);

                $entidadJudicial = $em->getRepository('JHWEBConfigBundle:CfgEntidadJudicial')->find(
                    $params->entidadJudicial
                );

                $vhloActaTraspaso->setEntidadJudicial($entidadJudicial);
                $vhloActaTraspaso->setFecha(new \DateTime($params->fecha));
                $vhloActaTraspaso->setNumero($params->numero);


                $em->persist($vhloActaTraspaso);
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
     * Finds and displays a vhloActaTraspaso entity.
     *
     * @Route("/{id}", name="vhloactatraspaso_show")
     * @Method("GET")
     */
    public function showAction(VhloActaTraspaso $vhloActaTraspaso)
    {
        $deleteForm = $this->createDeleteForm($vhloActaTraspaso);

        return $this->render('vhloactatraspaso/show.html.twig', array(
            'vhloActaTraspaso' => $vhloActaTraspaso,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vhloActaTraspaso entity.
     *
     * @Route("/{id}/edit", name="vhloactatraspaso_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, VhloActaTraspaso $vhloActaTraspaso)
    {
        $deleteForm = $this->createDeleteForm($vhloActaTraspaso);
        $editForm = $this->createForm('JHWEB\VehiculoBundle\Form\VhloActaTraspasoType', $vhloActaTraspaso);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vhloactatraspaso_edit', array('id' => $vhloActaTraspaso->getId()));
        }

        return $this->render('vhloactatraspaso/edit.html.twig', array(
            'vhloActaTraspaso' => $vhloActaTraspaso,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a vhloActaTraspaso entity.
     *
     * @Route("/{id}", name="vhloactatraspaso_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, VhloActaTraspaso $vhloActaTraspaso)
    {
        $form = $this->createDeleteForm($vhloActaTraspaso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vhloActaTraspaso);
            $em->flush();
        }

        return $this->redirectToRoute('vhloactatraspaso_index');
    }

    /**
     * Creates a form to delete a vhloActaTraspaso entity.
     *
     * @param VhloActaTraspaso $vhloActaTraspaso The vhloActaTraspaso entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloActaTraspaso $vhloActaTraspaso)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhloactatraspaso_delete', array('id' => $vhloActaTraspaso->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
