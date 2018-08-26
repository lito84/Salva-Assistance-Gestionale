<?php include("../includes/parameters.php");?>
<?php include("../includes/functions.php");?>
<?php include("../includes/mysql.inc.php");

require("../libraries/tcpdf/tcpdf.php"); // Librerie generazione PDF
require("../libraries/tcpdf/fpdi.php"); // Librerie importazione PDF


$sql="SELECT bugiardino FROM prodotti WHERE id_prodotto = '1'";
$res=mysql_query($sql);
$rows=mysql_fetch_array($res, MYSQL_ASSOC);
$num=mysql_num_rows($res);
/*
$pdf=new fpdi();
$pagecount = $pdf->setSourceFile("../uploads/modelli/bugiardino.pdf");
$tplidx=$pdf->ImportPage(1);

$pdf->AddFont('verdana','','verdana.php');
$pdf->AddFont('verdanab','B','verdanab.php');
$pdf->AddFont('verdanai','I','verdanai.php');
$pdf->SetAuthor($rows["titolare"]);
$pdf->SetTitle("Convenzione");
$pdf->SetSubject("Convenzione");
$pdf->SetKeywords(" ");
$pdf->SetCreator("360 system");
$pdf->SetMargins(20,20,20);
$pdf->SetAutoPageBreak(true,PDF_MARGIN_BOTTOM);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetDisplayMode("fullpage","continuous");
$pdf->SetCompression(true);
$permission=array("modify","copy","annot-forms","fill-forms","extract","assemble","owner");
$pdf->SetProtection($permission);
$pdf->setPDFVersion("1.5");
$pdf->AliasNbPages();
$pdf->setFontSubsetting(false);

$pdf->SetTextColor(0,0,0);

// 1° PAGINA //////////////////////////////////////////////////////////////////////////////////
$pdf->addPage();
$s=$pdf->getTemplateSize($tplidx);
$pdf->useTemplate($tplidx,0,0,$s["w"],$s["h"]);
$pdf->SetXY(20,20);
$pdf->writeHTMLCell(0,0,10,44,utf8_encode($rows["bugiardino"]));

$pdf->Output("Bugiardino.pdf",'I');
*/

class PDF extends FPDI
{
// Page header
function Header()
{
	// Logo
    $this->Image('tcpdf/images/logo_migliorsalute.jpg',10,10,50);
    $this->Image('tcpdf/images/logo_migliorsorriso.jpg',150,10,50);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8// Logo
    //$this->Image('logo.png',10,6,30);

    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->SetMargins(10, 30, 10, true);
$pdf->AddFont('helveticaneue','','helveticaneue.php');
$pdf->AddFont('helveticaneueb','','helveticaneueb.php');
$pdf->AddFont('helveticaneueltstd','','helveticaneueltstd.php');
$pdf->SetFont('helveticaneue');
$pdf->AddPage();
$pdf->SetXY(20,20);
$pdf->writeHTMLCell(0,0,10,44,utf8_encode($rows["bugiardino"]));
$pdf->Output();
?>