<?php

namespace T3developer\ProjectsAndTasks\Utility;

/* * *************************************************************
 *  Copyright notice
 *
 *  
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */

/**
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Pdf extends \T3developer\ProjectsAndTasks\Utility\Tcpdf\TCPDF {

    const DEFAULT_DIRECOTRY_FONTS = 'EXT:projects_and_tasks/Classes/Utility/Tcpdf/fonts/';
    const DEFAULT_DIRECOTRY_IMAGE = 'EXT:projects_and_tasks/Classes/Utility/Tcpdf/custombg/';
    
    public function __construct() {
        parent::__construct();
    }
    /*
     * Defines the standard Header for t3-developer
     */

    public function Header() {
        $auto_page_break = $this->AutoPageBreak;
        // disable auto-page-break
        $this->SetAutoPageBreak(false, 0);
        // set bacground image
         
        $img_file = 'http://localhost:8888/typo62/typo3conf/ext/projects_and_tasks/Resources/Public/t3page.jpg';
        
        $this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
        
        // restore auto-page-break status
        $this->SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        $this->setPageMark();
    }

    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-10);
        $this->SetX(23);
        // Set font
        $this->SetFont('TRADEGOTHICLT', '', 7);
        // Page number
        $this->Cell(0, 10, 'Seite ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'L', 0, '', 0, false, 'T', 'M');
        $this->SetX(150);
        $this->SetFont('TRADEGOTHICLT', '', 5);
        $this->Cell(0, 10, 'Build by ProjectsAndTasks | A TYPO3 EXT by t3-developer.com V:0.2', 0, false, 'L', 0, '', 0, false, 'T', 'M');
    }

    public function CreateTextBox($textval, $x = 0, $y, $width = 0, $height, $fontsize, $fontstyle = '', $align = 'L', $fill) {
        $this->SetXY($x + 20, $y); // 20 = margin left
        $this->SetFont('Helvetica', $fontstyle, $fontsize);
        $this->Cell($width, $height, $textval, 0, false, $align, $fill);
    }

    /**
     * @param 
     * @param boolean $saveOnly
     * @return void
     */
    //public function createInvoice(Tx_PiFaktura_Domain_Model_Process $process, $saveOnly = TRUE) {
    public function createTodoPdf($todoList, $todos, $project) {
        
        //$this->addTTFfont( \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName(self::DEFAULT_DIRECOTRY_FONTS . 'latoregular.ttf', 'TrueTypeUnicode'));

        // set document information
        $this->SetCreator(PDF_CREATOR);
        $this->SetAuthor('ProjectsAndTasks');
        $this->SetTitle('Projects and Tasks :: A TYPO3 Extension by t3-developer.com');
        $this->SetSubject('Singel ToDo List');
        $this->SetKeywords('Projects and Tasks');

       
        $this->setJPEGQuality(100);
        $this->SetMargins(0, 0, 0, 0);

        $this->SetCellPadding(0, 0, 0, 0);
        $this->setCellMargins(0, 0, 0, 0);
        $this->setImageScale(1.53);
        // $this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $this->SetHeaderMargin(0);
        //$this->SetFooterMargin(0);
        //$this->setPrintFooter(false);






        // Page 1
        $this->AddPage();
        $this->Header();
        $this->SetAutoPageBreak(TRUE);

        // Adressfeld
        $project = 'Projekt: '. $project->getProjectTitle();
        $this->CreateTextBox($project, 00, 35, 60, 10, 9, 'B');
        $this->CreateTextBox($todoList->getTodolistTitel(), 00, 40, 80, 10, 9, 'R');

        $this->writeTodos($todos);





        // $this->SetAutoPageBreak(TRUE, 30);
        $this->setJPEGQuality(100);
        $this->SetMargins(0, 0, 0, true);

        $this->SetCellPadding(0, 0, 0, 0);
        $this->setCellMargins(0, 0, 0, 0);
        $this->setImageScale(1.53);
        // $this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $this->SetHeaderMargin(0);
        $this->SetFooterMargin(0);




        if ($saveOnly === TRUE) {
            $this->savePdf('mypdf' . '.pdf');
        } else {
            $this->savePdf('mypdf' . '.pdf');
            $this->showPdf('mypdf' . '.pdf');
        }
    }

    /**
     * Saves pdf file
     * @param string $filename
     */
    public function savePdf($filename) {
        $pdfSource = $this->Output(NULL, 'S');
        $pdfFile = '/uploads/pat/' . $filename;
        file_put_contents(PATH_site . $pdfFile, $pdfSource);
    }

    /**
     * Shows PDF file
     * @param string $filename
     */
    public function showPdf($filename) {
        $pdfFile = PATH_site . 'uploads/pat/' . $filename;

        if (file_exists($pdfFile)) {
                    header('Content-Description: File Transfer');
            header('Content-Type: application/force-download');
            header('Content-Disposition: attachment; filename='.basename($pdfFile));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($pdfFile));
            ob_clean();
            flush();
            readfile($pdfFile, 'I');
            exit;
        }
        echo "Es ist ein Fehler beim Download der Datei aufgetreten!";
    }

    public function createTodo2() {
        $pdf = new \Tcpdf\tcpdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Nicola Asuni');
        $pdf->SetTitle('TCPDF Example 003');
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
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

// ---------------------------------------------------------
// set font
        $pdf->SetFont('times', 'BI', 12);

// add a page
        $pdf->AddPage();

// set some text to print
        $txt = <<<EOD
TCPDF Example 003

Custom page header and footer are defined by extending the TCPDF class and overriding the Header() and Footer() methods.
EOD;

// print a block of text using Write()
        $pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);

