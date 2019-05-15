<?php

namespace JHWEB\UsuarioBundle\Controller;

use JHWEB\UsuarioBundle\Entity\UserEmpresaSucursal;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Userempresasucursal controller.
 *
 * @Route("userempresasucursal")
 */
class UserEmpresaSucursalController extends Controller
{
    /**
     * Lists all userEmpresaSucursal entities.
     *
     * @Route("/", name="userempresasucursal_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $userEmpresaSucursals = $em->getRepository('JHWEBUsuarioBundle:UserEmpresaSucursal')->findAll();

        return $this->render('userempresasucursal/index.html.twig', array(
            'userEmpresaSucursals' => $userEmpresaSucursals,
        ));
    }

    /**
     * Creates a new userEmpresaSucursal entity.
     *
     * @Route("/new", name="userempresasucursal_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $json = $request->get("data", null);
            $params = json_decode($json);

            $sucursal = new UserEmpresaSucursal();

            $sucursal->setNombre($params->nombre);
            $sucursal->setSigla($params->sigla);
            
            $municipio = $em->getRepository('JHWEBConfigBundle:CfgMunicipio')->find($params->idMunicipio);
            $sucursal->setMunicipio($municipio);

            $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->find($params->idEmpresa);
            $sucursal->setEmpresa($empresa);
            
            $sucursal->setDireccion($params->direccion);
            $sucursal->setCorreo($params->correo);
            $sucursal->setTelefono($params->telefono);
            $sucursal->setCelular($params->celular);
            $sucursal->setFax($params->fax);
            $sucursal->setActivo(true);

            $em->persist($sucursal);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con exito",
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
     * Finds and displays a userEmpresaSucursal entity.
     *
     * @Route("/{id}", name="userempresasucursal_show")
     * @Method("GET")
     */
    public function showAction(UserEmpresaSucursal $userEmpresaSucursal)
    {

        return $this->render('userempresasucursal/show.html.twig', array(
            'userEmpresaSucursal' => $userEmpresaSucursal,
        ));
    }
 
    /**
     * Displays a form to edit an existing userEmpresaSucursal entity.
     *
     * @Route("/edit", name="usercfgempresasucursal_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();

            $sucursal = $em->getRepository("JHWEBUsuarioBundle:UserEmpresaSucursal")->find($params->id);

            if ($sucursal!=null) {
                $sucursal->setNombre($params->nombre);
                $sucursal->setSigla($params->sigla);
                
                $municipio = $em->getRepository('JHWEBConfigBundle:CfgMunicipio')->find($params->idMunicipio);
                $sucursal->setMunicipio($municipio);

                $sucursal->setDireccion($params->direccion);
                $sucursal->setCorreo($params->correo);
                $sucursal->setTelefono($params->telefono);
                $sucursal->setCelular($params->celular);
                $sucursal->setFax($params->fax);

                $em->persist($sucursal);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $sucursal,
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
                'message' => "Autorizacion no validar", 
            );
        }
        return $helpers->json($response);
    }

     /**
     * Deletes a userEmpresaSucursal entity.
     *
     * @Route("/delete", name="userempresasucursal_delete")
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

            $sucursal = $em->getRepository('JHWEBUsuarioBundle:UserEmpresaSucursal')->find($params->id);
            $sucursal->setActivo(false);
            $em->persist($sucursal);
            $em->flush();
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro eliminado con exito", 
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
            );
        }
        return $helpers->json($response);
    }

    /**
     * Busca sucursales por empresa.
     *
     * @Route("/sucursales/by/empresa", name="userempresasucursal_by_empresa")
     * @Method({"GET", "POST"})
     */
    public function getSucursalesByEmpresaAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        
        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $sucursales = $em->getRepository('JHWEBUsuarioBundle:UserEmpresaSucursal')->findBy(
                array(
                    'empresa' => $params,
                    'activo' => true
                )
            );

            if ($sucursales) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Sucursales entontradas",
                    'data' => $sucursales,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "La empresa no tiene sucursales registradas.",
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida",
            );
        }
        return $helpers->json($response);
    }
}
