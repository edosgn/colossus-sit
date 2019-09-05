<?php

namespace AppBundle\services;

use TCPDF;

class PdfTemplate extends TCPDF{
    //Page header
    public function Header() {
        // Set font
        $this->SetFont('helvetica', 'B', 8);
        // Page number
        //$this->Cell(0, 10, 'Pag. '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'L', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 20, '', 0, false, 'J', 0, '', 0, false, 'T', 'M');
        // Logo
        $image_file = __DIR__.'/../../../web/img/header.png';
        $this->Image($image_file, 5, 0, 200, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        $this->Cell(0, 15, '', 0, false, 'J', 0, '', 0, false, 'T', 'M');
        //$this->MultiCell(0, 5, $nota, 0, 'J', 0, 1, '', '', true, 0);
        $image_file = __DIR__.'/../../../web/img/footer.png';
        $this->Image($image_file, 5, 270, 200, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    }

    public function templatePreview($html, $titulo){
        // create new PDF document
        $pdf = new PdfTemplate('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('JHWEB PASTO SAS');
        $pdf->SetTitle($titulo);
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins('15', '25', '15');
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------

        // set font
        $pdf->SetFont('helvetica', '', 10, '', true);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

        // Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        // ---------------------------------------------------------
        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $pdf->Output($titulo, 'I');
    }

    public function templateProyecto($html, $proyecto){
        // create new PDF document
        $pdf = new PdfTemplate('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('JHWEB PASTO SAS');
        $pdf->SetTitle('PROYECTO No_'.$proyecto->getNumero());
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins('15', '25', '15');
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------

        // set font
        $pdf->SetFont('helvetica', '', 10, '', true);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage();


        // Print text using writeHTMLCell()
        //$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        $pdf->writeHTML($html, true, 0, true, 0);

// ---------------------------------------------------------

        /*$xc = 105;
        $yc = 100;
        $r = 50;

        $pdf->SetFillColor(0, 0, 255);
        $pdf->PieSector($xc, $yc, $r, 20, 120, 'FD', false, 0, 2);

        $pdf->SetFillColor(0, 255, 0);
        $pdf->PieSector($xc, $yc, $r, 120, 250, 'FD', false, 0, 2);

        $pdf->SetFillColor(255, 0, 0);
        $pdf->PieSector($xc, $yc, $r, 250, 20, 'FD', false, 0, 2);*/

        // write labels
        /*$pdf->SetTextColor(255,255,255);
        $pdf->Text(105, 65, 'BLUE');
        $pdf->Text(60, 95, 'GREEN');
        $pdf->Text(120, 115, 'RED');*/
        // ---------------------------------------------------------
        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $pdf->Output('PROYECTO No_'.$proyecto->getNumero(), 'I');
    }

    public function templateEvaluacion($html, $evaluacion){
        // create new PDF document
        $pdf = new PdfTemplate('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('JHWEB PASTO SAS');
        $pdf->SetTitle($evaluacion->getId());
        $pdf->SetSubject('PDF PQRSF');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        // set default header data
        $fecha = new \DateTime('now');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins('30', '25', '30');
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------

        // set font
        $pdf->SetFont('helvetica', '', 10, '', true);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

        // Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        // ---------------------------------------------------------
        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $pdf->Output('example_065.pdf', 'I');
    }

    public function templateResoluciones($html){
        // create new PDF document
        $pdf = new PdfTemplate('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('JHWEB PASTO SAS');
        $pdf->SetTitle("JHWEB RESOLUCION");
        $pdf->SetSubject('PDF PQRSF');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        // set default header data
        $fecha = new \DateTime('now');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins('30', '25', '30');
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------

        // set font
        $pdf->SetFont('helvetica', '', 10, '', true);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

        // Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        // ---------------------------------------------------------
        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $pdf->Output('example_065.pdf', 'I');
    }

    public function templateCalificacion($html, $empresa){
        // create new PDF document
        $pdf = new PdfTemplate('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('JHWEB PASTO SAS');
        $pdf->SetTitle('Evaluación '. $empresa->getNombre());
        $pdf->SetSubject('PDF PQRSF');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        
        // set default header data
        $fecha = new \DateTime('now');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins('30', '25', '30');
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------

        // set font
        $pdf->SetFont('helvetica', '', 10, '', true);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

        // Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        // ---------------------------------------------------------
        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $pdf->Output('example_065.pdf', 'I');
    }

    public function templateActaIpat($html, $asignacion){
        // create new PDF document
        $pdf = new PdfTemplate('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('JHWEB PASTO SAS');
        $pdf->SetTitle('Acta No. '.$asignacion->getNumeroActa());
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins('30', '25', '30');
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------

        // set font
        $pdf->SetFont('helvetica', '', 10, '', true);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

        // Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        // ---------------------------------------------------------
        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $pdf->Output('example_065.pdf', 'I');
    }

    public function templateFactura($html, $factura){
        // create new PDF document
        $pdf = new PdfTemplate('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('JHWEB PASTO SAS');
        $pdf->SetTitle('Factura No. '.$factura->getNumero());
        $pdf->SetSubject('Subsecretaría de transito deptal.');
        $pdf->SetKeywords('Factura');

        // set default header data
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
        
        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins('2', '5', '2');
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, 30);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------
        $pdf->SetTextColor(0,0,0);
        // set font
        $pdf->SetFont('helvetica', '', 11, '', true);

        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

        // Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        // ---------------------------------------------------------
        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $pdf->Output('factura_'.$factura->getNumero().'.pdf', 'I');
    }

    public function templateEmpty($html, $title){
        // create new PDF document
        $pdf = new PdfTemplate('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('JHWEB PASTO SAS');
        $pdf->SetTitle($title);
        $pdf->SetSubject('Subsecretaría de transito deptal.');
        $pdf->SetKeywords('Factura');

        // set default header data
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
        
        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins('3', '5', '3');
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, 30);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------
        $pdf->SetTextColor(0,0,0);
        // set font
        $pdf->SetFont('helvetica', '', 11, '', true);

        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

        // Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        // ---------------------------------------------------------
        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $pdf->Output($title.'.pdf', 'I');
    }

    public function templateDocumentacion($html, $factura){
        // create new PDF document
        $pdf = new PdfTemplate('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('JHWEB PASTO SAS');
        $pdf->SetTitle($factura->getNumero());
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins('30', '25', '30');
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------

        // set font
        $pdf->SetFont('helvetica', '', 10, '', true);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

        // Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        // ---------------------------------------------------------
        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $pdf->Output('example_065.pdf', 'I');
    }

    public function templateSummary($html, $factura){
        // create new PDF document
        $pdf = new PdfTemplate('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Ing. EDGAR GUERRERO');
        $pdf->SetTitle('Prueba');
        $pdf->SetSubject('PDF PRESTAMO');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        // set default header data
        $fecha = new \DateTime('now');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins('20', '10', '20');
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------
        $pdf->SetTextColor(0,0,0);
        // set font
        $pdf->SetFont('helvetica', '', 14, '', true);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

        // Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        // ---------------------------------------------------------
        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $pdf->Output('example_065.pdf', 'I');
    }

    public function templateCertificadoTradicion($html, $title, $tipo){
        // create new PDF document
        $pdf = new PdfTemplate('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('JHWEB PASTO SAS');
        $pdf->SetTitle('Cert. Tradición '.$title);
        $pdf->SetSubject('Subsecretaría de transito deptal.');
        $pdf->SetKeywords('Certificado, Tradición');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins('30', '25', '30');
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------

        // set font
        $pdf->SetFont('helvetica', '', 10, '', true);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

        // Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        // ---------------------------------------------------------
        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $pdf->Output('certificado_tradicion.pdf', 'I');
    }

    public function templateIngresos($html){
        // create new PDF document
        $pdf = new PdfTemplate('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('JHWEB PASTO SAS');
        $pdf->SetTitle('Reporte Ingresos');
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins('30', '25', '30');
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------

        $pdf->SetTextColor(0,0,0);
        // set font
        $pdf->SetFont('helvetica', '', 10, '', true);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

        // Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, 'J', true);
        // ---------------------------------------------------------
        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $pdf->Output('example_065.pdf', 'I');
    }

    public function templateAsignacion($html, $numeroActa){
        // create new PDF document
        $pdf = new PdfTemplate('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('JHWEB PASTO SAS');
        $pdf->SetTitle('Acta entrega N. '.$numeroActa);
        $pdf->SetSubject('Subsecretaría de transito deptal.');
        $pdf->SetKeywords('Acta, asignación, insumos');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins('30', '25', '30');
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------

        // set font
        $pdf->SetFont('helvetica', '', 10, '', true);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

        // Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        // ---------------------------------------------------------
        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $pdf->Output('acta_asignacion.pdf', 'I');
    }

    public function templateAsignacionTalonarios($html, $asignacion){
        // create new PDF document
        $pdf = new PdfTemplate('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('JHWEB PASTO SAS');
        $pdf->SetTitle('Acta entrega No. '.$asignacion->getNumeroActa());
        $pdf->SetSubject('Subsecretaría de transito deptal.');
        $pdf->SetKeywords('Acta, asignación, talonarios');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins('30', '25', '30');
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------

        // set font
        $pdf->SetFont('helvetica', '', 10, '', true);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

        // Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        // ---------------------------------------------------------
        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $pdf->Output('acta_asignacion_'.$asignacion->getNumeroActa().'.pdf', 'I');
    }
}