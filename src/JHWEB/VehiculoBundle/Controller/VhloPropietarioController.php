<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloPropietario;
use JHWEB\UsuarioBundle\Entity\UserLicenciaTransito;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlopropietario controller.
 *
 * @Route("vhlopropietario")
 */
class VhloPropietarioController extends Controller
{
    /**
     * Lists all vhloPropietario entities.
     *
     * @Route("/", name="vhlopropietario_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $vhloPropietarios = $em->getRepository('JHWEBVehiculoBundle:VhloPropietario')->findAll();

        return $this->render('vhlopropietario/index.html.twig', array(
            'vhloPropietarios' => $vhloPropietarios,
        ));
    }

    /**
     * Creates a new vhloPropietario entity.
     *
     * @Route("/new", name="vhlopropietario_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);
            
            $em = $this->getDoctrine()->getManager();  

            if ($params->idVehiculo) {
                $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->find(
                    $params->idVehiculo
                );
            }

            if ($vehiculo) {
                foreach ($params->propietarios as $key => $propietarioArray) {
                    $propietario = new VhloPropietario();

                    if ($propietarioArray->tipo == 'Empresa') {
                        $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->findOneBy(
                            array(
                                'id' => $propietarioArray->idPropietario,
                                'activo' => true,
                            )
                        );

                        $propietario->setEmpresa($empresa);
                    }elseif ($propietarioArray->tipo == 'Ciudadano') {
                        $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findOneBy(
                            array(
                                'id' => $propietarioArray->idPropietario,
                                'activo' => true,
                            )
                        );

                        $propietario->setCiudadano($ciudadano);
                    }

                    if ($propietarioArray->idApoderado) {
                        $apoderado = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findOneBy(
                            array(
                                'id' => $propietarioArray->idApoderado,
                                'activo' => true,
                            )
                        );

                        $propietario->setApoderado($apoderado);
                    }

                    $propietario->setPermiso($propietarioArray->permiso);
                    $propietario->setFechaInicial(new \Datetime(date('Y-m-d')));

                    if ($params->tipoPropiedad == 1) {
                        $propietario->setLeasing(true);
                    }else{
                        $propietario->setLeasing(false);
                    }

                    $propietario->setActivo(true);

                    $propietario->setVehiculo($vehiculo);

                    $em->persist($propietario);
                    $em->flush();

                    if (isset($params->licenciaTransito) && $params->licenciaTransito) {
                        $licenciaTransitoOld = $em->getRepository('JHWEBUsuarioBundle:UserLicenciaTransito')->findOneBy(
                            array(
                                'propietario' => $propietario->getId(),
                                'activo' => true,
                            )
                        );

                        if ($licenciaTransitoOld) {
                            $licenciaTransitoOld->setActivo(false);
                            $em->flush();
                        }

                        $licenciaTransito = new UserLicenciaTransito();

                        $licenciaTransito->setNumero($params->licenciaTransito);
                        $licenciaTransito->setFecha(new \Datetime(date('Y-m-d')));
                        $licenciaTransito->setActivo(true);

                        $licenciaTransito->setPropietario($propietario);

                        $em->persist($licenciaTransito);
                        $em->flush();
                    }
                }

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Propietario creado con exito.', 
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Vehiculo no encontrado.', 
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
     * Finds and displays a vhloPropietario entity.
     *
     * @Route("/{id}/show", name="vhlopropietario_show")
     * @Method("GET")
     */
    public function showAction(VhloPropietario $vhloPropietario)
    {
        $deleteForm = $this->createDeleteForm($vhloPropietario);

        return $this->render('vhlopropietario/show.html.twig', array(
            'vhloPropietario' => $vhloPropietario,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vhloPropietario entity.
     *
     * @Route("/{id}/edit", name="vhlopropietario_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, VhloPropietario $vhloPropietario)
    {
        $deleteForm = $this->createDeleteForm($vhloPropietario);
        $editForm = $this->createForm('JHWEB\VehiculoBundle\Form\VhloPropietarioType', $vhloPropietario);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vhlopropietario_edit', array('id' => $vhloPropietario->getId()));
        }

        return $this->render('vhlopropietario/edit.html.twig', array(
            'vhloPropietario' => $vhloPropietario,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a vhloPropietario entity.
     *
     * @Route("/{id}/delete", name="vhlopropietario_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, VhloPropietario $vhloPropietario)
    {
        $form = $this->createDeleteForm($vhloPropietario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vhloPropietario);
            $em->flush();
        }

        return $this->redirectToRoute('vhlopropietario_index');
    }

    /**
     * Creates a form to delete a vhloPropietario entity.
     *
     * @param VhloPropietario $vhloPropietario The vhloPropietario entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloPropietario $vhloPropietario)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhlopropietario_delete', array('id' => $vhloPropietario->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ============================================== */

    /**
     * Lists all userCfgMenu entities.
     *
     * @Route("/search/filter", name="vhlopropietario_search_filter")
     * @Method({"GET", "POST"})
     */
    public function searchByFilterAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->getByFilter($params->filtro);

            if ($vehiculo) {
                $propietarios = $em->getRepository('JHWEBVehiculoBundle:VhloPropietario')->findBy(
                    array(
                        'vehiculo' => $vehiculo->getId(),
                        'permiso' => true,
                        'estado' => true,
                        'activo' => true,
                    )
                );

                if ($propietarios) {
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => count($propietarios).' propietarios encontrados.', 
                        'data'=> array(
                            'vehiculo' => $vehiculo,
                            'propietarios' => $propietarios,
                        )
                    );
                }else{ 
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => 'Este vehiculo no tiene propietarios registrados, debe realizar una matricula inicial.', 
                        'data' => array(
                            'vehiculo' => $vehiculo,
                            'propietarios' => null,
                        ) 
                    );
                } 
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Registro no encontrado en base de datos.', 
                );
            }            
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida para editar', 
            );
        }


        return $helpers->json($response);
    }

