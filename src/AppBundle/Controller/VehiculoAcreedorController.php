<?php

namespace AppBundle\Controller;

use AppBundle\Entity\VehiculoAcreedor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Vehiculoacreedor controller.
 *
 * @Route("vehiculoacreedor")
 */
class VehiculoAcreedorController extends Controller
{
    /**
     * Lists all vehiculoAcreedor entities.
     *
     * @Route("/", name="vehiculocreedor_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $vehiculoAcreedor = $em->getRepository('AppBundle:VehiculoAcreedor')->findBy(
            array('estado' => 1)
        );
        $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado acreedores", 
                    'data'=> $vehiculoAcreedor,
            );
         
        return $helpers->json($response);
    }

    /**
     * Creates a new vehiculoAcreedor entity.
     *
     * @Route("/new", name="vehiculoacreedor_new")
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
            $placa = $params->vehiculoPlaca;
            
            $em = $this->getDoctrine()->getManager();
            $placaId = $em->getRepository('AppBundle:CfgPlaca')->findOneByNumero($placa);
            $vehiculo = $em->getRepository('AppBundle:Vehiculo')->findOneByPlaca($placaId->getId());
            $cfgTipoAlerta = $em->getRepository('AppBundle:CfgTipoAlerta')->find($params->tipoAlerta);
            $gradoAlerta = $params->gradoAlerta;
            
            $vehiculoAcreedor = new VehiculoAcreedor();

            if ($params->acreedoresCiudadanos) {
                foreach ($params->acreedoresCiudadanos as $key => $ciudadano) {
                    
                    $usuario = $em->getRepository('UsuarioBundle:Usuario')->findOneBy(
                        array(
                            'estado' => 'Activo',
                            'identificacion' => $ciudadano->identificacion
                            )
                        );
                        
                       
                        $acreedorVehiculo = new VehiculoAcreedor();
                        $acreedorVehiculo->setCiudadano($usuario->getCiudadano());
                        $acreedorVehiculo->setVehiculo($vehiculo);
                        $acreedorVehiculo->setCfgTipoAlerta($cfgTipoAlerta);
                        $acreedorVehiculo->setGradoAlerta($gradoAlerta);
                        $acreedorVehiculo->setEstado(true);
                        $em->persist($acreedorVehiculo);
                        $em->flush();
                        
                    }
                }
            if ($params->acreedoresEmpresas) {
                
                foreach ($params->acreedoresEmpresas as $key => $empresa) {
                    $empresaNueva = $em->getRepository('AppBundle:Empresa')->findOneBy(
                        array(
                            'estado' => 1,
                            'nit' => $empresa->nit
                            )
                        );
                        
                        $acreedorVehiculo = new VehiculoAcreedor();
                        $acreedorVehiculo->setEmpresa($empresaNueva);
                        $acreedorVehiculo->setVehiculo($vehiculo);
                        $acreedorVehiculo->setCfgTipoAlerta($cfgTipoAlerta);
                        $acreedorVehiculo->setGradoAlerta($gradoAlerta);
                        $acreedorVehiculo->setEstado(true);
                        $em->persist($acreedorVehiculo);
                        $em->flush();
                        
                    }
                }

            
            

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
     * Finds and displays a vehiculoAcreedor entity.
     *
     * @Route("/{id}/show", name="vehiculoacreedor_show")
     * @Method("GET")
     */
    public function showAction(VehiculoAcreedor $vehiculoAcreedor)
    {
        $deleteForm = $this->createDeleteForm($vehiculoAcreedor);

        return $this->render('vehiculoacreedor/show.html.twig', array(
            'vehiculoAcreedor' => $vehiculoAcreedor,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vehiculoAcreedor entity.
     *
     * @Route("/{id}/edit", name="vehiculoacreedor_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, VehiculoAcreedor $vehiculoAcreedor)
    {
        $deleteForm = $this->createDeleteForm($vehiculoAcreedor);
        $editForm = $this->createForm('AppBundle\Form\VehiculoAcreedorType', $vehiculoAcreedor);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vehiculoacreedor_edit', array('id' => $vehiculoAcreedor->getId()));
        }

        return $this->render('vehiculoacreedor/edit.html.twig', array(
            'vehiculoAcreedor' => $vehiculoAcreedor,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a vehiculoAcreedor entity.
     *
     * @Route("/delete", name="vehiculoacreedor_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        
        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $json = $request->get("json", null);
            $params = json_decode($json);
            
            if ($params->acreedoresCiudadanos) {
                
                foreach ($params->acreedoresCiudadanos as $key => $ciudadano) {
                    $acreedorVehiculo = $em->getRepository('AppBundle:VehiculoAcreedor')->findOneBy(
                        array(
                            'estado' => 1,
                            'ciudadano' => $ciudadano->ciudadanoId
                            )
                        );
                        
                    $acreedorVehiculo->setEstado(false);
                    $em->persist($acreedorVehiculo);
                    $em->flush();
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Ciudadano acreedor eliminado con éxto",
                    );
                        
                    }
                }
            
                if ($params->acreedoresEmpresas) {
                
                foreach ($params->acreedoresEmpresas as $key => $empresa) {
                    $acreedorVehiculo = $em->getRepository('AppBundle:VehiculoAcreedor')->findOneBy(
                        array(
                            'estado' => 1,
                            'empresa' => $empresa->empresaId
                            )
                        );
                        
                        $acreedorVehiculo->setEstado(false);
                        $em->persist($acreedorVehiculo);
                        $em->flush();
                        $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Empresa acreedora eliminada con éxto",
                        );
                    }
                }
                if($params->ciudadanoNewId){
                    $acreedorVehiculoNew = new VehiculoAcreedor();
                    $usuario = $em->getRepository('UsuarioBundle:Usuario')->find($params->ciudadanoNewId);
                    $acreedorVehiculoNew->setCiudadano($usuario->getCiudadano());
                    $acreedorVehiculoNew->setVehiculo($acreedorVehiculo->getVehiculo());
                    $acreedorVehiculoNew->setCfgTipoAlerta($acreedorVehiculo->getCfgTipoAlerta());
                    $acreedorVehiculoNew->setGradoAlerta($acreedorVehiculo->getGradoAlerta());
                    $acreedorVehiculoNew->setEstado(true);
                    $em->persist($acreedorVehiculoNew);
                    $em->flush();
                }

        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorización no válida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a vehiculoAcreedor entity.
     *
     * @param VehiculoAcreedor $vehiculoAcreedor The vehiculoAcreedor entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VehiculoAcreedor $vehiculoAcreedor)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vehiculoacreedor_delete', array('id' => $vehiculoAcreedor->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


    /**
     * busca acreedores por ciudadano.
     *
     * @Route("/search/acreedor", name="vehiculoacreedor_search_acreedor")
     * @Method({"GET", "POST"})
     */
    public function searchAcreedorAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json",null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            $acreedorCiudadano = $em->getRepository('AppBundle:VehiculoAcreedor')->findOneBy(
                        array(
                            'estado' => 1,
                            'ciudadano' => $params
                            )
                        );

            if ($acreedorCiudadano!=null) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "acreedorCiudadano", 
                    'data'=> $acreedorCiudadano,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Ciudadano acreedor no encotrado", 
                );
            }
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
     * busca acreedores por ciudadano.
     *
     * @Route("/search/acreedor/empresa", name="vehiculoacreedor_search_acreedor_empresa")
     * @Method({"GET", "POST"})
     */
    public function searchAcreedorEmpresaAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json",null);
            $params = json_decode($json);
            // var_dump($params);
            // die();
            $em = $this->getDoctrine()->getManager();
            $acreedorCiudadano = $em->getRepository('AppBundle:VehiculoAcreedor')->findOneBy(
                        array(
                            'estado' => 1,
                            'empresa' => $params->id
                            )
                        );

            if ($acreedorCiudadano!=null) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "acreedorCiudadano", 
                    'data'=> $acreedorCiudadano,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Empresa no encotrada como acreedor", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($response);
    }
}