// ---------------------------------------------------------
//Close and output PDF document
        $pdf->Output('example_003.pdf', 'I');
    }

    public function writeTodos($todos) {


        // Colors, line width and bold font
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(112, 113, 115);
        $this->SetDrawColor(235, 235, 235);

        $this->SetXY(00, 60);

//        $this->CreateTextBox('Nr.', 0, 10, 5, 5, 4, '', 'C');
//        $this->CreateTextBox('Titel', 8, 135, 12, 5, 4, '', 'C');
//        $this->CreateTextBox('Beschreibung', 20, 135, 85, 5, 4, '', 'L');
//        $this->CreateTextBox('Status', 105, 135, 20, 5, 4, '', 'C');
        // Header
        //Spaltenbreiten in mm

        $this->SetFillColor(235, 235, 235);
        $this->SetTextColor(90,90,90);
        $this->SetFont('lato', '', 7);
        $this->setCellPaddings(2, 2, 2, 2);
        $this->SetLineWidth(0.2);

        $timeTotal = 0;
        
        $y_start = 50;
        foreach ($todos as $row) {
            // MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0)
            //status
            $openTime = 0;
            if ($row->getTodoStatus() == '1') {
                $status = 'offen';
                $openTime = $row->getTodoPlantime();}
            if ($row->getTodoStatus() == '3'){
                $status = 'klären';
                $openTime = 0;}
            if ($row->getTodoStatus() == '6'){
                $status = 'erledigt';
                $openTime = 0;}
            $id = '#' . str_pad($row->getTodoNr(), 3, "0", STR_PAD_LEFT);

            //time
            $time = $row->getTodoPlantime() / 3600;
            $time = $time . ' h';

            // BugId
            $this->MultiCell(10, 0, $id, T, 'C', 0, 2, 20, $y_start, true, 0);
            $y_bugid = $this->GetY();

            // write the left cell
            $this->MultiCell(40, 0, $row->getTodoTitle(), T, 'L', 0, 1, 30, $y_start, true, 0);



            // write the right cell
            $this->MultiCell(55, 0, $row->getTodoDescription(), T, 'L', 0, 1, 70, $y_start, true, 0);
            $y_description = $this->GetY();

            $this->MultiCell(55, 0, $row->getTodoComment(), T, 'L', 0, 1, 125, $y_start, true, 0);
            if($this->GetY() > $y_description)$y_description = $this->GetY();
            // write the right cell
            $this->MultiCell(15, 0, $time, T, 'C', 0, 1, 180, $y_start, true, 0);

            // write the right cell
            //$this->MultiCell(20, 0, $status, T, 'C', 0, 1, 170, $y_start, true, 0);

            $timeTotal = $timeTotal + $openTime;
            
            if ($y_description > $y_bugid) {
                $y_start = $y_description;
            } else {
                $y_start = $y_bugid;
            }

            if ($y_start >= 247) {
                $this->AddPage();
                $y_start = 30;
            }
        }
        $total = $timeTotal / 3600;
        $total = $total . 'h';
//        $this->MultiCell(10, 0, '', T, 'C', 0, 2, 20, $y_start, true, 0);
//        $this->MultiCell(40, 0, 'Gesamt-Zeit Staus Offen:', T, 'L', 0, 1, 30, $y_start, true, 0);
//        $this->MultiCell(80, 0, '', T, 'L', 0, 1, 70, $y_start, true, 0);
//        $this->MultiCell(20, 0, $total, T, 'C', 0, 1, 150, $y_start, true, 0);
//        $this->MultiCell(20, 0, '', T, 'C', 0, 1, 170, $y_start, true, 0);
    }

}

?>