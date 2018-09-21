<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgPreventiva;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Svcfgpreventiva controller.
 *
 * @Route("svcfgpreventiva")
 */
class SvCfgPreventivaController extends Controller
{
    /**
     * Lists all svCfgPreventiva entities.
     *
     * @Route("/", name="svcfgpreventiva_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $svCfgPreventivas = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgPreventiva')->findAll();

        return $this->render('svcfgpreventiva/index.html.twig', array(
            'svCfgPreventivas' => $svCfgPreventivas,
        ));
    }

    /**
     * Finds and displays a svCfgPreventiva entity.
     *
     * @Route("/{id}", name="svcfgpreventiva_show")
     * @Method("GET")
     */
    public function showAction(SvCfgPreventiva $svCfgPreventiva)
    {

        return $this->render('svcfgpreventiva/show.html.twig', array(
            'svCfgPreventiva' => $svCfgPreventiva,
        ));
    }
}
