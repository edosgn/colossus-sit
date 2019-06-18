<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloTpCupo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Vhlotpcupo controller.
 *
 * @Route("vhlotpcupo")
 */
class VhloTpCupoController extends Controller
{
    /**
     * Lists all vhloTpCupo entities.
     *
     * @Route("/", name="vhlotpcupo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $vhloTpCupos = $em->getRepository('JHWEBVehiculoBundle:VhloTpCupo')->findAll();

        return $this->render('vhlotpcupo/index.html.twig', array(
            'vhloTpCupos' => $vhloTpCupos,
        ));
    }

    /**
     * Finds and displays a vhloTpCupo entity.
     *
     * @Route("/{id}", name="vhlotpcupo_show")
     * @Method("GET")
     */
    public function showAction(VhloTpCupo $vhloTpCupo)
    {

        return $this->render('vhlotpcupo/show.html.twig', array(
            'vhloTpCupo' => $vhloTpCupo,
        ));
    }
}
