<?php include("../includes/parameters.php");?>
<?php include("../includes/functions.php");?>
<?php include("../includes/mysql.inc.php");
require("../libraries/tcpdf/tcpdf.php"); // Librerie generazione PDF
//require("../libraries/tcpdf/fpdi.php"); // Librerie importazione PDF

require('fpdf.php');
require('fpdi.php');


session_name("Salva_Download");
session_start();

$files=array();

function hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return $rgb; // returns an array with the rgb values
}

$url_loghi="uploads/immagini/files/";
$sql="SELECT *, clienti.cognome AS cognome, clienti.nome AS nome, utenti.nome AS agente FROM pratiche LEFT JOIN clienti ON pratiche.id_cliente = clienti.id_cliente LEFT JOIN convenzioni_prodotti ON pratiche.id_prodotto_convenzione = convenzioni_prodotti.id_convenzione_prodotto LEFT JOIN convenzioni ON convenzioni.id_convenzione = convenzioni_prodotti.id_convenzione LEFT JOIN utenti ON convenzioni.id_utente = utenti.id_utente WHERE pratiche.codice_attivazione='$_GET[codice_attivazione]'";
$res=mysql_query($sql);
$rows=mysql_fetch_array($res, MYSQL_ASSOC);
$id_prodotto_convenzione=$rows["id_prodotto_convenzione"];
$id_prodotto=$rows["id_prodotto"];

$_SESSION["codice_attivazione"]=$_GET["codice_attivazione"];

$id_pratica=$rows["id_pratica"];

$_GET["id_convenzione_prodotto"]=$rows["id_prodotto_convenzione"];

$res=mysql_query($sql);
$rows=mysql_fetch_array($res, MYSQL_ASSOC);
define('EURO',chr(128));

$sqlp="SELECT *, prodotti_categorie.categoria AS categoria FROM prodotti LEFT JOIN prodotti_categorie ON prodotti_categorie.id_categoria = prodotti.categoria WHERE id_prodotto = '$rows[id_prodotto]'";
$resp=mysql_query($sqlp);
$rowsp=mysql_fetch_array($resp, MYSQL_ASSOC);

$prodotto=utf8_encode(stripslashes($rowsp["prodotto"]));

$codice_attivazione=$_GET["codice_attivazione"];
$data_attivazione=date("d/m/Y", strtotime($rows["data_attivazione"]));


$luogo="Vigonza, ".$data_attivazione;

$importo=$rows["importo"];
$imponibile=$rows["importo"]/1.22;
$iva=$importo-$imponibile;

$importo=number_format($importo,2,",","");
$imponibile=number_format($imponibile,2,",","");
$iva=number_format($iva,2,",","");


$scadenza="Il presente Certificato ha la durata di 365 giorni dalla data di effetto e copre fino ad un massimo di ".$validita." mesi dall'ingresso in Italia";
//Meta dati//

//Modello

$sql1="SELECT * FROM prodotti_meta WHERE id_prodotto='$rows[id_prodotto]' AND chiave = 'Modello'";
$res1=mysql_query($sql1);
$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
$modello=$rows1["valore"];
$y=0;


// initiate FPDI
$pdf = new TCPDF();
// add a page


if($id_prodotto=='01'): //Integration Mezzi di Sussistenza


$pdf->AddPage();
$pdf->AddFont('Roboto','','Roboto-Regular.php');

$pdf->AddFont('Roboto','B','Roboto-Bold.php');
// set the source file
$pdf->setSourceFile('../uploads/modelli/files/'.$modello);
$pageCount = $pdf->setSourceFile('../uploads/modelli/files/'.$modello);
// import page 1
$tplIdx = $pdf->importPage(1);
$pdf->useTemplate($tplIdx);
$pdf->SetTextColor(1,70,148);


$pdf->SetTitle($prodotto);

$pdf->SetXY(0,68);   
$pdf->SetFont("Roboto","B",23);
$pdf->Cell(210,10,utf8_decode($rows["nome"]." ".$rows["cognome"]),0,1,'C');

$pdf->SetFont("Roboto","B",11);

$pdf->SetXY(0,212);
//Dati prodotto

$pdf->Cell(210,10,utf8_decode($prodotto." n. ".$codice_attivazione),0,1,'C');  

