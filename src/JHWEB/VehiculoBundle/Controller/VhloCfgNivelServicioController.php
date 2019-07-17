<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloCfgNivelServicio;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Vhlocfgnivelservicio controller.
 *
 * @Route("vhlocfgnivelservicio")
 */
class VhloCfgNivelServicioController extends Controller
{
    /**
     * Lists all vhloCfgNivelServicio entities.
     *
     * @Route("/", name="vhlocfgnivelservicio_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $vhloCfgNivelServicios = $em->getRepository('JHWEBVehiculoBundle:VhloCfgNivelServicio')->findAll();

        return $this->render('vhlocfgnivelservicio/index.html.twig', array(
            'vhloCfgNivelServicios' => $vhloCfgNivelServicios,
        ));
    }

    /**
     * Finds and displays a vhloCfgNivelServicio entity.
     *
     * @Route("/{id}", name="vhlocfgnivelservicio_show")
     * @Method("GET")
     */
    public function showAction(VhloCfgNivelServicio $vhloCfgNivelServicio)
    {

        return $this->render('vhlocfgnivelservicio/show.html.twig', array(
            'vhloCfgNivelServicio' => $vhloCfgNivelServicio,
        ));
    }
}
