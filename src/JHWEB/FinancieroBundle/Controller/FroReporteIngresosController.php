<?php

namespace JHWEB\FinancieroBundle\Controller;

use JHWEB\FinancieroBundle\Entity\FroReporteIngresos;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Froreporteingreso controller.
 *
 * @Route("froreporteingresos")
 */
class FroReporteIngresosController extends Controller
{
    /**
     * Lists all froReporteIngreso entities.
     *
     * @Route("/", name="froreporteingresos_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $froReporteIngresos = $em->getRepository('JHWEBFinancieroBundle:FroReporteIngresos')->findAll();

        return $this->render('froreporteingresos/index.html.twig', array(
            'froReporteIngresos' => $froReporteIngresos,
        ));
    }

    /**
     * Finds and displays a froReporteIngreso entity.
     *
     * @Route("/{id}", name="froreporteingresos_show")
     * @Method("GET")
     */
    public function showAction(FroReporteIngresos $froReporteIngreso)
    {

        return $this->render('froreporteingresos/show.html.twig', array(
            'froReporteIngreso' => $froReporteIngreso,
        ));
    }

    /**
     * datos para obtener tramites por rango de fechas
     *
     * @Route("/pdf/tramite/fecha", name="frotramite_rango_fechas")
     * @Method({"GET", "POST"})
     */
    public function tramitesByFechaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        setlocale(LC_ALL,"es_ES");
        $fechaActual = strftime("%d de %B del %Y");

        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager(); 
        $json = $request->get("data",null);
        $params = json_decode($json);

        $fechaInicioDatetime = new \Datetime($params->fechaDesde);
        $fechaFinDatetime = new \Datetime($params->fechaHasta);
        $organismoTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find($params->idOrganismoTransito);
            
        $tramites = $em->getRepository('JHWEBFinancieroBundle:FroReporteIngresos')->findTramitesByFecha($fechaInicioDatetime,$fechaFinDatetime,$organismoTransito->getId());

        $pagadas = [];
        $vencidas = [];
        $anuladas = [];

        foreach ($tramites as $key => $tramite) {
            switch ($tramite->getTramiteFactura()->getFactura()->getEstado() ) {
                case 'PAGADA':
                    $pagadas[] = $tramite;
                    break;
                case 'VENCIDA':
                    $vencidas[] = $tramite;
                    break;
                case 'ANULADA':
                    $anuladas[] = $tramite;
                    break;
            }
        }

        $html = $this->renderView('@JHWEBFinanciero/Default/ingresos/pdf.ingresos.tramites.html.twig', array(
            'organismoTransito' => $organismoTransito, 
            'pagadas' => $pagadas, 
            'vencidas' => $vencidas, 
            'anuladas' => $anuladas, 
            'cantPagadas' => count($pagadas), 
            'cantVencidas' => count($vencidas), 
            'cantAnuladas' => count($anuladas), 
        )); 

              
        return new Response(
            $this->get('app.pdf')->templateIngresos($html, $organismoTransito),
            200,
            array(
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="fichero.pdf"'
                )
            );
    }
}
