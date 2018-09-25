<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgSolidaridad;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Svcfgsolidaridad controller.
 *
 * @Route("svcfgsolidaridad")
 */
class SvCfgSolidaridadController extends Controller
{
    /**
     * Lists all svCfgSolidaridad entities.
     *
     * @Route("/", name="svcfgsolidaridad_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $svCfgSolidaridads = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSolidaridad')->findAll();

        return $this->render('svcfgsolidaridad/index.html.twig', array(
            'svCfgSolidaridads' => $svCfgSolidaridads,
        ));
    }

    /**
     * Finds and displays a svCfgSolidaridad entity.
     *
     * @Route("/{id}", name="svcfgsolidaridad_show")
     * @Method("GET")
     */
    public function showAction(SvCfgSolidaridad $svCfgSolidaridad)
    {

        return $this->render('svcfgsolidaridad/show.html.twig', array(
            'svCfgSolidaridad' => $svCfgSolidaridad,
        ));
    }
}
