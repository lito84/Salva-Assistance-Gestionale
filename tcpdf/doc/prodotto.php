<?php include("../../includes/parameters.php");?>
<?php include("../../includes/functions.php");?>
<?php include("../../includes/mysql.inc.php");?>
<?php
// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

$url_loghi="uploads/immagini/files/";
$sql="SELECT *, clienti.cognome AS cognome, clienti.nome AS nome, utenti.nome AS agente FROM pratiche LEFT JOIN clienti ON pratiche.id_cliente = clienti.id_cliente LEFT JOIN convenzioni_prodotti ON pratiche.id_prodotto_convenzione = convenzioni_prodotti.id_convenzione_prodotto LEFT JOIN convenzioni ON convenzioni.id_convenzione = convenzioni_prodotti.id_convenzione LEFT JOIN utenti ON convenzioni.id_utente = utenti.id_utente WHERE pratiche.codice_attivazione='$_GET[codice_attivazione]'";
$res=mysql_query($sql);
$rows=mysql_fetch_array($res, MYSQL_ASSOC);

$_GET["id_convenzione_prodotto"]=$rows["id_prodotto_convenzione"];

$res=mysql_query($sql);
$rows=mysql_fetch_array($res, MYSQL_ASSOC);


$sqlp="SELECT *, prodotti_categorie.categoria AS categoria FROM prodotti LEFT JOIN prodotti_categorie ON prodotti_categorie.id_categoria = prodotti.categoria WHERE id_prodotto = '$rows[id_prodotto]'";
$resp=mysql_query($sqlp);
$rowsp=mysql_fetch_array($resp, MYSQL_ASSOC);

$prodotto=utf8_encode(stripslashes($rowsp["prodotto"]." ".$rowsp["categoria"]));

//Meta dati//

//Modello

$sql1="SELECT * FROM prodotti_convenzione_meta WHERE id_prodotto_convenzione='$_GET[id_convenzione_prodotto]' AND chiave = 'Modello'";
$res1=mysql_query($sql1);
$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
$modello=$rows1["valore"];
//Loghi

$sql1="SELECT * FROM prodotti_convenzione_meta_pdf WHERE id_prodotto_convenzione='$_GET[id_convenzione_prodotto]' AND chiave = 'logo1'";
$res1=mysql_query($sql1);
$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
$logo1=$rows1["valore"];

$sql1="SELECT * FROM prodotti_convenzione_meta_pdf WHERE id_prodotto_convenzione='$_GET[id_convenzione_prodotto]' AND chiave = 'logo2'";
$res1=mysql_query($sql1);
$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
$logo2=$rows1["valore"];

$sql1="SELECT * FROM prodotti_convenzione_meta_pdf WHERE id_prodotto_convenzione='$_GET[id_convenzione_prodotto]' AND chiave = 'logo3'";
$res1=mysql_query($sql1);
$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
$logo3=$rows1["valore"];


//Altezze celle loghi
$sql1="SELECT * FROM prodotti_convenzione_meta WHERE id_prodotto_convenzione='$_GET[id_convenzione_prodotto]' AND chiave = 'Altezza Cella Logo 1'";
$res1=mysql_query($sql1);
$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
$altezza_logo1=$rows1["valore"];

$sql1="SELECT * FROM prodotti_convenzione_meta WHERE id_prodotto_convenzione='$_GET[id_convenzione_prodotto]' AND chiave = 'Altezza Cella Logo 2'";
$res1=mysql_query($sql1);
$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
$altezza_logo2=$rows1["valore"];

//Larghezze loghi
$sql1="SELECT * FROM prodotti_convenzione_meta WHERE id_prodotto_convenzione='$_GET[id_convenzione_prodotto]' AND chiave = 'Larghezza Logo 1'";
$res1=mysql_query($sql1);
$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
$largezza_logo1=$rows1["valore"];

$sql1="SELECT * FROM prodotti_convenzione_meta WHERE id_prodotto_convenzione='$_GET[id_convenzione_prodotto]' AND chiave = 'Larghezza Logo 2'";
$res1=mysql_query($sql1);
$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
$larghezza_logo2=$rows1["valore"];

$sql1="SELECT * FROM prodotti_convenzione_meta WHERE id_prodotto_convenzione='$_GET[id_convenzione_prodotto]' AND chiave = 'Larghezza Logo 3'";
$res1=mysql_query($sql1);
$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
$larghezza_logo3=$rows1["valore"];

//Colore font

$sql1="SELECT * FROM prodotti_meta WHERE id_prodotto='$rows[id_prodotto]' AND chiave = 'Colore'";
$res1=mysql_query($sql1);
$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
$colore=$rows1["valore"];


$dettaglio_prodotto = <<<EOD
<span style="color:#$colore;">$prodotto</span>
EOD;


// initiate FPDI
$pdf = new FPDI();
// add a page
$pdf->AddPage();
// set the source file
//$pdf->setSourceFile('../../uploads/modelli/files/'$modello);
// import page 1
$tplIdx = $pdf->importPage(1);
// use the imported page and place it at position 10,10 with a width of 100 mm
$pdf->useTemplate($tplIdx, 10, 10, 100);

$pdf->AddFont("helveticaneue","","helveticaneue.php");
$pdf->AddFont("helveticaneueb","B","helveticaneueb.php");
$pdf->SetFont("helveticaneue","",10);
// ---------------------------------------------------------

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.

// Add a page
// This method has several options, check the source code documentation for more information.

$pdf->AddPage();
$pdf->SetDrawColor($red, $green, $blue);
$pdf->SetLineWidth(1.5);
$pdf->Line(14.25, 10+$y, 195.75, 10+$y);
$pdf->Line(15, 10+$y, 15, 65+$y);
$pdf->Line(195, 10+$y, 195, 65+$y);
$pdf->Line(14.25, 65+$y, 195.75, 65+$y);
$pdf->Line(105, 10+$y, 105, 65+$y);

$pdf->SetXY(10,10+$y);
$pdf->Cell(10,0,"",5,0,'',false);

$pdf->SetTextColor(1,117,143);

$html_dati = <<<EOD
	<p>$prodotto</p>
	<p style="font-weight:bold;">$prodotto</p>
EOD;

$html_loghi = <<<EOD
	<p>$loghi</p>
	
EOD;
$pdf->writeHTMLCell(45, 65, 106.50, 11.50+$y, $html_loghi, 0, 1, 0, true, '', true);

$pdf->writeHTMLCell(45, 65, 150, 10.75+$y, $html_dati, 0, 1, 0, true, '', true);
// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('example_001.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
