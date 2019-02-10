<?php

namespace JHWEB\FinancieroBundle\Controller;

use JHWEB\FinancieroBundle\Entity\FroTrteConcepto;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Frotrteconcepto controller.
 *
 * @Route("frotrteconcepto")
 */
class FroTrteConceptoController extends Controller
{
    /**
     * Lists all froTrteConcepto entities.
     *
     * @Route("/", name="frotrteconcepto_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $froTrteConceptos = $em->getRepository('JHWEBFinancieroBundle:FroTrteConcepto')->findAll();

        return $this->render('frotrteconcepto/index.html.twig', array(
            'froTrteConceptos' => $froTrteConceptos,
        ));
    }

    /**
     * Finds and displays a froTrteConcepto entity.
     *
     * @Route("/{id}", name="frotrteconcepto_show")
     * @Method("GET")
     */
    public function showAction(FroTrteConcepto $froTrteConcepto)
    {

        return $this->render('frotrteconcepto/show.html.twig', array(
            'froTrteConcepto' => $froTrteConcepto,
        ));
    }
}
