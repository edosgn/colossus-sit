<?php

namespace JHWEB\FinancieroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Frotrtehojacontrol controller.
 *
 * @Route("frotrtehojacontrol")
 */
class FroTrteHojaControlController extends Controller
{
    
    /**
     * Busca un vehiculos segun los filtros .
     *
     * @Route("/search/filter", name="frotrtehojacontrol_search_filter")
     * @Method({"GET", "POST"})
     */
    public function searchByFilterAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->getByPlaca($params->filtro);

            if ($vehiculo) {
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Registro encontrado.', 
                    'data'=> $vehiculo
                );
            }else{
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Registro no encontrado en base de datos.', 
                );
            }            
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorización no válida', 
            );
        }

        return $helpers->json($response);
    }

    /**
     * Genera la hoja de control del un vehiculo
     *
     * @Route("/{idVehiculo}/hojacontrol/pdf", name="frotrtehojacontrol_hojacontrol_pdf")
     * @Method({"GET","POST"})
     */
    public function pdfAction(Request $request, $idVehiculo)
    {        
        $em = $this->getDoctrine()->getManager();
        
        setlocale(LC_ALL, "es_ES");
        $fechaActual = strftime("%d de %B del %Y");

        $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->find($idVehiculo);

        $idUltimoTrteSolicitud = $em->getRepository('JHWEBFinancieroBundle:FroTrteSolicitud')->getLastByVehiculo($idVehiculo);
        $ultimoTrteSolicitud = $em->getRepository('JHWEBFinancieroBundle:FroTrteSolicitud')->find($idUltimoTrteSolicitud['idTramiteSolicitud']);



        $facturaArchivo = $em->getRepository('JHWEBFinancieroBundle:FroFacArchivo')->findOneBy(
            array(
                'factura' => $ultimoTrteSolicitud->getTramiteFactura()->getFactura()->getId()
            )
        );


        $html = $this->renderView('@JHWEBFinanciero/default/pdfHojaControl.template.html.twig', array(
            'fechaActual' => $fechaActual,
            'vehiculo' => $vehiculo,
            'facturaArchivo' => $facturaArchivo,
        ));
        
        $this->get('app.pdf')->templateHojaControl($html);
    }
}
