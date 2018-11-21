<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloCfgTransporteEspecial;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlocfgtransporteespecial controller.
 *
 * @Route("vhlocfgtransporteespecial")
 */
class VhloCfgTransporteEspecialController extends Controller
{
    /**
     * Lists all vhloCfgTransporteEspecial entities.
     *
     * @Route("/", name="vhlocfgtransporteespecial_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $transportesEspecial = $em->getRepository('JHWEBVehiculoBundle:VhloCfgTransporteEspecial')->findBy(
            array('activo'=>true)
        );

        $response['data'] = array();

        if ($transportesEspecial) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($transportesEspecial)." Registros encontrados", 
                'data'=> $transportesEspecial,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new vhloCfgTransporteEspecial entity.
     *
     * @Route("/new", name="vhlocfgtransporteespecial_new")
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

            $transporteEspecial = new VhloCfgTransporteEspecial();

            $transporteEspecial->setNombre(strtoupper($params->nombre));
            $transporteEspecial->setGestionable($params->gestionable);
            $transporteEspecial->setActivo(true);

            if ($params->idTransportePasajero) {
                $transportePasajero = $em->getRepository('JHWEBVehiculoBundle:VhloCfgTransportePasajero')->find(
                    $params->idTransportePasajero
                );
                $transporteEspecial->setTransportePasajero($transportePasajero);
            }
            
            $em->persist($transporteEspecial);
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
     * Finds and displays a vhloCfgTransporteEspecial entity.
     *
     * @Route("/show", name="vhlocfgtransporteespecial_show")
     * @Method("GET")
     */
    public function showAction(VhloCfgTransporteEspecial $vhloCfgTransporteEspecial)
    {
        $deleteForm = $this->createDeleteForm($vhloCfgTransporteEspecial);

        return $this->render('vhlocfgtransporteespecial/show.html.twig', array(
            'vhloCfgTransporteEspecial' => $vhloCfgTransporteEspecial,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vhloCfgTransporteEspecial entity.
     *
     * @Route("/edit", name="vhlocfgtransporteespecial_edit")
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
            $transporteEspecial = $em->getRepository("JHWEBVehiculoBundle:VhloCfgTransporteEspecial")->find($params->id);

            if ($transporteEspecial) {
                $transporteEspecial->setNombre(strtoupper($params->nombre));
                $transporteEspecial->setGestionable($params->gestionable);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $transporteEspecial,
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
     * Deletes a vhloCfgTransporteEspecial entity.
     *
     * @Route("/delete", name="vhlocfgtransporteespecial_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, VhloCfgTransporteEspecial $vhloCfgTransporteEspecial)
    {
        $form = $this->createDeleteForm($vhloCfgTransporteEspecial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vhloCfgTransporteEspecial);
            $em->flush();
        }

        return $this->redirectToRoute('vhlocfgtransporteespecial_index');
    }

    /**
     * Creates a form to delete a vhloCfgTransporteEspecial entity.
     *
     * @param VhloCfgTransporteEspecial $vhloCfgTransporteEspecial The vhloCfgTransporteEspecial entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloCfgTransporteEspecial $vhloCfgTransporteEspecial)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhlocfgtransporteespecial_delete', array('id' => $vhloCfgTransporteEspecial->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="vhlocfgtransporteespecial_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $transportesEspecial = $em->getRepository('JHWEBVehiculoBundle:VhloCfgTransporteEspecial')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($transportesEspecial as $key => $transporteEspecial) {
            $response[$key] = array(
                'value' => $transporteEspecial->getId(),
                'label' => $transporteEspecial->getNombre()
            );
        }
        
        return $helpers->json($response);
    }
}
