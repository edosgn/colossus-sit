<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgSeguridadCiudadana;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Svcfgseguridadciudadana controller.
 *
 * @Route("svcfgseguridadciudadana")
 */
class SvCfgSeguridadCiudadanaController extends Controller
{
    /**
     * Lists all svCfgSeguridadCiudadana entities.
     *
     * @Route("/", name="svcfgseguridadciudadana_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $svCfgSeguridadCiudadanas = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSeguridadCiudadana')->findAll();

        return $this->render('svcfgseguridadciudadana/index.html.twig', array(
            'svCfgSeguridadCiudadanas' => $svCfgSeguridadCiudadanas,
        ));
    }

    /**
     * Finds and displays a svCfgSeguridadCiudadana entity.
     *
     * @Route("/{id}", name="svcfgseguridadciudadana_show")
     * @Method("GET")
     */
    public function showAction(SvCfgSeguridadCiudadana $svCfgSeguridadCiudadana)
    {

        return $this->render('svcfgseguridadciudadana/show.html.twig', array(
            'svCfgSeguridadCiudadana' => $svCfgSeguridadCiudadana,
        ));
    }
}
