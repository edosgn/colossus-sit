<?php
namespace AppBundle\services;

use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Style;
use PHPExcel_Style_Fill;
use PHPExcel_Style_Border;
use PHPExcel_Style_Alignment;
use PHPExcel_Worksheet_HeaderFooterDrawing;
use PHPExcel_Worksheet_HeaderFooter;
use PHPExcel_Worksheet_Drawing;
use PHPExcel_Cell_AdvancedValueBinder;
use PHPExcel_Chart_DataSeriesValues;
use PHPExcel_Chart_DataSeries;
use PHPExcel_Chart_PlotArea;
use PHPExcel_Chart_Legend;
use PHPExcel_Chart_Title;
use PHPExcel_Chart;
use Doctrine\ORM\EntityManager;

class ExcelTemplate {
  //Inicializar
  protected $em;
  protected $objPHPExcel;
  protected $row = 5; //Numero de fila
  protected $col = 'A'; //Columna
  protected $styleSuccess, $styleDanger, $styleBorder; //Estilos de celda
  protected $index = 0;

  public function __construct(EntityManager $em)
  {
    $this->em = $em;

    $this->objPHPExcel = new PHPExcel();

    $this->styleDanger = array(
        'fill'  => array(
          'type'    => PHPExcel_Style_Fill::FILL_SOLID,
          'color'   => array('argb' => 'CC0000')
        )
      );

    $this->styleWarning = array(
        'fill'  => array(
          'type'    => PHPExcel_Style_Fill::FILL_SOLID,
          'color'   => array('argb' => 'FF9933')
        )
      );

    $this->styleSuccess = array(
        'fill'  => array(
          'type'    => PHPExcel_Style_Fill::FILL_SOLID,
          'color'   => array('argb' => '028D5F')
        )
      );

    $this->styleBorder = array(
      'borders' => array(
          'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
          )
      )
    );
  }

  public function newExcel($params) {
    switch ($params->template) {
      case 'templateExcelByTramites':
        $objPHPExcel = $this->templateExcelByTramites($params);
        break;

      case 'templateExcelByInventarioDocumental':
        $objPHPExcel = $this->templateExcelByInventarioDocumental($params);
        break;
    }

    if (!$objPHPExcel) {
      echo('<h1 style="text-align:center;margin-top:20px;color:red;"><b>Alerta!</b><br> <small>La búsqueda no tiene datos asociados</small></h1>');
      die(); 
    }

    //$this->templateExcelMembretes($params, $objPHPExcel);

    $filename = "reporte_".date('Y-m-d').".xlsx";
    // Redirect output to a client’s web browser (Excel2007)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="'.$filename.'"');
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');
    // If you're serving to IE over SSL, then the following may be needed
    header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
    header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header ('Pragma: public'); // HTTP/1.0
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->setIncludeCharts(TRUE);
    $objWriter->save('php://output');
    exit;
  }

  //==============================//START DEFAULT CONFIGURATIONS//==============================//

    /* ==================== ENCABEZADO Y PIE DE PAGINA TRAMITES ===================*/
    public function getMembretesTramites($params){
      // Add some data

      if($params->reporteGeneral == true){
        $this->objPHPExcel->getActiveSheet()->mergeCells('A1:E1');
        $this->objPHPExcel->getActiveSheet()->mergeCells('A2:E2');
        $this->objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->objPHPExcel->setActiveSheetIndex($this->index)
                    /* ->setCellValue('A1', 'INFORME INGRESOS ' . $params->organismoTransito->getNombre()) */
                    ->setCellValue('A1', 'INFORME INGRESOS')
                    ->setCellValue('A2', 'General')
                    ->setCellValue('A3', 'CÓDIGO')
                    ->setCellValue('B3', 'TRAMITES')
                    ->setCellValue('C3', 'CANTIDAD')
                    ->setCellValue('D3', 'VALOR')
                    ->setCellValue('E3', 'TOTAL');
      } else if($params->reporteDetallado == true) {
        $this->objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
        $this->objPHPExcel->getActiveSheet()->mergeCells('A2:I2');
        $this->objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->objPHPExcel->setActiveSheetIndex($this->index)
                    /* ->setCellValue('A1', 'INFORME INGRESOS ' . $params->organismoTransito->getNombre()) */
                    ->setCellValue('A1', 'INFORME INGRESOS')
                    ->setCellValue('A2', 'Detallado')
                    ->setCellValue('A3', 'NRO. FACTURA')
                    ->setCellValue('B3', 'FECHA PAGO')
                    ->setCellValue('C3', 'PLACA/CÉDULA')
                    ->setCellValue('D3', 'NRO. SUSTRATO')
                    ->setCellValue('E3', 'CLASIFICACIONES')
                    ->setCellValue('F3', 'NUMERO SOLICITUD RUNT')
                    ->setCellValue('G3', 'NOMBRE TRÁMITE')
                    ->setCellValue('H3', 'FECHA TRÁMITE')
                    ->setCellValue('I3', 'VALOR PAGADO');
      }
    }

    public function getStyleTramites($params){
        // Set document properties
        if($params->reporteGeneral == true){
          $this->objPHPExcel->getProperties()->setCreator("JHWEB PASTO S.A.S.")
            ->setLastModifiedBy("JHWEB PASTO S.A.S.")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Tramites");

          $this->objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth('10');
          $this->objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth('50');
          $this->objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth('10');
          $this->objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth('20');
          $this->objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth('20');
          $this->objPHPExcel->getActiveSheet()->getStyle("A1:E".$this->row)->applyFromArray($this->styleBorder);
          $this->objPHPExcel->getActiveSheet()->getStyle('A2:E'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
          $this->objPHPExcel->getActiveSheet()->getStyle('A1:E3')->getFont()->setBold(true);
          $this->objPHPExcel->getActiveSheet()->getStyle('A1:E3')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
          $this->objPHPExcel->getActiveSheet()->getStyle('B1:'.$this->col.$this->row)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        } else if($params->reporteDetallado == true) {
          $this->objPHPExcel->getProperties()->setCreator("JHWEB PASTO S.A.S.")
            ->setLastModifiedBy("JHWEB PASTO S.A.S.")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("PQRSF");

          $this->objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth('10');
          $this->objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth('15');
          $this->objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth('20');
          $this->objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth('20');
          $this->objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth('20');
          $this->objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth('20');
          $this->objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth('20');
          $this->objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth('20');
          $this->objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth('20');
          $this->objPHPExcel->getActiveSheet()->getStyle("A1:I".$this->row)->applyFromArray($this->styleBorder);
          $this->objPHPExcel->getActiveSheet()->getStyle('A2:I'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
          $this->objPHPExcel->getActiveSheet()->getStyle('A1:I3')->getFont()->setBold(true);
          $this->objPHPExcel->getActiveSheet()->getStyle('A1:I3')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
          $this->objPHPExcel->getActiveSheet()->getStyle('B1:'.$this->col.$this->row)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        }
    }

    /* ==================== ENCABEZADO Y PIE DE PAGINA INVENTARIO DOCUMENTAL ===================*/
    public function getMembretesInventarioDocumental($params){
        $this->objPHPExcel->getActiveSheet()->mergeCells('A1:P1');
        $this->objPHPExcel->getActiveSheet()->mergeCells('A2:P2');
        $this->objPHPExcel->getActiveSheet()->mergeCells('A3:P3');
        $this->objPHPExcel->getActiveSheet()->mergeCells('A4:I4');
        $this->objPHPExcel->getActiveSheet()->mergeCells('A5:I5');
        $this->objPHPExcel->getActiveSheet()->mergeCells('A6:I6');
        $this->objPHPExcel->getActiveSheet()->mergeCells('A7:I7');
        $this->objPHPExcel->getActiveSheet()->mergeCells('A8:I8');
        $this->objPHPExcel->getActiveSheet()->mergeCells('A9:I9');
        $this->objPHPExcel->getActiveSheet()->mergeCells('D10:E10');
        $this->objPHPExcel->getActiveSheet()->mergeCells('F10:I10');
        $this->objPHPExcel->getActiveSheet()->mergeCells('M4:O4');
        $this->objPHPExcel->getActiveSheet()->mergeCells('M5:O5');
        $this->objPHPExcel->getActiveSheet()->mergeCells('N9:O9');
        $this->objPHPExcel->getActiveSheet()->mergeCells('M11:P11');
        $this->objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->objPHPExcel->setActiveSheetIndex($this->index)
        ->setCellValue('A1', 'REPÚBLICA DE COLOMBIA')
        ->setCellValue('A2', 'GOBERNACIÓN DE NARIÑO')
        ->setCellValue('A3', 'FORMATO ÚNICO DE INVENTARIO DOCUMENTAL')
        ->setCellValue('A4', 'ENTIDAD PRODUCTORA: GOBERNACIÓN DE NARIÑO')
        ->setCellValue('A5', 'UNIDAD ADMINISTRATIVA: SECRETARÍA DE HACIENDA')
        ->setCellValue('A6', 'OFICINA PRODUCTORA: SUBSECRETARÍA DE TRÁNSITO')
        ->setCellValue('A7', 'OBJETO:TRANSFERENCIA DOCUMENTAL')
        ->setCellValue('D10', 'FECHAS EXTREMAS (aaaa-mm-dd)')
        ->setCellValue('F10', 'UNIDAD DE CONSERVACIÓN')
        ->setCellValue('M4', 'HOJA No:___DE:___')
        ->setCellValue('M5', 'REGISTRO DE ENTRADA')
        ->setCellValue('M6', 'AÑO')
        ->setCellValue('N6', 'MES')
        ->setCellValue('O6', 'DIA')
        ->setCellValue('N9', 'N° T: Número de transferencia')
        ->setCellValue('A11', 'NÚMERO DE ORDEN')
        ->setCellValue('B11', 'CÓDIGO')
        ->setCellValue('C11', 'NOMBRE DE LA SERIE SUBSERIE O ASUNTOS')
        ->setCellValue('D11', 'FECHA INICIAL')
        ->setCellValue('E11', 'FECHA FINAL')
        ->setCellValue('F11', 'CAJA')
        ->setCellValue('G11', 'CARPETA')
        ->setCellValue('H11', 'TOMO')
        ->setCellValue('I11', 'OTRO')
        ->setCellValue('J11', 'NÚMERO DE FOLIOS')
        ->setCellValue('K11', 'SOPORTE')
        ->setCellValue('L11', 'FRECUENCIA CONSULTA')
        ->setCellValue('M11', 'NOTAS');
    }

    public function getStyleInventarioDocumental(){
        $this->objPHPExcel->getProperties()->setCreator("JHWEB PASTO S.A.S.")
          ->setLastModifiedBy("JHWEB PASTO S.A.S.")
          ->setTitle("Office 2007 XLSX Test Document")
          ->setSubject("Office 2007 XLSX Test Document")
          ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
          ->setKeywords("office 2007 openxml php")
          ->setCategory("Inventario Documental");

        $this->objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth('10');
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth('10');
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth('30');
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth('15');
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth('15');
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth('10');
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth('10');
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth('10');
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth('10');
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth('10');
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth('10');
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth('10');
        $this->objPHPExcel->getActiveSheet()->getStyle("A1:P".$this->row)->applyFromArray($this->styleBorder);
        $this->objPHPExcel->getActiveSheet()->getStyle('A2:P'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
        $this->objPHPExcel->getActiveSheet()->getStyle('A11:P11')->getFont()->setBold(true);
        //$this->objPHPExcel->getActiveSheet()->getStyle('A1:P3')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $this->objPHPExcel->getActiveSheet()->getStyle('A1:P'.$this->row)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
    }
  //==============================//START TEMPLATES//==============================//

    /* ==================== EXCEL BY TRAMITES ===================*/
    public function templateExcelByTramites($params){
        $em = $this->em;
        $pages = 0;

        $cantidadFacturasDevolucionadas = 0;
        $cantidadFacturasPagadas = 0;
        $cantidadFacturasRetefuente = 0;
        $cantidadFacturasVencidas = 0;
        
        $totalTramitesFinalizados = 0;
        $totalConceptos = 0;
        $totalSustratos = 0;

        $cantidadFacturasGeneradas = 0;

        foreach ($params->filtros['organismosTransito'] as $key => $idOrganismoTransito) {
          $organismoTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find($idOrganismoTransito);
          
          $this->index = $pages;
          $this->row = 4;
          $this->col = 'A';
          
          if ($pages > 0) {
            $this->objPHPExcel->createSheet();
          }
          
          $this->objPHPExcel->setActiveSheetIndex($pages);

          //Imprime la cabecera
          $this->getMembretesTramites($params);

          //Asigna titulo a la pestaña
          $title = $organismoTransito->getMunicipio();

          $this->objPHPExcel->getActiveSheet()->setTitle(substr($title, 0, 100));



          $this->objPHPExcel->setActiveSheetIndex($pages);
          
          /* $this->objPHPExcel->getActiveSheet()->setTitle('TRAMITES'); */
          if($params->reporteGeneral == true) {

            $tramitesFinalizados = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->findTramitesFinalizados(
              $params->filtros['tipoArchivoTramite'],
              $params->filtros['fechaInicio'],
              $params->filtros['fechaFin'],
              [$idOrganismoTransito]
            );

            $facturasDevolucionadas = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->findFacturasDevolucionadas(
              $params->filtros['fechaInicio'],
              $params->filtros['fechaFin'],
              [$idOrganismoTransito]
            );

            $facturasPagadas = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->findFacturasPagadas(
              $params->filtros['fechaInicio'],
              $params->filtros['fechaFin'],
              [$idOrganismoTransito]
            );

            $facturasVencidas = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->findFacturasVencidas(
              $params->filtros['fechaInicio'],
              $params->filtros['fechaFin'],
              [$idOrganismoTransito]
            );

            $facturasRetefuente = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->findFacturasRetefuente(
              $params->filtros['fechaInicio'],
              $params->filtros['fechaFin'],
              [$idOrganismoTransito]
            );

            $facturasGeneradas = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->getFacturasGeneradasByFecha(
              $params->filtros['fechaInicio'],
              $params->filtros['fechaFin'],
              [$idOrganismoTransito]
            );

            foreach ($tramitesFinalizados as $key => $tramiteFinalizado) {
              $totalTramitesFinalizados += intval($tramiteFinalizado['total']);
            }
            foreach ($facturasDevolucionadas as $key => $facturaDevolucionada) {
              $cantidadFacturasDevolucionadas = intval($facturaDevolucionada['cantidad']);
            }
            foreach ($facturasPagadas as $key => $facturaPagada) {
              $cantidadFacturasPagadas = intval($facturaPagada['cantidad']);
            }
            foreach ($facturasRetefuente as $key => $facturaRetefuente) {
              $cantidadFacturasRetefuente = intval($facturaRetefuente['cantidad']);
            }
            foreach ($facturasVencidas as $key => $facturaVencida) {
              $cantidadFacturasVencidas = intval($facturaVencida['cantidad']);
            }

            foreach ($facturasGeneradas as $key => $facturaGenerada) {
              $cantidadFacturasGeneradas = intval($facturaGenerada['cantidad']);
            }

            $sustratos = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->getSustratos(
              $params->filtros['fechaInicio'],
              $params->filtros['fechaFin'],
              [$idOrganismoTransito]
            );

            foreach ($sustratos as $key => $sustrato) {
              $totalSustratos += intval($sustrato['total']);
            }

            $conceptos = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->getConceptos(
              $params->filtros['fechaInicio'],
              $params->filtros['fechaFin'],
              [$idOrganismoTransito]
            );

            foreach ($conceptos as $key => $concepto) {
              $totalConceptos += intval($concepto['total']);
            }
            foreach ($tramitesFinalizados as $key => $tramite) {
              //Imprime los datos
              $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
                'A'.$this->row, $tramite['codigo']
              );
              $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
                'B'.$this->row,  $tramite['nombre']
              );
              $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
                'C'.$this->row,  $tramite['cantidad']
              );
              $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
                'D'.$this->row,  $tramite['valor']
              );
              $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
                'E'.$this->row,  $tramite['total']
              );

              $this->row++;
            }

            $this->objPHPExcel->getActiveSheet()->mergeCells('A'.$this->row.':'.'D'.$this->row);
            $this->objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            
            $this->objPHPExcel->setActiveSheetIndex($this->index)
              ->setCellValue('A'.$this->row, 'TOTAL INGRESOS');
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->row)->getFont()->setBold(true);
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->row)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            
            $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
              'E'.$this->row, $totalTramitesFinalizados
            );
            
            //para los sustratos
            $this->rowSustrato = $this->row+2;
            $this->row2 = $this->row+3;

            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->rowSustrato. ':'.'E'.$this->rowSustrato)->applyFromArray($this->styleBorder);
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->row2 . ':'.'E'.$this->row2)->applyFromArray($this->styleBorder);
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->rowSustrato.':'.'E'.$this->rowSustrato)->getFont()->setBold(true);
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->rowSustrato.':'.'E'.$this->rowSustrato)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

            $this->objPHPExcel->setActiveSheetIndex($this->index)
                    ->setCellValue('B'.$this->rowSustrato, 'SUSTRATOS CDA')
                    ->setCellValue('C'.$this->rowSustrato, 'CANTIDAD')
                    ->setCellValue('D'.$this->rowSustrato, 'VALOR')
                    ->setCellValue('E'.$this->rowSustrato, 'TOTAL');

            foreach ($sustratos as $key => $sustrato) {
              //Imprime los datos
              $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
                'B'.$this->row2,  $sustrato['nombre']
              );
              $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
                'C'.$this->row2,  $sustrato['cantidad']
              );
              $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
                'D'.$this->row2,  $sustrato['valor']
              );
              $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
                'E'.$this->row2,  $sustrato['total']
              );

              $this->row2++;
            }

            $this->objPHPExcel->getActiveSheet()->mergeCells('A'.$this->row2.':'.'D'.$this->row2);
            $this->objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            
            $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue('A'.$this->row2, 'TOTAL SUSTRATOS');
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->row2. ':'.'E'.$this->row2)->applyFromArray($this->styleBorder);
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->row2)->getFont()->setBold(true);
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->row2)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            
            $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
              'E'.$this->row2, $totalSustratos
            );
              
            //para los conceptos
            $this->rowConcepto = $this->row2+2;
            $this->row3 = $this->row2+3;

            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->rowConcepto.':'.'E'.$this->rowConcepto)->getFont()->setBold(true);
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->rowConcepto . ':'.'E'.$this->rowConcepto)->applyFromArray($this->styleBorder);
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->row3 . ':'.'E'.$this->row3)->applyFromArray($this->styleBorder);
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->rowConcepto.':'.'E'.$this->rowConcepto)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

            $this->objPHPExcel->setActiveSheetIndex($this->index)
                    ->setCellValue('A'.$this->rowConcepto, 'CODIGO')
                    ->setCellValue('B'.$this->rowConcepto, 'NOMBRE CONCEPTO')
                    ->setCellValue('C'.$this->rowConcepto, 'CANTIDAD')
                    ->setCellValue('D'.$this->rowConcepto, 'VALOR')
                    ->setCellValue('E'.$this->rowConcepto, 'TOTAL');

            foreach ($conceptos as $key => $concepto) {
              //Imprime los datos
              $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
                'A'.$this->row3,  $concepto['id']
              );
              $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
                'B'.$this->row3,  $concepto['nombre']
              );
              $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
                'C'.$this->row3,  $concepto['cantidad']
              );
              $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
                'D'.$this->row3,  $concepto['valor']
              );
              $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
                'E'.$this->row3,  $concepto['total']
              );

              $this->row3++;
            }

            $this->totalIngresosSubdetra = $this->row3 + 1;

            $this->objPHPExcel->getActiveSheet()->mergeCells('A'.$this->row3.':'.'D'.$this->row3);
            $this->objPHPExcel->getActiveSheet()->mergeCells('A'.$this->totalIngresosSubdetra . ':'.'D'. $this->totalIngresosSubdetra);
            
            $this->objPHPExcel->setActiveSheetIndex($this->index)
              ->setCellValue('A'.$this->row3, 'TOTAL CONCEPTOS')
              ->setCellValue('A'.$this->totalIngresosSubdetra, 'TOTAL INGRESOS SUBDETRA');
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->row3)->getFont()->setBold(true);
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->row3)->applyFromArray($this->styleBorder);
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->totalIngresosSubdetra)->applyFromArray($this->styleBorder);
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->totalIngresosSubdetra)->getFont()->setBold(true);
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->row3)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->totalIngresosSubdetra)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            
            $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
              'E'.$this->row3, $totalConceptos
            );

            $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
              'E'.$this->totalIngresosSubdetra, $totalTramitesFinalizados - $totalSustratos
            );

            //para contadores totales
            //devoluciones
            $this->totalDevoluciones = $this->totalIngresosSubdetra + 2;
            $this->objPHPExcel->getActiveSheet()->mergeCells('A'.$this->totalDevoluciones.':'.'B'.$this->totalDevoluciones);
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->totalDevoluciones . ':'.'E'.$this->totalDevoluciones)->applyFromArray($this->styleBorder);
            $this->objPHPExcel->getActiveSheet()->mergeCells('C'.$this->totalDevoluciones.':'.'E'.$this->totalDevoluciones);

            $this->objPHPExcel->setActiveSheetIndex($this->index)
              ->setCellValue('A'.$this->totalDevoluciones, 'DEVOLUCIÓN');

            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->totalDevoluciones)->getFont()->setBold(true);
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->totalDevoluciones)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            
            $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
              'C'.$this->totalDevoluciones, $cantidadFacturasDevolucionadas
            );

            //devoluciones retefuente
            $this->totalDevolucionesRetefuente = $this->totalDevoluciones + 1;
            $this->objPHPExcel->getActiveSheet()->mergeCells('A'.$this->totalDevolucionesRetefuente.':'.'B'.$this->totalDevolucionesRetefuente);
            $this->objPHPExcel->getActiveSheet()->mergeCells('C'.$this->totalDevolucionesRetefuente.':'.'E'.$this->totalDevolucionesRetefuente);

            $this->objPHPExcel->setActiveSheetIndex($this->index)
              ->setCellValue('A'.$this->totalDevolucionesRetefuente, 'DEVOLUCIÓN RETEFUENTE');

            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->totalDevolucionesRetefuente)->getFont()->setBold(true);
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->totalDevolucionesRetefuente . ':'.'E'.$this->totalDevolucionesRetefuente)->applyFromArray($this->styleBorder);
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->totalDevolucionesRetefuente)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            
            $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
              'C'.$this->totalDevolucionesRetefuente, $cantidadFacturasRetefuente
            );

            //total pagadas
            $this->totalPagadas = $this->totalDevolucionesRetefuente + 2;
            $this->objPHPExcel->getActiveSheet()->mergeCells('A'.$this->totalPagadas.':'.'B'.$this->totalPagadas);
            $this->objPHPExcel->getActiveSheet()->mergeCells('C'.$this->totalPagadas.':'.'E'.$this->totalPagadas);

            $this->objPHPExcel->setActiveSheetIndex($this->index)
              ->setCellValue('A'.$this->totalPagadas, 'CANTIDAD FACTURAS PAGADAS');

            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->totalPagadas)->getFont()->setBold(true);
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->totalPagadas . ':'.'E'.$this->totalPagadas)->applyFromArray($this->styleBorder);
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->totalPagadas)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            
            $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
              'C'.$this->totalPagadas, $cantidadFacturasPagadas
            );

            //total vencidas
            $this->totalVencidas = $this->totalPagadas + 1;
            $this->objPHPExcel->getActiveSheet()->mergeCells('A'.$this->totalVencidas.':'.'B'.$this->totalVencidas);
            $this->objPHPExcel->getActiveSheet()->mergeCells('C'.$this->totalVencidas.':'.'E'.$this->totalVencidas);

            $this->objPHPExcel->setActiveSheetIndex($this->index)
              ->setCellValue('A'.$this->totalVencidas, 'CANTIDAD FACTURAS VENCIDAS');

            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->totalVencidas)->getFont()->setBold(true);
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->totalVencidas . ':'.'E'.$this->totalVencidas)->applyFromArray($this->styleBorder);
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->totalVencidas)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            
            $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
              'C'.$this->totalVencidas, $cantidadFacturasVencidas
            );

            //total generadas
            $this->totalGeneradas = $this->totalVencidas + 1;
            $this->objPHPExcel->getActiveSheet()->mergeCells('A'.$this->totalGeneradas.':'.'B'.$this->totalGeneradas);
            $this->objPHPExcel->getActiveSheet()->mergeCells('C'.$this->totalGeneradas.':'.'E'.$this->totalGeneradas);

            $this->objPHPExcel->setActiveSheetIndex($this->index)
              ->setCellValue('A'.$this->totalGeneradas, 'CANTIDAD FACTURAS GENERADAS');

            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->totalGeneradas)->getFont()->setBold(true);
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->totalGeneradas . ':'.'E'.$this->totalGeneradas)->applyFromArray($this->styleBorder);
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->totalGeneradas)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            
            $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
              'C'.$this->totalGeneradas, $cantidadFacturasGeneradas
            );
          }
          else if($params->reporteDetallado == true) {

            $tramitesFinalizados = $em->getRepository('JHWEBFinancieroBundle:FroFactura')->findTramitesFinalizados(
              $params->filtros['tipoArchivoTramite'],
              $params->filtros['fechaInicio'],
              $params->filtros['fechaFin'],
              [$idOrganismoTransito]
            );

            $totalTramitesFinalizados = 0;

            foreach ($tramitesFinalizados as $key => $tramiteFinalizado) {
              $totalTramitesFinalizados += $tramiteFinalizado['valorPagado'];
            }

            foreach ($tramitesFinalizados as $key => $tramite) {
              $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
                'A'.$this->row, $tramite['numero']
              );
              $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
                'B'.$this->row, $tramite['fechaPago']->format('Y/m/d')
              );
              $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
                'C'.$this->row, $tramite['placa']
              );
              $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
                'D'.$this->row, $tramite['numeroSustrato']
              );
              $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
                'E'.$this->row, $tramite['abreviatura']
              );
              $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
                'F'.$this->row, $tramite['numeroRunt']
              );
              $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
                'G'.$this->row, $tramite['nombreTramite']
              );
              $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
                'H'.$this->row, $tramite['fechaTramite']->format('Y/m/d')
              );
              $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
                'I'.$this->row, $tramite['valorPagado']
              );
              $this->row++;

            }

            $this->total = $this->row + 1;
            
            $this->objPHPExcel->getActiveSheet()->mergeCells('A'.$this->total.':'.'F'.$this->total);
            $this->objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $this->objPHPExcel->setActiveSheetIndex($this->index)
              ->setCellValue('A'.$this->total, 'TOTAL');
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->total)->getFont()->setBold(true);
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->total . ':'.'I'.$this->total)->applyFromArray($this->styleBorder);
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->total)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            
            $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
              'I'.$this->total, $totalTramitesFinalizados
            );
          }
          
          //Otorga estilos
          $this->getStyleTramites($params);
          
          $pages ++;
        }

        $this->objPHPExcel->setActiveSheetIndex(0);

        return $this->objPHPExcel;

    }

    /* ==================== EXCEL BY INVENTARIO DOCUMENTAL ===================*/
    public function templateExcelByInventarioDocumental($params){
        $em = $this->em;
        $pages = 0;

     
        $this->index = $pages;
        $this->row = 12;
        $this->col = 'A';
        
        if ($pages > 0) {
          $this->objPHPExcel->createSheet();
        }
        
        $this->objPHPExcel->setActiveSheetIndex($pages);

        //Imprime la cabecera
        $this->getMembretesInventarioDocumental($params);

        $this->objPHPExcel->getActiveSheet()->setTitle('Inventario Documental');

        $this->objPHPExcel->setActiveSheetIndex($pages);

        foreach ($params->inventarios as $key => $inventario) {
          //Imprime los datos
          $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
            'A'.$this->row, $key + 1
          );
          $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
            'B'.$this->row,  $inventario->getCodigo()
          );
          $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
            'C'.$this->row,  $inventario->getTipo()
          );
          $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
            'D'.$this->row,  $inventario->getFechaInicial()->format('Y-m-d')
          );
          $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
            'E'.$this->row,  $inventario->getFechaFinal()->format('Y-m-d')
          );
          $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
            'F'.$this->row,  $inventario->getCaja()
          );
          $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
            'G'.$this->row,  $inventario->getCarpeta()
          );
          if($inventario->getFolios()){
            $folios = $inventario->getFolios();
          }else{
            $folios = 0;
          }
          $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
            'J'.$this->row,  $folios
          );
          $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
            'K'.$this->row,  'PAPEL'
          );
          $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
            'L'.$this->row,  'B'
          );

          $this->row++;
        }
        
        //Otorga estilos
        $this->getStyleInventarioDocumental();
        
        //$pages ++;
        
        $this->objPHPExcel->setActiveSheetIndex(0);

        return $this->objPHPExcel;
    }
  //==============================//END TEMPLATES//==============================//
}