$pdf->SetXY(150,$y+6);
$pdf->SetFont("helvetica","B",10);
$pdf->Cell(210,10,utf8_decode("n. ".$codice_attivazione),0,1,'L');

//validita
$pdf->SetFont("helvetica","",8);

$pdf->SetXY(150,$y+10);
$pdf->Cell(210,10,utf8_decode("valida dal "),0,1,'L');
$pdf->SetFont("helvetica","B",8);
$pdf->SetXY(163,$y+10);
$pdf->Cell(216,10,utf8_decode($data_attivazione),0,1,'L');
$pdf->SetXY(150,$y+13);
$pdf->SetFont("helvetica","",8);
$pdf->Cell(210,10,utf8_decode("al "),0,1,'L');
$pdf->SetFont("helvetica","B",8);
$pdf->SetXY(153,$y+13);
$pdf->Cell(216,10,utf8_decode($data_scadenza),0,1,'L');

$pdf->SetXY(150,$y+17);

$pdf->SetFont("helvetica","",8);
$pdf->Cell(210,10,utf8_decode("titolare"),0,1,'L');
$pdf->SetFont("helvetica","B",8);
$pdf->SetXY(150,$y+20);
$pdf->Cell(210,10,utf8_decode($rows["cognome"]." ".$rows["nome"]),0,1,'L');

$pdf->SetXY(150,$y+23);
$pdf->SetFont("helvetica","",8);
$pdf->Cell(210,10,utf8_decode("codice fiscale"),0,1,'L');
$pdf->SetFont("helvetica","B",8);
$pdf->SetXY(150,$y+26);
$pdf->Cell(210,10,strtoupper(utf8_decode($rows["codicefiscale"])),0,1,'L');

//Sezione Beneficiari

$sqlb="SELECT * FROM beneficiari WHERE id_pratica = '$id_pratica'";
$resb=mysql_query($sqlb);
if($numb=mysql_num_rows($resb)!=0){
$pdf->SetXY(150,$y+29.5);
$pdf->SetFont("helvetica","",8);
$pdf->Cell(210,10,"beneficiari",0,1,'L');
$beneficiari="";  
   while($rowsb=mysql_fetch_array($resb, MYSQL_ASSOC)){
      $beneficiari.=$rowsb["nome"]." ".$rowsb["cognome"].", ";
   }
$beneficiari=utf8_encode(mb_substr($beneficiari, 0, -2));   
$pdf->SetFont("helvetica","B",5.5);
$pdf->SetXY(150,$y+36.5);
$pdf->MultiCell(43,1.7,$beneficiari,0,'L');
}


$filenameinit="INIT".rand(5).time();

$pdf->Output("tmp/".$filenameinit.".pdf","F");

endif; //Fine Integration Mezzi di Sussistenza


if($id_prodotto=='02'): //Integration Spese Sanitarie


$pdf->AddFont('Roboto','','Roboto-Regular.php');
$pdf->AddFont('Roboto','B','Roboto-Bold.php');
$pdf->AddFont('Verdana','','Verdana.php');
$pdf->AddFont('Verdana','B','verdanab.php');
// set the source file
$pdf->setSourceFile('../uploads/modelli/files/'.$modello);
$pageCount = $pdf->setSourceFile('../uploads/modelli/files/'.$modello);

//Copia cliente


$pdf->AddPage();
$tplIdx2 = $pdf->importPage(2);
$pdf->useTemplate($tplIdx2);


$pdf->SetFont("Verdana","",7);
$pdf->SetTextColor(153,153,153);
$pdf->SetXY(160,2);
$pdf->RotatedText(205,265,'COPIA CLIENTE',270);

$pdf->SetTextColor(0,0,153);
$pdf->SetXY(0,55);   
$pdf->SetFont("Verdana","B",13);
$pdf->Cell(210,10,utf8_decode("CERTIFICATO INTEGRATION N. ".$rows["codice_attivazione"]),0,1,'C');
$filenameinit="INIT".rand(5).time();


$sql1="SELECT * FROM clienti WHERE id_cliente = '$rows[id_cliente]'";
$res1=mysql_query($sql1);
$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);

