<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloCfgTransportePasajero;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlocfgtransportepasajero controller.
 *
 * @Route("vhlocfgtransportepasajero")
 */
class VhloCfgTransportePasajeroController extends Controller
{
    /**
     * Lists all vhloCfgTransportePasajero entities.
     *
     * @Route("/", name="vhlocfgtransportepasajero_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $transportesPasajero = $em->getRepository('JHWEBVehiculoBundle:VhloCfgTransportePasajero')->findBy(
            array('activo'=>true)
        );

        $response['data'] = array();

        if ($transportesPasajero) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($transportesPasajero)." Registros encontrados", 
                'data'=> $transportesPasajero,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new vhloCfgTransportePasajero entity.
     *
     * @Route("/new", name="vhlocfgtransportepasajero_new")
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

            $transportePasajero = new VhloCfgTransportePasajero();

            $transportePasajero->setNombre(strtoupper($params->nombre));
            $transportePasajero->setGestionable($params->gestionable);
            $transportePasajero->setActivo(true);
            
            $em->persist($transportePasajero);
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
     * Finds and displays a vhloCfgTransportePasajero entity.
     *
     * @Route("/show", name="vhlocfgtransportepasajero_show")
     * @Method("GET")
     */
    public function showAction(VhloCfgTransportePasajero $vhloCfgTransportePasajero)
    {
        $deleteForm = $this->createDeleteForm($vhloCfgTransportePasajero);

        return $this->render('vhlocfgtransportepasajero/show.html.twig', array(
            'vhloCfgTransportePasajero' => $vhloCfgTransportePasajero,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vhloCfgTransportePasajero entity.
     *
     * @Route("/edit", name="vhlocfgtransportepasajero_edit")
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
            $transportePasajero = $em->getRepository("JHWEBVehiculoBundle:VhloCfgTransportePasajero")->find($params->id);

            if ($transportePasajero) {
                $transportePasajero->setNombre(strtoupper($params->nombre));
                $transportePasajero->setGestionable($params->gestionable);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $transportePasajero,
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
     * Deletes a vhloCfgTransportePasajero entity.
     *
     * @Route("/delete", name="vhlocfgtransportepasajero_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, VhloCfgTransportePasajero $vhloCfgTransportePasajero)
    {
        $form = $this->createDeleteForm($vhloCfgTransportePasajero);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vhloCfgTransportePasajero);
            $em->flush();
        }

        return $this->redirectToRoute('vhlocfgtransportepasajero_index');
    }

    /**
     * Creates a form to delete a vhloCfgTransportePasajero entity.
     *
     * @param VhloCfgTransportePasajero $vhloCfgTransportePasajero The vhloCfgTransportePasajero entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloCfgTransportePasajero $vhloCfgTransportePasajero)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhlocfgtransportepasajero_delete', array('id' => $vhloCfgTransportePasajero->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="vhlocfgtransportepasajero_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $transportesPasajero = $em->getRepository('JHWEBVehiculoBundle:VhloCfgTransportePasajero')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($transportesPasajero as $key => $transportePasajero) {
            $response[$key] = array(
                'value' => $transportePasajero->getId(),
                'label' => $transportePasajero->getNombre()
            );
        }
        
        return $helpers->json($response);
    }
}
