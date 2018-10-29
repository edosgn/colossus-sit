<?php

namespace JHWEB\PersonalBundle\Controller;

use JHWEB\PersonalBundle\Entity\PnalProroga;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Pnalproroga controller.
 *
 * @Route("pnalproroga")
 */
class PnalProrogaController extends Controller
{
 
    /**
     * Lists all cvCfgPorcentajeInicial entities.
     *
     * @Route("/", name="cvcfgporcentajeinicial_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $pnalProrogas = $em->getRepository('JHWEBPersonalBundle:PnalProroga')->findBy(
            array(
                'activo' => true
            )
        );

        $response['data'] = array();

        if ($pnalProrogas) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($pnalProrogas)." registros encontrados", 
                'data'=> $pnalProrogas,
            );
        }

        return $helpers->json($response);
    }


    /**
     * Creates a new pnalProroga entity.
     *
     * @Route("/new", name="pnalproroga_new")
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

            $pnalProroga = new Pnalproroga();

            // $ciudadano = $em->getRepository('AppBundle:MpersonalFuncionario')->find(
            //     $usuario->getId()
            // );

            $fechaInicio = new \DateTime($params->fechaInicio);
            $fechaFin = new \DateTime($params->fechaFin);
            $mPersonalFuncionario = $em->getRepository('AppBundle:MpersonalFuncionario')->find($params->mPersonalFuncionarioId);

            $mPersonalFuncionario->setFechaFin($fechaFin);
            $mPersonalFuncionario->setModificatorio(true);
            $em->persist($mPersonalFuncionario);

            $pnalProroga->setFechaInicio($fechaInicio);
            $pnalProroga->setFechaFin($fechaFin);
            $pnalProroga->setNumeroModificatorio($params->numeroModificatorio);
            $pnalProroga->setMPersonalFuncionario($mPersonalFuncionario);
            
            $em->persist($pnalProroga);
            $em->flush();
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con éxito",
            );
        
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
     * Finds and displays a pnalProroga entity.
     *
     * @Route("/{id}", name="pnalproroga_show")
     * @Method("GET")
     */
    public function showAction(PnalProroga $pnalProroga)
    {
        $deleteForm = $this->createDeleteForm($pnalProroga);

        return $this->render('pnalproroga/show.html.twig', array(
            'pnalProroga' => $pnalProroga,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing pnalProroga entity.
     *
     * @Route("/{id}/edit", name="pnalproroga_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, PnalProroga $pnalProroga)
    {
        $deleteForm = $this->createDeleteForm($pnalProroga);
        $editForm = $this->createForm('JHWEB\PersonalBundle\Form\PnalProrogaType', $pnalProroga);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pnalproroga_edit', array('id' => $pnalProroga->getId()));
        }

        return $this->render('pnalproroga/edit.html.twig', array(
            'pnalProroga' => $pnalProroga,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a pnalProroga entity.
     *
     * @Route("/{id}", name="pnalproroga_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, PnalProroga $pnalProroga)
    {
        $form = $this->createDeleteForm($pnalProroga);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pnalProroga);
            $em->flush();
        }

        return $this->redirectToRoute('pnalproroga_index');
    }

    /**
     * Creates a form to delete a pnalProroga entity.
     *
     * @param PnalProroga $pnalProroga The pnalProroga entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PnalProroga $pnalProroga)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pnalproroga_delete', array('id' => $pnalProroga->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
