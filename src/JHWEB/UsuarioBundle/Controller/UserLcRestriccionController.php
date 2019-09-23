<?php

namespace JHWEB\UsuarioBundle\Controller;

use JHWEB\UsuarioBundle\Entity\UserLcRestriccion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Userlcrestriccion controller.
 *
 * @Route("userlcrestriccion")
 */
class UserLcRestriccionController extends Controller
{
    /**
     * Lists all userLcRestriccion entities.
     *
     * @Route("/", name="userlcrestriccion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $userLcRestriccions = $em->getRepository('JHWEBUsuarioBundle:UserLcRestriccion')->findAll();

        return $this->render('userlcrestriccion/index.html.twig', array(
            'userLcRestriccions' => $userLcRestriccions,
        ));
    }

    /**
     * Finds and displays a userLcRestriccion entity.
     *
     * @Route("/{id}", name="userlcrestriccion_show")
     * @Method("GET")
     */
    public function showAction(UserLcRestriccion $userLcRestriccion)
    {

        return $this->render('userlcrestriccion/show.html.twig', array(
            'userLcRestriccion' => $userLcRestriccion,
        ));
    }
}
