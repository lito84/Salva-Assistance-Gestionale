<?php include("../includes/parameters.php");?>
<?php include("../includes/functions.php");?>
<?php include("../includes/mysql.inc.php");?>
<?php 

require('fpdf.php');
require('fpdi.php');

$sql="SELECT *, clienti.cognome AS cognome, clienti.nome AS nome, clienti.codicefiscale AS codicefiscale, clienti.ragionesociale AS ragionesociale, clienti.partitaiva AS partitaiva, clienti.cap AS cap, clienti.indirizzo AS indirizzo, clienti.citta AS citta, utenti.nome AS agente FROM pratiche LEFT JOIN clienti ON pratiche.id_cliente = clienti.id_cliente LEFT JOIN convenzioni_prodotti ON pratiche.id_prodotto_convenzione = convenzioni_prodotti.id_convenzione_prodotto LEFT JOIN convenzioni ON convenzioni.id_convenzione = convenzioni_prodotti.id_convenzione LEFT JOIN utenti ON convenzioni.id_utente = utenti.id_utente ";
$sql.="WHERE pratiche.codice_attivazione = '$_GET[codice_attivazione]'";
$res=mysql_query($sql);
$rows=mysql_fetch_array($res, MYSQL_ASSOC);
$num=mysql_num_rows($res);

$sql0="SELECT * FROM prodotti LEFT JOIN prodotti_categorie ON prodotti.categoria = prodotti_categorie.id_categoria WHERE prodotti.id_prodotto = '$rows[id_prodotto]'";
$res0=mysql_query($sql0);
$rows0=mysql_fetch_array($res0, MYSQL_ASSOC);

$prodotto=utf8_encode(stripslashes($rows0["prodotto"]));

$fattura=$rows["fattura"];
$data_fattura=date("d/m/Y", strtotime($rows["data_fattura"]));
$quantita=$num;

if($rows["tipo"]=="P"){
	$cliente = utf8_encode($rows["cognome"]." ".$rows["nome"]);
	$indirizzo=utf8_encode($rows["indirizzo"]);

	$sqlc="SELECT * FROM comuni_gl LEFT JOIN province_gl ON comuni_gl.cod_provincia = province_gl.cod_provincia WHERE cod_istat='$rows[citta]'";
	$resc=mysql_query($sqlc);
	$rowsc=mysql_fetch_array($resc, MYSQL_ASSOC);
	$citta=utf8_encode($rowsc["comune"]);
	$provincia=utf8_encode($rowsc["sigla"]);
	$cap=$rows["cap"];

} else{
	$cliente =utf8_encode($rows["ragionesociale"]);	
	$indirizzo=utf8_encode($rows["viasedelegale"]);
	$sqlc="SELECT * FROM comuni_gl LEFT JOIN province_gl ON comuni_gl.cod_provincia = province_gl.cod_provincia WHERE cod_istat='$rows[comunesedelegale]'";
	$resc=mysql_query($sqlc);
	$rowsc=mysql_fetch_array($resc, MYSQL_ASSOC);
	$citta=utf8_encode($rowsc["comune"]);
	$provincia=utf8_encode($rowsc["sigla"]);
	$cap=$rows["capsedelegale"];
}

$cf=$rows["codicefiscale"];
$partitaiva=$rows["partitaiva"];

// initiate FPDI
$pdf = new FPDI();
// add a page
$pdf->AddPage();
// set the source file
$pdf->setSourceFile('../uploads/modelli/fattura.pdf');
// import page 1
$tplIdx = $pdf->importPage(1);

$pdf->useTemplate($tplIdx);
$pdf->AddFont("helvetica","","helvetica.php");
$pdf->AddFont("helveticaneue","","helveticaneue.php");
$pdf->AddFont("helveticaneue","B","helveticaneueb.php");
$pdf->SetFont("helveticaneue","B",10);
$pdf->SetTextColor(126,125,126);


$pdf->SetTitle("Fattura ".$fattura." - ".$data_fattura);

$pdf->SetXY(0,0);

//Dati fattura
$pdf->SetXY(110,57.7);
$pdf->Cell(20,0,$fattura);
$pdf->SetXY(135,57.7);
$pdf->Cell(20,0,$data_fattura);
//Dati anagrafici

$pdf->SetFont("helveticaneue","",10);
$pdf->SetTextColor(0,0,0);

$pdf->SetXY(110,73.4);
$pdf->Cell(70,0,$cliente);

$pdf->SetXY(98,77.5);
$pdf->Cell(70,0,$cf);
$pdf->SetXY(144,77.5);
$pdf->Cell(50,0,$partitaiva);

$pdf->SetXY(105,81.7);
$pdf->Cell(80,0,$indirizzo);

$pdf->SetXY(100,85.9);
$pdf->Cell(80,0,$citta);
$pdf->SetXY(150,85.9);
$pdf->Cell(80,0,$provincia);

$pdf->SetXY(175,85.9);
$pdf->Cell(80,0,$cap);

//Dati acquisto

$sqlp="SELECT * FROM convenzioni_prodotti WHERE id_convenzione_prodotto = '$rows[id_convenzione_prodotto]'";
$resp=mysql_query($sqlp);
$rowsp=mysql_fetch_array($resp, MYSQL_ASSOC);

if($rowsp["iva_cliente"]){
	$imponibile=number_format($rows["prezzo_cliente"],2);
	$iva=number_format($imponibile*0.22,2);
	$importo=number_format($imponibile+$iva,2);
}else{
	$importo=number_format($rows["prezzo_cliente"],2);
	$imponibile=number_format($importo/1.22,2);
	$iva=number_format($importo-$imponibile,2);
}


$pdf->SetXY(15,105);
$pdf->Cell(22,10,$num,0,0,'C');

$pdf->SetXY(38,105);
$pdf->Cell(95,10,$prodotto,0,0,'L');

$pdf->SetXY(134,105);
$pdf->Cell(30,10,$imponibile,0,0,'C');

$pdf->SetXY(165,105);
$pdf->Cell(30,10,number_format($imponibile*$quantita,2),0,0,'C');


//Totali
$pdf->SetFont("helveticaneue","B",10);
$pdf->SetXY(165,253);
$pdf->Cell(30,10,number_format($imponibile,2),0,0,'C');
$pdf->SetXY(165,260.5);
$pdf->Cell(30,10,number_format($iva,2),0,0,'C');
$pdf->SetXY(165,266.5);
$pdf->Cell(30,10,number_format($importo,2),0,0,'C');
$pdf->Output();?>