<?php require_once("tcpdf/tcpdf.php");


session_name("Migliorsalute_Download");
session_start();


$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->AddPage();
// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $_SESSION["codice_attivazione"], 0, 1, 0, true, '', true);

// ---------------------------------------------------------
$filename=rand(5).time();
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output(dirname(__FILE__).'/tmp/'.$filename.'.pdf', 'F');



array_push($files,$filename.".pdf");
?>