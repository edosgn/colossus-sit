<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgTemaCapacitacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Svcfgtemacapacitacion controller.
 *
 * @Route("svcfgtemacapacitacion")
 */
class SvCfgTemaCapacitacionController extends Controller
{
    /**
     * Lists all svCfgTemaCapacitacion entities.
     *
     * @Route("/", name="svcfgtemacapacitacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $svCfgTemaCapacitacions = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgTemaCapacitacion')->findBy(
            array('estado' => true)
        );

        $response['data'] = array();

        if ($svCfgTemaCapacitacions) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($svCfgTemaCapacitacions) . " registros encontrados",
                'data' => $svCfgTemaCapacitacions,
            );
        }
        return $helpers->json($response);
    }

    /**
     * Finds and displays a svCfgTemaCapacitacion entity.
     *
     * @Route("/{id}", name="svcfgtemacapacitacion_show")
     * @Method("GET")
     */
    public function showAction(SvCfgTemaCapacitacion $svCfgTemaCapacitacion)
    {

        return $this->render('svcfgtemacapacitacion/show.html.twig', array(
            'svCfgTemaCapacitacion' => $svCfgTemaCapacitacion,
        ));
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="tema_capacitacion_select")
     * @Method("GET")
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $temasCapacitaciones = $em->getRepository('JHWEBSeguridadVialBundle\SvCfgTemaCapacitacion')->findBy(
        array('estado' => 1)
    );
      foreach ($temasCapacitaciones as $key => $temaCapacitacion) {
        $response[$key] = array(
            'value' => $temaCapacitacion->getId(),
            //'label' => $municipio->getCodigoDane()."_".$municipio->getNombre(),
            );
      }
       return $helpers->json($response);
    }
}