$nome=strtoupper(utf8_decode($rows1["nome"]));
$cognome=strtoupper(utf8_decode($rows1["cognome"]));
$luogo_nascita=strtoupper(utf8_decode($rows1["luogo_nascita"]));
$data_nascita=strtoupper(utf8_decode($rows1["data_nascita"]));

$sql2="SELECT comune FROM comuni_2017 WHERE cod_catastale = '$rows1[provenienza]'";
$res2=mysql_query($sql2);
$rows2=mysql_fetch_array($res2, MYSQL_ASSOC);
$provenienza=strtoupper(utf8_decode($rows2["comune"]));
$documento=strtoupper(utf8_decode($rows1["documento"]));
$data_documento=strtoupper(utf8_decode($rows1["data_documento"]));
$numero_documento=strtoupper(utf8_decode($rows1["numero_documento"]));



$pdf->SetXY(10,79);   
$pdf->SetFont("Verdana","B",11);
$pdf->Cell(210,10,utf8_decode($cognome." ".$nome),0,1,'L');
$pdf->SetXY(10,90);
$pdf->Cell(210,10,$provenienza,0,1,'L');
$pdf->SetXY(100.5,90);
$pdf->Cell(210,10,$luogo_nascita,0,1,'L');
$pdf->SetXY(165,90);
$pdf->Cell(210,10,$data_nascita,0,1,'L');
$pdf->SetXY(10,103);
$pdf->Cell(210,10,utf8_decode($documento),0,1,'L');
$pdf->SetXY(86,103);
$pdf->Cell(210,10,utf8_decode($numero_documento),0,1,'L');
$pdf->SetXY(138,103);
$pdf->Cell(210,10,utf8_decode($data_documento),0,1,'L');


$sql1="SELECT * FROM invitanti WHERE id_invitante = '$rows[id_invitante]'";
$res1=mysql_query($sql1);
$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);

$nome=utf8_decode($rows1["nome"]);
$cognome=utf8_decode($rows1["cognome"]);

$codicefiscale=utf8_decode($rows1["codicefiscale"]);

$indirizzo=utf8_decode($rows1["indirizzo"]);
$cap=utf8_decode($rows1["cap"]);

$sql2="SELECT comune,pr FROM comuni_2017 WHERE cod_catastale = '$rows1[citta]'";
$res2=mysql_query($sql2);
$rows2=mysql_fetch_array($res2, MYSQL_ASSOC);
$citta=utf8_decode($rows2["comune"]." (".$rows2["pr"].")");

$telefono=utf8_decode($rows1["telefono"]);
$email=utf8_decode($rows1["email"]);
$residenza=strtoupper($indirizzo. " ".$citta." ".$cap);
$pdf->SetXY(10,129);   
$pdf->SetFont("Verdana","B",11);
$pdf->Cell(210,10,strtoupper($cognome." ".$nome),0,1,'L');
$pdf->SetXY(125,129);   
$pdf->Cell(210,10,strtoupper($codicefiscale),0,1,'L');
$pdf->SetFont("Verdana","B",9);
$pdf->SetXY(10,141);   
$pdf->Cell(210,10,$residenza,0,1,'L');


$pdf->SetXY(35.5,162);
$pdf->Cell(210,10,utf8_decode($data_attivazione),0,1,'L');

$pdf->SetXY(107,163);
$pdf->SetFont("Verdana","B",6);
$pdf->MultiCell(95,2.5,utf8_decode($scadenza),0,'L',0);
$pdf->SetFont("Verdana","B",11);

$pdf->SetXY(10,227);
$pdf->Cell(65,10,EURO." ".$imponibile,0,1,'C');

$pdf->SetXY(75,227);
$pdf->Cell(62,10,EURO." ".$iva,0,1,'C');

$pdf->SetXY(138,227);
$pdf->Cell(63,10,EURO." ".$importo,0,1,'C');


$pdf->SetXY(130,246.5);
$pdf->SetFont("Verdana","",6);
$pdf->Cell(210,10,utf8_decode($data_attivazione),0,1,'L');

$pdf->AddPage();
$tplIdx3 = $pdf->importPage(3);
$pdf->useTemplate($tplIdx3);

$pdf->SetFont("Verdana","",7);
$pdf->SetTextColor(153,153,153);
$pdf->SetXY(160,2);
$pdf->RotatedText(205,265,'COPIA CLIENTE',270);


