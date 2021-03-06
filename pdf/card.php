<?php include("../includes/parameters.php");?>
<?php include("../includes/functions.php");?>
<?php include("../includes/mysql.inc.php");
//require("../libraries/tcpdf/tcpdf.php"); // Librerie generazione PDF
//require("../libraries/tcpdf/fpdi.php"); // Librerie importazione PDF

require('fpdf.php');
require('fpdi.php');

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


$_SESSION["codice_attivazione"]=$_GET["codice_attivazione"];

$id_pratica=$rows["id_pratica"];

$_GET["id_convenzione_prodotto"]=$rows["id_prodotto_convenzione"];

$res=mysql_query($sql);
$rows=mysql_fetch_array($res, MYSQL_ASSOC);


$sqlp="SELECT *, prodotti_categorie.categoria AS categoria FROM prodotti LEFT JOIN prodotti_categorie ON prodotti_categorie.id_categoria = prodotti.categoria WHERE id_prodotto = '$rows[id_prodotto]'";
$resp=mysql_query($sqlp);
$rowsp=mysql_fetch_array($resp, MYSQL_ASSOC);

$prodotto=utf8_encode(stripslashes($rowsp["prodotto"]." ".$rowsp["categoria"]));
$codice_attivazione=$_GET["codice_attivazione"];
$data_attivazione=date("d/m/y", strtotime($rows["data_attivazione"]));
$data_scadenza=date("d/m/y", strtotime($rows["data_scadenza"]));


//Modello
$sql1="SELECT * FROM prodotti_convenzione_meta WHERE id_prodotto_convenzione='$_GET[id_convenzione_prodotto]' AND chiave = 'Card'";
$res1=mysql_query($sql1);
$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
$modello=$rows1["valore"];

//Nome reale card

$sql1="SELECT * FROM prodotti_convenzione_meta WHERE id_prodotto_convenzione='$_GET[id_convenzione_prodotto]' AND chiave = 'Nome reale card'";
$res1=mysql_query($sql1);
$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
if($num1=mysql_num_rows($res1>0)){
  $prodotto=$rows1["valore"];
}
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

$sql1="SELECT * FROM prodotti_convenzione_meta WHERE id_prodotto_convenzione='$_GET[id_convenzione_prodotto]' AND chiave = 'Colore'";
$res1=mysql_query($sql1);
$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
  $colore=$rows1["valore"];
  $colore=hex2rgb($colore);


  //Template pdf

$sql1="SELECT * FROM prodotti_convenzione_meta WHERE id_prodotto_convenzione='$_GET[id_convenzione_prodotto]' AND chiave = 'TemplatePDF'";
$res1=mysql_query($sql1);
$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
$template=$rows1["valore"];
 


$dettaglio_prodotto = <<<EOD
<span style="color:#$colore;">$prodotto</span>
EOD;

$y=0;

// initiate FPDI
$pdf = new FPDI('L','mm', array(55,90));


//$pdf->setPrintHeader(false);
//$pdf->SetPrintFooter(false);
// add a page
$pdf->AddPage();
$pdf->AddFont('gothaml','','gothamlight.php');
$pdf->AddFont('gothamb','','gothambold.php');
// set the source file
$pdf->setSourceFile('../uploads/card/files/'.$modello);
$pageCount = $pdf->setSourceFile('../uploads/card/files/'.$modello);
// import page 1
$tplIdx = $pdf->importPage(1);
$pdf->useTemplate($tplIdx);
$pdf->SetTextColor(0,119,149);


$pdf->SetTitle($prodotto);

if($template=="Marchex"): //Render pdf per le marchex

$y=0;
$pdf->SetFont("gothamb","",8);
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(3,$y);
$pdf->Cell(10,10,$prodotto." n. ".$codice_attivazione,0,'L');

$y=$y+4.5;
$pdf->SetFont("gothaml","",8);
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(3,$y);
$pdf->Cell(10,10,utf8_decode("validità"),0,'L');

$pdf->SetFont("gothamb","",8);
$pdf->SetXY(14.5,$y);
$pdf->Cell(10,10,$data_attivazione." - ".$data_scadenza,0,'L');

$pdf->SetTextColor(255,255,255);
$pdf->SetFont("gothamb","",10);
$y=$y+8.5;
$pdf->SetXY(3,$y);
$pdf->Cell(90,10,utf8_decode($rows["nome"]." ".$rows["cognome"]),0,1,'L');

$pdf->SetTextColor(255,255,255);
$pdf->SetFont("gothaml","",8);
$y=$y+3.5;
$pdf->SetXY(3,$y);
$pdf->Cell(86,10,utf8_decode("c.f. ".$rows["codicefiscale"]),0,1,'R');

else:

$y=10;
//Dati prodotto

$pdf->SetXY(150,$y);
if(strlen($prodotto)>18){
$pdf->MultiCell(40,4.5,utf8_decode($prodotto),0,'L');
$y=$y+3;
}else{
$pdf->Cell(210,10,utf8_decode($prodotto),0,1,'L');  
}
$pdf->SetXY(150,$y+6);
$pdf->SetFont("helvetica","B",10);
$pdf->Cell(210,10,utf8_decode("n. ".$codice_attivazione),0,1,'L');

//validita
$pdf->SetFont("helvetica","",8);
//Secondo colore per CherryBox
if($_GET["id_convenzione_prodotto"]=="00041"){
   $pdf->SetTextColor(135,135,135);
}
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


endif;

$filenameinit="INIT".rand(5).time();

$pdf->Output("tmp/".$filenameinit.".pdf","I");
?>