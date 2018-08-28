<?php include("../includes/parameters.php");?>
<?php include("../includes/functions.php");?>
<?php include("../includes/mysql.inc.php");?>
<?php include("../includes/auth.inc.php");

//require("../libraries/tcpdf/tcpdf.php"); // Librerie generazione PDF
//require("../libraries/tcpdf/fpdi.php"); // Librerie importazione PDF

require('fpdf.php');
require('fpdi.php');
require('rotation.php');

class PDF extends PDF_Rotate
{
function RotatedText($x,$y,$txt,$angle)
{
    //Text rotated around its origin
    $this->Rotate($angle,$x,$y);
    $this->Text($x,$y,$txt);
    $this->Rotate(0);
}
}
session_name("Salva_Download");
session_start();




$sql="SELECT *, clienti.cognome AS cognome, clienti.nome AS nome, utenti.nome AS agente, invitanti.cognome AS invitante_cognome, invitanti.nome AS invitante_nome, pratiche.id_agente FROM pratiche LEFT JOIN clienti ON pratiche.id_cliente = clienti.id_cliente LEFT JOIN convenzioni_prodotti ON pratiche.id_prodotto_convenzione = convenzioni_prodotti.id_convenzione_prodotto LEFT JOIN convenzioni ON convenzioni.id_convenzione = convenzioni_prodotti.id_convenzione LEFT JOIN utenti ON pratiche.id_agente = utenti.id_utente LEFT JOIN invitanti ON invitanti.id_invitante = pratiche.id_invitante WHERE pratiche.codice_attivazione='$_GET[codice_attivazione]'";
$res=mysql_query($sql);
$rows=mysql_fetch_array($res, MYSQL_ASSOC);
$id_prodotto_convenzione=$rows["id_prodotto_convenzione"];
$id_prodotto=$rows["id_prodotto"];

if($id_prodotto=='001') $prodotto="Mezzi Sussistenza";
if($id_prodotto=='002') $prodotto="Spese sanitarie";
if($id_prodotto=='003') $prodotto="Mezzi Sussistenza + Spese sanitarie";

$id_pratica=$rows["id_pratica"];


$res=mysql_query($sql);
$rows=mysql_fetch_array($res, MYSQL_ASSOC);


$copertura = $rows["copertura"];
$validita = $rows["validita"];


$codice_attivazione=$_GET["codice_attivazione"];
$data_attivazione=date("d/m/Y", strtotime($rows["data_attivazione"]));



// initiate FPDI
$pdf = new PDF();
// add a page




// set the source file
$pdf->setSourceFile('Salva_Integration_cop-stampa.pdf');
$pageCount = $pdf->setSourceFile('Salva_Integration_cop-stampa.pdf');
  
$pdf->AddFont('Roboto','','Roboto-Regular.php');
$pdf->AddFont('Roboto','B','Roboto-Bold.php');
$pdf->AddFont('Verdana','','Verdana.php');
$pdf->AddFont('Verdana','B','verdanab.php');
$pdf->SetAutoPageBreak(false);
//Copia cliente
$pdf->AddPage();
$tplIdx = $pdf->importPage(1);
$pdf->useTemplate($tplIdx);

$pdf->SetTextColor(21,61,138);
$pdf->SetFont("Roboto","B",20);

$pdf->SetXY(0,95);   
$pdf->Cell(210,10,$rows["agente"],0,1,'C');

$pdf->SetXY(0,130);   
$pdf->Cell(210,10,$data_attivazione,0,1,'C');

$pdf->SetXY(0,165);   
$pdf->Cell(210,10,$prodotto,0,1,'C');

$pdf->SetXY(0,200);   
$pdf->Cell(210,10,utf8_decode($rows["invitante_cognome"]." ".$rows["invitante_nome"]),0,1,'C');
$pdf->SetXY(0,235);   
$pdf->Cell(210,10,utf8_decode($rows["cognome"]." ".$rows["nome"]),0,1,'C');

$pdf->Output('Copertina '.$_GET["codice_attivazione"].'.pdf','I');

?>