$pdf->SetFont("Verdana","",8);
$pdf->SetTextColor(0,0,153);
$pdf->SetXY(30,114.5);
$pdf->Cell(210,10,utf8_decode($luogo),0,1,'L');
$pdf->SetXY(30,151);
$pdf->Cell(210,10,utf8_decode($luogo),0,1,'L');
$pdf->SetXY(30,236);
$pdf->Cell(210,10,utf8_decode($luogo),0,1,'L');


$pdf->AddPage();
$tplIdx4 = $pdf->importPage(4);
$pdf->useTemplate($tplIdx4);

$pdf->SetFont("Verdana","",7);
$pdf->SetTextColor(153,153,153);
$pdf->SetXY(160,2);

$pdf->RotatedText(205,265,'COPIA CLIENTE',270);

$pdf->AddPage();
$tplIdx5 = $pdf->importPage(5);
$pdf->useTemplate($tplIdx5);

$pdf->SetFont("Verdana","",7);
$pdf->SetTextColor(153,153,153);
$pdf->SetXY(160,2);
$pdf->RotatedText(205,265,'COPIA CLIENTE',270);

$pdf->SetFont("Verdana","",8);
$pdf->SetTextColor(0,0,153);
$pdf->SetXY(35,99);
$pdf->Cell(210,10,utf8_decode($luogo),0,1,'L');
$pdf->SetXY(35,129);
$pdf->Cell(210,10,utf8_decode($luogo),0,1,'L');


//Fine copia cliente


//Copia beneficiario

$pdf->AddPage();
$tplIdx2 = $pdf->importPage(2);
$pdf->useTemplate($tplIdx2);

$pdf->SetFont("Verdana","",7);
$pdf->SetTextColor(153,153,153);
$pdf->SetXY(115,2);
$pdf->RotatedText(205,250,'COPIA BENEFICIARIO',270);


$pdf->SetTextColor(0,0,153);
$pdf->SetXY(0,55);   
$pdf->SetFont("Verdana","B",13);
$pdf->Cell(210,10,utf8_decode("CERTIFICATO INTEGRATION N. ".$rows["codice_attivazione"]),0,1,'C');
$filenameinit="INIT".rand(5).time();


$sql1="SELECT * FROM clienti WHERE id_cliente = '$rows[id_cliente]'";
$res1=mysql_query($sql1);
$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);

$nome=strtoupper(utf8_decode($rows1["nome"]));
$cognome=strtoupper(utf8_decode($rows1["cognome"]));
$luogo_nascita=strtoupper(utf8_decode($rows1["luogo_nascita"]));
$data_nascita=strtoupper(utf8_decode($rows1["data_nascita"]));

$sql2="SELECT comune FROM comuni_2017 WHERE cod_catastale = '$rows1[provenienza]'";
$res2=mysql_query($sql2);
$rows2=mysql_fetch_array($res2, MYSQL_ASSOC);
$provenienza=strtoupper(utf8_decode($rows2["comune"]));
$documento=strtoupper(utf8_decode($rows1["documento"]));
$data_documento=strtoupper(utf8_decode($rows1["data_documento"]));
$numero_documento=strtoupper(utf8_decode($rows1["numero_documento"]));



$pdf->SetXY(10,79);   
$pdf->SetFont("Verdana","B",11);
$pdf->Cell(210,10,utf8_decode($cognome." ".$nome),0,1,'L');
$pdf->SetXY(10,90);
$pdf->Cell(210,10,$provenienza,0,1,'L');
$pdf->SetXY(100.5,90);
$pdf->Cell(210,10,$luogo_nascita,0,1,'L');
$pdf->SetXY(165,90);
$pdf->Cell(210,10,$data_nascita,0,1,'L');
$pdf->SetXY(10,103);
$pdf->Cell(210,10,utf8_decode($documento),0,1,'L');
$pdf->SetXY(86,103);
$pdf->Cell(210,10,utf8_decode($numero_documento),0,1,'L');
$pdf->SetXY(138,103);
$pdf->Cell(210,10,utf8_decode($data_documento),0,1,'L');


$sql1="SELECT * FROM invitanti WHERE id_invitante = '$rows[id_invitante]'";
$res1=mysql_query($sql1);
$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);

