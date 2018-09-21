<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgEducacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Svcfgeducacion controller.
 *
 * @Route("svcfgeducacion")
 */
class SvCfgEducacionController extends Controller
{
    /**
     * Lists all svCfgEducacion entities.
     *
     * @Route("/", name="svcfgeducacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $svCfgEducacions = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgEducacion')->findAll();

        return $this->render('svcfgeducacion/index.html.twig', array(
            'svCfgEducacions' => $svCfgEducacions,
        ));
    }

    /**
     * Finds and displays a svCfgEducacion entity.
     *
     * @Route("/{id}", name="svcfgeducacion_show")
     * @Method("GET")
     */
    public function showAction(SvCfgEducacion $svCfgEducacion)
    {

        return $this->render('svcfgeducacion/show.html.twig', array(
            'svCfgEducacion' => $svCfgEducacion,
        ));
    }
}
