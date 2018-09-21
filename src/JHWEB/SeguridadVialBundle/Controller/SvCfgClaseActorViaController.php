<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgClaseActorVia;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Svcfgclaseactorvium controller.
 *
 * @Route("svcfgclaseactorvia")
 */
class SvCfgClaseActorViaController extends Controller
{
    /**
     * Lists all svCfgClaseActorVium entities.
     *
     * @Route("/", name="svcfgclaseactorvia_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $svCfgClaseActorVias = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgClaseActorVia')->findAll();

        return $this->render('svcfgclaseactorvia/index.html.twig', array(
            'svCfgClaseActorVias' => $svCfgClaseActorVias,
        ));
    }

    /**
     * Finds and displays a svCfgClaseActorVium entity.
     *
     * @Route("/{id}", name="svcfgclaseactorvia_show")
     * @Method("GET")
     */
    public function showAction(SvCfgClaseActorVia $svCfgClaseActorVium)
    {

        return $this->render('svcfgclaseactorvia/show.html.twig', array(
            'svCfgClaseActorVium' => $svCfgClaseActorVium,
        ));
    }
}
