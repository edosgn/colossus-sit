<?php

namespace JHWEB\FinancieroBundle\Controller;

use JHWEB\FinancieroBundle\Entity\FroFacTramite;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Frofactramite controller.
 *
 * @Route("frofactramite")
 */
class FroFacTramiteController extends Controller
{
    /**
     * Lists all froFacTramite entities.
     *
     * @Route("/", name="frofactramite_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $froFacTramites = $em->getRepository('JHWEBFinancieroBundle:FroFacTramite')->findAll();

        return $this->render('frofactramite/index.html.twig', array(
            'froFacTramites' => $froFacTramites,
        ));
    }

    /**
     * Creates a new froFacTramite entity.
     *
     * @Route("/new", name="frofactramite_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $froFacTramite = new Frofactramite();
        $form = $this->createForm('JHWEB\FinancieroBundle\Form\FroFacTramiteType', $froFacTramite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($froFacTramite);
            $em->flush();

            return $this->redirectToRoute('frofactramite_show', array('id' => $froFacTramite->getId()));
        }

        return $this->render('frofactramite/new.html.twig', array(
            'froFacTramite' => $froFacTramite,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a froFacTramite entity.
     *
     * @Route("/show", name="frofactramite_show")
     * @Method("POST")
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $tramiteFactura = $em->getRepository('JHWEBFinancieroBundle:FroFacTramite')->find(
                $params->id
            );

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Registro encontrado con exito.',
                'data' => $tramiteFactura
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
     * Displays a form to edit an existing froFacTramite entity.
     *
     * @Route("/{id}/edit", name="frofactramite_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FroFacTramite $froFacTramite)
    {
        $deleteForm = $this->createDeleteForm($froFacTramite);
        $editForm = $this->createForm('JHWEB\FinancieroBundle\Form\FroFacTramiteType', $froFacTramite);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('frofactramite_edit', array('id' => $froFacTramite->getId()));
        }

        return $this->render('frofactramite/edit.html.twig', array(
            'froFacTramite' => $froFacTramite,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a froFacTramite entity.
     *
     * @Route("/{id}/delete", name="frofactramite_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FroFacTramite $froFacTramite)
    {
        $form = $this->createDeleteForm($froFacTramite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($froFacTramite);
            $em->flush();
        }

        return $this->redirectToRoute('frofactramite_index');
    }

    /**
     * Creates a form to delete a froFacTramite entity.
     *
     * @param FroFacTramite $froFacTramite The froFacTramite entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FroFacTramite $froFacTramite)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('frofactramite_delete', array('id' => $froFacTramite->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ========================================== */

    /**
     * datos para factura
     *
     * @Route("/search/tramites/factura", name="frofactramite_search_tramites_factura")
     * @Method({"GET", "POST"})
     */
    public function searchTramitesByFacturaAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        $json = $request->get("data",null);
        $params = json_decode($json);

        $em = $this->getDoctrine()->getManager();

        $tramitesFactura = $em->getRepository('JHWEBFinancieroBundle:FroFacTramite')->findBy(
            array(
                'factura' => $params->idFactura
            )
        );

        $sustrato = false;
        $numeroRunt = false;
        
        if ($tramitesFactura) {
            if (isset($params->idVehiculo)) {
                $propietarios = $em->getRepository('JHWEBVehiculoBundle:VhloPropietario')->findBy(
                    array(
                        'vehiculo' => $params->idVehiculo
                    )
                );

                if ($propietarios) {
                    foreach ($tramitesFactura as $key => $tramiteFactura) {
                        //Valida si alguno de los trámites facturados requiere numero RUNT
                        if ($tramiteFactura->getPrecio()->getTramite()->getId() != 30) {
                            $numeroRunt = true;
                        }

                        //Valida si alguno de los trámites facturados requiere sustrato
                        if ($tramiteFactura->getPrecio()->getTramite()->getSustrato()) {
                            $sustrato = true;
                        }

                        $tramitesFacturaArray[$key] = array(
                            'value' => $tramiteFactura->getId(),
                            'label' => $tramiteFactura->getPrecio()->getNombre(),
                        );
                    }

                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => count($tramitesFactura).' tramites facturados.', 
                        'data'=> array(
                            'tramitesFactura' => $tramitesFacturaArray,
                            'propietarios' => $propietarios,
                            'sustrato' => $sustrato,
                            'numeroRunt' => $numeroRunt,
                        )
                    );
                }else{
                    $matriculaInicial = false;

                    foreach ($tramitesFactura as $key => $tramiteFactura) {
                        //Valida si esta facturado el trámite matricula inicial
                        if ($tramiteFactura->getPrecio()->getTramite()->getId() == 1) {
                            $matriculaInicial = true;
                        }

                        //Valida si alguno de los trámites facturados requiere sustrato
                        if ($tramiteFactura->getPrecio()->getTramite()->getSustrato()) {
                            $sustrato = true;
                        }

                        //Valida si alguno de los trámites facturados requiere sustrato
                        if ($tramiteFactura->getPrecio()->getTramite()->getSustrato()) {
                            $sustrato = true;
                        }

                        $tramitesFacturaArray[$key] = array(
                            'value' => $tramiteFactura->getId(),
                            'label' => $tramiteFactura->getPrecio()->getNombre(),
                        );
                    }

                    if ($matriculaInicial) {
                        $response = array(
                            'status' => 'success',
                            'code' => 200,
                            'message' => count($tramitesFactura).' tramites facturados. Debe iniciar con el registro de matricula inicial.', 
                            'data'=> array(
                                'tramitesFactura' => $tramitesFacturaArray,
                                'propietarios' => null,
                                'sustrato' => $sustrato,
                                'numeroRunt' => $numeroRunt,
                            )
                        );
                    }else{
                        $response = array(
                            'status' => 'error',
                            'code' => 400,
                            'message' => 'Este vehiculo no tiene propietarios registrados, debe realizar una matricula inicial.', 
                        );
                    }
                } 
            }else{
                foreach ($tramitesFactura as $key => $tramiteFactura) {
                    //Valida si alguno de los trámites facturados requiere sustrato
                    if ($tramiteFactura->getPrecio()->getTramite()->getSustrato()) {
                        $sustrato = true;
                    }

                    //Valida si alguno de los trámites facturados requiere numero RUNT
                    if ($tramiteFactura->getPrecio()->getTramite()->getId() != 30) {
                        $numeroRunt = true;
                    }

                    $tramitesFacturaArray[$key] = array(
                        'value' => $tramiteFactura->getId(),
                        'label' => $tramiteFactura->getPrecio()->getNombre(),
                    );
                }

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($tramitesFactura).' tramites facturados.', 
                    'data'=> array(
                        'tramitesFactura' => $tramitesFacturaArray,
                        'sustrato' => $sustrato,
                        'numeroRunt' => $numeroRunt,
                    )
                );
            }
        }else{                    
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Ningún trámite pendiente.', 
            );
        }
       
        return $helpers->json($response);
    }
}
