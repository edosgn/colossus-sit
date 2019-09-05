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

    /* ==================== ENCABEZADO Y PIE DE PAGINA ===================*/
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
            ->setCategory("PQRSF");

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
  //==============================//START TEMPLATES//==============================//

    /* ==================== EXCEL BY TRAMITES ===================*/
    public function templateExcelByTramites($params){
        $em = $this->em;
        $pages = 0;

        if ($params) {
          $this->index = $pages;
          $this->row = 4;
          $this->col = 'A';
          
          $this->objPHPExcel->setActiveSheetIndex($pages);

          //Imprime la cabecera
          $this->getMembretesTramites($params);

          //Asigna titulo a la pestaña
          $this->objPHPExcel->getActiveSheet()->setTitle('TRAMITES');


          if($params->reporteGeneral == true) {
            foreach ($params->tramitesFinalizados as $key => $tramite) {
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
              'E'.$this->row, $params->totalTramitesFinalizados
            );
            
            //para los sustratos
            $this->rowSustrato = $this->row+2;
            $this->row2 = $this->row+3;

            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->rowSustrato.':'.'E'.$this->rowSustrato)->getFont()->setBold(true);
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->rowSustrato.':'.'E'.$this->rowSustrato)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

            $this->objPHPExcel->setActiveSheetIndex($this->index)
                    ->setCellValue('B'.$this->rowSustrato, 'SUSTRATOS CDA')
                    ->setCellValue('C'.$this->rowSustrato, 'CANTIDAD')
                    ->setCellValue('D'.$this->rowSustrato, 'VALOR')
                    ->setCellValue('E'.$this->rowSustrato, 'TOTAL');

            foreach ($params->sustratos as $key => $sustrato) {
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
            
            $this->objPHPExcel->setActiveSheetIndex($this->index)
              ->setCellValue('A'.$this->row2, 'TOTAL SUSTRATOS');
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->row2)->getFont()->setBold(true);
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->row2)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            
            $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
              'E'.$this->row2, $params->totalSustratos
            );
              
            //para los conceptos
            $this->rowConcepto = $this->row2+2;
            $this->row3 = $this->row2+3;

            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->rowConcepto.':'.'E'.$this->rowConcepto)->getFont()->setBold(true);
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->rowConcepto.':'.'E'.$this->rowConcepto)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

            $this->objPHPExcel->setActiveSheetIndex($this->index)
                    ->setCellValue('A'.$this->rowConcepto, 'CODIGO')
                    ->setCellValue('B'.$this->rowConcepto, 'NOMBRE CONCEPTO')
                    ->setCellValue('C'.$this->rowConcepto, 'CANTIDAD')
                    ->setCellValue('D'.$this->rowConcepto, 'VALOR')
                    ->setCellValue('E'.$this->rowConcepto, 'TOTAL');

            foreach ($params->conceptos as $key => $concepto) {
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
              ->setCellValue('A'.$this->row3, 'TOTAL SUSTRATOS')
              ->setCellValue('A'.$this->totalIngresosSubdetra, 'TOTAL INGRESOS SUBDETRA');
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->row3)->getFont()->setBold(true);
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->totalIngresosSubdetra)->getFont()->setBold(true);
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->row3)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->totalIngresosSubdetra)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            
            $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
              'E'.$this->row3, $params->totalConceptos
            );

            $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
              'E'.$this->totalIngresosSubdetra, $params->totalTramitesFinalizados - $params->totalSustratos
            );

            //para contadores totales
            //devoluciones
            $this->totalDevoluciones = $this->totalIngresosSubdetra + 2;
            $this->objPHPExcel->getActiveSheet()->mergeCells('A'.$this->totalDevoluciones.':'.'B'.$this->totalDevoluciones);
            $this->objPHPExcel->getActiveSheet()->mergeCells('C'.$this->totalDevoluciones.':'.'E'.$this->totalDevoluciones);

            $this->objPHPExcel->setActiveSheetIndex($this->index)
              ->setCellValue('A'.$this->totalDevoluciones, 'DEVOLUCIÓN');

            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->totalDevoluciones)->getFont()->setBold(true);
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->totalDevoluciones)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            
            $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
              'C'.$this->totalDevoluciones, $params->cantidadFacturasDevolucionadas
            );

            //devoluciones retefuente
            $this->totalDevolucionesRetefuente = $this->totalDevoluciones + 1;
            $this->objPHPExcel->getActiveSheet()->mergeCells('A'.$this->totalDevolucionesRetefuente.':'.'B'.$this->totalDevolucionesRetefuente);
            $this->objPHPExcel->getActiveSheet()->mergeCells('C'.$this->totalDevolucionesRetefuente.':'.'E'.$this->totalDevolucionesRetefuente);

            $this->objPHPExcel->setActiveSheetIndex($this->index)
              ->setCellValue('A'.$this->totalDevolucionesRetefuente, 'DEVOLUCIÓN RETEFUENTE');

            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->totalDevolucionesRetefuente)->getFont()->setBold(true);
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->totalDevolucionesRetefuente)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            
            $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
              'C'.$this->totalDevolucionesRetefuente, $params->cantidadFacturasRetefuente
            );

            //total pagadas
            $this->totalPagadas = $this->totalDevolucionesRetefuente + 2;
            $this->objPHPExcel->getActiveSheet()->mergeCells('A'.$this->totalPagadas.':'.'B'.$this->totalPagadas);
            $this->objPHPExcel->getActiveSheet()->mergeCells('C'.$this->totalPagadas.':'.'E'.$this->totalPagadas);

            $this->objPHPExcel->setActiveSheetIndex($this->index)
              ->setCellValue('A'.$this->totalPagadas, 'CANTIDAD TOTAL FACTURAS PAGADAS');

            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->totalPagadas)->getFont()->setBold(true);
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->totalPagadas)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            
            $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
              'C'.$this->totalPagadas, $params->cantidadFacturasPagadas
            );

            //total vencidas
            $this->totalVencidas = $this->totalPagadas + 1;
            $this->objPHPExcel->getActiveSheet()->mergeCells('A'.$this->totalVencidas.':'.'B'.$this->totalVencidas);
            $this->objPHPExcel->getActiveSheet()->mergeCells('C'.$this->totalVencidas.':'.'E'.$this->totalVencidas);

            $this->objPHPExcel->setActiveSheetIndex($this->index)
              ->setCellValue('A'.$this->totalVencidas, 'CANTIDAD TOTAL FACTURAS VENCIDAS');

            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->totalVencidas)->getFont()->setBold(true);
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->totalVencidas)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            
            $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
              'C'.$this->totalVencidas, $params->cantidadFacturasVencidas
            );

            //total generadas
            $this->totalGeneradas = $this->totalVencidas + 1;
            $this->objPHPExcel->getActiveSheet()->mergeCells('A'.$this->totalGeneradas.':'.'B'.$this->totalGeneradas);
            $this->objPHPExcel->getActiveSheet()->mergeCells('C'.$this->totalGeneradas.':'.'E'.$this->totalGeneradas);

            $this->objPHPExcel->setActiveSheetIndex($this->index)
              ->setCellValue('A'.$this->totalGeneradas, 'CANTIDAD TOTAL FACTURAS GENERADAS');

            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->totalGeneradas)->getFont()->setBold(true);
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->totalGeneradas)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            
            $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
              'C'.$this->totalGeneradas, $params->cantidadFacturasGeneradas
            );
          }
          else if($params->reporteDetallado == true) {
            foreach ($params->tramitesFinalizados as $key => $tramite) {
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
                'H'.$this->row, $tramite['fechaTramite']
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
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$this->total)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            
            $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
              'I'.$this->total, $params->totalTramitesFinalizados
            );
          }
        }
          //Otorga estilos
          $this->getStyleTramites($params);
          /* $this->templateExcelByGeneral($params); */

        

        $this->objPHPExcel->setActiveSheetIndex(0);

        return $this->objPHPExcel;

    }
  //==============================//END TEMPLATES//==============================//

  public function templateExcelByGeneral($params){
        $em = $this->em;
        $pages = 0;

        for ($i=1; $i <= 4; $i++) { 
          switch ($i) {
            case 1:
              $solicitudes = $em->getRepository('JHWEBPqrsfBundle:Trazabilidad')->getPendientesByDate(
                  $params->fechaInicial,
                  $params->fechaFinal
              );
              //Asigna titulo a la pestaña
              $title = 'PENDIENTES';
              break;
            
            case 2:
              $solicitudes = $em->getRepository('JHWEBPqrsfBundle:Trazabilidad')->getVencidasByDate(
                  $params->fechaInicial,
                  $params->fechaFinal
              );
              $title = 'VENCIDAS';
              break;

            case 3:
              $solicitudes = $em->getRepository('JHWEBPqrsfBundle:Trazabilidad')->getOportunasByDate(
                  $params->fechaInicial,
                  $params->fechaFinal
              );
              //Asigna titulo a la pestaña
              $title = 'OPORTUNAS';
              break;

            case 4:
              $solicitudes = $em->getRepository('JHWEBPqrsfBundle:Trazabilidad')->getInoportunasByDate(
                  $params->fechaInicial,
                  $params->fechaFinal
              );
              //Asigna titulo a la pestaña
              $title = 'INOPORTUNAS';
              break;
          }
          
          if ($solicitudes) {
            $this->index = $pages;
            $this->row = 4;
            $this->col = 'A';
            
            if ($pages > 0) {
              $this->objPHPExcel->createSheet();
            }
            
            $this->objPHPExcel->setActiveSheetIndex($pages);

            //Imprime la cabecera
            $this->getMembretes($params);

            //Asigna titulo a la pestaña
            $this->objPHPExcel->getActiveSheet()->setTitle(substr($title,0,30));

            foreach ($solicitudes as $key => $trazabilidad) {
              //Imprime los datos
              $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
                'A'.$this->row, $trazabilidad->getSolicitud()->getNumeroRadicado()
              );
              $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
                'B'.$this->row, $trazabilidad->getSolicitud()->getAcudiente()->getIdentificacion()
              );
              $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
                'C'.$this->row, $trazabilidad->getSolicitud()->getAcudiente()->getNombres().' '.$trazabilidad->getSolicitud()->getAcudiente()->getApellidos()
              );
              $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
                'D'.$this->row, $trazabilidad->getSolicitud()->getPaciente()->getIdentificacion()
              );
              $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
                'E'.$this->row, $trazabilidad->getSolicitud()->getPaciente()->getNombres().' '.$trazabilidad->getSolicitud()->getPaciente()->getApellidos()
              );
              $eps = 'No aplica';
              if ($trazabilidad->getSolicitud()) {
                $paciente = $em->getRepository('JHWEBUserBundle:Paciente')->findOneBy(
                    array(
                      'usuario' => $trazabilidad->getSolicitud()->getId()
                    )
                );
                if ($paciente) {
                  $eps = $paciente->getEps()->getNombre();
                }
              }
              $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
                'F'.$this->row, $eps
              );
              $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
                'G'.$this->row, $trazabilidad->getFuncionario()->getServicio()->getNombre()
              );
              $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
                'H'.$this->row, $trazabilidad->getFuncionario()->getUsuario()->getNombres().' '.$trazabilidad->getFuncionario()->getUsuario()->getApellidos()
              );
              $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
                'I'.$this->row, $trazabilidad->getSolicitud()->getTipo()->getNombre()
              );
              $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
                'J'.$this->row, $trazabilidad->getEstado()->getNombre()
              );
              $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
                'K'.$this->row, $trazabilidad->getSolicitud()->getCausa()->getNombre()
              );
              $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
                'L'.$this->row, $trazabilidad->getSolicitud()->getFechaApertura()->format('d/m/Y')
              );
              $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
                'M'.$this->row, $trazabilidad->getSolicitud()->getFechaVencimiento()->format('d/m/Y')
              );
              $fechaRespuesta = 'No aplica';
              if ($trazabilidad->getSolicitud()->getFechaRespuesta()) {
                $fechaRespuesta = $trazabilidad->getSolicitud()->getFechaRespuesta()->format('d/m/Y');
              }
              $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
                'N'.$this->row, $fechaRespuesta
              );
              //Calcula dias de respuesta
              $dias = 'No aplica';
              if (!$trazabilidad->getSolicitud()->getActivo() && $trazabilidad->getSolicitud()->getFechaRespuesta()){
                $dias = $trazabilidad->getSolicitud()->getFechaApertura()->diff($trazabilidad->getSolicitud()->getFechaRespuesta());
                $dias = $dias->format('%a días');
              }
              $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
                'O'.$this->row, $dias
              );
              
              /*$this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
                'B'.$this->row, $trazabilidad->getEstado()->getNombre()
              );
              $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
                'C'.$this->row, $trazabilidad->getFuncionario()->getServicio()->getNombre()
              );
              $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
                'D'.$this->row, $trazabilidad->getFuncionario()->getUsuario()->getNombres().' '.$trazabilidad->getFuncionario()->getUsuario()->getApellidos()
              );
              
              $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
                'F'.$this->row, $trazabilidad->getSolicitud()->getNumeroRadicado()
              );*/
              $this->row++;
            }
            //Otorga estilos
            $this->getStyle();

            // Aumenta en uno el numero de paginas
            $pages++;
          }
        }

        $this->objPHPExcel->setActiveSheetIndex(0);

        return $this->objPHPExcel;

    }
}