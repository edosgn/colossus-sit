<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvIpatVictima;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Svipatvictima controller.
 *
 * @Route("svipatvictima")
 */
class SvIpatVictimaController extends Controller
{
    /**
     * Lists all svIpatVictima entities.
     *
     * @Route("/", name="svipatvictima_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $svIpatVictimas = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatVictima')->findAll();

        return $this->render('svipatvictima/index.html.twig', array(
            'svIpatVictimas' => $svIpatVictimas,
        ));
    }

    /**
     * Finds and displays a svIpatVictima entity.
     *
     * @Route("/{id}", name="svipatvictima_show")
     * @Method("GET")
     */
    public function showAction(SvIpatVictima $svIpatVictima)
    {

        return $this->render('svipatvictima/show.html.twig', array(
            'svIpatVictima' => $svIpatVictima,
        ));
    }
}
