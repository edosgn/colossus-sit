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
     * @Route("/pdf/certificado/tradicion/{placa}/{idFuncionario}/{tipo}", name="pdf")
     * @Method({"GET", "POST"})
     */
    public function pdfAction(Request $request, $placa, $idFuncionario, $tipo)
    {
        setlocale(LC_ALL,"es_ES");
        $fechaActual = strftime("%d de %B del %Y");

        $em = $this->getDoctrine()->getManager();
        
        $funcionario = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->find(
            $idFuncionario
        );
        
        $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->findOneByPlaca(
            $placa
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

        foreach ($tramitesSolicitud as $tramiteSolicitud) {
            $tramitesSolicitudArray[]= array(
                'fecha' => $tramiteSolicitud->getFecha(),
                'tramiteNombre' => $tramiteSolicitud->getTramiteFactura()->getPrecio()->getTramite()->getNombre(),
                'datos' => $tramiteSolicitud->getResumen()
            );
        }
        
        $html = $this->renderView('@App/default/pdfCertificadoTradicion.html.twig', array(
            'vehiculo'=>$vehiculo,
            'funcionario'=>$funcionario,
            'propietarios' => $propietarios,
            'fechaActual' => $fechaActual,
            'tramitesSolicitudArray'=>$tramitesSolicitudArray
        ));
        if($tipo == 'OFICIAL'){
            $this->get('app.pdf.certificado.tradicion')->templatePreview($html, 'Certificado de tradición para uso oficial');
        } else {
            $this->get('app.pdf')->templateCertificadoTradicion($html, $vehiculo->getPlaca()->getNumero(), 'oficial');
        }
    }
}
