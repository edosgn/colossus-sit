<?php

namespace JHWEB\FinancieroBundle\Controller;

use JHWEB\FinancieroBundle\Entity\FroTrteCarpeta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Frotrtecarpetum controller.
 *
 * @Route("frotrtecarpeta")
 */
class FroTrteCarpetaController extends Controller
{
    /**
     * Lists all froTrteCarpetum entities.
     *
     * @Route("/", name="frotrtecarpeta_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $froTrteCarpetas = $em->getRepository('JHWEBFinancieroBundle:FroTrteCarpeta')->findAll();

        return $this->render('frotrtecarpeta/index.html.twig', array(
            'froTrteCarpetas' => $froTrteCarpetas,
        ));
    }

    /**
     * Finds and displays a froTrteCarpetum entity.
     *
     * @Route("/{id}", name="frotrtecarpeta_show")
     * @Method("GET")
     */
    public function showAction(FroTrteCarpeta $froTrteCarpetum)
    {

        return $this->render('frotrtecarpeta/show.html.twig', array(
            'froTrteCarpetum' => $froTrteCarpetum,
        ));
    }
}
