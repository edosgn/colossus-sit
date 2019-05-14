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
}
