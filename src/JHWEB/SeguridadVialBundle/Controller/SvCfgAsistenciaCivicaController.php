<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgAsistenciaCivica;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Svcfgasistenciacivica controller.
 *
 * @Route("svcfgasistenciacivica")
 */
class SvCfgAsistenciaCivicaController extends Controller
{
    /**
     * Lists all svCfgAsistenciaCivica entities.
     *
     * @Route("/", name="svcfgasistenciacivica_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $svCfgAsistenciaCivicas = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgAsistenciaCivica')->findAll();

        return $this->render('svcfgasistenciacivica/index.html.twig', array(
            'svCfgAsistenciaCivicas' => $svCfgAsistenciaCivicas,
        ));
    }

    /**
     * Finds and displays a svCfgAsistenciaCivica entity.
     *
     * @Route("/{id}", name="svcfgasistenciacivica_show")
     * @Method("GET")
     */
    public function showAction(SvCfgAsistenciaCivica $svCfgAsistenciaCivica)
    {

        return $this->render('svcfgasistenciacivica/show.html.twig', array(
            'svCfgAsistenciaCivica' => $svCfgAsistenciaCivica,
        ));
    }
}
