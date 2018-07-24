<?php

namespace AppBundle\Controller;

use AppBundle\Entity\LimitacionDatos;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Limitaciondato controller.
 *
 * @Route("limitaciondatos")
 */
class LimitacionDatosController extends Controller
{
    /**
     * Lists all limitacionDato entities.
     *
     * @Route("/", name="limitaciondatos_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $limitacionesDatos = $em->getRepository('AppBundle:LimitacionDatos')->findAll();

        $response = array(
            'status' => 'success',
            'code' => 200,
            'msj' => "Lista de datos limitaciones",
            'data' => $limitacionesDatos, 
        );
        return $helpers->json($response);
    }

    /**
     * Creates a new limitacionDato entity.
     *
     * @Route("/new", name="limitaciondatos_new")
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
            
            $fechaRadicacion = $params->fechaRadicacion;
            $municipioId = $params->municipioId;
            $departamentoId = $params->departamentoId;
            $ciudadanoDemandadoId = $params->ciudadanoDemandadoId;
            $ciudadanoDemandanteId = $params->ciudadanoDemandanteId;
            $nOrdenJudicial = $params->nOrdenJudicial;
            $limitacionId = $params->limitacionId;
            $fechaExpedicion = $params->fechaExpedicion;
            $tipoProcesoId = $params->tipoProcesoId;
            $entidadJudicialId = $params->entidadJudicialId;
            $observaciones = $params->observaciones;
            $datos = $params->datos;
            
            $em = $this->getDoctrine()->getManager();
            $municipio = $em->getRepository('AppBundle:Municipio')->find($municipioId);
            $departamento = $em->getRepository('AppBundle:Departamento')->find($departamentoId);
            $ciudadanoDemandado = $em->getRepository('AppBundle:Ciudadano')->find($ciudadanoDemandadoId);
            $ciudadanoDemandante = $em->getRepository('AppBundle:Ciudadano')->find($ciudadanoDemandanteId);
            $limitacion = $em->getRepository('AppBundle:CfgLimitacion')->find($limitacionId);
            $tipoProceso = $em->getRepository('AppBundle:CfgTipoProceso')->find($tipoProcesoId);
            $entidadJudicial = $em->getRepository('AppBundle:CfgEntidadJudicial')->find($entidadJudicial);

            $limitaciondatos = new LimitacionDatos();

            $limitaciondatos->setFechaRadicacion($fechaRadicacion);
            $limitaciondatos->setDepartamento($departamento);
            $limitaciondatos->setMunicipio($municipio);
            $limitaciondatos->setCiudadanoDemandado($ciudadanoDemandado);
            $limitaciondatos->setCiudadanoDemandante($ciudadanoDemandante);
            $limitaciondatos->setNOrdenJudicial($nOrdenJudicial);
            $limitaciondatos->setLimitacion($limitacion);
            $limitaciondatos->setFechaExpedicion($fechaExpedicion);
            $limitaciondatos->setTipoProceso($tipoProceso);
            $limitaciondatos->setEntidadJudicial($entidadJudicial);
            $limitaciondatos->setObservaciones($observaciones);
            $limitaciondatos->setDatos($datos);
            $limitaciondatos->setEstado(true);

            $em->persist($limitaciondatos);
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
     * Finds and displays a limitacionDato entity.
     *
     * @Route("/{id}", name="limitaciondatos_show")
     * @Method("POST")
     */
    public function showAction(LimitacionDatos $limitacionDato)
    {
        $deleteForm = $this->createDeleteForm($limitacionDato);

        return $this->render('limitaciondatos/show.html.twig', array(
            'limitacionDato' => $limitacionDato,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing limitacionDato entity.
     *
     * @Route("/edit", name="limitaciondatos_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, LimitacionDatos $limitacionDato)
    {
        $deleteForm = $this->createDeleteForm($limitacionDato);
        $editForm = $this->createForm('AppBundle\Form\LimitacionDatosType', $limitacionDato);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('limitaciondatos_edit', array('id' => $limitacionDato->getId()));
        }

        return $this->render('limitaciondatos/edit.html.twig', array(
            'limitacionDato' => $limitacionDato,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a limitacionDato entity.
     *
     * @Route("/{id}/delete", name="limitaciondatos_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, LimitacionDatos $limitacionDato)
    {
        $form = $this->createDeleteForm($limitacionDato);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($limitacionDato);
            $em->flush();
        }

        return $this->redirectToRoute('limitaciondatos_index');
    }

    /**
     * Creates a form to delete a limitacionDato entity.
     *
     * @param LimitacionDatos $limitacionDato The limitacionDato entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(LimitacionDatos $limitacionDato)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('limitaciondatos_delete', array('id' => $limitacionDato->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
