<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgFuncion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Svcfgfuncion controller.
 *
 * @Route("svcfgfuncion")
 */
class SvCfgFuncionController extends Controller
{
    /**
     * Lists all svCfgFuncion entities.
     *
     * @Route("/", name="svcfgfuncion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $svCfgFuncions = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgFuncion')->findAll();

        return $this->render('svcfgfuncion/index.html.twig', array(
            'svCfgFuncions' => $svCfgFuncions,
        ));
    }

    /**
     * Finds and displays a svCfgFuncion entity.
     *
     * @Route("/{id}", name="svcfgfuncion_show")
     * @Method("GET")
     */
    public function showAction(SvCfgFuncion $svCfgFuncion)
    {

        return $this->render('svcfgfuncion/show.html.twig', array(
            'svCfgFuncion' => $svCfgFuncion,
        ));
    }
}
