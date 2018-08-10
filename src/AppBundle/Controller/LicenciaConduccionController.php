<?php

namespace AppBundle\Controller;

use AppBundle\Entity\LicenciaConduccion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Licenciaconduccion controller.
 *
 * @Route("licenciaconduccion")
 */
class LicenciaConduccionController extends Controller
{
    /**
     * Lists all licenciaConduccion entities.
     *
     * @Route("/", name="licenciaconduccion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $licencias = $em->getRepository('AppBundle:LicenciaConduccion')->findAll();

        $response['data'] = array();

        if ($licencias) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($licencias)." Registros encontrados", 
                'data'=> $licencias,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new licenciaConduccion entity.
     *
     * @Route("/new", name="licenciaconduccion_new")
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
            
            $licenciaConduccion = new LicenciaConduccion();

            $licenciaConduccion->setNumero($params->numeroLicenciaConduccion);
            $licenciaConduccion->setNumeroRunt($params->numeroRunt);
            $licenciaConduccion->setFechaExpedicion(new \Datetime($params->fechaExpedicion));
            $fechaVencimiento = strtotime($params->fechaExpedicion);
            $fechaVencimiento = date('Y-m-d',strtotime('+1 years', $fechaVencimiento));
            $licenciaConduccion->setFechaVencimiento(new \Datetime($fechaVencimiento));
            $licenciaConduccion->setActivo(true);

            if ($params->sedeOperativaId) {
                $sedeOperativa = $em->getRepository('AppBundle:SedeOperativa')->find(
                    $params->sedeOperativaId
                );
                $licenciaConduccion->setSedeOperativa($sedeOperativa);
            }

            if ($params->categoriaId) {
                $categoria = $em->getRepository('AppBundle:CfgLicenciaConduccionCategoria')->find(
                    $params->categoriaId
                );
                $licenciaConduccion->setCategoria($categoria);
            }

            if ($params->claseId) {
                $clase = $em->getRepository('AppBundle:Clase')->find(
                    $params->claseId
                );
                $licenciaConduccion->setClase($clase);
            }

            if ($params->servicioId) {
                $servicio = $em->getRepository('AppBundle:Servicio')->find(
                    $params->servicioId
                );
                $licenciaConduccion->setServicio($servicio);
            }

            if (isset($params->tramiteFacturaId)) {
                $tramiteFactura = $em->getRepository('AppBundle:TramiteFactura')->find(
                    $params->tramiteFacturaId
                );
                $licenciaConduccion->setTramiteFactura($tramiteFactura);
            }

            if ($params->ciudadanoId) {
                $usuario = $em->getRepository('UsuarioBundle:Usuario')->find(
                    $params->ciudadanoId
                );

                $ciudadano = $em->getRepository('AppBundle:Ciudadano')->findOneByUsuario(
                    $usuario->getId()
                );
                $licenciaConduccion->setCiudadano($ciudadano);
            }

            if (isset($params->paisId)) {
                $pais = $em->getRepository('AppBundle:Pais')->find(
                    $params->paisId
                );
                $licenciaConduccion->setPais($pais);
            }
            
            $em->persist($licenciaConduccion);
            $em->flush();
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Licencia de conducción creada con éxito",
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
     * Finds and displays a licenciaConduccion entity.
     *
     * @Route("/{id}", name="licenciaconduccion_show")
     * @Method("GET")
     */
    public function showAction(LicenciaConduccion $licenciaConduccion)
    {
        $deleteForm = $this->createDeleteForm($licenciaConduccion);

        return $this->render('licenciaconduccion/show.html.twig', array(
            'licenciaConduccion' => $licenciaConduccion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing licenciaConduccion entity.
     *
     * @Route("/{id}/edit", name="licenciaconduccion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, LicenciaConduccion $licenciaConduccion)
    {
        $deleteForm = $this->createDeleteForm($licenciaConduccion);
        $editForm = $this->createForm('AppBundle\Form\LicenciaConduccionType', $licenciaConduccion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('licenciaconduccion_edit', array('id' => $licenciaConduccion->getId()));
        }

        return $this->render('licenciaconduccion/edit.html.twig', array(
            'licenciaConduccion' => $licenciaConduccion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a licenciaConduccion entity.
     *
     * @Route("/{id}", name="licenciaconduccion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, LicenciaConduccion $licenciaConduccion)
    {
        $form = $this->createDeleteForm($licenciaConduccion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($licenciaConduccion);
            $em->flush();
        }

        return $this->redirectToRoute('licenciaconduccion_index');
    }

    /**
     * Creates a form to delete a licenciaConduccion entity.
     *
     * @param LicenciaConduccion $licenciaConduccion The licenciaConduccion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(LicenciaConduccion $licenciaConduccion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('licenciaconduccion_delete', array('id' => $licenciaConduccion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* =============================================================== */

    /**
     * Search all licenciaConduccion form entity by ciudadanoId.
     *
     * @Route("/record/ciudadano/id", name="licenciaconduccion_record_id")
     * @Method({"GET", "POST"})
     */
    public function recordByCiudadanoIdAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization",null);
        $authCheck = $helpers->authCheck($hash);
        if($authCheck == true){
            $json = $request->get("json",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            if ($params->ciudadanoId) {
                $licencias = $em->getRepository('AppBundle:LicenciaConduccion')->findBy(
                    array(
                        'ciudadano' => $params->ciudadanoId
                    )
                );

                if ($licencias) {
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => count($licencias)." registros encontrados.",
                        'data' => $licencias,
                    );
                }else{
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "El ciudadano no tiene un historial de licencias de conducción",
                    );
                }
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El ID del ciudadano no ha sido recibido",
                );
            }
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
     * Search one licenciaConduccion form entity vigente.
     *
     * @Route("/search/vigente", name="licenciaconduccion_vigente")
     * @Method({"GET", "POST"})
     */
    public function searchVigenteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization",null);
        $authCheck = $helpers->authCheck($hash);
        if($authCheck == true){
            $em = $this->getDoctrine()->getManager();

            $licencia = $em->getRepository('AppBundle:LicenciaConduccion')->findOneBy(
                array(
                    'activo' => true
                )
            );

            if ($licencia) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "El ciudadano si tiene al menos una licencia de conducción vigente",
                    'data' => $licencias,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El ciudadano no tiene ninguna licencia de conducción vigente",
                );
            }
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
     * Validate if tipoIdentificacion is TI.
     *
     * @Route("/validate/tipo/identificacion/ciudadano/id", name="licenciaconduccion_validate_tipo_identificacion")
     * @Method({"GET", "POST"})
     */
    public function validateTipoIdentificacionByCiudadanoIdAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization",null);
        $authCheck = $helpers->authCheck($hash);
        if($authCheck == true){
            $json = $request->get("json",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            if ($params->ciudadanoId) {
                $ciudadano = $em->getRepository('AppBundle:Ciudadano')->find(
                    $params->ciudadanoId
                );

                if ($ciudadano->getUsuario()) {
                    if ($ciudadano->getUsuario()->getTipoIdentificacion()->getSigla() == 'TI') {
                        $response = array(
                            'status' => 'success',
                            'code' => 200,
                            'message' => "El ciudadano aún tiene tarjeta de identidad.",
                            'data' => $ciudadano->getUsuario(),
                        );
                    }else{
                        $response = array(
                            'status' => 'error',
                            'code' => 400,
                            'message' => "No se puede realizar el trámite porque el tipo de identificación actual no es válido.",
                        );
                    }
                    
                }else{
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "El ciudadano no tiene datos vinculados como usuario.",
                    );
                }
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El ID del ciudadano no ha sido recibido",
                );
            }
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no valida",
            );
        }
        return $helpers->json($response);
    }
}
