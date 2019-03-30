<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloAcreedor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Vhloacreedor controller.
 *
 * @Route("vhloacreedor")
 */
class VhloAcreedorController extends Controller
{
    /**
     * Lists all vhloAcreedor entities.
     *
     * @Route("/", name="vhloacreedor_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $vhloAcreedors = $em->getRepository('JHWEBVehiculoBundle:VhloAcreedor')->findAll();

        return $this->render('vhloacreedor/index.html.twig', array(
            'vhloAcreedors' => $vhloAcreedors,
        ));
    }

    /**
     * Creates a new vhloAcreedor entity.
     *
     * @Route("/new", name="vhloacreedor_new")
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
                $propietario = $em->getRepository('JHWEBVehiculoBundle:VhloPropietario')->find(
                    $params->idPropietario
                );

                if ($propietario->getCiudadano()) {
                    $acreedorOld = $em->getRepository('JHWEBVehiculoBundle:VhloAcreedor')->findOneBy(
                        array(
                            'ciudadano' => $propietario->getCiudadano()->getId(),
                            'vehiculo' => $vehiculo->getId(),
                            'activo' => true,
                        )
                    );
                } elseif($propietario->getEmpresa()) {
                    $acreedorOld = $em->getRepository('JHWEBVehiculoBundle:VhloAcreedor')->findOneBy(
                        array(
                            'empresa' => $propietario->getEmpresa()->getId(),
                            'vehiculo' => $vehiculo->getId(),
                            'activo' => true,
                        )
                    );
                }

                if (!$acreedorOld) {
                    $acreedor = new VhloAcreedor();

                    if ($params->idEmpresa) {
                        $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->findOneBy(
                            array(
                                'id' => $params->idEmpresa,
                                'activo' => true,
                            )
                        );

                        $acreedor->setEmpresa($empresa);
                    }elseif ($params->idCiudadano) {
                        $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findOneBy(
                            array(
                                'id' => $params->idCiudadano,
                                'activo' => true,
                            )
                        );

                        $acreedor->setCiudadano($ciudadano);
                    }

                    $acreedor->setPropietario($propietario);

                    $tipoAlerta = $em->getRepository('JHWEBVehiculoBundle:VhloCfgTipoAlerta')->find(
                        $params->idTipoAlerta
                    );
                    $acreedor->setTipoAlerta($tipoAlerta);

                    $acreedor->setGradoAlerta($params->gradoAlerta);
                    $acreedor->setActivo(true);
                    $acreedor->setVehiculo($vehiculo);

                    $vehiculo->setPignorado(true);

                    $em->persist($acreedor);
                    $em->flush();
                    
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => 'Registro creado con exito.', 
                    );
                }else{
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => 'El propietario no puede ser el mismo acreedor.', 
                    ); 
                }
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
     * Finds and displays a vhloAcreedor entity.
     *
     * @Route("/{id}/show", name="vhloacreedor_show")
     * @Method("GET")
     */
    public function showAction(VhloAcreedor $vhloAcreedor)
    {
        $deleteForm = $this->createDeleteForm($vhloAcreedor);

        return $this->render('vhloacreedor/show.html.twig', array(
            'vhloAcreedor' => $vhloAcreedor,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vhloAcreedor entity.
     *
     * @Route("/{id}/edit", name="vhloacreedor_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, VhloAcreedor $vhloAcreedor)
    {
        $deleteForm = $this->createDeleteForm($vhloAcreedor);
        $editForm = $this->createForm('JHWEB\VehiculoBundle\Form\VhloAcreedorType', $vhloAcreedor);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vhloacreedor_edit', array('id' => $vhloAcreedor->getId()));
        }

        return $this->render('vhloacreedor/edit.html.twig', array(
            'vhloAcreedor' => $vhloAcreedor,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a vhloAcreedor entity.
     *
     * @Route("/delete", name="vhloacreedor_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        
        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);
            
            $em = $this->getDoctrine()->getManager();

            $acreedor = $em->getRepository('JHWEBVehiculoBundle:VhloAcreedor')->find(
                $params->id
            );

            $acreedor->setActivo(false);

            $em->flush();

            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro eliminado con éxito", 
                );
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorización no válida", 
                );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a vhloAcreedor entity.
     *
     * @param VhloAcreedor $vhloAcreedor The vhloAcreedor entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloAcreedor $vhloAcreedor)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhloacreedor_delete', array('id' => $vhloAcreedor->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ============================================= */

    /**
     * Busca los acreedores por vehiculo
     *
     * @Route("/search/vehiculo", name="vhloacreedor_search_vehiculo")
     * @Method({"GET", "POST"})
     */
    public function searchByVehiculoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $acreedores = $em->getRepository('JHWEBVehiculoBundle:VhloAcreedor')->findBy(
                array(
                    'vehiculo' => $params->idVehiculo,
                    'activo' => true,
                )
            );

            if ($acreedores) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($acreedores).' registros encontrados.', 
                    'data'=> $acreedores
                );
            }else{
                 $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'El ciudadano o empresa no es acreedor del vehiculo.', 
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
     * Busca cuidadano o empresa por identificacion.
     *
     * @Route("/search/ciudadano/empresa", name="vhloacreedor_search_ciudadano_empresa")
     * @Method({"GET", "POST"})
     */
    public function searchByCiudadanoOrEmpresaAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            if ($params->tipo == 'CIUDADANO') {
                $acreedor = $em->getRepository('JHWEBVehiculoBundle:VhloAcreedor')->findOneBy(
                    array(
                        'ciudadano' => $params->id,
                        'activo' => true,
                    )
                );
            } elseif($params->tipo == 'EMPRESA') {
                $acreedor = $em->getRepository('JHWEBVehiculoBundle:VhloAcreedor')->findOneBy(
                    array(
                        'empresa' => $params->id,
                        'activo' => true,
                    )
                );
            }

            if ($acreedor) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Registro encontrado.', 
                    'data'=> $acreedor
                );
            }else{
                 $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'El ciudadano o empresa no es acreedor del vehiculo.', 
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
     * Busca un acreedor por ciudadano o empresa según el vehiculo
     *
     * @Route("/search/ciudadano/empresa/vehiculo", name="vhloacreedor_search_ciudadano_empresa_vehiculo")
     * @Method({"GET", "POST"})
     */
    public function searchByCiudadanoOrEmpresaAndVehiculoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            if ($params->tipo == 'CIUDADANO') {
                $acreedor = $em->getRepository('JHWEBVehiculoBundle:VhloAcreedor')->findOneBy(
                    array(
                        'ciudadano' => $params->id,
                        'activo' => true,
                    )
                );
            } elseif($params->tipo == 'EMPRESA') {
                $acreedor = $em->getRepository('JHWEBVehiculoBundle:VhloAcreedor')->findOneBy(
                    array(
                        'empresa' => $params->id,
                        'activo' => true,
                    )
                );
            }

            if ($acreedor) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Registro encontrado.', 
                    'data'=> $acreedor
                );
            }else{
                 $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'El ciudadano o empresa no es acreedor del vehiculo.', 
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
     * Busca un acreedor por propietario
     *
     * @Route("/search/propietario", name="vhloacreedor_search_propietario")
     * @Method({"GET", "POST"})
     */
    public function searchByPropietarioAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $acreedor = $em->getRepository('JHWEBVehiculoBundle:VhloAcreedor')->findOneBy(
                array(
                    'propietario' => $params->id,
                    'activo' => true,
                )
            );
           
            if ($acreedor) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Registro encontrado.', 
                    'data'=> $acreedor
                );
            }else{
                 $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'El ciudadano o empresa no es acreedor del vehiculo.', 
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
     * Actualiza un acreedor prendario.
     *
     * @Route("/update", name="vhloacreedor_update")
     * @Method({"GET", "POST"})
     */
    public function updateAction(Request $request)
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
                if ($params->tipo == 'ACREEDOR') {
                    $acreedorOld = $em->getRepository('JHWEBVehiculoBundle:VhloAcreedor')->find(
                        $params->idAcreedor
                    );

                    $acreedorOld->setActivo(false);

                    $acreedor = new VhloAcreedor();

                    if ($params->idEmpresa) {
                        $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->findOneBy(
                            array(
                                'id' => $params->idEmpresa,
                                'activo' => true,
                            )
                        );

                        $acreedor->setEmpresa($empresa);
                    }elseif ($params->idCiudadano) {
                        $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findOneBy(
                            array(
                                'id' => $params->idCiudadano,
                                'activo' => true,
                            )
                        );

                        $acreedor->setCiudadano($ciudadano);
                    }

                    $acreedor->setGradoAlerta($acreedorOld->getGradoAlerta());
                    $acreedor->setTipoAlerta($acreedorOld->getTipoAlerta());
                    
                    $acreedor->setActivo(true);

                    $acreedor->setVehiculo($vehiculo);

                    $em->persist($acreedor);
                    $em->flush();
                }elseif ($params->tipo == 'PROPIETARIO') {
                    $acreedorOld = $em->getRepository('JHWEBVehiculoBundle:VhloAcreedor')->findOneBy(
                        array(
                            'id' => $params->idAcreedor,
                            'activo' => true,
                        )
                    );

                    $acreedorOld->setActivo(false);

                    $acreedor = new VhloAcreedor();

                    $propietario = $em->getRepository('JHWEBVehiculoBundle:VhloPropietario')->findOneBy(
                        array(
                            'id' => $params->idPropietarioNew,
                            'activo' => true,
                        )
                    );
                    $acreedor->setPropietario($propietario);

                    if ($acreedorOld->getEmpresa()) {
                        $acreedor->setEmpresa(
                            $acreedorOld->getEmpresa()
                        );
                    }elseif ($acreedorOld->getCiudadano()) {
                        $acreedor->setCiudadano(
                            $acreedorOld->getCiudadano()
                        );
                    }

                    $acreedor->setGradoAlerta(
                        $acreedorOld->getGradoAlerta()
                    );
                    $acreedor->setTipoAlerta(
                        $acreedorOld->getTipoAlerta()
                    );
                    
                    $acreedor->setActivo(true);

                    $acreedor->setVehiculo($vehiculo);

                    $em->persist($acreedor);
                    $em->flush();
                }

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Registros actualizados con exito.', 
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
}
