<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgPoliciaJudicial;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Svcfgpoliciajudicial controller.
 *
 * @Route("svcfgpoliciajudicial")
 */
class SvCfgPoliciaJudicialController extends Controller
{
    /**
     * Lists all svCfgPoliciaJudicial entities.
     *
     * @Route("/", name="svcfgpoliciajudicial_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $svCfgPoliciaJudicials = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgPoliciaJudicial')->findAll();

        return $this->render('svcfgpoliciajudicial/index.html.twig', array(
            'svCfgPoliciaJudicials' => $svCfgPoliciaJudicials,
        ));
    }

    /**
     * Finds and displays a svCfgPoliciaJudicial entity.
     *
     * @Route("/{id}", name="svcfgpoliciajudicial_show")
     * @Method("GET")
     */
    public function showAction(SvCfgPoliciaJudicial $svCfgPoliciaJudicial)
    {

        return $this->render('svcfgpoliciajudicial/show.html.twig', array(
            'svCfgPoliciaJudicial' => $svCfgPoliciaJudicial,
        ));
    }
}
