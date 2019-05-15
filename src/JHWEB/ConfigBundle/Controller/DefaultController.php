<?php

namespace JHWEB\ConfigBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('JHWEBConfigBundle:Default:index.html.twig');
    }

    /**
     * PDF
     *
     * @Route("/minuta/estados/{id}/pdf", name="minuta_estados_pdf")
     * @Method({"GET", "POST"})
     */
    public function minutaEstadosPdfAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        
        $em = $this->getDoctrine()->getManager();

        setlocale(LC_ALL,"es_ES");
        $fechaActual = strftime("%d de %B del %Y");

        $trazabilidad = $em->getRepository('JHWEBContravencionalBundle:CvCdoTrazabilidad')->find(
            $id
        );

        $fecha = $helpers->convertDateTime($trazabilidad->getFecha());

        $trazabilidades = $em->getRepository('JHWEBContravencionalBundle:CvCdoTrazabilidad')->findBy(
            array(
                'estado' => 14,
                'fecha' => $fecha
            )
        );

        $html = $this->renderView('@JHWEBConfig/Default/pdf.minuta.estados.html.twig', array(
            'trazabilidades' => $trazabilidades,
            'fechaActual' => $fechaActual,
        ));

        $this->get('app.pdf')->templatePreview($html, 'MINUTA ESTADOS');
    }
}
