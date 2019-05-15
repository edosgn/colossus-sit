<?php

namespace JHWEB\UsuarioBundle\Controller;

use JHWEB\UsuarioBundle\Entity\UserEmpresaSucursal;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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
                    'empresa' => $params->id
                )
            );

            if ($sucursales) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Empresa encontrada",
                    'data' => $sucursales,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Empresa no encontrada",
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
