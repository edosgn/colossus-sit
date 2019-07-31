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

    $filename = "reporte_pqrsf".date('Ymd-His').".xlsx";
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
      $this->objPHPExcel->getActiveSheet()->mergeCells('A1:L1');
      $this->objPHPExcel->getActiveSheet()->mergeCells('A2:L2');
      $this->objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      $this->objPHPExcel->setActiveSheetIndex($this->index)
                  ->setCellValue('A1', 'CÓDIGO')
                  ->setCellValue('B1', 'TRAMITES')
                  ->setCellValue('C1', 'CANTIDAD')
                  ->setCellValue('D1', 'VALOR')
                  ->setCellValue('E1', 'NOMBRE DEL QUEJOSO');
    }

    public function getStyleTramites(){
        // Set document properties
        $this->objPHPExcel->getProperties()->setCreator("JHWEB PASTO S.A.S.")
        ->setLastModifiedBy("JHWEB PASTO S.A.S.")
        ->setTitle("Office 2007 XLSX Test Document")
        ->setSubject("Office 2007 XLSX Test Document")
        ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("PQRSF");

        $this->objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth('15');
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth('18');
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth('45');
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth('18');
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth('45');
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth('25');
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth('45');
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth('12');
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth('15');
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth('20');
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth('15');
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth('15');
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth('15');
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth('15');
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth('15');
        $this->objPHPExcel->getActiveSheet()->getStyle("A1:O".$this->row)->applyFromArray($this->styleBorder);
        $this->objPHPExcel->getActiveSheet()->getStyle('A2:O'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
        $this->objPHPExcel->getActiveSheet()->getStyle('A1:O3')->getFont()->setBold(true);
        $this->objPHPExcel->getActiveSheet()->getStyle('A1:O3')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $this->objPHPExcel->getActiveSheet()->getStyle('B1:'.$this->col.$this->row)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
    }
  //==============================//START TEMPLATES//==============================//

    /* ==================== EXCEL BY TRAMITES ===================*/
    public function templateExcelByTramites($params){
        $em = $this->em;
        $pages = 0;

        $this->getMembretesTramites($params);

        if ($params) {
          $this->index = $pages;
          $this->row = 4;
          $this->col = 'A';
          
          $this->objPHPExcel->setActiveSheetIndex($pages);

          //Imprime la cabecera
          $this->getMembretesTramites($params);

          //Asigna titulo a la pestaña
          $this->objPHPExcel->getActiveSheet()->setTitle('TRAMITES');

          foreach ($params->arrayTramites as $key => $tramite) {
            //Imprime los datos
          }
          $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
            'A'.$this->row, $tramite->getNumeroFactura()
          );
          $this->objPHPExcel->setActiveSheetIndex($this->index)->setCellValue(
            'B'.$this->row, "asjdajsd"
          );
          
            $this->row++;
          }
          //Otorga estilos
          $this->getStyleTramites();

        

        $this->objPHPExcel->setActiveSheetIndex(0);

        return $this->objPHPExcel;

    }
  //==============================//END TEMPLATES//==============================//
}