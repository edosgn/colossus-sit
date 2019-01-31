<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MsvResultado;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Msvresultado controller.
 *
 * @Route("msvresultado")
 */
class MsvResultadoController extends Controller
{
    /**
     * Lists all msvResultado entities.
     *
     * @Route("/", name="msvresultado_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $msvResultados = $em->getRepository('AppBundle:MsvResultado')->findAll();

        return $this->render('msvresultado/index.html.twig', array(
            'msvResultados' => $msvResultados,
        ));
    }

    /**
     * Finds and displays a msvResultado entity.
     *
     * @Route("/{id}", name="msvresultado_show")
     * @Method("GET")
     */
    public function showAction(MsvResultado $msvResultado)
    {

        return $this->render('msvresultado/show.html.twig', array(
            'msvResultado' => $msvResultado,
        ));
    }
}