$nome=utf8_decode($rows1["nome"]);
$cognome=utf8_decode($rows1["cognome"]);

$codicefiscale=utf8_decode($rows1["codicefiscale"]);

$indirizzo=utf8_decode($rows1["indirizzo"]);
$cap=utf8_decode($rows1["cap"]);

$sql2="SELECT comune,pr FROM comuni_2017 WHERE cod_catastale = '$rows1[citta]'";
$res2=mysql_query($sql2);
$rows2=mysql_fetch_array($res2, MYSQL_ASSOC);
$citta=utf8_decode($rows2["comune"]." (".$rows2["pr"].")");

$telefono=utf8_decode($rows1["telefono"]);
$email=utf8_decode($rows1["email"]);
$residenza=strtoupper($indirizzo. " ".$citta." ".$cap);
$pdf->SetXY(10,129);   
$pdf->SetFont("Verdana","B",11);
$pdf->Cell(210,10,strtoupper($cognome." ".$nome),0,1,'L');
$pdf->SetXY(125,129);   
$pdf->Cell(210,10,strtoupper($codicefiscale),0,1,'L');
$pdf->SetFont("Verdana","B",9);
$pdf->SetXY(10,141);   
$pdf->Cell(210,10,$residenza,0,1,'L');


$pdf->SetXY(35.5,162);
$pdf->Cell(210,10,utf8_decode($data_attivazione),0,1,'L');

$pdf->SetXY(107,163);
$pdf->SetFont("Verdana","B",6);
$pdf->MultiCell(95,2.5,utf8_decode($scadenza),0,'L',0);
$pdf->SetFont("Verdana","B",11);

$pdf->SetXY(10,227);
$pdf->Cell(65,10,EURO." ".$imponibile,0,1,'C');

$pdf->SetXY(75,227);
$pdf->Cell(62,10,EURO." ".$iva,0,1,'C');

$pdf->SetXY(138,227);
$pdf->Cell(63,10,EURO." ".$importo,0,1,'C');


$pdf->SetXY(130,246.5);
$pdf->SetFont("Verdana","",6);
$pdf->Cell(210,10,utf8_decode($data_attivazione),0,1,'L');

$pdf->AddPage();
$tplIdx3 = $pdf->importPage(3);
$pdf->useTemplate($tplIdx3);
$pdf->SetFont("Verdana","",7);
$pdf->SetTextColor(153,153,153);
$pdf->SetXY(115,2);
$pdf->RotatedText(205,250,'COPIA BENEFICIARIO',270);
$pdf->SetFont("Verdana","",8);
$pdf->SetTextColor(0,0,153);
$pdf->SetXY(30,114.5);
$pdf->Cell(210,10,utf8_decode($luogo),0,1,'L');
$pdf->SetXY(30,151);
$pdf->Cell(210,10,utf8_decode($luogo),0,1,'L');
$pdf->SetXY(30,236);
$pdf->Cell(210,10,utf8_decode($luogo),0,1,'L');



$pdf->AddPage();
$tplIdx4 = $pdf->importPage(4);
$pdf->useTemplate($tplIdx4);

$pdf->SetFont("Verdana","",7);
$pdf->SetTextColor(153,153,153);
$pdf->SetXY(115,2);
$pdf->RotatedText(205,250,'COPIA BENEFICIARIO',270);

$pdf->AddPage();
$tplIdx5 = $pdf->importPage(5);
$pdf->useTemplate($tplIdx5);

$pdf->SetFont("Verdana","",7);
$pdf->SetTextColor(153,153,153);
$pdf->SetXY(115,2);
$pdf->RotatedText(205,250,'COPIA BENEFICIARIO',270);
$pdf->SetFont("Verdana","",8);
$pdf->SetTextColor(0,0,153);
$pdf->SetXY(35,99);
$pdf->Cell(210,10,utf8_decode($luogo),0,1,'L');
$pdf->SetXY(35,129);
$pdf->Cell(210,10,utf8_decode($luogo),0,1,'L');

//Fine copia beneficiario



//Copia da restituire firmata

$pdf->AddPage();
$tplIdx2 = $pdf->importPage(2);
$pdf->useTemplate($tplIdx2);

