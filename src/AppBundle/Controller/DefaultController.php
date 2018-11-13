<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CfgFestivo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Cuenta controller.
 *
 * @Route("/default")
 */ 
class DefaultController extends Controller
{

    
    /**
     * Creates a new Cuenta entity.
     *
     * @Route("/pdf/certificadoTradicion/{placaId}", name="pdf")
     * @Method({"GET", "POST"})
     */
    public function pdfAction(Request $request,$placaId)
    {
        setlocale(LC_ALL,"es_ES");
        $fechaActual = strftime("%d de %B del %Y");

        $em = $this->getDoctrine()->getManager();
        
        $asignaciones = $em->getRepository('AppBundle:MpersonalAsignacion')->findByFuncionario(
            1
        );
        
        $vehiculo = $em->getRepository('AppBundle:Vehiculo')->findOneByPlaca(
            $placaId 
        ); 
              

        $propietariosVehiculo = $em->getRepository('AppBundle:PropietarioVehiculo')->findByVehiculo(
            $vehiculo->getId()
        );

        $tramitesSolicitud = $em->getRepository('AppBundle:TramiteSolicitud')->findByVehiculo($vehiculo->getId());

        $tramitesSolicitudArray = false;
        
        foreach ($tramitesSolicitud as $tramiteSolicitud) {

            foreach ((array)$tramiteSolicitud->getResumen() as $key => $value) {
                $data[] = $key.":".$value;
            }  

            $tramitesSolicitudArray[]= array(
                'fecha' => $tramiteSolicitud->getFecha(),
                'tramiteNombre' => $tramiteSolicitud->getTramiteFactura()->getTramitePrecio()->getTramite()->getNombre(),
                'datos' => $data
            );
        }
        
        $html = $this->renderView('@App/default/pdfCertificadoTradicion.html.twig', array(
            'vehiculo'=>$vehiculo,
            'propietariosVehiculo' => $propietariosVehiculo,
            'fechaActual' => $fechaActual,
            'tramitesSolicitudArray'=>$tramitesSolicitudArray
        ));

        $pdf = $this->container->get("white_october.tcpdf")->create(
            'PORTRAIT',
            PDF_UNIT,
            PDF_PAGE_FORMAT,
            true,
            'UTF-8',
            false
        );
        $pdf->SetAuthor('qweqwe');
        $pdf->SetTitle('Planilla');
        $pdf->SetSubject('Your client');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        $pdf->setFontSubsetting(true);

        $pdf->SetFont('helvetica', '', 11, '', true);
        $pdf->SetMargins('25', '25', '25');
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->AddPage();

        $pdf->writeHTMLCell(
            $w = 0,
            $h = 0,
            $x = '',
            $y = '',
            $html,
            $border = 0,
            $ln = 1,
            $fill = 0,
            $reseth = true,
            $align = '',
            $autopadding = true
        );

        $pdf->Output("example.pdf", 'I');
        die();
    }
}
