<?php

namespace JHWEB\UsuarioBundle\Controller;

use JHWEB\UsuarioBundle\Entity\UserEmpresaRepresentante;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Userempresarepresentante controller.
 *
 * @Route("userempresarepresentante")
 */
class UserEmpresaRepresentanteController extends Controller
{
    /**
     * Lists all userEmpresaRepresentante entities.
     *
     * @Route("/", name="userempresarepresentante_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $representantes = $em->getRepository('JHWEBUsuarioBundle:UserEmpresaRepresentante')->findBy(
                array(
                    'empresa' => $params->idEmpresa
                )
            );

            if ($representantes) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($representantes)." registros encontrados con exito.", 
                    'data'=> $representantes
                );
            }else{
                $response = array(
                    'titlr' => 'Alerta!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => "La empresa no tiene ningún representante registrado.",
                );
            }
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
     * Finds and displays a userEmpresaRepresentante entity.
     *
     * @Route("/show", name="userempresarepresentante_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $representante = $em->getRepository('JHWEBUsuarioBundle:UserEmpresaRepresentante')->find(
                $params->id
            );

            if ($representante) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado con exito.", 
                    'data'=> $representante,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos.", 
                );
            }
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
            );
        }

        return $helpers->json($response);
    }

    /* ==================================================== */
    /**
     * Lists all userEmpresaRepresentante entities.
     *
     * @Route("/active", name="userempresarepresentante_active")
     * @Method({"GET", "POST"})
     */
    public function activeAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $representante = $em->getRepository('JHWEBUsuarioBundle:UserEmpresaRepresentante')->findOneBy(
                array(
                    'empresa' => $params->idEmpresa,
                    'activo' => true
                )
            );

            if ($representante) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado con exito.", 
                    'data'=> $representante
                );
            }else{
                $response = array(
                    'status' => 'warning',
                    'code' => 400,
                    'message' => "No tiene reresentantes activos", 
                );
            }
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
            );
        }

        return $helpers->json($response);
    }
}
