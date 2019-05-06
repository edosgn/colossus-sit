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
        $traspasos = [];

        $valorTramitesPagados = 0;
        $valorTramitesVencidos = 0;
        $valorTramitesAnulados = 0;

        foreach ($tramites as $key => $tramite) {
            switch ($tramite->getTramiteFactura()->getFactura()->getEstado() ) {
                case 'PAGADA':
                    $pagadas[] = $tramite;
                    $valorTramitesPagados += $tramite->getTramiteFactura()->getPrecio()->getValor(); 
    
                    $conceptos = $em->getRepository('JHWEBFinancieroBundle:FroTrteConcepto')->findBy(
                        array(
                            'precio' => $tramite->getTramiteFactura()->getPrecio()->getId(),
                        )
                    );
                    break;
                case 'VENCIDA':
                    $vencidas[] = $tramite;
                    $valorTramitesVencidos += $tramite->getTramiteFactura()->getPrecio()->getValor(); 
                    break;
                case 'ANULADA':
                    $anuladas[] = $tramite;
                    $valorTramitesAnulados += $tramite->getTramiteFactura()->getPrecio()->getValor(); 
                    if($tramite->getTramiteFactura()->getPrecio()->getTramite()->getNombre() == 'TRASPASO') {
                        $traspasos[] = $tramite;
                    }
                    break;
            }
        }


        $sustratos = $em->getRepository('JHWEBInsumoBundle:ImoInsumo')->findBy(
            array (
                'organismoTransito' => $organismoTransito,
                'estado' => 'ASIGNADO',
                'categoria' => 'SUSTRATO',
            )
        );

        /* $insumos = $em->getRepository('JHWEBInsumoBundle:ImoInsumo')->getInsumoRango($fechaInicioDatetime,$fechaFinDatetime,$organismoTransito->getId());

        $disponibles = [];
        $anulados = [];
        $asignados = []; */

        /* foreach ($insumos as $key => $insumo) {
            switch ($insumo->getEstado()) {
                case 'DISPONIBLE':
                    $disponibles[]=$insumo;
                    break;
                case 'ANULADO':
                    $anulados[]=$insumo;
                    break;
                case 'ASIGNADO':
                    $asignados[]=$insumo;
                    break;
            }
        } */

        $html = $this->renderView('@JHWEBFinanciero/Default/ingresos/pdf.ingresos.tramites.html.twig', array(
            'organismoTransito' => $organismoTransito, 
            'pagadas' => $pagadas, 
            'vencidas' => $vencidas, 
            'anuladas' => $anuladas, 
            'cantPagadas' => count($pagadas), 
            'cantVencidas' => count($vencidas), 
            'cantAnuladas' => count($anuladas), 
            'valorTramitesPagados' => $valorTramitesPagados, 
            'valorTramitesVencidos' => $valorTramitesVencidos, 
            'valorTramitesAnulados' => $valorTramitesAnulados, 
            'insumos' => $sustratos,
            'conceptos' => $conceptos,
            'cantConceptos' => count($conceptos),
            'traspasosAnulados' => $traspasos,
            'cantTraspasos' => count($traspasos),
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