$pdf->SetFont("Verdana","",7);
$pdf->SetTextColor(153,153,153);
$pdf->SetXY(115,2);
$pdf->RotatedText(205,250,'COPIA DA RESTITUIRE FIRMATA',270);


$pdf->SetTextColor(0,0,153);
$pdf->SetXY(0,55);   
$pdf->SetFont("Verdana","B",13);
$pdf->Cell(210,10,utf8_decode("CERTIFICATO INTEGRATION N. ".$rows["codice_attivazione"]),0,1,'C');
$filenameinit="INIT".rand(5).time();


$sql1="SELECT * FROM clienti WHERE id_cliente = '$rows[id_cliente]'";
$res1=mysql_query($sql1);
$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);

$nome=strtoupper(utf8_decode($rows1["nome"]));
$cognome=strtoupper(utf8_decode($rows1["cognome"]));
$luogo_nascita=strtoupper(utf8_decode($rows1["luogo_nascita"]));
$data_nascita=strtoupper(utf8_decode($rows1["data_nascita"]));

$sql2="SELECT comune FROM comuni_2017 WHERE cod_catastale = '$rows1[provenienza]'";
$res2=mysql_query($sql2);
$rows2=mysql_fetch_array($res2, MYSQL_ASSOC);
$provenienza=strtoupper(utf8_decode($rows2["comune"]));
$documento=strtoupper(utf8_decode($rows1["documento"]));
$data_documento=strtoupper(utf8_decode($rows1["data_documento"]));
$numero_documento=strtoupper(utf8_decode($rows1["numero_documento"]));



$pdf->SetXY(10,79);   
$pdf->SetFont("Verdana","B",11);
$pdf->Cell(210,10,utf8_decode($cognome." ".$nome),0,1,'L');
$pdf->SetXY(10,90);
$pdf->Cell(210,10,$provenienza,0,1,'L');
$pdf->SetXY(100.5,90);
$pdf->Cell(210,10,$luogo_nascita,0,1,'L');
$pdf->SetXY(165,90);
$pdf->Cell(210,10,$data_nascita,0,1,'L');
$pdf->SetXY(10,103);
$pdf->Cell(210,10,utf8_decode($documento),0,1,'L');
$pdf->SetXY(86,103);
$pdf->Cell(210,10,utf8_decode($numero_documento),0,1,'L');
$pdf->SetXY(138,103);
$pdf->Cell(210,10,utf8_decode($data_documento),0,1,'L');


$sql1="SELECT * FROM invitanti WHERE id_invitante = '$rows[id_invitante]'";
$res1=mysql_query($sql1);
$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);

$nome=utf8_decode($rows1["nome"]);
$cognome=utf8_decode($rows1["cognome"]);

$codicefiscale=utf8_decode($rows1["codicefiscale"]);

$indirizzo=utf8_decode($rows1["indirizzo"]);
$cap=utf8_decode($rows1["cap"]);

$sql2="SELECT comune,pr FROM comuni_2017 WHERE cod_catastale = '$rows1[citta]'";
$res2=mysql_query($sql2);
$rows2=mysql_fetch_array($res2, MYSQL_ASSOC);
$citta=utf8_decode($rows2["comune"]." (".$rows2["pr"].")");

$telefono=utf8_decode($rows1["telefono"]);
$email=utf8_decode($rows1["email"]);
$residenza=strtoupper($indirizzo. " ".$citta." ".$cap);
$pdf->SetXY(10,129);   
$pdf->SetFont("Verdana","B",11);
$pdf->Cell(210,10,strtoupper($cognome." ".$nome),0,1,'L');
$pdf->SetXY(125,129);   
$pdf->Cell(210,10,strtoupper($codicefiscale),0,1,'L');
$pdf->SetFont("Verdana","B",9);
$pdf->SetXY(10,141);   
$pdf->Cell(210,10,$residenza,0,1,'L');


$pdf->SetXY(35.5,162);
$pdf->Cell(210,10,utf8_decode($data_attivazione),0,1,'L');

$pdf->SetXY(107,163);
$pdf->SetFont("Verdana","B",6);
$pdf->MultiCell(95,2.5,utf8_decode($scadenza),0,'L',0);
$pdf->SetFont("Verdana","B",11);

$pdf->SetXY(10,227);
$pdf->Cell(65,10,EURO." ".$imponibile,0,1,'C');

