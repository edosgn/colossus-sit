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
     * @Route("/pdf/certificadoTradicion/{placaId}/{tipo}", name="pdf")
     * @Method({"GET", "POST"})
     */
    public function pdfAction(Request $request,$placaId,$tipo)
    {
        setlocale(LC_ALL,"es_ES");
        $fechaActual = strftime("%d de %B del %Y");

        $em = $this->getDoctrine()->getManager();
        
        /*$asignaciones = $em->getRepository('AppBundle:MpersonalAsignacion')->findByFuncionario(
            1
        ); */
        
        $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->findOneByPlaca(
            $placaId 
        );

        if ($vehiculo) {
            $propietarios = $em->getRepository('JHWEBVehiculoBundle:VhloPropietario')->findByVehiculo(
                $vehiculo->getId()
            );

            $tramitesSolicitud = $em->getRepository('JHWEBFinancieroBundle:FroTrteSolicitud')->findByVehiculo(
                $vehiculo->getId()
            );
        }        

        $tramitesSolicitudArray = false;
        
        $data = null;
        foreach ($tramitesSolicitud as $tramiteSolicitud) {

            /*foreach ((array)$tramiteSolicitud->getResumen() as $key => $value) {
                $data[] = $key.":".$value;
            }  */

            $tramitesSolicitudArray[]= array(
                'fecha' => $tramiteSolicitud->getFecha(),
                'tramiteNombre' => $tramiteSolicitud->getTramiteFactura()->getPrecio()->getTramite()->getNombre(),
                'datos' => $tramiteSolicitud->getResumen()
            );
        }
        
        $html = $this->renderView('@App/default/pdfCertificadoTradicion.html.twig', array(
            'vehiculo'=>$vehiculo,
            'propietarios' => $propietarios,
            'fechaActual' => $fechaActual,
            'tramitesSolicitudArray'=>$tramitesSolicitudArray
        ));

        $this->get('app.pdf')->templateCertificadoTradicion($html, $vehiculo, 'oficial');

        /*$pdf = $this->container->get("white_october.tcpdf")->create(
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

        if($tipo == 'OFICIAL'){
            $image_file = __DIR__.'/../../../web/img/marcaAgua.png';
            $pdf->Image($image_file, 50, 50, 100, '', '', '', '', false, 0);
        }
 
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
        die();*/
    }
}
