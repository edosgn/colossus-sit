<?php

namespace AppBundle\Controller;

use AppBundle\Entity\LimitacionDatos;
use AppBundle\Entity\VehiculoLimitacion;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;use Symfony\Component\HttpFoundation\Request;

/**
 * Limitaciondato controller.
 *
 * @Route("limitacionDatos")
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
        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);

            $fechaRadicacion = $params[0]->datosLimitacion->fechaRadicacion;
            $municipioId = $params[0]->datosLimitacion->municipioId;
            $departamentoId = $params[0]->datosLimitacion->departamentoId;
            $ciudadanoDemandadoId = $params[0]->datosLimitacion->ciudadanoDemandadoId;
            $ciudadanoDemandanteId = $params[0]->datosLimitacion->ciudadanoDemandanteId;
            $nOrdenJudicial = $params[0]->datosLimitacion->nOrdenJudicial;
            $limitacionId = $params[0]->datosLimitacion->limitacionId;
            $fechaExpedicion = $params[0]->datosLimitacion->fechaExpedicion;
            $tipoProcesoId = $params[0]->datosLimitacion->tipoProcesoId;
            $entidadJudicialId = $params[0]->datosLimitacion->entidadJudicialId;
            $observaciones = $params[0]->datosLimitacion->observaciones;
            $datos = $params[0]->datosLimitacion->datos;
            // $placa = $params[1]->vehiculosLimitacionArray->vehiculos[0]->placa;

            $em = $this->getDoctrine()->getManager();
            $municipio = $em->getRepository('AppBundle:Municipio')->find($municipioId);
            $departamento = $em->getRepository('AppBundle:Departamento')->find($departamentoId);
            $ciudadanoDemandado = $em->getRepository('AppBundle:Ciudadano')->find($ciudadanoDemandadoId);
            $ciudadanoDemandante = $em->getRepository('AppBundle:Ciudadano')->find($ciudadanoDemandanteId);
            $limitacion = $em->getRepository('AppBundle:CfgLimitacion')->find($limitacionId);
            $tipoProceso = $em->getRepository('AppBundle:CfgTipoProceso')->find($tipoProcesoId);
            $entidadJudicial = $em->getRepository('AppBundle:CfgEntidadJudicial')->find($entidadJudicialId);

            $vehiculosLimitacion = $params[1]->vehiculosLimitacionArray;
            foreach ($vehiculosLimitacion->vehiculos as $key => $vehiculoLimitacion) {

                $placaNew = $em->getRepository('AppBundle:CfgPlaca')->findOneByNumero($vehiculoLimitacion->placa);
                $vehiculo = $em->getRepository('AppBundle:Vehiculo')->findOneByPlaca($placaNew);
                // $vehiculoLimitacion = $em->getRepository('AppBundle:VehiculoLimitacion')->findOneBy(
                //     array('vehiculo' => $vehiculo->getId())
                // );
                // $limitacionDatos = $em->getRepository('AppBundle:LimitacionDatos')->findOneBy(
                //     array('nOrdenJudicial' => $nOrdenJudicial,
                //           'fechaExpedicion' => $fechaExpedicion,
                //           'entidadJudicial' => $entidadJudicial,
                //           'limitacion' => $limitacion,  )
                // );

                $vehiculoLimitacion = $em->getRepository('AppBundle:VehiculoLimitacion')->getByDatosAndVehiculo(
                    $vehiculo->getId(),
                    $nOrdenJudicial,
                    $fechaExpedicion,
                    $entidadJudicial,
                    $limitacion->getId()

                );

                if (!$vehiculoLimitacion) {
                    $limitaciondatos = new LimitacionDatos();

                    $limitaciondatos->setFechaRadicacion(new \Datetime($fechaRadicacion));
                    $limitaciondatos->setDepartamento($departamento);
                    $limitaciondatos->setMunicipio($municipio);
                    $limitaciondatos->setCiudadanoDemandado($ciudadanoDemandado);
                    $limitaciondatos->setCiudadanoDemandante($ciudadanoDemandante);
                    $limitaciondatos->setNOrdenJudicial($nOrdenJudicial);
                    $limitaciondatos->setLimitacion($limitacion);
                    $limitaciondatos->setFechaExpedicion(new \Datetime($fechaExpedicion));
                    $limitaciondatos->setTipoProceso($tipoProceso);
                    $limitaciondatos->setEntidadJudicial($entidadJudicial);
                    $limitaciondatos->setObservaciones($observaciones);
                    $limitaciondatos->setDatos($datos);
                    $limitaciondatos->setEstado(true);

                    $em->persist($limitaciondatos);
                    $em->flush();

                    $em = $this->getDoctrine()->getManager();
                    $placa = $vehiculoLimitacion->placa;

                    $vehiculoLimitacionNew = new VehiculoLimitacion();
                    $vehiculoLimitacionNew->setLimitacionDatos($limitaciondatos);
                    $vehiculoLimitacionNew->setVehiculo($vehiculo);

                    $em->persist($vehiculoLimitacionNew);
                    $em->flush();
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Registro creado con exito",
                    );

                } else {
                    $response = array(
                        'status' => 'error',
                        'code' => 450,
                        'msj' => "La limitacion a la propiedad numero ",
                    );
                }

            }

            // $response = array(
            //     'status' => 'success',
            //     'code' => 200,
            //     'msj' => "Registro creado con exito",
            // );

            // }
        } else {
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
