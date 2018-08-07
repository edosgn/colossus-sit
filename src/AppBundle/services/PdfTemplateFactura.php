<?php

namespace AppBundle\services;

use TCPDF;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;

class PdfTemplateFactura extends TCPDF{
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
        
    }

    public function templateSummary($html,$factura){
        // create new PDF document
        $pdf = new PdfTemplateFactura('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('JHWEB PASTO SAS');
        $pdf->SetTitle('factura');
        $pdf->SetSubject('PDF PQRSF');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        // var_dump($factura->getNumero());
        // die();
        $barcode = new BarcodeGenerator();
        $barcode->setText($factura->getFechaCreacion().$factura->getNumero());
        $barcode->setNoLengthLimit(true);
        $barcode->setAllowsUnknownIdentifier(true);
        $barcode->setType(BarcodeGenerator::Gs1128);
        $barcode->setScale(2);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $code = $barcode->generate();

        $imgDescuento = \base64_decode($code);
        $mi = $ms = $md = 10;

        

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

        $pdf->Image('@'.$imgDescuento, $mi + 4, $ms + 242, 90, 18, 'png');

        $files = glob(__DIR__."../../../../web/uploads/*");
        foreach($files as $file){
            if(is_file($file))
            unlink($file); //elimino el fichero
        }
        $pdf->Output(__DIR__."../../../../web/uploads/".date('d-M-Y').".pdf", 'F');

        return (date('d-M-Y').".pdf");

    }

    public function templatePreview($html, $estado){
        // create new PDF document
        $pdf = new PdfTemplate('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('JHWEB PASTO SAS');
        $pdf->SetTitle($estado->getNombre());
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
}