$pdf->SetXY(75,227);
$pdf->Cell(62,10,EURO." ".$iva,0,1,'C');

$pdf->SetXY(138,227);
$pdf->Cell(63,10,EURO." ".$importo,0,1,'C');


$pdf->SetXY(130,246.5);
$pdf->SetFont("Verdana","",6);
$pdf->Cell(210,10,utf8_decode($data_attivazione),0,1,'L');

$pdf->AddPage();
$tplIdx3 = $pdf->importPage(3);
$pdf->useTemplate($tplIdx3);
$pdf->SetFont("Verdana","",7);
$pdf->SetTextColor(153,153,153);
$pdf->SetXY(115,2);
$pdf->RotatedText(205,250,'COPIA DA RESTITUIRE FIRMATA',270);
$pdf->SetFont("Verdana","",8);
$pdf->SetTextColor(0,0,153);
$pdf->SetXY(30,114.5);
$pdf->Cell(210,10,utf8_decode($luogo),0,1,'L');
$pdf->SetXY(30,151);
$pdf->Cell(210,10,utf8_decode($luogo),0,1,'L');
$pdf->SetXY(30,236);
$pdf->Cell(210,10,utf8_decode($luogo),0,1,'L');



$pdf->AddPage();
$tplIdx4 = $pdf->importPage(4);
$pdf->useTemplate($tplIdx4);

$pdf->SetFont("Verdana","",7);
$pdf->SetTextColor(153,153,153);
$pdf->SetXY(115,2);
$pdf->RotatedText(205,250,'COPIA DA RESTITUIRE FIRMATA',270);

$pdf->AddPage();
$tplIdx5 = $pdf->importPage(5);
$pdf->useTemplate($tplIdx5);

$pdf->SetFont("Verdana","",7);
$pdf->SetTextColor(153,153,153);
$pdf->SetXY(115,2);
$pdf->RotatedText(205,250,'COPIA DA RESTITUIRE FIRMATA',270);
$pdf->SetFont("Verdana","",8);
$pdf->SetTextColor(0,0,153);
$pdf->SetXY(35,99);
$pdf->Cell(210,10,utf8_decode($luogo),0,1,'L');
$pdf->SetXY(35,129);
$pdf->Cell(210,10,utf8_decode($luogo),0,1,'L');

//Fine copia da restituire firmata

// Pdf Card
$pdf->AddPage();
$tplIdx = $pdf->importPage(1);
$pdf->useTemplate($tplIdx);
$pdf->SetTextColor(1,70,148);


$pdf->SetTitle($prodotto);

$pdf->SetXY(0,78);   
$pdf->SetFont("Roboto","B",23);
$pdf->Cell(210,10,utf8_decode($rows["nome"]." ".$rows["cognome"]),0,1,'C');

$pdf->SetFont("Roboto","B",11);

$pdf->SetXY(0,212);
//Dati prodotto

$pdf->Cell(210,10,utf8_decode("Card ".$prodotto." n. ".$codice_attivazione),0,1,'C');  
$y=212;
$y=$y+8;
$pdf->SetXY(0,$y);
$pdf->SetFont("Roboto","B",8);
//$pdf->Cell(210,10,utf8_decode("valida per ".$copertura." giorni dalla data di ingresso in Italia "),0,1,'C');
$pdf->SetXY(0,$y);
$pdf->SetFont("Roboto","",8);
$pdf->Cell(210,10,utf8_decode("titolare"),0,1,'C');
$y=$y+5;
$pdf->SetXY(0,$y);
$pdf->SetFont("Roboto","B",11);
$pdf->Cell(210,10,utf8_decode($rows["cognome"]." ".$rows["nome"]),0,1,'C');

$pdf->Output("tmp/".$filenameinit.".pdf","F");

endif; //Fine Integration Mezzi di Sussistenza



require('PDFMerger.php');


$pdff = new PDFMerger;

$pdff->addPDF('tmp/'.$filenameinit.".pdf", 'all');
foreach($files as $file){
  $pdff->addPDF('tmp/'.$file, 'all');
}

//$pdff->addPDF('tmp/Bugiardino.pdf', 'all');
$pdff->merge('browser', $_GET["codice_attivazione"].'.pdf');
?>