<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TramiteTraslado;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Tramitetraslado controller.
 *
 * @Route("tramitetraslado")
 */
class TramiteTrasladoController extends Controller
{
    /**
     * Lists all tramiteTraslado entities.
     *
     * @Route("/", name="tramitetraslado_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $tramiteTraslados = $em->getRepository('AppBundle:TramiteTraslado')->findBy(array('estado' => 1));

        $response = array(
            'status' => 'succes',
            'code' => 200,
            'msj' => "Listado Traslado Cuenta",
            'data' => $tramiteTraslados,
        );
        return $helpers -> json($response);
    }

    /**
     * Creates a new tramiteTraslado entity.
     *
     * @Route("/new", name="tramitetraslado_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization",null);
        $authCheck = $helpers->authCheck($hash);

        if($authCheck == true){
            $json = $request->get("json",null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            $vehiculo = $em->getRepository('AppBundle:Vehiculo')->find($params->vehiculoId);
            
                $tramiteTraslado = new TramiteTraslado();
                $tramiteTraslado->setFechaSalida(new \DateTime($params->fechaSalida));
                $tramiteTraslado->setVehiculo($vehiculo);
                $tramiteTraslado->setNumeroGuia($params->numeroGuia);
                $tramiteTraslado->setNombreEmpresa($params->nombreEmpresa);
                $tramiteTraslado->setNumeroRunt($params->numeroRunt);
                $tramiteTraslado->setEstado(true);
                $em->persist($tramiteTraslado);
                $em->flush();
                $response = array(
                            'status' => 'success',
                            'code' => 200,
                            'msj' => "Tramite traslado creado con éxito",
                );    
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorización no valida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Finds and displays a tramiteTraslado entity.
     *
     * @Route("/{id}", name="tramitetraslado_show")
     * @Method("GET")
     */
    public function showAction(TramiteTraslado $tramiteTraslado)
    {
        $deleteForm = $this->createDeleteForm($tramiteTraslado);

        return $this->render('tramitetraslado/show.html.twig', array(
            'tramiteTraslado' => $tramiteTraslado,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing tramiteTraslado entity.
     *
     * @Route("/{id}/edit", name="tramitetraslado_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TramiteTraslado $tramiteTraslado)
    {
        $deleteForm = $this->createDeleteForm($tramiteTraslado);
        $editForm = $this->createForm('AppBundle\Form\TramiteTrasladoType', $tramiteTraslado);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tramitetraslado_edit', array('id' => $tramiteTraslado->getId()));
        }

        return $this->render('tramitetraslado/edit.html.twig', array(
            'tramiteTraslado' => $tramiteTraslado,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a tramiteTraslado entity.
     *
     * @Route("/{id}", name="tramitetraslado_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TramiteTraslado $tramiteTraslado)
    {
        $form = $this->createDeleteForm($tramiteTraslado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tramiteTraslado);
            $em->flush();
        }

        return $this->redirectToRoute('tramitetraslado_index');
    }

    /**
     * Creates a form to delete a tramiteTraslado entity.
     *
     * @param TramiteTraslado $tramiteTraslado The tramiteTraslado entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TramiteTraslado $tramiteTraslado)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tramitetraslado_delete', array('id' => $tramiteTraslado->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

}
