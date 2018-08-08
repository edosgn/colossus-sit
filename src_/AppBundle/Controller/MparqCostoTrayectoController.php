<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MparqCostoTrayecto;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Mparqcostotrayecto controller.
 *
 * @Route("mparqcostotrayecto")
 */
class MparqCostoTrayectoController extends Controller
{
    /**
     * Lists all mparqCostoTrayecto entities.
     *
     * @Route("/", name="mparqcostotrayecto_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $costosTrayecto = $em->getRepository('AppBundle:MparqCostoTrayecto')->findBy(
            array('activo' => true)
        );

        $response = null;

        if ($costosTrayecto) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "Listado de costos trayecto", 
                'data'=> $costosTrayecto,
            );
        }
         
        return $helpers->json($response);
    }

    /**
     * Creates a new mparqCostoTrayecto entity.
     *
     * @Route("/new", name="mparqcostotrayecto_new")
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
            // if (count($params)==0) {
            //     $response = array(
            //         'status' => 'error',
            //         'code' => 400,
            //         'msj' => "Los campos no pueden estar vacios", 
            //     );
            // }else{

                $mparqcostotrayecto = new MparqCostoTrayecto();

                $mparqcostotrayecto->setOrigen($params->origen);
                $mparqcostotrayecto->setDestino($params->destino);
                $mparqcostotrayecto->setCosto($params->costo);

                $em = $this->getDoctrine()->getManager();
                $em->persist($mparqcostotrayecto);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro creado con exito", 
                );
            // }
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
     * Finds and displays a mparqCostoTrayecto entity.
     *
     * @Route("/{id}", name="mparqcostotrayecto_show")
     * @Method("GET")
     */
    public function showAction(MparqCostoTrayecto $mparqCostoTrayecto)
    {
        $deleteForm = $this->createDeleteForm($mparqCostoTrayecto);

        return $this->render('mparqcostotrayecto/show.html.twig', array(
            'mparqCostoTrayecto' => $mparqCostoTrayecto,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing mparqCostoTrayecto entity.
     *
     * @Route("/{id}/edit", name="mparqcostotrayecto_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MparqCostoTrayecto $mparqCostoTrayecto)
    {
        $deleteForm = $this->createDeleteForm($mparqCostoTrayecto);
        $editForm = $this->createForm('AppBundle\Form\MparqCostoTrayectoType', $mparqCostoTrayecto);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mparqcostotrayecto_edit', array('id' => $mparqCostoTrayecto->getId()));
        }

        return $this->render('mparqcostotrayecto/edit.html.twig', array(
            'mparqCostoTrayecto' => $mparqCostoTrayecto,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a mparqCostoTrayecto entity.
     *
     * @Route("/{id}", name="mparqcostotrayecto_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MparqCostoTrayecto $mparqCostoTrayecto)
    {
        $form = $this->createDeleteForm($mparqCostoTrayecto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mparqCostoTrayecto);
            $em->flush();
        }

        return $this->redirectToRoute('mparqcostotrayecto_index');
    }

    /**
     * Creates a form to delete a mparqCostoTrayecto entity.
     *
     * @param MparqCostoTrayecto $mparqCostoTrayecto The mparqCostoTrayecto entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MparqCostoTrayecto $mparqCostoTrayecto)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mparqcostotrayecto_delete', array('id' => $mparqCostoTrayecto->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="mparqcostotrayecto_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $costoTrayectos = $em->getRepository('AppBundle:MparqCostoTrayecto')->findBy(
            array('activo' => true)
        );

        foreach ($costoTrayectos as $key => $costoTrayecto) {
            $response[$key] = array(
                'value' => $costoTrayecto->getId(),
                'label' => $costoTrayecto->getOrigen()." - ".$costoTrayecto->getDestino()
            );
        }
        return $helpers->json($response);
    }
}
