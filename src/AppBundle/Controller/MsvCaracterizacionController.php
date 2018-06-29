<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MsvCaracterizacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Msvcaracterizacion controller.
 *
 * @Route("msvcaracterizacion")
 */
class MsvCaracterizacionController extends Controller
{
    /**
     * Lists all msvCaracterizacion entities.
     *
     * @Route("/", name="msvcaracterizacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $msvCaracterizacions = $em->getRepository('AppBundle:MsvCaracterizacion')->findAll();

        return $this->render('msvcaracterizacion/index.html.twig', array(
            'msvCaracterizacions' => $msvCaracterizacions,
        ));
    }

    /**
     * Finds and displays a msvCaracterizacion entity.
     *
     * @Route("/{id}", name="msvcaracterizacion_show")
     * @Method("GET")
     */
    public function showAction(MsvCaracterizacion $msvCaracterizacion)
    {

        return $this->render('msvcaracterizacion/show.html.twig', array(
            'msvCaracterizacion' => $msvCaracterizacion,
        ));
    }
}