    /**
     * Lists all userCfgMenu entities.
     *
     * @Route("/search/vehiculo", name="vhlovehiculo_search_vehiculo")
     * @Method({"GET", "POST"})
     */
    public function searchByVehiculoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $propietarios = $em->getRepository('JHWEBVehiculoBundle:VhloPropietario')->findBy(
                array(
                    'vehiculo' => $params->idVehiculo
                )
            );

            if ($propietarios) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($propietarios).' registros encontrados.', 
                    'data'=> $propietarios
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Este vehiculo no tiene propietarios registrados, debe realizar una matricula inicial.', 
                );
            }            
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida para editar', 
            );
        }

        return $helpers->json($response);
    }

    /**
     * Elimina el vehiculo al propietario.
     *
     * @Route("/update/vehiculo", name="vhlopropietario_update_vehiculo")
     * @Method({"GET", "POST"})
     */
    public function updateVehiculoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            
            $propietario = $em->getRepository('JHWEBVehiculoBundle:VhloPropietario')->findOneBy(
                array(
                    'ciudadano' => $params->idSolicitante,
                    'vehiculo' => $params->idVehiculo,
                    'activo' => true,
                )
            );

            if ($params->fecha) {
                $propietario->setFechaFinal(new \DateTime($params->fecha));
            }else{
                $propietario->setFechaFinal(new \DateTime(date('Y-m-d')));
            }
            $propietario->setActivo(0);

            $propietarioNew = new VhloPropietario();

            //
            $propietarioNew->setLicenciaTransito(
                $propietario->getLicenciaTransito()
            );
            $propietarioNew->setFechaInicial($propietario->getFechaInicial());
            $propietarioNew->setVehiculo($propietario->getVehiculo());
            $propietarioNew->setTipoPropiedad($propietario->getVehiculo());
            $propietarioNew->setPermiso(false);
            $propietarioNew->setActivo(true);

            
            $em = $this->getDoctrine()->getManager();

            $em->persist($propietarioNew);
            $em->flush();

            $licenciaTransitoOld = $em->getRepository('JHWEBUsuarioBundle:UserLicenciaTransito')->findOneBy(
                array(
                    'propietario' => $propietario->getId(),
                    'activo' => true,
                )
            );

            $licenciaTransitoOld->setActivo(false);
            $em->flush();

            $licenciaTransito = new UserLicenciaTransito();

            $licenciaTransito->setNumero($params->numeroLicenciaTransito);
            $licenciaTransito->setFecha(new \Datetime(date('Y-m-d')));
            $licenciaTransito->setActivo(true);

            $licenciaTransito->setPropietario($propietario);

            $em->persist($licenciaTransito);
            $em->flush();
            
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Propietario actualizado con exito.',
                    'data' => $propietarioNew
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
}
