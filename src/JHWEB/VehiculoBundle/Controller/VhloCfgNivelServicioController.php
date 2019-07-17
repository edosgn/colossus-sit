<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloCfgNivelServicio;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

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
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $nivelesServicio = $em->getRepository('JHWEBVehiculoBundle:VhloCfgNivelServicio')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($nivelesServicio) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($nivelesServicio)." registros encontrados", 
                'data'=> $nivelesServicio,
            );
        }

        return $helpers->json($response);
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
