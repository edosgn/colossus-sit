<?php

namespace JHWEB\FinancieroBundle\Controller;

use JHWEB\FinancieroBundle\Entity\FroFacArchivo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Frofacarchivo controller.
 *
 * @Route("frofacarchivo")
 */
class FroFacArchivoController extends Controller
{
    /**
     * Lists all froFacArchivo entities.
     *
     * @Route("/", name="frofacarchivo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $froFacArchivos = $em->getRepository('JHWEBFinancieroBundle:FroFacArchivo')->findAll();

        return $this->render('frofacarchivo/index.html.twig', array(
            'froFacArchivos' => $froFacArchivos,
        ));
    }

    /**
     * Finds and displays a froFacArchivo entity.
     *
     * @Route("/{id}", name="frofacarchivo_show")
     * @Method("GET")
     */
    public function showAction(FroFacArchivo $froFacArchivo)
    {

        return $this->render('frofacarchivo/show.html.twig', array(
            'froFacArchivo' => $froFacArchivo,
        ));
    }
}
