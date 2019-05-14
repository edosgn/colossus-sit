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
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $userEmpresaRepresentantes = $em->getRepository('JHWEBUsuarioBundle:UserEmpresaRepresentante')->findAll();

        return $this->render('userempresarepresentante/index.html.twig', array(
            'userEmpresaRepresentantes' => $userEmpresaRepresentantes,
        ));
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

            $representantes = $em->getRepository('JHWEBUsuarioBundle:UserEmpresaRepresentante')->findBy(
                array(
                    'empresa' => $params,
                    'activo' => false
                    )
            );
            $representanteVigente = $em->getRepository('JHWEBUsuarioBundle:UserEmpresaRepresentante')->findOneBy(
                array(
                    'empresa' => $params,
                    'activo' => true
                    )
            );
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro encontrado", 
                    'representantes'=> $representantes,
                    'representanteVigente'=> $representanteVigente,
            );
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
