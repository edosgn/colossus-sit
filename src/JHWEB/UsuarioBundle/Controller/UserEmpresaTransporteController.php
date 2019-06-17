<?php

namespace JHWEB\UsuarioBundle\Controller;

use JHWEB\UsuarioBundle\Entity\UserEmpresaTransporte;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Userempresatransporte controller.
 *
 * @Route("userempresatransporte")
 */
class UserEmpresaTransporteController extends Controller
{
    /**
     * Lists all userEmpresaTransporte entities.
     *
     * @Route("/", name="userempresatransporte_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $empresas = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->findBy(
            array(
                'tipoEmpresa' => 2,
                'activo' => true
            )
        ); 

        if ($empresas) {
            $response = array(
                'tittle' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => count($empresas) . "empresas encontradas",
                'data' => $empresas,
            );
        } else {
            $response = array(
                'tittle' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "No se encontraron registros",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Finds and displays a userEmpresaTransporte entity.
     *
     * @Route("/{id}", name="userempresatransporte_show")
     * @Method("GET")
     */
    public function showAction(UserEmpresaTransporte $userEmpresaTransporte)
    {

        return $this->render('userempresatransporte/show.html.twig', array(
            'userEmpresaTransporte' => $userEmpresaTransporte,
        ));
    }

    /**
     * Busca empresas por NIT.
     *
     * @Route("/search/nit", name="userempresa_transporte_search_nit")
     * @Method({"GET", "POST"})
     */
    public function searchByNitAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        
        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            
            $em = $this->getDoctrine()->getManager();
            
            $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->findOneBy(
                array(
                    'nit' => $params,
                    'tipoEmpresa' => 2,
                    'activo' => true
                )
            ); 

            if ($empresa) {
                $response = array(
                    'tittle' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Empresa encontrada",
                    'data' => $empresa,
                );
            } else {
                $response = array(
                    'tittle' => 'Error!',
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
