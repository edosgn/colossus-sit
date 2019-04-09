<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvIpatTalonario;
use JHWEB\SeguridadVialBundle\Entity\SvIpatConsecutivo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svipattalonario controller.
 *
 * @Route("svipattalonario")
 */
class SvIpatTalonarioController extends Controller
{
    /**
     * Lists all svIpatTalonario entities.
     *
     * @Route("/", name="svipattalonario_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $talonarios = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatTalonario')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($talonarios) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($talonarios) . " registros encontrados",
                'data' => $talonarios,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new svIpatTalonario entity.
     *
     * @Route("/new", name="svipattalonario_new")
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

            $talonario = new SvIpatTalonario();

            $organismoTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find(
                $params->idOrganismoTransito
            );
            $talonario->setOrganismoTransito($organismoTransito);

            $talonario->setRangoInicial($params->rangoInicial);
            $talonario->setRangoFinal($params->rangoFinal);
            $talonario->setTotal($params->total);
            $talonario->setDisponible($params->total);
            $talonario->setFecha(
                new \Datetime($params->fecha)
            );
            $talonario->setNumeroResolucion($params->numeroResolucion);
            $talonario->setActivo(true);

            $em->persist($talonario);
            $em->flush();

            $divipo = $organismoTransito->getDivipo();

            for ($rango = $talonario->getRangoInicial(); $rango <= $talonario->getRangoFinal(); $rango++) {

                $consecutivo = new SvIpatConsecutivo();

                $consecutivo->setTalonario($talonario);
                $consecutivo->setNumero($divipo.$rango);
                $consecutivo->setEstado("DISPONIBLE");
                $consecutivo->setActivo(true);

                $em->persist($consecutivo);
                $em->flush();
            }
        
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Registros creado con exito.', 
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
     * Finds and displays a svIpatTalonario entity.
     *
     * @Route("/show", name="svipattalonario_show")
     * @Method("POST")
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $talonario = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatTalonario')->find(
                $params->id
            );

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro encontrado con exito",
                'data' => $talonario,
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida",
            );
        }

        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing svIpatTalonario entity.
     *
     * @Route("/{id}/edit", name="svipattalonario_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SvIpatTalonario $svIpatTalonario)
    {
        $deleteForm = $this->createDeleteForm($svIpatTalonario);
        $editForm = $this->createForm('JHWEB\SeguridadVialBundle\Form\SvIpatTalonarioType', $svIpatTalonario);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('svipattalonario_edit', array('id' => $svIpatTalonario->getId()));
        }

        return $this->render('svipattalonario/edit.html.twig', array(
            'svIpatTalonario' => $svIpatTalonario,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a svIpatTalonario entity.
     *
     * @Route("/{id}/delete", name="svipattalonario_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SvIpatTalonario $svIpatTalonario)
    {
        $form = $this->createDeleteForm($svIpatTalonario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($svIpatTalonario);
            $em->flush();
        }

        return $this->redirectToRoute('svipattalonario_index');
    }

    /**
     * Creates a form to delete a svIpatTalonario entity.
     *
     * @param SvIpatTalonario $svIpatTalonario The svIpatTalonario entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvIpatTalonario $svIpatTalonario)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svipattalonario_delete', array('id' => $svIpatTalonario->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ============================================================== */

    /**
     * Buscar todos los talonarios por organismo de transito y fecha.
     *
     * @Route("/search/organismotransito/fecha", name="svipattalonario_search_organismotransito_fecha")
     * @Method("POST")
     */
    public function searchByOrganismoTransitoAndFechaAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $fecha = new \Datetime($params->fecha);

            $talonarios = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatTalonario')->findBy(
                array(
                    'organismoTransito' => $params->idOrganismoTransito,
                    'fecha' => $fecha,
                )
            );

            if ($talonarios) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($talonarios) . " registros encontrados.",
                    'data'=> $talonarios,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 300,
                    'message' => 'Registro no encontrado.', 
                );
            }
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
     * Buscar talonario por organismo de transito.
     *
     * @Route("/search/organismotransito", name="svipattalonario_search_organismotransito")
     * @Method("POST")
     */
    public function searchOneByOrganismoTransitoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $talonario = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatTalonario')->findOneBy(
                array(
                    'organismoTransito' => $params->idOrganismoTransito,
                )
            );

            if ($talonario) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Registro encontrado.', 
                    'data'=> $talonario,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 300,
                    'message' => 'Registro no encontrado.', 
                );
            }
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida.', 
            );
        }

        return $helpers->json($response);
    }
}
